<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Users</h1>
            <p class="text-indigo-100 text-xl">Manage system users and permissions</p>
            <div class="flex items-center mt-4 text-indigo-100">
                <span class="flex items-center">
                    <i class="fas fa-users mr-2"></i>
                    <span><?php echo count($users) ?> Users</span>
                </span>
            </div>
        </div>
        <?php if (in_array($userRole, ['admin', 'manager'])): ?>
            <a href="<?php echo base_url('admin/users/create') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New User
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Animated bubbles background effect - Optimized to generate bubbles once -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php
        $bubbles = [];
        for ($i = 0; $i < 6; $i++) {
            $bubbles[] = [
                'width'    => rand(30, 80),
                'left'     => rand(0, 100),
                'top'      => rand(0, 100),
                'duration' => rand(5, 12),
            ];
        }

        foreach ($bubbles as $bubble):
        ?>
            <div class="absolute rounded-full bg-white/30"
                style="width: <?php echo $bubble['width'] ?>px; height: <?php echo $bubble['width'] ?>px; left: <?php echo $bubble['left'] ?>%; top: <?php echo $bubble['top'] ?>%; animation: float <?php echo $bubble['duration'] ?>s ease-in-out infinite;"></div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
    <div class="flex flex-col md:flex-row gap-4 justify-between">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="user-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5" placeholder="Search users..." onkeyup="filterUsers()">
        </div>
        <div class="flex gap-2">
            <?php if (in_array($userRole, ['admin'])): ?>
                <select id="role-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="filterUsers()">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="editor">Editor</option>
                    <option value="user">User</option>
                </select>
            <?php else: ?>
                <input type="hidden" id="role-filter" value="" />
            <?php endif; ?>

            <select id="gender-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="filterUsers()">
                <option value="">All Genders</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <select id="status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="filterUsers()">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="banned">Banned</option>
                <option value="suspended">Suspended</option>
            </select>
        </div>
    </div>
</div>

