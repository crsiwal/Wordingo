<!-- Featured Blog Section (Horizontal Carousel, Design Accurate) -->
<div class="container mx-auto px-4 sm:px-6 mb-12">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl sm:text-2xl font-bold leading-relaxed">Featured Blog</h2>
        <div class="flex gap-2">
            <button type="button" class="carousel-btn-left-featured group flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 bg-gray-100 border border-gray-200 rounded-full shadow transition hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Scroll left">
                <i class="fas fa-chevron-left text-base sm:text-lg text-blue-600 group-hover:text-white transition"></i>
            </button>
            <button type="button" class="carousel-btn-right-featured group flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 bg-gray-100 border border-gray-200 rounded-full shadow transition hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Scroll right">
                <i class="fas fa-chevron-right text-base sm:text-lg text-blue-600 group-hover:text-white transition"></i>
            </button>
        </div>
    </div>
    <div class="relative">
        <div class="carousel-scroll-featured flex overflow-x-auto gap-4 sm:gap-8 pb-4 snap-x snap-mandatory scroll-smooth hide-scrollbar">
            <?php foreach ($featuredPosts as $post): ?>
                <article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-row min-w-[85vw] sm:min-w-[66vw] md:min-w-[500px] max-w-xl snap-center">
                    <?php if (!empty($post['thumbnail'])): ?>
                        <img src="<?= str_replace('/raw/', '/thumb/', $post['thumbnail']); ?>" alt="<?= esc($post['title']) ?>" class="w-24 sm:w-32 md:w-32 h-full object-cover rounded-l-xl flex-shrink-0">
                    <?php else: ?>
                        <div class="w-24 sm:w-32 md:w-32 h-full bg-gray-200 rounded-l-xl flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-2xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 p-4 sm:p-5 flex flex-col justify-between h-full">
                        <span class="text-xs uppercase text-gray-400 font-semibold mb-1 tracking-wide leading-relaxed"><?= esc($post['category_name'] ?? '') ?></span>
                        <h3 class="text-base sm:text-lg font-bold mb-1 line-clamp-2 leading-relaxed">
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-500 text-xs sm:text-sm mb-2 sm:mb-3 line-clamp-2 leading-relaxed">
                            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
                        </p>
                        <div class="flex items-center mt-auto pt-2">
                            <?php if (!empty($post['author_avatar'])): ?>
                                <img src="<?= esc($post['author_avatar']) ?>" alt="<?= esc($post['author_name'] ?? 'Author') ?>" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full mr-2 sm:mr-3 object-cover">
                            <?php else: ?>
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full mr-2 sm:mr-3 bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <span class="font-semibold text-gray-900 text-xs sm:text-sm leading-relaxed block"><?= esc($post['author_name'] ?? 'Author') ?></span>
                                <span class="block text-[10px] sm:text-xs text-gray-400 font-normal leading-relaxed"><?= esc($post['author_role'] ?? '') ?></span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>