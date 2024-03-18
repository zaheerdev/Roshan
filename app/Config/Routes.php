<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/testdb', 'Auth::testdb');