<!-- Users Grid - Optimized loop with cached variables -->
<div class="grid grid-cols-1 gap-6">
    <?php
    // Cache these values once outside the loop
    $currentUserRole = session()->get('user_role');
    $currentUserId   = session()->get('user_id');

    foreach ($users as $user):
        // Pre-calculate permissions
        $canEdit = ($currentUserRole === 'admin') ||
            ($currentUserRole === 'manager' && isset($user['parent_id']) && $user['parent_id'] == $currentUserId);

        // Determine role class once
        $roleClass = $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';

        // Determine status class once
        $statusClass = 'bg-gray-100 text-gray-800';
        if (isset($user['status'])) {
            if ($user['status'] === 'active') {
                $statusClass = 'bg-green-100 text-green-800';
            } elseif ($user['status'] === 'banned') {
                $statusClass = 'bg-red-100 text-red-800';
            } elseif ($user['status'] === 'suspended') {
                $statusClass = 'bg-orange-100 text-orange-800';
            }
        }

        // Determine gender icon once
        $genderIcon = 'fa-genderless';
        if (isset($user['gender'])) {
            if ($user['gender'] === 'male') {
                $genderIcon = 'fa-mars';
            } elseif ($user['gender'] === 'female') {
                $genderIcon = 'fa-venus';
            }
        }

        // Determine gradient class once
        $gradientClass = $user['role'] === 'admin' ? 'from-purple-500 to-indigo-500' : 'from-blue-500 to-cyan-500';
    ?>
        <div class="user-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div class="flex items-start gap-4">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">
                            <?php if (isset($user['avatar']) && $user['avatar'] != ''): ?>
                                <img src="<?php echo base_url($user['avatar']) ?>" alt="<?php echo $user['name'] ?>" class="w-full h-full object-cover rounded-full">
                            <?php else: ?>
                                <?php echo strtoupper(substr($user['name'], 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="user-name text-xl font-semibold text-gray-900 mb-1">
                                <?php echo esc($user['name']) ?>
                                <?php if (isset($user['is_verified']) && $user['is_verified']): ?>
                                    <span class="inline-block ml-1 text-green-500" title="Verified User">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                <?php endif; ?>
                            </h3>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center">
                                    <i class="fas fa-at text-indigo-400 mr-1"></i>
                                    <?php echo esc($user['username'] ?? '') ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-envelope text-purple-400 mr-1"></i>
                                    <?php echo esc($user['email']) ?>
                                    <?php if (isset($user['email_verified_at']) && ! empty($user['email_verified_at'])): ?>
                                        <span class="inline-block ml-1 text-green-500" title="Verified Email">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    <?php endif; ?>
                                </span>
                                <?php if (isset($user['phone']) && ! empty($user['phone'])): ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-phone text-blue-400 mr-1"></i>
                                        <?php echo esc($user['phone']) ?>
                                        <?php if (isset($user['phone_verified_at']) && ! empty($user['phone_verified_at'])): ?>
                                            <span class="inline-block ml-1 text-green-500" title="Verified Phone">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar text-blue-400 mr-1"></i>
                                    <?php echo date('M d, Y', strtotime($user['created_at'])) ?>
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <span class="user-role px-3 py-1 rounded-full text-xs <?php echo $roleClass ?>">
                                    <?php echo ucfirst($user['role']) ?>
                                </span>

                                <!-- User Status -->
                                <span class="user-status px-3 py-1 rounded-full text-xs <?php echo $statusClass ?>">
                                    <?php echo isset($user['status']) ? ucfirst($user['status']) : 'Unknown' ?>
                                </span>

                                <!-- Gender if available -->
                                <?php if (isset($user['gender']) && ! empty($user['gender'])): ?>
                                    <span class="user-gender px-3 py-1 rounded-full text-xs bg-indigo-50 text-indigo-600">
                                        <i class="fas <?php echo $genderIcon ?> mr-1"></i>
                                        <?php echo ucfirst($user['gender']) ?>
                                    </span>
                                <?php endif; ?>

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                    <a href="<?php echo base_url('admin/posts?u=' . $user['id']) ?>" class="hover:text-green-900">
                                        <?php echo number_format($user['post_count'] ?? 0) ?> Posts
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <?php if ($canEdit): ?>
                            <a href="<?php echo base_url('admin/users/edit/' . $user['id']) ?>"
                                class="px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors inline-flex items-center">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        <?php endif; ?>

                        <?php if ($canEdit && $user['id'] !== $currentUserId): ?>
                            <a href="<?php echo base_url('admin/users/delete/' . $user['id']) ?>"
                                class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors inline-flex items-center"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="fas fa-trash mr-1"></i>
                                Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Gradient bar at bottom -->
            <div class="h-1 bg-gradient-to-r <?php echo $gradientClass ?>"></div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Empty State (shown when no users match filter) -->
<div id="empty-state" class="hidden text-center py-12 bg-white rounded-xl shadow-sm mt-6">
    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas fa-users text-3xl text-gray-400"></i>
    </div>
    <h3 class="text-xl font-medium text-gray-900 mb-2">No users found</h3>
    <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
    <button onclick="resetSearch()" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
        <i class="fas fa-redo mr-2"></i> Reset Search
    </button>
</div>

<!-- Pagination -->
<?php if (isset($pager)): ?>
    <div class="mt-8 flex justify-center">
        <?php echo $pager->links() ?>
    </div>
<?php endif; ?>

<style>
    .bg-grid-white\/20 {
        mask-image: linear-gradient(to bottom, transparent, black);
    }

    .bg-grid-8 {
        background-size: 40px 40px;
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    }

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
    function filterUsers() {
        const searchTerm = document.getElementById('user-search').value.toLowerCase();
        const roleFilter = document.getElementById('role-filter').value.toLowerCase();
        const statusFilter = document.getElementById('status-filter').value.toLowerCase();
        const genderFilter = document.getElementById('gender-filter').value.toLowerCase();
        const userCards = document.querySelectorAll('.user-card');
        let visibleCount = 0;

        // Optimize loop by caching selectors and avoiding repeated DOM lookups
        userCards.forEach(card => {
            // Cache all DOM elements we need
            const name = card.querySelector('.user-name').textContent.toLowerCase();
            const role = card.querySelector('.user-role').textContent.toLowerCase();
            const statusEl = card.querySelector('.user-status');
            const genderEl = card.querySelector('.user-gender');

            const status = statusEl ? statusEl.textContent.trim().toLowerCase() : '';
            const gender = genderEl ? genderEl.textContent.trim().toLowerCase() : '';

            // Fast checks using cached values
            if ((searchTerm === '' || name.includes(searchTerm)) &&
                (roleFilter === '' || role.includes(roleFilter)) &&
                (statusFilter === '' || status.includes(statusFilter)) &&
                (genderFilter === '' || gender.includes(genderFilter))) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state based on count
        document.getElementById('empty-state').classList.toggle('hidden', visibleCount > 0);
    }

    function resetSearch() {
        ['user-search', 'role-filter', 'status-filter', 'gender-filter'].forEach(id => {
            document.getElementById(id).value = '';
        });
        filterUsers();
    }
</script>
<?php echo $this->endSection() ?>