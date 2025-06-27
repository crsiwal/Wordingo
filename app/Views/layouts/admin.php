<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Blog' ?></title>
    <meta name="description" content="<?php echo $description ?? 'A modern blogging platform' ?>">

    <!-- Geist Mono Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@300;400;500;600;700&display=swap">

    <!-- Tailwind CSS -->
    <link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        html,
        body {
            font-family: 'Geist Mono', monospace;
        }

        /* Adjust heading weights for Geist Mono */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Geist Mono', monospace;
            font-weight: 600;
        }

        /* Make sure buttons and inputs use the font */
        button,
        input,
        select,
        textarea {
            font-family: 'Geist Mono', monospace;
        }

        /* Mobile nav menu animation */
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .mobile-menu.closed {
            transform: translateX(-100%);
        }

        /* Responsive text adjustments */
        @media (max-width: 768px) {
            h1.text-5xl {
                font-size: 2.5rem;
                line-height: 2.75rem;
            }

            p.text-\[1\.375rem\] {
                font-size: 1.125rem;
                line-height: 1.5rem;
            }
        }

        /* Responsive tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Add spacing to table cells on mobile */
        @media (max-width: 768px) {

            .table-responsive table th,
            .table-responsive table td {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
                white-space: nowrap;
            }
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup Auto-save
            setupAutoSave();

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('userDropdown');
                const button = document.getElementById('userDropdownButton');
                if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
            menu.classList.toggle('closed');
        }

        // Auto-save functionality
        function setupAutoSave() {
            const editor = document.querySelector('.ck-editor__editable');
            if (editor) {
                let autoSaveTimeout;
                const autoSaveInterval = 15000; // 15 seconds

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
    </script>
    <?php echo $this->renderSection('styles') ?>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo - Left Aligned -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="<?= base_url("admin") ?>" class="flex items-center gap-3 text-2xl font-bold text-indigo-600">
                            <span class="rounded-full w-10 h-10 flex items-center justify-center">
                                <img src="<?= base_url('assets/images/icon.png') ?>" alt="Depto Words Logo" class="w-10 h-10">
                            </span>
                            <span class="tracking-tight"><?= site_name() ?></span>
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="ml-4 md:hidden">
                        <button type="button" onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>

                <!-- Navigation Links - Centered (Desktop only) -->
                <div class="hidden md:flex md:justify-center md:flex-1">
                    <div class="flex space-x-8">
                        <a href="<?php echo base_url('admin') ?>" class="<?php echo service('uri')->getSegment(1) === 'admin' && !service('uri')->getSegment(2) ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider">
                            Dashboard
                        </a>
                        <a href="<?php echo base_url('admin/posts') ?>" class="<?php echo service('uri')->getSegment(2) === 'posts' ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider">
                            Posts
                        </a>
                        <a href="<?php echo base_url('admin/categories') ?>" class="<?php echo service('uri')->getSegment(2) === 'categories' ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider">
                            Categories
                        </a>
                        <a href="<?php echo base_url('admin/tags') ?>" class="<?php echo service('uri')->getSegment(2) === 'tags' ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider"> Tags </a>
                        <?php if (in_array(session()->get('user_role'), ['admin'])): ?>
                            <div class="relative group">
                                <a href="#" class="<?php echo service('uri')->getSegment(2) === 'ads' ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider inline-flex items-center"> Ads
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </a>
                                <div class="hidden group-hover:block absolute left-0 mt-0 w-48 bg-white shadow-lg rounded-md z-50">
                                    <a href="<?php echo base_url('admin/ads') ?>" class="<?php echo (service('uri')->getSegment(2) === 'ads' && !service('uri')->getSegment(3)) ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' ?> block px-4 py-2 text-sm"> <i class="fas fa-ad mr-2"></i> Ads </a>
                                    <a href="<?php echo base_url('admin/ads/slots') ?>" class="<?php echo (service('uri')->getSegment(2) === 'ads' && service('uri')->getSegment(3) === 'slots') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' ?> block px-4 py-2 text-sm"> <i class="fas fa-layer-group mr-2"></i> Ad Slots </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (in_array(session()->get('user_role'), ['admin', 'manager'])): ?>
                            <a href="<?php echo base_url('admin/users') ?>" class="<?php echo service('uri')->getSegment(2) === 'users' ? 'text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-900' ?> px-3 py-2 text-sm font-medium uppercase tracking-wider"> Users </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- User Profile - Right Aligned -->
                <div class="flex items-center">
                    <?php if (session()->get('logged_in')): ?>
                        <div class="relative">
                            <button id="userDropdownButton" onclick="toggleDropdown()" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                                <i class="fas fa-user-circle mr-2 text-lg"></i>
                                <div class="flex items-center justify-center">
                                    <?php echo substr(session()->get('user_name'), 0, 20); ?>
                                </div>
                            </button>
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                        <div class="font-semibold"><?php echo session()->get('user_name') ?></div>
                                    </div>
                                    <a href="<?php echo base_url('admin/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-user-circle mr-2"></i> Profile
                                    </a>
                                    <a href="<?php echo base_url('admin/settings') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-cog mr-2"></i> Settings
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="<?php echo base_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <a href="<?php echo base_url('login') ?>" class="text-gray-700 hover:text-gray-900">
                                Login
                            </a>
                            <a href="<?php echo base_url('register') ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Register
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mobile menu (off-canvas) -->
        <div id="mobile-menu" class="md:hidden bg-white fixed inset-y-0 left-0 w-64 px-4 py-4 shadow-lg z-30 mobile-menu closed">
            <div class="flex items-center justify-between mb-6">
                <div class="text-xl font-bold text-gray-800">Menu</div>
                <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-3">
                <a href="<?php echo base_url('admin') ?>" class="<?php echo service('uri')->getSegment(1) === 'admin' && !service('uri')->getSegment(2) ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-base font-medium uppercase tracking-wider">
                    Dashboard
                </a>
                <a href="<?php echo base_url('admin/posts') ?>" class="<?php echo service('uri')->getSegment(2) === 'posts' ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-base font-medium uppercase tracking-wider">
                    Posts
                </a>
                <a href="<?php echo base_url('admin/categories') ?>" class="<?php echo service('uri')->getSegment(2) === 'categories' ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-base font-medium uppercase tracking-wider">
                    Categories
                </a>
                <a href="<?php echo base_url('admin/tags') ?>" class="<?php echo service('uri')->getSegment(2) === 'tags' ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-base font-medium uppercase tracking-wider"> Tags </a>

                <?php if (in_array(session()->get('user_role'), ['admin'])): ?>
                    <div class="py-2 text-base font-medium uppercase tracking-wider <?php echo service('uri')->getSegment(2) === 'ads' ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?>">Ads</div>

                    <div class="pl-4 border-l-2 border-gray-200 space-y-2">
                        <a href="<?php echo base_url('admin/ads') ?>" class="<?php echo (service('uri')->getSegment(2) === 'ads' && !service('uri')->getSegment(3)) ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-sm font-medium block"> <i class="fas fa-ad mr-2"></i> Ads </a>

                        <a href="<?php echo base_url('admin/ads/slots') ?>" class="<?php echo (service('uri')->getSegment(2) === 'ads' && service('uri')->getSegment(3) === 'slots') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-sm font-medium block"> <i class="fas fa-layer-group mr-2"></i> Ad Slots </a>

                    </div>
                <?php endif; ?>

                <?php if (in_array(session()->get('user_role'), ['admin', 'manager'])): ?>
                    <a href="<?php echo base_url('admin/users') ?>" class="<?php echo service('uri')->getSegment(2) === 'users' ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' ?> py-2 text-base font-medium uppercase tracking-wider"> Users </a>
                <?php endif; ?>

                <?php if (session()->get('logged_in')): ?>
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <a href="<?php echo base_url('admin/profile') ?>" class="flex items-center text-gray-600 hover:text-gray-900 py-2">
                            <i class="fas fa-user-circle mr-2"></i> Profile
                        </a>
                        <a href="<?php echo base_url('admin/settings') ?>" class="flex items-center text-gray-600 hover:text-gray-900 py-2">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <a href="<?php echo base_url('logout') ?>" class="flex items-center text-red-600 hover:text-red-700 py-2">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php if ($flash = session()->getFlashdata('flash')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="p-4 rounded-lg <?php echo $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?php echo $flash['message'] ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        <?php echo $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <p class="text-center text-gray-500 text-sm">
                &copy; <?php echo date('Y') ?> Wordiqo. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <!-- ECharts -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <!-- Moment.js (for date handling) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Numeral.js (for number formatting) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <?php echo $this->renderSection('scripts') ?>

</body>

</html>