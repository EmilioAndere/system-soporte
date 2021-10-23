<?php

namespace App\Controllers;

use App\Models\Aplicacion;
use Config\Request;
use Config\Controller;

class AplicacionController extends Controller{

    public function index(){
        $aplicaciones = Aplicacion::all();
        $this->json($aplicaciones);
    }

    public function show($id){
        $aplicacion = Aplicacion::find($id);
        $this->json($aplicacion);
    }

    public function insert(Request $req){
        $aplicacion = new Aplicacion();
        $aplicacion->nombre = $req->getBody()->nombre;
        $aplicacion->version = $req->getBody()->version;
        $aplicacion->fecha_compra = $req->getBody()->compra;
        $aplicacion->save();
    }

    public function update(Request $req){
        $aplicacion = new Aplicacion();
        $aplicacion->aplicacion_id = $req->getBody()->id;
        $aplicacion->nombre = $req->getBody()->nombre;
        $aplicacion->version = $req->getBody()->version;
        $aplicacion->fecha_compra = $req->getBody()->compra;
        $aplicacion->save();
    }

    public function destroy($id){
        Aplicacion::delete($id);
    }
    
}