<?php
namespace App\Controllers\Admin\Ads;

use App\Controllers\BaseController;
use App\Models\AdSlotModel;
use App\Models\AdModel;

class AdSlots extends BaseController
{
    protected $adSlotModel;
    protected $adModel;
    protected $userRole;
    protected $showRecords = 50;

    public function __construct()
    {
        $this->adSlotModel = new AdSlotModel();
        $this->adModel = new AdModel();
        $this->userRole = session()->get('user_role');
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $sort = $this->request->getGet('sort');

        $slotQuery = $this->adSlotModel
            ->select('ad_slots.*, COUNT(ads.id) as ad_count')
            ->join('ads', 'ads.slot_id = ad_slots.id', 'left')
            ->groupBy('ad_slots.id');

        // Search filter
        if (!empty($search)) {
            $slotQuery = $slotQuery->like('ad_slots.name', $search);
        }

        // Sorting
        switch ($sort) {
            case 'name_desc':
                $slotQuery = $slotQuery->orderBy('ad_slots.name', 'DESC');
                break;
            case 'ad_count':
                $slotQuery = $slotQuery->orderBy('ad_count', 'DESC');
                break;
            case 'created_at':
                $slotQuery = $slotQuery->orderBy('ad_slots.created_at', 'DESC');
                break;
            case 'width':
                $slotQuery = $slotQuery->orderBy('ad_slots.width', 'DESC');
                break;
            case 'height':
                $slotQuery = $slotQuery->orderBy('ad_slots.height', 'DESC');
                break;
            case 'name_asc':
            default:
                $slotQuery = $slotQuery->orderBy('ad_slots.name', 'ASC');
                $sort = 'name_asc'; // Set default sort for UI
                break;
        }

        $adSlots = $slotQuery->paginate($this->showRecords);

        $data = [
            'title'        => 'Manage Ad Slots',
            'adSlots'      => $adSlots,
            'pager'        => $this->adSlotModel->pager,
            'userRole'     => $this->userRole,
            'queryParams'  => $this->request->getGet(),
            'activeFilters' => [
                'search' => $search,
                'sort'   => $sort,
            ],
            'sort'         => $sort,
        ];

        return $this->render('admin/ads/slots/index', $data);
    }

    public function create()
    {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can create ad slots');
            return redirect()->to('/admin/ads/slots');
        }

        if ($this->request->is('post')) {
            $rules = [
                'name'      => 'required|min_length[3]|max_length[100]',
                'slug'      => 'required|min_length[3]|max_length[100]|alpha_dash|is_unique[ad_slots.slug]',
                'width'     => 'required|numeric|greater_than[0]',
                'height'    => 'required|numeric|greater_than[0]',
                'is_active' => 'permit_empty|in_list[0,1]',
            ];

            if ($this->validate($rules)) {
                $isActive = $this->request->getPost('is_active') ? 1 : 0;

                $data = [
                    'name'      => $this->request->getPost('name'),
                    'slug'      => $this->request->getPost('slug'),
                    'width'     => $this->request->getPost('width'),
                    'height'    => $this->request->getPost('height'),
                    'is_active' => $isActive,
                ];

                if ($this->adSlotModel->insert($data)) {
                    $this->setFlash('success', 'Ad slot created successfully');
                    return redirect()->to('/admin/ads/slots');
                }

                $this->setFlash('error', 'Failed to create ad slot');
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }
        }

        $data = [
            'title'      => 'Create Ad Slot',
            'validation' => $this->validator,
        ];

        return $this->render('admin/ads/slots/create', $data);
    }

    public function edit($id)
    {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can edit ad slots');
            return redirect()->to('/admin/ads/slots');
        }

        $adSlot = $this->adSlotModel->find($id);

        if (!$adSlot) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {
            $rules = [
                'name'      => 'required|min_length[3]|max_length[100]',
                'slug'      => "required|min_length[3]|max_length[100]|alpha_dash|is_unique[ad_slots.slug,id,$id]",
                'width'     => 'required|numeric|greater_than[0]',
                'height'    => 'required|numeric|greater_than[0]',
                'is_active' => 'permit_empty',
            ];

            if ($this->validate($rules)) {
                $isActive = $this->request->getPost('is_active') ? 1 : 0;

                $data = [
                    'name'      => $this->request->getPost('name'),
                    'slug'      => $this->request->getPost('slug'),
                    'width'     => $this->request->getPost('width'),
                    'height'    => $this->request->getPost('height'),
                    'is_active' => $isActive,
                ];

                if ($this->adSlotModel->update($id, $data)) {
                    $this->setFlash('success', 'Ad slot updated successfully');
                    return redirect()->to('/admin/ads/slots');
                }

                $errorMessage = (array_values($this->adSlotModel->errors()))[0];
                $this->setFlash('error', 'Failed to update ad slot: ' . $errorMessage);
            }
        }

        $data = [
            'title'      => 'Edit Ad Slot',
            'adSlot'     => $adSlot,
            'validation' => $this->validator,
        ];

        return $this->render('admin/ads/slots/edit', $data);
    }

    public function delete($id)
    {
        // Check if user is admin
        if ($this->userRole !== 'admin') {
            $this->setFlash('error', 'Only administrators can delete ad slots');
            return redirect()->to('/admin/ads/slots');
        }

        // Get the ad slot before deletion
        $adSlot = $this->adSlotModel->find($id);
        if (!$adSlot) {
            $this->setFlash('error', 'Ad slot not found');
            return redirect()->to('/admin/ads/slots');
        }

        // Check if there are any ads using this slot
        $affectedAds = $this->adModel->where('slot_id', $id)->countAllResults();

        if ($affectedAds > 0) {
            // Update ads to remove the slot reference
            $this->adModel->set('slot_id', null)
                     ->where('slot_id', $id)
                     ->update();

            $this->setFlash('info', "$affectedAds ads were updated to have no slot");
        }

        // Now delete the ad slot
        if ($this->adSlotModel->delete($id)) {
            $this->setFlash('success', 'Ad slot "' . $adSlot['name'] . '" deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete ad slot');
        }

        return redirect()->to('/admin/ads/slots');
    }
}