<?php
// Tempelkan ke app/Config/Routes.php (ganti route default '/')
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Kategori
    $routes->get('categories', 'Category::index');
    $routes->get('categories/create', 'Category::create');
    $routes->post('categories/store', 'Category::store');
    $routes->get('categories/edit/(:num)', 'Category::edit/$1');
    $routes->post('categories/update/(:num)', 'Category::update/$1');
    $routes->post('categories/delete/(:num)', 'Category::delete/$1');

    // Arsip
    $routes->get('archives', 'Archive::index');
    $routes->get('archives/create', 'Archive::create');
    $routes->post('archives/store', 'Archive::store');
    $routes->get('archives/show/(:num)', 'Archive::show/$1');
    $routes->get('archives/edit/(:num)', 'Archive::edit/$1');
    $routes->post('archives/update/(:num)', 'Archive::update/$1');
    $routes->post('archives/delete/(:num)', 'Archive::delete/$1');
    $routes->get('archives/file/(:num)', 'Archive::file/$1');          // lihat inline
    $routes->get('archives/download/(:num)', 'Archive::download/$1');  // unduh
});
