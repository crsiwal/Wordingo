<?php
// Layout Key: VerticalList
?>
<div class="flex items-center gap-4 bg-white rounded-xl shadow p-4">
    <div>
        <?php if (!empty($post['thumbnail'])): ?>
            <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-20 h-20 object-cover rounded-lg">
        <?php else: ?>
            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-gray-500 text-2xl"></i>
            </div>
        <?php endif; ?>
        <div class="flex flex-col gap-2 mt-3 text-center">
            <?php
            $categoryName = $post['category_name'] ?? $category['name'] ?? '';
            if (!empty($categoryName)) {
            ?>
                <span class="inline-block bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full mb-1 leading-relaxed">
                    <a href="<?= base_url('category/' . $categoryName) ?>" class="text-gray-900 hover:text-green-600">
                        <?= esc($categoryName) ?>
                    </a>
                </span>
            <?php } ?>
        </div>
    </div>
    <div class="flex-1 flex flex-col justify-between h-full">
        <h3 class="text-base font-bold mb-1 leading-relaxed">
            <a href="<?= postUrl($post) ?>" class="text-gray-900 hover:text-green-600">
                <?= esc($post['title']) ?>
            </a>
        </h3>
        <p class="text-gray-500 text-xs leading-relaxed mb-2">
            <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 60)) : "" ?>
        </p>

        <div class="flex items-center mt-auto pt-2">
            <a href="<?= base_url('author/' . $post['author_name']) ?>" class="text-gray-900 hover:text-green-600">
                <?php if (!empty($post['author_avatar'])): ?>
                    <img src="<?= esc($post['author_avatar']) ?>" alt="<?= esc($post['author_name'] ?? 'Author') ?>" class="w-7 h-7 rounded-full mr-2 object-cover">
                <?php else: ?>
                    <div class="w-7 h-7 rounded-full mr-2 bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
            </a>
            <div>
                <a href="<?= base_url('author/' . $post['author_name']) ?>" class="text-gray-900 hover:text-green-600">
                    <span class="font-semibold text-gray-900 text-xs leading-relaxed block"><?= esc($post['author_name'] ?? 'Author') ?></span>
                </a>
                <span class="block text-[10px] text-gray-400 font-normal leading-relaxed"><?= esc($post['author_role'] ?? '') ?></span>
            </div>
        </div>
    </div>
</div>