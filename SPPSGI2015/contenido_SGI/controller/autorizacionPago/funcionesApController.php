<?php

session_start();
/*
  @Modulo "Aplicacion"
  @Control "Aplicacion"
  @versiï¿½n: 0.1
  @modificado: 23 de Octubre del 2014
  @autor: Regino Tabares
 */

//incluye las funciones para las autorizaciones
include_once '../../libs/ChromePhp.php';
include '../../model/autorizacionPago/funcionesAp.php';

//Se recorren los casos solo si la informacion ha sido enviada por POST
if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {

        $aplicacion = new Aplicaciones();
//        ChromePhp::log($accion);
        switch ($accion) {
            case "getApById":
                $data = $aplicacion->getApById($CveAps);
                echo json_encode($data);
                break;

            case "getCombos":
                $dataCombos = array();
                $data['Ejercicio'] = $aplicacion->getEjercicio();
                $data['Movimientos'] = $aplicacion->getMoviento();
                $data['ue'] = $aplicacion->getUE($_SESSION["IDUE"]);

//                $comboEjercicio = "<option value='-1'>Seleccionar...</option>";
                foreach ($data['Ejercicio'] as $value) {
                    $comboEjercicio.="<option value=" . $value . ">" . $value . "</option>";
                }
                $comboMovimiento = "<option value='-1'>Seleccionar...</option>";
                foreach ($data['Movimientos'] as $value) {
                    $comboMovimiento.="<option value=" . $value['idTipAps'] . ">" . $value['NomTipAps'] . "</option>";
                }
                array_push($dataCombos, $comboEjercicio, $comboMovimiento, $data['ue']);
                echo json_encode($dataCombos);
                break;
            
                case "consultaEmpresa":
                $data = $aplicacion->obtenerEmpresas($RfcEmp);
                echo json_encode($data);
                break;

            case "getObraById":
                $result = array();
                $data = $aplicacion->getObraById($idObr, $ejercicio);
                if ($data) {
//                    if (count($data['contratos'] > 0)) {
                    if (isset($data['contratos'])) {
                        $comboContratos = "<option value='-1'>Seleccionar...</option>";
                        foreach ($data['contratos'] as $value) {
                            $comboContratos.="<option value=" . $value['idContrato'] . ">" . $value['numContra'] . " " . $value['NomEmp'] . " " . $value['fecCeleb'] . "</option>";
                        }
                    } else {
                        $comboContratos = 0;
                        $data['contratos']=0;
                    }

                    $comboFuentes = "<option value='-1'>Seleccionar...</option>";
                    foreach ($data['fuentes'] as $value) {
                        $comboFuentes.="<option value=" . $value['idFte'] . ">" . $value['CveFte'] . " " . $value['DscFte'] . "</option>";
                    }

                    $result['obra'] = $data['obra'];
                    $result['comboContratos'] = $comboContratos;
                    $result['contratos'] = $data['contratos'];
                    $result['fuentes'] = $comboFuentes;
                    $result['montosFuentes'] = $data['fuentes'];
                    echo json_encode($result);
                }else{
                    echo 'false';
                }
                break;
                
            case "getFolioParaAmortizar":
                $data = $aplicacion->getFolioParaAmortizar($idObr, $idFte,$idSol);
                echo json_encode($data);
                break;

            case "getContratoAnticipo":
                $result = array();
                $dataContratos = $aplicacion->getContratoAnticipo($idSol);
                $importes = Array();
                if (count($dataContratos > 0)) {
                    $comboContratos = "<option value='-1'>Seleccionar...</option>";
                    foreach ($dataContratos as $value) {
                        $comboContratos.="<option value=" . $value['idContrato'] . ">" . $value['numContra'] . " / " . $value['NomEmp'] . " / " . $value['fecCeleb'] . " / Monto de anticipo: $" . $value['montoAnticipo'] . "</option>";
                        array_push($importes, array($value['idContrato'], $value['montoAnticipo'], $value['fuentes']));
                    }
                } else {
                    $comboContratos = 0;
                }
                $result['comboContratos'] = $comboContratos;
                $result['importes'] = $importes;
                echo json_encode($result);
                break;

            case "getOficios":
                $data = $aplicacion->getOficios($idObr);
                echo json_encode($data);
                break;

            case "getConceptos":
                $data = $aplicacion->getConceptos($idContrato, $idFte);
                echo json_encode($data);
                break;
            
            case "getConceptosFuente":
                $data = $aplicacion->getConceptosFuente($idFte,$idSol);
                echo json_encode($data);
                break;

            case "guardarAp":
                $data = $aplicacion->guardarAp($datosAp, $idSol);
                echo json_encode($data);
                break;

            case "guardarApAnticipo":
                $data = $aplicacion->guardarApAnticipo($datosAp, $idSol);
                echo json_encode($data);
                break;
            
            case "guardarComprobantes":
                $data = $aplicacion->guardarComprobantes($idAps, $comprobantes);
                echo json_encode($data);
                break;
            
            case "cerrarAp":
                $data = $aplicacion->cerrarAp($datosAp, $idSol,$estado);
                echo $data;
                break;
            
            case "cambiarEstado":
                $data = $aplicacion->cambiarEstado($idAps, $estado);
                echo $data;
                break;
            
            //INGRESO
            case "consultaArea":
                $data = $aplicacion->obtenerAreas();
                echo $data["areas"];
                break;
            
            case "consultaTurnos":
                $data = $aplicacion->obtenerTurnos();
                echo $data["turno"];
                break;
            
            case "buscarFolio":
                $data = $aplicacion->getApById($CveAps);
                echo json_encode($data);
                break;
            
             case "ingresaAp":
                $data = $aplicacion->ingresaAp($aps);
                if ($data) {
                    $resp = $aplicacion->registraTurno($data, $area);
                    echo $resp;
                } else {
                    echo "false";
                }
                break;

            
            //ANALISIs
            case "getApByIdAnalisis":
                $data = $aplicacion->getApByIdAnalisis($CveAps);
                echo json_encode($data);
                break;
            
            case "aceptarAp":
                $data = $aplicacion->aceptarAp($ap, $idSol);
                echo json_encode($data);
                break;
            
            case "devolucionAp":
                $data = $aplicacion->devolucionAp($ap, $idSol);
                echo $data;
                break;
            
            //LISTADO
            
            case "listadoApGeneral":
                $data = $aplicacion->listadoApGeneral($condicion, $parametro);
                echo json_encode($data);
                break;
            
            case "getDevoluciones":
                $data = $aplicacion->getDevoluciones($idAps);
                echo json_encode($data);
                break;
            
            //ENVIO
            
            case "combosRelacionEnvio":
                $data = $aplicacion->obtenerCombosEnvio();
                echo json_encode($data);
                break;
             case "buscarApEnvio":
                $data = $aplicacion->obtenerApProceso($cveAp);
                echo json_encode($data);
                break;          
            case "obtenerRelacion":
                $data = $aplicacion->obtenerRelacion($idRel);
                echo json_encode($data);
                break;

            case "agregarRelacion":
                $userId = $_SESSION['USERID'];
                $data = $aplicacion->insertarRelacion($ejercicio, $fechaEnvio, $tipoRel, $oficio, $userId);
                echo json_encode($data);

                break;

            case "guardarDataRel":
                echo $aplicacion->InsertRelAps($relacion,$eliminados,$items);
                break;
            
            //ENTREGA
            case "buscarFolioAceptado":
                $data = $aplicacion->obtenerApAceptado($cveAp);
                echo json_encode($data);
                break;

            case "entregaAps":
                $aplicacion->entregaAps($items);
                break;




//
//
//            //VERSION VIEJA
//            case "consultaObras":
//                $data = $aplicacion->obtenerObras($idObra);
//                echo json_encode($data);
//                break;
////        
//            case "consultaArea":
//                $data = $aplicacion->obtenerAreas();
//                echo $data["areas"];
//                break;
////        
//            
////        
//            
////        
//           
//
//            
//
//            case "llenaPdf":
//                $data = $aplicacion->llenaPdf($nombreArea, $ap);
//                echo $data;
//                break;
//
//            
//
//            case "devolucionAp":
//                $data = $aplicacion->devolucionAp($ap);
//                echo $data;
//                break;
//
//            //-------------------------------------------------------------------------------------------
//            //          CONTROLADOR DE MÃ“DULO DE APLICACIÃ“N
//            //-------------------------------------------------------------------------------------------
//            case "getFolio":
//                $data = $aplicacion->getFolio();
//                echo $data;
//                break;
//
//            case "getMovimientos":
//                $data = $aplicacion->getMovimientos($idAps);
//                echo json_encode($data);
//                break;
//
//            case "getObraAplicacion":
//                $data = $aplicacion->getObraAplicacion($idObra);
//                echo json_encode($data);
//                break;
//
//            case "getTipoAp":
//                $data = $aplicacion->getTipoAp();
//                echo $data;
//                break;
//
//            case "buscarFolioAplicacion":
//                $data = $aplicacion->getApById2($CveAps);
//                echo json_encode($data);
//                break;
//
////            case "getOficios":
////
////                $data = $aplicacion->getOficios($idObr, $fec);
////                echo json_encode($data);
////                break;
//
//            case "getMontoOficio":
//                $data = $aplicacion->getMontoOficio($idDetOfi, $idAps);
//                echo $data;
//                break;
//
//            case "getOficiosAp":
//                $data = $aplicacion->getOficiosAp($idObr, $idAps, $fecrec, $mov);
//                echo json_encode($data);
//                //echo $data;
//                break;
//
//            case "getMontoOficioAp":
//                $data = $aplicacion->getMontoOficioAP($idDetAps, $idAps, $mov);
//                echo $data;
//                break;
//
//            case "registrarAp":
//                $data = $aplicacion->registrarAp($apPrincipal);
//                echo json_encode($data);
//                break;
//
//            case "actualizarAp":
//                $data = $aplicacion->actualizarApAplicacion($apPrincipal);
//                echo $data;
//                break;
//
//            case "borrarDetalle":
//                $data = $aplicacion->borrarDetalle($apBorradas);
//                echo $data;
//                break;
//
//            case "guardaDetalle":
//                $data = $aplicacion->guardarDetalle($apDetalle);
//                echo $data;
//                break;
//
//            
//
//            case "imprimeAp":
//                $data = $aplicacion->imprimeAp($datosGenerales, $datosAmortizacion, $aplicacionPresupuestal, $movimientos, $idDetObr);
//                echo $data;
//                break;
////            
////            case "guardaDetalle":
////                $data = $aplicacion->guardarDetalle($apBorradas, $apPrincipal, $apDetalle);
////                echo $data;
////                break;
//
//            
//
//           
//
//            //-------------------------------------------------------------------------------------------
//            //          CONTROLADOR DE MÃ“DULO DE CONTROL
//            //-------------------------------------------------------------------------------------------
//
//            case "buscarFolioControl":
//                $data = $aplicacion->getApByIdControl($CveAps);
//                echo json_encode($data);
//                break;
//
//            case "getEstadoAp":
//                $data = $aplicacion->getEstadoAp();
//                echo $data["estados"];
//                break;
//
//            case "actualizarApControl":
//                $data = $aplicacion->actualizarAp($datosCancel, $apPrincipal);
//                echo $data;
//                break;
//
//            case "imprimirDetalle":
//                $data = $aplicacion->llenarPdfDetalle($datosAp, $movAp, $montosAp);
//                echo $data;
//                break;
//
//            //-------------------------------------------------------------------------------------------
//            //          CONTROLADOR DE MÃ“DULO DE LISTADO
//            //-------------------------------------------------------------------------------------------
//
//            


            default:
                break;
        }
    }
} else {
    echo "Peticion Invalida";
}