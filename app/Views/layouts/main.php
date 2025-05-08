<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Blog' ?></title>
    <meta name="description" content="<?= $description ?? 'A modern blogging platform' ?>">
    
    <!-- Tailwind CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="<?= base_url() ?>" class="text-2xl font-bold text-primary-600">
                    Blog
                </a>
                
                <div class="flex items-center space-x-4">
                    <form action="<?= base_url('search') ?>" method="get" class="relative">
                        <input type="text" name="q" placeholder="Search..." 
                               class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                    <?php if (session()->get('logged_in')): ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary-600">
                                <span><?= session()->get('user_name') ?></span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl hidden group-hover:block">
                                <a href="<?= base_url('admin') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                                <a href="<?= base_url('admin/posts') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Posts
                                </a>
                                <a href="<?= base_url('admin/categories') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Categories
                                </a>
                                <hr class="my-2">
                                <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="text-gray-700 hover:text-primary-600">
                            Login
                        </a>
                        <a href="<?= base_url('register') ?>" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    <?php if ($flash = session()->getFlashdata('flash')): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $flash['message'] ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About</h3>
                    <p class="text-gray-600">
                        A modern blogging platform built with CodeIgniter 4 and Tailwind CSS.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= base_url() ?>" class="text-gray-600 hover:text-primary-600">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('about') ?>" class="text-gray-600 hover:text-primary-600">
                                About
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('contact') ?>" class="text-gray-600 hover:text-primary-600">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <form action="<?= base_url('newsletter/subscribe') ?>" method="post" class="space-y-2">
                        <input type="email" name="email" placeholder="Enter your email" 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t text-center text-gray-600">
                <p>&copy; <?= date('Y') ?> Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Auto-save functionality
        let autoSaveTimeout;
        const autoSaveInterval = 15000; // 15 seconds

        function setupAutoSave() {
            const editor = document.querySelector('.ck-editor__editable');
            if (editor) {
                editor.addEventListener('input', () => {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(() => {
                        // Trigger save
                        document.querySelector('form').dispatchEvent(new Event('submit'));
                    }, autoSaveInterval);
                });
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey) {
                switch (e.key.toLowerCase()) {
                    case 'n':
                        e.preventDefault();
                        window.location.href = '<?= base_url('admin/posts/create') ?>';
                        break;
                    case 's':
                        e.preventDefault();
                        document.querySelector('form').dispatchEvent(new Event('submit'));
                        break;
                    case 'p':
                        e.preventDefault();
                        const statusInput = document.querySelector('select[name="status"]');
                        if (statusInput) {
                            statusInput.value = 'published';
                            document.querySelector('form').dispatchEvent(new Event('submit'));
                        }
                        break;
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            setupAutoSave();
        });
    </script>
</body>
</html> 