<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required',
            ];

            if ($this->validate($rules)) {
                $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

                if ($user && $this->userModel->verifyPassword($this->request->getPost('password'), $user['password'])) {
                    $sessionData = [
                        'user_id' => $user['id'],
                        'user_name' => $user['name'],
                        'user_email' => $user['email'],
                        'user_role' => $user['role'],
                        'logged_in' => true,
                    ];

                    session()->set($sessionData);
                    $this->setFlash('success', 'Welcome back, ' . $user['name']);
                    return redirect()->to('/admin');
                }

                $this->setFlash('error', 'Invalid email or password');
            }
        }

        $data = [
            'title' => 'Login',
            'validation' => $this->validator,
        ];

        return $this->render('auth/login', $data);
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'role' => 'user',
                ];

                if ($this->userModel->insert($data)) {
                    $this->setFlash('success', 'Registration successful. Please login.');
                    return redirect()->to('/login');
                }

                $this->setFlash('error', 'Failed to register');
            }
        }

        $data = [
            'title' => 'Register',
            'validation' => $this->validator,
        ];

        return $this->render('auth/register', $data);
    }

    public function logout()
    {
        session()->destroy();
        $this->setFlash('success', 'You have been logged out');
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email',
            ];

            if ($this->validate($rules)) {
                $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

                if ($user) {
                    // Generate reset token
                    $token = bin2hex(random_bytes(32));
                    $this->userModel->update($user['id'], ['reset_token' => $token]);

                    // Send reset email
                    $email = \Config\Services::email();
                    $email->setTo($user['email']);
                    $email->setSubject('Password Reset');
                    $email->setMessage('Click here to reset your password: ' . base_url('reset-password/' . $token));
                    $email->send();

                    $this->setFlash('success', 'Password reset instructions have been sent to your email');
                    return redirect()->to('/login');
                }

                $this->setFlash('error', 'Email not found');
            }
        }

        $data = [
            'title' => 'Forgot Password',
            'validation' => $this->validator,
        ];

        return $this->render('auth/forgot_password', $data);
    }

    public function resetPassword($token)
    {
        $user = $this->userModel->where('reset_token', $token)->first();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'password' => $this->request->getPost('password'),
                    'reset_token' => null,
                ];

                if ($this->userModel->update($user['id'], $data)) {
                    $this->setFlash('success', 'Password has been reset. Please login.');
                    return redirect()->to('/login');
                }

                $this->setFlash('error', 'Failed to reset password');
            }
        }

        $data = [
            'title' => 'Reset Password',
            'validation' => $this->validator,
        ];

        return $this->render('auth/reset_password', $data);
    }
} 