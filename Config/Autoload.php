<?php

class Autoload{

    public static function run(){
        spl_autoload_register(function($class){
            $path = "../".str_replace("\\", "/", $class).".php";
            if(is_readable($path)){
                include_once $path;
            }else{
                throw new Exception("La clase a la que estas haciendo referencia no existe $class");
            }
        });
    }

}