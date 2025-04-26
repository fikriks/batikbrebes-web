<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama dan Auth
$routes->get('/', 'AuthController::login', ['filter' => 'guest']);
$routes->get('login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('login', 'AuthController::attemptLogin', ['filter' => 'guest']);
$routes->get('logout', 'AuthController::logout');

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'AdminController::dashboard');
    
    // CRUD Produk
    $routes->get('produk', 'ProdukController::index');
    $routes->get('produk/tambah', 'ProdukController::tambah');
    $routes->post('produk/simpan', 'ProdukController::simpan');
    $routes->get('produk/edit/(:num)', 'ProdukController::edit/$1');
    $routes->match(['post', 'put'], 'produk/update/(:num)', 'ProdukController::update/$1');
    $routes->get('produk/hapus/(:num)', 'ProdukController::hapus/$1');
});

// API Routes
$routes->post('api/scan', 'ApiController::scanQRCode');