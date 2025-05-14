<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Wordiqo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #fff;
            padding: 30px;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 5px 5px;
            border: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .security-note {
            background: #fff8e5;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset</h1>
        </div>
        <div class="content">
            <p>Hello <?= $name ?>,</p>
            
            <p>We received a request to reset your password for your Wordiqo account. If you did not request this password reset, please ignore this email or contact support if you have concerns.</p>
            
            <div style="text-align: center;">
                <a href="<?= $reset_link ?>" class="button">Reset Password</a>
            </div>
            
            <div class="security-note">
                <p><strong>Security Note:</strong></p>
                <p>This password reset link will expire in 30 minutes for your security.</p>
                <p>If you're having trouble clicking the reset button, copy and paste the following URL into your web browser:</p>
                <p style="word-break: break-all; font-size: 12px;"><?= $reset_link ?></p>
            </div>
            
            <p>Best regards,<br>The Wordiqo Team</p>
        </div>
        <div class="footer">
            <p>© <?= date('Y') ?> Wordiqo. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html> 