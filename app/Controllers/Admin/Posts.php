<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\PostTagModel;
use App\Models\TagModel;

class Posts extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $postTagModel;

    public function __construct()
    {
        $this->postModel     = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel      = new TagModel();
        $this->postTagModel  = new PostTagModel();
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
        // Create a blank draft post and redirect to edit
        $data = [
            'user_id' => session()->get('user_id'),
            'status'  => 'draft',
        ];
        $postId = $this->postModel->skipValidation(true)->insert($data, true);
        if ($postId) {
            return redirect()->to('/admin/posts/edit/' . $postId);
        }
        $this->setFlash('error', 'Failed to create new post');
        return redirect()->to('/admin/posts');
    }

    public function edit($id)
    {
        $post = $this->postModel->find($id);

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'      => 'Edit Post',
            'post'       => $post,
            'categories' => $this->categoryModel->findAll(),
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[256]',
                'content'     => 'required',
                'category_id' => 'required|numeric',
                'status'      => 'required|in_list[draft,published]',
            ];

            // Handle tags
            $tagsString = $this->request->getPost('tags');

            // Only validate slug if it's being changed or newly created
            $newSlug = $this->request->getPost('slug');
            if ($newSlug && ($post['slug'] === '' || $post['slug'] !== $newSlug)) {
                $rules['slug'] = 'required|min_length[8]|max_length[256]|is_unique[posts.slug,id,' . $id . ']';
            }

            if ($this->request->getPost('status') === 'published') {
                $rules['published_at'] = 'required|valid_date';
            }

            if ($this->validate($rules)) {
                $content = [
                    'title'        => $this->request->getPost('title'),
                    'content'      => $this->request->getPost('content'),
                    'thumbnail'    => $this->request->getPost('featured_image_url') ?? null,
                    'category_id'  => $this->request->getPost('category_id'),
                    'status'       => $this->request->getPost('status'),
                    'published_at' => $this->request->getPost('published_at') ?? null,
                ];

                // Only update slug if it's changed or newly created
                if ($newSlug && ($post['slug'] === '' || $post['slug'] !== $newSlug)) {
                    $content['slug'] = url_title($newSlug, '-', true);
                }

                try {
                    if ($this->postModel->update($id, $content)) {
                        // Remove all existing tags
                        $this->postTagModel->where('post_id', $id)->delete();
                        // Add new tags
                        if ($tagsString) {
                            $this->handleTags($id, $tagsString);
                        }
                        $this->setFlash('success', 'Post updated successfully');
                        return redirect()->to('/admin/posts/edit/' . $id);
                    } else {
                        // Validation failed
                        return redirect()->back()->withInput()->with('error', 'Validation failed.');
                    }
                } catch (\Exception $e) {
                    // Check for specific error (e.g., Data too long)
                    if (strpos($e->getMessage(), 'Data too long') !== false) {
                        return redirect()->back()->withInput()->with('error', 'The post content is too long. Please reduce the size.');
                    }
                    // Generic error
                    return redirect()->back()->withInput()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
                }
            } else {
                $this->setFlash('error', $this->validator->listErrors());
            }

            // Update form data with submitted values
            $data['post'] = array_merge($data['post'], [
                'title'        => $this->request->getPost('title'),
                'slug'         => $newSlug,
                'content'      => $this->request->getPost('content'),
                'thumbnail'    => $this->request->getPost('featured_image'),
                'category_id'  => $this->request->getPost('category_id'),
                'status'       => $this->request->getPost('status'),
                'published_at' => $this->request->getPost('published_at'),
                'tags'         => $tagsString,
            ]);
        } else {
            // Get tags for this post
            $data['post']['tags'] = $this->getPostTags($id);
        }

        $data['validation'] = $this->validator;
        return $this->render('admin/posts/edit', $data);
    }

    /**
     * Delete a post
     */
    public function delete($id)
    {
        // Check if post exists and user has permission
        $post = $this->postModel->find($id);
        if (! $post) {
            $this->setFlash('error', 'Post not found');
            return redirect()->to('/admin/posts');
        }

        // Allow both admins and post owners to delete
        $userId   = session()->get('user_id');
        $userRole = session()->get('role');
        $isAdmin  = ($userRole == 'admin');

        if (! $isAdmin && $post['user_id'] != $userId) {
            $this->setFlash('error', 'You do not have permission to delete this post');
            return redirect()->to('/admin/posts');
        }

        // Delete post tags first
        $this->postTagModel->where('post_id', $id)->delete();

        // Now delete the post
        if ($this->postModel->delete($id)) {
            $this->setFlash('success', 'Post deleted successfully');
        } else {
            $this->setFlash('error', 'Failed to delete post');
        }

        return redirect()->to('/admin/posts');
    }

    /**
     * Validate if a slug is unique
     */
    public function validateSlug()
    {
        $slug   = $this->request->getPost('slug');
        $postId = $this->request->getPost('post_id');

        if (! $slug) {
            return $this->response->setJSON(['valid' => false, 'message' => 'Slug is required']);
        }

        if (strlen($slug) < 8) {
            return $this->response->setJSON(['valid' => false, 'message' => 'Slug must be at least 8 characters long']);
        }

        if (strlen($slug) > 256) {
            return $this->response->setJSON(['valid' => false, 'message' => 'Slug cannot be longer than 256 characters']);
        }

        // Check if slug exists
        $builder = $this->postModel->where('slug', $slug);

        // If editing, exclude current post
        if ($postId) {
            $builder->where('id !=', $postId);
        }

        $exists = $builder->first();

        return $this->response->setJSON([
            'valid'   => ! $exists,
            'message' => $exists ? 'This slug is already taken' : 'Slug is available',
        ]);
    }

    /**
     * Handle tag operations for a post
     */
    private function handleTags($postId, $tagsString)
    {
        $tagsArr = array_filter(array_map('trim', explode(',', $tagsString)));
        if (empty($tagsArr)) {
            return;
        }

        // Get existing tags
        $existingTags     = $this->tagModel->whereIn('name', $tagsArr)->findAll();
        $existingTagNames = array_column($existingTags, 'name');
        $tagIds           = array_column($existingTags, 'id', 'slug');

        // Find new tags
        $newTagNames = array_diff($tagsArr, $existingTagNames);

        // Insert new tags
        if (! empty($newTagNames)) {
            $newTagData = array_map(function ($name) {
                return [
                    'name'       => $name,
                    'slug'       => url_title($name, '-', true),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }, $newTagNames);

            $this->tagModel->insertBatch($newTagData);

            // Get all tags including newly inserted ones
            $allTags = $this->tagModel->whereIn('name', $tagsArr)->findAll();
            $tagIds  = array_column($allTags, 'id', 'slug');
        }

        // Create post-tag relationships
        $postTagData = [];
        foreach ($tagIds as $tagSlug => $tagId) {
            if ($tagId) {
                $postTagData[] = [
                    'post_id'    => (int) $postId,
                    'tag_id'     => (int) $tagId,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        if (is_array($postTagData) && count($postTagData) > 0) {
            $inserted = $this->postTagModel->insertBatch($postTagData);
            if ($inserted) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get tags for a post
     */
    private function getPostTags($postId)
    {
        $postTags = $this->postTagModel->where('post_id', $postId)->findAll();
        if (empty($postTags)) {
            return '';
        }

        $tagIds   = array_column($postTags, 'tag_id');
        $tagNames = array_column($this->tagModel->whereIn('id', $tagIds)->findAll(), 'name');
        return implode(',', $tagNames);
    }
}
