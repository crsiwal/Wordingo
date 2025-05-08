<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full mx-auto p-8">
        <div class="text-center">
            <h1 class="text-9xl font-bold text-primary-600">404</h1>
            <h2 class="text-3xl font-semibold mt-4 mb-2">Page Not Found</h2>
            <p class="text-gray-600 mb-8">The page you're looking for doesn't exist or has been moved.</p>
            <a href="<?= base_url() ?>" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html> 