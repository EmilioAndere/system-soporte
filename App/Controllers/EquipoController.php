<?php

namespace App\Controllers;

use App\Models\Equipo;
use Config\Request;
use Config\Controller;

class EquipoController extends Controller{

    public function index(){
        $equipos = Equipo::all();
        $this->json($equipos);
    }

    public function show($id){
        $equipo = Equipo::find($id);
        $this->json($equipo);
    }

    public function insert(Request $req){
        $equipo = new Equipo();
        $equipo->nombre = $req->getBody()->nombre;
        $equipo->serial = $req->getBody()->serial;
        $equipo->ip_equipo = $req->getBody()->ip_equipo;
        $equipo->licencia = $req->getBody()->licencia;
        $equipo->fecha_compra = $req->getBody()->fecha_compra;
        $equipo->marca_id = $req->getBody()->marca_id;
        $equipo->categoria_id = $req->getBody()->categoria_id;
        $equipo->ram_id = $this->exist($req->getBody()->ram_id);
        $equipo->disco_id = $this->exist($req->getBody()->disco_id);
        $equipo->pantalla_id = $this->exist($req->getBody()->pantalla_id);
        $equipo->empleado_id = $this->exist($req->getBody()->empleado_id);
    }

    public function update(Request $req){
        $equipo = new Equipo();
        $equipo->equipo_id = $req->getBody()->id;
        $equipo->nombre = $req->getBody()->nombre;
        $equipo->serial = $req->getBody()->serial;
        $equipo->ip_equipo = $req->getBody()->ip_equipo;
        $equipo->licencia = $req->getBody()->licencia;
        $equipo->fecha_compra = $req->getBody()->fecha_compra;
        $equipo->marca_id = $req->getBody()->marca_id;
        $equipo->categoria_id = $req->getBody()->categoria_id;
        $equipo->ram_id = $this->exist($req->getBody()->ram_id);
        $equipo->disco_id = $this->exist($req->getBody()->disco_id);
        $equipo->pantalla_id = $this->exist($req->getBody()->pantalla_id);
        $equipo->empleado_id = $this->exist($req->getBody()->empleado_id);
    }

    public function destroy($id){
        Equipo::delete($id);
    }

}