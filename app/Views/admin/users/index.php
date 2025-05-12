<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Users</h1>
                <p class="text-gray-600">Manage your blog users</p>
            </div>
            <a href="<?= base_url('admin/users/create') ?>" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i>
                New User
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3 font-semibold">Name</th>
                            <th class="pb-3 font-semibold">Email</th>
                            <th class="pb-3 font-semibold">Role</th>
                            <th class="pb-3 font-semibold">Posts</th>
                            <th class="pb-3 font-semibold">Joined</th>
                            <th class="pb-3 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900"><?= esc($user['name']) ?></div>
                                            <div class="text-sm text-gray-500">@<?= esc($user['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-gray-600"><?= esc($user['email']) ?></td>
                                <td class="py-4">
                                    <span class="px-2 py-1 text-xs rounded-full <?= $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td class="py-4"><?= number_format($user['post_count'] ?? 0) ?></td>
                                <td class="py-4"><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                <td class="py-4">
                                    <div class="flex space-x-2">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" 
                                           class="text-gray-600 hover:text-primary-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user['id'] !== session()->get('user_id')): ?>
                                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                               class="text-red-600 hover:text-red-700"
                                               onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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