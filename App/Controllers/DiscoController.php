<?php

namespace App\Controllers;

use App\Models\Disco;
use Config\Controller;

class DiscoController extends Controller{

    public function index(){
        $discos = Disco::all();
        $this->json($discos);
    }

}