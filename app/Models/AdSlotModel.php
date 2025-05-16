<?php

namespace App\Models;

use CodeIgniter\Model;

class AdSlotModel extends Model
{
    protected $table            = 'ad_slots';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = ['name', 'slug', 'width', 'height', 'is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 3 characters long',
            'max_length' => 'Name cannot exceed 100 characters'
        ],
        'slug' => [
            'required' => 'Slug is required',
            'min_length' => 'Slug must be at least 3 characters long',
            'max_length' => 'Slug cannot exceed 100 characters',
            'alpha_dash' => 'Slug can only contain alphanumeric characters, underscores, and dashes',
            'is_unique' => 'This slug is already in use'
        ],
        'width' => [
            'required' => 'Width is required',
            'numeric' => 'Width must be a number',
            'greater_than' => 'Width must be greater than 0'
        ],
        'height' => [
            'required' => 'Height is required',
            'numeric' => 'Height must be a number',
            'greater_than' => 'Height must be greater than 0'
        ]
    ];

    protected $skipValidation = false;
}