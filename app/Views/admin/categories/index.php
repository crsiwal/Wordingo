<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Categories</h1>
                <p class="text-gray-600">Manage your blog categories</p>
            </div>
            <a href="<?= base_url('admin/categories/create') ?>" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i>
                New Category
            </a>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3 font-semibold">Name</th>
                            <th class="pb-3 font-semibold">Slug</th>
                            <th class="pb-3 font-semibold">Posts</th>
                            <th class="pb-3 font-semibold">Created</th>
                            <th class="pb-3 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr class="border-b">
                                <td class="py-4">
                                    <a href="<?= base_url('blog/category/' . $category['slug']) ?>" class="text-gray-900 hover:text-primary-600">
                                        <?= esc($category['name']) ?>
                                    </a>
                                </td>
                                <td class="py-4 text-gray-600"><?= esc($category['slug']) ?></td>
                                <td class="py-4"><?= number_format($category['post_count'] ?? 0) ?></td>
                                <td class="py-4"><?= date('M d, Y', strtotime($category['created_at'])) ?></td>
                                <td class="py-4">
                                    <div class="flex space-x-2">
                                        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" 
                                           class="text-gray-600 hover:text-primary-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" 
                                           class="text-red-600 hover:text-red-700"
                                           onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (isset($pager)): ?>
                <div class="mt-4">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?> 