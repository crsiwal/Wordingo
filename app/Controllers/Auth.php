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
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        return $this->render('auth/login', [
            'title'      => 'Login',
            'validation' => $this->validator,
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if ($this->validate($rules)) {
            $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

            if ($user) {
                // Debug information
                log_message('debug', 'Login attempt for user: ' . $user['email']);
                log_message('debug', 'Stored hash: ' . $user['password']);
                log_message('debug', 'Provided password: ' . $this->request->getPost('password'));
                
                $verify = password_verify($this->request->getPost('password'), $user['password']);
                log_message('debug', 'Password verification result: ' . ($verify ? 'true' : 'false'));

                if ($verify) {
                    $sessionData = [
                        'user_id'    => $user['id'],
                        'user_name'  => $user['name'],
                        'user_email' => $user['email'],
                        'user_role'  => $user['role'],
                        'logged_in'  => true,
                    ];

                    session()->set($sessionData);
                    $this->setFlash('success', 'Welcome back, ' . $user['name']);
                    return redirect()->to('/admin');
                }
            }

            $this->setFlash('error', 'Invalid email or password');
        }

        return redirect()->back()->withInput();
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        return $this->render('auth/register', [
            'title'      => 'Register',
            'validation' => $this->validator,
        ]);
    }

    public function attemptRegister()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[255]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'terms'    => 'required',
        ];

        if ($this->validate($rules)) {
            $password = $this->request->getPost('password');
            
            // Debug information
            log_message('debug', 'Registration for user: ' . $this->request->getPost('email'));
            log_message('debug', 'Original password: ' . $password);
            
            // Create user data array - let the model handle password hashing
            $data = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => $password, // Pass the plain password, model will hash it
                'role'     => 'user',
            ];
            
            // Debug the final data being inserted
            log_message('debug', 'User data to be inserted: ' . json_encode($data));

            if ($this->userModel->insert($data)) {
                // Verify the stored hash
                $storedUser = $this->userModel->where('email', $data['email'])->first();
                log_message('debug', 'Stored hash in database: ' . $storedUser['password']);
                
                $this->setFlash('success', 'Registration successful. Please login.');
                return redirect()->to('/login');
            }

            $this->setFlash('error', 'Failed to register');
        }

        return redirect()->back()->withInput();
    }

    public function logout()
    {
        session()->destroy();
        $this->setFlash('success', 'You have been logged out');
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        return $this->render('auth/forgot_password', [
            'title'      => 'Forgot Password',
            'validation' => $this->validator,
        ]);
    }

    public function attemptForgotPassword()
    {
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

        return redirect()->back()->withInput();
    }

    public function resetPassword($token)
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        $user = $this->userModel->where('reset_token', $token)->first();

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->render('auth/reset_password', [
            'title'      => 'Reset Password',
            'validation' => $this->validator,
            'token'      => $token,
        ]);
    }

    public function attemptResetPassword($token)
    {
        $user = $this->userModel->where('reset_token', $token)->first();

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'password' => 'required|min_length[8]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'reset_token' => null,
            ];

            if ($this->userModel->update($user['id'], $data)) {
                $this->setFlash('success', 'Password has been reset. Please login.');
                return redirect()->to('/login');
            }

            $this->setFlash('error', 'Failed to reset password');
        }

        return redirect()->back()->withInput();
    }
}
