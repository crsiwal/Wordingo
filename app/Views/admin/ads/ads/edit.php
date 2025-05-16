<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
    <!-- Header Section with Animated Background -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10">
            <h1 class="text-4xl font-bold text-white leading-tight mb-2">Edit Ad</h1>
            <p class="text-blue-100 text-xl">Update the details of "<?php echo esc($ad['title']) ?>"</p>
        </div>

        <!-- Animated bubbles background effect -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="absolute rounded-full bg-white/30"
                     style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
            <?php endfor; ?>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Edit Ad Form -->
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

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        </div>
                        <div>
                            <p class="font-medium"><?php echo session()->getFlashdata('success') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo base_url('admin/ads/edit/' . $ad['id']) ?>" method="post" class="space-y-8">
                <?php echo csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="title">
                                Ad Title <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.title') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="title"
                                    type="text"
                                    name="title"
                                    value="<?php echo old('title', $ad['title']) ?>"
                                    placeholder="Enter a descriptive title"
                                    required>
                            </div>
                            <?php if (session('errors.title')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.title') ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="slot_id">
                                Ad Slot
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-layer-group text-gray-400"></i>
                                </div>
                                <select class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.slot_id') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="slot_id"
                                    name="slot_id">
                                    <option value="">-- Select Ad Slot --</option>
                                    <?php foreach ($slots as $slot): ?>
                                        <option value="<?php echo $slot['id'] ?>" <?php echo old('slot_id', $ad['slot_id']) == $slot['id'] ? 'selected' : '' ?>>
                                            <?php echo esc($slot['name']) ?> (<?php echo $slot['width'] ?>x<?php echo $slot['height'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (session('errors.slot_id')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.slot_id') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">Where will this ad be displayed</p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="category_id">
                                Category
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-folder text-gray-400"></i>
                                </div>
                                <select class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.category_id') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="category_id"
                                    name="category_id">
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id'] ?>" <?php echo old('category_id', $ad['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                            <?php echo esc($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (session('errors.category_id')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.category_id') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">Associate with a specific content category</p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="priority">
                                Priority
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-sort-numeric-up text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.priority') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="priority"
                                    type="number"
                                    name="priority"
                                    value="<?php echo old('priority', $ad['priority']) ?>"
                                    min="1"
                                    placeholder="1">
                            </div>
                            <?php if (session('errors.priority')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.priority') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">Higher numbers will be shown more frequently</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Ad Content & Settings -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Ad Content & Settings</h3>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="asset_url">
                                Asset URL <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.asset_url') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="asset_url"
                                    type="url"
                                    name="asset_url"
                                    value="<?php echo old('asset_url', $ad['asset_url']) ?>"
                                    placeholder="https://example.com/image.jpg"
                                    required>
                            </div>
                            <?php if (session('errors.asset_url')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.asset_url') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">URL to banner image or ad creative</p>
                            <?php endif; ?>

                            <?php if (!empty($ad['asset_url']) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $ad['asset_url'])): ?>
                                <div class="mt-4">
                                    <div class="border border-gray-200 rounded-lg p-2">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Current asset:</p>
                                        <img src="<?php echo esc($ad['asset_url']) ?>" alt="Ad preview" class="max-h-40 max-w-full object-contain rounded">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="target_url">
                                Target URL <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-link text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.target_url') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="target_url"
                                    type="url"
                                    name="target_url"
                                    value="<?php echo old('target_url', $ad['target_url']) ?>"
                                    placeholder="https://advertiser-website.com/landing-page"
                                    required>
                            </div>
                            <?php if (session('errors.target_url')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.target_url') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">Where users will go when clicking the ad</p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="max_views">
                                Max Views
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-eye text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.max_views') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="max_views"
                                    type="number"
                                    name="max_views"
                                    value="<?php echo old('max_views', $ad['max_views']) ?>"
                                    min="0"
                                    placeholder="Leave empty for unlimited">
                            </div>
                            <?php if (session('errors.max_views')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.max_views') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">Maximum number of times this ad will be shown</p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <div class="flex items-center">
                                <input class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all"
                                    id="is_active"
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    <?php echo old('is_active', $ad['is_active']) ? 'checked' : '' ?>>
                                <label class="ml-2 block text-sm font-medium text-gray-700" for="is_active">
                                    Active
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">When active, this ad will be eligible for display</p>
                        </div>
                    </div>
                </div>

                <!-- Schedule Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule (Optional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="start_time">
                                Start Date & Time
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.start_time') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="start_time"
                                    type="datetime-local"
                                    name="start_time"
                                    value="<?php echo old('start_time', !empty($ad['start_time']) ? date('Y-m-d\TH:i', strtotime($ad['start_time'])) : '') ?>">
                            </div>
                            <?php if (session('errors.start_time')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.start_time') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">When to start showing this ad</p>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="end_time">
                                End Date & Time
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input class="w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 <?php echo session('errors.end_time') ? 'border-red-500' : 'border-gray-300' ?>"
                                    id="end_time"
                                    type="datetime-local"
                                    name="end_time"
                                    value="<?php echo old('end_time', !empty($ad['end_time']) ? date('Y-m-d\TH:i', strtotime($ad['end_time'])) : '') ?>">
                            </div>
                            <?php if (session('errors.end_time')): ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo session('errors.end_time') ?>
                                </p>
                            <?php else: ?>
                                <p class="mt-2 text-sm text-gray-500">When to stop showing this ad</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="text-sm font-medium text-gray-500">Views</div>
                            <div class="text-xl font-bold text-blue-600"><?php echo number_format($ad['views']) ?></div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="text-sm font-medium text-gray-500">Clicks</div>
                            <div class="text-xl font-bold text-purple-600"><?php echo number_format($ad['clicks']) ?></div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="text-sm font-medium text-gray-500">CTR</div>
                            <div class="text-xl font-bold text-green-600">
                                <?php echo $ad['views'] > 0 ? number_format(($ad['clicks'] / $ad['views']) * 100, 2) . '%' : '0%' ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-base font-medium text-gray-700">
                                <?php echo date('M d, Y', strtotime($ad['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo base_url('admin/ads/resetStats/' . $ad['id']) ?>"
                           onclick="return confirm('Are you sure you want to reset the statistics for this ad? This will set views and clicks to zero.')"
                           class="inline-flex items-center text-sm text-purple-600 hover:text-purple-800">
                            <i class="fas fa-redo-alt mr-1"></i> Reset Statistics
                        </a>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-3">
                        <div>
                            <a href="<?php echo base_url('admin/ads/delete/' . $ad['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this ad? This cannot be undone.')"
                               class="px-6 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 inline-flex items-center justify-center transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Delete
                            </a>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="<?php echo base_url('admin/ads') ?>"
                               class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 inline-flex items-center justify-center transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back
                            </a>
                            <button type="submit"
                                    class="group relative px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg overflow-hidden inline-flex items-center justify-center">
                                <span class="relative z-10 flex items-center">
                                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                    Update Ad
                                </span>
                                <span class="absolute inset-0 bg-gradient-to-r from-blue-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                            </button>
                        </div>
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
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview image when asset URL is entered
        const assetUrlInput = document.getElementById('asset_url');
        const previewContainer = document.createElement('div');
        previewContainer.className = 'mt-4 hidden';

        // Check if there's already a preview container for the current asset
        if (!document.querySelector('.border.border-gray-200.rounded-lg.p-2')) {
            assetUrlInput.parentNode.parentNode.appendChild(previewContainer);
        }

        assetUrlInput.addEventListener('blur', function() {
            // Ignore if we're still using the original asset URL
            if (this.value.trim() === "<?php echo esc($ad['asset_url']) ?>") {
                return;
            }

            const url = this.value.trim();
            if (url && /\.(jpg|jpeg|png|gif|webp)$/i.test(url)) {
                previewContainer.innerHTML = `
                    <div class="border border-gray-200 rounded-lg p-2">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview of new asset:</p>
                        <img src="${url}" alt="Ad preview" class="max-h-40 max-w-full object-contain rounded">
                    </div>
                `;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    });
    </script>
<?php echo $this->endSection() ?>