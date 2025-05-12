<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-gray-600">Welcome back, <?= session()->get('user_name') ?>!</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary-100 text-primary-600">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Total Posts</h3>
                    <p class="text-2xl font-semibold"><?= number_format($totalPosts) ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Published Posts</h3>
                    <p class="text-2xl font-semibold"><?= number_format($publishedPosts) ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-eye text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Total Views</h3>
                    <p class="text-2xl font-semibold"><?= number_format($totalViews) ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-folder text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Categories</h3>
                    <p class="text-2xl font-semibold"><?= number_format($totalCategories) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Recent Posts</h2>
                <a href="<?= base_url('admin/posts/create') ?>" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                    <i class="fas fa-plus mr-2"></i>
                    New Post
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3 font-semibold">Title</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold">Views</th>
                            <th class="pb-3 font-semibold">Created</th>
                            <th class="pb-3 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentPosts as $post): ?>
                            <tr class="border-b">
                                <td class="py-4">
                                    <a href="<?= base_url('blog/' . $post['slug']) ?>" class="text-gray-900 hover:text-primary-600">
                                        <?= esc($post['title']) ?>
                                    </a>
                                </td>
                                <td class="py-4">
                                    <span class="px-2 py-1 rounded-full text-sm <?= $post['status'] === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                        <?= ucfirst($post['status']) ?>
                                    </span>
                                </td>
                                <td class="py-4"><?= number_format($post['views']) ?></td>
                                <td class="py-4"><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                                <td class="py-4">
                                    <div class="flex space-x-2">
                                        <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>" 
                                           class="text-gray-600 hover:text-primary-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/posts/delete/' . $post['id']) ?>" 
                                           class="text-red-600 hover:text-red-700"
                                           onclick="return confirm('Are you sure you want to delete this post?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?> 