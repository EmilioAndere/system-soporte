<?php

namespace Config;

class Matcher{
    
    private $expresion;
    /** @var  array|calleable controller or function of the route*/
    private $callback;
    private $match;
    /** @var string[] metodos HTTP permitidos */
    private $methods = array("GET", "POST", "PUT", "DELETE");

    /**
    * Metodo Constructor
    *
    *@param string $expr Expresion
    *@param callable $callback Funcion a ejecutar
    *@param array|null $method metodos HTTP
    *@throw ErrorException
    */
    public function __construct($expr, $callback, $method = null){
        $path = $this->replace($expr);
        $this->expresion = "#^".$path."/?$#";
        $this->callback = $callback;
        if(!is_null($method)){
            $this->methods = is_array($method) ? $method : array($method);
        }
    }

    /**
     * Checa coincidencias en las rutas;
     * @param string $path ruta del request
     * 
     * @return bool
     */
    public function matches($path): bool{
        if(preg_match($this->expresion, $path, $this->match) && in_array($_SERVER['REQUEST_METHOD'], $this->methods)){
            // var_dump($this->match);
            return true;
        }
        return false;
    }

    public function replace($path): string{
        $rute = explode("/", $path);
        array_shift($rute);
        foreach ($rute as $key => $value) {
            if(str_contains($value, ":")){
                $rute[$key] = "([a-zA-Z0-9-]+)";
            }
        }
        return "/".join("/", $rute);
    }

    public function exec(){
        if(is_array($this->callback)){
            $this->callback[0] = new $this->callback[0]();
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $req = new Request();
            array_push($this->match, $req);
        }

        if($_SERVER['REQUEST_METHOD'] == 'PUT'){
            $datos = json_decode(file_get_contents('php://input'), true);
            $req = new Request($datos);
            array_push($this->match, $req);
        }
        return call_user_func_array($this->callback, array_slice($this->match, 1));
    }

}