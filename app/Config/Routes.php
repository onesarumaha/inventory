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
$routes->get('/', [DashboardContoller::class, 'index']);

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
$routes->post('/supplier/tambah', [Supplier::class, 'tambah']);

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
$routes->post('/product/tambah', [Product::class, 'tambah']);

// route pengeluaran
$routes->get('/pengeluaran', [Transaksi::class, 'index']);
$routes->get('/pengeluaran/create', [Transaksi::class, 'create']);
$routes->get('/pengeluaran/details/(:num)', [Transaksi::class, 'getProductDetails/$1']);
$routes->post('/pengeluaran/store', [Transaksi::class, 'store']);
$routes->get('/pengeluaran/edit/(:any)', [Transaksi::class, 'edit/$1']);
$routes->get('/pengeluaran/view/(:any)', [Transaksi::class, 'view/$1']);


// route pemasukan
$routes->get('/pemasukan', [Pemasukan::class, 'index']);
$routes->get('/pemasukan/create', [Pemasukan::class, 'create']);
$routes->post('/pemasukan/store', [Pemasukan::class, 'store']);
$routes->get('/pemasukan/edit/(:any)', [Pemasukan::class, 'edit/$1']);
$routes->post('/pemasukan/update/(:any)', [Pemasukan::class, 'update/$1']);
$routes->get('/pemasukan/download/(:any)', [Pemasukan::class, 'download/$1']);
$routes->post('/pemasukan/approve-admin/(:num)', [Pemasukan::class, 'approveAdmin/$1']); 
$routes->post('/pemasukan/approve-owner/(:num)', [Pemasukan::class, 'approveOwner/$1']); 
$routes->post('/pemasukan/save-quantity', [Pemasukan::class, 'saveQuantityReal']); 
$routes->get('/pemasukan/view/(:any)', [Pemasukan::class, 'view/$1']);
$routes->delete('/pemasukan/(:num)', [Pemasukan::class, 'delete/$1']);
$routes->post('/pemasukan/save-reject', [Pemasukan::class, 'saveReject']); 


// route stok product
$routes->get('/stock', [Stock::class, 'index']);
$routes->get('/filter-stock', [Stock::class, 'filter']);
$routes->get('/export-data-stock-pdf', [Stock::class, 'exportDataStock']);
$routes->get('/export-data-stock', [Stock::class, 'exportDataStock']);


$routes->get('/omset', [Omset::class, 'index']);
$routes->get('/laporan-pengadaan', [Omset::class, 'pengadaan']);
$routes->get('/filter-omset', [Omset::class, 'filter']);
$routes->get('/filter-omset-pengadaan', [Omset::class, 'filterPengadaan']);
$routes->get('/export-data-omset', [Omset::class, 'exportDataOmset']);
$routes->get('/export-data-omset-pengadaan', [Omset::class, 'exportDataOmsetPengadaan']);

// route profile
$routes->get('/profile', [Profile::class, 'index']);
$routes->get('/profile/ganti-password', [Profile::class, 'gantiPassword']);
$routes->post('/profile/update-password', [Profile::class, 'updatePassword']);

// chart
$routes->get('/chart-penjualan-petugas', [DashboardContoller::class, 'getSalesData']);
$routes->get('/get-top-product', [DashboardContoller::class, 'getTopProduct']);
