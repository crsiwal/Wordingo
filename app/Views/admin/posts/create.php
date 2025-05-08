<?php echo $this->extend('layouts/admin')?>

<?php echo $this->section('content')?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Create Post</h1>
            <a href="<?php echo base_url('admin/posts')?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to Posts
            </a>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo session()->getFlashdata('error')?>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url('admin/posts/create')?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <?php echo csrf_field()?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo session('errors.title') ? 'border-red-500' : ''?>"
                    id="title"
                    type="text"
                    name="title"
                    value="<?php echo old('title')?>"
                    required>
                <?php if (session('errors.title')): ?>
                    <p class="text-red-500 text-xs italic"><?php echo session('errors.title')?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                    Content
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo session('errors.content') ? 'border-red-500' : ''?>"
                    id="content"
                    name="content"
                    rows="10"
                    required><?php echo old('content')?></textarea>
                <?php if (session('errors.content')): ?>
                    <p class="text-red-500 text-xs italic"><?php echo session('errors.content')?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">
                    Category
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo session('errors.category_id') ? 'border-red-500' : ''?>"
                    id="category_id"
                    name="category_id"
                    required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']?>" <?php echo old('category_id') == $category['id'] ? 'selected' : ''?>>
                            <?php echo esc($category['name'])?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.category_id')): ?>
                    <p class="text-red-500 text-xs italic"><?php echo session('errors.category_id')?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tags">
                    Tags
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="tags"
                    name="tags[]"
                    multiple>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo $tag['id']?>" <?php echo in_array($tag['id'], old('tags', [])) ? 'selected' : ''?>>
                            <?php echo esc($tag['name'])?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-gray-600 text-xs mt-1">Hold Ctrl/Cmd to select multiple tags</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="featured_image">
                    Featured Image
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="featured_image"
                    type="file"
                    name="featured_image"
                    accept="image/*">
                <p class="text-gray-600 text-xs mt-1">Recommended size: 1200x630 pixels</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo session('errors.status') ? 'border-red-500' : ''?>"
                    id="status"
                    name="status"
                    required>
                    <option value="draft" <?php echo old('status') === 'draft' ? 'selected' : ''?>>Draft</option>
                    <option value="published" <?php echo old('status') === 'published' ? 'selected' : ''?>>Published</option>
                </select>
                <?php if (session('errors.status')): ?>
                    <p class="text-red-500 text-xs italic"><?php echo session('errors.status')?></p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Create Post
                </button>
                <a href="<?php echo base_url('admin/posts')?>" class="text-blue-500 hover:text-blue-700">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/awn2usil5yo5udzvd9roetcgu6curg3r1a763y1dtxzlintb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500
    });
</script>
<?php echo $this->endSection()?>