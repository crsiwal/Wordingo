<?php
if (!function_exists('postUrl')) {
    function postUrl($post) {
        $categorySlug = isset($post['category_slug']) ? $post['category_slug'] : 'uncategorized';
        $createdAt = isset($post['created_at']) ? date('Y-m-d', strtotime($post['created_at'])) : 'unknown';
        $slug = isset($post['slug']) ? $post['slug'] : '';
        return base_url("post/{$categorySlug}/{$createdAt}/{$slug}");
    }
}


// Example: $categoryPostsData = [
//   'before_category_tabs' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_category_tabs' => ['posts' => [...], 'category' => [...], 'layout' => 'list', 'title' => 'Lifestyle Picks'],
//   'before_featured_carousel' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_featured_carousel' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'before_recommended_carousel' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_recommended_carousel' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'before_popular_grid' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_popular_grid' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'before_latest_posts' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_latest_posts' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'before_premium_cta' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'after_premium_cta' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
//   'before_footer' => ['posts' => [...], 'category' => [...], 'layout' => 'grid', 'title' => 'Tech Insights'],
// ];

if (!function_exists('layout_posts')) {
    function layout_posts($layoutsData, $key) {
        if (!isset($layoutsData[$key])) {
            return null; // or return ''; or handle it as needed
        }

        $layoutData = $layoutsData[$key];

        if (isset($layoutData['posts']) && is_array($layoutData['posts']) && count($layoutData['posts']) > 0) {
            $layoutData["title"] = $layoutData["title"] ?? "";
            return view('visitor/sections/layouts/layout_posts', array_merge($layoutData, ['layout_id' => $key]));
        }

        return null;
    }
}
