<?php

namespace App\Controllers;

use App\Models\Usuario;
use Config\Controller;
use Config\Request;

class UsuarioController extends Controller{

    public function auth(Request $req){
        $user = new Usuario();
        $resp = $user->select('usuarios')
        ->where('usuario', $req->getBody()->usuario)->exec();
        if(count($resp) != 0){
            if(password_verify($req->getBody()->password, $resp[0]['password']))
                $this->json($resp);
            else
                $this->json(['error' => 'El Usuario y/o Contraseña son Incorrectos']);        
        }else{
            $this->json(['error' => 'El Usuario y/o Contraseña son Incorrectos']);
        }
    }

    public function register(Request $req){
        $user = new Usuario();
        $user->nombre = $req->getBody()->nombre;
        $user->usuario = $req->getBody()->usuario;
        $user->password = password_hash($req->getBody()->password, PASSWORD_BCRYPT);
        $user->imagen = $req->getBody()->imagen;
        $user->rol_id = $req->getBody()->rol_id;
        $user->save();
    }

}