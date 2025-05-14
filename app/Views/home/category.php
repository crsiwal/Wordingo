<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold"><?= esc($category['name']) ?></h1>
            <p class="text-gray-600">Browse all posts in this category</p>
        </div>

        <?php if (empty($posts)): ?>
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <h2 class="text-xl font-semibold mb-2">No posts found</h2>
                <p class="text-gray-600">Check back later for new content</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <?php if ($post['thumbnail']): ?>
                            <a href="<?= base_url('blog/' . $post['slug']) ?>" class="block">
                                <img src="<?= base_url('files/' . $post['user_id'] . '/' . $post['id'] . '/' . $post['thumbnail']) ?>"
                                     alt="<?= esc($post['title']) ?>"
                                     class="w-full h-48 object-cover">
                            </a>
                        <?php endif; ?>

                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="<?= base_url('blog/' . $post['slug']) ?>" class="text-gray-900 hover:text-primary-600">
                                    <?= esc($post['title']) ?>
                                </a>
                            </h2>

                            <p class="text-gray-600 mb-4">
                                <?= !empty($post['description'])
                                    ? esc($post['description'])
                                    : character_limiter(strip_tags($post['content']), 150) ?>
                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-user mr-1"></i>
                                    <?= esc($post['user']['name']) ?>
                                </span>
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    <?= date('M d, Y', strtotime($post['published_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>