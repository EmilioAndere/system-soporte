<?php

namespace App\Controllers;

use App\Models\Ubicacion;
use Config\Controller;

class UbicacionController extends Controller{

    public function find($id){
        $ubicacion = new Ubicacion();
        $ubicacion = $ubicacion->select('ubicacion')
        ->where('ubicacion_id', $id)->exec();
        $this->json($ubicacion);
    }

}