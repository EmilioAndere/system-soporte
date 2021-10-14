<?php

namespace App\Controllers;

use App\Models\Pantalla;
use Config\Controller;

class PantallaController extends Controller{

    public function index(){
        $pantallas = Pantalla::all(false);
        $this->json($pantallas);
    }
}