<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Edit Post</h1>
                <p class="text-gray-600">Edit the blog post</p>
            </div>
        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3 mt-4">
            <a href="<?php echo base_url('admin/posts/create') ?>" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Post
            </a>
            <?php if (! empty($post['slug']) && $post['status'] === 'published'): ?>
            <a href="<?php echo base_url('blog/post/' . $post['slug']) ?>" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg flex items-center" target="_blank">
                <i class="fas fa-eye mr-2"></i>
                View this Post
            </a>
            <?php endif; ?>
            <div class="bg-yellow-500 text-gray-800 px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-chart-bar mr-2"></i>
                Views:
                 <?php echo isset($post['views_count']) ? number_format($post['views_count']) : '0' ?>
            </div>
        </div>
        </div>


    </div>

    <!-- Create Post Form -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo base_url('admin/posts/edit/' . $post['id']) ?>" method="post" class="space-y-6">
                <?php echo csrf_field() ?>

                <!-- Main Content Column -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="title">
                                Title
                            </label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.title') ? 'border-red-500' : 'border-gray-300' ?>"
                                id="title"
                                type="text"
                                name="title"
                                value="<?php echo old('title', $post['title']) ?>"
                                required>
                            <?php if (session('errors.title')): ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo session('errors.title') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Slug Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="slug">
                                Post Slug
                            </label>
                            <?php if (empty($post['slug'])): ?>
                                <div class="relative">
                                    <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.slug') ? 'border-red-500' : 'border-gray-300' ?>"
                                        id="slug"
                                        type="text"
                                        name="slug"
                                        value="<?php echo old('slug', $post['slug']) ?>"
                                        required>
                                    <div id="slug-status" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                                        <i class="fas fa-check text-green-500"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    The slug will be automatically created based on the title. It must be at least 8 characters long.
                                </p>
                            <?php else: ?>
                                <div class="flex items-center space-x-2">
                                    <input class="w-full px-3 py-2 border rounded-lg bg-gray-50 border-gray-300"
                                        name="slug"
                                        type="text"
                                        value="<?php echo $post['slug'] ?>"
                                        readonly>
                                    <button type="button"
                                        id="edit-slug-btn"
                                        class="px-3 py-2 text-sm text-primary-600 hover:text-primary-700 focus:outline-none">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    You can edit the slug if needed. It must be at least 8 characters long.
                                </p>
                            <?php endif; ?>
