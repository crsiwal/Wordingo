<?php

namespace App\Models;

use CodeIgniter\Model;

class AdModel extends Model
{
    protected $table            = 'ads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'title', 'slot_id', 'category_id', 'asset_url', 'target_url',
        'priority', 'views', 'clicks', 'max_views', 'start_time',
        'end_time', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}