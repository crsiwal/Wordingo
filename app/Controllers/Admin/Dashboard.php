<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminDashboardService;
use App\Services\ManagerDashboardService;
use App\Services\EditorDashboardService;

class Dashboard extends BaseController {
    protected $userId;
    protected $userRole;
    protected $adminDashboardService;
    protected $managerDashboardService;
    protected $editorDashboardService;

    public function __construct() {
        $this->userId = session()->get('user_id');
        $this->userRole = session()->get('user_role');
        $this->adminDashboardService = new AdminDashboardService();
        $this->managerDashboardService = new ManagerDashboardService($this->userId);
        $this->editorDashboardService = new EditorDashboardService($this->userId);
    }

    public function index() {
        if ($this->userRole === 'admin') {
            return $this->render('admin/dashboard/admin', $this->adminDashboardService->getDashboardData());
        } elseif ($this->userRole === 'manager') {
            return $this->render('admin/dashboard/manager', $this->managerDashboardService->getDashboardData());
        } elseif ($this->userRole === 'editor') {
            return $this->render('admin/dashboard/editor', $this->editorDashboardService->getDashboardData());
        }
        return $this->render('admin/dashboard');
    }
}
