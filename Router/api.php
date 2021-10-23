<?php

use App\Controllers\MarcaController;

$router->get('/marca', [MarcaController::class, 'index']);

$router->get('/marca/:id', [MarcaController::class, 'show']);

$router->post('/marca', [MarcaController::class, 'insert']);

$router->put('/marca', [MarcaController::class, 'update']);

$router->delete('/marca/:marca_id', [MarcaController::class, 'destroy']);
