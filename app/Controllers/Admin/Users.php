<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\EmailService;
use App\Models\UserModel;
use App\Models\PostModel;

class Users extends BaseController {
    protected $userModel;
    protected $emailService;
    protected $avatarPath = 'uploads/avatars';
    protected $fullAvatarPath;
    protected $userRole;
    protected $userId;
    protected $allowedRoles;

    public function __construct() {
        $this->userModel      = new UserModel();
        $this->emailService   = new EmailService();
        $this->fullAvatarPath = FCPATH . $this->avatarPath;
        $this->userRole       = session()->get('user_role');
        $this->userId         = session()->get('user_id');

        // Determine allowed roles based on current user role
        $this->allowedRoles = ($this->userRole === 'admin')
            ? ['admin', 'manager', 'editor', 'user']
            : ['editor'];

        // Create avatar directory if it doesn't exist
        if (! is_dir($this->fullAvatarPath)) {
            mkdir($this->fullAvatarPath, 0777, true);
        }

        // Editor users cannot access user management
        if ($this->userRole === 'editor') {
            $this->setFlash('error', 'You do not have permission to manage users');
            return redirect()->to('/admin')->withInput();
        }
    }

    public function index() {
        // Admin can see all users, Manager can only see users they created
        if ($this->userRole === 'admin') {
            $users = $this->userModel->paginate(10);
        } elseif ($this->userRole === 'manager') {
            $users = $this->userModel->where('parent_id', $this->userId)->paginate(10);
        } else {
            // Should not reach here due to constructor check, but just in case
            return redirect()->to('/admin');
        }

        // Get post counts for all users in a single query
        $postModel = new \App\Models\PostModel();

        // Extract all user IDs
        $userIds = array_column($users, 'id');

        // Get post counts for these users in a single query
        $postCounts = $postModel
            ->select('user_id, COUNT(*) as post_count')
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')
            ->findAll();

        // Convert to associative array for easy lookup
        $postCountsByUser = [];
        foreach ($postCounts as $count) {
            $postCountsByUser[$count['user_id']] = $count['post_count'];
        }

        // Assign post counts to users
        foreach ($users as &$user) {
            $user['post_count'] = $postCountsByUser[$user['id']] ?? 0;
        }

        $data = [
            'title'    => 'Manage Users',
            'users'    => $users,
            'pager'    => $this->userModel->pager,
            'userRole' => $this->userRole,
        ];

        return $this->render('admin/users/index', $data);
    }

