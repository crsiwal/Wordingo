<?php echo $this->extend('layouts/user')?>

<?php echo $this->section('content')?>
<div class="py-8">
    <!-- Welcome Section -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10">
            <div class="text-white">
                <h1 class="text-3xl font-bold mb-2">Welcome, <?php echo session()->get('user_name') ?></h1>
                <p class="text-indigo-100">This is your personal dashboard. Manage your profile and saved content.</p>
            </div>
        </div>

        <!-- Animated bubbles background effect -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="absolute rounded-full bg-white/30"
                    style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;'?>"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- User Dashboard Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Sidebar - User Info -->
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-indigo-100 flex items-center justify-center mb-4">
                            <?php if (session()->get('avatar')): ?>
                                <img src="<?php echo base_url(session()->get('avatar')) ?>" alt="<?php echo session()->get('user_name') ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-4xl text-indigo-600 dark:text-indigo-400"><?php echo substr(session()->get('user_name'), 0, 1) ?></span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo session()->get('user_name') ?></h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">@<?php echo session()->get('user_username') ?></p>
                        
                        <a href="<?php echo base_url('users/profile') ?>" class="w-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-4 py-2 rounded-lg text-center hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Quick Actions</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo base_url('users/posts/bookmarks') ?>" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center">
                                <i class="fas fa-bookmark text-indigo-500 dark:text-indigo-400 mr-2"></i> Saved Posts
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('users/profile') ?>" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center">
                                <i class="fas fa-user-edit text-indigo-500 dark:text-indigo-400 mr-2"></i> Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('logout') ?>" class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors flex items-center">
                                <i class="fas fa-sign-out-alt text-red-500 mr-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Content Area -->
        <div class="md:col-span-2">
            <!-- Recent Posts Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Recent Posts</h3>
                    
                    <?php if (!empty($recentPosts)): ?>
                        <div class="space-y-4">
                            <?php foreach ($recentPosts as $post): ?>
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-1">
                                        <a href="<?php echo base_url('posts/' . $post['slug']) ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                            <?php echo $post['title'] ?>
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo substr(strip_tags($post['content']), 0, 80) ?>...
                                    </p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        <span><i class="far fa-calendar-alt mr-1"></i> <?php echo date('M d, Y', strtotime($post['created_at'])) ?></span>
                                        <span class="mx-2">•</span>
                                        <span><i class="far fa-eye mr-1"></i> <?php echo $post['views'] ?? 0 ?> views</span>
                                        <a href="<?php echo base_url('posts/' . $post['slug']) ?>" class="ml-auto text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="<?php echo base_url('blogs') ?>" class="text-indigo-600 dark:text-indigo-400 hover:underline">View All Posts</a>
                        </div>
                    <?php else: ?>
                        <div class="text-gray-500 dark:text-gray-400 text-center py-4">
                            <p>No recent posts available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Explore Categories</h3>
                    
                    <?php if (!empty($categories)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($categories as $category): ?>
                                <a href="<?php echo base_url('category/' . $category['slug']) ?>" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                                    <?php echo $category['name'] ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-gray-500 dark:text-gray-400 text-center py-4">
                            <p>No categories available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection()?> 