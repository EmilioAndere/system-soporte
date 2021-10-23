<?php

namespace App\Controllers;

use App\Models\Ram;
use Config\Controller;
use Config\Request;

class RamController extends Controller{

    public function index(){
        $rams = Ram::all(false);
        $this->json($rams);
    }

    public function show($id){
        $ram = Ram::find($id);
        $this->json($ram);
    }

    public function insert(Request $req){
        $ram = new Ram();
        $ram->tipo = $req->getBody()->tipo;
        $ram->capacidad = $req->getBody()->capacidad;
        $ram->medida = $req->getBody()->medida;
        $ram->save();
    }

    public function update(Request $req){
        $ram = new Ram();
        $ram->ram_id = $req->getBody()->id;
        $ram->tipo = $req->getBody()->tipo;
        $ram->capacidad = $req->getBody()->capacidad;
        $ram->medida = $req->getBody()->medida;
        $ram->save();
    }

    public function destroy($id){
        Ram::delete($id);
    }

}