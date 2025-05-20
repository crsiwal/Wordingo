<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        <!-- Post Header -->
        <header class="mb-8">
            <h1 class="text-4xl font-bold mb-4"><?= esc($post['title']) ?></h1>
            <div class="flex items-center text-gray-600 text-sm mb-4">
                <span class="mr-4">
                    <i class="fas fa-user"></i> <?= esc($post['author_name']) ?>
                </span>
                <span class="mr-4">
                    <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
                </span>
                <span class="mr-4">
                    <i class="fas fa-eye"></i> <?= number_format($post['views']) ?> views
                </span>
                <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-folder"></i> <?= esc($post['category_name']) ?>
                </a>
            </div>
            <?php if ($post['featured_image']): ?>
                <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="w-full h-96 object-cover rounded-lg mb-8">
            <?php endif; ?>
        </header>

        <!-- Post Content -->
        <div class="prose prose-lg max-w-none mb-12">
            <?= $post['content'] ?>
        </div>

        <!-- Post Tags -->
        <?php if (!empty($post['tags'])): ?>
            <div class="mb-12">
                <h3 class="text-lg font-semibold mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($post['tags'] as $tag): ?>
                        <a href="<?= base_url('tag/' . $tag['slug']) ?>" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">
                            <?= esc($tag['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Related Posts -->
        <?php if (!empty($relatedPosts)): ?>
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($relatedPosts as $relatedPost): ?>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden">
                            <?php if ($relatedPost['featured_image']): ?>
                                <img src="<?= base_url('uploads/' . $relatedPost['featured_image']) ?>" alt="<?= esc($relatedPost['title']) ?>" class="w-full h-48 object-cover">
                            <?php endif; ?>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">
                                    <a href="<?= base_url('post/' . $relatedPost['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                        <?= esc($relatedPost['title']) ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    <?= character_limiter(strip_tags($relatedPost['content']), 100) ?>
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="mr-4">
                                        <i class="fas fa-eye"></i> <?= number_format($relatedPost['views']) ?> views
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($relatedPost['published_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </article>
</div>
<?= $this->endSection() ?> 