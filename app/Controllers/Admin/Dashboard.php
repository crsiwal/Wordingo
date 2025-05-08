<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'totalPosts' => $this->postModel->countAll(),
            'publishedPosts' => $this->postModel->where('status', 'published')->countAllResults(),
            'totalViews' => $this->postModel->selectSum('views')->first()['views'] ?? 0,
            'totalCategories' => $this->categoryModel->countAll(),
            'totalUsers' => $this->userModel->countAll(),
            'recentPosts' => $this->postModel->orderBy('created_at', 'DESC')->limit(5)->find(),
        ];

        return $this->render('admin/dashboard', $data);
    }
} 