<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'User Dashboard' ?></title>
    <meta name="description" content="<?php echo $description ?? 'User dashboard for Wordiqo' ?>">

    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Tailwind CSS -->
    <link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = ['userDropdown', 'notificationsDropdown'];
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
        code, pre, .monospace {
            font-family: monospace;
        }

        /* Adjust heading styles */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.5);
            border-radius: 4px;
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
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Slide-up animation */
        .slide-up {
            animation: slideUp 0.5s ease-out forwards;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Dark mode transitions */
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>
<body class="dark-transition bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="dark-transition relative bg-white dark:bg-gray-800 shadow-sm">
        <!-- Top accent bar -->
        <div class="h-1 w-full animated-gradient"></div>

        <nav class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button onclick="toggleSidebar()" class="md:hidden mr-3 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <i class="fas fa-bars"></i>
                    </button>

                    <a href="<?php echo base_url("users") ?>" class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full animated-gradient flex items-center justify-center">
                            <span class="text-white font-bold text-lg">B</span>
                        </div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                            Wordiqo
                        </span>
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i id="themeIcon" class="fas                                                                                                                                                                                                                 <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'fa-sun' : 'fa-moon' ?>"></i>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div class="relative">
                        <button id="notificationsDropdownButton" onclick="toggleDropdown('notificationsDropdown')" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                        <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-white dark:ring-opacity-10 z-50">
                            <div class="p-3 border-b border-gray-100 dark:border-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="py-2 px-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                                <i class="fas fa-bell"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Welcome to your dashboard!</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Just now</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="block p-3 text-center text-sm font-medium text-indigo-600 dark:text-indigo-400 border-t border-gray-100 dark:border-gray-700">
                                View all notifications
                            </a>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="userDropdownButton" onclick="toggleDropdown('userDropdown')" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 overflow-hidden">
                                <?php if (session()->get('avatar')): ?>
                                    <img src="<?php echo base_url(session()->get('avatar')) ?>" alt="<?php echo session()->get('user_name') ?>" class="h-full w-full object-cover">
                                <?php else: ?>
                                    <span><?php echo substr(session()->get('user_name'), 0, 1) ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="hidden sm:inline"><?php echo session()->get('user_name') ?></span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-white dark:ring-opacity-10 z-50">
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="<?php echo base_url(session()->get('user_role') == "user" ? "users" : "admin") ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <?php echo session()->get('user_role') == "user" ? "Dashboard" : "Admin Dashboard" ?>
                                </a>
                                <a href="<?php echo base_url('users/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    My Profile
                                </a>
                                <a href="<?php echo base_url('users/posts/bookmarks') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    Saved Posts
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <a href="<?php echo base_url() ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <i class="fas fa-globe mr-2"></i> Visit Site
                                </a>
                                <a href="<?php echo base_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar - Hidden on mobile, visible on desktop -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 top-[57px] w-64 bg-white dark:bg-gray-800 shadow-md z-20 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
            <nav class="px-4 py-6 space-y-1">
                <div class="mb-8">
                    <div class="flex items-center px-4 py-3">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 overflow-hidden">
                                <?php if (session()->get('avatar')): ?>
                                    <img src="<?php echo base_url(session()->get('avatar')) ?>" alt="<?php echo session()->get('user_name') ?>" class="h-full w-full object-cover">
                                <?php else: ?>
                                    <span class="text-lg"><?php echo substr(session()->get('user_name'), 0, 1) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-gray-100"><?php echo session()->get('user_name') ?></h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">@<?php echo session()->get('user_username') ?></p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url('users') ?>" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-colors">
                    <i class="fas fa-home mr-3 text-indigo-500 dark:text-indigo-400"></i>
                    <span>Dashboard</span>
                </a>

                <a href="<?php echo base_url('users/profile') ?>" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-colors">
                    <i class="fas fa-user mr-3 text-indigo-500 dark:text-indigo-400"></i>
                    <span>My Profile</span>
                </a>

                <a href="<?php echo base_url('users/posts/bookmarks') ?>" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-colors">
                    <i class="fas fa-bookmark mr-3 text-indigo-500 dark:text-indigo-400"></i>
                    <span>Saved Posts</span>
                </a>

                <a href="<?php echo base_url('blogs') ?>" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-colors">
                    <i class="fas fa-rss mr-3 text-indigo-500 dark:text-indigo-400"></i>
                    <span>Browse Blogs</span>
                </a>

                <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                <a href="<?php echo base_url('logout') ?>" class="flex items-center px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="md:ml-64 flex-1">
            <!-- Flash Messages -->
            <?php if ($flash = session()->getFlashdata('flash')): ?>
                <div class="m-4 slide-up">
                    <div class="p-4 rounded-lg shadow-md border-l-4                                                                                                                                                                                                                                                                             <?php echo $flash['type'] === 'success'
                                                                                                                                                                                                                                                                             ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-500'
                                                                                                                                                                                                                                                                             : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-500' ?>">
                        <div class="flex items-center">
                            <i class="<?php echo $flash['type'] === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500' ?> mr-3 text-lg"></i>
                            <p><?php echo $flash['message'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <main class="p-4">
                <?php echo $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            // Update theme icon on load
            const isDarkMode = document.documentElement.classList.contains('dark');
            document.getElementById('themeIcon').classList.replace(
                isDarkMode ? 'fa-moon' : 'fa-sun',
                isDarkMode ? 'fa-sun' : 'fa-moon'
            );
        });
    </script>
</body>
</html>