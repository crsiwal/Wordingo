<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagModel;

class Tags extends BaseController
{
    protected $tagModel;

    public function __construct()
    {
        $this->tagModel = new TagModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Tags',
            'tags' => $this->tagModel->withPostCount()->findAll(),
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