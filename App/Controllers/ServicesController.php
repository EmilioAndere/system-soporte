<?php

namespace App\Controllers;

use App\Models\Services;
use Config\Controller;
use DateTime;

class ServicesController extends Controller{

    public function index(){
        if($this->logged()){
            $servicios = new Services();
            $services = $this->isAdmin($servicios->select('servicio_equipo', ['servicio_equipo.*', 'usuarios.nombre as usuario'])
            ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id'));
    
            $abierto = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as abierto'])->where('servicio_equipo.estado', 'Abierto'));
            $espera = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera'));
            $notAsign = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id'));
            $important = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta'));
            $uri = $this->uri;

            echo $this->tmp->render('/pages/services.twig', compact('uri', 'services', 'abierto', 'espera', 'notAsign', 'important'));
        }else{
            header('location: /login');
        }
    }

    public function service($id){
        if($this->logged()){
            $servicio = new Services();
            $service = $servicio->select('servicio_equipo', [
                'servicio_equipo.*',
                'equipos.nombre as equipo',
                'usuarios.nombre as usuario'
            ])
            ->join('equipos', 'equipos.equipo_id', 'servicio_equipo.equipo_id')
            ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id')
            ->where('servicio_id', $id)->exec();
            
            $services = $this->isAdmin($servicio->select('servicio_equipo', ['servicio_equipo.*', 'usuarios.nombre as usuario'])
            ->leftJoin('usuarios', 'usuarios.usuario_id', 'servicio_equipo.usuario_id'));


            $abierto = $this->isAdmin($servicio->select('servicio_equipo', ['count(*) as abierto'])->where('estado', 'Abierto'));
            $espera = $this->isAdmin($servicio->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera'));
            $notAsign = $this->isAdmin($servicio->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id'));
            $important = $this->isAdmin($servicio->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta')->isNull('fecha_termino'));
            $uri = $this->uri;

            $date = new DateTime();
            $solicitud = new DateTime($service[0]['fecha_solicitud']);
            $diff = $solicitud->diff($date);
            if($diff->days != 0){
                $dias = $diff->days." Dias.";
            }else{
                $dias = $diff->h." Horas.";
            }
            echo $this->tmp->render('/pages/services.twig', compact('uri', 'service', 'services', 'dias', 'abierto', 'espera', 'notAsign', 'important'));
        }else{
            $this->redirect('/login');
        }
        
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

    public function openService($id){
        $service = new Services();
        $service->servicio_id = $id;
        $service->estado = 'Abierto';
        $service->fecha_termino = 'NULL';
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

        $services = $this->isAdmin($serv);

        $abierto = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as abierto'])->where('estado', 'Abierto'));
        $espera = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as espera'])->where('estado', 'Espera'));
        $notAsign = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as total'])->isNull('usuario_id'));
        $important = $this->isAdmin($servicios->select('servicio_equipo', ['count(*) as important'])->where('prioridad', 'Alta'));

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
        $servicio->usuario_id = ($_COOKIE['user'] == 'Administrador') ? $_POST['user'] : $_COOKIE['id_t'];
        $servicio->save();
    }

    public function grafs(){
        $services = new Services();
        $news = $this->isAdmin($services->select('servicio_equipo', ['count(*) as total'])->where('fecha_solicitud', date('Y-m-d')));
        $pend = $this->isAdmin($services->select('servicio_equipo', ['count(*) as total'])->where('estado', 'Espera'));
        // $grafCase = array(]);

        $this->json(['nuevos' => $news[0]['total'], 'pendient' => $pend[0]['total']]);
    }

    public function grafPrior(){
        $services = new Services();
        $low = $this->isAdmin($services->select('servicio_equipo', ['count(*) as total'])
        ->where('prioridad', 'Baja')
        ->where('fecha_solicitud', date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-30", 'BETWEEN'));
        $med = $this->isAdmin($services->select('servicio_equipo', ['count(*) as total'])
        ->where('prioridad', 'Media')
        ->where('fecha_solicitud', date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-30", 'BETWEEN'));
        $high = $this->isAdmin($services->select('servicio_equipo', ['count(*) as total'])
        ->where('prioridad', 'Alta')
        ->where('fecha_solicitud', date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-30", 'BETWEEN'));
        // echo $low;
        $this->json(['low' => $low[0]['total'], 'med' => $med[0]['total'], 'high' => $high[0]['total'], 'mes' => date('F')]);
    }
}