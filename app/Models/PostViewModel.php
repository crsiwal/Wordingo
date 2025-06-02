<?php

namespace App\Models;

use CodeIgniter\Model;

class PostViewModel extends Model {
    protected $table = 'post_views';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'post_id',
        'user_id',
        'ip_address',
        'user_agent',
        'referrer',
        'device_type',
        'browser',
        'os',
        'country',
        'region',
        'city',
        'session_id',
        'view_duration',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    /**
     * Get views for a specific post
     */
    public function getPostViews(int $postId, string $period = '24h'): array {
        $timeWindow = $this->getTimeWindow($period);

        return $this->where('post_id', $postId)
            ->where('created_at >', $timeWindow)
            ->findAll();
    }

    /**
     * Get unique views for a post
     */
    public function getUniqueViews(int $postId, string $period = '24h'): int {
        $timeWindow = $this->getTimeWindow($period);

        return $this->where('post_id', $postId)
            ->where('created_at >', $timeWindow)
            ->groupBy('session_id')
            ->countAllResults();
    }

    /**
     * Get views by device type
     */
    public function getViewsByDevice(int $postId, string $period = '24h'): array {
        $timeWindow = $this->getTimeWindow($period);

        return $this->select('device_type, COUNT(*) as count')
            ->where('post_id', $postId)
            ->where('created_at >', $timeWindow)
            ->groupBy('device_type')
            ->findAll();
    }

    /**
     * Get time window for period
     */
    protected function getTimeWindow(string $period): string {
        $intervals = [
            '24h' => '24 HOUR',
            '7d' => '7 DAY',
            '30d' => '30 DAY',
            '1y' => '1 YEAR'
        ];

        $interval = $intervals[$period] ?? '24 HOUR';
        return date('Y-m-d H:i:s', strtotime("-{$interval}"));
    }
}