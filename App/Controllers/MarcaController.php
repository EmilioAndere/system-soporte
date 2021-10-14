<?php

namespace App\Controllers;

use App\Models\Marca;
use Config\Controller;

class MarcaController extends Controller{

    public function index(){
        $marcas = Marca::all();
        echo json_encode($marcas);
    }

}