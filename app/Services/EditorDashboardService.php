<?php

namespace App\Services;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\PostViewModel;
use App\Models\TagModel;
use App\Models\PostTagModel;

class EditorDashboardService {
    protected $postModel;
    protected $categoryModel;
    protected $postViewModel;
    protected $tagModel;
    protected $postTagModel;
    protected $userId;

    public function __construct(int $userId) {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->postViewModel = new PostViewModel();
        $this->tagModel = new TagModel();
        $this->postTagModel = new PostTagModel();
        $this->userId = $userId;
    }

    public function getDashboardData(): array {
        return array_merge(
            [
                'title' => 'Dashboard',
            ],
            $this->getPostStats(),
            [
                'dailyPostsViewCount' => $this->getDailyPostsViewCount(30),
                'dailyPostsPublishedCount' => $this->getDailyPostsPublishedCount(30),
                'categoryPostsCount' => $this->getCategoryPostsCount(),
                'categoryPostsViewCount' => $this->getCategoryPostsViewCount(30),
                'recentPosts' => $this->getRecentPosts(),
                'popularPosts' => $this->getPopularPosts(),
                'categories' => $this->getCategoryStats(),
                'trendingTags' => $this->getTrendingTags(),
            ]
        );
    }

    /*
     * Get post stats
     * @return array
     */
    protected function getPostStats(): array {
        return [
            'totalPosts' => $this->postModel->where('user_id', $this->userId)->countAllResults(),
            'publishedPosts' => $this->postModel->where('user_id', $this->userId)->where('status', 'published')->countAllResults(),
            'totalViews' => $this->postModel->selectSum('views')->where('user_id', $this->userId)->first()['views'] ?? 0
        ];
    }

    /*
     * Get recent posts
     * @return array
     */
    protected function getRecentPosts(): array {
        return $this->postModel->authorPosts($this->userId)->posts(5);
    }

    /*
     * Get popular posts
     * @return array
     */
    protected function getPopularPosts(): array {
        return $this->postModel->authorPosts($this->userId)->orderBy('views', 'DESC')->posts(5);
    }

