<?php
// Layout Key: StandardGrid
?>
<article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
    <a href="<?= postUrl($post) ?>">
        <?php if (!empty($post['thumbnail'])): ?>
            <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-full h-40 object-cover">
        <?php else: ?>
            <div class="w-full h-40 bg-gray-200 rounded-t-xl flex items-center justify-center">
                <i class="fas fa-image text-gray-500 text-2xl"></i>
            </div>
        <?php endif; ?>
    </a>
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="inline-block bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full mb-2 leading-relaxed">
                <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-gray-900 hover:text-blue-600">
                    <?= esc($post['category_name']) ?>
                </a>
            </span>
            <span class="text-xs text-gray-500 font-semibold">
                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
            </span>
        </div>
        <h3 class="text-base font-bold mb-1 line-clamp-2 leading-relaxed">
            <a href="<?= postUrl($post) ?>" class="text-gray-900 hover:text-blue-600">
                <?= esc($post['title']) ?>
            </a>
        </h3>
        <p class="text-gray-500 text-sm mb-3 line-clamp-2 leading-relaxed">
            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
        </p>
    </div>
</article>