<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardContoller;
use App\Controllers\Supplier;
use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard', [DashboardContoller::class, 'index']);
$routes->get('/users', [Users::class, 'index']);

// route supplier
$routes->get('/supplier', [Supplier::class, 'index']);
$routes->get('/supplier/create', [Supplier::class, 'create']);
$routes->post('/supplier/store', [Supplier::class, 'store']);
$routes->get('/supplier/edit/(:segment)', [Supplier::class, 'edit/$1']);
$routes->post('/supplier/update/(:segment)', [Supplier::class, 'update/$1']);
$routes->delete('/supplier/(:num)', [Supplier::class, 'delete/$1']);
