<?php

namespace Config;

class Controller{

    public function __construct(){
        
    }

    public function json($data){
        echo json_encode($data);
    }

}