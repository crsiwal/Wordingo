<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;

class Categories extends BaseController {
    protected $categoryModel;
    protected $postModel;
    protected $userRole;
    protected $showRecords = 50;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
        $this->postModel = new PostModel();
        $this->userRole = session()->get('user_role');
    }

    public function index() {
        $search = $this->request->getGet('q');
        $sort = $this->request->getGet('sort');
        $userId = session()->get('user_id');
        $userRole = $this->userRole;

        $categoryQuery = $this->categoryModel
            ->select('categories.*, COUNT(posts.id) as post_count')
            ->join('posts', 'posts.category_id = categories.id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->groupBy('categories.id');

        // Permission-based post filter
        if ($userRole === 'admin') {
            $categoryQuery = $categoryQuery->where('posts.id IS NULL OR users.status != "banned"');
        } elseif ($userRole === 'manager') {
            $userModel = new UserModel();
            $editorIds = $userModel->where('parent_id', $userId)->findColumn('id') ?? [];
            $userIds = array_merge([$userId], $editorIds);
            if (!empty($userIds)) {
                $in = implode(',', array_map('intval', $userIds));
                $categoryQuery = $categoryQuery->where("posts.id IS NULL OR (posts.user_id IN ($in) AND users.status != 'banned')");
            } else {
                // If manager has no editors, only their own posts
                $categoryQuery = $categoryQuery->where('posts.id IS NULL OR (posts.user_id = ' . intval($userId) . ' AND users.status != "banned")');
            }
        } else { // editor
            $categoryQuery = $categoryQuery->where('posts.id IS NULL OR (posts.user_id = ' . intval($userId) . ' AND users.status != "banned")');
        }

        // Search filter
        if (!empty($search)) {
            $categoryQuery = $categoryQuery->like('categories.name', $search);
        }

        // Sorting
        switch ($sort) {
            case 'name_desc':
                $categoryQuery = $categoryQuery->orderBy('categories.name', 'DESC');
                break;
            case 'post_count':
                $categoryQuery = $categoryQuery->orderBy('post_count', 'DESC');
                break;
            case 'created_at':
                $categoryQuery = $categoryQuery->orderBy('categories.created_at', 'DESC');
                break;
            case 'name_asc':
            default:
                $categoryQuery = $categoryQuery->orderBy('categories.name', 'ASC');
                $sort = 'name_asc'; // Set default sort for UI
                break;
        }

        $categories = $categoryQuery->paginate($this->showRecords);

        $data = [
            'title'        => 'Manage Categories',
            'categories'   => $categories,
            'pager'        => $this->categoryModel->pager,
            'userRole'     => $this->userRole,
            'queryParams'  => $this->request->getGet(),
            'activeFilters' => [
                'search' => $search,
                'sort'   => $sort,
            ],
            'sort'         => $sort,
        ];

        return $this->render('admin/categories/index', $data);
    }

    public function create() {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can create categories');
            return redirect()->to('/admin/categories');
        }

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
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Create Category',
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/create', $data);
    }

    public function edit($id) {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can edit categories');
            return redirect()->to('/admin/categories');
        }

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
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Edit Category',
            'category'   => $category,
            'validation' => $this->validator,
        ];

        return $this->render('admin/categories/edit', $data);
    }

    public function delete($id) {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can delete categories');
            return redirect()->to('/admin/categories');
        }

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
