<!-- Latest Posts Section -->
<div class="container mx-auto px-4 mb-16">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold leading-relaxed">Latest Posts</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($latestPosts as $post): ?>
            <article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                <?php if (!empty($post['thumbnail'])): ?>
                    <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-full h-40 object-cover">
                <?php endif; ?>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-block bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full mr-2 leading-relaxed">
                            <?= esc($post['category_name'] ?? '') ?>
                        </span>
                        <span class="text-xs text-gray-400 font-medium leading-relaxed">
                            <?= date('M d, Y', strtotime($post['published_at'])) ?>
                        </span>
                    </div>
                    <h3 class="text-base font-bold mb-1 line-clamp-2 leading-relaxed">
                        <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                            <?= esc($post['title']) ?>
                        </a>
                    </h3>
                    <p class="text-gray-500 text-sm mb-3 line-clamp-2 leading-relaxed">
                        <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
                    </p>
                    <div class="flex items-center mt-auto pt-2">
                        <?php if (!empty($post['author_avatar'])): ?>
                            <img src="<?= esc($post['author_avatar']) ?>" alt="<?= esc($post['author_name'] ?? 'Author') ?>" class="w-8 h-8 rounded-full mr-3 object-cover">
                        <?php else: ?>
                            <div class="w-8 h-8 rounded-full mr-3 bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <span class="font-semibold text-gray-900 text-sm leading-relaxed block">
                                <?= esc($post['author_name'] ?? 'Author') ?>
                            </span>
                            <span class="block text-xs text-gray-400 font-normal leading-relaxed">
                                <?= esc($post['author_role'] ?? '') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <!-- Modern Pagination -->
    <div class="flex justify-center mt-8">
        <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
            <a href="#" class="px-3 py-1 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 leading-relaxed">&laquo;</a>
            <a href="#" class="px-3 py-1 border-t border-b border-gray-300 bg-white text-blue-600 font-semibold leading-relaxed">1</a>
            <a href="#" class="px-3 py-1 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50 leading-relaxed">2</a>
            <a href="#" class="px-3 py-1 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50 leading-relaxed">3</a>
            <a href="#" class="px-3 py-1 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 leading-relaxed">&raquo;</a>
        </nav>
    </div>
</div>