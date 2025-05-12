<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Blog' ?></title>
    <meta name="description" content="<?php echo $description ?? 'A modern blogging platform' ?>">

    <!-- Tailwind CSS -->
    <link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.getElementById('userDropdownButton');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="<?php echo base_url("admin") ?>" class="text-2xl font-bold text-primary-600">
                    Blog
                </a>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="<?php echo base_url('admin') ?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="<?php echo base_url('admin/posts') ?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Posts
                        </a>
                        <a href="<?php echo base_url('admin/categories') ?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Categories
                        </a>
                        <a href="<?php echo base_url('admin/tags') ?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Tags
                        </a>
                        <a href="<?php echo base_url('admin/users') ?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Users
                        </a>
                    </div>

                <div class="flex items-center space-x-4">
                    <form action="<?php echo base_url('search') ?>" method="get" class="relative">
                        <input type="text" name="q" placeholder="Search..."
                               class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <?php if (session()->get('logged_in')): ?>
                        <div class="relative">
                            <button id="userDropdownButton" onclick="toggleDropdown()" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                                <span class="mr-2"><?php echo session()->get('user_name') ?></span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <a href="<?php echo base_url('admin/categories') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Categories
                                    </a>
                                    <a href="<?php echo base_url('admin/tags') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Tags
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="<?php echo base_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo base_url('login') ?>" class="text-gray-700 hover:text-primary-600">
                            Login
                        </a>
                        <a href="<?php echo base_url('register') ?>" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
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
            <div class="p-4 rounded-lg                                                                                                                                                                                                                                                                                                                 <?php echo $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?php echo $flash['message'] ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 min-h-screen">
        <?php echo $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <p class="text-center text-gray-500 text-sm">
                &copy;                                                                                         <?php echo date('Y') ?> Wordiqo. All rights reserved.
            </p>
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
                        window.location.href = '<?php echo base_url('admin/posts/create') ?>';
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