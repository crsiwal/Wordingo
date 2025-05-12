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
                    // Handle tags (comma-separated string)
                    $tagsString = $this->request->getPost('tags');
                    $this->postTagModel->where('post_id', $id)->delete(); // Remove old tags
                    if ($tagsString) {
                        $tagsArr = array_filter(array_map('trim', explode(',', $tagsString)));
                        // 1. Find which tags are new
                        $existingTags     = $this->tagModel->whereIn('name', $tagsArr)->findAll();
                        $existingTagNames = array_column($existingTags, 'name');
                        $existingTagIds   = array_column($existingTags, 'id', 'name');
                        $newTagNames      = array_diff($tagsArr, $existingTagNames);
                        // 2. Bulk insert new tags
                        $newTagData = [];
                        foreach ($newTagNames as $tagName) {
                            $newTagData[] = [
                                'name' => $tagName,
                                'slug' => url_title($tagName, '-', true),
                            ];
                        }
                        if ($newTagData) {
                            $this->tagModel->insertBatch($newTagData);
                            // Get all tags again (assume names are unique)
                            $allTags = $this->tagModel->whereIn('name', $tagsArr)->findAll();
                            $tagIds  = array_column($allTags, 'id', 'name');
                        } else {
                            $tagIds = $existingTagIds;
                        }
                        // 3. Prepare post_tags data
                        $postTagData = [];
                        foreach ($tagsArr as $tagName) {
                            if (isset($tagIds[$tagName])) {
                                $postTagData[] = [
                                    'post_id'    => $id,
                                    'tag_id'     => $tagIds[$tagName],
                                    'created_at' => date('Y-m-d H:i:s'),
                                ];
                            }
                        }
                        if ($postTagData) {
                            $this->postTagModel->insertBatch($postTagData);
                        }
                    }
                    $this->setFlash('success', 'Post updated successfully');
                    return redirect()->to('/admin/posts/edit/' . $id);
                }
                $this->setFlash('error', 'Failed to update post');
            }
        }

        // Get tags for this post
        $postTags = $this->postTagModel->where('post_id', $id)->findAll();
        $tagIds   = array_column($postTags, 'tag_id');
        $tagNames = [];
        if ($tagIds) {
            $tagNames = array_column($this->tagModel->whereIn('id', $tagIds)->findAll(), 'name');
        }

        $data = [
            'title'      => 'Edit Post',
            'post'       => $post,
            'categories' => $this->categoryModel->findAll(),
            'tags'       => $this->tagModel->findAll(),
            'postTags'   => implode(',', $tagNames),
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
}
