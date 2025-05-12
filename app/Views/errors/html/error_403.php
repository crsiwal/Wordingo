<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-red-600 mb-4">403 - Access Denied</h1>
                <div class="text-gray-600 mb-6">
                    Sorry, you don't have permission to access this page. Please make sure you're logged in with the correct permissions.
                </div>
                <?php if (ENVIRONMENT !== 'production'): ?>
                    <div class="bg-gray-100 p-4 rounded-lg text-left mb-6">
                        <h2 class="text-lg font-semibold mb-2">Error Details:</h2>
                        <div class="text-sm font-mono">
                            <?= nl2br(esc($message)) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="space-x-4">
                    <a href="javascript:history.back()" class="inline-block bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Go Back
                    </a>
                    <a href="<?= base_url('admin/posts/create') ?>" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create New Post
                    </a>
                    <a href="<?= base_url() ?>" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-home mr-2"></i>Go Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 