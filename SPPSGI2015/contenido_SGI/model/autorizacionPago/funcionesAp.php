<?php

session_start();
include_once '../../libs/ChromePhp.php';
include_once 'funcionesApModel.php';

class Aplicaciones {

    var $insAplicacionModel;

    function __construct() {

        $this->insAplicacionModel = new aplicacionModel();
    }

    public function getEjercicio() {
        $ejercicio = $this->insAplicacionModel->getEjercicio();
        return $ejercicio;
    }

    public function getMoviento() {
        $movimientos = $this->insAplicacionModel->getMovimiento();
        return $movimientos;
    }

    public function getUE($idue) {
        $ue = $this->insAplicacionModel->unidadEjecutora($idue);
        return $ue;
    }
    
    public function obtenerEmpresas($RfcEmp) {
        $data = array();
        $empresas = $this->insAplicacionModel->catalogoEmpresas($RfcEmp);
        if ($empresas) {
            foreach ($empresas as $key) {
                $data["idEmp"] = $key["idemp"];
                $data["NomEmp"] = utf8_encode($key["nomemp"]);
            }
        } else {
            $data[] = null;
        }
        return $data;
    }

    public function getObraById($idObr, $ejercicio) {
        $obraresult = Array();
        $obraresult['obra'] = $this->insAplicacionModel->getObraById($idObr, $ejercicio);
        if ($obraresult['obra']) {
            if ($obraresult['obra'][0]['IdModEje'] == "3") { // ES POR CONTRATO               
                $obraresult['contratos'] = $this->insAplicacionModel->getContratoSol($obraresult['obra'][0]['VerExpTec']);
                $obraresult['fuentes'] = $this->insAplicacionModel->getFuentesSol($obraresult['obra'][0]['VerExpTec']);
                return $obraresult;
            } else { // POR ADMINISTRACION
                $obraresult['fuentes']=  $this->insAplicacionModel->getFuentesSol($obraresult['obra'][0]['VerExpTec']);
                return $obraresult;
            }
        } else {
            return false;
        }
    }

    public function getFolioParaAmortizar($idObr, $idFte, $idSol) {
        $folioParaAmortizar = $this->insAplicacionModel->getFolioParaAmortizar($idObr, $idFte, $idSol);
        return $folioParaAmortizar;
    }

    public function getContratoAnticipo($idSol) {
        $contratos = $this->insAplicacionModel->getContratoAnticipo($idSol);
        return $contratos;
    }

    public function getOficios($idObr) {
//        if($FecRec=='0'){
        $fecha = date("Y-m-d");
//        }else{
//            $fecha = $FecRec;
//        }
        $oficios = $this->insAplicacionModel->getOficios($idObr, $fecha);
        return $oficios;
    }

    public function getConceptos($idContrato, $idFte) {
        $conceptos = $this->insAplicacionModel->getConceptos($idContrato, $idFte);
        return $conceptos;
    }
    
    public function getConceptosFuente($idFte,$idSol) {
        $conceptos = $this->insAplicacionModel->getConceptosFuente($idFte,$idSol);
        return $conceptos;
    }

    public function getApById($CveAps) {
        $ap = $this->insAplicacionModel->getApById($CveAps);
        return $ap;
    }

    public function guardarAp($datosAp, $idSol) {
        if ($datosAp[0]['idAp'] === "0") {
            $folio = $this->insAplicacionModel->getFolio();
            if ($folio != '') {
                $folioViejo = substr($folio, -3);
                $folioViejo = (int) $folioViejo + 1;
                switch (strlen($folioViejo)) {
                    case 1: $folioViejo = '00' . $folioViejo;
                        break;
                    case 2: $folioViejo = '0' . $folioViejo;
                        break;
                }
                $nvoFolio = date("ymd") . $folioViejo;
            } else {
                $nvoFolio = date("ymd") . "001";
            }
        }
        $resp = $this->insAplicacionModel->guardarAP($datosAp, $nvoFolio, '0');
        if (!$resp) {
            return false;
        } else {
            if ($datosAp[0]['idTipAps'] == "4" || $datosAp[0]['idTipAps'] == "6" ||  $datosAp[0]['idTipAps'] == "7") { // SI ES ESTIMACION,PAGO O COMPROBACION GUARDAR LA RELACION CON CONCEPTOS
                $resp2 = $this->insAplicacionModel->guardarMontoConceptos($resp, $datosAp);
                return $resp;
            }
        }
    }

