<?php

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class NotificacionesModel {

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }
    
    function getNotificacionesByIdUsu($idUsu){
        global $cnx;
        $query = "SELECT idnotificacion,DATE_FORMAT(fechaNotificacion, '%d-%m-%Y') fechaNotificacion,mensaje,DATE_FORMAT(vigencia, '%d-%m-%Y') vigencia FROM notificacion WHERE idUsu = '$idUsu' AND leido = 0 ORDER BY idnotificacion DESC";        
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['mensaje'] = utf8_encode($rs->fields['mensaje']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
}
    