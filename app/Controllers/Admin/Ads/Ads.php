<?php

namespace App\Controllers\Admin\Ads;

use App\Controllers\BaseController;
use App\Models\AdModel;
use App\Models\AdSlotModel;
use App\Models\CategoryModel;

class Ads extends BaseController {
    protected $adModel;
    protected $adSlotModel;
    protected $categoryModel;
    protected $userRole;
    protected $showRecords = 50;

    public function __construct() {
        $this->adModel = new AdModel();
        $this->adSlotModel = new AdSlotModel();
        $this->categoryModel = new CategoryModel();
        $this->userRole = session()->get('user_role');
    }

    public function index() {
        $search = $this->request->getGet('q');
        $sort = $this->request->getGet('sort');
        $slotFilter = $this->request->getGet('slot');
        $statusFilter = $this->request->getGet('status');
        $categoryFilter = $this->request->getGet('category');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $adsQuery = $this->adModel
            ->select('ads.*, ad_slots.name as slot_name, categories.name as category_name')
            ->join('ad_slots', 'ad_slots.id = ads.slot_id', 'left')
            ->join('categories', 'categories.id = ads.category_id', 'left');

        // Search filter
        if (!empty($search)) {
            $adsQuery = $adsQuery->like('ads.title', $search);
        }

        // Slot filter
        if (!empty($slotFilter)) {
            $adsQuery = $adsQuery->where('ads.slot_id', $slotFilter);
        }

        // Category filter
        if (!empty($categoryFilter)) {
            $adsQuery = $adsQuery->where('ads.category_id', $categoryFilter);
        }

        // Status filter
        if ($statusFilter !== null && $statusFilter !== '') {
            $isActive = ($statusFilter === 'active') ? 1 : 0;
            $adsQuery = $adsQuery->where('ads.is_active', $isActive);
        }

        // Date range filter
        if (!empty($startDate)) {
            $adsQuery = $adsQuery->where('ads.created_at >=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $adsQuery = $adsQuery->where('ads.created_at <=', $endDate . ' 23:59:59');
        }

        // Sorting
        switch ($sort) {
            case 'title_desc':
                $adsQuery = $adsQuery->orderBy('ads.title', 'DESC');
                break;
            case 'views':
                $adsQuery = $adsQuery->orderBy('ads.views', 'DESC');
                break;
            case 'clicks':
                $adsQuery = $adsQuery->orderBy('ads.clicks', 'DESC');
                break;
            case 'slot':
                $adsQuery = $adsQuery->orderBy('ad_slots.name', 'ASC');
                break;
            case 'created_at':
                $adsQuery = $adsQuery->orderBy('ads.created_at', 'DESC');
                break;
            case 'priority':
                $adsQuery = $adsQuery->orderBy('ads.priority', 'DESC');
                break;
            case 'title_asc':
            default:
                $adsQuery = $adsQuery->orderBy('ads.title', 'ASC');
                $sort = 'title_asc'; // Set default sort for UI
                break;
        }

        $ads = $adsQuery->paginate($this->showRecords);

        // Get slots for filter dropdown
        $slots = $this->adSlotModel->findAll();

        // Get categories for filter dropdown
        $categories = $this->categoryModel->findAll();

        $data = [
            'title'        => 'Manage Ads',
            'ads'          => $ads,
            'pager'        => $this->adModel->pager,
            'userRole'     => $this->userRole,
            'queryParams'  => $this->request->getGet(),
            'activeFilters' => [
                'search'     => $search,
                'sort'       => $sort,
                'slot'       => $slotFilter,
                'status'     => $statusFilter,
                'category'   => $categoryFilter,
                'start_date' => $startDate,
                'end_date'   => $endDate,
            ],
            'slots'        => $slots,
            'categories'   => $categories,
            'sort'         => $sort,
        ];

        return $this->render('admin/ads/ads/index', $data);
    }

    public function create() {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can create ads');
            return redirect()->to('/admin/ads');
        }

        // Get slots and categories for dropdowns
        $slots = $this->adSlotModel->where('is_active', 1)->findAll();
        $categories = $this->categoryModel->findAll();

        if ($this->request->is('post')) {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[150]',
                'slot_id'     => 'permit_empty|is_natural_no_zero',
                'category_id' => 'permit_empty|is_natural_no_zero',
                'asset_url'   => 'required|valid_url_strict',
                'target_url'  => 'required|valid_url_strict',
                'priority'    => 'permit_empty|is_natural_no_zero',
                'max_views'   => 'permit_empty|is_natural',
                'max_clicks'  => 'permit_empty|is_natural',
                'start_time'  => 'permit_empty|valid_date[Y-m-d\TH:i]',
                'end_time'    => 'permit_empty|valid_date[Y-m-d\TH:i]',
                'is_active'   => 'permit_empty',
            ];

            if ($this->validate($rules)) {
                $isActive = $this->request->getPost('is_active') ? 1 : 0;

                $data = [
                    'title'       => $this->request->getPost('title'),
                    'slot_id'     => $this->request->getPost('slot_id') ?: null,
                    'category_id' => $this->request->getPost('category_id') ?: null,
                    'asset_url'   => $this->request->getPost('asset_url'),
                    'target_url'  => $this->request->getPost('target_url'),
                    'priority'    => $this->request->getPost('priority') ?: 1,
                    'max_views'   => $this->request->getPost('max_views') ?: null,
                    'max_clicks'  => $this->request->getPost('max_clicks') ?: null,
                    'start_time'  => $this->request->getPost('start_time') ?: null,
                    'end_time'    => $this->request->getPost('end_time') ?: null,
                    'is_active'   => $isActive,
                ];

                if ($this->adModel->insert($data)) {
                    $this->setFlash('success', 'Ad created successfully');
                    return redirect()->to('/admin/ads');
                }

                $this->setFlash('error', 'Failed to create ad');
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Create Ad',
            'validation' => $this->validator,
            'slots'      => $slots,
            'categories' => $categories,
        ];

        return $this->render('admin/ads/ads/create', $data);
    }

