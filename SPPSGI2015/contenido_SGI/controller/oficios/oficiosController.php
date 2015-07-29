<?php

include '../../model/oficios/funcionesOficios.php';


if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {
        
        $insOficios = new Oficios();

        switch ($accion) {            
            
            case "getInfoSol":
                $data = json_encode($insOficios->getInfoSol($idSol));
                echo $data;
                break;           
            case "getInfoSolFtes":
                echo $insOficios->getInfoSolFtes($idSol);
                break;
            
            case "obtenerSolObra":
                echo json_encode($insOficios->getSolObra($idObra));                
                break;
            
            case "getHistoricoSolicitudes":
                
                echo $insOficios->getHistSol($idObra,$idSol);                
                break;
            
            case "guardarOficio":
                $res = $insOficios->guardarOficio($idSol, $idFte, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idObr, $ejercicio, $tipImpOfi);
                echo json_encode($res);
                break;
            
            case "obtenerInfoOfi":
                echo json_encode($insOficios->getInfoOficio($cveOfi));
                break;
            
            case "guardarFechaFirma":
                echo json_encode($insOficios->guardarFechaFirma($fechaFirma, $cveOfi));
                break;
            case "guardarStatus":
                echo json_encode($insOficios->guardarstatusOficio($idEdoOfi, $cveOfi,$tipoSol));
                break;
            
            case "getListadoOficios":
//                echo $insOficios->getListadoOficios($fecIni, $fecFin);
                echo json_encode($insOficios->getListadoOficios($fecIni, $fecFin));
                break;
            
            case "loadTemplate":
                echo json_encode($insOficios->loadTemplate($ejercicio, $idSol, $idFte));
                
                break;
            
            case "combosOficios":                
                echo json_encode($insOficios->loadCombos());
                break;
            
            case "seleccionarObra":
                echo json_encode($insOficios->buscarObra($ejercicio, $tipSol, $numObr));
                
                break;
            
            case "getInfoObra":
                echo json_encode($insOficios->getInfoObra($idObr));
                break;
            
            case "guardarOficioMultObras":                   
                echo json_encode($insOficios->guardarOficioMulObr($titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idSolPre, $ejercicio, $tipImpOfi, $obras));
                break;
            
            case "comboFtesOficio":
                //echo $insOficios->getComboFtes($fuentes);
                echo json_encode($insOficios->getComboFtes($fuentes));                                
                break;
                
            
        }   
    }
}
?>
