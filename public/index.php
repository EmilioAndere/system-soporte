<?php

define("DS", "/");

require '../vendor/autoload.php';
require_once './../Config/Autoload.php';
Autoload::run();

use Dotenv\Dotenv;

$env = Dotenv::createImmutable("../");
$env->load();

use Config\Router;

$router = new Router();
require_once './../Router/web.php';
$router ->run();