<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;

class Categories extends BaseController
{
    protected $categoryModel;
    protected $postModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->postModel = new PostModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Manage Categories',
            'categories' => $this->categoryModel->select('categories.*, COUNT(posts.id) as post_count')
                ->join('posts', 'posts.category_id = categories.id', 'left')
                ->groupBy('categories.id')
                ->orderBy('categories.created_at', 'DESC')
                ->paginate(10),
            'pager'      => $this->categoryModel->pager,
        ];

        return $this->render('admin/categories/index', $data);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[255]',
                'slug'        => 'required|min_length[3]|max_length[255]|alpha_dash|is_unique[categories.slug]',
                'description' => 'permit_empty|max_length[1000]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name'        => $this->request->getPost('name'),
                    'slug'        => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                ];

                if ($this->categoryModel->insert($data)) {
                    $this->setFlash('success', 'Category created successfully');
                    return redirect()->to('/admin/categories');
                }

                $this->setFlash('error', 'Failed to create category');
            }else{
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Create Category',
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/create', $data);
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {
            $rules = [
                'name'        => "required|min_length[3]|max_length[255]",
                'slug'        => "required|min_length[3]|max_length[255]|alpha_dash|is_unique[categories.slug,id,$id]",
                'description' => 'permit_empty|max_length[1000]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name'        => $this->request->getPost('name'),
                    'slug'        => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                ];

                if ($this->categoryModel->update($id, $data)) {
                    $this->setFlash('success', 'Category updated successfully');
                    return redirect()->to('/admin/categories');
                }

                $errorMessage = (array_values($this->categoryModel->errors()))[0];
                $this->setFlash('error', 'Failed to update category: ' . $errorMessage);
            }
        }

        $data = [
            'title'      => 'Edit Category',
            'category'   => $category,
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/edit', $data);
    }

    public function delete($id)
    {
        // Get the category before deletion
        $category = $this->categoryModel->find($id);
        if (!$category) {
            $this->setFlash('error', 'Category not found');
            return redirect()->to('/admin/categories');
        }

        // Update posts that use this category to have null category_id
        $affectedPosts = $this->postModel->where('category_id', $id)->countAllResults();
        
        if ($affectedPosts > 0) {
            // Update posts to remove the category reference
            $this->postModel->set('category_id', null)
                     ->where('category_id', $id)
                     ->update();
            
            $this->setFlash('info', "$affectedPosts posts were updated to have no category");
        }

        // Now delete the category
        if ($this->categoryModel->delete($id)) {
            $this->setFlash('success', 'Category "' . $category['name'] . '" deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete category');
        }

        return redirect()->to('/admin/categories');
    }
}
