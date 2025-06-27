<?php

namespace App\Controllers\Visitor;

use CodeIgniter\Controller;
use App\Models\PostViewModel;
use App\Models\PostModel;
use CodeIgniter\HTTP\ResponseInterface;

class PostTracker extends Controller {
    protected $postViewModel;
    protected $postModel;

    public function __construct() {
        $this->postViewModel = new PostViewModel();
        $this->postModel = new PostModel();
    }

    /**
     * Track a post view via AJAX
     */
    public function track() {
        $postId = $this->request->getGet('post_id');
        $ip = $this->request->getGet('ip');
        $country = $this->request->getGet('country');
        $region = $this->request->getGet('region');
        $city = $this->request->getGet('city');
        $view_duration = $this->request->getGet('view_duration') ?? 0;

        if (!$postId) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $data = [
            'post_id' => $postId,
            'user_id' => session()->get('user_id'),
            'ip_address' => $ip ?? $this->request->getIPAddress(),
            'country' => $country,
            'region' => $region,
            'city' => $city,
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'referrer' => $this->request->getHeaderLine('referer'),
            'session_id' => session_id(),
            'view_duration' => $view_duration,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Add device and browser info
        $userAgent = $this->request->getUserAgent();
        $data['device_type'] = $this->getDeviceType($userAgent);
        $data['browser'] = $userAgent->getBrowser();
        $data['os'] = $userAgent->getPlatform();

        // Save the view data
        if ($this->postViewModel->insert($data)) {

            if ($view_duration == 0 && !in_array($data['device_type'], ['bot'])) {
                // Update post view count
                $this->postModel->where('id', $postId)
                    ->set('views', 'views + 1', false)
                    ->update();
            }
        }

        // Return 204 No Content
        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT)
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache');
    }

    /**
     * Determine device type from user agent
     */
    protected function getDeviceType(): string {
        $userAgent = $this->request->getUserAgent();
        $agent = strtolower($userAgent->getAgentString());

        // Check for bots first
        if ($userAgent->isRobot()) {
            return 'bot';
        }

        // Check for tablets
        $tabletKeywords = ['ipad', 'tablet', 'kindle', 'playbook', 'silk', 'gt-p', 'sm-t'];
        foreach ($tabletKeywords as $keyword) {
            if (strpos($agent, $keyword) !== false) {
                return 'tablet';
            }
        }

        // Check for mobile devices
        if ($userAgent->isMobile()) {
            return 'mobile';
        }

        // Check for desktop browsers
        $desktopKeywords = ['windows', 'macintosh', 'linux', 'x11', 'chrome', 'firefox', 'safari', 'opera'];
        foreach ($desktopKeywords as $keyword) {
            if (strpos($agent, $keyword) !== false) {
                return 'desktop';
            }
        }

        // Return unknown if no specific device type is detected
        return 'unknown';
    }
}
