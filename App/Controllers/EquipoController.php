<?php

namespace App\Controllers;

use App\Models\Equipo;
use Config\Request;
use Config\Controller;

class EquipoController extends Controller{

    public function index(){
        $equipos = new Equipo();
        $results = $equipos->select('equipos', [
            'equipos.num_serie',
            'equipos.compra',
            'concat("Est. ", equipos.estacion) as estacion',
            'equipos.especificaciones',
            'equipos.tipo as tipo',
            'sede.nombre as sede'
        ])
        ->join('sede', 'equipos.id_sede', 'sede.ID')->exec();
        $this->json($results);
    }

    public function all(){
        $equipos = Equipo::all();
        $this->json($equipos);
    }

    public function show($val, $param = null){
        if(is_null($param)){
            $equipo = Equipo::find($val);
            $this->json($equipo);
        }else{
            $equipo = new Equipo();
            $result = $equipo->select('equipos')->where($param, $val)->exec();
            $this->json($result);
        }
    }

    public function insert(Request $req){
        $equipo = new Equipo();
        $equipo->num_serie = $req->getBody()->serial;
        $equipo->compra = $req->getBody()->compra;
        $equipo->estacion = $req->getBody()->estacion;
        $equipo->especificaciones = $req->getBody()->especificaciones;
        $equipo->tipo = $req->getBody()->tipo;
        $equipo->id_sede = $req->getBody()->sede;
        $equipo->save();
    }

    public function update(Request $req){
        $equipo = new Equipo();
        $equipo->ID = $req->getBody()->id;
        $equipo->num_serie = $req->getBody()->serial;
        $equipo->compra = $req->getBody()->compra;
        $equipo->estacion = $req->getBody()->estacion;
        $equipo->especificaciones = $req->getBody()->especificaciones;
        $equipo->tipo = $req->getBody()->tipo;
        $equipo->id_sede = $req->getBody()->sede;
        $equipo->save();
    }

    public function destroy($id){
        Equipo::delete($id);
    }

}