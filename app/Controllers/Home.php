<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController {
    protected $postModel;
    protected $categoryModel;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        // Fetch featured posts with all required fields for the card
        $featuredPosts = $this->postModel
            ->select('posts.*, categories.name as category_name, users.name as author_name, users.avatar as author_avatar, users.role as author_role')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.is_featured', 1)
            ->orderBy('posts.published_at', 'DESC')
            ->findAll(8);

        // Fetch latest posts with all required fields for the card
        $latestPosts = $this->postModel
            ->select('posts.*, categories.name as category_name, users.name as author_name, users.avatar as author_avatar, users.role as author_role')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->orderBy('posts.published_at', 'DESC')
            ->findAll(6);

        $categories = $this->categoryModel->withPostCount()->findAll();

        $data = [
            'title' => 'Home',
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
        ];

        return $this->render('visitor/index', $data);
    }

    public function search() {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/');
        }

        $data = [
            'title' => "Search: {$query}",
            'query' => $query,
            'posts' => $this->postModel->published()
                ->like('title', $query)
                ->orLike('content', $query)
                ->orderBy('published_at', 'DESC')
                ->paginate(10),
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/search', $data);
    }

    public function category($slug) {
        $category = $this->categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $this->postModel->published()
                ->where('category_id', $category['id'])
                ->orderBy('published_at', 'DESC')
                ->paginate(10),
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/category', $data);
    }

    public function post($slug) {
        $post = $this->postModel->published()
            ->where('slug', $slug)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment view count
        $this->postModel->incrementViews($post['id']);

        // Get related posts
        $relatedPosts = $this->postModel->published()
            ->where('category_id', $post['category_id'])
            ->where('id !=', $post['id'])
            ->orderBy('published_at', 'DESC')
            ->limit(3)
            ->find();

        $data = [
            'title' => $post['title'],
            'description' => !empty($post['description']) ? $post['description'] : substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];

        return $this->render('visitor/post', $data);
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'Learn more about our blog and mission',
        ];

        return $this->render('visitor/about', $data);
    }

    public function contact() {
        if ($this->request->is('post')) {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email',
                'message' => 'required|min_length[10]',
            ];

            if ($this->validate($rules)) {
                // Send email
                $email = \Config\Services::email();
                $email->setTo(getenv('admin_email'));
                $email->setFrom($this->request->getPost('email'), $this->request->getPost('name'));
                $email->setSubject('Contact Form Submission');
                $email->setMessage($this->request->getPost('message'));
                $email->send();

                $this->setFlash('success', 'Your message has been sent. We will get back to you soon.');
                return redirect()->to('/contact');
            }
        }

        $data = [
            'title' => 'Contact Us',
            'description' => 'Get in touch with us',
            'validation' => $this->validator,
        ];

        return $this->render('visitor/contact', $data);
    }
}
