<?php

namespace App\Controllers;

use App\Models\Ram;
use Config\Controller;

class RamController extends Controller{

    public function index(){
        $rams = Ram::all(false);
        $this->json($rams);
    }

}