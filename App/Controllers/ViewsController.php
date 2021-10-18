<?php

namespace App\Controllers;

use App\Models\Services;
use Config\Controller;

class ViewsController extends Controller{

    public function dash(){
        $uri = $this->uri;
        echo $this->tmp->render('dash.twig', compact('uri'));
    }

    public function devices(){
        $uri = $this->uri;
        echo $this->tmp->render('/pages/device.twig', compact('uri'));
    }

    public function services(){
        
    }

}