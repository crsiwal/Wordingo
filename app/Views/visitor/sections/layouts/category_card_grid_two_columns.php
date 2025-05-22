<?php
// Layout Key: TwoColumnGrid
?>
<div class="flex flex-col md:flex-row gap-8">
    <!-- Left column: first 3 posts, large card style -->
    <div class="w-full md:w-3/5 flex flex-col gap-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
            <?php foreach (array_slice($posts, 0, 4) as $post): ?>
                <?= view('visitor/sections/layouts/category_card_grid', ['post' => $post]) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Right column: remaining posts, compact card style -->
    <div class="w-full md:w-2/5 flex flex-col gap-4 max-w-xs md:max-w-full">
        <?php foreach (array_slice($posts, 4) as $post): ?>
            <?= view('visitor/sections/layouts/category_card_list', ['post' => $post]) ?>
        <?php endforeach; ?>
    </div>
</div>