<?php
// $posts: array of posts
// $category: category info (name, slug, etc.)
// $layout: 'StandardGrid', 'VerticalList', 'LeftToRightGrid', 'TwoColumnGrid', 'CarouselCompact', 'CarouselGrid', etc.
// $title: optional section title
// $carouselId: optional unique id for carousel (auto-generated from slug if not set)

$carouselId = null;
?>

<div class="container mx-auto px-4 my-16">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold leading-relaxed"><?= esc($title ?? $category['name'] ?? 'Category') ?></h2>
        <?php
        if (in_array($layout, ['CarouselCompact', 'CarouselGrid'])):
            $carouselId = $layout_id ?? uniqid();
        ?>
            <?= view('visitor/sections/layouts/category_carousel_buttons', ['carouselId' => $carouselId]) ?>
        <?php endif; ?>
    </div>
    <div class="relative">
        <?php if ($layout === 'StandardGrid'): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <?= view('visitor/sections/layouts/category_card_grid', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'VerticalList'): ?>
            <div class="space-y-6">
                <?php foreach ($posts as $post): ?>
                    <?= view('visitor/sections/layouts/category_card_list', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'LeftToRightGrid'): ?>
            <div class="space-y-6">
                <?= view('visitor/sections/layouts/category_card_grid_ltr', ['posts' => $posts]) ?>
            </div>
        <?php elseif ($layout === 'TwoColumnGrid'): ?>
            <div class="space-y-6">
                <?= view('visitor/sections/layouts/category_card_grid_two_columns', ['posts' => $posts]) ?>
            </div>
        <?php elseif ($layout === 'CarouselCompact'): ?>
            <div class="carousel-scroll-<?= $carouselId ?> flex overflow-x-auto gap-4 sm:gap-8 pb-4 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                <?php foreach ($posts as $post): ?>
                    <?= view('visitor/sections/layouts/category_card_compact', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'CarouselGrid'): ?>
            <div class="carousel-scroll-<?= $carouselId ?> flex overflow-x-auto gap-8 pb-4 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                <?php foreach ($posts as $post): ?>
                    <?= view('visitor/sections/layouts/category_card_grid_carousel', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-gray-400 italic">No layout selected.</div>
        <?php endif; ?>
    </div>
</div>