<?php

namespace App\Controllers;

use App\Models\Sede;
use Config\Request;
use Config\Controller;

class SedeController extends Controller{

    public function index(){
        $sedes = Sede::all(false);
        $this->json($sedes);
    }

    public function show($id){
        $sede = Sede::find($id);
        $this->json($sede);
    }

    public function insert(Request $req){
        $sede = new Sede();
        $sede->nombre = $req->getBody()->nombre;
        $sede->save();
    }

    public function update(Request $req){
        $sede = new Sede();
        $sede->sede_id = $req->getBody()->id;
        $sede->nombre = $req->getBody()->nombre;
        $sede->save();
    }

    public function destroy($id){
        Sede::delete($id);
    }

}