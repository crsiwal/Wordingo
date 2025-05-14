<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
    }

    /**
     * User dashboard
     */
    public function index()
    {
        $data = [
            'title' => 'My Profile',
            'user'  => [
                'id'       => session()->get('user_id'),
                'name'     => session()->get('user_name'),
                'username' => session()->get('user_username'),
                'email'    => session()->get('user_email'),
                'phone'    => session()->get('user_phone'),
                'avatar'   => session()->get('avatar'),
                'role'     => session()->get('user_role'),
            ],
        ];

        return $this->render('user/profile', $data);
    }
}
