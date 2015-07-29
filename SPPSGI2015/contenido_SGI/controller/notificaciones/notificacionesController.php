<?php

include '../../model/notificaciones/notificacionesModel.php';

if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {
        $notificacion = new NotificacionesModel();
        switch ($accion) {
            case "getNotificaciones":                
                $notificaciones = $notificacion->getNotificacionesByIdUsu($idUsu);
                for ($i = 0; $i < count($notificaciones); $i++) {
                    $notificaciones[$i]["accion"] = "<input type='checkbox' onclick='cambiaEstatusNotificacion(this,".$notificaciones[$i]["idnotificacion"].");'/>";
                    $notificaciones[$i][4] = "<input type='checkbox' onclick='cambiaEstatusNotificacion(this,".$notificaciones[$i]["idnotificacion"].");'/>";
                }
                echo json_encode($notificaciones);
                break;
        }
    }
}
