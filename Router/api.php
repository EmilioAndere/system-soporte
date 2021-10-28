<?php

use App\Controllers\AplicacionController;
use App\Controllers\EquipoController;
use App\Controllers\InstalacionController;
use App\Models\Installation;

$router->get('/devices', [EquipoController::class, 'index']);
$router->get('/get/devices', [EquipoController::class, 'all']);
$router->get('/apps', [AplicacionController::class, 'index']);
$router->get('/install', [InstalacionController::class, 'index']);

$router->get('/devices/:id', [EquipoController::class, 'show']);
$router->get('/devices/:id/:param', [EquipoController::class, 'show']);
$router->get('/app/:id', [AplicacionController::class, 'show']);
$router->get('/instalation/:name', [InstalacionController::class, 'show']);

$router->post('/device', [EquipoController::class, 'insert']);
$router->post('/app', [AplicacionController::class, 'insert']);
$router->post('/install', [InstalacionController::class, 'insert']);

$router->put('/device', [EquipoController::class, 'update']);
$router->put('/app', [AplicacionController::class, 'update']);

$router->delete('/device/:id', [EquipoController::class, 'destroy']);
$router->delete('/app/:id', [AplicacionController::class, 'destroy']);
$router->delete('/install/:id', [InstalacionController::class, 'destroy']);
