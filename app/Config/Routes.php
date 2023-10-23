<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', function() {
    return redirect()->to('users');
});
$routes->resource('users'); // RESTful resource