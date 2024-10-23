<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardContoller;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/auth', [AuthController::class, 'index']);
$routes->get('/dashboard', [DashboardContoller::class, 'index']);

