<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration</title>
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
        .alert {
            border-left: 4px solid #4f46e5;
            padding-left: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New User Registration</h1>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            
            <p>A new user has registered on Wordiqo.</p>
            
            <div class="user-info">
                <p><strong>Name:</strong> <?= $name ?></p>
                <p><strong>Username:</strong> <?= $username ?></p>
                <p><strong>Email:</strong> <?= $email ?></p>
                <p><strong>Role:</strong> <?= ucfirst($role) ?></p>
                <p><strong>Registration Date:</strong> <?= $created_at ?></p>
            </div>
            
            <div class="alert">
                <p>This is an automated notification. You may need to review this account or take appropriate action based on your site policies.</p>
            </div>
            
            <div style="text-align: center;">
                <a href="<?= base_url('admin/users') ?>" class="button">View All Users</a>
            </div>
            
            <p>Best regards,<br>Wordiqo System</p>
        </div>
        <div class="footer">
            <p>© <?= date('Y') ?> Wordiqo. All rights reserved.</p>
            <p>This is an automated message from your system.</p>
        </div>
    </div>
</body>
</html> 