<?php

namespace Config;

class Model{

    protected $query;

    public function __construct(){
        $this->query = new MySql();
    }

}