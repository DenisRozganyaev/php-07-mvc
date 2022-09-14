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
$router->add('logout', ['controller' => \App\Controllers\AuthController::class, 'action' => 'logout', 'method' => 'POST']);
$router->add('registration', ['controller' => \App\Controllers\AuthController::class, 'action' => 'registration', 'method' => 'GET']);
$router->add('auth/verify', ['controller' => \App\Controllers\AuthController::class, 'action' => 'verify', 'method' => 'POST']);
$router->add('users/store', ['controller' => \App\Controllers\UsersController::class, 'action' => 'store', 'method' => 'POST']);
