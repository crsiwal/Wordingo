<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostTagModel;
use App\Models\UserModel;

class Category extends BaseController {
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $postTagModel;
    protected $userModel;

    /**
     * @var int
     */
    protected $mostViewedCount;

    /**
     * @var int
     */
    protected $latestCount;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
        $this->postTagModel = new PostTagModel();
        $this->userModel = new UserModel();
        $this->mostViewedCount = 7;
        $this->latestCount = 18;
    }

    // Category Page
    public function index($slug) {
        $category = $this->categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get top posts
            $mostViewedPosts = $this->postModel->categoryPosts($slug)->viewed(true)->posts(1);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'label' => 'Top Stories',
            ];
        }

        // Get latest posts
        $latestPosts = $this->postModel->categoryPosts($slug)->exclude($excludedIds)->paginate(18);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'label' => 'Recently Posted',
        ];

        $data = [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/category', $data);
    }
}
