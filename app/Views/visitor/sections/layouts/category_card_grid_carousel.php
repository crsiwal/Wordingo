<?php
// Layout Key: CarouselGrid
?>
<article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col min-w-[320px] md:min-w-[350px] max-w-xs snap-center">
    <a href="<?= postUrl($post) ?>">
        <?php if (!empty($post['thumbnail'])): ?>
            <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-full h-40 object-cover">
        <?php else: ?>
            <div class="w-full h-40 bg-gray-200 rounded-t-xl flex items-center justify-center">
                <i class="fas fa-image text-gray-500 text-2xl"></i>
            </div>
        <?php endif; ?>
    </a>
    <div class="p-6 flex-1 flex flex-col">
        <span class="text-xs uppercase text-gray-500 font-semibold mb-2 leading-relaxed">
            <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-gray-900 hover:text-green-600">
                <?= esc($post['category_name']) ?>
            </a>
        </span>
        <h3 class="text-base font-bold mb-1 line-clamp-2 leading-relaxed">
            <a href="<?= postUrl($post) ?>" class="text-gray-900 hover:text-blue-600">
                <?= esc($post['title']) ?>
            </a>
        </h3>
        <p class="text-gray-600 mb-4 flex-1 leading-relaxed">
            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
        </p>
        <div class="flex items-center text-xs text-gray-500 mt-auto leading-relaxed">
            <?= authorNameRoleLink($post, false) ?>
            <span class="ml-2 font-semibold text-gray-900 text-xs sm:text-sm">
                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
            </span>
        </div>
    </div>
</article>