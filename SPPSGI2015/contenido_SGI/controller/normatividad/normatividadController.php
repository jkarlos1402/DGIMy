<?php

include_once '../../libs/ChromePhp.php';
include '../../model/normatividad/funcionesNormatividad.php';

if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {

        $normatividad = new Normatividad();

        switch ($accion) {
            //Consultas normas
            case "consultasNormas":
                $data = $normatividad->consultasNormas();
                echo json_encode($data);
                break;
        }
    }
}
?>
