<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class EmailSettings extends BaseConfig
{
    /**
     * System email settings - these can be overridden in .env file
     */
    public $fromEmail = 'noreply@wordiqo.com';
    public $fromName = 'Wordiqo';
    public $adminEmail = 'admin@wordiqo.com';
    
    /**
     * Email templates
     */
    public $templates = [
        'welcome'           => 'emailer/templates/welcome',
        'admin_notification' => 'emailer/templates/admin_notification',
        'password_reset'    => 'emailer/templates/password_reset',
    ];
    
    /**
     * Other email settings
     */
    public $expirationTime = 30; // Password reset link expiration time in minutes
    
    public function __construct()
    {
        parent::__construct();
        
        // Override with environment values if set
        $this->fromEmail = getenv('email.fromEmail') ?: $this->fromEmail;
        $this->fromName = getenv('email.fromName') ?: $this->fromName;
        $this->adminEmail = getenv('email.adminEmail') ?: $this->adminEmail;
    }
} 