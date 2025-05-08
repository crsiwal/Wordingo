<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
            'featuredPosts' => $this->postModel->published()
                ->orderBy('views', 'DESC')
                ->limit(3)
                ->find(),
            'latestPosts' => $this->postModel->published()
                ->orderBy('published_at', 'DESC')
                ->limit(6)
                ->find(),
            'categories' => $this->categoryModel->withPostCount()->findAll(),
        ];

        return $this->render('home/index', $data);
    }

    public function search()
    {
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

        return $this->render('home/search', $data);
    }

    public function category($slug)
    {
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

        return $this->render('home/category', $data);
    }

    public function post($slug)
    {
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
            'description' => substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];

        return $this->render('home/post', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'Learn more about our blog and mission',
        ];

        return $this->render('home/about', $data);
    }

    public function contact()
    {
        if ($this->request->getMethod() === 'post') {
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

        return $this->render('home/contact', $data);
    }
} 