<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto p-8">
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 animate-pulse"></div>

            <div class="mb-8 relative">
                <div class="text-9xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 animate-pulse">500</div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-9xl opacity-10 blur-sm text-white">500</div>
            </div>

            <div class="space-y-6">
                <div class="relative">
                    <h2 class="text-3xl font-bold text-white mb-4">Server Error!</h2>
                    <p class="text-gray-400 text-lg">We're sorry, but something went wrong on our end. Our team has been notified and we're working to fix it.</p>
                </div>

                <?php if (ENVIRONMENT !== 'production'): ?>
                    <div class="bg-gray-700 p-4 rounded-lg text-left mb-6">
                        <h2 class="text-lg font-semibold text-white mb-2">Error Details:</h2>
                        <div class="text-sm font-mono text-gray-300">
                            <?php echo nl2br(esc($message))?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="flex justify-center space-x-4 mt-8">
                    <a href="javascript:history.back()" class="group relative inline-flex items-center px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Go Back
                    </a>
                    <a href="<?php echo base_url()?>" class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-lg transition-all duration-200">
                        <i class="fas fa-home mr-2 group-hover:scale-110 transition-transform"></i>
                        Go Home
                    </a>
                </div>

                <div class="mt-8 text-gray-500">
                    <p class="text-sm">Error Code: <span class="font-mono">SERVER_ERROR_500</span></p>
                </div>
            </div>

            <!-- Floating space elements -->
            <div class="absolute top-10 right-10 text-gray-600 animate-spin-slow">
                <i class="fas fa-cog text-3xl"></i>
            </div>
            <div class="absolute bottom-10 left-10 text-gray-600 animate-bounce">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }
    </style>
</body>
</html>