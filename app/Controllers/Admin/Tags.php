<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagModel;

class Tags extends BaseController
{
    protected $tagModel;
    protected $showRecords = 50;

    public function __construct()
    {
        $this->tagModel = new TagModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $sort = $this->request->getGet('sort');
        $userId = session()->get('user_id');
        $userRole = session()->get('user_role');

        $tagsQuery = $this->tagModel
            ->select('tags.*, COUNT(posts.id) as post_count')
            ->join('post_tags', 'post_tags.tag_id = tags.id', 'left')
            ->join('posts', 'posts.id = post_tags.post_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->groupBy('tags.id');

        // Permission-based post filter
        if ($userRole === 'admin') {
            $tagsQuery = $tagsQuery->where('posts.id IS NULL OR users.status != "banned"');
        } elseif ($userRole === 'manager') {
            $userModel = new \App\Models\UserModel();
            $editorIds = $userModel->where('parent_id', $userId)->findColumn('id') ?? [];
            $userIds = array_merge([$userId], $editorIds);
            if (!empty($userIds)) {
                $in = implode(',', array_map('intval', $userIds));
                $tagsQuery = $tagsQuery->where("posts.id IS NULL OR (posts.user_id IN ($in) AND users.status != 'banned')");
            } else {
                $tagsQuery = $tagsQuery->where('posts.id IS NULL OR (posts.user_id = ' . intval($userId) . ' AND users.status != "banned")');
            }
        } else { // editor
            $tagsQuery = $tagsQuery->groupStart()
                ->where('posts.id IS NULL')
                ->orGroupStart()
                    ->where('posts.user_id', $userId)
                    ->where('users.status !=', 'banned')
                ->groupEnd()
            ->groupEnd();
        }

        // Search filter
        if (!empty($search)) {
            $tagsQuery = $tagsQuery->like('tags.name', $search);
        }

        // Sorting
        switch ($sort) {
            case 'name_desc':
                $tagsQuery = $tagsQuery->orderBy('tags.name', 'DESC');
                break;
            case 'post_count':
                $tagsQuery = $tagsQuery->orderBy('post_count', 'DESC');
                break;
            case 'created_at':
                $tagsQuery = $tagsQuery->orderBy('tags.created_at', 'DESC');
                break;
            case 'name_asc':
            default:
                $tagsQuery = $tagsQuery->orderBy('tags.name', 'ASC');
                $sort = 'name_asc';
                break;
        }

        // Only show tags with at least 1 post
        $tagsQuery = $tagsQuery->having('COUNT(posts.id) >', 0);

        $tags = $tagsQuery->paginate($this->showRecords);

        $data = [
            'title'        => 'Manage Tags',
            'tags'         => $tags,
            'pager'        => $this->tagModel->pager,
            'userRole'     => $userRole,
            'queryParams'  => $this->request->getGet(),
            'activeFilters' => [
                'search' => $search,
                'sort'   => $sort,
            ],
            'sort'         => $sort,
        ];

        return $this->render('admin/tags/index', $data);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            $rules = [
                'name' => 'required|min_length[2]|max_length[50]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                ];

                if ($this->tagModel->insert($data)) {
                    $this->setFlash('success', 'Tag created successfully');
                    return redirect()->to('/admin/tags');
                }

                $this->setFlash('error', 'Failed to create tag');
            }
        }

        $data = [
            'title' => 'Create Tag',
            'validation' => $this->validator,
        ];

        return $this->render('admin/tags/create', $data);
    }

    public function edit($id)
    {
        $tag = $this->tagModel->find($id);

        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {
            $rules = [
                'name' => 'required|min_length[2]|max_length[50]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                ];

                if ($this->tagModel->update($id, $data)) {
                    $this->setFlash('success', 'Tag updated successfully');
                    return redirect()->to('/admin/tags');
                }

                $this->setFlash('error', 'Failed to update tag');
            }
        }

        $data = [
            'title' => 'Edit Tag',
            'tag' => $tag,
            'validation' => $this->validator,
        ];

        return $this->render('admin/tags/edit', $data);
    }

    public function delete($id)
    {
        if ($this->tagModel->delete($id)) {
            $this->setFlash('success', 'Tag deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete tag');
        }

        return redirect()->to('/admin/tags');
    }
}