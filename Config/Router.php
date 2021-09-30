<?php

namespace Config;

class Router{

    private $basePath;
    private $path;
    private $routes = array();

    public function __construct($basePath = ""){
        $this->basePath = $basePath;
        $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $path = substr($path, strlen($basePath));
        $this->path = $path;
    }

    public static function load($router){
        require_once $router;
    }

    public function all($expr, $callback, $methods = null){
        $this->routes[] = new Matcher($expr, $callback, $methods);
    }

    public function get($expr, $callback){
        $this->routes[] = new Matcher($expr, $callback, 'GET');
    }

    public function post($expr, $callback){
        $this->routes[] = new Matcher($expr, $callback, "POST");
    }

    public function redirect($from_path, $to_path, $code = 302){
        $this->all($from_path, function () use ($to_path, $code) {
            http_response_code($code);
            echo $to_path;
            header("Location: {$to_path}");
        });
    }

    public function run(){
        foreach($this->routes as $route){
            if($route->matches($this->path)){
                return $route->exec();
            }
        }
    }
}