<?php
// Layout Key: CarouselCompact
?>
<article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-row min-w-[85vw] sm:min-w-[66vw] md:min-w-[500px] max-w-xl snap-center">
    <a href="<?= postUrl($post) ?>">
        <?php if (!empty($post['thumbnail'])): ?>
            <img src="<?= str_replace('/raw/', '/thumb/', $post['thumbnail']); ?>" alt="<?= esc($post['title']) ?>" class="w-24 sm:w-32 md:w-32 h-full object-cover rounded-l-xl flex-shrink-0">
        <?php else: ?>
            <div class="w-24 sm:w-32 md:w-32 h-full bg-gray-200 rounded-l-xl flex items-center justify-center">
                <i class="fas fa-image text-gray-500 text-2xl"></i>
            </div>
        <?php endif; ?>
    </a>
    <div class="flex-1 p-4 sm:p-5 flex flex-col justify-between h-full">
        <span class="text-xs uppercase text-gray-400 font-semibold mb-1 tracking-wide leading-relaxed">
            <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-gray-900 hover:text-green-600">
                <?= esc($post['category_name']) ?>
            </a>
        </span>
        <h3 class="text-base sm:text-lg font-bold mb-1 line-clamp-2 leading-relaxed">
            <a href="<?= postUrl($post) ?>" class="text-gray-900 hover:text-blue-600">
                <?= esc($post['title']) ?>
            </a>
        </h3>
        <p class="text-gray-500 text-xs sm:text-sm mb-2 sm:mb-3 line-clamp-2 leading-relaxed">
            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
        </p>
        <div class="flex items-center mt-auto pt-2">
            <?= authorImageLink($post) ?>
            <?= authorNameRoleLink($post) ?>
        </div>
    </div>
</article>