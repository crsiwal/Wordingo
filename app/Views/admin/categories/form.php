<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold"><?= isset($category) ? 'Edit Category' : 'Create Category' ?></h1>
            <p class="text-gray-600">
                <?= isset($category) ? 'Edit your category details below.' : 'Fill in the details to create a new category.' ?>
            </p>
        </div>

        <form action="<?= isset($category) ? base_url('admin/categories/edit/' . $category['id']) : base_url('admin/categories/create') ?>" 
              method="post" 
              class="bg-white rounded-lg shadow-md p-6">
            
            <?= csrf_field() ?>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="<?= old('name', $category['name'] ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.name') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.name')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.name') ?></p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" 
                          id="description" 
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.description') ? 'border-red-500' : '' ?>"
                          rows="4"><?= old('description', $category['description'] ?? '') ?></textarea>
                <?php if (session('errors.description')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    <?= isset($category) ? 'Update Category' : 'Create Category' ?>
                </button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?> 