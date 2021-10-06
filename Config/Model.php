<?php

namespace Config;

use Exception;

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

    private function getPrimary(){
        if(isset($this->primary_key)){
            return $this->primary_key;
        }else{
            $field_id = substr($this->getTable(), 0, -2)."_id";
            return $field_id;
        }
    }

    private function getInsert(){
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
        return $query;
    }

    private function getUpdate($id){
        $table = $this->getTable();
        $values = "";
        $query = "UPDATE $table SET ";
        if(count($this->data) == 0){
            throw new \Exception("No hay atributos para insertar");
        }
        foreach ($this->data as $key => $value) {
            $values .= $key."='".$value."', ";
        }
        $query .= $values;
        $query = substr($query, 0, -2)." WHERE ".substr($table, 0, -2)."_id = ".$id;
        return $query;
    }

    public function save(){
        $field_id = substr($this->getTable(), 0, -2)."_id";
        if(isset($this->data[$field_id])){
            $sql = $this->getUpdate($this->data[$field_id]);
        }else{
            $sql = $this->getInsert();
        }
        try {
            $rows = $this->exeIns($sql);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $rows;
    }

    public function delete($id){
        try {
            $table = $this->getTable();
            $field = $this->getPrimary();
            $query = "DELETE FROM $table WHERE ".$field." = $id";
            $numRows = $this->exeIns($query);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $numRows;
    }

    public static function all(){
        $class = explode("\\", get_called_class());
        $table = strtolower($class[count($class)-1])."s ";
        try {
            $con = new \PDO($_ENV['DB_DNS'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
        } catch (\PDOException $e) {
            echo "Fallo la conexion: $e->getMessage()";
        }
        $res = $con->query("SELECT * FROM $table");
        $error = $con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            $data = $res->fetchAll(\PDO::FETCH_ASSOC);
            $con = null;
            return $data;
        }

        return $error;
    }

}