<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;

class Dashboard extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel     = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * User dashboard
     */
    public function index()
    {
        $data = [
            'title'       => 'User Profile',
            'recentPosts' => $this->postModel->orderBy('created_at', 'DESC')
                ->where('status', 'published')
                ->limit(5)
                ->find(),
            'categories'  => $this->categoryModel->findAll(),
        ];

        return $this->render('user/dashboard', $data);
    }

}
