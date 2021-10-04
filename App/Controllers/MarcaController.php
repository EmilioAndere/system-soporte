<?php

namespace App\Controllers;

use App\Models\Marca;
use Config\Controller;

class MarcaController extends Controller{

    public function new(){
        $marca = new Marca();
        $marca->marca_id = 5;
        $marca->nombre = "Kiosera";
        $saludo = $marca->delete(5);
        echo $saludo;
    }

}