<?php if (session('errors.slug')): ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo session('errors.slug') ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="content">
                                Content
                            </label>
                            <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo session('errors.content') ? 'border-red-500' : 'border-gray-300' ?>"
                                id="content"
                                name="content"
                                rows="10"><?php echo old('content', $post['content']) ?></textarea>
                            <?php if (session('errors.content')): ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo session('errors.content') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sidebar Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>
                            <div>
                                <!-- Upload Section -->
                                <div id="featured_image_upload_section" class="<?php echo empty($post['thumbnail']) ? '' : 'hidden'; ?>">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="featured_image">
                                        Upload Image
                                    </label>
                                    <div class="mb-3">
                                        <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 border-gray-300" id="featured_image_input" type="file" accept="image/*">
                                        <p class="mt-1 text-sm text-gray-500">Recommended size: 1200x630 pixels (minimum width: 800px, minimum height: 400px)</p>
                                    </div>
                                </div>

                                <!-- Preview area with delete button -->
                                <div id="featured_image_preview" class="mt-4 mb-3 relative                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo empty($post['featured_image_url']) ? 'hidden' : ''; ?>">
                                    <button type="button" id="delete_featured_image" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <img id="featured_image_preview_img" src="<?php echo $post['thumbnail'] ?>" alt="Featured image preview" class="w-full h-auto rounded-lg">
                                </div>

                                <!-- Progress bar -->
                                <div id="featured_image_progress_container" class="w-full h-2 bg-gray-200 rounded hidden mb-2">
                                    <div id="featured_image_progress" class="h-2 bg-primary-500 rounded" style="width: 0%"></div>
                                </div>

                                <!-- Status message -->
                                <p id="featured_image_status" class="text-sm mt-1 hidden"></p>

                                <!-- Hidden input to store the uploaded image URL -->
                                <input type="hidden" id="featured_image_url" name="featured_image_url" value="<?php echo old('featured_image_url', $post['thumbnail'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Post Settings</h3>
                            <div class="space-y-4">
                                <!-- Post Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="status">
                                        Status
                                    </label>
                                    <select class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo session('errors.status') ? 'border-red-500' : 'border-gray-300' ?>"
                                        id="status"
                                        name="status"
                                        required>
                                        <option value="draft"<?php echo old('status', $post['status']) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="published"<?php echo old('status', $post['status']) === 'published' ? 'selected' : '' ?>>Published</option>
                                    </select>
                                    <?php if (session('errors.status')): ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo session('errors.status') ?></p>
                                    <?php endif; ?>
                                    <p class="mt-1 text-sm text-gray-500">Select the status of the post. Draft posts are not visible to the visitors.</p>
                                </div>


                                <!-- Published At -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="published_at">
                                        Published At
                                    </label>
                                    <?php
                                        $publishedAt = old('published_at', $post['published_at'] ?? '');
                                        if (! $publishedAt) {
                                            $publishedAt = date('Y-m-d\TH:i');
                                        } else {
                                            // Convert to HTML5 datetime-local format
                                            $publishedAt = date('Y-m-d\TH:i', strtotime($publishedAt));
                                        }
                                    ?>
                                    <input type="datetime-local" name="published_at" id="published_at" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 border-gray-300" value="<?php echo $publishedAt ?>">
                                    <p class="mt-1 text-sm text-gray-500">Set a future date/time to schedule the post. The post will be visible only after this time.</p>
                                </div>


                                <!-- Post Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="category_id">
                                        Category
                                    </label>
                                    <select id="category_id" name="category_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.category_id') ? 'border-red-500' : 'border-gray-300' ?>" required>
                                        <option value="">Select a category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id'] ?>"<?php echo old('category_id', $post['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                                <?php echo esc($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.category_id')): ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo session('errors.category_id') ?></p>
                                    <?php endif; ?>
                                    <p class="mt-1 text-sm text-gray-500">Select a category for the post.</p>
                                </div>

                                <!-- Tags Input -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tags-input">
                                        Tags
                                    </label>
                                    <div id="tags-input-wrapper" class="flex flex-wrap items-center border rounded-lg px-2 py-2 bg-white min-h-[44px] focus-within:ring-2 focus-within:ring-primary-500">
                                        <!-- Tag chips will be inserted here -->
                                        <input type="text" id="tags-input" class="flex-1 border-none focus:ring-0 outline-none py-1 px-2 text-sm" placeholder="Type and press Enter or comma...">
                                    </div>
                                    <input type="hidden" name="tags" id="tags-hidden" value="<?php echo old('tags', $post['tags']) ?>">
                                    <p class="mt-1 text-sm text-gray-500">Type a tag and press Enter or comma. Tags are optional.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="<?php echo base_url('admin/posts') ?>" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                        <?php echo $post['title'] ? 'Update Post' : 'Create Post' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Froala Editor -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Froala Editor
            const editor = new FroalaEditor('#content', {
                // Basic configuration
                height: 500,
                placeholderText: 'Start writing your post content...',

                // Image upload configuration
                imageUploadURL: '<?php echo base_url('admin/files/upload?post_id=' . ($post['id'] ?? '0')); ?>',
                imageUploadParams: {
                    post_id: '<?php echo $post['id'] ?? '0'; ?>'
                },
                imageUploadMethod: 'POST',

                // Image browsing configuration
                imageManagerLoadURL: '<?php echo base_url('admin/files/list'); ?>',
                imageManagerLoadMethod: 'GET',
                imageManagerPageSize: 5,
                imageManagerScrollOffset: 5,
                imageManagerLoadParams: {
                    for: 'editor',
                    post_id: '<?php echo $post['id'] ?? '0'; ?>',
                    user_id: '<?php echo session()->get('user_id'); ?>'
                },

                // Image manager delete configuration
                imageManagerDeleteURL: '<?php echo base_url('admin/files/delete'); ?>',
                imageManagerDeleteMethod: 'DELETE',
                imageManagerDeleteParams: {
                    for: 'editor',
                    post_id: '<?php echo $post['id'] ?? '0'; ?>',
                    user_id: '<?php echo session()->get('user_id'); ?>'
                },

                // Video configuration - disable uploads but keep URL/embed
                videoUpload: false,
                videoInsertButtons: ['videoBack', '|', 'videoByURL', 'videoEmbed'],

                // Toolbar configuration
                toolbarButtons: {
                    'moreText': {
                        'buttons': ['bold', 'underline', 'fontSize', 'italic', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'insertHR', 'clearFormatting']
                    },
                    'moreParagraph': {
                        'buttons': ['align', 'formatOL', 'formatUL',  'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
                    },
                    'moreRich': {
                        'buttons': ['insertTable', 'insertImage','insertVideo', 'emoticons', 'insertLink', 'specialCharacters']
                    },
                    'moreMisc': {
                        'buttons': ['undo', 'redo', 'fullscreen', 'html', 'getPDF', 'spellChecker', 'help'],
                        'align': 'right',
                        'buttonsVisible': 2
                    }
                },

                // Disable specific plugins
                pluginsDisable: [
                    'fileUploadToS3',
                    'imageUploadToS3',
                    'videoUploadToS3',
                    'videoUpload',     // Disable video uploads
                    'fileManager'      // Disable file manager (not images)
                ],

                // Configure image insertion buttons
                imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL', 'imageManager'],

                // Events
                events: {
                    'image.uploaded': function (response) {
                        // Parse the response
                        try {
                            const resp = JSON.parse(response);
                            return resp.link || resp.location;
                        } catch (e) {
                            return response;
                        }
                    },
                    'image.error': function (error, response) {
                        console.error('Froala Image Upload Error:', error, response);
                    },
                    'imageManager.beforeDeleteImage': function (img) {
                        // You can implement image deletion here if needed
                        console.log('Delete image:', img);
                    },
                    'imageManager.error': function (error) {
                        console.error('Froala Image Manager Error:', error);
                    },
                    'contentChanged': function () {
                        // Update the textarea value when content changes
                        this.el.value = this.html.get();
                    }
                }
            });

            // Handle form submission - ensure all images are uploaded before submitting
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                const content = editor.html.get();
                if (!content.trim()) {
                    alert('Please enter some content for the post.');
                    return;
                }

                // Submit the form (Froala handles image uploads during insertion)
                this.submit();
            });

            // Tags input logic
            const tagsInput = document.getElementById('tags-input');
            const tagsWrapper = document.getElementById('tags-input-wrapper');
            const tagsHidden = document.getElementById('tags-hidden');
            let tags = tagsHidden.value ? tagsHidden.value.split(',').map(t => t.trim()).filter(Boolean) : [];

            function renderTags() {
                // Remove all tag chips except the input
                tagsWrapper.querySelectorAll('.tag-chip').forEach(e => e.remove());
                tags.forEach((tag, idx) => {
                    const chip = document.createElement('span');
                    chip.className = 'tag-chip bg-primary-100 text-primary-700 rounded px-2 py-1 mr-2 mb-2 flex items-center text-xs';
                    chip.innerHTML = `${tag} <button type="button" class="ml-1 text-primary-500 hover:text-red-500" data-idx="${idx}">&times;</button>`;
                    tagsWrapper.insertBefore(chip, tagsInput);
                });
                tagsHidden.value = tags.join(',');
            }

            tagsWrapper.addEventListener('click', () => tagsInput.focus());
            tagsInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',' || e.key === 'Tab') {
                    e.preventDefault();
                    let val = tagsInput.value.trim().replace(/,/g, '');
                    if (val && !tags.includes(val)) {
                        tags.push(val);
                        tagsInput.value = '';
                        renderTags();
                    }
                } else if (e.key === 'Backspace' && !tagsInput.value && tags.length) {
                    tags.pop();
                    renderTags();
                }
            });
            tagsWrapper.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON' && e.target.dataset.idx) {
                    tags.splice(e.target.dataset.idx, 1);
                    renderTags();
                }
            });
            renderTags();

            // Featured Image Handling
            const featuredImageInput = document.getElementById('featured_image_input');
            const featuredImagePreview = document.getElementById('featured_image_preview');
            const featuredImagePreviewImg = document.getElementById('featured_image_preview_img');
            const featuredImageProgress = document.getElementById('featured_image_progress');
            const featuredImageProgressContainer = document.getElementById('featured_image_progress_container');
            const featuredImageStatus = document.getElementById('featured_image_status');
            const featuredImageUrl = document.getElementById('featured_image_url');
            const featuredImageUploadSection = document.getElementById('featured_image_upload_section');
            const deleteFeaturedImageBtn = document.getElementById('delete_featured_image');

            // Load existing image if available
            if (featuredImageUrl.value) {
                featuredImagePreviewImg.src = featuredImageUrl.value;
                featuredImagePreview.classList.remove('hidden');
                featuredImageUploadSection.classList.add('hidden');
            }

            // Delete featured image handler
            deleteFeaturedImageBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this image?')) {
                    // Clear the image URL
                    featuredImageUrl.value = '';
                    // Hide preview and show upload section
                    featuredImagePreview.classList.add('hidden');
                    featuredImageUploadSection.classList.remove('hidden');
                    // Clear the preview image
                    featuredImagePreviewImg.src = '';
                    // Clear the file input
                    featuredImageInput.value = '';
                    // Clear status message
                    featuredImageStatus.textContent = '';
                    featuredImageStatus.classList.add('hidden');
                }
            });

            featuredImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (!file) {
                    return;
                }

                // Create object URL for preview
                const objectUrl = URL.createObjectURL(file);

                // Check dimensions before upload
                const img = new Image();
                img.onload = function() {
                    URL.revokeObjectURL(objectUrl);

                    // Validate dimensions
                    const minWidth = 800;
                    const minHeight = 400;
                    const recommendedWidth = 1200;
                    const recommendedHeight = 630;

                    if (img.width < minWidth || img.height < minHeight) {
                        setFeaturedImageStatus(`Image too small: ${img.width}x${img.height}px. Minimum size: ${minWidth}x${minHeight}px`, 'text-red-500');
                        return;
                    }

                    if (img.width < recommendedWidth || img.height < recommendedHeight) {
                        setFeaturedImageStatus(`Image size: ${img.width}x${img.height}px. Recommended: ${recommendedWidth}x${recommendedHeight}px`, 'text-yellow-500');
                    } else {
                        setFeaturedImageStatus(`Image size: ${img.width}x${img.height}px.`, 'text-green-500');
                    }

                    // Upload image
                    uploadFeaturedImage(file);
                };

                img.src = objectUrl;
            });

            function setFeaturedImageStatus(message, className) {
                featuredImageStatus.textContent = message;
                featuredImageStatus.className = 'text-sm mt-1 ' + className;
                featuredImageStatus.classList.remove('hidden');
            }

            function uploadFeaturedImage(file) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('post_id', '<?php echo $post['id'] ?? '0'; ?>');
                formData.append('is_featured', '1');

                // Show progress bar
                featuredImageProgressContainer.classList.remove('hidden');
                featuredImageProgress.style.width = '0%';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo base_url('admin/files/upload'); ?>', true);

                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        featuredImageProgress.style.width = percentComplete + '%';
                    }
                };

                xhr.onload = function() {
                    featuredImageProgressContainer.classList.add('hidden');
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.link) {
                                // Store the uploaded URL
                                featuredImageUrl.value = response.link;
                                featuredImagePreviewImg.src = response.link;
                                featuredImagePreview.classList.remove('hidden');
                                featuredImageUploadSection.classList.add('hidden');
                                setFeaturedImageStatus('Image uploaded successfully!', 'text-green-500');
                            } else {
                                setFeaturedImageStatus('Error: Invalid server response', 'text-red-500');
                            }
                        } catch (e) {
                            setFeaturedImageStatus('Error parsing server response', 'text-red-500');
                        }
                    } else {
                        setFeaturedImageStatus('Error uploading image: ' + xhr.status, 'text-red-500');
                    }
                };

                xhr.onerror = function() {
                    featuredImageProgressContainer.classList.add('hidden');
                    setFeaturedImageStatus('Network error occurred', 'text-red-500');
                };

                xhr.send(formData);
            }

            // Slug generation and validation
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const slugStatus = document.getElementById('slug-status');
            const editSlugBtn = document.getElementById('edit-slug-btn');
            let slugTimeout;

            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')         // Replace spaces with hyphens
                    .replace(/-+/g, '-')          // Replace multiple hyphens with single hyphen
                    .trim();                      // Trim leading/trailing spaces
            }

            function validateSlug(slug) {
                if (!slug || slug === '' || slug === null || slug.length < 8 || slug.length > 256) return;

                var formData = new FormData();
                formData.append('slug', slug);
                formData.append('post_id', '<?php echo $post['id'] ?? ''; ?>');

                fetch('<?php echo base_url('admin/posts/validate-slug'); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        slugStatus.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                        slugInput.classList.remove('border-red-500');
                        slugInput.classList.add('border-green-500');
                    } else {
                        slugStatus.innerHTML = '<i class="fas fa-times text-red-500"></i>';
                        slugInput.classList.remove('border-green-500');
                        slugInput.classList.add('border-red-500');
                    }
                    slugStatus.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error validating slug:', error);
                });
            }

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    if (!slugInput.readOnly) {
                        clearTimeout(slugTimeout);
                        slugTimeout = setTimeout(() => {
                            const slug = generateSlug(this.value);
                            if (slug.length > 256) {
                                slugInput.value = slug.substring(0, 256);
                            } else {
                                slugInput.value = slug;
                            }
                            validateSlug(slugInput.value);
                        }, 300);
                    }
                });

                slugInput.addEventListener('input', function() {
                    clearTimeout(slugTimeout);
                    slugTimeout = setTimeout(() => {
                        const slug = generateSlug(this.value);
                        if (slug.length > 256) {
                            this.value = slug.substring(0, 256);
                        } else {
                            this.value = slug;
                        }
                        validateSlug(this.value);
                    }, 300);
                });
            }

            if (editSlugBtn) {
                editSlugBtn.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    input.readOnly = false;
                    input.classList.remove('bg-gray-50');
                    input.focus();
                    this.innerHTML = '<i class="fas fa-check"></i> Save';
                    this.classList.remove('text-primary-600', 'hover:text-primary-700');
                    this.classList.add('text-green-600', 'hover:text-green-700');

                    this.addEventListener('click', function saveSlug() {
                        const newSlug = input.value.trim();
                        if (newSlug) {
                            validateSlug(newSlug);
                            input.readOnly = true;
                            input.classList.add('bg-gray-50');
                            this.innerHTML = '<i class="fas fa-edit"></i> Edit';
                            this.classList.remove('text-green-600', 'hover:text-green-700');
                            this.classList.add('text-primary-600', 'hover:text-primary-700');
                            this.removeEventListener('click', saveSlug);
                        }
                    }, { once: true });
                });
            }
        });
    </script>
<?php echo $this->endSection() ?>