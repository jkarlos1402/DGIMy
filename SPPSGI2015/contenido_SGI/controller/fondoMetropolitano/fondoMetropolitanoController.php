<?php

include '../../model/fondoMetropolitano/funcionesFondoMetropolitano.php';


if ($_POST) {
    
    //se obtienen los elementos del post como variables    
    extract($_POST);
   
    if (isset($accion) && !empty($accion)) {
        
        $insFM = new FondoMetropolitano();

        switch ($accion) {            
            
            case "comboEjercicio":                
                $data = json_encode($insFM->getEjercicios());
                echo $data;
                break;  
            
            case "comboFuente":
                $data = json_encode($insFM->getFuentes());
                echo $data;
                break;  
            
            case "comboSector":
                $data = json_encode($insFM->getSectores());
                echo $data;
                break;
            
            case "comboGrupoSocial":
                $data = json_encode($insFM->getGrupoSocial());
                echo $data;
                break;            
            
            case "comboUE":
                $data = json_encode($insFM->getUE($idSector));
                echo $data;
                break;
            
            case "comboTipOficio":                
                $data = json_encode($insFM->getTipOfi());
                echo $data;
                break;
            
            case "comboSesion":
                if(!isset($ejercicio)){
                    $ejercicio=0;
                }
                $data = json_encode($insFM->getSesion($ejercicio));
                echo $data;
                break;
            
            case "guardaSesion":                
                $data = json_encode($insFM->guardarSesion($ejercicio, $fecha, $sesion));
                echo $data;                
                break;
            
            case "infoGridSesiones":
                $data = json_encode($insFM->gridSesiones($ejercicio));
                echo $data;
                break;
            
            case "borrarSesion":
                $data = json_encode($insFM->borrarSesion($idSesion));
                echo $data;
                break;
            
            case "guardarDatos":
                $data = json_encode($insFM->guardarDatos($datos));
                echo $data;
                break;                                
            
            case "getInfopFonMet":
                $data = json_encode($insFM->getInfopFonMet($cvePry));                
                echo $data;
                break;                        
            
            case "guardarNuevoEjercicio":
                $data = json_encode($insFM->guardarNuevoEjercicio($datos));
                echo $data;
                break;
            
            case "getDetalleFonMet":
                $data = json_encode($insFM->getDetalleFonMet($cvePry, $ejercicio));
                echo $data;
                break;
            case "guardarModificarDatos":
                $data = json_encode($insFM->guardarModificarDatos($datos));
                echo $data;
                break;
            
            case "guardarPlantilla":                
                $data = json_encode($insFM->guardarPlantilla($ejercicio, $fuente, $tipOfi, $texto));
                echo $data;
                break;
            
            case "listaProyectosEjercicio":
                $insFM->listaProyectosEjercicio($ejercicio, $fuente, $ue);
                break;
            
            case "guardarDepositos":
                $insFM->guardarDepositos($idDetFon, $datos);                
                break;
            
            case "getDepositosDet":                
                $data = json_encode($insFM->getDepositos($idDetFon));                
                echo $data;
                break;
            
            case "cargarPlantillaOficio":
                $data = json_encode($insFM->getPlantillaOficio($ejercicio, $fuente, $tipOfi));
                echo $data;
                break;
            
            case "guardarOficio":
                $data = json_encode($insFM->guardarOficio($datosOfi, $datos));
                echo $data;
                break;
            
            case "cargarTitularCopias":
                $data = json_encode($insFM->getTitularCopias($ue, $sector));
                echo $data;
                break;
            
        }   
    }
}
?>
