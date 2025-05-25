<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10">
        <h1 class="text-4xl font-bold text-white leading-tight mb-2">Create Category</h1>
        <p class="text-blue-100 text-xl">Add a new category to organize your content</p>
    </div>

    <!-- Animated bubbles background effect -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="absolute rounded-full bg-white/30"
                style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<div class="max-w-2xl mx-auto">
    <!-- Create Category Form -->
    <div class="bg-white rounded-xl shadow-lg p-8 transform transition-all duration-300 hover:shadow-xl">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    </div>
                    <div>
                        <p class="font-medium"><?php echo session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url('admin/categories/create') ?>" method="post" class="space-y-8">
            <?php echo csrf_field() ?>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="name">
                    Category Name
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.name') ? 'border-red-500' : 'border-gray-300' ?>"
                        id="name"
                        type="text"
                        name="name"
                        value="<?php echo old('name') ?>"
                        placeholder="Enter category name"
                        required>
                </div>
                <?php if (session('errors.name')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <?php echo session('errors.name') ?>
                    </p>
                <?php else: ?>
                    <p class="mt-2 text-sm text-gray-500">Choose a descriptive name for your category</p>
                <?php endif; ?>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="slug">
                    Slug
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-link text-gray-400"></i>
                    </div>
                    <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.slug') ? 'border-red-500' : 'border-gray-300' ?>"
                        id="slug"
                        type="text"
                        name="slug"
                        value="<?php echo old('slug') ?>"
                        placeholder="e.g. writing-tips"
                        required>
                </div>
                <?php if (session('errors.slug')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <?php echo session('errors.slug') ?>
                    </p>
                <?php else: ?>
                    <p class="mt-2 text-sm text-gray-500">Must be unique, lowercase, and use hyphens (e.g. writing-tips)</p>
                <?php endif; ?>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="description">
                    Description
                </label>
                <div class="relative">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-align-left text-gray-400"></i>
                    </div>
                    <textarea class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.description') ? 'border-red-500' : 'border-gray-300' ?>"
                        id="description"
                        name="description"
                        placeholder="Describe this category"
                        rows="4"><?php echo old('description') ?></textarea>
                </div>
                <?php if (session('errors.description')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <?php echo session('errors.description') ?>
                    </p>
                <?php else: ?>
                    <p class="mt-2 text-sm text-gray-500">Write a short description to explain what this category is about</p>
                <?php endif; ?>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
                    <a href="<?php echo base_url('admin/categories') ?>"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 inline-flex items-center justify-center transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Categories
                    </a>
                    <button type="submit"
                        class="group relative px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg overflow-hidden inline-flex items-center justify-center">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-check mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Create Category
                        </span>
                        <span class="absolute inset-0 bg-gradient-to-r from-blue-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-grid-white\/20 {
        mask-image: linear-gradient(to bottom, transparent, black);
    }

    .bg-grid-8 {
        background-size: 40px 40px;
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>

<script>
    let slugEdited = false;
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    slugInput.addEventListener('input', function() {
        slugEdited = this.value.length > 0;
    });

    nameInput.addEventListener('input', function() {
        if (!slugEdited) {
            var val = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            slugInput.value = val;
        }
    });
</script>
<?php echo $this->endSection() ?>