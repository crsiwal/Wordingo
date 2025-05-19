<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Ads</h1>
            <p class="text-blue-100 text-xl">Manage advertising content across your website</p>
            <div class="flex items-center mt-4 text-blue-100">
                <span class="flex items-center mr-6">
                    <i class="fas fa-ad mr-2"></i>
                    <span><?php echo count($ads) ?> Ads</span>
                </span>
                <span class="flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    <span><?php echo array_sum(array_column($ads, 'views')) ?? 0 ?> Total Views</span>
                </span>
                <span class="flex items-center ml-6">
                    <i class="fas fa-mouse-pointer mr-2"></i>
                    <span><?php echo array_sum(array_column($ads, 'clicks')) ?? 0 ?> Total Clicks</span>
                </span>
            </div>
        </div>
        <?php if ($userRole === 'admin'): ?>
            <a href="<?php echo base_url('admin/ads/create') ?>"
                class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full mr-2 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Ad
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Animated bubbles background effect -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="absolute rounded-full bg-white/30"
                style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search form -->
        <form id="mainFilterForm" action="<?= base_url('admin/ads') ?>" method="get" class="relative flex-grow flex items-center gap-2">
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
            <input type="hidden" name="sort" id="sortInput" value="<?= esc($sort ?? 'title_asc') ?>">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <div class="flex flex-grow">
                <input type="text" name="q" value="<?= esc($queryParams['q'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search ads...">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Search</button>
            </div>
        </form>

        <!-- Sort by Dropdown -->
        <div class="relative">
            <button id="sortDropdownBtn" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-sort-amount-down mr-2"></i> Sort
            </button>
            <div id="sortDropdown" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-20 hidden">
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-t-lg sort-option <?= ($sort === 'title_asc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="title_asc">Title A-Z</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'title_desc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="title_desc">Title Z-A</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'views') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="views">Most Views</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'clicks') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="clicks">Most Clicks</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'priority') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="priority">Priority</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'slot') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="slot">Slot</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-b-lg sort-option <?= ($sort === 'created_at') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="created_at">Recently Created</button>
            </div>
        </div>

        <!-- Filter Icon Button -->
        <button id="openFilterModal" class="ml-2 px-4 py-2 bg-gray-100 text-blue-600 rounded-lg hover:bg-blue-200 flex items-center gap-2">
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
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="slot">Ad Slot</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="category">Category</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="status">Status</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="date">Date Range</button>
        </div>
        <!-- Right: Filter Content -->
        <div class="w-2/3 p-6">
            <form id="filterForm" action="<?= base_url('admin/ads') ?>" method="get" class="h-full flex flex-col justify-between">
                <div id="filterContent">
                    <!-- Slot Filter -->
                    <div class="filter-panel" data-filter-panel="slot">
                        <label class="block mb-2 font-medium">Ad Slot</label>
                        <select name="slot" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Slots</option>
                            <?php foreach ($slots as $slot): ?>
                                <option value="<?= $slot['id'] ?>" <?= (isset($queryParams['slot']) && $queryParams['slot'] == $slot['id']) ? 'selected' : '' ?>><?= esc($slot['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Category Filter -->
                    <div class="filter-panel hidden" data-filter-panel="category">
                        <label class="block mb-2 font-medium">Category</label>
                        <select name="category" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Categories</option>
                            <?php foreach ($categories ?? [] as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= (isset($queryParams['category']) && $queryParams['category'] == $category['id']) ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Status Filter -->
                    <div class="filter-panel hidden" data-filter-panel="status">
                        <label class="block mb-2 font-medium">Status</label>
                        <select name="status" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Status</option>
                            <option value="active" <?= (isset($queryParams['status']) && $queryParams['status'] === 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= (isset($queryParams['status']) && $queryParams['status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <!-- Date Range Filter -->
                    <div class="filter-panel hidden" data-filter-panel="date">
                        <label class="block mb-2 font-medium">Date Range</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Start Date</label>
                                <input type="date" name="start_date" value="<?= esc($queryParams['start_date'] ?? '') ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">End Date</label>
                                <input type="date" name="end_date" value="<?= esc($queryParams['end_date'] ?? '') ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="closeFilterModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Active Filters Display -->
<?php if (!empty($activeFilters['search']) || !empty($activeFilters['slot']) || !empty($activeFilters['status']) || !empty($activeFilters['category']) || !empty($activeFilters['start_date']) || !empty($activeFilters['end_date'])): ?>
    <div class="mb-6 bg-blue-50 rounded-xl p-4 flex items-center justify-between">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-gray-700 font-medium">Active filters:</span>

            <?php if (!empty($activeFilters['search'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-search mr-1"></i>
                    Search: <?= esc($activeFilters['search']) ?>
                    <a href="<?= base_url('admin/ads?' . http_build_query(array_diff_key($queryParams, ['q' => '']))) ?>" class="ml-2 text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (!empty($activeFilters['slot'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-layer-group mr-1"></i>
                    Slot: <?= esc($slots[array_search($activeFilters['slot'], array_column($slots, 'id'))]['name'] ?? 'Unknown') ?>
                    <a href="<?= base_url('admin/ads?' . http_build_query(array_diff_key($queryParams, ['slot' => '']))) ?>" class="ml-2 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (!empty($activeFilters['category'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <i class="fas fa-folder mr-1"></i>
                    Category: <?= esc($categories[array_search($activeFilters['category'], array_column($categories ?? [], 'id'))]['name'] ?? 'Unknown') ?>
                    <a href="<?= base_url('admin/ads?' . http_build_query(array_diff_key($queryParams, ['category' => '']))) ?>" class="ml-2 text-purple-600 hover:text-purple-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (!empty($activeFilters['status'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-toggle-on mr-1"></i>
                    Status: <?= ucfirst($activeFilters['status']) ?>
                    <a href="<?= base_url('admin/ads?' . http_build_query(array_diff_key($queryParams, ['status' => '']))) ?>" class="ml-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (!empty($activeFilters['start_date']) || !empty($activeFilters['end_date'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                    <i class="fas fa-calendar mr-1"></i>
                    Date:
                    <?php if (!empty($activeFilters['start_date']) && !empty($activeFilters['end_date'])): ?>
                        <?= esc(date('M d, Y', strtotime($activeFilters['start_date']))) ?> - <?= esc(date('M d, Y', strtotime($activeFilters['end_date']))) ?>
                    <?php elseif (!empty($activeFilters['start_date'])): ?>
                        From <?= esc(date('M d, Y', strtotime($activeFilters['start_date']))) ?>
                    <?php else: ?>
                        Until <?= esc(date('M d, Y', strtotime($activeFilters['end_date']))) ?>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/ads?' . http_build_query(array_diff_key($queryParams, ['start_date' => '', 'end_date' => '']))) ?>" class="ml-2 text-orange-600 hover:text-orange-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
        </div>
        <a href="<?= base_url('admin/ads') ?>" class="text-gray-600 hover:text-gray-800 flex items-center">
            <i class="fas fa-times mr-1"></i> Clear filters
        </a>
    </div>
<?php endif; ?>

<!-- Ads Table -->
<?php if (empty($ads)): ?>
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-ad text-gray-300 text-5xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-700 mb-2">No ads found</h3>
        <p class="text-gray-500 mb-6">There are no ads created yet. Start by creating your first ad.</p>
        <?php if ($userRole === 'admin'): ?>
            <a href="<?= site_url('admin/ads/create') ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Ad
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($ads as $ad): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <!-- Card Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <span class="text-blue-600 font-medium text-sm">
                        <i class="fas fa-arrow-up text-blue-500 mr-1"></i> Priority: <?= $ad['priority'] ?>
                    </span>

                    <div class="bg-gray-200 rounded-md w-12 h-12 flex items-center justify-center text-gray-500">
                        <i class="fas fa-ad text-xl"></i>
                    </div>

                    <span class="font-medium text-sm <?= $ad['is_active'] ? '' : 'text-gray-500' ?>">
                        <?php if ($ad['is_active']): ?>
                            <i class="fas fa-check-circle text-green-500 mr-1"></i> <span class="text-green-500">Active</span>
                        <?php else: ?>
                            <i class="fas fa-ban text-gray-500 mr-1"></i> <span class="text-gray-500">Inactive</span>
                        <?php endif; ?>
                    </span>
                </div>

                <!-- Card Body -->
                <div class="p-4">
                    <!-- Title -->
                    <h3 class="text-lg font-medium text-gray-800 mb-2"><?= esc($ad['title']) ?></h3>

                    <!-- Link -->
                    <a href="<?= esc($ad['target_url']) ?>" target="_blank" class="text-blue-500 text-sm mb-4 block truncate hover:underline">
                        <i class="fas fa-external-link-alt mr-1"></i> <?= esc(substr($ad['target_url'], 0, 40) . (strlen($ad['target_url']) > 40 ? '...' : '')) ?>
                    </a>

                    <!-- Slot & Category -->
                    <div class="flex flex-wrap gap-2 my-3">
                        <?php if (!empty($ad['slot_name'])): ?>
                            <span class="text-blue-600 text-xs bg-blue-50 px-2 py-1 rounded-full">
                                <i class="fas fa-layer-group mr-1"></i> <?= esc($ad['slot_name']) ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($ad['category_name'])): ?>
                            <span class="text-purple-600 text-xs bg-purple-50 px-2 py-1 rounded-full">
                                <i class="fas fa-folder mr-1"></i> <?= esc($ad['category_name']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Stats Area -->
                    <div class="grid grid-cols-3 gap-4 text-center py-3 border-t border-b border-gray-100 my-4">
                        <div>
                            <div class="text-gray-500 text-xs mb-1">Views</div>
                            <div class="font-bold text-gray-800"><?= number_format($ad['views']) ?></div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-xs mb-1">Clicks</div>
                            <div class="font-bold text-gray-800"><?= number_format($ad['clicks']) ?></div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-xs mb-1">CTR</div>
                            <div class="font-bold text-<?= $ad['views'] > 0 && ($ad['clicks'] / $ad['views']) * 100 > 0 ? 'green-600' : 'gray-800' ?>">
                                <?= $ad['views'] > 0 ? number_format(($ad['clicks'] / $ad['views']) * 100, 2) : '0.00' ?>%
                            </div>
                        </div>
                    </div>



                    <div class="flex flex-row gap-2 justify-between">
                        <!-- Max Views if set -->
                        <?php if (!empty($ad['max_views'])): ?>
                            <div title="Max views" class="text-gray-600 text-sm mb-4">
                                <i class="fas fa-eye text-gray-400 mr-1"></i> Max: <?= number_format($ad['max_views']) ?>
                            </div>
                        <?php else: ?>
                            <div title="Max views" class="text-gray-600 text-sm mb-4">
                                <i class="fas fa-eye text-gray-400 mr-1"></i> Unlimited
                            </div>
                        <?php endif; ?>

                        <!-- Max Clicks if set -->
                        <?php if (!empty($ad['max_clicks'])): ?>
                            <div title="Max clicks" class="text-gray-600 text-sm mb-4">
                                <i class="fas fa-mouse-pointer text-gray-400 mr-1"></i> Max: <?= number_format($ad['max_clicks']) ?>
                            </div>
                        <?php else: ?>
                            <div title="Max clicks" class="text-gray-600 text-sm mb-4">
                                <i class="fas fa-mouse-pointer text-gray-400 mr-1"></i> Unlimited
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <?php if ($userRole === 'admin'): ?>
                        <div class="flex justify-between mt-4 pt-2">
                            <a href="<?= base_url('admin/ads/edit/' . $ad['id']) ?>"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="<?= base_url('admin/ads/resetStats/' . $ad['id']) ?>"
                                onclick="return confirm('Are you sure you want to reset statistics for this ad? This will set views and clicks to zero.')"
                                class="text-purple-600 hover:text-purple-800">
                                <i class="fas fa-redo-alt mr-1"></i> Reset Stats
                            </a>
                            <a href="<?= base_url('admin/ads/delete/' . $ad['id']) ?>"
                                onclick="return confirm('Are you sure you want to delete this ad? This cannot be undone.')"
                                class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
        <div class="mt-8 flex justify-center">
            <?php echo $pager->links('default', 'admin_pager'); ?>
        </div>
    <?php endif; ?>
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
            tabs.forEach(t => t.classList.remove('bg-blue-100', 'font-bold'));
            tab.classList.add('bg-blue-100', 'font-bold');
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