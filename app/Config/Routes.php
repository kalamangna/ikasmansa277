<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Route
$routes->get('/', 'Dashboard::index');

// Auth Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

// Alumni Routes
$routes->group('alumni', function($routes) {
    $routes->get('/', 'Alumni::index');
    $routes->get('create', 'Alumni::create');
    $routes->post('save', 'Alumni::save');
    $routes->get('detail/(:num)', 'Alumni::detail/$1');
    $routes->get('edit/(:num)', 'Alumni::edit/$1');
    $routes->post('update/(:num)', 'Alumni::update/$1');
    $routes->post('get_kabupaten_ajax', 'Alumni::get_kabupaten_ajax');
    $routes->get('search', 'Alumni::search');
});

// API Routes
$routes->get('api/kabupaten/(:num)', 'Alumni::getKabupatenApi/$1');

// Dashboard
$routes->get('dashboard', 'Dashboard::index');

// Admin Group
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    
    $routes->group('alumni', function($routes) {
        $routes->get('/', 'Alumni::index');
        $routes->get('detail/(:num)', 'Alumni::detail/$1');
        $routes->get('edit/(:num)', 'Alumni::edit/$1');
        $routes->post('delete/(:num)', 'Alumni::delete/$1');
    });

    // Content Management
    $routes->get('pages', 'Pages::index');
    $routes->get('pages/create', 'Pages::create');
    $routes->post('pages/save', 'Pages::create'); // Assuming save maps to create logic in the refactored controller
    $routes->get('pages/edit/(:num)', 'Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Pages::edit/$1');
    $routes->get('pages/delete/(:num)', 'Pages::delete/$1');

    $routes->get('news', 'News::index');
    $routes->get('news/create', 'News::create');
    $routes->post('news/save', 'News::create');
    $routes->get('news/edit/(:num)', 'News::edit/$1');
    $routes->post('news/update/(:num)', 'News::edit/$1');
    $routes->get('news/delete/(:num)', 'News::delete/$1');
    
    $routes->get('counter', 'Counter::index');
});

// Qr Code
$routes->get('qr_code', 'QrCodeController::index');

// Catch-all for legacy pages
$routes->get('pages/(:segment)', 'Pages::index/$1');