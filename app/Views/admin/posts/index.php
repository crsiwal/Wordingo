<?php echo $this->extend('layouts/admin')?>

<?php echo $this->section('content')?>
    <!-- Header Section with Animated Background -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-5xl font-bold leading-tight mb-2">Posts</h1>
                <p class="text-blue-100 text-xl">Manage and publish your blog content</p>
                <div class="flex items-center mt-4 text-blue-100">
                    <span class="flex items-center mr-6">
                        <i class="fas fa-file-alt mr-2"></i>
                        <span><?php echo count($posts)?> Posts</span>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        <span><?php echo number_format(array_sum(array_column($posts, 'views')))?> Total Views</span>
                    </span>
                </div>
            </div>
            <a href="<?php echo base_url('admin/posts/create')?>" class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full mr-2 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Post
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
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

    <!-- Search and Filter Bar -->
    <div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="post-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search posts..." onkeyup="filterPosts()">
            </div>
            <div class="flex gap-2">
                <select id="status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" onchange="filterPosts()">
                    <option value="">All Statuses</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                    <i class="fas fa-sort-amount-down mr-2"></i> Sort
                </button>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 gap-6">
        <?php foreach ($posts as $post): ?>
            <div class="post-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col md:flex-row">
                    <?php if ($post['thumbnail']): ?>
                        <div class="w-full md:w-48 h-48 overflow-hidden bg-gray-100 flex-shrink-0">
                            <img src="<?php echo $post['thumbnail']?>" alt="<?php echo esc($post['title'])?>" class="w-full h-full object-cover">
                        </div>
                    <?php else: ?>
                        <div class="w-full md:w-48 h-48 bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-image text-gray-300 text-4xl"></i>
                        </div>
                    <?php endif; ?>

                    <div class="p-6 flex-grow">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div>
                                <h3 class="post-title text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors mb-2">
                                    <a href="<?php echo base_url('admin/posts/edit/' . $post['id'])?>">
                                        <?php echo esc($post['title'])?>
                                    </a>
                                </h3>

                                <!-- Add the description section right after the title -->
                                <p class="post-description text-gray-600 mb-4">
                                    <?php
                                    // Show the SEO description if available, otherwise show truncated content
                                    echo !empty($post['description'])
                                        ? esc($post['description'])
                                        : character_limiter(strip_tags($post['content'] ?? ''), 160);
                                    ?>
                                </p>

                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-folder text-blue-400 mr-1"></i>
                                        <?php echo esc($post['category_name'] ?? 'Uncategorized')?>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar text-purple-400 mr-1"></i>
                                        <?php echo date('M d, Y', strtotime($post['created_at']))?>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-eye text-green-400 mr-1"></i>
                                        <?php echo number_format($post['views'] ?? 0)?> views
                                    </span>
                                    <?php if (isset($post['author_name'])): ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-user text-indigo-400 mr-1"></i>
                                        <?php echo esc($post['author_name'])?>
                                    </span>
                                    <?php endif; ?>
                                    <span class="post-status px-2 py-1 rounded-full text-xs <?php echo $post['status'] === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'?>">
                                        <?php echo ucfirst($post['status'])?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <?php
                                // Admin can edit all posts
                                // Manager can edit their own posts and posts from their editors
                                // Editor can only edit their own posts
                                $canEdit = ($userRole === 'admin') ||
                                           ($userRole === 'manager' && ($post['user_id'] == $userId ||
                                                                       (isset($post['parent_id']) && $post['parent_id'] == $userId))) ||
                                           ($post['user_id'] == $userId);

                                if ($canEdit):
                                ?>
                                <a href="<?php echo base_url('admin/posts/edit/' . $post['id'])?>"
                                   class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors inline-flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <?php endif; ?>

                                <a href="<?php echo base_url('blog/' . $post['slug'])?>"
                                   target="_blank"
                                   class="px-3 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors inline-flex items-center">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    View
                                </a>

                                <?php if ($canEdit): ?>
                                <a href="<?php echo base_url('admin/posts/delete/' . $post['id'])?>"
                                   class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors inline-flex items-center"
                                   onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gradient bar at bottom -->
                <div class="h-1 bg-gradient-to-r <?php echo $post['status'] === 'published' ? 'from-green-500 to-blue-500' : 'from-yellow-500 to-orange-500'?>"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State (shown when no posts match filter) -->
    <div id="empty-state" class="hidden text-center py-12 bg-white rounded-xl shadow-sm mt-6">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-file-alt text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No posts found</h3>
        <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
        <button onclick="resetSearch()" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
            <i class="fas fa-redo mr-2"></i> Reset Search
        </button>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
        <div class="mt-8 flex justify-center">
            <?php echo $pager->links()?>
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
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>

    <script>
        function filterPosts() {
            const searchTerm = document.getElementById('post-search').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value.toLowerCase();
            const postCards = document.querySelectorAll('.post-card');
            let visibleCount = 0;

            postCards.forEach(card => {
                const title = card.querySelector('.post-title').textContent.toLowerCase();
                const status = card.querySelector('.post-status').textContent.toLowerCase();

                const matchesSearch = title.includes(searchTerm);
                const matchesStatus = statusFilter === '' || status.includes(statusFilter);

                if (matchesSearch && matchesStatus) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state
            const emptyState = document.getElementById('empty-state');
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        function resetSearch() {
            document.getElementById('post-search').value = '';
            document.getElementById('status-filter').value = '';
            filterPosts();
        }
    </script>
<?php echo $this->endSection()?>