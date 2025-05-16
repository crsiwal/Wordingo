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
$routes->get('/', 'Home::index');
$routes->get('post/(:segment)', 'Home::post/$1');
$routes->get('category/(:segment)', 'Home::category/$1');
$routes->get('tag/(:segment)', 'Home::tag/$1');
$routes->get('search', 'Home::search');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::attemptForgotPassword');
$routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('reset-password/(:segment)', 'Auth::attemptResetPassword/$1');

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

    // Ads
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
