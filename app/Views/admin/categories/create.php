<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Create Category</h1>
                <p class="text-gray-600">Add a new blog category</p>
            </div>
            <a href="<?= base_url('admin/categories') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Create Category Form -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/categories/create') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="name">
                        Name
                    </label>
                    <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.name') ? 'border-red-500' : 'border-gray-300' ?>" 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="<?= old('name') ?>" 
                        required>
                    <?php if (session('errors.name')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="description">
                        Description
                    </label>
                    <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.description') ? 'border-red-500' : 'border-gray-300' ?>" 
                        id="description" 
                        name="description" 
                        rows="4"><?= old('description') ?></textarea>
                    <?php if (session('errors.description')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="<?= base_url('admin/categories') ?>" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?> 