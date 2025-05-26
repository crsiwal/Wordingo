<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostTagModel;
use App\Models\UserModel;

class Home extends BaseController {
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

    public function index() {
        $categoryPostsData = [
            'before_category_tabs' => [
                'label' => 'Top Stories',
                'layout' => 'VerticalList',
                'posts' => $this->postModel->featured()->posts(8),
            ],
            'after_category_tabs' => [
                'label' => 'Latest Posts',
                'layout' => 'CarouselCompact',
                'posts' => $this->postModel->published()->paginate(18),
            ],
            'before_featured_carousel' => [
                'label' => 'Featured Posts',
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
}
