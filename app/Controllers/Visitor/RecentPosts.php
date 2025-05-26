<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;

class RecentPosts extends BaseController {
    protected $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    public function index() {
        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get most viewed posts
            $mostViewedPosts = $this->postModel->published()->viewed(true)->posts(7);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'label' => 'Most Viewed Articles',
            ];
        }

        // Get latest posts with pagination
        $recentPosts = $this->postModel->exclude($excludedIds)->published()->paginate(18);
        $posts["latest"] = [
            'posts' => $recentPosts,
            'layout' => 'StandardGrid',
        ];

        $data = [
            'title' => 'Recent Posts',
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/recentPosts', $data);
    }
}
