<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\PostTagModel;
use App\Models\TagModel;
use App\Models\UserModel;

class Posts extends BaseController {
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $postTagModel;
    protected $userModel;
    protected $userRole;
    protected $userId;
    protected $showRecords = 50;

    public function __construct() {
        $this->postModel     = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel      = new TagModel();
        $this->postTagModel  = new PostTagModel();
        $this->userModel     = new UserModel();
        $this->userRole      = session()->get('user_role');
        $this->userId        = session()->get('user_id');
    }

    public function index() {
        // Build the base query
        $builder = $this->postModel
            ->select('posts.*, users.name as author_name, users.status as user_status, categories.name as category_name, categories.slug as category_slug')
            ->join('users', 'users.id = posts.user_id')
            ->join('categories', 'categories.id = posts.category_id', 'left'); // Left join to categories table

        // Get query parameters for filtering with shorter names
        $tagSlug = $this->request->getGet('t'); // t for tag
        $categorySlug = $this->request->getGet('c'); // c for category
        $statusFilter = $this->request->getGet('s'); // s for status
        $searchQuery = $this->request->getGet('q'); // q for search query
        $userId = $this->request->getGet('u'); // u for user ID
        $sort = $this->request->getGet('sort');
        $sortOptions = [
            'name_asc' => ['posts.title', 'ASC'],
            'name_desc' => ['posts.title', 'DESC'],
            'created_at' => ['posts.created_at', 'DESC'],
            'updated_at' => ['posts.updated_at', 'DESC'],
            'published_at' => ['posts.published_at', 'DESC'],
        ];
        $orderBy = $sortOptions[$sort] ?? $sortOptions['created_at'];

        // Apply tag filter if provided
        if (!empty($tagSlug)) {
            // Find the tag ID from the slug
            $tag = $this->tagModel->where('slug', $tagSlug)->first();
            if ($tag) {
                // Get all post IDs that have this tag
                $postIds = $this->postTagModel->where('tag_id', $tag['id'])->findColumn('post_id') ?? [];
                if (!empty($postIds)) {
                    $builder->whereIn('posts.id', $postIds);
                } else {
                    // If tag exists but no posts have it, return empty result
                    $builder->where('posts.id', 0); // This will result in no posts found
                }
            }
        }

        // Apply category filter if provided
        if (!empty($categorySlug)) {
            // Find the category from the slug
            $category = $this->categoryModel->where('slug', $categorySlug)->first();
            if ($category) {
                $builder->where('posts.category_id', $category['id']);
            }
        }

        // Apply status filter if provided
        if (!empty($statusFilter) && in_array($statusFilter, ['draft', 'published'])) {
            $builder->where('posts.status', $statusFilter);
        }

        // Apply user filter if provided
        if (!empty($userId) && is_numeric($userId)) {
            $builder->where('posts.user_id', $userId);
            // Get user information for display in active filters
            $filterUser = $this->userModel->find($userId);
        }

        // Apply search query if provided
        if (!empty($searchQuery)) {
            $builder->groupStart()
                ->like('posts.title', $searchQuery)
                ->orLike('posts.content', $searchQuery)
                ->orLike('posts.description', $searchQuery)
                ->groupEnd();
        }

        // Filter posts based on user role
        if ($this->userRole === 'admin') {
            // Admin can see all posts, but exclude posts from banned users
            $builder->where('users.status !=', 'banned');
        } elseif ($this->userRole === 'manager') {
            // Manager can see their own posts and posts from their editors
            $editorIds = $this->userModel->where('parent_id', $this->userId)->findColumn('id') ?? [];
            $userIds = array_merge([$this->userId], $editorIds);
            $builder->whereIn('posts.user_id', $userIds)
                ->where('users.status !=', 'banned');
        } else {
            // Editor can only see their own posts
            $builder->where('posts.user_id', $this->userId)
                ->where('users.status !=', 'banned');
        }

        // Prepare filters for view to show active filters
        $activeFilters = [];
        if (!empty($tagSlug) && isset($tag)) {
            $activeFilters['tag'] = $tag['name'];
        }
        if (!empty($categorySlug) && isset($category)) {
            $activeFilters['category'] = $category['name'];
        }
        if (!empty($statusFilter)) {
            $activeFilters['status'] = ucfirst($statusFilter);
        }
        if (!empty($searchQuery)) {
            $activeFilters['search'] = $searchQuery;
        }
        if (!empty($userId) && isset($filterUser)) {
            $activeFilters['user'] = $filterUser['name'];
        }

        // Get all categories for filter dropdown
        $allCategories = $this->categoryModel->findAll();

        // Get posts with pagination
        $posts = $builder->orderBy($orderBy[0], $orderBy[1])->paginate($this->showRecords);

        // Fetch tags for all displayed posts - we still need this for showing tags on post cards
        $postIds = array_column($posts, 'id');
        $postTagsMap = [];

        if (!empty($postIds)) {
            // Get all post-tag relationships for these posts
            $postTags = $this->postTagModel->whereIn('post_id', $postIds)->findAll();

            if (!empty($postTags)) {
                // Get all tag IDs
                $tagIds = array_column($postTags, 'tag_id');

                // Fetch all tags data at once
                $allPostTags = $this->tagModel->whereIn('id', $tagIds)->findAll();
                $tagsById = array_column($allPostTags, null, 'id'); // Organize by ID for easier lookup

                // Organize tags by post ID
                foreach ($postTags as $pt) {
                    if (isset($tagsById[$pt['tag_id']])) {
                        $postTagsMap[$pt['post_id']][] = $tagsById[$pt['tag_id']];
                    }
                }
            }
        }

        // Get the current query string to pass to the view
        $queryString = $this->request->getUri()->getQuery();

        // Get post counts
        $totalPosts = $this->postModel->countAll();
        $publishedPosts = $this->postModel->where('status', 'published')->countAllResults();
        $draftPosts = $this->postModel->where('status', 'draft')->countAllResults();

        $data = [
            'title' => 'Manage Posts',
            'posts' => $posts,
            'postTags' => $postTagsMap,
            'pager' => $this->postModel->pager,
            'userRole' => $this->userRole,
            'userId' => $this->userId,
            'activeFilters' => $activeFilters,
            'allCategories' => $allCategories,
            'queryString' => $queryString,
            'sort' => $sort,
            'totalPosts' => $totalPosts,
            'publishedPosts' => $publishedPosts,
            'draftPosts' => $draftPosts,
        ];

        return $this->render('admin/posts/index', $data);
    }

