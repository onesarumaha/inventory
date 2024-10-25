<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardContoller;
use App\Controllers\Product;
use App\Controllers\Supplier;
use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard', [DashboardContoller::class, 'index']);

// route users
$routes->get('/users', [Users::class, 'index']);
$routes->delete('/users/(:num)', [Product::class, 'delete/$1']);

// route supplier
$routes->get('/supplier', [Supplier::class, 'index']);
$routes->get('/supplier/create', [Supplier::class, 'create']);
$routes->post('/supplier/store', [Supplier::class, 'store']);
$routes->get('/supplier/edit/(:segment)', [Supplier::class, 'edit/$1']);
$routes->post('/supplier/update/(:segment)', [Supplier::class, 'update/$1']);
$routes->delete('/supplier/(:num)', [Supplier::class, 'delete/$1']);

// route product
$routes->get('/product', [Product::class, 'index']);
$routes->get('/product/create', [Product::class, 'create']);
$routes->post('/product/store', [Product::class, 'store']);
$routes->get('/product/edit/(:segment)', [Product::class, 'edit/$1']);
$routes->post('/product/update/(:segment)', [Product::class, 'update/$1']);
$routes->delete('/product/(:num)', [Product::class, 'delete/$1']);