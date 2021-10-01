<?php

namespace App\Controllers;

use App\Models\Marca;
use Config\Controller;

class MarcaController extends Controller{

    public function new(){
        $marca = new Marca();
        $marca = $marca->select("marca")->where("name", "HP")->where("id", 1)->join("equipo", "equipo.id", "marca.equipo_id")->join("equipo", "equipo.id", "marca.equipo_id");
        echo "<pre>";
        var_dump($marca);
        echo "</pre>";
    }

}