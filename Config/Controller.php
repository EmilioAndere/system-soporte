<?php

namespace Config;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller{

    protected $tmp;
    protected $uri;

    public function __construct(){
        $loader = new FilesystemLoader('../Views');
        $this->tmp = new Environment($loader);
        $this->uri = $_SERVER['REQUEST_URI'];
    }

}