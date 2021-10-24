<?php

namespace App\Controllers;

use App\Models\Empleado;
use Config\Controller;
use Config\Request;

class EmpleadoController extends Controller{

    public function index(){
        $empleados = Empleado::all();
        $this->json($empleados);
    }

    public function show($id){
        $empleado = Empleado::find($id);
        $this->json($empleado);
    }

    public function insert(Request $req){
        $empleado = new Empleado();
        $empleado->nombre = $req->getBody()->nombre;
        $empleado->telefono = $req->getBody()->telefono;
        $empleado->mail = $req->getBody()->mail;
        $empleado->puesto = $req->getBody()->puesto;
        $empleado->imagen = $req->getBody()->imagen;
        $empleado->ubicacion_id = $req->getBody()->ubicacion_id;
        $empleado->sede_id = $req->getBody()->sede_id;
        $empleado->save();
    }

    public function update(Request $req){
        $empleado = new Empleado();
        $empleado->empleado_id = $req->getBody()->id;
        $empleado->nombre = $req->getBody()->nombre;
        $empleado->telefono = $req->getBody()->telefono;
        $empleado->mail = $req->getBody()->mail;
        $empleado->puesto = $req->getBody()->puesto;
        $empleado->imagen = $req->getBody()->imagen;
        $empleado->ubicacion_id = $req->getBody()->ubicacion_id;
        $empleado->sede_id = $req->getBody()->sede_id;
        $empleado->save();
    }

    public function destroy($id){
        Empleado::delete($id);
    }
 
}