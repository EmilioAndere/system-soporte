<?php

namespace App\Controllers;

use Config\Controller;

class DeviceController extends Controller{

    public function index(){
        $uri = $this->uri;
        echo $this->tmp->render('pages/devices/device.twig', compact('uri'));
    }

}