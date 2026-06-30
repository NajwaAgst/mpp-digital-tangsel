<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InteroperabilityController;

return [
    ['method' => 'GET', 'uri' => '/', 'controller' => HomeController::class, 'action' => 'index'],

    ['method' => 'GET', 'uri' => '/services', 'controller' => ServiceController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/services/{slug}', 'controller' => ServiceController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/services/{slug}/apply', 'controller' => ServiceController::class, 'action' => 'apply'],
    ['method' => 'POST', 'uri' => '/services/{slug}/apply', 'controller' => ServiceController::class, 'action' => 'apply'],

    ['method' => 'GET', 'uri' => '/sip-doctor', 'controller' => ServiceController::class, 'action' => 'sipForm'],

    ['method' => 'GET', 'uri' => '/login', 'controller' => AuthController::class, 'action' => 'showLogin'],
    ['method' => 'GET', 'uri' => '/register', 'controller' => AuthController::class, 'action' => 'showRegister'],
    ['method' => 'POST', 'uri' => '/auth/login', 'controller' => AuthController::class, 'action' => 'login'],
    ['method' => 'POST', 'uri' => '/auth/register', 'controller' => AuthController::class, 'action' => 'register'],
    ['method' => 'POST', 'uri' => '/auth/logout', 'controller' => AuthController::class, 'action' => 'logout'],
    ['method' => 'GET', 'uri' => '/auth/me', 'controller' => AuthController::class, 'action' => 'me'],

    ['method' => 'GET', 'uri' => '/mock/dukcapil/{nik}', 'controller' => InteroperabilityController::class, 'action' => 'dukcapil'],
    ['method' => 'GET', 'uri' => '/mock/kemenkes/{str}', 'controller' => InteroperabilityController::class, 'action' => 'kemenkes'],
];
