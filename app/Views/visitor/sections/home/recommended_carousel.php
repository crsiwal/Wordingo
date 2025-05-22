<!-- Recommended Blog Section (Horizontal Carousel) -->
<div class="container mx-auto px-4 mb-12">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold leading-relaxed">Recommended Blog</h2>
        <div class="flex gap-2">
            <button type="button" class="carousel-btn-left-recommended group flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 bg-gray-100 border border-gray-200 rounded-full shadow transition hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Scroll left">
                <i class="fas fa-chevron-left text-base sm:text-lg text-blue-600 group-hover:text-white transition"></i>
            </button>
            <button type="button" class="carousel-btn-right-recommended group flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 bg-gray-100 border border-gray-200 rounded-full shadow transition hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Scroll right">
                <i class="fas fa-chevron-right text-base sm:text-lg text-blue-600 group-hover:text-white transition"></i>
            </button>
        </div>
    </div>
    <div class="relative">
        <div class="carousel-scroll-recommended flex overflow-x-auto gap-8 pb-4 snap-x snap-mandatory scroll-smooth hide-scrollbar">
            <?php foreach ($latestPosts as $post): ?>
                <article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col min-w-[320px] md:min-w-[350px] max-w-xs snap-center">
                    <?php if ($post['thumbnail']): ?>
                        <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-full h-40 object-cover">
                    <?php endif; ?>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-xs uppercase text-gray-500 font-semibold mb-2 leading-relaxed"><?= esc($post['category_name'] ?? '') ?></span>
                        <h3 class="text-lg font-semibold mb-2 leading-relaxed">
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4 flex-1 leading-relaxed">
                            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
                        </p>
                        <div class="flex items-center text-xs text-gray-500 mt-auto leading-relaxed">
                            <span class="mr-2">
                                <i class="fas fa-user"></i> <?= esc($post['author_name'] ?? 'Author') ?>
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>