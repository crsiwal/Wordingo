<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model {
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug', 'description'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Relationships
    public function posts() {
        return $this->hasMany(PostModel::class, 'category_id', 'id');
    }

    // Scopes
    public function withPostCount() {
        return $this->select('categories.*, COUNT(posts.id) as post_count')
            ->join('posts', 'posts.category_id = categories.id', 'left')
            ->groupBy('categories.id');
    }
}
