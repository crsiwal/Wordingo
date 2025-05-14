<?php echo $this->extend('layouts/user')?>

<?php echo $this->section('content')?>
<div class="py-8">
    <!-- Page Header -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-3xl font-bold leading-tight mb-2">My Profile</h1>
                <p class="text-indigo-100">View and manage your account information</p>
            </div>
            <a href="<?php echo base_url('users') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    Back to Dashboard
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
            </a>
        </div>

        <!-- Animated bubbles background effect -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="absolute rounded-full bg-white/30"
                    style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;'?>"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Column - Avatar and Quick Actions -->
        <div class="md:col-span-1">
            <!-- Profile Picture Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-indigo-100 flex items-center justify-center mb-4">
                            <?php if ($user['avatar']): ?>
                                <img src="<?php echo base_url($user['avatar']) ?>" alt="<?php echo $user['name'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-6xl text-indigo-600 dark:text-indigo-400"><?php echo substr($user['name'], 0, 1) ?></span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo $user['name'] ?></h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-2">@<?php echo $user['username'] ?></p>
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-sm mb-4">
                            <?php echo ucfirst($user['role']) ?>
                        </span>
                        
                        <button type="button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-center transition-colors mb-2">
                            <i class="fas fa-camera mr-1"></i> Change Photo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Account Actions</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo base_url('users/profile/change-password') ?>" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center">
                                <i class="fas fa-key text-indigo-500 dark:text-indigo-400 mr-2"></i> Change Password
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('users/profile/notifications') ?>" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center">
                                <i class="fas fa-bell text-indigo-500 dark:text-indigo-400 mr-2"></i> Notification Settings
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('users/posts/bookmarks') ?>" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center">
                                <i class="fas fa-bookmark text-indigo-500 dark:text-indigo-400 mr-2"></i> Saved Posts
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

        <!-- Right Column - Profile Details -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                            Profile Information
                        </h3>
                        <button type="button" class="px-4 py-2 bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                            <i class="fas fa-pencil-alt mr-1"></i> Edit
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Full Name</label>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100">
                                <?php echo $user['name'] ?>
                            </div>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Username</label>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100">
                                @<?php echo $user['username'] ?>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email Address</label>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100">
                                <?php echo $user['email'] ?>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Phone Number</label>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100">
                                <?php echo $user['phone'] ?: 'Not provided' ?>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Account Type</label>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100">
                                <?php echo ucfirst($user['role']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection()?> 