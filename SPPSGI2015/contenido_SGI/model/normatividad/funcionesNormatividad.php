<?php

session_start();
include_once '../../libs/ChromePhp.php';
include_once 'funcionesNormatividadModel.php';

class Normatividad {

    var $instanciaNormaModel;

    function __construct() {
        $this->instanciaNormaModel = new NormatividadModel();
    }

    public function consultasNormas() {
        return $this->instanciaNormaModel->consultarNormas();
    }
}