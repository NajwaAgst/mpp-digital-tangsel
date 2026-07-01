<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InteroperabilityController;

return [

    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'uri' => '/',
        'controller' => HomeController::class,
        'action' => 'index'
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'uri' => '/services',
        'controller' => ServiceController::class,
        'action' => 'index'
    ],

    [
        'method' => 'GET',
        'uri' => '/services/{slug}',
        'controller' => ServiceController::class,
        'action' => 'show'
    ],

    [
        'method' => 'GET',
        'uri' => '/services/{slug}/apply',
        'controller' => ServiceController::class,
        'action' => 'apply'
    ],

    [
        'method' => 'POST',
        'uri' => '/services/{slug}/apply',
        'controller' => ServiceController::class,
        'action' => 'apply'
    ],

    [
        'method' => 'GET',
        'uri' => '/sip-doctor',
        'controller' => ServiceController::class,
        'action' => 'sipForm'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    [
        'method' => 'GET',
        'uri' => '/login',
        'controller' => AuthController::class,
        'action' => 'showLogin'
    ],

    [
        'method' => 'GET',
        'uri' => '/register',
        'controller' => AuthController::class,
        'action' => 'showRegister'
    ],

    [
        'method' => 'POST',
        'uri' => '/auth/login',
        'controller' => AuthController::class,
        'action' => 'login'
    ],

    [
        'method' => 'POST',
        'uri' => '/auth/register',
        'controller' => AuthController::class,
        'action' => 'register'
    ],

    [
        'method' => 'POST',
        'uri' => '/auth/logout',
        'controller' => AuthController::class,
        'action' => 'logout'
    ],

    [
        'method' => 'GET',
        'uri' => '/auth/me',
        'controller' => AuthController::class,
        'action' => 'me'
    ],

    /*
    |--------------------------------------------------------------------------
    | Interoperability Demo
    |--------------------------------------------------------------------------
    */

    // Halaman Demo
    [
        'method' => 'GET',
        'uri' => '/interoperability',
        'controller' => InteroperabilityController::class,
        'action' => 'index'
    ],

    // API Dukcapil
    [
        'method' => 'GET',
        'uri' => '/mock/dukcapil/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'dukcapil'
    ],

    // API NPWP
    [
        'method' => 'GET',
        'uri' => '/mock/npwp/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'npwp'
    ],

    // API NIB
    [
        'method' => 'GET',
        'uri' => '/mock/nib/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'nib'
    ],

    // Aggregator SPBE
    [
        'method' => 'GET',
        'uri' => '/mock/interoperability/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'aggregate'
    ],

];