    public function guardarApAnticipo($datosAp, $idSol) {
        $fuenteFolio = Array();
        for ($i = 0; $i < count($datosAp); $i++) {
            $folio = $this->insAplicacionModel->getFolio();
            if ($folio != '') {
                $folioViejo = substr($folio, -3);
                $folioViejo = (int) $folioViejo + 1;
                switch (strlen($folioViejo)) {
                    case 1: $folioViejo = '00' . $folioViejo;
                        break;
                    case 2: $folioViejo = '0' . $folioViejo;
                        break;
                }
                $nvoFolio = date("ymd") . $folioViejo;
            } else {
                $nvoFolio = date("ymd") . "001";
            }

            $resp = $this->insAplicacionModel->guardarAPAnticipo($datosAp[$i], $nvoFolio, '0', $idSol);
            if (!$resp) {
                return false;
            } else {
                array_push($fuenteFolio, array($datosAp[$i]['idFte'], $nvoFolio));
            }
        }
        return $fuenteFolio;
    }

    public function cerrarAp($datosAp, $idSol, $estado) {
        if ($this->cambiarEstado($datosAp[0]['idAp'], $estado, $datosAp[0]['idTipAps'])) {
            $resp2 = $this->insAplicacionModel->modificaMontos(4, $datosAp[0], $idSol, 0);
            return $resp2;
        } else {
            return false;
        }
    }

    public function guardarComprobantes($idAps, $comprobantes) {
        $resp2 = $this->insAplicacionModel->guardarComprobantes($idAps, $comprobantes);
        return $resp2;
    }

    public function cambiarEstado($idAps, $estado, $tipo) {
        $respb = $this->insAplicacionModel->cambiarEstado($idAps, $estado, $tipo);
        return $respb;
    }

    //INGRESO
    public function obtenerAreas() {
        $data = array();
        $areas = $this->insAplicacionModel->catalogoAreas();

        if ($areas) {
            $res = "";
            foreach ($areas as $key) {
                $res.= "<option value='" . $key["idDir"] . "'>" . utf8_encode($key["NomDir"]) . "</option>";
            }
            $data['areas'] = $res;
        }
        return $data;
    }

    public function obtenerTurnos() {

        $turno = $this->insAplicacionModel->obtenerTurnos();
        if ($turno) {
            $dataTurno['turno'] = $turno;
        } else {
            $dataTurno['turno'] = 1;
        }
        return $dataTurno;
    }

    public function ingresaAp($ap) {
        $resp = $this->insAplicacionModel->updateApTurno($ap);
        return $resp;
    }

    public function registraTurno($data, $area) {
        $resp = $this->insAplicacionModel->registraTurno($data, $area);
        return $resp;
    }

    //ANALISIS
    public function getApByIdAnalisis($CveAps) {
        $ap = $this->insAplicacionModel->getApByIdAnalisis($CveAps);
        return $ap;
    }

    public function aceptarAp($ap, $idSol) {
        $resp = $this->insAplicacionModel->aceptarAp($ap, $idSol);
        return $resp;
    }
    
    public function devolucionAp($ap,$idSol) {
            $respb = $this->insAplicacionModel->cancelaAp($ap,$idSol);
            return $respb;
    }
    
    //LISTADO
    public function listadoApGeneral($condicion, $parametro) {
        $ap = $this->insAplicacionModel->listadoApGeneral($condicion, $parametro);
        return $ap;
    }
    
    public function getDevoluciones($idAps) {
        $resp = $this->insAplicacionModel->getDevoluciones($idAps);
        return $resp;
    }
    
    //ENVIO
    public function obtenerCombosEnvio() {
        $ejercicios = $this->insAplicacionModel->getCatEjercicio();


        $txtEjercicio = '';
        foreach ($ejercicios as $ejercicio) {
            $txtEjercicio .= "<option value='" . $ejercicio['Ejercicio'] . "'>" . $ejercicio['Ejercicio'] . "</option>";
        }
        $data['ejercicio'] = $txtEjercicio;

        $tipRels = $this->insAplicacionModel->getCatTipRel();

        $txtRels = '';
        foreach ($tipRels as $rel) {
            $txtRels .= "<option value='" . $rel['IdTipRel'] . "'>" . $rel['NomTipRel'] . "</option>";
        }

        $data['tipRel'] = $txtRels;
        return $data;
    }
    
