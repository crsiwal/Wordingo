<!-- Category Tabs -->
<div class="container mx-auto px-4 mb-8 mt-12">
    <div class="flex flex-wrap gap-2 md:gap-4 justify-center md:justify-start">
        <a href="<?= base_url('/') ?>" class="px-4 py-2 rounded-full font-medium text-sm <?= !isset($activeCategory) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-blue-50' ?>">All Article</a>
        <?php foreach ($categories as $category): ?>
            <a href="<?= base_url('category/' . $category['slug']) ?>" class="px-4 py-2 rounded-full font-medium text-sm <?= (isset($activeCategory) && $activeCategory == $category['slug']) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-blue-50' ?>">
                <?= esc($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>