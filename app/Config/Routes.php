<?php

use App\Controllers\AuthController;
use App\Controllers\Customer;
use App\Controllers\DashboardContoller;
use App\Controllers\Omset;
use App\Controllers\Pemasukan;
use App\Controllers\Product;
use App\Controllers\Profile;
use App\Controllers\Stock;
use App\Controllers\Supplier;
use App\Controllers\Transaksi;
use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard', [DashboardContoller::class, 'index']);

// route users
$routes->get('/users', [Users::class, 'index']);
$routes->delete('/users/(:num)', [Users::class, 'delete/$1']);
$routes->get('/users/edit/(:segment)', [Users::class, 'edit/$1']);
$routes->post('/users/update/(:segment)', [Users::class, 'update/$1']);


// route supplier
$routes->get('/supplier', [Supplier::class, 'index']);
$routes->get('/supplier/create', [Supplier::class, 'create']);
$routes->post('/supplier/store', [Supplier::class, 'store']);
$routes->get('/supplier/edit/(:segment)', [Supplier::class, 'edit/$1']);
$routes->post('/supplier/update/(:segment)', [Supplier::class, 'update/$1']);
$routes->delete('/supplier/(:num)', [Supplier::class, 'delete/$1']);

// route customer
$routes->get('/customer', [Customer::class, 'index']);
$routes->get('/customer/create', [Customer::class, 'create']);
$routes->post('/customer/store', [Customer::class, 'store']);
$routes->get('/customer/edit/(:segment)', [Customer::class, 'edit/$1']);
$routes->post('/customer/update/(:segment)', [Customer::class, 'update/$1']);
$routes->delete('/customer/(:num)', [Customer::class, 'delete/$1']);

// route product
$routes->get('/product', [Product::class, 'index']);
$routes->get('/product/create', [Product::class, 'create']);
$routes->post('/product/store', [Product::class, 'store']);
$routes->get('/product/edit/(:segment)', [Product::class, 'edit/$1']);
$routes->post('/product/update/(:segment)', [Product::class, 'update/$1']);
$routes->delete('/product/(:num)', [Product::class, 'delete/$1']);

// route pengeluaran
$routes->get('/pengeluaran', [Transaksi::class, 'index']);
$routes->get('/pengeluaran/create', [Transaksi::class, 'create']);

// route pemasukan
$routes->get('/pemasukan', [Pemasukan::class, 'index']);
$routes->get('/pemasukan/create', [Pemasukan::class, 'create']);
$routes->post('/pemasukan/store', [Pemasukan::class, 'store']);
$routes->get('/pemasukan/edit/(:any)', [Pemasukan::class, 'edit/$1']);
$routes->get('/pemasukan/download/(:any)', [Pemasukan::class, 'download/$1']);


// route stok product
$routes->get('/stock', [Stock::class, 'index']);
$routes->get('/omset', [Omset::class, 'index']);

// route profile
$routes->get('/profile', [Profile::class, 'index']);
$routes->get('/profile/ganti-password', [Profile::class, 'gantiPassword']);
$routes->post('/profile/update-password', [Profile::class, 'updatePassword']);
