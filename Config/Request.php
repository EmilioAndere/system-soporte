<?php

namespace Config;

class Request {

    protected $data;
    protected $datos = null;
    public $code;


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __construct(){
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_contructor = '__construct'.$num_params;
        if(method_exists($this, $funcion_contructor)){
            call_user_func_array(array($this, $funcion_contructor), $params);
        }
    }

    public function __construct1(array $datos)
    {
        $this->datos = $datos;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
    }

    public function getBody(){
        if(!is_null($this->datos)){
            foreach ($this->datos as $key => $value) {
                $this->$key = $value;
            }
        }else{
            foreach ($_REQUEST as $key => $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function code(int $code){
        http_response_code($code);
    }

}