    public function create() {
        if ($this->request->is('post')) {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[255]',
                'username' => 'required|min_length[3]|max_length[32]|is_unique[users.username]|alpha_numeric',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'phone'    => 'required|min_length[10]|max_length[15]',
                'gender'   => 'required|in_list[male,female]',
                'address'  => 'required|min_length[5]|max_length[255]',
                'password' => 'required|min_length[8]',
                'status'   => 'required|in_list[active,inactive,banned]',
                'avatar'   => 'permit_empty|is_image[avatar]|max_size[avatar,2048]',
            ];

            // Only add role validation if admin (manager can only create editors)
            if ($this->userRole === 'admin') {
                $rules['role'] = 'required|in_list[admin,manager,editor,user]';
            }

            if ($this->validate($rules)) {
                // Generate random salt for password
                $salt = bin2hex(random_bytes(8));

                // Set role based on user type
                $role = ($this->userRole === 'admin')
                    ? $this->request->getPost('role')
                    : 'editor'; // Manager can only create editors

                // Process form data
                $data = [
                    'parent_id'     => $this->userId, // Current user is the parent
                    'name'          => $this->request->getPost('name'),
                    'username'      => $this->request->getPost('username'),
                    'email'         => $this->request->getPost('email'),
                    'phone'         => $this->request->getPost('phone'),
                    'date_of_birth' => $this->request->getPost('date_of_birth') ?: null,
                    'gender'        => $this->request->getPost('gender'),
                    'address'       => $this->request->getPost('address'),
                    'password'      => $this->request->getPost('password'),
                    'salt'          => $salt,
                    'role'          => $role,
                    'status'        => $this->request->getPost('status') ?: 'active',
                    'is_verified'   => (int) $this->request->getPost('is_verified') ? 1 : 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];

                // Handle email verification
                if ($this->request->getPost('email_verified')) {
                    $data['email_verified_at'] = date('Y-m-d H:i:s');
                }

                // Handle phone verification
                if ($this->request->getPost('phone_verified')) {
                    $data['phone_verified_at'] = date('Y-m-d H:i:s');
                }

                // Handle avatar upload and conversion to PNG
                $avatar = $this->request->getFile('avatar');
                if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
                    $avatarResult = $this->processAvatar($avatar);

                    if ($avatarResult['status']) {
                        $data['avatar'] = $avatarResult['path'];
                    } else {
                        $this->setFlash('error', 'Failed to process avatar: ' . $avatarResult['message']);
                        return redirect()->back()->withInput();
                    }
                }

                if ($this->userModel->insert($data)) {
                    // Send welcome email to the newly created user if account is active
                    if ($data['status'] === 'active') {
                        try {
                            $this->emailService->sendWelcomeEmail($data);

                            // Also notify admin about the user creation (if created by another admin or manager)
                            if ($this->userRole !== 'admin') {
                                $this->emailService->sendAdminNotification($data);
                            }

                            log_message('info', 'Welcome email sent to: ' . $data['email']);
                            $emailSent = true;
                        } catch (\Exception $e) {
                            log_message('error', 'Failed to send welcome email: ' . $e->getMessage());
                            $emailSent = false;
                        }
                    } else {
                        $emailSent = false;
                    }

                    $this->setFlash('success', 'User created successfully' . ($emailSent ? ' and welcome email sent' : ''));
                    return redirect()->to('/admin/users');
                }

                $this->setFlash('error', 'Failed to create user: ' . $this->userModel->errors());
                return redirect()->back()->withInput();
            } else {
                $this->setFlash('error', 'Please fill in all fields correctly' . $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
        }

        // Default form values if not from prior submission
        $formData = $this->request->getPost() ?: [
            'status' => 'active',
            'role'   => 'user',
        ];

        $data = [
            'title'        => 'Create User',
            'validation'   => $this->validator,
            'allowedRoles' => $this->allowedRoles,
            'userRole'     => $this->userRole,
            'formData'     => $formData,
        ];

        return $this->render('admin/users/create', $data);
    }

