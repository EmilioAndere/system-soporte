<?php

namespace App\Controllers;

use App\Models\Categoria;
use Config\Controller;

class CategoriaController extends Controller{

    public function index(){
        $categorias = Categoria::all();
        $this->json($categorias);
    }

}