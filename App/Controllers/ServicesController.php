<?php

namespace App\Controllers;

use App\Models\Services;
use Config\Controller;
use DateTime;

class ServicesController extends Controller{

    public function index(){
        $servicios = new Services();
        $services = $servicios->select('servicio_equipo', ['servicio_equipo.*', 'usuarios.nombre as usuario'])
        ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id')->exec();

        $abierto = $servicios->select('servicio_equipo', ['count(*) as abierto'])->where('estado', 'Abierto')->exec();
        $espera = $servicios->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera')->exec();
        $notAsign = $servicios->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id')->exec();
        $important = $servicios->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta')->exec();

        $uri = $this->uri;
        echo $this->tmp->render('/pages/services.twig', compact('uri', 'services', 'abierto', 'espera', 'notAsign', 'important'));
    }

    public function service($id){
        $servicio = new Services();
        $service = $servicio->select('servicio_equipo', [
            'servicio_equipo.*',
            'equipos.nombre as equipo',
            'usuarios.nombre as usuario'
        ])
        ->join('equipos', 'equipos.equipo_id', 'servicio_equipo.equipo_id')
        ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id')
        ->where('servicio_id', $id)->exec();
        $services = $servicio->select('servicio_equipo', ['servicio_equipo.*', 'usuarios.nombre as usuario'])
        ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id')->exec();
        $uri = $this->uri;

        $abierto = $servicio->select('servicio_equipo', ['count(*) as abierto'])->where('estado', 'Abierto')->exec();
        $espera = $servicio->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera')->exec();
        $notAsign = $servicio->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id')->exec();
        $important = $servicio->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta')->isNull('fecha_termino')->exec();

        $date = new DateTime();
        $solicitud = new DateTime($service[0]['fecha_solicitud']);
        $diff = $solicitud->diff($date);
        if($diff->days != 0){
            $dias = $diff->days." Dias.";
        }else{
            $dias = $diff->h." Horas.";
        }
        echo $this->tmp->render('/pages/services.twig', compact('uri', 'service', 'services', 'dias', 'abierto', 'espera', 'notAsign', 'important'));
        
    }

    public function changeState($id){
        $servicio = new Services();
        $servicio->servicio_id = $id;
        $servicio->estado = $_POST['estado'];
        if($_POST['estado'] === 'Cerrado'){
            $servicio->fecha_termino = $_POST['fin'];
        }
        $servicio->save();
    }

    public function changeUser($id){
        $service = new Services();
        $service->servicio_id = $id;
        $service->usuario_id = $_POST['user'];
        $service->save();
    }

    public function filter($estado, $prioridad){
        $servicios = new Services();
        $serv = $servicios->select('servicio_equipo', ['servicio_equipo.*', 'usuarios.nombre as usuario'])
        ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id');

        if($estado != 'all'){
            $serv = $serv->where('servicio_equipo.estado', $estado);
        }

        if($prioridad != 'all'){
            $serv = $serv->where('servicio_equipo.prioridad', $prioridad);
        }

        $services = $serv->exec();

        $abierto = $servicios->select('servicio_equipo', ['count(*) as abierto'])->where('estado', 'Abierto')->exec();
        $espera = $servicios->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera')->exec();
        $notAsign = $servicios->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id')->exec();
        $important = $servicios->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta')->exec();

        $uri = $this->uri;
        echo $this->tmp->render('/pages/services.twig', compact('uri', 'services', 'abierto', 'espera', 'notAsign', 'important'));
    }

    public function add(){
        $servicio = new Services();
        $servicio->descripcion = $_POST['descripcion'];
        $servicio->servicio = $_POST['servicio'];
        $servicio->prioridad = $_POST['prioridad'];
        $servicio->estado = $_POST['estado'];
        $servicio->fecha_solicitud = $_POST['fecha'];
        $servicio->equipo_id = $_POST['equipo'];
        $servicio->usuario_id = $_POST['user'];
        $servicio->save();
    }
}