<?php echo $this->extend('layouts/user')?>

<?php echo $this->section('content')?>
<div class="py-8">
    <!-- Page Header -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-3xl font-bold leading-tight mb-2">Saved Posts</h1>
                <p class="text-indigo-100">Articles and content you've bookmarked for later</p>
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

    <!-- Saved Posts Content -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="p-6">
            <?php if (!empty($posts)): ?>
                <div class="space-y-6">
                    <?php foreach ($posts as $post): ?>
                        <div class="flex flex-col md:flex-row border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                            <?php if (isset($post['thumbnail'])): ?>
                                <div class="w-full md:w-56 h-40 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-4 md:mb-0 md:mr-6 flex-shrink-0">
                                    <img src="<?php echo base_url($post['thumbnail']) ?>" alt="<?php echo $post['title'] ?>" class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <?php if (isset($post['category'])): ?>
                                        <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-xs">
                                            <?php echo $post['category'] ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($post['tags']) && is_array($post['tags'])): ?>
                                        <?php foreach ($post['tags'] as $tag): ?>
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs">
                                                <?php echo $tag ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    <a href="<?php echo base_url('posts/' . $post['slug']) ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                        <?php echo $post['title'] ?>
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    <?php echo isset($post['summary']) ? $post['summary'] : substr(strip_tags($post['content']), 0, 120) . '...' ?>
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span><i class="far fa-calendar-alt mr-1"></i> <?php echo date('M d, Y', strtotime($post['created_at'])) ?></span>
                                        <span class="mx-2">•</span>
                                        <span><i class="far fa-clock mr-1"></i> <?php echo isset($post['read_time']) ? $post['read_time'] : '5 min read' ?></span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <a href="<?php echo base_url('posts/' . $post['slug']) ?>" class="text-indigo-600 dark:text-indigo-400 hover:underline mr-4">
                                            Read Now
                                        </a>
                                        <button type="button" class="text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bookmark text-4xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No Saved Posts Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-center max-w-md">
                        You haven't saved any posts yet. When you find interesting content, click the bookmark icon to save it for later reading.
                    </p>
                    <a href="<?php echo base_url('blogs') ?>" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Browse Articles
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo $this->endSection()?> 