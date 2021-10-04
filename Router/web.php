<?php

use App\Controllers\MarcaController;

// $router->redirect("/", "/marca");

$router->get("/marca/:id", [Persona::class, "add"]);

$router->get("/cat/:id", [Persona::class, 'index']);

$router->get("/marca", [MarcaController::class, 'new']);
