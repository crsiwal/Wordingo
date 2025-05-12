<?php
namespace App\Models;

use CodeIgniter\Model;

class PostTagModel extends Model
{
    protected $table            = 'post_tags';
    protected $primaryKey       = ['post_id', 'tag_id'];
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['post_id', 'tag_id', 'created_at'];
    public $useTimestamps       = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = false;
}
