<?php

namespace App\Controllers;

use App\Models\Services;
use Config\Request;
use Config\Controller;

class ServicesController extends Controller{

    public function index(){
        $servicios = Services::all();
        $this->json($servicios);
    }

    public function show($id){
        $servicio = Services::find($id);
        $this->json($servicio);
    }

    public function insert(Request $req){
        $servicio = new Services();
        $servicio->descripcion = $req->getBody()->descripcion;
        $servicio->servicio = $req->getBody()->servicio;
        $servicio->prioridad = $req->getBody()->prioridad;
        $servicio->estado = $req->getBody()->estado;
        $servicio->fecha_solicitud = $req->getBody()->solicitud;
        $servicio->fecha_termino = $req->getBody()->termino;
        $servicio->equipo_id = $req->getBody()->equipo_id;
        $servicio->usuario_id = $req->getBody()->usuario_id;
        $servicio->save();
    }

    public function update(Request $req){
        $servicio = new Services();
        $servicio->servicio_id = $req->getBody()->id; 
        $servicio->descripcion = $req->getBody()->descripcion;
        $servicio->servicio = $req->getBody()->servicio;
        $servicio->prioridad = $req->getBody()->prioridad;
        $servicio->estado = $req->getBody()->estado;
        $servicio->fecha_solicitud = $req->getBody()->solicitud;
        $servicio->fecha_termino = $req->getBody()->termino;
        $servicio->equipo_id = $req->getBody()->equipo_id;
        $servicio->usuario_id = $req->getBody()->usuario_id;
        $servicio->save();
    }

    public function destroy($id){
        Services::delete($id);
    }

}