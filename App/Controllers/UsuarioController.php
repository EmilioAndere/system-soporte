<?php

namespace App\Controllers;

use App\Models\Usuario;
use Config\Controller;

class UsuarioController extends Controller{

    public function index(){
        $usuarios = Usuario::all();
        $this->json($usuarios);
    }

}