<?php

namespace App\Services;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\AdModel;
use App\Models\AdSlotModel;
use App\Models\PostViewModel;

class AdminDashboardService {
    protected $postModel;
    protected $categoryModel;
    protected $userModel;
    protected $adModel;
    protected $adSlotModel;
    protected $postViewModel;
    protected $userId;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->adModel = new AdModel();
        $this->adSlotModel = new AdSlotModel();
        $this->postViewModel = new PostViewModel();
        $this->userId = session()->get('user_id');
    }

    /*
     * Get dashboard data
     * @return array
     */
    public function getDashboardData(): array {
        return array_merge(
            [
                'title' => 'Dashboard',
            ],
            $this->getPostStats(),
            $this->getUserStats(),
            $this->getAdStats(),
            [
                'dailyPostsViewCount' => $this->getDailyPostsViewCount(30),
                'dailyPostsPublishedCount' => $this->getDailyPostsPublishedCount(30),
                'categoryPostsCount' => $this->getCategoryPostsCount(),
                'categoryPostsViewCount' => $this->getCategoryPostsViewCount(30),
                'recentPosts' => $this->getRecentPosts(),
                'recentUsers' => $this->getRecentUsers(),
                'recentAds' => $this->getRecentAds(),
                'recentSlots' => $this->getRecentSlots(),
                'popularPosts' => $this->getPopularPosts(),
                'categories' => $this->getCategoryStats(),
                'trendingTags' => $this->getTrendingTags(),
                'viewsData' => $this->getViewsData(),
            ]
        );
    }

    /*
     * Get post stats
     * @return array
     */
    protected function getPostStats(): array {
        return [
            'totalPosts' => $this->postModel->countAll(),
            'publishedPosts' => $this->postModel->where('status', 'published')->countAllResults(),
            'totalViews' => $this->postModel->selectSum('views')->first()['views'] ?? 0
        ];
    }

    /*
     * Get user stats
     * @return array
     */
    protected function getUserStats(): array {
        return [
            'totalMembers' => $this->userModel->countAll(),
            'totalAdmins' => $this->userModel->where('role', 'admin')->countAllResults(),
            'totalManagers' => $this->userModel->where('role', 'manager')->countAllResults(),
            'totalEditors' => $this->userModel->where('role', 'editor')->countAllResults(),
            'totalUsers' => $this->userModel->where('role', 'user')->countAllResults()
        ];
    }

    /*
     * Get ad stats
     * @return array
     */
    protected function getAdStats(): array {
        // Get all ad slots
        $adSlots = $this->adSlotModel->findAll();

        // Get filled slot IDs
        $filledSlotIds = $this->adModel->select('slot_id')
            ->groupBy('slot_id')
            ->findColumn('slot_id') ?? [];

        // Count filled and empty slots
        $filledSlots = count($filledSlotIds);
        $emptySlots = count($adSlots) - $filledSlots;

        return [
            'totalAds' => $this->adModel->countAll(),
            'activeAds' => $this->adModel->where('is_active', 1)->countAllResults(),
            'adSlots' => $adSlots,
            'totalSlots' => count($adSlots),
            'filledSlots' => $filledSlots,
            'emptySlots' => $emptySlots
        ];
    }

    /*
     * Get recent posts
     * @return array
     */
    protected function getRecentPosts(): array {
        return $this->postModel->published()->posts(5);
    }

    /*
     * Get recent users
     * @return array
     */
    protected function getRecentUsers(): array {
        return $this->userModel->orderBy('created_at', 'DESC')->limit(5)->find();
    }

    /*
     * Get recent ads
     * @return array
     */
    protected function getRecentAds(): array {
        return $this->adModel->select('ads.*, ad_slots.name as slot_name, categories.name as category_name, users.name as user_name')
            ->join('ad_slots', 'ad_slots.id = ads.slot_id')
            ->join('categories', 'categories.id = ads.category_id')
            ->join('users', 'users.id = ads.user_id')
            ->orderBy('ads.created_at', 'DESC')
            ->limit(5)
            ->find();
    }

    /*
     * Get recent slots
     * @return array
     */
    protected function getRecentSlots(): array {
        return $this->adSlotModel->select('ad_slots.*, COUNT(ads.id) as running_ads')
            ->join('ads', 'ads.slot_id = ad_slots.id AND ads.is_active = 1', 'left')
            ->groupBy('ad_slots.id')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->find();
    }

    /*
     * Get popular posts
     * @return array
     */
    protected function getPopularPosts(): array {
        return $this->postModel->published()->orderBy('views', 'DESC')->limit(5)->find();
    }

    /*
     * Get category stats
     * @return array
     */
    protected function getCategoryStats(): array {
        $categories = $this->categoryModel->findAll();
        $totalPosts = $this->postModel->countAll();

        $categoryPosts = $this->postModel->select('category_id, COUNT(*) as posts_count')
            ->groupBy('category_id')
            ->findAll();

        $categoryPostCounts = array_column($categoryPosts, 'posts_count', 'category_id');

        return array_map(function ($category) use ($totalPosts, $categoryPostCounts) {
            $postsCount = $categoryPostCounts[$category['id']] ?? 0;
            return [
                'id' => $category['id'],
                'name' => $category['name'],
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
        return $this->postModel->db->table('post_tags')
            ->select('tags.name, tags.slug, COUNT(*) as count')
            ->join('tags', 'tags.id = post_tags.tag_id')
            ->groupBy('post_tags.tag_id')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    /*
     * Get views data
     * @return array
     */
    protected function getViewsData(): array {
        $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
        $viewsData = $this->postModel->select('DATE(published_at) as date, SUM(views) as total_views')
            ->where('published_at >=', $thirtyDaysAgo)
            ->groupBy('DATE(published_at)')
            ->orderBy('date', 'ASC')
            ->find();

        return [
            'dates' => array_column($viewsData, 'date'),
            'values' => array_column($viewsData, 'total_views')
        ];
    }

    /*
     * Get content distribution
     * @return array
     */
    protected function getContentDistribution(): array {
        $distribution = [
            [
                'name' => 'Published',
                'value' => $this->postModel->where('status', 'published')->countAllResults()
            ],
            [
                'name' => 'Draft',
                'value' => $this->postModel->where('status', 'draft')->countAllResults()
            ],
            [
                'name' => 'Scheduled',
                'value' => $this->postModel->where('status', 'scheduled')->countAllResults()
            ]
        ];

        // Add category distribution
        foreach ($this->getCategoryStats() as $category) {
            $distribution[] = [
                'name' => $category['name'],
                'value' => $category['posts_count']
            ];
        }

        return $distribution;
    }

    /*
        Get daily posts view count
        @param int $days
        @return array
    */
    protected function getDailyPostsViewCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily view counts
        $dailyViews = $this->postViewModel->select('DATE(created_at) as date, COUNT(*) as views')
            ->where('created_at >=', $startDate . ' 00:00:00')
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->where('view_duration', 0)  // Only count initial view tracks
            ->groupBy('DATE(created_at)')
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
        Get daily posts published count
        @param int $days
        @return array
    */
    protected function getDailyPostsPublishedCount(int $days = 30): array {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Get daily published post counts
        $dailyPosts = $this->postModel->select('DATE(published_at) as date, COUNT(*) as posts')
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
        Get category posts count
        @return array
    */
    protected function getCategoryPostsCount(): array {
        $categories = $this->postModel->select('categories.name, COUNT(posts.id) as count')
            ->join('categories', 'categories.id = posts.category_id')
            ->where('posts.status', 'published')
            ->groupBy('posts.category_id')
            ->orderBy('count', 'DESC')
            ->findAll();

        return array_column($categories, 'count', 'name');
    }

    /*
        Get category posts view count
        @param int $days
        @return array
    */
    protected function getCategoryPostsViewCount(int $days = 30): array {
        // 1. Get post IDs and their view counts from post_views table
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $postViews = $this->postViewModel->select('post_id, COUNT(*) as view_count')
            ->where('created_at >', $startDate)
            ->where('view_duration', 0)  // Only count initial view tracks
            ->groupBy('post_id')
            ->findAll();

        if (empty($postViews)) {
            return [];
        }

        // Create lookup array for post views
        $postViewCounts = array_column($postViews, 'view_count', 'post_id');

        // 2. Get posts with their categories
        $posts = $this->postModel->select('posts.id, categories.name')
            ->join('categories', 'categories.id = posts.category_id')
            ->whereIn('posts.id', array_keys($postViewCounts))
            ->findAll();

        // 3. Aggregate views by category
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
