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
<?= $this->include('visitor/sections/home/category_tabs') ?>
<?= $this->include('visitor/sections/home/featured_carousel') ?>
<?= $this->include('visitor/sections/home/recommended_carousel') ?>
<?= $this->include('visitor/sections/home/popular_grid') ?>
<?= $this->include('visitor/sections/home/premium_cta') ?>
<?= $this->endSection() ?>