    public function edit($id) {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can edit ads');
            return redirect()->to('/admin/ads');
        }

        $ad = $this->adModel->find($id);

        if (!$ad) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get slots and categories for dropdowns
        $slots = $this->adSlotModel->where('is_active', 1)->findAll();
        $categories = $this->categoryModel->findAll();

        if ($this->request->is('post')) {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[150]',
                'slot_id'     => 'permit_empty|is_natural_no_zero',
                'category_id' => 'permit_empty|is_natural_no_zero',
                'asset_url'   => 'required|valid_url_strict',
                'target_url'  => 'required|valid_url_strict',
                'priority'    => 'permit_empty|is_natural_no_zero',
                'max_views'   => 'permit_empty|is_natural',
                'max_clicks'  => 'permit_empty|is_natural',
                'start_time'  => 'permit_empty|valid_date[Y-m-d\TH:i]',
                'end_time'    => 'permit_empty|valid_date[Y-m-d\TH:i]',
                'is_active'   => 'permit_empty',
            ];

            if ($this->validate($rules)) {
                $isActive = $this->request->getPost('is_active') ? 1 : 0;

                $data = [
                    'title'       => $this->request->getPost('title'),
                    'slot_id'     => $this->request->getPost('slot_id') ?: null,
                    'category_id' => $this->request->getPost('category_id') ?: null,
                    'asset_url'   => $this->request->getPost('asset_url'),
                    'target_url'  => $this->request->getPost('target_url'),
                    'priority'    => $this->request->getPost('priority') ?: 1,
                    'max_views'   => $this->request->getPost('max_views') ?: null,
                    'max_clicks'  => $this->request->getPost('max_clicks') ?: null,
                    'start_time'  => $this->request->getPost('start_time') ?: null,
                    'end_time'    => $this->request->getPost('end_time') ?: null,
                    'is_active'   => $isActive,
                ];

                if ($this->adModel->update($id, $data)) {
                    $this->setFlash('success', 'Ad updated successfully');
                    return redirect()->to('/admin/ads');
                }

                $this->setFlash('error', 'Failed to update ad');
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Edit Ad',
            'ad'         => $ad,
            'validation' => $this->validator,
            'slots'      => $slots,
            'categories' => $categories,
        ];

        return $this->render('admin/ads/ads/edit', $data);
    }

    public function delete($id) {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can delete ads');
            return redirect()->to('/admin/ads');
        }

        // Get the ad before deletion
        $ad = $this->adModel->find($id);
        if (!$ad) {
            $this->setFlash('error', 'Ad not found');
            return redirect()->to('/admin/ads');
        }

        // Now delete the ad
        if ($this->adModel->delete($id)) {
            $this->setFlash('success', 'Ad "' . $ad['title'] . '" deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete ad');
        }

        return redirect()->to('/admin/ads');
    }

    public function resetStats($id) {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can reset ad statistics');
            return redirect()->to('/admin/ads');
        }

        // Get the ad
        $ad = $this->adModel->find($id);
        if (!$ad) {
            $this->setFlash('error', 'Ad not found');
            return redirect()->to('/admin/ads');
        }

        // Reset views and clicks
        $data = [
            'views' => 0,
            'clicks' => 0
        ];

        if ($this->adModel->update($id, $data)) {
            $this->setFlash('success', 'Statistics for "' . $ad['title'] . '" reset successfully');
        } else {
            $this->setFlash('error', 'Failed to reset statistics');
        }

        return redirect()->to('/admin/ads');
    }
}