    public function create() {
        // Accept category id from query string
        $categoryId = $this->request->getGet('cid');
        $data = [
            'user_id' => $this->userId,
            'status'  => 'draft',
        ];

        if ($categoryId && $this->categoryModel->find($categoryId)) {
            $data['category_id'] = $categoryId;
        }

        $postId = $this->postModel->skipValidation(true)->insert($data, true);

        if ($postId) {
            return redirect()->to('/admin/posts/edit/' . $postId);
        }
        $this->setFlash('error', 'Failed to create new post');
        return redirect()->to('/admin/posts');
    }

    public function edit($id) {
        $post = $this->postModel->find($id);

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check if user has permission to edit this post
        if (!$this->canEditPost($post)) {
            $this->setFlash('error', 'You do not have permission to edit this post');
            return redirect()->to('/admin/posts');
        }

        // Check if post author is banned
        $postAuthor = $this->userModel->find($post['user_id']);
        if ($postAuthor && $postAuthor['status'] === 'banned') {
            $this->setFlash('error', 'Cannot edit posts from banned users');
            return redirect()->to('/admin/posts');
        }

        $data = [
            'title'      => 'Edit Post',
            'post'       => $post,
            'categories' => $this->categoryModel->findAll(),
        ];

        if ($this->request->is('post')) {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[256]',
                'in_short'    => 'permit_empty|max_length[2000]',
                'description' => 'permit_empty|max_length[256]',
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
                    'description'  => $this->request->getPost('description') ?? '',
                    'content'      => $this->request->getPost('content'),
                    'in_short'     => $this->request->getPost('in_short'),
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
                            $postTagSlugs = $this->handleTags($id, $tagsString);
                            if ($postTagSlugs) {
                                $tagsData = [
                                    'tags' => json_encode($postTagSlugs),
                                ];
                                // Update the post with the new tags
                                $this->postModel->update($id, $tagsData);
                            }
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
                'in_short'     => $this->request->getPost('in_short'),
                'content'      => $this->request->getPost('content'),
                'description'  => $this->request->getPost('description'),
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
    public function delete($id) {
        // Check if post exists
        $post = $this->postModel->find($id);
        if (! $post) {
            $this->setFlash('error', 'Post not found');
            return redirect()->to('/admin/posts');
        }

        // Check if user has permission to delete this post
        if (!$this->canEditPost($post)) {
            $this->setFlash('error', 'You do not have permission to delete this post');
            return redirect()->to('/admin/posts');
        }

        // Check if post author is banned
        $postAuthor = $this->userModel->find($post['user_id']);
        if ($postAuthor && $postAuthor['status'] === 'banned') {
            $this->setFlash('error', 'Cannot delete posts from banned users');
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
     * Check if current user can edit a post
     */
    private function canEditPost($post) {
        // Admin can edit any post
        if ($this->userRole === 'admin') {
            return true;
        }

        // Manager can edit own posts and posts from their editors
        if ($this->userRole === 'manager') {
            if ($post['user_id'] == $this->userId) {
                return true; // Own post
            }

            // Check if post belongs to one of their editors
            $editorIds = $this->userModel->where('parent_id', $this->userId)->findColumn('id') ?? [];
            return in_array($post['user_id'], $editorIds);
        }

        // Editor can only edit own posts
        return $post['user_id'] == $this->userId;
    }

    /**
     * Validate if a slug is unique
     */
    public function validateSlug() {
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
    private function handleTags($postId, $tagsString) {
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

        $allTags = [];
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
                if (count($allTags) > 0) {
                    $postTags = [];
                    foreach ($allTags as $tag) {
                        $postTags[] = [
                            "name" => $tag['name'],
                            "slug" => $tag['slug'],
                        ];
                    }
                    return $postTags;
                }
                return [];
            }
        }
        return false;
    }

    /**
     * Get tags for a post
     */
    private function getPostTags($postId) {
        $postTags = $this->postTagModel->where('post_id', $postId)->findAll();
        if (empty($postTags)) {
            return '';
        }

        $tagIds   = array_column($postTags, 'tag_id');
        $tagNames = array_column($this->tagModel->whereIn('id', $tagIds)->findAll(), 'name');
        return implode(',', $tagNames);
    }
}
