<?php

include_once '../../libs/ChromePhp.php';
include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class NormatividadModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }

    public function consultarNormas() {
        global $cnx;
        $query = "SELECT Nombre, Descripcion, Archivo FROM normatividad";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["Nombre"] = utf8_encode($rs->fields["Nombre"]);
            $rs->fields["Descripcion"] = utf8_encode($rs->fields["Descripcion"]);
            $rs->fields["Archivo"] = utf8_encode($rs->fields["Archivo"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
}
