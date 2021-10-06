<?php

use App\Controllers\DeviceController;
use App\Controllers\ViewsController;

$router->get("/", [ViewsController::class, "dash"]);
$router->get("/devices", [DeviceController::class, "index"]);
