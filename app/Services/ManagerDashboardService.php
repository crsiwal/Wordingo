<?php

namespace App\Services;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\PostViewModel;

class ManagerDashboardService {
    protected $postModel;
    protected $categoryModel;
    protected $userModel;
    protected $postViewModel;
    protected $userId;
    protected $teamMembers;
    protected $teamIds;

    public function __construct(int $userId) {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->postViewModel = new PostViewModel();
        $this->userId = $userId;
    }

    public function getDashboardData(): array {
        $this->teamMembers = $this->userModel->where('parent_id', $this->userId)->findColumn('id') ?? [];
        $this->teamIds = array_merge([$this->userId], $this->teamMembers);

        return array_merge(
            [
                'title' => 'Dashboard',
            ],
            $this->getPostStats(),
            $this->getTeamStats(),
            [
                'dailyPostsViewCount' => $this->getDailyPostsViewCount(30),
                'dailyPostsPublishedCount' => $this->getDailyPostsPublishedCount(30),
                'categoryPostsCount' => $this->getCategoryPostsCount(),
                'categoryPostsViewCount' => $this->getCategoryPostsViewCount(30),
                'recentPosts' => $this->getRecentPosts(),
                'popularPosts' => $this->getPopularPosts(),
                'categories' => $this->getCategoryStats(),
                'trendingTags' => $this->getTrendingTags(),
                'teamMembers' => $this->getTeamMembers(),
            ]
        );
    }

    protected function getPostStats(): array {
        return [
            'totalPosts' => $this->postModel->whereIn('user_id', $this->teamIds)->countAllResults(),
            'publishedPosts' => $this->postModel->whereIn('user_id', $this->teamIds)
                ->where('status', 'published')
                ->countAllResults(),
            'totalViews' => $this->postModel->selectSum('views')
                ->whereIn('user_id', $this->teamIds)
                ->first()['views'] ?? 0
        ];
    }

    protected function getTeamStats(): array {
        return [
            'teamMembersCount' => count($this->teamMembers),
            'activeEditors' => $this->userModel->whereIn('id', $this->teamMembers)
                ->where('status', 'active')
                ->countAllResults(),
            'totalCategories' => $this->categoryModel->countAll()
        ];
    }

    protected function getRecentPosts(): array {
        return $this->postModel->whereIn('user_id', $this->teamIds)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->find();
    }

    protected function getPopularPosts(): array {
        return $this->postModel->whereIn('user_id', $this->teamIds)
            ->where('status', 'published')
            ->orderBy('views', 'DESC')
            ->limit(5)
            ->find();
    }

    protected function getCategoryStats(): array {
        $categories = $this->categoryModel->findAll();
        $totalPosts = $this->postModel->whereIn('user_id', $this->teamIds)->countAllResults();

        $categoryPosts = $this->postModel->select('category_id, COUNT(*) as posts_count')
            ->whereIn('user_id', $this->teamIds)
            ->groupBy('category_id')
            ->findAll();

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

    protected function getTrendingTags(): array {
        // Get all posts ids
        $posts = $this->postModel->whereIn('user_id', $this->teamIds)->find();
        $postIds = array_column($posts, 'id');

        if (empty($postIds)) {
            return [];
        }

        // Get post tags with counts
        $postTags = $this->postModel->db->table('post_tags')
            ->select('tags.name, tags.slug, COUNT(*) as count')
            ->join('tags', 'tags.id = post_tags.tag_id')
            ->whereIn('post_tags.post_id', $postIds)
            ->groupBy('post_tags.tag_id')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return $postTags;
    }

    protected function getDailyPostsViewCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily view counts for team posts
        $dailyViews = $this->postViewModel->select('DATE(post_views.created_at) as date, COUNT(*) as views')
            ->join('posts', 'posts.id = post_views.post_id')
            ->whereIn('posts.user_id', $this->teamIds)
            ->where('post_views.view_duration', 0)  // Only count initial view tracks
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

    protected function getDailyPostsPublishedCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily published post counts for team
        $dailyPosts = $this->postModel->select('DATE(published_at) as date, COUNT(*) as posts')
            ->whereIn('user_id', $this->teamIds)
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

    protected function getCategoryPostsCount(): array {
        $categories = $this->postModel->select('categories.name, COUNT(posts.id) as count')
            ->join('categories', 'categories.id = posts.category_id')
            ->whereIn('posts.user_id', $this->teamIds)
            ->where('posts.status', 'published')
            ->groupBy('posts.category_id')
            ->orderBy('count', 'DESC')
            ->findAll();

        return array_column($categories, 'count', 'name');
    }

    protected function getCategoryPostsViewCount(int $days = 30): array {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        // Get post IDs and their view counts for team posts
        $postViews = $this->postViewModel->select('post_id, COUNT(*) as view_count')
            ->join('posts', 'posts.id = post_views.post_id')
            ->whereIn('posts.user_id', $this->teamIds)
            ->where('post_views.created_at >', $startDate)
            ->where('post_views.view_duration', 0)  // Only count initial view tracks
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

    protected function getTeamMembers(): array {
        if (empty($this->teamMembers)) {
            return [];
        }

        return $this->userModel->select('users.*, COUNT(posts.id) as total_posts, SUM(posts.views) as total_views')
            ->join('posts', 'posts.user_id = users.id', 'left')
            ->whereIn('users.id', $this->teamMembers)
            ->groupBy('users.id')
            ->find();
    }
}
