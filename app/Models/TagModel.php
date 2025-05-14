<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table            = 'tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug'];

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
    public function posts()
    {
        return $this->belongsToMany(PostModel::class, 'post_tags', 'tag_id', 'post_id');
    }

    // Scopes
    public function withPostCount()
    {
        return $this->select('tags.*, COUNT(post_tags.post_id) as post_count')
                    ->join('post_tags', 'post_tags.tag_id = tags.id', 'left')
                    ->groupBy('tags.id');
    }
} 