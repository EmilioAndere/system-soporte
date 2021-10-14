<?php

namespace App\Controllers;

use App\Models\Equipo;
use Config\Controller;

class EquipoController extends Controller{

    public function index(){
        $equipos = new Equipo();
        $data = $equipos->select('equipos', [
            "equipos.equipo_id",
            "equipos.nombre",
            "equipos.ip_equipo as ip",
            "equipos.fecha_compra",
            "marcas.nombre as marca"
        ])->join('marcas', 'marcas.marca_id', 'equipos.marca_id')->exec();
        $this->json($data);
    }

    public function find($id){
        $equipos = new Equipo();
        $data = $equipos->select('equipos', [
            "equipos.*",
            "marcas.nombre as marca",
            "categorias.nombre as categoria",
            "ram.tipo as ram",
            "discos.tipo as disco",
            "pantalla.tamano as pantalla"
        ])
        ->join('marcas', 'marcas.marca_id', 'equipos.marca_id')
        ->join('categorias', 'categorias.categoria_id', 'equipos.categoria_id')
        ->join('ram', 'ram.ram_id', 'equipos.ram_id')
        ->join('discos', 'discos.disco_id', 'equipos.disco_id')
        ->join('pantalla', 'pantalla.pantalla_id', 'equipos.pantalla_id')
        ->where('equipo_id', $id)
        ->exec();
        echo json_encode($data);
    }

    public function add(){
        $equipo = new Equipo();
        $equipo->nombre = $_POST['name'];
        $equipo->serial = $_POST['serial'];
        $equipo->ip_equipo = $_POST['ip'];
        $equipo->licencia = 'Windows 11';
        $equipo->fecha_compra = $_POST['fecha'];
        $equipo->marca_id = $_POST['marca'];
        $equipo->categoria_id = $_POST['categoria'];
        $equipo->ram_id = $_POST['ram'];
        $equipo->disco_id = $_POST['disco'];
        $equipo->pantalla_id = $_POST['pantalla'];
        $new = $equipo->save();
        $this->json(['new_id' => $new]);
    }

    public function delete($id){
        $equipo = new Equipo();
        $rows = $equipo->delete($id);
        echo json_encode(["rows" => $rows]);
    }

    public function update($id){

        $equipo = new Equipo();
        $equipo->equipo_id = $id;
        $equipo->nombre = $_POST['name'];
        $equipo->serial = $_POST['serial'];
        $equipo->ip_equipo = $_POST['ip'];
        // $quipo->licencia = $_POST[''];
        $equipo->fecha_compra = $_POST['fecha'];
        $equipo->marca_id = $_POST['marca'];
        $equipo->categoria_id = $_POST['categoria'];
        $equipo->ram_id = $_POST['ram'];
        $equipo->disco_id = $_POST['disco'];
        $equipo->pantalla_id = $_POST['pantalla'];
        $row = $equipo->save();
        // $quipo->empleado_id = $_POST['id'];
        $this->json($row);
    }

    public function changeEmp($id){
        $equipo = new Equipo();
        $equipo->equipo_id = $id;
        if(!isset($_POST['emp_id'])){
            $equipo->empleado_id = 'NULL';
        }else{
            $equipo->empleado_id = $_POST['emp_id'];
        }
        $row = $equipo->save();
        $this->json(['affect' => $row]);
    }

    public function inStock(){
        $equipo = new Equipo();
        $equipo = $equipo->select("equipos", ["count(*) as stock"])
        ->isNull('empleado_id')->exec();
        $this->json($equipo);
    }

    public function asign(){
        $equipo = new Equipo();
        $equipo = $equipo->select("equipos", ["count(*) as stock"])
        ->isNotNull('empleado_id')->exec();
        $this->json($equipo);
    }

    public function search($val){
        $search = new Equipo();
        $result = $search->select('equipos', [
            "equipos.*",
            "marcas.nombre as marca",
            "categorias.nombre as categoria",
            "ram.tipo as ram",
            "discos.tipo as disco",
            "pantalla.tamano as pantalla"
        ])
        ->join('marcas', 'marcas.marca_id', 'equipos.marca_id')
        ->join('categorias', 'categorias.categoria_id', 'equipos.categoria_id')
        ->join('ram', 'ram.ram_id', 'equipos.ram_id')
        ->join('discos', 'discos.disco_id', 'equipos.disco_id')
        ->join('pantalla', 'pantalla.pantalla_id', 'equipos.pantalla_id')
        // ->orWhere('equipos.ip_equipo', "%$val%", 'LIKE')
        ->orWhere('equipos.nombre', "%$val%", 'LIKE')
        ->orWhere('equipos.equipo_id', "%$val%", 'LIKE')->exec();
        $this->json($result);
    }

}