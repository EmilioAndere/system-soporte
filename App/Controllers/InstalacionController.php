<?php

namespace App\Controllers;

use App\Models\Installation;
use Config\Controller;
use Config\Request;

class InstalacionController extends Controller{

    public function index(){
        $instalacion = new Installation();

        $result = $instalacion->select('vista_instalacion')->exec();
        $this->json($result);
    }

    public function show($name){
        $instalacion = new Installation();
        $chair = str_replace('-', ' ', $name);
        $result = $instalacion->select('vista_instalacion')
        ->where('nombre', $chair)->exec();
        $this->json($result);
    }

    public function insert(Request $req){
        $install = new Installation();
        $install->id_eq = $req->getBody()->equipo;
        $install->id_app = $req->getBody()->app;
        $install->save();
    }

    public function destroy($id){
        Installation::delete($id);
    }

}