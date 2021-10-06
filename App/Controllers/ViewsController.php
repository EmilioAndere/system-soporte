<?php

namespace App\Controllers;

use Config\Controller;

class ViewsController extends Controller{

    public function dash(){
        $uri = $this->uri;
        echo $this->tmp->render('dash.twig', compact('uri'));
    }

}