    /*
     * Get category stats
     * @return array
     */
    protected function getCategoryStats(): array {
        $categories = $this->categoryModel->findAll();
        $totalPosts = $this->postModel->authorPosts($this->userId)->countAllResults();

        $categoryPosts = $this->postModel->authorPosts($this->userId)->select('category_id, COUNT(*) as posts_count')->groupBy('category_id')->findAll();

        $categoryPostCounts = array_column($categoryPosts, 'posts_count', 'category_id');

        return array_map(function ($category) use ($totalPosts, $categoryPostCounts) {
            $postsCount = $categoryPostCounts[$category['id']] ?? 0;
            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug'],
                'posts_count' => $postsCount,
                'percentage' => $totalPosts > 0 ? ($postsCount / $totalPosts) * 100 : 0
            ];
        }, $categories);
    }

    /*
     * Get trending tags
     * @return array
     */
    protected function getTrendingTags(): array {
        // Get all posts ids
        $posts = $this->postModel->authorPosts($this->userId)->find();
        $postIds = array_column($posts, 'id');

        if (empty($postIds)) {
            return [];
        }

        // First get grouped post tags
        $postTags = $this->postTagModel
            ->select('tag_id, COUNT(*) as count')
            ->whereIn('post_id', $postIds)
            ->groupBy('tag_id')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->find();

        if (empty($postTags)) {
            return [];
        }

        // Then get tag details
        $tagIds = array_column($postTags, 'tag_id');

        $tags = $this->tagModel->select('id, name, slug')->whereIn('id', $tagIds)->find();

        // Combine the results
        $tagMap = array_column($tags, null, 'id');
        $result = [];
        foreach ($postTags as $postTag) {
            if (isset($tagMap[$postTag['tag_id']])) {
                $tag = $tagMap[$postTag['tag_id']];
                $result[] = [
                    'name' => $tag['name'],
                    'slug' => $tag['slug'],
                    'count' => $postTag['count']
                ];
            }
        }

        return $result;
    }

    /*
     * Get daily posts view count
     * @param int $days
     * @return array
     */
    protected function getDailyPostsViewCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily view counts for editor's posts
        $dailyViews = $this->postViewModel->select('DATE(post_views.created_at) as date, COUNT(*) as views')
            ->join('posts', 'posts.id = post_views.post_id')
            ->where('posts.user_id', $this->userId)
            ->where('post_views.view_duration', 0) // Only count initial view tracks
            ->where('post_views.created_at >=', $startDate . ' 00:00:00')
            ->where('post_views.created_at <=', $endDate . ' 23:59:59')
            ->groupBy('DATE(post_views.created_at)')
            ->orderBy('date', 'ASC')
            ->findAll();

        // Create lookup array for existing dates
        $viewsByDate = array_column($dailyViews, 'views', 'date');

        // Generate array with all dates and fill in missing ones with 0
        $result = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $result[] = [
                'date' => $currentDate,
                'views' => $viewsByDate[$currentDate] ?? 0
            ];
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return $result;
    }

    /*
     * Get daily posts published count
     * @param int $days
     * @return array
     */
    protected function getDailyPostsPublishedCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily published post counts for editor
        $dailyPosts = $this->postModel->select('DATE(published_at) as date, COUNT(*) as posts')
            ->where('user_id', $this->userId)
            ->where('status', 'published')
            ->where('published_at >=', $startDate . ' 00:00:00')
            ->where('published_at <=', $endDate . ' 23:59:59')
            ->groupBy('DATE(published_at)')
            ->orderBy('date', 'ASC')
            ->findAll();

        // Create lookup array for existing dates
        $postsByDate = array_column($dailyPosts, 'posts', 'date');

        // Generate array with all dates and fill in missing ones with 0
        $result = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $result[] = [
                'date' => $currentDate,
                'posts' => $postsByDate[$currentDate] ?? 0
            ];
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return $result;
    }

    /*
     * Get category posts count
     * @return array
     */
    protected function getCategoryPostsCount(): array {
        $categories = $this->postModel->select('categories.name, COUNT(posts.id) as count')
            ->join('categories', 'categories.id = posts.category_id')
            ->where('posts.user_id', $this->userId)
            ->where('posts.status', 'published')
            ->groupBy('posts.category_id')
            ->orderBy('count', 'DESC')
            ->findAll();

        return array_column($categories, 'count', 'name');
    }

    /*
     * Get category posts view count
     * @param int $days
     * @return array
     */
    protected function getCategoryPostsViewCount(int $days = 30): array {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        // Get post IDs and their view counts for editor's posts
        $postViews = $this->postViewModel->select('post_id, COUNT(*) as view_count')
            ->join('posts', 'posts.id = post_views.post_id')
            ->where('posts.user_id', $this->userId)
            ->where('post_views.created_at >', $startDate)
            ->where('view_duration', 0)
            ->groupBy('post_id')
            ->findAll();

        if (empty($postViews)) {
            return [];
        }

        // Create lookup array for post views
        $postViewCounts = array_column($postViews, 'view_count', 'post_id');

        // Get posts with their categories
        $posts = $this->postModel->select('posts.id, categories.name')
            ->join('categories', 'categories.id = posts.category_id')
            ->whereIn('posts.id', array_keys($postViewCounts))
            ->findAll();

        // Aggregate views by category
        $categoryViews = [];
        foreach ($posts as $post) {
            $categoryName = $post['name'];
            $viewCount = $postViewCounts[$post['id']] ?? 0;

            if (!isset($categoryViews[$categoryName])) {
                $categoryViews[$categoryName] = 0;
            }
            $categoryViews[$categoryName] += $viewCount;
        }

        // Sort by view count in descending order
        arsort($categoryViews);

        return $categoryViews;
    }
}
