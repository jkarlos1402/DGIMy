<?php
 /*
 @Modulo "Autorizacion Presupuestal"
 @Control "Autorizacion"
 @versión: 0.1      
 @modificado: 21 de Octubre del 2014
 @autor: Giovanni Estrada Aleman
*/

//incluye las funciones para las autorizaciones
include '../../model/oficios/funcionesAutorizacion.php';

//Se recorren los casos solo si la informacion ha sido enviada por POST
if($_POST){    
    //se obtienen los elementos del post como variables    
    extract($_POST);    
    
    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if(isset($accion) && !empty($accion)){        
        
        $autorizaciones = new Autorizaciones();
        
        switch ($accion) {
            
            case "consultaOficio":
                //obtiene la informacion del oficio
                $data = $autorizaciones->obtenerOficio($idOficio);                
                echo json_encode($data);                
            break;
        
            case "consultaOficioClave":
                //obtiene la informacion del oficio
                $data = $autorizaciones->obtenerOficioClave($claveOficio);                
                echo json_encode($data);                
            break;
        
            case "consultaObra":
                //obtiene la informacion de la obra
                $data = $autorizaciones->obtenerObra($idObra, $ejercicio);                
                echo json_encode($data);                
            break;    
        
            case "consultaUnidadEjecutora":
                $addlike = '';
                if(!empty($like)){
                    $addlike = $like;               
                }    
                //obtiene la informacion de la obra
                $data = $autorizaciones->obtenerDep($idDep, $addlike);                                
                echo json_encode($data);                
            break; 
            
            case "UnidadEjecutoraLetra":
                $addlike = '';
                if(!empty($like)){
                    $addlike = $like;               
                }    
                //obtiene la informacion de la obra
                $data = $autorizaciones->obtenerDepLetra($Dep, $addlike);                                
                
                
                echo json_encode($data);
            break;    
            
            case "recuperarInfoGrid":
                $data = $autorizaciones->obtenerGrid($idOficio);
                echo json_encode($data);
            break;
        
            case "cargarCombos":
                //obtiene la informacion de los selects
                $data = $autorizaciones->infoSelects();                
                echo json_encode($data);                
            break;    
        
            case "guardarPDF":
                //se envia la infomracion para guardar el oficio que permita generar el pdf
                $data = $autorizaciones->guardarPdf($idOficio);
                echo json_encode($data);
            break;    
        
            case "GuardarOficio":                
                $data = $autorizaciones->guardarOficio($datos, $infOfi, $opcion);
                echo json_encode($data);
            break;    
        
            case "insertTextoFolio":
                $data = $autorizaciones->guardarTextosPdf($cveOficio, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto);                
                echo json_encode($data);
            break;    
        
            case "calcularMontos":                                                              
                $data = $autorizaciones->calcularMontos($tipo, $movimiento, $idOficio, $idObra, $ejercicio, $referencia);                                
                echo json_encode($data);
            break;    
                        
            case "actualizarOficio":
                $data = $autorizaciones->updateOficio($idOficio, $estado, $fecha, $modificable, $cp);
                echo json_encode($data);
            break;    
        
            case "cambiarInfOficio":
                $autorizaciones->cambiarInfOficio($fuente, $inversion,$recursos,$uEjecutora,$idDetOfi);                
            break;
                
            case "obtenerAps":
                $data = $autorizaciones->obtenerAps($idOficio);
                echo json_encode($data);
            break;    
        
            case "obtenerGridOfis":
                $data = $autorizaciones->obtenerGridOfis($idOficio);
                echo json_encode($data);
            break;    
        
            case "oficioReferencia":
                $data = $autorizaciones->oficioReferencia($idObr,$referencia);
                echo json_encode($data);
            break;    
        
            case "consultaOficiosReferencia":
                echo $autorizaciones->getOficioReferencia($idObra, $ejercicio, $cveOficio);                                
                
            break;    
        
            case "detalleOficiosReferencia":
                $data = $autorizaciones->detalleReferencia($idObra, $ejercicio, $idReferencia);                                
                echo json_encode($data);
            break;    
        
            case "consultaTemplateOficio":
                $data = $autorizaciones->getOficioTemplate($tipOficio, $ejercicio, $fuente, $recurso);                
                echo json_encode($data);
            break;
        
            case "guardarTemplateOficio":
                //se guarda el template del oficio
                $data = $autorizaciones->guardarOficioTemplate($tipo, $ejercicio, $fuente,  $asunto, $prefijo, $fundamento, $complemento);                
                echo json_encode($data);
            break; 
        
            default:
            break;
        }
        
    }
    
    
}
else{
    echo "Peticion Invalida";
}