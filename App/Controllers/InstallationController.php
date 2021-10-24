<?php

namespace App\Controllers;

use App\Models\Installation;
use Config\Controller;
use Config\Request;

class InstallationController extends Controller{

    public function index(){
        $installations = Installation::all();
        $this->json($installations);
    }

    public function show($id){
        $installation = Installation::find($id);
        $this->json($installation);
    }

    public function insert(Request $req){
        $ins = new Installation();
        $ins->fecha_instalacion = $req->getBody()->instalacion;
        $ins->aplicacion_id = $req->getBody()->aplicacion_id;
        $ins->equipo_id = $req->getBody()->equipo_id;
        $ins->save();
    }

    public function update(Request $req){
        $ins = new Installation();
        $ins->instalacion_id = $req->getBody()->id;
        $ins->fecha_instalacion = $req->getBody()->instalacion;
        $ins->aplicacion_id = $req->getBody()->aplicacion_id;
        $ins->equipo_id = $req->getBody()->equipo_id;
        $ins->save();
    }

    public function destroy($id){
        Installation::delete($id);
    }

}