<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>



<?= $this->include('visitor/sections/home/hero') ?>

<!-- Category Tabs -->
<?= layout_posts($categoryPostsData, 'before_category_tabs'); ?>
<?= $this->include('visitor/sections/home/category_tabs') ?>
<?= layout_posts($categoryPostsData, 'after_category_tabs'); ?>

<!-- Featured Carousel -->
<?= layout_posts($categoryPostsData, 'before_featured_carousel'); ?>
<?= $this->include('visitor/sections/home/featured_carousel') ?>
<?= layout_posts($categoryPostsData, 'after_featured_carousel'); ?>

<!-- Recommended Carousel -->
<?= layout_posts($categoryPostsData, 'before_recommended_carousel'); ?>
<?= $this->include('visitor/sections/home/recommended_carousel') ?>
<?= layout_posts($categoryPostsData, 'after_recommended_carousel'); ?>

<!-- Popular Grid -->
<?= layout_posts($categoryPostsData, 'before_popular_grid'); ?>
<?= $this->include('visitor/sections/home/popular_grid') ?>
<?= layout_posts($categoryPostsData, 'after_popular_grid'); ?>

<!-- Latest Posts -->
<?= layout_posts($categoryPostsData, 'before_latest_posts'); ?>
<?= $this->include('visitor/sections/home/latest_posts') ?>
<?= layout_posts($categoryPostsData, 'after_latest_posts'); ?>

<!-- Premium CTA -->
<?= layout_posts($categoryPostsData, 'before_premium_cta'); ?>
<?= $this->include('visitor/sections/home/premium_cta') ?>
<?= layout_posts($categoryPostsData, 'after_premium_cta'); ?>

<!-- Post before Footer -->
<?= layout_posts($categoryPostsData, 'before_footer'); ?>
<!-- End of Home Page -->
<?= $this->endSection() ?>