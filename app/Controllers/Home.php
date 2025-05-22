<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController {
    protected $postModel;
    protected $categoryModel;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categoryPostsData = [
            'before_category_tabs' => [
                'title' => 'Top stories',
                'layout' => 'TwoColumnGrid',
                'posts' => $this->postModel->featured()->posts(8),
            ],
            'after_category_tabs' => [
                'title' => 'Latest Posts',
                'layout' => 'CarouselCompact',
                'posts' => $this->postModel->published()->paginate(18),
            ],
            'before_featured_carousel' => [
                'title' => 'Featured Posts',
                'layout' => 'CarouselGrid',
                'posts' => $this->postModel->featured()->posts(8),
            ],
        ];

        $data = [
            'title' => 'Home',
            'featuredPosts' => $this->postModel->featured()->posts(8),
            'latestPosts' => $this->postModel->featured()->posts(8),
            'categories' => $this->categoryModel->withPostCount()->findAll(),
            'categoryPostsData' => $categoryPostsData,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/index', $data);
    }

    /* Recent Posts */
    public function recentPosts() {
        // Get latest posts with pagination with 18 posts per page with 'recent' segment
        $recentPosts = $this->postModel->published()->paginate(18);

        $posts = [
            "latest" => [
                'posts' => $recentPosts,
                'layout' => 'StandardGrid',
            ],
        ];

        $data = [
            'title' => 'Recent Posts',
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/recentPosts', $data);
    }


    public function search() {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/');
        }

        $searchedPosts = $this->postModel->published()
            ->like('posts.title', $query)
            ->orLike('posts.content', $query)
            ->posts(9);

        $data = [
            'title' => "Search: {$query}",
            'query' => $query,
            'posts' => [
                "search" => [
                    'posts' => $searchedPosts,
                    'layout' => 'LeftToRightGrid',
                    'title' => 'Search Results: ' . $query,
                ]
            ],
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/search', $data);
    }

    public function category($slug) {
        $category = $this->categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get top posts
        $mostViewedPosts = $this->postModel->categoryPosts($slug)->viewed(true)->posts(1);
        $excludedIds = array_column($mostViewedPosts, 'id');

        // Get latest posts
        $latestPosts = $this->postModel->categoryPosts($slug)->exclude($excludedIds)->posts(10);

        $posts = [
            "mostViewed" => [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'title' => 'Top stories',
            ],
            "latest" => [
                'posts' => $latestPosts,
                'layout' => 'StandardGrid',
                'title' => 'Recently Posted',
            ],
        ];

        $data = [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/category', $data);
    }

    public function post($slug) {
        $post = $this->postModel->published()
            ->where('posts.slug', $slug)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment view count
        $this->postModel->incrementViews($post['id']);

        // Get related posts
        $relatedPosts = $this->postModel->related($post['category_id'], $post['id'])->posts(3);

        $data = [
            'title' => $post['title'],
            'description' => !empty($post['description']) ? $post['description'] : substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];

        return $this->render('visitor/post', $data);
    }
}
