<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard'?> - Wordiqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="<?php echo base_url('admin')?>" class="text-xl font-bold text-gray-800">
                            Wordiqo Admin
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="<?php echo base_url('admin')?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="<?php echo base_url('admin/posts')?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Posts
                        </a>
                        <a href="<?php echo base_url('admin/categories')?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Categories
                        </a>
                        <a href="<?php echo base_url('admin/tags')?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Tags
                        </a>
                        <a href="<?php echo base_url('admin/users')?>" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Users
                        </a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative">
                        <button id="userDropdownButton" onclick="toggleDropdown()" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span class="mr-2"><?php echo session()->get('user_name')?></span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="<?php echo base_url('admin')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Dashboard
                                </a>
                                <a href="<?php echo base_url('admin/posts')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Posts
                                </a>
                                <a href="<?php echo base_url('admin/categories')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Categories
                                </a>
                                <a href="<?php echo base_url('admin/tags')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Tags
                                </a>
                                <a href="<?php echo base_url('admin/users')?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Users
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="<?php echo base_url('logout')?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="rounded-md p-4 bg-green-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <?php echo session()->getFlashdata('success')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="rounded-md p-4 bg-red-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            <?php echo session()->getFlashdata('error')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $this->renderSection('content')?>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <p class="text-center text-gray-500 text-sm">
                &copy; <?php echo date('Y')?> Wordiqo. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>