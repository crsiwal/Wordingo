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
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

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
    <!-- Modernized Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-4 sm:px-8 py-3 max-w-screen-2xl mx-auto">
            <a href="<?= base_url() ?>" class="flex items-center gap-3 text-2xl font-bold text-indigo-700">
                <span class="bg-gradient-to-tr from-indigo-600 to-purple-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl shadow">W</span>
                <span class="tracking-tight">Wordingo</span>
            </a>
            <nav class="hidden md:flex gap-6 text-base font-medium">
                <a href="<?= base_url() ?>"
                    class="<?= uri_string() === '' || uri_string() === 'home' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Home
                </a>
                <a href="<?= base_url('posts') ?>"
                    class="<?= uri_string() === 'posts' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Posts
                </a>
                <a href="<?= base_url('about') ?>"
                    class="<?= uri_string() === 'about' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    About
                </a>
                <a href="<?= base_url('contact') ?>"
                    class="<?= uri_string() === 'contact' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Contact
                </a>
                <a href="<?= base_url('privacy') ?>"
                    class="<?= uri_string() === 'privacy' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Privacy Policy
                </a>
                <a href="<?= base_url('terms') ?>"
                    class="<?= uri_string() === 'terms' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Terms of Use
                </a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="<?= base_url('login') ?>" class="hidden sm:inline-block px-4 py-2 rounded-lg font-semibold text-indigo-600 hover:bg-indigo-50 transition text-base">Login</a>
                <a href="<?= base_url('register') ?>" class="hidden sm:inline-block px-4 py-2 rounded-lg font-semibold bg-indigo-600 text-white shadow hover:bg-indigo-700 transition text-base">Register</a>
                <button class="p-2 rounded-full hover:bg-gray-100 transition md:hidden" onclick="toggleDropdown('mobileMenu')" aria-label="Open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Nav Dropdown -->
        <div id="mobileMenu" class="md:hidden hidden absolute left-0 right-0 bg-white shadow-lg border-b border-gray-100 px-4 py-4 z-40">
            <nav class="flex flex-col gap-3 text-base font-medium">
                <a href="<?= base_url() ?>"
                    class="<?= uri_string() === '' || uri_string() === 'home' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Home
                </a>
                <a href="<?= base_url('posts') ?>"
                    class="<?= uri_string() === 'posts' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Posts
                </a>
                <a href="<?= base_url('about') ?>"
                    class="<?= uri_string() === 'about' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    About
                </a>
                <a href="<?= base_url('contact') ?>"
                    class="<?= uri_string() === 'contact' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Contact
                </a>
                <a href="<?= base_url('privacy') ?>"
                    class="<?= uri_string() === 'privacy' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Privacy Policy
                </a>
                <a href="<?= base_url('terms') ?>"
                    class="<?= uri_string() === 'terms' ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-indigo-600' ?> transition">
                    Terms of Use
                </a>
                <a href="<?= base_url('login') ?>" class="px-3 py-2 rounded-lg font-semibold text-indigo-600 hover:bg-indigo-50 transition">Login</a>
                <a href="<?= base_url('register') ?>" class="px-3 py-2 rounded-lg font-semibold bg-indigo-600 text-white shadow hover:bg-indigo-700 transition">Register</a>
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
                    <form action="<?= base_url('search') ?>" method="get">
                        <div class="flex items-center border-b-2 border-indigo-500 dark:border-indigo-400 pb-2">
                            <i class="fas fa-search text-gray-400 mr-2"></i>
                            <input type="text" name="q" placeholder="Search for articles, topics, or keywords..." autofocus
                                class="w-full bg-transparent border-none outline-none text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Popular Topics:</span>
                            <a href="<?= base_url('search?q=technology') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Technology</a>
                            <a href="<?= base_url('search?q=design') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Design</a>
                            <a href="<?= base_url('search?q=programming') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">Programming</a>
                            <a href="<?= base_url('search?q=ai') ?>" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">AI</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($flash = session()->getFlashdata('flash')): ?>
        <div class="container mx-auto px-4 mt-4 slide-up">
            <div class="p-4 rounded-lg shadow-md border-l-4 <?php echo $flash['type'] === 'success' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-500' : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-500' ?>">
                <div class="flex items-center">
                    <i class="<?php echo $flash['type'] === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500' ?> mr-3 text-lg"></i>
                    <p><?php echo $flash['message'] ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Modernized Footer -->
    <footer class="bg-white border-t border-gray-100 pt-12 pb-6 mt-12">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10 mb-8">
            <div class="min-w-0 break-words">
                <h3 class="text-lg sm:text-xl font-bold mb-3 text-indigo-700">About Wordingo</h3>
                <p class="text-gray-600 mb-4 text-sm sm:text-base">A modern blogging platform built with CodeIgniter 4 and Tailwind CSS, focusing on a clean design and great user experience.</p>
                <div class="flex gap-3 text-xl text-indigo-600">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="min-w-0 break-words">
                <h3 class="text-lg sm:text-xl font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm sm:text-base">
                    <li><a href="/" class="hover:text-indigo-600 transition">Home</a></li>
                    <li><a href="/posts" class="hover:text-indigo-600 transition">Posts</a></li>
                    <li><a href="/about" class="hover:text-indigo-600 transition">About</a></li>
                    <li><a href="/contact" class="hover:text-indigo-600 transition">Contact</a></li>
                    <li><a href="/privacy" class="hover:text-indigo-600 transition">Privacy Policy</a></li>
                    <li><a href="/terms" class="hover:text-indigo-600 transition">Terms of Use</a></li>
                </ul>
            </div>
            <div class="min-w-0 break-words">
                <h3 class="text-lg sm:text-xl font-bold mb-3">Newsletter</h3>
                <p class="text-gray-600 mb-3 text-sm sm:text-base">Subscribe to our newsletter for the latest updates and articles.</p>
                <form class="flex flex-col gap-2 sm:flex-col md:flex-row xl:flex-col">
                    <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm sm:text-base flex-1 min-w-0">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition text-sm sm:text-base w-full md:w-auto xl:w-full">Subscribe</button>
                </form>
                <p class="text-xs text-gray-400 mt-2">We respect your privacy. Unsubscribe at any time.</p>
            </div>
            <div class="min-w-0 break-words">
                <h3 class="text-lg sm:text-xl font-bold mb-3">Contact</h3>
                <p class="text-gray-600 mb-2 text-sm sm:text-base">Want to discuss with us?</p>
                <a href="mailto:support@wordingo.com" class="text-indigo-600 hover:underline">support@wordingo.com</a>
                <div class="mt-4">
                    <a href="#" class="text-sm text-gray-500 hover:underline">Unsubscribe from this email</a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-4 sm:pt-6 text-center text-gray-400 text-xs sm:text-sm">
            &copy; <?= date('Y') ?> Wordingo. All rights reserved.
        </div>
    </footer>
    <script src="<?= base_url('js/script.js') ?>"></script>
</body>

</html>