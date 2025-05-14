<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Wordiqo</title>
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
        .user-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Wordiqo</h1>
        </div>
        <div class="content">
            <p>Hello <?= $name ?>,</p>
            
            <p>Thank you for registering with Wordiqo, your new blogging platform! We're excited to have you join our community.</p>
            
            <p>Your account has been created successfully with the following details:</p>
            
            <div class="user-info">
                <p><strong>Username:</strong> <?= $username ?></p>
                <p><strong>Email:</strong> <?= $email ?></p>
                <p><strong>Role:</strong> <?= ucfirst($role) ?></p>
            </div>
            
            <p>You can now log in to your account using your email and the password you provided during registration.</p>
            
            <div style="text-align: center;">
                <a href="<?= base_url('login') ?>" class="button">Login to Your Account</a>
            </div>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Happy blogging!</p>
            
            <p>Best regards,<br>The Wordiqo Team</p>
        </div>
        <div class="footer">
            <p>© <?= date('Y') ?> Wordiqo. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html> 