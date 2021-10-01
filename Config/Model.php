<?php

namespace Config;

class Model extends MySql{

    protected $data = array();

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
    }

    private function getTable(){
        if(isset($this->table)){
            return $this->table;
        }else{
            $class = explode("\\", get_class($this));
            $table = strtolower($class[count($class)-1])."s ";
            return $table;
        }
    }

    public function save(){
        $table = $this->getTable();
        $query  = "INSERT INTO $table ";
        $fields = "( ";
        $values = "( ";
        if(count($this->data) == 0){
            throw new \Exception("No hay atributos para insertar");
        }
        foreach ($this->data as $key => $value) {
            $fields .= $key.", "; 
            $values .= "'".$value."', ";
        }
        $fields = substr($fields, 0, -2)." )";
        $values = substr($values, 0, -2)." )";
        $query .= $fields." VALUES ".$values;
        echo $query;
    }

}