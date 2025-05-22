<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Results</h1>
        <p class="text-lg text-gray-600">Showing results for "<?= esc($query) ?>"</p>
    </div>

    <?php if (count($posts["search"]["posts"]) == 0): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-xl font-semibold mb-2">No results found</h2>
            <p class="text-gray-600">Try different keywords or browse our categories</p>
        </div>
    <?php else: ?>
        <?= layout_posts($posts, 'search'); ?>

        <!-- Pagination -->
        <?php if ($pager): ?>
            <div class="mt-8 flex justify-center">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>