<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Blog' ?></title>
    <meta name="description" content="<?php echo $description ?? 'A modern blogging platform' ?>">

    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Geist Mono Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@300;400;500;600;700&display=swap">

    <!-- Tailwind CSS -->
    <link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = ['userDropdown', 'mobileMenu'];
            dropdowns.forEach(id => {
                const dropdown = document.getElementById(id);
                const button = document.getElementById(id + 'Button');
                if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('themeIcon').classList.replace('fa-sun', 'fa-moon');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('themeIcon').classList.replace('fa-moon', 'fa-sun');
            }
        }

        // Check for saved theme preference or respect OS preference
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            --gradient-start: theme('colors.indigo.600');
            --gradient-end: theme('colors.purple.600');
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Use monospace for code-related content */
        code,
        pre,
        .monospace {
            font-family: 'Geist Mono', monospace;
        }

        /* Adjust heading styles */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.5);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(79, 70, 229, 0.7);
        }

        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #4f46e5, #8b5cf6, #3b82f6, #6366f1);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Grid pattern */
        .bg-grid {
            mask-image: linear-gradient(to bottom, transparent, black);
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }

        /* Float animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Slide-up animation */
        .slide-up {
            animation: slideUp 0.5s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Dark mode transitions */
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body class="dark-transition bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
    <!-- Modern Sticky Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
        <div class="flex items-center justify-between px-4 sm:px-6 py-2 sm:py-3 max-w-screen-2xl mx-auto">
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="<?php echo base_url() ?>" class="flex items-center gap-2 text-xl sm:text-2xl font-bold text-blue-700">
                    <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">B</span>
                    Wordingo
                </a>
            </div>
            <nav class="hidden md:flex gap-4 sm:gap-6 text-base font-medium">
                <a href="<?php echo base_url() ?>" class="hover:text-blue-600 transition">Home</a>
                <a href="<?php echo base_url('blogs') ?>" class="hover:text-blue-600 transition">Blogs</a>
                <a href="<?php echo base_url('about') ?>" class="hover:text-blue-600 transition">About</a>
                <a href="<?php echo base_url('contact') ?>" class="hover:text-blue-600 transition">Contact</a>
            </nav>
            <div class="flex items-center gap-1 sm:gap-2">
                <button class="p-2 rounded-full hover:bg-gray-100 transition md:hidden" onclick="toggleDropdown('mobileMenu')" aria-label="Open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-gray-100 transition" onclick="document.getElementById('searchModal').classList.remove('hidden')" aria-label="Search">
                    <i class="fas fa-search text-xl"></i>
                </button>
                <a href="/login" class="hidden sm:inline-block px-3 py-2 rounded-lg font-semibold text-blue-600 hover:bg-blue-50 transition text-sm sm:text-base">Login</a>
                <a href="/register" class="hidden sm:inline-block px-3 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition text-sm sm:text-base">Register</a>
            </div>
        </div>
        <!-- Mobile Nav Dropdown -->
        <div id="mobileMenu" class="md:hidden hidden absolute left-0 right-0 bg-white shadow-lg border-b border-gray-100 px-4 py-4 z-40">
            <nav class="flex flex-col gap-3 text-base font-medium">
                <a href="<?php echo base_url() ?>" class="hover:text-blue-600 transition">Home</a>
                <a href="<?php echo base_url('blogs') ?>" class="hover:text-blue-600 transition">Blogs</a>
                <a href="<?php echo base_url('about') ?>" class="hover:text-blue-600 transition">About</a>
                <a href="<?php echo base_url('contact') ?>" class="hover:text-blue-600 transition">Contact</a>
                <a href="/login" class="px-3 py-2 rounded-lg font-semibold text-blue-600 hover:bg-blue-50 transition">Login</a>
                <a href="/register" class="px-3 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition">Register</a>
            </nav>
        </div>
    </header>

    <!-- Search Modal -->
    <div id="searchModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" aria-hidden="true" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="p-6">
                    <form action="<?php echo base_url('search') ?>" method="get">
                        <div class="flex items-center border-b-2 border-indigo-500 dark:border-indigo-400 pb-2">
                            <i class="fas fa-search text-gray-400 mr-2"></i>
                            <input type="text" name="q" placeholder="Search for articles, topics, or keywords..." autofocus
                                class="w-full bg-transparent border-none outline-none text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Popular Topics:</span>
                            <a href="<?php echo base_url('search?q=technology') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Technology</a>
                            <a href="<?php echo base_url('search?q=design') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Design</a>
                            <a href="<?php echo base_url('search?q=programming') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Programming</a>
                            <a href="<?php echo base_url('search?q=ai') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">AI</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($flash = session()->getFlashdata('flash')): ?>
        <div class="container mx-auto px-4 mt-4 slide-up">
            <div class="p-4 rounded-lg shadow-md border-l-4                                                                                                                                                                                  <?php echo $flash['type'] === 'success'
                                                                                                                                                                                                                                                    ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-500'
                                                                                                                                                                                                                                                    : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-500' ?>">
                <div class="flex items-center">
                    <i class="<?php echo $flash['type'] === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500' ?> mr-3 text-lg"></i>
                    <p><?php echo $flash['message'] ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $this->renderSection('content') ?>
    </main>

    <!-- Modern Footer (Multi-Column) -->
    <footer class="bg-white border-t border-gray-100 pt-10 pb-4 mt-12">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-4 gap-8 sm:gap-12 mb-8">
            <div>
                <h3 class="text-lg sm:text-xl font-bold mb-3 text-blue-700">About Wordingo</h3>
                <p class="text-gray-600 mb-4 text-sm sm:text-base">A modern blogging platform built with CodeIgniter 4 and Tailwind CSS, focusing on a clean design and great user experience.</p>
                <div class="flex gap-3 text-xl text-blue-600">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm sm:text-base">
                    <li><a href="/" class="hover:text-blue-600 transition">Home</a></li>
                    <li><a href="/blogs" class="hover:text-blue-600 transition">Blogs</a></li>
                    <li><a href="/about" class="hover:text-blue-600 transition">About</a></li>
                    <li><a href="/contact" class="hover:text-blue-600 transition">Contact</a></li>
                    <li><a href="/privacy-policy" class="hover:text-blue-600 transition">Privacy Policy</a></li>
                    <li><a href="/terms-of-service" class="hover:text-blue-600 transition">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-bold mb-3">Newsletter</h3>
                <p class="text-gray-600 mb-3 text-sm sm:text-base">Subscribe to our newsletter for the latest updates and articles.</p>
                <form class="flex flex-col sm:flex-row gap-2">
                    <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-sm sm:text-base">Subscribe</button>
                </form>
                <p class="text-xs text-gray-400 mt-2">We respect your privacy. Unsubscribe at any time.</p>
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-bold mb-3">Contact</h3>
                <p class="text-gray-600 mb-2 text-sm sm:text-base">Want to discuss with us?</p>
                <a href="mailto:contact@website.com" class="text-blue-600 hover:underline">contact@website.com</a>
                <div class="mt-4">
                    <a href="#" class="text-sm text-gray-500 hover:underline">Unsubscribe from this email</a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-4 sm:pt-6 text-center text-gray-400 text-xs sm:text-sm">
            &copy; <?= date('Y') ?> Wordingo. All rights reserved.
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
                        const form = document.querySelector('form');
                        if (form) form.dispatchEvent(new Event('submit'));
                        break;
                    case 'p':
                        e.preventDefault();
                        const statusInput = document.querySelector('select[name="status"]');
                        if (statusInput) {
                            statusInput.value = 'published';
                            document.querySelector('form').dispatchEvent(new Event('submit'));
                        }
                        break;
                    case '/':
                        e.preventDefault();
                        document.getElementById('searchModal').classList.remove('hidden');
                        setTimeout(() => {
                            document.querySelector('#searchModal input').focus();
                        }, 100);
                        break;
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            setupAutoSave();

            // Update theme icon on load
            const isDarkMode = document.documentElement.classList.contains('dark');
            const themeIcon = document.getElementById('themeIcon');
            if (themeIcon) {
                themeIcon.classList.replace(
                    isDarkMode ? 'fa-moon' : 'fa-sun',
                    isDarkMode ? 'fa-sun' : 'fa-moon'
                );
            }

            // Close search modal with escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.getElementById('searchModal').classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>