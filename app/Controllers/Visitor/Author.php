<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\UserModel;

class Author extends BaseController {
    protected $postModel;
    protected $userModel;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->userModel = new UserModel();
    }

    public function index($username) {
        $author = $this->userModel->where('username', $username)->first();

        if (!$author) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get top posts
            $mostViewedPosts = $this->postModel->authorPosts($author['id'])->viewed(true)->posts(7);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'label' => 'Top Stories',
            ];
        }

        // Get latest posts
        $latestPosts = $this->postModel->authorPosts($author['id'])->exclude($excludedIds)->paginate(18);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'label' => 'Recently Posted',
        ];

        $data = [
            'title' => $author['name'],
            'author' => $author,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/author', $data);
    }
}
