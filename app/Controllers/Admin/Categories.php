<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Categories',
            'categories' => $this->categoryModel->select('categories.*, COUNT(posts.id) as post_count')
                ->join('posts', 'posts.category_id = categories.id', 'left')
                ->groupBy('categories.id')
                ->orderBy('categories.created_at', 'DESC')
                ->paginate(10),
            'pager' => $this->categoryModel->pager
        ];

        return $this->render('admin/categories/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name]',
                'description' => 'permit_empty|max_length[1000]'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description')
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
            'validation' => $this->validator
        ];

        return $this->render('admin/categories/create', $data);
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => "required|min_length[3]|max_length[255]|is_unique[categories.name,id,$id]",
                'description' => 'permit_empty|max_length[1000]'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description')
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
            'validation' => $this->validator
        ];

        return $this->render('admin/categories/edit', $data);
    }

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            $this->setFlash('success', 'Category deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete category');
        }

        return redirect()->to('/admin/categories');
    }
} 