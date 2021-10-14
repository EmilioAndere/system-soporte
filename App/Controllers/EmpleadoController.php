<?php

namespace App\Controllers;

use App\Models\Empleado;
use Config\Controller;

class EmpleadoController extends Controller{

    public function index(){
        $empleados = Empleado::all();
        $this->json($empleados);
    }

    public function find($id){
        $empleado = new Empleado();
        $empleado = $empleado->select('empleados')
        ->where('empleado_id', $id)->exec();
        $this->json($empleado);
    }

    public function search($val){
        $search = new Empleado();
        $result = $search->select('empleados', ['empleado_id', 'nombre', 'puesto'])
        ->orWhere('nombre', "%$val%", 'LIKE')
        ->orWhere('puesto', "%$val%", 'LIKE')
        ->orWhere('empleado_id', "%$val%", 'LIKE')->exec();
        $this->json($result);
    }
 
}