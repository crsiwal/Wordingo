<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
    <!-- Header Section with Animated Background -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-5xl font-bold leading-tight mb-2">Categories</h1>
                <p class="text-blue-100 text-xl">Organize your content with powerful categorization</p>
                <div class="flex items-center mt-4 text-blue-100">
                    <span class="flex items-center mr-6">
                        <i class="fas fa-layer-group mr-2"></i>
                        <span><?php echo count($categories) ?> Categories</span>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span><?php echo array_sum(array_column($categories, 'post_count')) ?? 0 ?> Total Posts</span>
                    </span>
                </div>
            </div>
            <?php if ($userRole === 'admin'): ?>
            <a href="<?php echo base_url('admin/categories/create') ?>"
               class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full mr-2 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Category
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
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="category-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search categories..." onkeyup="filterCategories()">
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                    <i class="fas fa-sort-amount-down mr-2"></i> Sort
                </button>
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($categories as $category): ?>
            <div class="category-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="category-name text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                            <a href="<?php echo base_url('blog/category/' . $category['slug']) ?>" class="inline-flex items-center">
                                <?php echo esc($category['name']) ?>
                                <i class="fas fa-external-link-alt ml-2 text-sm text-gray-400"></i>
                            </a>
                        </h3>
                        <div class="flex gap-1">
                            <?php if ($userRole === 'admin'): ?>
                            <a href="<?php echo base_url('admin/categories/edit/' . $category['id']) ?>"
                               class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo base_url('admin/categories/delete/' . $category['id']) ?>"
                               class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors"
                               onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-link mr-2 text-gray-400"></i>
                        <span class="category-slug truncate"><?php echo esc($category['slug']) ?></span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-newspaper text-blue-500 mr-2"></i>
                                <span><?php echo number_format($category['post_count'] ?? 0) ?> Posts</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                                <span><?php echo date('M d, Y', strtotime($category['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State (shown when no categories match filter) -->
    <div id="empty-state" class="hidden text-center py-12 bg-white rounded-xl shadow-sm mt-6">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-folder-open text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No categories found</h3>
        <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
        <button onclick="resetSearch()" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
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
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>

    <script>
        function filterCategories() {
            const searchTerm = document.getElementById('category-search').value.toLowerCase();
            const categoryCards = document.querySelectorAll('.category-card');
            let visibleCount = 0;

            categoryCards.forEach(card => {
                const name = card.querySelector('.category-name').textContent.toLowerCase();
                const slug = card.querySelector('.category-slug').textContent.toLowerCase();

                if (name.includes(searchTerm) || slug.includes(searchTerm)) {
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
            document.getElementById('category-search').value = '';
            filterCategories();
        }
    </script>
<?php echo $this->endSection() ?>