<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Frontend Routes
$routes->get('/', 'Visitor\Home::index');
$routes->get('post/(:segment)', 'Visitor\SinglePost::index/$1'); // post/slug
$routes->get('post/(:segment)/(:segment)/(:segment)', 'Visitor\SinglePost::index/$3'); // post/category/created_at/slug
$routes->get('post/(:segment)/(:segment)', 'Visitor\SinglePost::index/$2'); // post/category/slug

// Recent Posts
$routes->get('posts', 'Visitor\RecentPosts::index');

// Category Routes
$routes->get('category/(:segment)', 'Visitor\Category::index/$1'); // category/slug

// Tag Routes
$routes->get('tag/(:segment)', 'Visitor\Tag::index/$1');

// Author Routes
$routes->get('author/(:segment)', 'Visitor\Author::index/$1');

// Search Routes
$routes->get('search', 'Visitor\Search::index');

// About Us Page
$routes->get('about', 'Visitor\Pages::about');

// Contact Us Page
$routes->get('contact', 'Visitor\Pages::contact');
$routes->post('contact', 'Visitor\Pages::contact');

// Terms and Conditions Page Route
$routes->get('terms', 'Visitor\Pages::terms');

// Privacy Policy Page Route
$routes->get('privacy', 'Visitor\Pages::privacy');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

// Register Routes
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');

// Logout Routes
$routes->get('logout', 'Auth::logout');

// Forgot Password Routes
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::attemptForgotPassword');

// Reset Password Routes
$routes->get('reset/(:segment)', 'Auth::resetPassword/$1');
$routes->post('reset/(:segment)', 'Auth::attemptResetPassword/$1');

// User Routes
$routes->group('users', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Users\Dashboard::index');
    $routes->get('profile', 'Users\Profile::index');
    $routes->get('posts/bookmarks', 'Users\UserPosts::bookmarks');
});

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    // Posts
    $routes->get('posts', 'Admin\Posts::index');
    $routes->get('posts/create', 'Admin\Posts::create');
    $routes->get('posts/edit/(:num)', 'Admin\Posts::edit/$1');
    $routes->post('posts/edit/(:num)', 'Admin\Posts::edit/$1');
    $routes->get('posts/delete/(:num)', 'Admin\Posts::delete/$1');
    $routes->post('posts/validate-slug', 'Admin\Posts::validateSlug');

    // Categories
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/create', 'Admin\Categories::create');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    // Tags
    $routes->get('tags', 'Admin\Tags::index');
    $routes->get('tags/create', 'Admin\Tags::create');
    $routes->post('tags/create', 'Admin\Tags::create');
    $routes->get('tags/edit/(:num)', 'Admin\Tags::edit/$1');
    $routes->post('tags/edit/(:num)', 'Admin\Tags::update/$1');
    $routes->post('tags/delete/(:num)', 'Admin\Tags::delete/$1');

    // Advertisements - Ads
    $routes->get('ads', 'Admin\Ads\Ads::index');
    $routes->get('ads/create', 'Admin\Ads\Ads::create');
    $routes->post('ads/create', 'Admin\Ads\Ads::create');
    $routes->get('ads/edit/(:num)', 'Admin\Ads\Ads::edit/$1');
    $routes->post('ads/edit/(:num)', 'Admin\Ads\Ads::edit/$1');
    $routes->get('ads/delete/(:num)', 'Admin\Ads\Ads::delete/$1');
    $routes->get('ads/resetStats/(:num)', 'Admin\Ads\Ads::resetStats/$1');

    // Advertisements - Ads Slots
    $routes->get('ads/slots', 'Admin\Ads\AdSlots::index');
    $routes->get('ads/slots/create', 'Admin\Ads\AdSlots::create');
    $routes->post('ads/slots/create', 'Admin\Ads\AdSlots::create');
    $routes->get('ads/slots/edit/(:num)', 'Admin\Ads\AdSlots::edit/$1');
    $routes->post('ads/slots/edit/(:num)', 'Admin\Ads\AdSlots::edit/$1');
    $routes->get('ads/slots/delete/(:num)', 'Admin\Ads\AdSlots::delete/$1');

    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/create', 'Admin\Users::create');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // File/Image Store
    $routes->post('files/upload', 'Admin\FileStore::upload');
    $routes->get('files/list', 'Admin\FileStore::list');
    $routes->delete('files/delete', 'Admin\FileStore::delete');

    // Admin User Profile
    $routes->get('profile', 'Users\Profile::index');
});
