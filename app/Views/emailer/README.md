# Wordiqo Email System

This directory contains the email templates and configuration for Wordiqo's email functionality.

## System Overview

The email system consists of:

1. **Email Templates**: HTML templates for various types of emails (welcome, reset password, notifications)
2. **EmailService Library**: Service class that manages sending emails
3. **EmailSettings Config**: Configuration file with email settings and template references

## Template Structure

Templates are located in the `templates` directory. Each template is a PHP file that can access variables passed to it from the EmailService.

Current templates:
- `welcome.php`: Welcome email for new user registrations
- `admin_notification.php`: Email sent to admins when new users register
- `password_reset.php`: Email for password reset requests

## Configuration

Email settings are configured in:
1. `.env` file (for environment-specific settings)
2. `app/Config/EmailSettings.php` (for default settings)

Available configuration options:
- `fromEmail`: Sender email address (default: noreply@wordiqo.com)
- `fromName`: Sender name (default: Wordiqo)
- `adminEmail`: Admin notification email (default: admin@wordiqo.com)

To override these settings in your environment, add the following to your `.env` file:
```
email_from = your-email@example.com
email_name = Your Name
admin_email = admin@example.com
```

## Integration Points

The email system is integrated at these points:
1. **User Registration**: Welcome email sent when users register
2. **Admin User Creation**: Welcome email sent when admin creates a new user
3. **Password Reset**: Email sent when users request password reset

## Adding New Templates

To add a new email template:
1. Create a new template file in `templates` directory
2. Add the template path to `EmailSettings.php`
3. Add a corresponding method in `EmailService` class

## Troubleshooting

If emails are not being sent:
1. Check SMTP settings in `.env` file
2. Verify email_from and admin_email settings
3. Check PHP error logs for more details

## SMTP Configuration Example

```
mail.protocol = smtp
mail.SMTPHost = smtp.example.com
mail.SMTPUser = your-email@example.com
mail.SMTPPass = your-password
mail.SMTPPort = 587
mail.SMTPCrypto = tls
``` 