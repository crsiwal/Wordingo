<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;

class UserPosts extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {

    }

    /**
     * User saved users/posts/bookmarks
     */
    public function bookmarks()
    {
        $data = [
            'title' => 'Saved Posts',
            'posts' => [], // You would implement actual saved posts retrieval here
        ];

        return $this->render('user/bookmarks', $data);
    }

}
