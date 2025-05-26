<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;

class Search extends BaseController {
    protected $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    public function index() {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/');
        }

        $searchedPosts = $this->postModel->published()
            ->groupStart()
            ->like('posts.title', $query)
            ->orLike('posts.content', $query)
            ->groupEnd()
            ->paginate(18);

        $data = [
            'title' => "Search: {$query}",
            'query' => $query,
            'posts' => [
                "search" => [
                    'posts' => $searchedPosts,
                    'layout' => 'StandardGrid',
                    'label' => 'Search Results: ' . $query,
                ]
            ],
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/search', $data);
    }
}
