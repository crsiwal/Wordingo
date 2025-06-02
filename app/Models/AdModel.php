<?php

namespace App\Models;

use CodeIgniter\Model;

class AdModel extends Model {
    protected $table            = 'ads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'user_id',
        'title',
        'slot_id',
        'category_id',
        'asset_url',
        'target_url',
        'priority',
        'views',
        'clicks',
        'max_views',
        'max_clicks',
        'start_time',
        'end_time',
        'is_active'
    ];

    protected $validationRules = [];

    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title must be less than 150 characters long',
        ],
        'slot_id' => [
            'required' => 'Slot is required',
            'integer' => 'Slot must be an integer',
        ],
        'category_id' => [
            'required' => 'Category is required',
            'integer' => 'Category must be an integer',
        ],
        'asset_url' => [
            'required' => 'Asset URL is required',
            'valid_url' => 'Invalid asset URL',
        ],
        'target_url' => [
            'required' => 'Target URL is required',
            'valid_url' => 'Invalid target URL',
        ],
        'priority' => [
            'required' => 'Priority is required',
            'integer' => 'Priority must be an integer',
            'greater_than' => 'Priority must be greater than 0',
        ],
        'start_time' => [
            'required' => 'Start time is required',
            'valid_date' => 'Invalid start time',
        ],
        'end_time' => [
            'required' => 'End time is required',
            'valid_date' => 'Invalid end time',
        ],
        'is_active' => [
            'required' => 'Active status is required',
            'boolean' => 'Active status must be a boolean',
        ],
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
