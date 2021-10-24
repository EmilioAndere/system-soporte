<?php

namespace App\Controllers;

use App\Models\Movements;
use Config\Request;
use Config\Controller;

class MovementsController extends Controller{

    public function index(){
        $movements = Movements::all();
        $this->json($movements);
    }

    public function show($id){
        $move = Movements::find($id);
        $this->json($move);
    }

    public function insert(Request $req){
        $move = new Movements();
        $move->fecha_movimiento = $req->getBody()->movimiento;
        $move->equipo_id = $req->getBody()->equipo_id;
        $move->ubicacion_id = $req->getBody()->ubicacion;
        $move->sede_id = $req->getBody()->sede; 
    }

    public function update(Request $req){
        $move = new Movements();
        $move->mov_id = $req->getBody()->id;
        $move->fecha_movimiento = $req->getBody()->movimiento;
        $move->equipo_id = $req->getBody()->equipo_id;
        $move->ubicacion_id = $req->getBody()->ubicacion;
        $move->sede_id = $req->getBody()->sede; 
    }

    public function destroy($id){
        Movements::delete($id);
    }

}