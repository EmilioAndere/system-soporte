<?php

namespace App\Controllers;

use App\Models\Marca;
use Config\Controller;

class MarcaController extends Controller{

    public function new(){
        $marca = new Marca();
        // $marca->id = 2;
        $marca->nombre = "Dell";
        $marca->save();
    }

}