<?php

namespace App\Controllers;

use Config\Controller;
use Config\Request;
use App\Models\Rol;

class RolController extends Controller{

    public function index(){
        $rol = Rol::all();
        $this->json($rol);        
    }

    public function show($id){
        $rol = Rol::find($id);
        $this->json($rol);
    }

    public function insert(Request $req){
        $rol = new Rol();
        $rol->nombre = $req->getBody()->nombre;
        $rol->save();
    }

    public function update(Request $req){
        $rol = new Rol();
        $rol->rol_id = $req->getBody()->id;
        $rol->nombre = $req->getBody()->nombre;
        $rol->save();
    }

    public function destroy($id){
        $rol = Rol::delete($id);
        $this->json($rol);
    }

}