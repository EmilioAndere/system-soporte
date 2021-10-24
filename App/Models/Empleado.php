<?php

namespace App\Models;

use Config\Model;

class Empleado extends Model{
    
    protected $table = "empleados";
    protected $primary = "empleado_id";

}