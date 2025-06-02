<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>

<?php
// Parse query string into array once
$queryParams = [];
if (!empty($queryString)) {
    parse_str($queryString, $queryParams);
}
?>

<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-6 md:p-8 shadow-lg border border-blue-200">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-6">
        <div class="text-white">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-1 md:mb-2 tracking-tight">Posts</h1>
            <p class="text-blue-100 text-lg md:text-xl">Manage and publish your blog content</p>
            <div class="flex items-center mt-3 md:mt-4 text-blue-100 text-sm md:text-base">
                <span class="flex items-center mr-4 md:mr-6">
                    <i class="fas fa-list mr-2"></i>
                    <span><?php echo $totalPosts; ?> Total</span>
                </span>
                <span class="flex items-center mr-4 md:mr-6">
                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                    <a href="<?php echo base_url('admin/posts?s=published'); ?>" class="text-blue-100 hover:text-white">
                        <?php echo $publishedPosts; ?> Published
                    </a>
                </span>
                <span class="flex items-center">
                    <i class="fas fa-pencil-alt text-yellow-300 mr-2"></i>
                    <a href="<?php echo base_url('admin/posts?s=draft'); ?>" class="text-blue-100 hover:text-white">
                        <?php echo $draftPosts; ?> Drafts
                    </a>
                </span>
            </div>
        </div>
        <a href="<?php echo base_url('admin/posts/create') ?>" class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex items-center gap-2 sticky md:static bottom-4 right-4 z-50">
            <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-plus"></i>
            </span>
            <span>New Post</span>
        </a>
    </div>
    <!-- Animated bubbles background effect -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="absolute rounded-full bg-white/30"
                style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<?php if (!empty($activeFilters)): ?>
    <!-- Active Filters Display -->
    <div class="mb-6 bg-blue-50 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center flex-wrap gap-2">
            <span class="text-gray-700 font-medium">Active filters:</span>
            <?php if (isset($activeFilters['category'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-folder mr-1"></i>
                    Category: <?php echo esc($activeFilters['category']) ?>
                    <a href="<?php
                                $params = $queryParams;
                                unset($params['c']);
                                echo base_url('admin/posts' . (empty($params) ? '' : '?' . http_build_query($params)));
                                ?>"
                        class="ml-2 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (isset($activeFilters['tag'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <i class="fas fa-tag mr-1"></i>
                    Tag: <?php echo esc($activeFilters['tag']) ?>
                    <a href="<?php
                                $params = $queryParams;
                                unset($params['t']);
                                echo base_url('admin/posts' . (empty($params) ? '' : '?' . http_build_query($params)));
                                ?>"
                        class="ml-2 text-purple-600 hover:text-purple-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (isset($activeFilters['status'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i>
                    Status: <?php echo esc($activeFilters['status']) ?>
                    <a href="<?php
                                $params = $queryParams;
                                unset($params['s']);
                                echo base_url('admin/posts' . (empty($params) ? '' : '?' . http_build_query($params)));
                                ?>"
                        class="ml-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (isset($activeFilters['search'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-search mr-1"></i>
                    Search: <?php echo esc($activeFilters['search']) ?>
                    <a href="<?php
                                $params = $queryParams;
                                unset($params['q']);
                                echo base_url('admin/posts' . (empty($params) ? '' : '?' . http_build_query($params)));
                                ?>"
                        class="ml-2 text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>

            <?php if (isset($activeFilters['user'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    <i class="fas fa-user mr-1"></i>
                    Author: <?php echo esc($activeFilters['user']) ?>
                    <a href="<?php
                                $params = $queryParams;
                                unset($params['u']);
                                echo base_url('admin/posts' . (empty($params) ? '' : '?' . http_build_query($params)));
                                ?>"
                        class="ml-2 text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            <?php endif; ?>
        </div>

        <a href="<?php echo base_url('admin/posts') ?>" class="text-gray-600 hover:text-gray-800 flex items-center">
            <i class="fas fa-times mr-1"></i> Clear filters
        </a>
    </div>
<?php endif; ?>

<!-- Search and Filter Bar -->
<div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search form -->
        <form id="mainFilterForm" action="<?php echo base_url('admin/posts') ?>" method="get" class="relative flex-grow flex items-center gap-2">
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
            <input type="hidden" name="sort" id="sortInput" value="<?php echo esc($sort ?? 'created_at') ?>">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <div class="flex flex-grow relative">
                <input type="text" name="q" value="<?php echo esc($queryParams['q'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-3" placeholder="Search posts...">
                <?php if (!empty($queryParams['q'])): ?>
                    <button type="button" onclick="document.querySelector('[name=\'q\']').value=''; document.getElementById('mainFilterForm').submit();" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500" aria-label="Clear search">
                        <i class="fas fa-times-circle"></i>
                    </button>
                <?php endif; ?>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Search</button>
            </div>
        </form>

        <!-- Sort by Dropdown -->
        <div class="relative">
            <button id="sortDropdownBtn" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-sort-amount-down mr-2"></i> Sort
            </button>
            <div id="sortDropdown" class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-20 hidden">
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-t-lg sort-option <?php echo ($sort === 'name_asc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="name_asc">Post Title A-Z</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?php echo ($sort === 'name_desc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="name_desc">Post Title Z-A</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?php echo ($sort === 'created_at') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="created_at">Recently Created</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?php echo ($sort === 'updated_at') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="updated_at">Recently Updated</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-b-lg sort-option <?php echo ($sort === 'published_at') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="published_at">Recently Published</button>
            </div>
        </div>

        <!-- Filter Icon Button -->
        <button id="openFilterModal" class="ml-2 px-4 py-3 bg-gray-100 text-blue-600 rounded-lg hover:bg-blue-200 flex items-center gap-2">
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
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="status">Status</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="category">Category</button>
            <button type="button" class="filter-tab text-left py-2 px-3 rounded-lg hover:bg-blue-100" data-filter="featured">Featured</button>
        </div>
        <!-- Right: Filter Content -->
        <div class="w-2/3 p-6">
            <form id="filterForm" action="<?php echo base_url('admin/posts') ?>" method="get" class="h-full flex flex-col justify-between">
                <div id="filterContent">
                    <!-- Status Filter (default) -->
                    <div class="filter-panel" data-filter-panel="status">
                        <label class="block mb-2 font-medium">Status</label>
                        <select name="s" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Statuses</option>
                            <option value="published" <?php echo isset($queryParams['s']) && $queryParams['s'] === 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="draft" <?php echo isset($queryParams['s']) && $queryParams['s'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </div>
                    <!-- Category Filter -->
                    <div class="filter-panel hidden" data-filter-panel="category">
                        <label class="block mb-2 font-medium">Category</label>
                        <select name="c" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Categories</option>
                            <?php foreach ($allCategories as $cat): ?>
                                <option value="<?php echo esc($cat['slug']) ?>" <?php echo isset($queryParams['c']) && $queryParams['c'] === $cat['slug'] ? 'selected' : '' ?>>
                                    <?php echo esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Featured Filter -->
                    <div class="filter-panel hidden" data-filter-panel="featured">
                        <label class="block mb-2 font-medium">Featured</label>
                        <select name="featured" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5">
                            <option value="">All Posts</option>
                            <option value="1" <?php echo isset($queryParams['featured']) && $queryParams['featured'] === '1' ? 'selected' : '' ?>>Featured Only</option>
                            <option value="0" <?php echo isset($queryParams['featured']) && $queryParams['featured'] === '0' ? 'selected' : '' ?>>Not Featured</option>
                        </select>
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


<!-- Posts Grid -->
<div class="grid grid-cols-1 gap-6">
    <?php if (empty($posts)): ?>
        <!-- Empty State (when no posts match filter) -->
        <div class="text-center py-12 bg-white rounded-xl shadow-md mt-6">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-file-alt text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No posts found</h3>
            <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
            <a href="<?php echo base_url('admin/posts') ?>" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors inline-flex items-center">
                <i class="fas fa-redo mr-2"></i> Clear all filters
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-transparent w-full overflow-hidden" style="border-bottom: 5px solid <?php echo $post['status'] === 'published' ? 'rgb(21 128 61 / var(--tw-text-opacity, 1))' : 'rgb(161 98 7 / var(--tw-text-opacity, 1))' ?>">
                <div class="flex flex-col md:flex-row relative w-full">
                    <!-- Image on the left (md+), top on mobile -->
                    <div class="flex items-center justify-center relative md:w-24 flex-shrink-0">
                        <?php if ($post['thumbnail']): ?>
                            <div class="w-full h-24 overflow-hidden bg-gray-100 flex-shrink-0 md:rounded-r-xl md:rounded-r-none">
                                <img src="<?php echo $post['thumbnail'] ?>" alt="<?php echo esc($post['title']) ?>" class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="w-full h-24 flex items-center justify-center overflow-hidden bg-gray-400 md:rounded-r-xl md:rounded-r-none">
                                <i class="fas fa-image text-gray-300 text-4xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Content -->
                    <div class="flex flex-col flex-1 p-4 md:p-6 w-full max-w-[90%]">
                        <div class="flex flex-col gap-2 md:gap-4 w-full">
                            <div class="flex sm:flex-row gap-2 mb-1 items-start sm:items-center sm:justify-between w-full">
                                <div class="flex-1 min-w-0">
                                    <h3 class="post-title text-lg md:text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors truncate block w-full flex items-center gap-2">
                                        <a href="<?php echo base_url('admin/posts/edit/' . $post['id']) ?>" class="truncate block w-full">
                                            <?php echo esc($post['title']) ?>
                                        </a>
                                        <?php if (!empty($post['is_featured'])): ?>
                                            <span title="Featured" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 shadow-lg text-white text-lg animate-pulse" data-tooltip="Featured post">
                                                <i class="fas fa-star"></i>
                                            </span>
                                        <?php endif; ?>
                                    </h3>
                                </div>
                                <div class="flex flex-row gap-2 mt-2 sm:mt-0 order-2 sm:order-none flex-shrink-0 flex-nowrap">
                                    <?php
                                    $canEdit = ($userRole === 'admin') ||
                                        ($userRole === 'manager' && ($post['user_id'] == $userId || (isset($post['parent_id']) && $post['parent_id'] == $userId))) ||
                                        ($post['user_id'] == $userId);
                                    if ($canEdit):
                                    ?>
                                        <a href="<?php echo base_url('admin/posts/edit/' . $post['id']) ?>"
                                            class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors inline-flex items-center justify-center text-sm"
                                            aria-label="Edit post">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url('blog/' . $post['slug']) ?>"
                                        target="_blank"
                                        class="px-3 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors inline-flex items-center justify-center text-sm"
                                        aria-label="View post">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        View
                                    </a>
                                    <button onclick="navigator.clipboard.writeText('<?php echo base_url('blog/' . $post['slug']) ?>'); this.setAttribute('aria-label','Copied!'); setTimeout(()=>this.setAttribute('aria-label','Copy post link'),1000);" class="px-3 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors inline-flex items-center justify-center text-sm" aria-label="Copy post link">
                                        <i class="fas fa-link mr-1"></i>
                                        Copy
                                    </button>
                                    <?php if ($canEdit): ?>
                                        <a href="<?php echo base_url('admin/posts/delete/' . $post['id']) ?>"
                                            class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors inline-flex items-center justify-center text-sm"
                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                            aria-label="Delete post">
                                            <i class="fas fa-trash mr-1"></i>
                                            Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="post-description text-gray-600 text-sm md:text-base line-clamp-2 md:line-clamp-3">
                                <?php
                                echo !empty($post['description'])
                                    ? esc($post['description'])
                                    : character_limiter(strip_tags($post['content'] ?? ''), 160);
                                ?>
                            </p>

                            <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-2 sm:gap-3 text-xs md:text-sm text-gray-500 mb-2 md:mb-4">
                                <span class="flex items-center">
                                    <i class="fas fa-folder text-blue-400 mr-1"></i>
                                    <a href="<?php
                                                $params = $queryParams;
                                                $params['c'] = $post['category_slug'] ?? '';
                                                echo base_url('admin/posts?' . http_build_query($params));
                                                ?>" class="hover:text-blue-600 transition-colors truncate">
                                        <?php echo esc($post['category_name'] ?? 'Uncategorized') ?>
                                    </a>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar text-purple-400 mr-1"></i>
                                    <?php echo date('M d, Y', strtotime($post['created_at'])) ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye text-green-400 mr-1"></i>
                                    <?php echo number_format($post['views'] ?? 0) ?> views
                                </span>
                                <?php if (isset($post['author_name'])): ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-user text-indigo-400 mr-1"></i>
                                        <a href="<?php
                                                    $params = $queryParams;
                                                    $params['u'] = $post['user_id'];
                                                    echo base_url('admin/posts?' . http_build_query($params));
                                                    ?>" class="hover:text-indigo-600 transition-colors truncate">
                                            <?php echo esc($post['author_name']) ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                                <a href="<?php
                                            $params = $queryParams;
                                            $params['s'] = $post['status'];
                                            echo base_url('admin/posts?' . http_build_query($params));
                                            ?>" class="post-status px-2 py-1 rounded-full text-xs <?php echo $post['status'] === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?php echo ucfirst($post['status']) ?>
                                </a>
                                <?php if (isset($postTags[$post['id']])): ?>
                                    <div class="flex flex-wrap gap-1 mt-1 w-full">
                                        <?php foreach ($postTags[$post['id']] as $tag): ?>
                                            <a href="<?php
                                                        $params = $queryParams;
                                                        $params['t'] = $tag['slug'];
                                                        echo base_url('admin/posts?' . http_build_query($params));
                                                        ?>"
                                                class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full hover:bg-gray-200 transition-colors truncate max-w-xs"
                                                title="<?php echo esc($tag['name']) ?>">
                                                <i class="fas fa-tag text-gray-500 mr-1"></i>
                                                <?php echo esc($tag['name']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if (isset($pager) && !empty($posts)): ?>
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

    @media (max-width: 640px) {
        .post-title {
            margin-bottom: 0.5rem;
        }

        .post-card .sm\:flex-row {
            flex-direction: column !important;
            align-items: stretch !important;
        }

        .post-card .sm\:items-center {
            align-items: flex-start !important;
        }

        .post-card .sm\:justify-between {
            justify-content: flex-start !important;
        }

        .post-card .flex-shrink-0 {
            margin-top: 0.5rem;
        }

        .post-card .px-3 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        .post-card .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
    }

    .post-card:hover {
        cursor: pointer;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    [data-tooltip]:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translateX(-50%);
        background: #222;
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        margin-top: 4px;
        z-index: 10;
        pointer-events: none;
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