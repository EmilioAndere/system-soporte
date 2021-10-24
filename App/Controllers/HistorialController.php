<?php

namespace App\Controllers;

use App\Models\Historial;
use Config\Controller;
use Config\Request;

class HistorialController extends Controller{

    public function index(){
        $historial = Historial::all();
        $this->json($historial);
    }

    public function show($id){
        $historial = Historial::find($id);
        $this->json($historial);
    }

    public function insert(Request $req){
        $historial = new Historial();
        $historial->mov_id = $req->getBody()->mov_id;
        $historial->equipo_id = $req->getBody()->equipo_id;
        $historial->save();
    }

    public function update(Request $req){
        $historial = new Historial();
        $historial->historial_id = $req->getBody()->id;
        $historial->mov_id = $req->getBody()->mov_id;
        $historial->equipo_id = $req->getBody()->equipo_id;
        $historial->save();
    }

    public function destroy($id){
        Historial::delete($id);
    }

}