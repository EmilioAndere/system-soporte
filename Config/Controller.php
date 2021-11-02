<?php

namespace Config;

class Controller{

    public function json($data){
        echo json_encode($data);
    }

    public function exist($var){
        if(isset($var)){
            return $var;
        }

        return 'NULL';
    }

}