<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div>
            <h1 class="text-5xl font-bold leading-[3.625rem]">Edit User</h1>
            <p class="text-gray-600 text-[1.375rem] leading-[1.6875rem] mt-2">Update user details</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/users/edit/' . $user['id']) ?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.name') ? 'border-red-500' : '' ?>" 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="<?= old('name', $user['name']) ?>" 
                    required>
                <?php if (session('errors.name')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.name') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.email') ? 'border-red-500' : '' ?>" 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="<?= old('email', $user['email']) ?>" 
                    required>
                <?php if (session('errors.email')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.email') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password (leave blank to keep current)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.password') ? 'border-red-500' : '' ?>" 
                    id="password" 
                    type="password" 
                    name="password">
                <?php if (session('errors.password')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.password') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                    Role
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.role') ? 'border-red-500' : '' ?>" 
                    id="role" 
                    name="role" 
                    required>
                    <option value="user" <?= old('role', $user['role']) === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <?php if (session('errors.role')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.role') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update User
                </button>
                <a href="<?= base_url('admin/users') ?>" class="text-blue-500 hover:text-blue-700">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?> 