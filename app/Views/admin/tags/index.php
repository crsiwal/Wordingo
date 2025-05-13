<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
    <!-- Header Section with Animated Background -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-5xl font-bold leading-tight mb-2">Tags</h1>
                <p class="text-blue-100 text-xl">Manage and organize your content with tags</p>
                <div class="flex items-center mt-4 text-blue-100">
                    <span class="flex items-center mr-6">
                        <i class="fas fa-tags mr-2"></i>
                        <span><?php echo count($tags) ?> Tags</span>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span><?php echo array_sum(array_column($tags, 'post_count')) ?? 0 ?> Total Posts</span>
                    </span>
                </div>
            </div>
            <a href="#" class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full mr-2 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Tag
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
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

    <!-- Search and Filter Bar -->
    <div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="tag-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search tags..." onkeyup="filterTags()">
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

    <!-- Tags Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($tags as $tag): ?>
            <div class="tag-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="tag-name text-lg font-semibold text-gray-900">
                            <a href="<?php echo base_url('admin/posts/tag/' . $tag['id']) ?>" class="hover:text-blue-600 transition-colors inline-flex items-center">
                                <i class="fas fa-tag text-blue-500 mr-2"></i>
                                <?php echo esc($tag['name']) ?>
                            </a>
                        </h3>
                        <div class="flex items-center bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-newspaper mr-1"></i>
                            <span><?php echo number_format($tag['post_count'] ?? 0) ?></span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-link mr-1 text-gray-400"></i>
                            <?php echo esc($tag['slug']) ?>
                        </span>
                        <a href="<?php echo base_url('admin/posts/tag/' . $tag['id']) ?>" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            View Posts <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State (shown when no tags match filter) -->
    <div id="empty-state" class="hidden text-center py-12 bg-white rounded-xl shadow-sm mt-6">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-tags text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No tags found</h3>
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
        function filterTags() {
            const searchTerm = document.getElementById('tag-search').value.toLowerCase();
            const tagCards = document.querySelectorAll('.tag-card');
            let visibleCount = 0;
            
            tagCards.forEach(card => {
                const name = card.querySelector('.tag-name').textContent.toLowerCase();
                
                if (name.includes(searchTerm)) {
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
            document.getElementById('tag-search').value = '';
            filterTags();
        }
    </script>
<?php echo $this->endSection() ?>