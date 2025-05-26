<?php
// Layout Key: VerticalList
?>
<div class="flex items-center gap-4 bg-white rounded-xl shadow p-4">
    <div class="flex items-center justify-center flex-col">
        <a href="<?= postUrl($post) ?>">
            <?php if (!empty($post['thumbnail'])): ?>
                <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>" class="w-32 h-24 object-cover rounded-lg">
            <?php else: ?>
                <div class="w-32 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-image text-gray-500 text-2xl"></i>
                </div>
            <?php endif; ?>
        </a>

        <div class="flex flex-col gap-2 mt-3 text-center">
            <span class="inline-block bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full mb-1 leading-relaxed">
                <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-gray-900 hover:text-green-600">
                    <?= esc($post['category_name']) ?>
                </a>
            </span>
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
            <?= authorImageLink($post) ?>
            <?= authorNameRoleLink($post) ?>
        </div>
    </div>
</div>