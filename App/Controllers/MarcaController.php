<?php

namespace App\Controllers;

use App\Models\Marca;
use Config\Controller;
use Config\Request;

class MarcaController extends Controller{

    public function index(){
        $marcas = Marca::all();
        $this->json($marcas);
    }

    public function show($id){
        $marca = Marca::find($id);
        $this->json($marca);
    }

    public function insert(Request $req){
        $marca = new Marca();
        $marca->nombre = $req->getBody()->nombre;
        $marca->save();
    }

    public function update(Request $req){
        $marca = new Marca();
        $marca->marca_id = $req->getBody()->id;
        $marca->nombre = $req->getBody()->nombre;
        $marca->save();
    }

    public function destroy($id){
        Marca::delete($id);
    }

}