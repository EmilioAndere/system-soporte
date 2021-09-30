<?php

namespace App\Controllers;

use Config\Controller;

class MarcaController extends Controller{

    public function new(){
        $lista = array('apple', 'watermelon');
        echo $this->tmp->render('marca.html', compact('lista'));
    }

}