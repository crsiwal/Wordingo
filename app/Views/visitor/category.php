<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-2"><?= esc($category['name']) ?></h1>
        <p class="text-lg text-gray-600">Browse all posts in this category</p>
    </div>

    <?php if (count($posts["mostViewed"] ?? []) == 0 && count($posts["latest"] ?? []) == 0): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-xl font-semibold mb-2">No posts found</h2>
            <p class="text-gray-600">Check back later for new content</p>
        </div>
    <?php else: ?>
        <?= layout_posts($posts, 'mostViewed'); ?>

        <?= layout_posts($posts, 'latest'); ?>

        <!-- Pagination -->
        <?php if (isset($pager)): ?>
            <div class="mt-8 flex justify-center">
                <?php
                // Use our custom pager that handles query parameters automatically
                echo $pager->links('default', 'visitor_pager');
                ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>