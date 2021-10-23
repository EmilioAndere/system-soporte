<?php

namespace App\Controllers;

use App\Models\Categoria;
use Config\Controller;
use Config\Request;

class CategoriaController extends Controller{

    public function index(){
        $categorias = Categoria::all();
        $this->json($categorias);
    }

    public function show($id){
        $categoria = Categoria::find($id);
        $this->json($categoria);
    }

    public function insert(Request $req){
        $categoria = new Categoria();
        $categoria->nombre = $req->getBody()->nombre;
        $categoria->save();
    }

    public function update(Request $req){
        $categoria = new Categoria();
        $categoria->categoria_id = $req->getBody()->id;
        $categoria->nombre = $req->getBody()->nombre;
        $categoria->save();
    }

    public function destroy($id){
        Categoria::delete($id);
    }

}