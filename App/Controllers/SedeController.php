<?php

namespace App\Controllers;

use App\Models\Sede;
use Config\Controller;

class SedeController extends Controller{

    public function index(){
        $sedes = Sede::all(false);
        $this->json($sedes);
    }

    public function find($id){
        $sede = new Sede();
        $sede = $sede->select('sede')
        ->where('sede_id', $id)->exec();
        $this->json($sede);
    }

}