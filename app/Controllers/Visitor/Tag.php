<?php

namespace App\Controllers\Visitor;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\TagModel;
use App\Models\PostTagModel;

class Tag extends BaseController {
    protected $postModel;
    protected $tagModel;
    protected $postTagModel;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->tagModel = new TagModel();
        $this->postTagModel = new PostTagModel();
    }

    public function index($slug) {
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
                ->posts(1);
            $excludedIds = array_column($mostViewedPosts, 'id');
            $posts["mostViewed"] = [
                'posts' => $mostViewedPosts,
                'layout' => 'LeftToRightGrid',
                'label' => 'Top Stories',
            ];
        }

        // Get latest published posts for this tag
        $latestPosts = $this->postModel
            ->whereIn('posts.id', $postIds)
            ->exclude($excludedIds)
            ->published()
            ->paginate(18);
        $posts["latest"] = [
            'posts' => $latestPosts,
            'layout' => 'StandardGrid',
            'label' => 'Recently Posted',
        ];

        $data = [
            'title' => $tag['name'],
            'tag' => $tag,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
        ];

        return $this->render('visitor/tags', $data);
    }
}
