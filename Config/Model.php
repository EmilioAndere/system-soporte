<?php

namespace Config;

use Exception;

class Model extends MySql{

    protected $data = array();
    private $params = array();

    public function __construct(){
        parent::__construct();
        
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
    }

    public static function find($value){
        $class = get_called_class();
        $instance = new $class();
        $table = isset($instance->table) ? $instance->table : strtolower(explode('\\', $class)[2]."s");
        $field = isset($instance->primary) ? $instance->primary : 'id';
        $instance->connect();
        $res = $instance->con->query("SELECT * FROM $table WHERE $field = $value");
        $error = $instance->con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            $data = $res->fetchAll(\PDO::FETCH_ASSOC);
            $conn = null;
            return $data;
        }

        return $error;
    }

    public static function all(){
        $class = get_called_class();
        $instance = new $class();
        $table = isset($instance->table) ? $instance->table : strtolower(explode('\\', $class)[2]."s");
        $instance->connect();
        $res = $instance->con->query("SELECT * FROM $table");
        $error = $instance->con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            $data = $res->fetchAll(\PDO::FETCH_ASSOC);
            $instance->con = null;
            return $data;
        }

        return $error;
    }

    public function save(){
        $table = isset($this->table) ? $this->table : strtolower(explode('\\', get_called_class())[2]."s");
        $field_id = isset($this->primary) ? $this->primary : "id";
        

        if(isset($this->data[$field_id]) && $this->data[$field_id] != 0){
            foreach ($this->data as $key => $value) {
                if($key != $field_id)
                    array_push($this->params, $key." = '".$value."'");
            }
            $data = implode(',', $this->params);
            $id = $this->data[$field_id];
            $sql = "UPDATE $table SET $data WHERE $field_id = $id";
            $resp = "affected_cols";
        }else{
            $keys = array();
            $vals = array();
            foreach ($this->data as $key => $value) {
                    array_push($keys, $key);
                    ($value == 'NULL') ? array_push($vals, $value) : array_push($vals, "'".$value."'");
            }
            $data = implode(',', $this->params);
            $sql = "INSERT INTO $table ( ".implode(',', $keys)." ) VALUES ( ".implode(',', $vals)." )";
            $resp = "lasted_id";
        }

        try {
            $rows = $this->exeIns($sql);
            echo json_encode([$resp => $rows]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function delete($id){
        $class = get_called_class();
        $instance = new $class();
        $instance->connect();
        $table = isset($instance->table) ? $instance->table : strtolower(explode('\\', $class)[2]."s");
        $field = isset($instance->primary) ? $instance->primary : 'id';
        $sql = "DELETE FROM $table WHERE $field = $id";
        $res = $instance->con->prepare($sql);
        $error = $instance->con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            echo json_encode('deleted');
        }else{
            echo json_encode('a ocurrido un error');
        }
        
    }

    

}