     public function obtenerApProceso($cveAp) {
        $data = $this->insAplicacionModel->getApProceso($cveAp);
        $dat['resultado'] = FALSE;
        if (count($data) > 0) {
            $dat['resultado'] = TRUE;
            $dat['info'] = end($data);
        }
        return $dat;
    }

    

    public function obtenerRelacion($idRel) {
        $data = $this->insAplicacionModel->getApsRel($idRel);
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function insertarRelacion($ejercicio, $fechaEnvio, $tipoRel, $oficio, $userId) {
        $fecha = $fechaEnvio;
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $ano = substr($fecha, 6, 4);
        $fechaEnvio = $ano . "-" . $mes . "-" . $dia;
        $id = $this->insAplicacionModel->insertRelacion($ejercicio, $fechaEnvio, $tipoRel, $oficio, $userId);
        $data['resultado'] = false;
        if ($id) {
            $data['resultado'] = true;
            $data['idRelAps'] = $id;
        }
        return $data;
    }

    public function InsertRelAps($relacion,$eliminados,$items) {       
        $this->insAplicacionModel->updateRelApsDel($eliminados);
        foreach ($items as $item) {
         $resp=$this->insAplicacionModel->updateRelAps($relacion, $item);
        }
        return $resp;
    }
    
    //ENTREGA
    
    public function obtenerApAceptado($cveAp) {
        $data = $this->insAplicacionModel->getApAceptado($cveAp);

        $dat['resultado'] = FALSE;
        if (count($data) > 0) {
            $dat['resultado'] = TRUE;
            $dat['info'] = end($data);
            return $dat;
        }
        return $dat;
    }

    public function entregaAps($items) {
        $this->insAplicacionModel->updateFechaAp($items);
    }


}

//    // VERSION VIEJA
//    public function getApById($CveAps) {
//        $data = array();
//        $ap = $this->insAplicacionModel->getApById($CveAps);
//        return $ap;
//    }
//
//    
//
//   
//
//    public function obtenerObras($idObra) {
//        $data = array();
//        $periodo = "";
//        $idDetObr;
//        $obras = $this->insAplicacionModel->catalogoObras($idObra);
//        if ($obras) {
//            foreach ($obras as $key) {
//                $idDetObr = $key["idDetObr"];
//                $periodo .= "<option value='" . $key["Ejercicio"] . "'>" . $key["Ejercicio"] . "</option>";
//            }
//            $data['periodo'] = $periodo;
//        } else {
//            $data[] = null;
//        }
//        return $data;
//    }
//
//    public function obtenerAreas() {
//        $data = array();
//        $areas = $this->insAplicacionModel->catalogoAreas();
//
//        if ($areas) {
//            $res = "";
//            foreach ($areas as $key) {
//                $res.= "<option value='" . $key["idDir"] . "'>" . utf8_encode($key["NomDir"]) . "</option>";
//            }
//            $data['areas'] = $res;
//        }
//        return $data;
//    }
//
//    
//
//    
//
//    
//
//    
//
//    public function llenaPdf($area, $datos) {
//        $_SESSION["area"] = $area;
//        $_SESSION["turno"] = $datos[0]["idTurAps"];
//        $_SESSION["fecha"] = $datos[0]["FecRec"];
//
//        foreach ($datos as $key => $value) {
//            $_SESSION["ap"][] = $value["CveAps"];
//        }
//        ChromePhp::log($_SESSION['ap']);
//        if (count($_SESSION["ap"] > 0))
//            return true;
//        else
//            return false;
//    }
//
//    
//
//    public function devolucionAp($ap) {
//
//        $resp = $this->insAplicacionModel->generaDevolucion($ap);
//        if ($resp) {
//            $respb = $this->insAplicacionModel->cancelaAp($ap);
//            return $respb;
//        } else {
//            return $resp;
//        }
//    }
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MÃ“DULO DE APLICACIÃ“N
//    //-------------------------------------------------------------------------------------------
//
//
//    public function getMovimientos($idAps) {
//
//        $movimientos = $this->insAplicacionModel->getMovimientos($idAps);
//        //return $obraresult.getIdDetObr();
//        return $movimientos;
//    }
//
//    public function getObraAplicacion($idObra) {
//
//        $obraresult = $this->insAplicacionModel->getObraAplicacion($idObra);
//        //return $obraresult.getIdDetObr();
//        return $obraresult;
//    }
//
//    public function getTipoAp() {
//        $tipoAp = array();
//        $data = $this->insAplicacionModel->getTipoAp();
//
//        if ($data) {
//            $res = "";
//            foreach ($data as $key) {
//                $res.= "<option value='" . $key["idTipAps"] . "'>" . utf8_encode($key["NomTipAps"]) . "</option>";
//            }
//            $tipoAp['tipos'] = $res;
//        }
//        return $tipoAp['tipos'];
//    }
//
//    public function getApById2($CveAps) {
//        $ap = $this->insAplicacionModel->getApById2($CveAps);
//        return $ap;
//    }
//
////    public function getOficios($idObr, $FecRec) {
////        ChromePhp::log("Fecha:".$FecRec);
////        if($FecRec=='0'){
////            $fecha = date("Y-m-d");
////        }else{
////            $fecha = $FecRec;
////        }
////        $ap = $this->insAplicacionModel->getOficios($idObr, $fecha);
////            return $ap;
////    }
//
//    public function getMontoOficio($idDetOfi, $idAps) {
//        $monto = 0;
//
//        //Obtener Montos de los oficios
//        $ap = $this->insAplicacionModel->getMontoOficio($idDetOfi);
//        foreach ($ap as $key) {
//            if ($key['idTipOfi'] == 5 || $key['idTipOfi'] == 6) {
//                $monto = $monto - $key["MonAut"];
//            } else {
//                $monto = $monto + $key["MonAut"];
//            }
//        }
//
//        //Obtener Montos de las AP
//        $resp = $this->insAplicacionModel->getMontoAp($idDetOfi, $idAps);
//        foreach ($resp as $key) {
//            if ($key['idTipAps'] == 3) {
//                $monto = $monto + $key["Monto"];
//            } else {
//                $monto = $monto - $key["Monto"];
//            }
//        }
//        ChromePhp::log("Monto Disponible:" + $monto);
//        return number_format($monto, 2, '.', '');
//    }
//
//    public function getOficiosAp($idObr, $idAps, $fecrec, $mov) {
//        $resp = $this->insAplicacionModel->getOficiosAP($idObr, $idAps, $fecrec, $mov);
//        return $resp;
//    }
//
//    public function getMontoOficioAP($idDetAps, $idAps, $mov) {
//        $monto = 0;
//
//        if ($mov == "3") { //DEVOLUCION
//            $ap = $this->insAplicacionModel->getMontoApDevolucion($idDetAps, $idAps);
//            foreach ($ap as $key) {
//                if ($key['idTipAps'] == 1 || $key['idTipAps'] == 3 || $key['idTipAps'] == 5) {
//                    $monto = $monto - $key["Monto"];
//                } else {
//                    $monto = $monto + $key["Monto"];
//                }
//            }
//        } else { //AMORTIZACION - IVA
//            $ap = $this->insAplicacionModel->getMontoApAmIva($idDetAps, $idAps);
//            foreach ($ap as $key) {
//                if ($key['idTipAps'] == 2) {
//                    $monto = $monto + $key["Monto"];
//                } else {
//                    $monto = $monto - $key["Monto"];
//                }
//            }
//        }
//        return number_format($monto, 2, '.', '');
//    }
//
//    public function registrarAp($apPrincipal) {
//        $fechaAlt = 0;
//        foreach ($apPrincipal as $key) {
//
//            if ($key['fecAlt'] == '0') { //AP CON FECHA ACTUAL
//                $folio = $this->insAplicacionModel->getFolio();
//                if ($folio != '') {
//                    $folioViejo = substr($folio, -3);
//                    $folioViejo = (int) $folioViejo + 1;
//                    switch (strlen($folioViejo)) {
//                        case 1: $folioViejo = '00' . $folioViejo;
//                            break;
//                        case 2: $folioViejo = '0' . $folioViejo;
//                            break;
//                    }
//                    $nvoFolio = date("ymd") . $folioViejo;
//                } else {
//                    $nvoFolio = date("ymd") . "001";
//                }
//            } else { // AP CON FECHA ALTERNATIVA
//                $folio = $this->insAplicacionModel->getFolioByFecha($key['fecAlt']);
//                if ($folio != '') {
//                    $folioViejo = substr($folio, -3);
//                    $folioViejo = (int) $folioViejo + 1;
//                    switch (strlen($folioViejo)) {
//                        case 1: $folioViejo = '00' . $folioViejo;
//                            break;
//                        case 2: $folioViejo = '0' . $folioViejo;
//                            break;
//                    }
//                    $nvoFolio = $key['fecAlt'] . $folioViejo;
//                } else {
//                    $nvoFolio = $key['fecAlt'] . "001";
//                }
//                $fechaAlt = $key['fechaAlternativa'];
//            }
//        }
//
//
//        $resp = $this->insAplicacionModel->registraAP($apPrincipal, $nvoFolio, $fechaAlt);
//        return $resp;
//    }
//
//    public function actualizarApAplicacion($apPrincipal) {
//        $resp = $this->insAplicacionModel->actualizarPrincipal($apPrincipal);
//        return $resp;
//    }
//
//    public function borrarDetalle($apBorradas) {
//        $resp = $this->insAplicacionModel->borrarAp($apBorradas);
//        return $resp;
//    }
//
//    public function guardarDetalle($apDetalle) {
//        $respb = $this->insAplicacionModel->registrarDetalle($apDetalle);
//        return $respb;
//    }
//
//    
//
//    public function imprimeAp($datosGenerales, $datosAmortizacion, $aplicacionPresupuestal, $movimientos, $idDetObr) {
//
//        $_SESSION['datosGenerales'] = $datosGenerales[0];
//        $_SESSION['datosAmortizacion'] = $datosAmortizacion;
//        $_SESSION['aplicacionPresupuestal'] = $aplicacionPresupuestal[0];
//        $_SESSION['movimientos'] = $movimientos;
//        $_SESSION['contratos'] = $this->insAplicacionModel->getContratos($idDetObr);
//        $_SESSION['montoAutorizado'] = $this->insAplicacionModel->getMontoAutorizado($idDetObr, $datosGenerales[0]['idDep']);
//        ChromePhp::log($_SESSION['montoAutorizado']);
//        return true;
//    }
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MODULO DE CONTROL
//    //-------------------------------------------------------------------------------------------
//
//    public function getApByIdControl($CveAps) {
//        $ap = $this->insAplicacionModel->getApByIdControl($CveAps);
//        return $ap;
//    }
//
//    public function getEstadoAp() {
//        $data = array();
//        $estado = $this->insAplicacionModel->getEstadoAp();
//        $resp = "";
//        if ($estado) {
//            foreach ($estado as $key) {
//                $resp .= "<option value='" . $key["idEdoAps"] . "'>" . $key["NomEdoAps"] . "</option>";
//            }
//            $data["estados"] = $resp;
//        } else {
//            $data[] = null;
//        }
//        return $data;
//    }
//
//    public function actualizarAp($cancelacion, $principal) {
//
//        if (isset($cancelacion)) {
//            ChromePhp::log("entro a cancelacion");
//            $resp = $this->insAplicacionModel->generaDevolucion($cancelacion);
//            if ($resp) {
//                $resp = $this->insAplicacionModel->actualizaAp($principal);
//                return $resp;
//            } else {
//                return false;
//            }
//        } else {
//            ChromePhp::log("entro a actualizacion");
//            $resp = $this->insAplicacionModel->actualizaAp($principal);
//            return $resp;
//        }
//    }
//
//    public function llenarPdfDetalle($datosAp, $movAp, $montosAp) {
//        $_SESSION['datosAp'] = $datosAp;
//        $_SESSION['movAp'] = $movAp;
//        $_SESSION['montosAp'] = $montosAp;
//        return true;
//    }
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MODULO DE LISTADO
//    //-------------------------------------------------------------------------------------------
//
//    
