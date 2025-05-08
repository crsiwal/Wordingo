<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Create Category</h1>
            <a href="<?= base_url('admin/categories') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to Categories
            </a>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/categories/create') ?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.name') ? 'border-red-500' : '' ?>" 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="<?= old('name') ?>" 
                    required>
                <?php if (session('errors.name')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.name') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= session('errors.description') ? 'border-red-500' : '' ?>" 
                    id="description" 
                    name="description" 
                    rows="4"><?= old('description') ?></textarea>
                <?php if (session('errors.description')): ?>
                    <p class="text-red-500 text-xs italic"><?= session('errors.description') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Create Category
                </button>
                <a href="<?= base_url('admin/categories') ?>" class="text-blue-500 hover:text-blue-700">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?> 