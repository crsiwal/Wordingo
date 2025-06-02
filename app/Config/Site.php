<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Site extends BaseConfig {
    /**
     * --------------------------------------------------------------------------
     * Site Name
     * --------------------------------------------------------------------------
     *
     * The name of your site. This will be used in various places throughout
     * the application.
     */
    public string $siteName = '';

    public function __construct() {
        parent::__construct();

        // Get site name from .env file
        $this->siteName = getenv('app.sitename') ?: 'Wordingo';

        // Get support email from .env file
        $this->supportEmail = getenv('app.support_email') ?: 'support@wordingox.com';
    }
}
