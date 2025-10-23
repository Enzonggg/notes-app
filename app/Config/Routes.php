<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

// Authentication Routes
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/registerSubmit', 'Auth::registerSubmit');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/loginSubmit', 'Auth::loginSubmit');
$routes->get('auth/logout', 'Auth::logout');

// Dashboard Route
$routes->get('dashboard', 'Home::dashboard');

// Notes Routes (API)
$routes->get('notes/list', 'Notes::list');
$routes->post('notes/create', 'Notes::create');
$routes->post('notes/update', 'Notes::update');
$routes->post('notes/delete', 'Notes::delete');
