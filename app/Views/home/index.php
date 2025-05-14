<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <!-- Featured Posts -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Featured Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($featuredPosts as $post): ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if ($post['featured_image']): ?>
                        <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <?= !empty($post['description'])
                                ? esc($post['description'])
                                : character_limiter(strip_tags($post['content']), 150) ?>
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-4">
                                <i class="fas fa-eye"></i> <?= number_format($post['views']) ?> views
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Latest Posts -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Latest Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($latestPosts as $post): ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if ($post['featured_image']): ?>
                        <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <?= !empty($post['description'])
                                ? esc($post['description'])
                                : character_limiter(strip_tags($post['content']), 100) ?>
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-4">
                                <i class="fas fa-eye"></i> <?= number_format($post['views']) ?> views
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Categories -->
    <section>
        <h2 class="text-3xl font-bold mb-6">Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($categories as $category): ?>
                <a href="<?= base_url('category/' . $category['slug']) ?>" class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold mb-2"><?= esc($category['name']) ?></h3>
                    <p class="text-gray-600"><?= $category['post_count'] ?> posts</p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>