<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
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
        'content',
        'thumbnail',
        'category_id',
        'status',
        'views',
        'published_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id'     => 'required|numeric',
        'title'       => 'required|min_length[3]|max_length[255]',
        'slug'        => 'required|alpha_dash|is_unique[posts.slug,id,{id}]',
        'content'     => 'required',
        'category_id' => 'required|numeric',
        'status'      => 'required|in_list[draft,published]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Relationships
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function photos()
    {
        return $this->hasMany(PostPhotoModel::class, 'post_id', 'id');
    }

    // Scopes
    public function published()
    {
        return $this->where('status', 'published')
                    ->where('published_at <=', date('Y-m-d H:i:s'));
    }

    public function draft()
    {
        return $this->where('status', 'draft');
    }

    public function incrementViews($id)
    {
        return $this->set('views', 'views + 1', false)
                    ->where('id', $id)
                    ->update();
    }
} 