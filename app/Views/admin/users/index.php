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
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search form -->
        <form id="mainFilterForm" action="<?= base_url('admin/users') ?>" method="get" class="relative flex-grow flex items-center gap-2">
            <?php
            // Generate hidden fields from query params, except for search and sort
            if (!empty($queryParams)) {
                foreach ($queryParams as $key => $value) {
                    if ($key !== 'q' && $key !== 'sort' && !empty($value)) {
                        echo '<input type="hidden" name="' . esc($key) . '" value="' . esc($value) . '">';
                    }
                }
            }
            ?>
            <input type="hidden" name="sort" id="sortInput" value="<?= esc($sort ?? 'name_asc') ?>">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <div class="flex flex-grow">
                <input type="text" name="q" value="<?= esc($queryParams['q'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5" placeholder="Search users...">
                <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg">Search</button>
            </div>
        </form>

        <!-- Sort by Dropdown -->
        <div class="relative">
            <button id="sortDropdownBtn" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-sort-amount-down mr-2"></i> Sort
            </button>
            <div id="sortDropdown" class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-20 hidden">
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-indigo-100 rounded-t-lg sort-option <?= ($sort === 'name_asc') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' ?>" data-value="name_asc">Name A-Z</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-indigo-100 sort-option <?= ($sort === 'name_desc') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' ?>" data-value="name_desc">Name Z-A</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-indigo-100 sort-option <?= ($sort === 'created_at') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' ?>" data-value="created_at">Recently Created</button>
            </div>
        </div>

        <!-- Filter Icon Button -->
        <button id="openFilterModal" class="ml-2 px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg hover:bg-indigo-200 flex items-center gap-2">
            <i class="fas fa-filter"></i>
            <span class="hidden md:inline">Filters</span>
        </button>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl flex overflow-hidden">
        <!-- Left: Filter List -->
        <div class="w-1/3 bg-gray-50 border-r p-6 flex flex-col gap-4">
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-indigo-100" data-filter="role">Role</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-indigo-100" data-filter="gender">Gender</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-indigo-100" data-filter="status">Status</button>
        </div>
        <!-- Right: Filter Content -->
        <div class="w-2/3 p-6">
            <form id="filterForm" action="<?= base_url('admin/users') ?>" method="get" class="h-full flex flex-col justify-between">
                <div id="filterContent">
                    <!-- Role Filter -->
                    <div class="filter-panel" data-filter-panel="role">
                        <label class="block mb-2 font-medium">Role</label>
                        <select name="role" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Roles</option>
                            <?php if (in_array($userRole, ['admin'])): ?>
                                <option value="admin" <?= (isset($queryParams['role']) && $queryParams['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="manager" <?= (isset($queryParams['role']) && $queryParams['role'] === 'manager') ? 'selected' : '' ?>>Manager</option>
                                <option value="editor" <?= (isset($queryParams['role']) && $queryParams['role'] === 'editor') ? 'selected' : '' ?>>Editor</option>
                                <option value="user" <?= (isset($queryParams['role']) && $queryParams['role'] === 'user') ? 'selected' : '' ?>>User</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <!-- Gender Filter -->
                    <div class="filter-panel hidden" data-filter-panel="gender">
                        <label class="block mb-2 font-medium">Gender</label>
                        <select name="gender" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Genders</option>
                            <option value="male" <?= (isset($queryParams['gender']) && $queryParams['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= (isset($queryParams['gender']) && $queryParams['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= (isset($queryParams['gender']) && $queryParams['gender'] === 'other') ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <!-- Status Filter -->
                    <div class="filter-panel hidden" data-filter-panel="status">
                        <label class="block mb-2 font-medium">Status</label>
                        <select name="status" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Status</option>
                            <option value="active" <?= (isset($queryParams['status']) && $queryParams['status'] === 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= (isset($queryParams['status']) && $queryParams['status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            <option value="banned" <?= (isset($queryParams['status']) && $queryParams['status'] === 'banned') ? 'selected' : '' ?>>Banned</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="closeFilterModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Active Filters Display -->
<?php if (!empty($activeFilters['search']) || !empty($activeFilters['role']) || !empty($activeFilters['gender']) || !empty($activeFilters['status'])): ?>
    <div class="mb-6 bg-indigo-50 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center flex-wrap gap-2">
            <span class="text-gray-700 font-medium">Active filters:</span>
            <?php if (!empty($activeFilters['search'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-search mr-1"></i>
                    Search: <?= esc($activeFilters['search']) ?>
                    <a href="<?= base_url('admin/users') ?>" class="ml-2 text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
            <?php if (!empty($activeFilters['role'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-user-shield mr-1"></i>
                    Role: <?= esc(ucfirst($activeFilters['role'])) ?>
                    <a href="<?= base_url('admin/users?' . http_build_query(array_diff_key($queryParams, ['role' => '']))) ?>" class="ml-2 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
            <?php if (!empty($activeFilters['gender'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    <i class="fas fa-venus-mars mr-1"></i>
                    Gender: <?= esc(ucfirst($activeFilters['gender'])) ?>
                    <a href="<?= base_url('admin/users?' . http_build_query(array_diff_key($queryParams, ['gender' => '']))) ?>" class="ml-2 text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
            <?php if (!empty($activeFilters['status'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-user-check mr-1"></i>
                    Status: <?= esc(ucfirst($activeFilters['status'])) ?>
                    <a href="<?= base_url('admin/users?' . http_build_query(array_diff_key($queryParams, ['status' => '']))) ?>" class="ml-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
        </div>
        <a href="<?= base_url('admin/users') ?>" class="text-gray-600 hover:text-gray-800 flex items-center">
            <i class="fas fa-times mr-1"></i> Clear filters
        </a>
    </div>
<?php endif; ?>

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

<!-- Pagination -->
<?php if (isset($pager) && !empty($users)): ?>
    <div class="mt-8 flex justify-center">
        <?php
        // Use our custom pager that handles query parameters automatically
        echo $pager->links('default', 'admin_pager');
        ?>
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
    // Modal open/close
    const openBtn = document.getElementById('openFilterModal');
    const modal = document.getElementById('filterModal');
    const closeBtn = document.getElementById('closeFilterModal');
    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    });

    // Filter tab switching
    const tabs = document.querySelectorAll('.filter-tab');
    const panels = document.querySelectorAll('.filter-panel');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('bg-indigo-100', 'font-bold'));
            tab.classList.add('bg-indigo-100', 'font-bold');
            panels.forEach(panel => {
                if (panel.dataset.filterPanel === tab.dataset.filter) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });
        });
    });
    // Default: show first tab
    if (tabs.length) tabs[0].click();

    // Sort dropdown logic
    const sortBtn = document.getElementById('sortDropdownBtn');
    const sortDropdown = document.getElementById('sortDropdown');
    sortBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sortDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!sortDropdown.classList.contains('hidden')) {
            sortDropdown.classList.add('hidden');
        }
    });
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortInput = document.getElementById('sortInput');
    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            // Get current URL and params
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            // Update or add sort parameter
            params.set('sort', option.dataset.value);

            // Update URL with new params
            url.search = params.toString();
            window.location.href = url.toString();
        });
    });
</script>
<?php echo $this->endSection() ?>