<?php
// Layout Key: LeftToRightGrid
?>
<div class="flex flex-col md:flex-row gap-8">
    <!-- Left column: first 3 posts, large card style -->
    <div class="w-full md:w-3/5 flex flex-col gap-6">
        <?php foreach (array_slice($posts, 0, 1) as $post): ?>
            <!-- Featured Card -->
            <article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-full">
                <a href="<?= postUrl($post) ?>">
                    <?php if (!empty($post['thumbnail'])): ?>
                        <img src="<?= str_replace('/raw/', '/thumb/', $post['thumbnail']); ?>" alt="<?= esc($post['title']) ?>" class="w-full h-60 object-cover">
                    <?php else: ?>
                        <div class="w-full h-60 bg-gray-200 rounded-t-xl flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-2xl"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full mb-2 leading-relaxed">
                            <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-gray-900 hover:text-green-600">
                                <?= esc($post['category_name'] ?? $category['name'] ?? '') ?>
                            </a>
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 leading-snug">
                        <a href="<?= postUrl($post) ?>" class="text-gray-900 hover:text-green-600">
                            <?= esc($post['title']) ?>
                        </a>
                    </h3>
                    <p class="text-gray-500 text-base mb-4 line-clamp-3 leading-relaxed">
                        <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 120)) : "" ?>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
            <?php foreach (array_slice($posts, 1, 2) as $post): ?>
                <?= view('visitor/sections/layouts/category_card_grid', ['post' => $post]) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Right column: remaining posts, compact card style -->
    <div class="w-full md:w-2/5 flex flex-col gap-4 max-w-xs md:max-w-full">
        <?php foreach (array_slice($posts, 3) as $post): ?>
            <?= view('visitor/sections/layouts/category_card_list', ['post' => $post]) ?>
        <?php endforeach; ?>
    </div>
</div>