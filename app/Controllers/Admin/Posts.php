<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\TagModel;

class Posts extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;

    public function __construct()
    {
        $this->postModel     = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel      = new TagModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Posts',
            'posts' => $this->postModel->orderBy('created_at', 'DESC')->paginate(10),
            'pager' => $this->postModel->pager,
        ];

        return $this->render('admin/posts/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[255]',
                'content'     => 'required',
                'category_id' => 'required|numeric',
                'status'      => 'required|in_list[draft,published]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'user_id'      => session()->get('user_id'),
                    'title'        => $this->request->getPost('title'),
                    'slug'         => url_title($this->request->getPost('title'), '-', true),
                    'content'      => $this->request->getPost('content'),
                    'category_id'  => $this->request->getPost('category_id'),
                    'status'       => $this->request->getPost('status'),
                    'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
                ];

                if ($this->postModel->insert($data)) {
                    $this->setFlash('success', 'Post created successfully');
                    return redirect()->to('/admin/posts');
                }

                $this->setFlash('error', 'Failed to create post');
            }
        }

        $data = [
            'title'      => 'Create Post',
            'categories' => $this->categoryModel->findAll(),
            'tags'       => $this->tagModel->findAll(),
            'validation' => $this->validator,
        ];

        return $this->render('admin/posts/create', $data);
    }

    public function edit($id)
    {
        $post = $this->postModel->find($id);

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[255]',
                'content'     => 'required',
                'category_id' => 'required|numeric',
                'status'      => 'required|in_list[draft,published]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'title'        => $this->request->getPost('title'),
                    'slug'         => url_title($this->request->getPost('title'), '-', true),
                    'content'      => $this->request->getPost('content'),
                    'category_id'  => $this->request->getPost('category_id'),
                    'status'       => $this->request->getPost('status'),
                    'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
                ];

                if ($this->postModel->update($id, $data)) {
                    $this->setFlash('success', 'Post updated successfully');
                    return redirect()->to('/admin/posts');
                }

                $this->setFlash('error', 'Failed to update post');
            }
        }

        $data = [
            'title'      => 'Edit Post',
            'post'       => $post,
            'categories' => $this->categoryModel->findAll(),
            'tags'       => $this->tagModel->findAll(),
            'validation' => $this->validator,
        ];

        return $this->render('admin/posts/edit', $data);
    }

    public function delete($id)
    {
        if ($this->postModel->delete($id)) {
            $this->setFlash('success', 'Post deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete post');
        }

        return redirect()->to('/admin/posts');
    }
}
