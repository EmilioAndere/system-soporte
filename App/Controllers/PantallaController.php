<?php

namespace App\Controllers;

use App\Models\Pantalla;
use Config\Request;
use Config\Controller;

class PantallaController extends Controller{

    public function index(){
        $pantallas = Pantalla::all(false);
        $this->json($pantallas);
    }

    public function show($id){
        $pantalla = Pantalla::find($id);
        $this->json($pantalla);
    }

    public function insert(Request $req){
        $pantalla = new Pantalla();
        $pantalla->tipo = $req->getBody()->tipo;
        $pantalla->capacidad = $req->getBody()->capacidad;
        $pantalla->save();
    }

    public function update(Request $req){
        $pantalla = new Pantalla();
        $pantalla->pantalla_id = $req->getBody()->id;
        $pantalla->tipo = $req->getBody()->tipo;
        $pantalla->tamano = $req->getBody()->tamano;
        $pantalla->save();
    }

    public function destroy($id){
        Pantalla::delete($id);
    }
}