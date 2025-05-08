<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $userModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
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
            'recentPosts' => $this->postModel->orderBy('created_at', 'DESC')->limit(5)->find(),
        ];

        return $this->render('admin/dashboard', $data);
    }

    public function posts()
    {
        $data = [
            'title' => 'Manage Posts',
            'posts' => $this->postModel->orderBy('created_at', 'DESC')->paginate(10),
            'pager' => $this->postModel->pager,
        ];

        return $this->render('admin/posts/index', $data);
    }

    public function createPost()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
                'category_id' => 'required|numeric',
                'status' => 'required|in_list[draft,published]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'user_id' => session()->get('user_id'),
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'content' => $this->request->getPost('content'),
                    'category_id' => $this->request->getPost('category_id'),
                    'status' => $this->request->getPost('status'),
                    'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
                ];

                if ($this->postModel->insert($data)) {
                    $this->setFlash('success', 'Post created successfully');
                    return redirect()->to('/admin/posts');
                }

                $this->setFlash('error', 'Failed to create post');
            }
        }

        $data = [
            'title' => 'Create Post',
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
            'validation' => $this->validator,
        ];

        return $this->render('admin/posts/create', $data);
    }

    public function editPost($id)
    {
        $post = $this->postModel->find($id);

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
                'category_id' => 'required|numeric',
                'status' => 'required|in_list[draft,published]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'content' => $this->request->getPost('content'),
                    'category_id' => $this->request->getPost('category_id'),
                    'status' => $this->request->getPost('status'),
                    'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
                ];

                if ($this->postModel->update($id, $data)) {
                    $this->setFlash('success', 'Post updated successfully');
                    return redirect()->to('/admin/posts');
                }

                $this->setFlash('error', 'Failed to update post');
            }
        }

        $data = [
            'title' => 'Edit Post',
            'post' => $post,
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
            'validation' => $this->validator,
        ];

        return $this->render('admin/posts/edit', $data);
    }

    public function deletePost($id)
    {
        if ($this->postModel->delete($id)) {
            $this->setFlash('success', 'Post deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete post');
        }

        return redirect()->to('/admin/posts');
    }

    public function categories()
    {
        $data = [
            'title' => 'Manage Categories',
            'categories' => $this->categoryModel->withPostCount()->findAll(),
        ];

        return $this->render('admin/categories/index', $data);
    }

    public function createCategory()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                ];

                if ($this->categoryModel->insert($data)) {
                    $this->setFlash('success', 'Category created successfully');
                    return redirect()->to('/admin/categories');
                }

                $this->setFlash('error', 'Failed to create category');
            }
        }

        $data = [
            'title' => 'Create Category',
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/create', $data);
    }

    public function editCategory($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                ];

                if ($this->categoryModel->update($id, $data)) {
                    $this->setFlash('success', 'Category updated successfully');
                    return redirect()->to('/admin/categories');
                }

                $this->setFlash('error', 'Failed to update category');
            }
        }

        $data = [
            'title' => 'Edit Category',
            'category' => $category,
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/edit', $data);
    }

    public function deleteCategory($id)
    {
        if ($this->categoryModel->delete($id)) {
            $this->setFlash('success', 'Category deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete category');
        }

        return redirect()->to('/admin/categories');
    }
} 