<?php

namespace App\Controllers;

use Config\Controller;
use Config\Request;
use App\Models\Archivo;

class ArchivoController extends Controller{

    public function index(){
        $files = Archivo::all();
        $this->json($files);
    }

    public function show($id){
        $file = Archivo::find($id);
        $this->json($file);
    }

    public function insert(Request $req){
        $file = new Archivo();
        $file->nombre = $req->getBody()->nombre;
        $file->link = $req->getBody()->link;
        $file->num_descarga = $req->getBody()->descargas;
        $file->save();
    }

    public function update(Request $req){
        $file = new Archivo();
        $file->archivo_id = $req->getBody()->id;
        $file->nombre = $req->getBody()->nombre;
        $file->link = $req->getBody()->link;
        $file->num_descarga = $req->getBody()->descargas;
        $file->save();
    }

    public function destroy($id){
        Archivo::delete($id);
    }

}