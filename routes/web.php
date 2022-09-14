<?php
/**
 * @var $router Core\Router
 */
$router->add('', [
   'controller' => \App\Controllers\HomeController::class,
    'action' => 'index',
    'method' => 'GET'
]);
$router->add('login', ['controller' => \App\Controllers\AuthController::class, 'action' => 'login', 'method' => 'GET']);
$router->add('logout', ['controller' => \App\Controllers\AuthController::class, 'action' => 'logout', 'method' => 'GET']);
$router->add('registration', ['controller' => \App\Controllers\AuthController::class, 'action' => 'registration', 'method' => 'GET']);
$router->add('auth/verify', ['controller' => \App\Controllers\AuthController::class, 'action' => 'verify', 'method' => 'POST']);
$router->add('users/store', ['controller' => \App\Controllers\UsersController::class, 'action' => 'store', 'method' => 'POST']);

$router->add('admin/dashboard', ['controller' => \App\Controllers\Admin\DashboardController::class, 'action' => 'index', 'method' => 'GET']);

$router->add('admin/posts', ['controller' => \App\Controllers\Admin\PostsController::class, 'action' => 'index', 'method' => 'GET']);


$router->add('admin/categories', ['controller' => \App\Controllers\Admin\CategoriesController::class, 'action' => 'index', 'method' => 'GET']);
$router->add('admin/categories/create', ['controller' => \App\Controllers\Admin\CategoriesController::class, 'action' => 'create', 'method' => 'GET']);
$router->add('admin/categories/{id:\d+}/edit', ['controller' => \App\Controllers\Admin\CategoriesController::class, 'action' => 'edit', 'method' => 'GET']);
$router->add('admin/categories/store', ['controller' => \App\Controllers\Admin\CategoriesController::class, 'action' => 'store', 'method' => 'POST']);
