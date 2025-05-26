<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostTagModel;
use App\Models\UserModel;

class SinglePost extends BaseController {
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

    // Single Post Page
    public function index($slug) {
        $post = $this->postModel->published()
            ->detailedFields()
            ->where('posts.slug', $slug)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $post['tags'] = $post['tags'] ? json_decode($post['tags'], true) : [];

        // Increment view count
        $this->postModel->incrementViews($post['id']);

        // Get related posts
        $relatedPosts = $this->postModel->related($post['category_id'], $post['id'])->posts(30);

        $data = [
            'title' => $post['title'],
            'description' => !empty($post['description']) ? $post['description'] : substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];

        return $this->render('visitor/post', $data);
    }
}
