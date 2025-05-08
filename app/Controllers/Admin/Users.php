<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Users',
            'users' => $this->userModel->paginate(10),
            'pager' => $this->userModel->pager,
        ];

        return $this->render('admin/users/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'role' => 'required|in_list[admin,user]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => $this->request->getPost('role'),
                ];

                if ($this->userModel->insert($data)) {
                    $this->setFlash('success', 'User created successfully');
                    return redirect()->to('/admin/users');
                }

                $this->setFlash('error', 'Failed to create user');
            }
        }

        $data = [
            'title' => 'Create User',
            'validation' => $this->validator,
        ];

        return $this->render('admin/users/create', $data);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'role' => 'required|in_list[admin,user]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'role' => $this->request->getPost('role'),
                ];

                // Update password if provided
                if ($password = $this->request->getPost('password')) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                if ($this->userModel->update($id, $data)) {
                    $this->setFlash('success', 'User updated successfully');
                    return redirect()->to('/admin/users');
                }

                $this->setFlash('error', 'Failed to update user');
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'validation' => $this->validator,
        ];

        return $this->render('admin/users/edit', $data);
    }

    public function delete($id)
    {
        // Prevent self-deletion
        if ($id == session()->get('user_id')) {
            $this->setFlash('error', 'You cannot delete your own account');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            $this->setFlash('success', 'User deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete user');
        }

        return redirect()->to('/admin/users');
    }
} 