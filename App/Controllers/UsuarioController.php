<?php

namespace App\Controllers;

use App\Models\Usuario;
use Config\Controller;

class UsuarioController extends Controller{

    public function index(){
        $usuarios = Usuario::all();
        $this->json($usuarios);
    }

    public function authorize(){
        $user = new Usuario();
        $result = $user->select('usuarios', ['usuario', 'password'])
        ->where('usuario', $_POST['usuario'])
        ->where('password', $_POST['pass'])
        ->where('rol_id', 1)->exec();
        if(count($result) == 1){
            $this->json(['auth' => true]);
        }else{
            $this->json(['auth' => false]);
        }
    }

    public function login(){
        $user =new Usuario();
        $result = $user->select('usuarios', ['usuarios.*', 'rol.nombre as rol'])->join('rol', 'rol.rol_id', 'usuarios.rol_id')
        ->where('usuario', $_POST['user'])->exec();
        // var_dump($result[0]);
        if(count($result) == 1 && $result[0]['password'] == $_POST['pass']){
            setcookie('user_n',$result[0]['nombre'], time()+60*60);
            setcookie('user',$result[0]['rol'], time()+60*60);
            setcookie('id_t',$result[0]['usuario_id'], time()+60*60);
            setcookie('pic',$result[0]['imagen'], time()+60*60);
            $this->json(['auth' => true]);
        }else{
            $this->json(['auth' => false]);
        }
    }

    public function logout(){
        setcookie('user_n', ' ', time());
        setcookie('user', ' ', time());
        setcookie('id_t', ' ', time());
        // header('location: /login');
    }

}