    public function edit($id) {
        // Check if user can edit this user
        $user = $this->userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Managers can only edit users they created
        if ($this->userRole === 'manager' && $user['parent_id'] != $this->userId) {
            $this->setFlash('error', 'You do not have permission to edit this user');
            return redirect()->to('/admin/users');
        }

        if ($this->request->is('post')) {
            // Build validation rules
            $rules = [
                'name'     => 'required|min_length[3]|max_length[255]',
                'username' => "required|min_length[3]|max_length[32]|alpha_numeric|is_unique[users.username,id,{$id}]",
                "email"    => "required|valid_email|max_length[255]|is_unique[users.email,id,{$id}]",
                'phone'    => 'required|min_length[10]|max_length[15]',
                'gender'   => 'required|in_list[male,female]',
                'address'  => 'required|min_length[5]|max_length[255]',
                'status'   => 'required|in_list[active,inactive,banned]',
                'avatar'   => 'permit_empty|is_image[avatar]|max_size[avatar,2048]',
            ];

            // Only admin can change role
            if ($this->userRole === 'admin') {
                $rules['role'] = 'required|in_list[admin,manager,editor,user]';
            }

            // Add password validation only if provided
            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[8]';
            }

            // Validate using the rules
            if ($this->validate($rules)) {
                // Set role based on user type
                $role = ($this->userRole === 'admin')
                    ? $this->request->getPost('role')
                    : $user['role']; // Manager cannot change roles

                // Start with basic data
                $data = [
                    'name'          => $this->request->getPost('name'),
                    'username'      => $this->request->getPost('username'),
                    'email'         => $this->request->getPost('email'),
                    'phone'         => $this->request->getPost('phone'),
                    'date_of_birth' => $this->request->getPost('date_of_birth') ?: null,
                    'gender'        => $this->request->getPost('gender'),
                    'address'       => $this->request->getPost('address'),
                    'role'          => $role,
                    'status'        => $this->request->getPost('status'),
                    'is_verified'   => (int) $this->request->getPost('is_verified') ? 1 : 0,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];

                // Update password if provided
                if ($password = $this->request->getPost('password')) {
                    // Get the existing salt or generate a new one
                    $salt = $user['salt'] ?: bin2hex(random_bytes(8));

                    $data['password'] = $password;
                    $data['salt']     = $salt;
                }

                // Handle email verification
                if ($this->request->getPost('email_verified')) {
                    $data['email_verified_at'] = date('Y-m-d H:i:s');
                } else {
                    $data['email_verified_at'] = null;
                }

                // Handle phone verification
                if ($this->request->getPost('phone_verified')) {
                    $data['phone_verified_at'] = date('Y-m-d H:i:s');
                } else {
                    $data['phone_verified_at'] = null;
                }

                // Handle avatar upload and conversion to PNG
                $avatar = $this->request->getFile('avatar');
                if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
                    // Delete the old avatar if it exists
                    $this->deleteAvatar($user['avatar']);

                    $avatarResult = $this->processAvatar($avatar);

                    if ($avatarResult['status']) {
                        $data['avatar'] = $avatarResult['path'];
                    } else {
                        $this->setFlash('error', 'Failed to process avatar: ' . $avatarResult['message']);
                        return redirect()->back()->withInput();
                    }
                }

                if ($this->userModel->update($id, $data)) {
                    $this->setFlash('success', 'User updated successfully');
                    return redirect()->to('/admin/users');
                }

                $errorMessage = (array_values($this->userModel->errors()))[0];
                $this->setFlash('error', 'Failed to update user: ' . $errorMessage);
                return redirect()->back()->withInput();
            } else {
                $this->setFlash('error', 'Please check your form data');
                return redirect()->back()->withInput();
            }
        }

        // Prepare form data - use existing user data or post data if from previous failed submission
        $formData = $this->request->getPost() ?: $user;

        // Convert verification dates to checkboxes
        if (! isset($formData['email_verified'])) {
            $formData['email_verified'] = ! empty($user['email_verified_at']);
        }
        if (! isset($formData['phone_verified'])) {
            $formData['phone_verified'] = ! empty($user['phone_verified_at']);
        }
        if (! isset($formData['is_verified'])) {
            $formData['is_verified'] = (bool) $user['is_verified'];
        }

        $data = [
            'title'        => 'Edit User',
            'user'         => $user,
            'validation'   => $this->validator,
            'allowedRoles' => $this->allowedRoles,
            'userRole'     => $this->userRole,
            'formData'     => $formData,
        ];

        return $this->render('admin/users/edit', $data);
    }

    public function delete($id) {
        // Prevent self-deletion
        if ($id == $this->userId) {
            $this->setFlash('error', 'You cannot delete your own account');
            return redirect()->to('/admin/users');
        }

        // Get user for avatar deletion and permission check
        $user = $this->userModel->find($id);

        if (! $user) {
            $this->setFlash('error', 'User not found');
            return redirect()->to('/admin/users');
        }

        // Managers can only delete users they created
        if ($this->userRole === 'manager' && $user['parent_id'] != $this->userId) {
            $this->setFlash('error', 'You do not have permission to delete this user');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            // Delete avatar file if exists
            $this->deleteAvatar($user['avatar']);

            $this->setFlash('success', 'User deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete user');
        }

        return redirect()->to('/admin/users');
    }

    /**
     * Process an avatar image - convert to PNG and save with unique name
     *
     * @param object $file The uploaded file object
     * @return array Status and results of the operation
     */
    private function processAvatar($file) {
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
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete an avatar file if it exists
     *
     * @param string $avatarPath The avatar path to delete
     * @return boolean Success or failure
     */
    private function deleteAvatar($avatarPath) {
        if (empty($avatarPath)) {
            return false;
        }

        // Check if it's a relative path and convert to full path
        if (strpos($avatarPath, '/') === 0) {
            $fullPath = FCPATH . substr($avatarPath, 1);
        } else {
            $fullPath = FCPATH . $avatarPath;
        }

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }
}
