<?php

namespace App\Libraries;

use Config\EmailSettings;

class EmailService
{
    protected $email;
    protected $settings;
    
    public function __construct()
    {
        $this->email = \Config\Services::email();
        $this->settings = new EmailSettings();
        
        // Set common email settings
        $this->email->setFrom($this->settings->fromEmail, $this->settings->fromName);
    }
    
    /**
     * Send a welcome email to a newly registered user
     *
     * @param array $userData User data including name, email, username, role
     * @return bool Whether the email was sent successfully
     */
    public function sendWelcomeEmail(array $userData): bool
    {
        $data = [
            'name'     => $userData['name'],
            'username' => $userData['username'],
            'email'    => $userData['email'],
            'role'     => $userData['role'],
        ];
        
        $message = view($this->settings->templates['welcome'], $data);
        
        $this->email->setTo($userData['email']);
        $this->email->setSubject('Welcome to Wordiqo!');
        $this->email->setMessage($message);
        $this->email->setMailType('html');
        
        return $this->email->send();
    }
    
    /**
     * Send a notification email to administrators when a new user registers
     *
     * @param array $userData User data including name, email, username, role
     * @param string|null $adminEmail Override admin email address
     * @return bool Whether the email was sent successfully
     */
    public function sendAdminNotification(array $userData, string $adminEmail = null): bool
    {
        $data = [
            'name'       => $userData['name'],
            'username'   => $userData['username'],
            'email'      => $userData['email'],
            'role'       => $userData['role'],
            'created_at' => date('Y-m-d H:i:s', strtotime($userData['created_at'] ?? 'now')),
        ];
        
        $message = view($this->settings->templates['admin_notification'], $data);
        
        $this->email->setTo($adminEmail ?? $this->settings->adminEmail);
        $this->email->setSubject('New User Registration - Wordiqo');
        $this->email->setMessage($message);
        $this->email->setMailType('html');
        
        return $this->email->send();
    }
    
    /**
     * Send a password reset email to a user
     *
     * @param array $userData User data including name, email, reset_token
     * @return bool Whether the email was sent successfully
     */
    public function sendPasswordResetEmail(array $userData): bool
    {
        $resetLink = base_url('reset-password/' . $userData['reset_token']);
        
        $data = [
            'name'       => $userData['name'],
            'email'      => $userData['email'],
            'reset_link' => $resetLink,
        ];
        
        $message = view($this->settings->templates['password_reset'], $data);
        
        $this->email->setTo($userData['email']);
        $this->email->setSubject('Password Reset - Wordiqo');
        $this->email->setMessage($message);
        $this->email->setMailType('html');
        
        return $this->email->send();
    }
    
    /**
     * Send a general notification email
     *
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $message Email message
     * @param bool $isHtml Whether the message is HTML
     * @return bool Whether the email was sent successfully
     */
    public function sendEmail(string $to, string $subject, string $message, bool $isHtml = false): bool
    {
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        if ($isHtml) {
            $this->email->setMailType('html');
        }
        
        return $this->email->send();
    }
} 