<?php

namespace App\Controllers;

use App\Models\Services;
use Config\Controller;
use DateTime;

class ViewsController extends Controller{

    public function dash(){
        if($this->logged()){
            $service = new Services();
            $ticket = $this->isAdmin($service->select('servicio_equipo', ['count(*) as total']))[0]['total'];
            $empleado = $service->select('empleados', ['count(*) as total'])->exec()[0]['total'];
            $equipos = $service->select('equipos', ['count(*) as total'])->exec()[0]['total'];
            $apps = $service->select('aplicaciones', ['count(*) as total'])->exec()[0]['total'];
            $uri = $this->uri;
            echo $this->tmp->render('dash.twig', compact('uri', 'ticket', 'empleado', 'equipos', 'apps'));
        }else{
            $this->redirect('/login');
        }
    }

    public function devices(){
        $uri = $this->uri;
        $user = $_COOKIE['user_n'];
        $rol = $_COOKIE['user'];
        echo $this->tmp->render('/pages/device.twig', compact('uri'));
    }

    public function logIn(){
        if(isset($_COOKIE['user_n'])){
            header('location: /');
        }else{
            echo $this->tmp->render('/pages/login.twig', ['log' => true]);
        }
    }

}