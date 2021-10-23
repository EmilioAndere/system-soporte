<?php

namespace App\Controllers;

use App\Models\Ubicacion;
use Config\Request;
use Config\Controller;

class UbicacionController extends Controller{

    public function index(){
        $ubicaciones = Ubicacion::all();
        $this->json($ubicaciones);
    }

    public function show($id){
        $ubicacion = Ubicacion::find($id);
        $this->json($ubicacion);
    }

    public function insert(Request $req){
        $ubicacion = new Ubicacion();
        $ubicacion->nombre = $req->getBody()->nombre;
        $ubicacion->save();
    }

    public function update(Request $req){
        $ubicacion = new Ubicacion();
        $ubicacion->ubicacion_id = $req->getBody()->id;
        $ubicacion->nombre = $req->getBody()->nombre;
        $ubicacion->save();
    }

    public function destroy($id){
        Ubicacion::delete($id);
    }

}