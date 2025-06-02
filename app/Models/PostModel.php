<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'title',
        'slug',
        'description',
        'content',
        'in_short',
        'thumbnail',
        'category_id',
        'tags',
        'status',
        'views',
        'is_featured',
        'published_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Recommended DB Indexes (add in migration or DB):
    // posts.category_id, posts.user_id, posts.slug, posts.published_at, posts.status
    // categories.slug, users.id

    // Only select needed fields for cards/lists by default
    protected $defaultFields = 'posts.id, posts.title, posts.slug, posts.description, posts.thumbnail, posts.published_at, posts.is_featured, posts.views, posts.status, categories.name as category_name, categories.slug as category_slug, posts.user_id, users.name as author_name, users.username as author_username, users.role as author_role, users.avatar as author_avatar';

    protected $detailedFields = 'posts.id, posts.title, posts.slug, posts.description, posts.content, posts.in_short, posts.thumbnail, posts.published_at, posts.is_featured, posts.views, posts.status, posts.category_id, posts.tags, categories.name as category_name, categories.slug as category_slug, posts.user_id, users.name as author_name, users.username as author_username, users.gender as author_gender, users.role as author_role, users.is_verified as author_is_verified, users.avatar as author_avatar';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /*
     * Get user
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function user() {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    /*
     * Get category
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function category() {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    /*
     * Get tags
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function tags() {
        return $this->belongsToMany(TagModel::class, 'post_tags', 'post_id', 'tag_id');
    }

    /*
     * Get photos
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function photos() {
        return $this->hasMany(PostPhotoModel::class, 'post_id', 'id');
    }

    /*
     * Select custom or default fields
     * @param string $fields
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function fields($fields = null) {
        if ($fields) {
            return $this->select($fields);
        }
        return $this->select($this->defaultFields);
    }

    public function detailedFields() {
        return $this->fields($this->detailedFields);
    }

    /*
     * Efficient join for category and user
     * @param string $fields
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function withCategoryAndUser($fields = null) {
        return $this->fields($fields)
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left');
    }

    /*
     * Exclude posts by IDs
     * @param array $ids
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function exclude($ids) {
        if (is_array($ids) && count($ids) > 0) {
            return $this->whereNotIn('posts.id', $ids);
        }
        return $this;
    }

    /*
     * Get posts by views
     * @param bool $mostViewed
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function viewed($mostViewed = true) {
        return $this->orderBy('posts.views', $mostViewed ? 'DESC' : 'ASC');
    }

    /*
     * Get featured posts
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function featured() {
        return $this->published()->where('posts.is_featured', 1);
    }

    /*
     * Get posts by category slug
     * @param string $categorySlug
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function categoryPosts($categorySlug) {
        return $this->published()->where('categories.slug', $categorySlug);
    }

    /*
     * Get posts by author ID
     * @param int $authorId
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function authorPosts($authorId) {
        return $this->published()->where('posts.user_id', $authorId);
    }

    /*
     * Get related posts (by category, excluding a post)
     * @param int $categoryId
     * @param int $excludeId
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function related($categoryId, $excludeId = null) {
        return $this->where('posts.category_id', $categoryId)
            ->exclude($excludeId)
            ->published();
    }

    /*
     * Get posts by tag slug
     * @param string $tagSlug
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function tagPosts($tagSlug) {
        return $this->withCategoryAndUser()
            ->join('post_tags', 'post_tags.post_id = posts.id')
            ->join('tags', 'tags.id = post_tags.tag_id')
            ->where('tags.slug', $tagSlug)
            ->where('posts.status', 'published')
            ->where('posts.published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('posts.published_at', 'DESC');
    }

    /*
     * Get published posts
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function published() {
        return $this->withCategoryAndUser()
            ->where('posts.status', 'published')
            ->where('posts.published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('posts.published_at', 'DESC');
    }

    /*
     * Get draft posts
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function draft() {
        return $this->withCategoryAndUser()
            ->where('posts.status', 'draft');
    }

    /*
     * Get posts
     * @param int $limit
     * @param int $offset
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function posts($limit = 10, $offset = 0) {
        return $this->limit($limit, $offset)->find();
    }

    /*
     * Increment views
     * @param int $id
     * @param int $count
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function incrementViews($id, $count = 1) {
        return $this->set('views', 'views + ' . $count, false)
            ->where('id', $id)
            ->update();
    }
}
