<?php
if (!function_exists('postUrl')) {
    function postUrl($post) {
        $categorySlug = isset($post['category_slug']) ? $post['category_slug'] : 'uncategorized';
        $createdAt = isset($post['published_at']) ? date('Y-m-d', strtotime($post['published_at'])) : 'unknown';
        $slug = isset($post['slug']) ? $post['slug'] : '';
        return base_url("post/{$categorySlug}/{$createdAt}/{$slug}");
    }
}

if (!function_exists('authorImageLink')) {
    function authorImageLink($post) {
        return (
            '<a href="' . base_url('author/' . $post['author_username']) . '" class="text-gray-900 hover:text-green-600">' .
            (!empty($post['author_avatar']) ?
                '<img src="' . esc($post['author_avatar']) . '" alt="' . esc($post['author_name'] ?? 'Author') . '" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full mr-2 sm:mr-3 object-cover">' :
                '<div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full mr-2 sm:mr-3 bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">' .
                '<i class="fas fa-user"></i>' .
                '</div>') .
            '</a>'
        );
    }
}

if (!function_exists('authorNameRoleLink')) {
    function authorNameRoleLink($post, $includeRole = true) {
        $role = $includeRole ? esc($post['author_role'] ?? '') : '';
        return (
            '<div>' .
            '<a href="' . base_url('author/' . $post['author_username']) . '" class="text-gray-900 hover:text-green-600">' .
            '<span class="font-semibold text-gray-900 text-xs sm:text-sm leading-relaxed block">' . esc($post['author_name'] ?? 'Author') . '</span>' .
            '</a>' .
            '<span class="block text-[10px] sm:text-xs text-gray-400 font-normal leading-relaxed">' . $role . '</span>' .
            '</div>'
        );
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
    function layout_posts($layoutsData, $key = null) {
        if (is_array($layoutsData)) {
            $layoutData = $key != null && isset($layoutsData[$key]) ? $layoutsData[$key] : $layoutsData;
            $key = $key ?? uniqid(5);
            if (isset($layoutData['posts']) && is_array($layoutData['posts']) && count($layoutData['posts']) > 0) {
                $layoutData["title"] = $layoutData["title"] ?? "";
                return view('visitor/sections/layouts/layout_posts', array_merge($layoutData, ['layout_id' => $key]));
            }
        }

        return null;
    }
}
