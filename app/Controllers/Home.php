<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostTagModel;
use App\Models\UserModel;

class Home extends BaseController {
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $postTagModel;
    protected $userModel;

    /**
     * @var int
     */
    protected $mostViewedCount;

    /**
     * @var int
     */
    protected $latestCount;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
        $this->postTagModel = new PostTagModel();
        $this->userModel = new UserModel();
        $this->mostViewedCount = 7;
        $this->latestCount = 18;
    }

    public function index() {
        $categoryPostsData = [
            'before_category_tabs' => [
                'title' => 'Top stories',
                'layout' => 'VerticalList',
                'posts' => $this->postModel->featured()->posts(8),
            ],
            'after_category_tabs' => [
                'title' => 'Latest Posts',
                'layout' => 'CarouselCompact',
                'posts' => $this->postModel->published()->paginate(18),
            ],
            'before_featured_carousel' => [
                'title' => 'Featured Posts',
                'layout' => 'CarouselGrid',
                'posts' => $this->postModel->featured()->posts(8),
            ],
        ];

        $data = [
            'title' => 'Home',
            'featuredPosts' => $this->postModel->featured()->posts(8),
            'latestPosts' => $this->postModel->featured()->posts(8),
            'categories' => $this->categoryModel->withPostCount()->findAll(),
            'categoryPostsData' => $categoryPostsData,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/index', $data);
    }

    /* Recent Posts */
    public function recentPosts() {
        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get most viewed posts
            $mostViewedPosts = $this->postModel->published()->viewed(true)->posts($this->mostViewedCount);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'title' => 'Most Viewed Articles',
            ];
        }

        // Get latest posts with pagination with 18 posts per page with 'recent' segment
        $recentPosts = $this->postModel->exclude($excludedIds)->published()->paginate($this->latestCount);

        $posts["latest"] = [
            'posts' => $recentPosts,
            'layout' => 'StandardGrid',
        ];

        $data = [
            'title' => 'Recent Posts',
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/recentPosts', $data);
    }

    public function search() {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/');
        }

        $searchedPosts = $this->postModel->published()
            ->groupStart()
            ->like('posts.title', $query)
            ->orLike('posts.content', $query)
            ->groupEnd()
            ->posts($this->latestCount);

        $data = [
            'title' => "Search: {$query}",
            'query' => $query,
            'posts' => [
                "search" => [
                    'posts' => $searchedPosts,
                    'layout' => 'LeftToRightGrid',
                    'title' => 'Search Results: ' . $query,
                ]
            ],
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/search', $data);
    }

    public function category($slug) {
        $category = $this->categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get top posts
            $mostViewedPosts = $this->postModel->categoryPosts($slug)->viewed(true)->posts($this->mostViewedCount);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'title' => 'Top stories',
            ];
        }

        // Get latest posts
        $latestPosts = $this->postModel->categoryPosts($slug)->exclude($excludedIds)->paginate($this->latestCount);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'title' => 'Recently Posted',
        ];

        $data = [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/category', $data);
    }

    public function tag($slug) {
        $tag = $this->tagModel->where('slug', $slug)->first();

        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;
        $postIds = $this->postTagModel->where('tag_id', $tag['id'])->findColumn('post_id');
        if ($page == 1) {
            // Get most viewed published post for this tag
            $mostViewedPosts = $this->postModel
                ->viewed(true)
                ->published()
                ->whereIn('posts.id', $postIds)
                ->posts($this->mostViewedCount);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'title' => 'Top stories',
            ];
        }

        // Get latest published posts for this tag
        $latestPosts = $this->postModel
            ->whereIn('posts.id', $postIds)
            ->exclude($excludedIds)
            ->published()
            ->paginate($this->latestCount);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'title' => 'Recently Posted',
        ];

        $data = [
            'title' => $tag['name'],
            'tag' => $tag,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/tags', $data);
    }

    public function author($username) {
        $author = $this->userModel->where('username', $username)->first();

        if (!$author) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $posts = [];
        $excludedIds = [];
        $page = $this->request->getGet('page') ?? 1;

        if ($page == 1) {
            // Get top posts
            $mostViewedPosts = $this->postModel->authorPosts($author['id'])->viewed(true)->posts($this->mostViewedCount);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'title' => 'Top stories',
            ];
        }

        // Get latest posts
        $latestPosts = $this->postModel->authorPosts($author['id'])->exclude($excludedIds)->paginate($this->latestCount);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'title' => 'Recently Posted',
        ];

        $data = [
            'title' => $author['name'],
            'author' => $author,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/author', $data);
    }

    public function post($slug) {
        $post = $this->postModel->published()
            ->detailedFields()
            ->where('posts.slug', $slug)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $post['tags'] = $post['tags'] ? json_decode($post['tags'], true) : [];

        // Increment view count
        $this->postModel->incrementViews($post['id']);

        // Get related posts
        $relatedPosts = $this->postModel->related($post['category_id'], $post['id'])->posts(30);

        $data = [
            'title' => $post['title'],
            'description' => !empty($post['description']) ? $post['description'] : substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];

        return $this->render('visitor/post', $data);
    }
}
