<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\EmailService;

class Auth extends BaseController
{
    protected $userModel;
    protected $emailService;
    protected $avatarPath = 'uploads/avatars';
    protected $fullAvatarPath;
    protected $tempAvatarPath = null; // Variable to store temporary avatar path

    public function __construct()
    {
        $this->userModel      = new UserModel();
        $this->emailService   = new EmailService();
        $this->fullAvatarPath = FCPATH . $this->avatarPath;

        // Create avatar directory if it doesn't exist
        if (! is_dir($this->fullAvatarPath)) {
            mkdir($this->fullAvatarPath, 0777, true);
        }
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
            'email'    => 'required',
            'password' => 'required',
        ];

        if ($this->validate($rules)) {
            $user = $this->userModel->where('email', $this->request->getPost('email'))
                ->orWhere('username', $this->request->getPost('email'))
                ->first();

            if ($user) {
                // Debug information
                log_message('debug', 'Login attempt for user: ' . $user['email']);

                log_message('debug', 'Password: ' . $this->request->getPost('password'));
                log_message('debug', 'Salt: ' . $user['salt']);
                log_message('debug', 'Password with salt: ' . $this->request->getPost('password') . $user['salt']);
                log_message('debug', 'User password: ' . $user['password']);

                // Verify password with salt
                $verify = password_verify($this->request->getPost('password') . $user['salt'], $user['password']);
                log_message('debug', 'Password verification result: ' . ($verify ? 'true' : 'false'));

                if ($verify) {
                    // Check if account is active
                    if ($user['status'] !== 'active') {
                        $this->setFlash('error', 'Your account is ' . $user['status'] . '. Please contact the administrator.');
                        return redirect()->back()->withInput();
                    }

                    $sessionData = [
                        'user_id'       => $user['id'],
                        'user_name'     => $user['name'],
                        'user_username' => $user['username'],
                        'user_email'    => $user['email'],
                        'user_phone'    => $user['phone'],
                        'user_role'     => $user['role'],
                        'is_verified'   => $user['is_verified'],
                        'is_admin'      => $user['role'] == 'admin',
                        'avatar'        => $user['avatar'],
                        'logged_in'     => true,
                    ];

                    session()->set($sessionData);
                    $this->setFlash('success', 'Welcome back, ' . $user['name']);

                    // Redirect based on role
                    switch ($user['role']) {
                        case 'admin':
                        case 'editor':
                            return redirect()->to('/admin');
                        case 'user':
                            return redirect()->to('/users');
                        default:
                            return redirect()->to('/');
                    }
                }
            }

            $this->setFlash('error', 'Invalid email/username or password');
        } else {
            $this->setFlash('error', $this->validator->listErrors());
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
            'username' => 'required|min_length[3]|max_length[32]|is_unique[users.username]|alpha_numeric',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'terms'    => 'required',
            'avatar'   => 'permit_empty|is_image[avatar]|max_size[avatar,2048]',
        ];

        $avatarUploaded = false;
        $avatarPath = null;

        if ($this->validate($rules)) {
            // Generate random salt for password
            $salt = bin2hex(random_bytes(8));

            // Create user data array
            $data = [
                'name'       => $this->request->getPost('name'),
                'username'   => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'password'   => $this->request->getPost('password'), // Store plain password to let model hash it
                'salt'       => $salt,
                'role'       => 'user',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Handle avatar upload if provided
            $avatar = $this->request->getFile('avatar');
            if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
                $avatarResult = $this->processAvatar($avatar);

                if ($avatarResult['status']) {
                    $data['avatar'] = $avatarResult['path'];
                    $avatarUploaded = true;
                    $avatarPath = $avatarResult['path'];
                } else {
                    $this->setFlash('error', 'Failed to process avatar: ' . $avatarResult['message']);
                    return redirect()->back()->withInput();
                }
            }

            // Debug the final data being inserted
            log_message('debug', 'User data to be inserted: ' . json_encode($data));

            if ($this->userModel->insert($data)) {
                // Send welcome email to the user
                try {
                    $this->emailService->sendWelcomeEmail($data);

                    // Send notification to admin
                    $this->emailService->sendAdminNotification($data);

                    log_message('info', 'Registration emails sent successfully to user and admin');
                } catch (\Exception $e) {
                    log_message('error', 'Failed to send registration emails: ' . $e->getMessage());
                }

                $this->setFlash('success', 'Registration successful. Please check your email for welcome information and login.');
                return redirect()->to('/login');
            }

            // If we reach here, registration failed but avatar might have been uploaded
            if ($avatarUploaded && $avatarPath) {
                // Delete the uploaded avatar to prevent junk files
                $fullPath = FCPATH . $avatarPath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    log_message('debug', 'Deleted avatar after failed registration: ' . $fullPath);
                }
            }

            $this->setFlash('error', 'Failed to register: ' . $this->userModel->errors());
        } else {
            $this->setFlash('error', $this->validator->listErrors());
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
                $this->userModel->update($user['id'], [
                    'reset_token' => $token,
                    'updated_at'  => date('Y-m-d H:i:s'),
                ]);

                // Update user data with reset token
                $user['reset_token'] = $token;

                // Send reset email using EmailService
                $this->emailService->sendPasswordResetEmail($user);

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
            // Generate a new salt for extra security
            $salt = bin2hex(random_bytes(8));

            $data = [
                'password'    => $this->request->getPost('password'), // Let model handle hashing
                'salt'        => $salt,
                'reset_token' => null,
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            if ($this->userModel->update($user['id'], $data)) {
                $this->setFlash('success', 'Password has been reset. Please login.');
                return redirect()->to('/login');
            }

            $this->setFlash('error', 'Failed to reset password');
        }

        return redirect()->back()->withInput();
    }

    /**
     * Process an avatar image - convert to PNG and save with unique name
     *
     * @param object $file The uploaded file object
     * @return array Status and results of the operation
     */
    private function processAvatar($file)
    {
        try {
            // Generate a unique filename with timestamp to avoid cache issues
            $newName = 'avatar_' . time() . '_' . uniqid() . '.png';

            // Load image library
            $image = \Config\Services::image();

            // Get the temporary path of the uploaded file
            $tempPath = $file->getTempName();

            // Create a new path for the converted image
            $savePath = $this->fullAvatarPath . '/' . $newName;

            // Resize and convert to PNG
            $image->withFile($tempPath)
                ->resize(300, 300, true)
                ->convert(IMAGETYPE_PNG)
                ->save($savePath);

            // Return the relative path to store in the database
            return [
                'status' => true,
                'path'   => $this->avatarPath . '/' . $newName,
                'fullPath' => $savePath // Include the full path for potential deletion
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
