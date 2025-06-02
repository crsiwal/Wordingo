<?php

if (!function_exists('site_name')) {
    /**
     * Get the site name from config
     *
     * @return string
     */
    function site_name(): string {
        return config('Site')->siteName;
    }
}

if (!function_exists('site_support_email')) {
    function site_support_email(): string {
        return config('Site')->supportEmail;
    }
}
