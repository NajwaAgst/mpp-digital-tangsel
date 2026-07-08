<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InteroperabilityController;
use App\Http\Controllers\ServiceController;

return [

    /*
    |--------------------------------------------------------------------------
    | HOME (HALAMAN INDUK)
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/',
        'controller' => HomeController::class,
        'action' => 'index'
    ],

    [
    'method' => 'GET',
    'uri' => '/dashboard',
    'controller' => ServiceController::class,
    'action' => 'dashboard'
],


    /*
    |--------------------------------------------------------------------------
    | MPP
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
    'uri' => '/services/history',
    'controller' => ServiceController::class,
    'action' => 'history'
],

[
    'method' => 'GET',
    'uri' => '/services/history/{id}',
    'controller' => ServiceController::class,
    'action' => 'historyDetail'
],

[
    'method' => 'GET',
    'uri' => '/services/history/{id}/download',
    'controller' => ServiceController::class,
    'action' => 'downloadPdf'
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

    


    /*
    |--------------------------------------------------------------------------
    | EMERGENCY 112
    |--------------------------------------------------------------------------
    */

    // Landing Emergency
    [
        'method' => 'GET',
        'uri' => '/emergency',
        'controller' => EmergencyController::class,
        'action' => 'index'
    ],

    // Form laporan
    [
        'method' => 'GET',
        'uri' => '/emergency/report',
        'controller' => EmergencyController::class,
        'action' => 'report'
    ],

    [
        'method' => 'POST',
        'uri' => '/emergency/report',
        'controller' => EmergencyController::class,
        'action' => 'report'
    ],

    // Success
    [
        'method' => 'GET',
        'uri' => '/emergency/success/{id}',
        'controller' => EmergencyController::class,
        'action' => 'success'
    ],

    // API
    [
        'method' => 'GET',
        'uri' => '/api/emergency',
        'controller' => EmergencyController::class,
        'action' => 'api'
    ],


    /*
    |--------------------------------------------------------------------------
    | AUTH MPP (SSO)
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


    /*
    |--------------------------------------------------------------------------
    | AUTH EMERGENCY (VIEW BERBEDA, DATABASE SAMA)
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/emergency/login',
        'controller' => AuthController::class,
        'action' => 'showEmergencyLogin'
    ],

    [
        'method' => 'GET',
        'uri' => '/emergency/register',
        'controller' => AuthController::class,
        'action' => 'showEmergencyRegister'
    ],


    /*
    |--------------------------------------------------------------------------
    | AUTH PROCESS (SSO)
    |--------------------------------------------------------------------------
    */

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
    | INTEROPERABILITY
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/interoperability',
        'controller' => InteroperabilityController::class,
        'action' => 'index'
    ],

    [
        'method' => 'GET',
        'uri' => '/mock/dukcapil/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'dukcapil'
    ],

    [
        'method' => 'GET',
        'uri' => '/mock/npwp/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'npwp'
    ],

    [
        'method' => 'GET',
        'uri' => '/mock/nib/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'nib'
    ],

    [
        'method' => 'GET',
        'uri' => '/mock/interoperability/{nik}',
        'controller' => InteroperabilityController::class,
        'action' => 'aggregate'
    ],


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/admin',
        'controller' => AdminController::class,
        'action' => 'dashboard'
    ],

    [
        'method' => 'GET',
        'uri' => '/admin/dashboard',
        'controller' => AdminController::class,
        'action' => 'dashboard'
    ],


    /*
    |--------------------------------------------------------------------------
    | ADMIN APPLICATION
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/admin/applications',
        'controller' => AdminController::class,
        'action' => 'applications'
    ],

    [
        'method' => 'GET',
        'uri' => '/admin/applications/{id}',
        'controller' => AdminController::class,
        'action' => 'show'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/applications/{id}/approve',
        'controller' => AdminController::class,
        'action' => 'approve'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/applications/{id}/reject',
        'controller' => AdminController::class,
        'action' => 'reject'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/applications/{id}/pending',
        'controller' => AdminController::class,
        'action' => 'pending'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/applications/{id}/delete',
        'controller' => AdminController::class,
        'action' => 'delete'
    ],


    /*
    |--------------------------------------------------------------------------
    | ADMIN EMERGENCY
    |--------------------------------------------------------------------------
    */

    [
        'method' => 'GET',
        'uri' => '/admin/emergencies',
        'controller' => AdminController::class,
        'action' => 'emergencies'
    ],

    [
        'method' => 'GET',
        'uri' => '/admin/emergencies/export/pdf',
        'controller' => AdminController::class,
        'action' => 'exportEmergencyPdf'
    ],

    [
        'method' => 'GET',
        'uri' => '/admin/emergencies/{id}',
        'controller' => AdminController::class,
        'action' => 'emergencyDetail'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/emergencies/{id}/waiting',
        'controller' => AdminController::class,
        'action' => 'emergencyWaiting'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/emergencies/{id}/process',
        'controller' => AdminController::class,
        'action' => 'emergencyProcess'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/emergencies/{id}/done',
        'controller' => AdminController::class,
        'action' => 'emergencyDone'
    ],

    [
        'method' => 'POST',
        'uri' => '/admin/emergencies/{id}/delete',
        'controller' => AdminController::class,
        'action' => 'deleteEmergency'
    ],

    [
    'method'=>'GET',
    'uri'=>'/emergency/history',
    'controller'=>EmergencyController::class,
    'action'=>'history'
],

[
    'method'=>'GET',
    'uri'=>'/emergency/history/{id}',
    'controller'=>EmergencyController::class,
    'action'=>'detail'
],

];