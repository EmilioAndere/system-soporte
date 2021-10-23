<?php

namespace App\Controllers;

use App\Models\Disco;
use Config\Request;
use Config\Controller;

class DiscoController extends Controller{

    public function index(){
        $discos = Disco::all();
        $this->json($discos);
    }

    public function show($id){
        $disco = Disco::find($id);
        $this->json($disco);
    }

    public function insert(Request $req){
        $disco = new Disco();
        $disco->tipo = $req->getBody()->tipo;
        $disco->capacidad = $req->getBody()->capacidad;
        $disco->medida = $req->getBody()->medida;
        $disco->save();
    }

    public function update(Request $req){
        $disco = new Disco();
        $disco->disco_id = $req->getBody()->id;
        $disco->tipo = $req->getBody()->tipo;
        $disco->capacidad = $req->getBody()->capacidad;
        $disco->medida = $req->getBody()->medida;
        $disco->save();
    }

    public function destroy($id){
        Disco::delete($id);
    }

}