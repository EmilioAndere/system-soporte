<?php

namespace Config;

use Config\Interfaces\IDbConnection;
use Exception;
use PDO;
use PDOException;

class Connection implements IDbConnection{

    private $dns;
    private $user;
    private $pass;
    protected $con;

    public function __construct(){
        $this->dns = $_ENV['DB_DNS'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
    }

    public function connect(){
        try {
            $this->con = new PDO($this->dns, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo "Fallo la conexion: $e->getMessage()";
        }
    }

    public function close(){
        $this->con = null;
    }

    public function getData($sql){
        $this->connect();
        $res = $this->con->query($sql);
        $error = $this->con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            $this->close();
            return $data;
        }

        return $error;
    }

    public function getSingle($sql){
        $this->connect();
        $res = $this->con->query($sql);
        $error = $this->con->errorInfo();

        if($error[0] === "00000"){
            $res->execute();
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $this->close();
            return $data;
        }

        return $error;
    }

    public function exeIns($sql){
        $this->connect();
        $res = $this->con->prepare($sql);
        try {
            $res->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        if(str_contains($sql, "UPDATE") || str_contains($sql, "DELETE")){
            if($res->rowCount() > 0){
                return $res->rowCount();
            }else{
                throw new Exception("No se ha ACTUALIZADO/ELIMINADO ningun registro");
            }
        }else{
            if($this->con->lastInsertId() > 0){
                return $this->con->lastInsertId();
            }else{
                throw new Exception("No se ha INSERTADO ningun registro");                
            }
        }
    }
}