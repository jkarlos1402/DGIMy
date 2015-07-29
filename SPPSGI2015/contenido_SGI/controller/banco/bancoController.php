<?php

include_once '../../libs/ChromePhp.php';
include '../../model/banco/funcionesBanco.php';


if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {
        
        $insBanco = new Banco();                

        switch ($accion) {            
            
            case "consultaInfoBanco":
                $data = json_encode($insBanco->getInfoBcoSol($rolUsu,$idUsu));                
                echo $data;
                break;
            case "guardarStatus":
                $data = json_encode($insBanco->guardarStatusBanco($_POST));                    
                echo $data;
                break;
            case "obtenerInfoBcoSol":                
                $data = json_encode($insBanco->obtenerInfoSol($idBco, '3'));
                echo $data;
                break;
            case "cargarCombos":
                $data = json_encode($insBanco->obtenerCombos());
                echo $data;
                break;
            case "cargarTipEva":
                $insBanco->obtenerTipEva($idTipEva);                    
                break;
            
            case "guardarEvaluacion":                
                $obs=(isset($observaciones)?$observaciones:array());
                echo json_encode($insBanco->guardarEvaluacion($datos,$obs,$generales));                
                break;
            
            case "revisaBloqueo":
                echo json_encode($insBanco->revisaBloqueo($_POST));
                break;
            
            case "consultaestsol":
                $historicoES = $insBanco->consultaEstSol($idSol);                
                echo json_encode($historicoES);
                break;
            
            case "consultadeteva":
                $obsPart = $insBanco->consultaDetEva($idEva);              
                echo json_encode($obsPart);
                break;
        }
    }
}
?>
