<?php

if (session_id() == '') {
    session_start();
}
include_once '../../libs/ChromePhp.php';
include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class aplicacionModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }

    public function getEjercicio() {
        global $cnx;
        $query = "SELECT Ejercicio FROM catejercicio WHERE Ejercicio > 0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields['Ejercicio']);
            $rs->movenext();
        }
        return $data;
    }

    public function getMovimiento() {
        global $cnx;
        $query = "SELECT * FROM ctipaps WHERE idTipAps not in (0,3,5)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomTipAps'] = utf8_encode($rs->fields['NomTipAps']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function unidadEjecutora($idue) {

        global $cnx;
        $query = "SELECT NomUE FROM catue where idue=$idue";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            array_push($data, $rs->fields['NomUE']);
            $rs->movenext();
        }
        return $data;
    }

    public function catalogoEmpresas($RfcEmp) {
        global $cnx;
        $query = "SELECT idemp,nomemp FROM cempresa where RfcEmp LIKE '" . $RfcEmp . "'";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getObraById($idObr, $periodo) {
        global $cnx;

        $query = "select psolicitud.idObr,IdModEje,NomObr,VerExpTec,MontoAutorizado,MontoDisponible from pobra
                    left join psolicitud on psolicitud.idSol = pobra.VerExpTec
                    where pobra.idObr = " . $idObr . " and psolicitud.Ejercicio = " . $periodo . "";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getApById($CveAps) {
        global $cnx;
        $query = "select *,pautpag.monto as montoAp from pautpag
                    left join catue using(idUE)
                    left join catsector on pautpag.idSec = catsector.idSec
                    left join cdepto using(idDpt)
                    left join carea using(idDir)
                    left join pobra using(idObr)
                    left join pcontrato using(idContrato)
                    left join psolicitud on psolicitud.idSol=pobra.VerExpTec
                    left join cempresa on pautpag.idEmp=cempresa.idEmp
                    where CveAps like'" . $CveAps . "'";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            if ($rs->fields['idTipAps'] === "4" || $rs->fields['idTipAps'] === "6" || $rs->fields['idTipAps'] === "7") { //SI ES ESTIMACION BUSCAR LOS CONCEPTOS PAGADOS
                $montoConceptos = array();
                $queryPre = "Select idPresu,total,iva,totalConIva from relappre where idAps=" . $rs->fields['idAps'] . "";
                $rs2 = $cnx->Execute($queryPre);
                while (!$rs2->EOF) {
                    array_push($montoConceptos, $rs2->fields);
                    $rs2->movenext();
                }
                $rs->fields['montosConceptos'] = $montoConceptos;
            }
            //BUSCAMOS LA DOCUMENTACION COMPROBATORIA
            $queryComp = "Select * from relapdoc where idAps=" . $rs->fields['idAps'] . "";
            $rs3 = $cnx->Execute($queryComp);
            $comprobantes = array();
            while (!$rs3->EOF) {
                $rs3->fields['folio'] = utf8_encode($rs3->fields['folio']);
                $rs3->fields['tipoDocumento'] = utf8_encode($rs3->fields['tipoDocumento']);
                array_push($comprobantes, $rs3->fields);
                $rs3->movenext();
            }
            $rs->fields['comprobantes'] = $comprobantes;
            $rs->fields['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
            $rs->fields['ObsAps'] = utf8_encode($rs->fields['ObsAps']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getContratoSol($idSol) {
        global $cnx;
        $query = "select * from pcontrato "
                . "left join cempresa using(idEmp) "
                . "where idSol= $idSol and estatus=1";
        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['descrip'] = utf8_encode($rs->fields['descrip']);
            $rs->fields['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getFuentesSol($idSol) {
        global $cnx;
        $query = "select * from catfte2015
                    left join relsolfte using(idFte)
                    where idSol=" . $idSol . "";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['DscFte'] = utf8_encode($rs->fields['DscFte']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getFolioParaAmortizar($idObr, $idFte, $idSol) { // QUITAR EL COMENTARIO DEL ESTADO DE LA AP
        global $cnx;
        $query = "select idAps as idAp,CveAps,ifnull(monto-(select SUM(montoAmortizacion) from pautpag where folioAmortizacion=idAp and idEdoAps=6),monto) as porComprobar
                    from pautpag where idObr=$idObr and idFte = $idFte and idTipAps =2 and idEdoAps=6";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getContratoAnticipo($idSol) {
        global $cnx;
        $query = "select idContrato,numContra,NomEmp, fecCeleb,montoAutActual,pjeAnti,((montoAutActual*pjeAnti)/100) as montoAnticipo ,contratoPadre from pcontrato
                    left join cempresa using(idEmp)
                    where idSol=" . $idSol . " and pjeAnti is not null and pjeAnti > 0 and estatus =1";
        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            if ($rs->fields['contratoPadre'] == "0") { //Anticipo definido en contrato
                $rs->fields['descrip'] = utf8_encode($rs->fields['descrip']);
                $rs->fields['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
            } else { //Anticipo definido en convenio
                $query2 = "select idContrato,numContra,fecCeleb from pcontrato
                    where idContrato=" . $rs->fields['contratoPadre'] . "";
                $rs2 = $cnx->Execute($query2);
                while (!$rs2->EOF) {
                    $rs->fields['idContrato'] = $rs2->fields['idContrato'];
                    $rs->fields['numContra'] = $rs2->fields['numContra'];
                    $rs->fields['fecCeleb'] = $rs2->fields['fecCeleb'];
                    $rs->movenext();
                }
            }

            //BUSCAMOS SI YA HAY ANTICIPOS REGISTRADOS Y LOS RESTAMOS AL MONTO DEFINIDO EN EL CONTRATO
            $query2 = "select sum(monto) as monto from pautpag 
                        where idTipAps = 2 and idContrato =" . $rs->fields['idContrato'] . " and idEdoAps != 2;";
            $rs2 = $cnx->Execute($query2);
            while (!$rs2->EOF) {
                $montoAnticipo = $rs->fields['montoAnticipo'] - $rs2->fields['monto'];
                $rs2->movenext();
            }

            //BUSCAMOS LAS FUENTES QUE INTERVIENEN EN EL CONTRATO Y OBTENEMOS SU PORCENTAJE DE PARTICIPACION
            $query3 = "select idFte,CveFte,DscFte,pjeInv,cuenta from pcontrato
                        left join relsolfte using(idSol)
                        left join catfte2015 using(idFte) where idContrato =" . $rs->fields['idContrato'];

            $rs3 = $cnx->Execute($query3);
            $fuentes = array();
            while (!$rs3->EOF) {
                $rs3->fields['DscFte'] = utf8_encode($rs3->fields['DscFte']);
                $rs3->fields[2] = utf8_encode($rs3->fields[2]);
                array_push($fuentes, $rs3->fields);
                $rs3->movenext();
            }
            $rs->fields['fuentes'] = $fuentes;
            $rs->fields['montoAnticipo'] = $montoAnticipo;
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    function getOficios($idObr, $fecha) {
        global $cnx;
        $query = "select *,poficio.idFte as idfuente,relsolfte.MontoAutorizado as MontoAutorizadoFte,pobra.MontoAutorizado as MontoAutorizadoGral
                    from poficio
                    left join pobra using(idObr)
                    left join psolicitud on psolicitud.idSol = pobra.VerExpTec
                    left join catsolpre on catsolpre.IdSolPre = psolicitud.IdSolPre
                    left join catfte2015 on poficio.idFte = catfte2015.idFte
                    left join relsolfte on poficio.idFte = relsolfte.idFte and pobra.VerExpTec = relsolfte.idSol 
                    where poficio.idObr = " . $idObr . "
                    -- and IdEdoOfi=1
                    and poficio.idSolPre in(2,10,11,12,13)
                    -- and fecFir<=now()";
//        ChromePhp::log("QUERY OFICIOS:");
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {

            $rs->fields['NomTipOfi'] = utf8_encode($rs->fields['NomTipOfi']);
            $rs->fields['NomSolPre'] = utf8_encode($rs->fields['NomSolPre']);
            $rs->fields['DscFte'] = utf8_encode($rs->fields['DscFte']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        return $data;
    }

    public function getConceptos($idContrato, $idFte) {
        global $cnx;
        $condicionFuentes = "";
        if ($idFte !== "All") {
            $condicionFuentes = "and idFte=" . $idFte . "";
        } else {
            $condicionFuentes = "";
        }
        $query = "select ppresupuestoobra.* from ppresupuestoobra
                    left join relprefte using(idPresu)
                    where idContrato = " . $idContrato . " " . $condicionFuentes . "
                    group by idPresu;";

        $rs = $cnx->Execute($query);
        $data = array();
        $dataConceptos = array();
        $dataFuente = array();
        while (!$rs->EOF) {
            $rs->fields['concept'] = utf8_encode($rs->fields['concept']);
            $rs->fields['uniMedi'] = utf8_encode($rs->fields['uniMedi']);

            $queryFte = "select *,(montoDisponible) as disponibleFte from relprefte
                            where idPresu=" . $rs->fields['idPresu'] . " " . $condicionFuentes . "";
//            ChromePhp::log($queryFte);
            $rs2 = $cnx->Execute($queryFte);
            $disponibleFte = 0.00;
            while (!$rs2->EOF) {
                $disponibleFte = (float) $disponibleFte + (float) $rs2->fields['disponibleFte'];
//                ChromePhp::log($disponibleFte);
                array_push($dataFuente, $rs2->fields);
                $rs2->movenext();
            }
            $rs->fields['disponibleConcepto'] = $disponibleFte;
            array_push($dataConceptos, $rs->fields);
            $rs->movenext();
        }

        $data['conceptos'] = $dataConceptos;
        $data['fuentes'] = $dataFuente;
        return $data;
    }

    public function getConceptosFuente($idFte, $idSol) {
        global $cnx;
        $condicionFuentes = "";
        if ($idFte !== "All") {
            $condicionFuentes = "and idFte=" . $idFte . "";
        } else {
            $condicionFuentes = "";
        }
        $query = "select ppresupuestoobra.* from ppresupuestoobra
                    left join relprefte using(idPresu)
                    where idSol = " . $idSol . " " . $condicionFuentes . "
                    group by idPresu;";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        $dataConceptos = array();
        $dataFuente = array();
        while (!$rs->EOF) {
            $rs->fields['concept'] = utf8_encode($rs->fields['concept']);
            $rs->fields['uniMedi'] = utf8_encode($rs->fields['uniMedi']);

            $queryFte = "select *,(montoDisponible) as disponibleFte from relprefte
                            where idPresu=" . $rs->fields['idPresu'] . " " . $condicionFuentes . "";
//            ChromePhp::log($queryFte);
            $rs2 = $cnx->Execute($queryFte);
            $disponibleFte = 0.00;
            while (!$rs2->EOF) {
                $disponibleFte = (float) $disponibleFte + (float) $rs2->fields['disponibleFte'];
//                ChromePhp::log($disponibleFte);
                array_push($dataFuente, $rs2->fields);
                $rs2->movenext();
            }
            $rs->fields['disponibleConcepto'] = $disponibleFte;
            array_push($dataConceptos, $rs->fields);
            $rs->movenext();
        }

        $data['conceptos'] = $dataConceptos;
        $data['fuentes'] = $dataFuente;
        return $data;
    }

    public function getFolio() {
        global $cnx;
        $query = "select idAps,CveAps, fecrec 
                    from pautpag 
                    where feccre = '" . date("Y-m-d") . "'
                    order by idAps DESC limit 1;";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $folio = $rs->fields['CveAps'];
            $rs->movenext();
        }
        return $folio;
    }

    public function guardarAP($ap, $folio, $fechaAlt) {
        global $cnx;
        $idue = $_SESSION["IDUE"];
        $idur = $_SESSION["IDUR"];

        if ($fechaAlt == '0') {
            $FecCre = date("Y-m-d");
            $FecSis = date("Y-m-d");
        } else {
            $FecCre = $fechaAlt;
            $FecSis = date("Y-m-d");
        }
        if ($ap[0]['idTipAps'] !== "4" && $ap[0]['idTipAps'] !== "6" && $ap[0]['idTipAps'] !== "7") {
            $cnx->StartTrans();
        }
        foreach ($ap as $key) {
            if ($key['idAp'] === "0") { // ES REGISTRO NUEVO
                $query = "INSERT INTO pautpag(CveAps, idTipAps, idEdoAps,idObr,idFte,idContrato,idEmp,ObsAps,monto,montoAmortizacion,montoIvaAmortizacion,folioAmortizacion,Iva,Icic,Cmic,Supervision,Ispt,Otro,idUsu,FecAlt,FecCre,FecSis,idUE,idSec) VALUES("
                        . "'" . $folio . "',"
                        . "" . $key['idTipAps'] . ","
                        . "4,"
                        . "" . $key['idObr'] . ","
                        . "" . $key['idFte'] . ","
                        . "" . $key['idContrato'] . ","
                        . "" . $key['idEmp'] . ","
                        . "'" . utf8_decode($key['observaciones']) . "',"
                        . "" . $key['monto'] . ","
                        . "" . $key['montoAmortizacion'] . ","
                        . "" . $key['montoIvaAmortizacion'] . ","
                        . "" . $key['folioAmortizacion'] . ","
                        . "" . $key['iva'] . ","
                        . "" . $key['icic'] . ","
                        . "" . $key['cmic'] . ","
                        . "" . $key['supervision'] . ","
                        . "" . $key['ispt'] . ","
                        . "" . $key['otro'] . ","
                        . "" . $_SESSION['USERID'] . ","
                        . "now(),"
                        . "'" . date('Y-m-d', strtotime($FecCre)) . "',"
                        . "'" . date('Y-m-d', strtotime($FecSis)) . "',"
                        . "" . $idue . ","
                        . "" . $idur . ")";
//                ChromePhp::log($query);
                $rs = $cnx->Execute($query);
                if ($rs) {
                    $data = array();
                    $idAps = $cnx->Insert_ID();
                    array_push($data, $idAps, $folio);

                    return $data;
                } else {
                    return false;
                }
            } else {
//                ChromePhp::log($key);
                $query = "UPDATE pautpag SET
                        idEmp=" . $key['idEmp'] . ",
                        ObsAps='" . utf8_decode($key['observaciones']) . "',
                        monto=" . $key['monto'] . ",
                        montoAmortizacion=" . $key['montoAmortizacion'] . ",
                        montoIvaAmortizacion=" . $key['montoIvaAmortizacion'] . ",
                        folioAmortizacion=" . $key['folioAmortizacion'] . ",
                        Iva=" . $key['iva'] . ",
                        Icic=" . $key['icic'] . ",
                        Cmic=" . $key['cmic'] . ",
                        Supervision=" . $key['supervision'] . ",
                        Ispt=" . $key['ispt'] . ",
                        Otro=" . $key['otro'] . ",
                        idUsu=" . $_SESSION['USERID'] . ",
                        FecAlt=now()
                        WHERE idAps =" . $key['idAp'] . "";
                $rs = $cnx->Execute($query);
                if ($rs) {
                    $data = array();
                    array_push($data, $key['idAp'], $key['CveAps']);
                    return $data;
                } else {
                    return false;
                }
            }
        }
    }

    public function guardarMontoConceptos($idAps, $datosAp) {
        global $cnx;
        // BORRAR LA RELACION DE CONCEPTOS PAGADOS E INSERTAR LOS NUEVOS
        $queryElim = "DELETE FROM relappre WHERE idAps=" . $datosAp[0]['idAp'] . "";
        $rsElim = $cnx->Execute($queryElim);

        foreach ($datosAp[0]['montosConceptos'] as $montoConceptos) {
            $query = "INSERT INTO relappre VALUES ($idAps[0],$montoConceptos[0],$montoConceptos[1],$montoConceptos[2],$montoConceptos[3])";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
            if (!$rs) {
                return false;
            }
        }
        return true;
    }

    public function guardarAPAnticipo($ap, $folio, $fechaAlt, $idSol) {
        global $cnx;
        $idue = $_SESSION["IDUE"];
        $idur = $_SESSION["IDUR"];
        if ($fechaAlt == '0') {
            $FecCre = date("Y-m-d");
            $FecSis = date("Y-m-d");
        } else {
            $FecCre = $fechaAlt;
            $FecSis = date("Y-m-d");
        }
        $cnx->StartTrans();
        $query = "INSERT INTO pautpag(CveAps, idTipAps, idEdoAps,idObr,idFte,idContrato,idEmp,monto,montoAmortizacion,montoIvaAmortizacion,Iva,Icic,Cmic,Supervision,Ispt,Otro,idUsu,FecAlt,FecCre,FecSis,idUE,idSec) VALUES("
                . "'" . $folio . "',"
                . "" . $ap['idTipAps'] . ","
                . "3,"
                . "" . $ap['idObr'] . ","
                . "" . $ap['idFte'] . ","
                . "" . $ap['idContrato'] . ","
                . "" . $ap['idEmp'] . ","
                . "" . $ap['monto'] . ","
                . "0.00,"
                . "0.00,"
                . "" . $ap['iva'] . ","
                . "" . $ap['icic'] . ","
                . "" . $ap['cmic'] . ","
                . "" . $ap['supervision'] . ","
                . "" . $ap['ispt'] . ","
                . "" . $ap['otro'] . ","
                . "" . $_SESSION['USERID'] . ","
                . "now(),"
                . "'" . date('Y-m-d', strtotime($FecCre)) . "',"
                . "'" . date('Y-m-d', strtotime($FecSis)) . "',"
                . "" . $idue . ","
                . "" . $idur . ")";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        if ($rs) {
            $data = array();
            $idAps = $cnx->Insert_ID();
            array_push($data, $idAps, $folio);

            if ($this->modificaMontos(4, $ap, $idSol, 0)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function guardarComprobantes($idAps, $comprobantes) {
        global $cnx;
        // BORRAR LA RELACION DE COMPROBANTES E INSERTAR LOS NUEVOS
        $queryElim = "DELETE FROM relapdoc WHERE idAps=$idAps";
        $rsElim = $cnx->Execute($queryElim);

        foreach ($comprobantes as $key) {
            $query = "INSERT INTO relapdoc VALUES ($idAps,'" . utf8_decode($key[1]) . "','" . utf8_decode($key[2]) . "',$key[3],'$key[4]')";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
            if (!$rs) {
                return false;
            }
        }
        return true;
    }

    public function modificaMontos($idEdoAps, $ap, $idSol, $accion) {
        global $cnx;
        $condicionObra = "";
        $condicionFte = "";
        switch ($idEdoAps) {
            case 2:  // CANCELADA
                //AGREAR SWITCH PARA LOS CASOS QUE SEA ESTIMACION, AMORT y PAGO Y ANTICIPO
                switch ($ap['idTipAps']) { // TIPO DE AP
                    case "1": //AMORTIZACION
                        break;
                    case "2": //ANTICIPO
                        // AUMENTA
                        $condicionObra = "MontoDisponible+" . $ap['monto'] . "";
                        $condicionFte = "disponible+" . $ap['monto'] . "";
                        //SE AUMENTA EL MONTO DISPONIBLE DE LA OBRA
                        $queryObra = "UPDATE pobra SET MontoDisponible = " . $condicionObra . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
                        //Y AUMENTA EL MONTO DISPONIBLE DE LA FUENTE
                        $query3 = "UPDATE relsolfte SET disponible = " . $condicionFte . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rs3 = $cnx->Execute($query3);

                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "4"://ESTIMACION
                        //Y AUMENTA EL DISPONIBLE
                        $queryObra = "UPDATE pobra SET"
                                . " MontoDisponible = MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //Y AUMENTA EL DISPONIBLE
                        $queryFte = "UPDATE relsolfte SET"
                                . " disponible = disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($queryFte);

                        foreach ($ap['montosConceptos'] as $key) {
                            //Y AUMENTA EL DISPONIBLE
                            $query4 = "UPDATE relprefte set"
                                    . " montoDisponible=montoDisponible+" . $key[3] . ""
                                    . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "6"://PAGO
                        //Y AUMENTA EL DISPONIBLE
                        $queryObra = "UPDATE pobra SET"
                                . " MontoDisponible = MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //Y AUMENTA EL DISPONIBLE
                        $queryFte = "UPDATE relsolfte SET"
                                . " disponible = disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($queryFte);

                        foreach ($ap['montosConceptos'] as $key) {
                            //Y AUMENTA EL DISPONIBLE
                            $query4 = "UPDATE relprefte set"
                                    . " montoDisponible=montoDisponible+" . $key[3] . ""
                                    . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "7"://COMPROBACION
                        //Y AUMENTA EL DISPONIBLE
                        $queryObra = "UPDATE pobra SET"
                                . " MontoDisponible = MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //Y AUMENTA EL DISPONIBLE
                        $queryFte = "UPDATE relsolfte SET"
                                . " disponible = disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ""
                                . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($queryFte);

                        foreach ($ap['montosConceptos'] as $key) {
                            //Y AUMENTA EL DISPONIBLE
                            $query4 = "UPDATE relprefte set"
                                    . " montoDisponible=montoDisponible+" . $key[3] . ""
                                    . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                }
                break;

            case 4: //REGISTRADO
                switch ($ap['idTipAps']) { // TIPO DE AP
                    case "1": //AMORTIZACION
                        break;
                    case "2": //ANTICIPO
                        if ($accion == 0) { // DISMINUYE
                            $condicionObra = "MontoDisponible-" . $ap['monto'] . "";
                            $condicionFte = "disponible-" . $ap['monto'] . "";
                        } else { // AUMENTA
                            $condicionObra = "MontoDisponible+" . $ap['monto'] . "";
                            $condicionFte = "disponible+" . $ap['monto'] . "";
                        }
                        //SE DISMINUYE EL MONTO DISPONIBLE DE LA OBRA
                        $queryObra = "UPDATE pobra SET MontoDisponible = " . $condicionObra . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
                        //Y DISMINUYE EL MONTO DISPONIBLE DE LA FUENTE
                        $query3 = "UPDATE relsolfte SET disponible = " . $condicionFte . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rs3 = $cnx->Execute($query3);

                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "4"://ESTIMACION
                        if ($accion == 0) { // DISMINUYE
                            $condicionObra = "MontoDisponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        } else { // AUMENTA
                            $condicionObra = "MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        }
                        //SE DISMINUYE EL MONTO DISPONIBLE DE LA OBRA
                        $queryObra = "UPDATE pobra SET MontoDisponible = " . $condicionObra . " WHERE idObr=" . $ap['idObr'] . "";
//                        ChromePhp::log($queryObra);
                        $rsObra = $cnx->Execute($queryObra);
                        //Y DISMINUYE EL MONTO DISPONIBLE DE LA FUENTE
                        $query3 = "UPDATE relsolfte SET disponible = " . $condicionFte . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
//                        ChromePhp::log($query3);
                        $rs3 = $cnx->Execute($query3);

                        foreach ($ap['montosConceptos'] as $key) {
                            if ($accion == 0) { // DISMINUYE
                                $condicionConcepto = "montoDisponible-" . $key[3] . "";
                            } else { // AUMENTA
                                $condicionConcepto = "montoDisponible+" . $key[3] . "";
                            }
                            $query4 = "UPDATE relprefte set montoDisponible=" . $condicionConcepto . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "6"://PAGO
                        if ($accion == 0) { // DISMINUYE
                            $condicionObra = "MontoDisponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        } else { // AUMENTA
                            $condicionObra = "MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        }
                        //SE DISMINUYE EL MONTO DISPONIBLE DE LA OBRA
                        $queryObra = "UPDATE pobra SET MontoDisponible = " . $condicionObra . " WHERE idObr=" . $ap['idObr'] . "";
//                        ChromePhp::log($queryObra);
                        $rsObra = $cnx->Execute($queryObra);
                        //Y DISMINUYE EL MONTO DISPONIBLE DE LA FUENTE
                        $query3 = "UPDATE relsolfte SET disponible = " . $condicionFte . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
//                        ChromePhp::log($query3);
                        $rs3 = $cnx->Execute($query3);

                        foreach ($ap['montosConceptos'] as $key) {
                            if ($accion == 0) { // DISMINUYE
                                $condicionConcepto = "montoDisponible-" . $key[3] . "";
                            } else { // AUMENTA
                                $condicionConcepto = "montoDisponible+" . $key[3] . "";
                            }
                            $query4 = "UPDATE relprefte set montoDisponible=" . $condicionConcepto . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "7"://COMPROBACION
                        if ($accion == 0) { // DISMINUYE
                            $condicionObra = "MontoDisponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible-" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        } else { // AUMENTA
                            $condicionObra = "MontoDisponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                            $condicionFte = "disponible+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . "";
                        }
                        //SE DISMINUYE EL MONTO DISPONIBLE DE LA OBRA
                        $queryObra = "UPDATE pobra SET MontoDisponible = " . $condicionObra . " WHERE idObr=" . $ap['idObr'] . "";
//                        ChromePhp::log($queryObra);
                        $rsObra = $cnx->Execute($queryObra);
                        //Y DISMINUYE EL MONTO DISPONIBLE DE LA FUENTE
                        $query3 = "UPDATE relsolfte SET disponible = " . $condicionFte . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
//                        ChromePhp::log($query3);
                        $rs3 = $cnx->Execute($query3);

                        foreach ($ap['montosConceptos'] as $key) {
                            if ($accion == 0) { // DISMINUYE
                                $condicionConcepto = "montoDisponible-" . $key[3] . "";
                            } else { // AUMENTA
                                $condicionConcepto = "montoDisponible+" . $key[3] . "";
                            }
                            $query4 = "UPDATE relprefte set montoDisponible=" . $condicionConcepto . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }


                        $cnx->CompleteTrans();

                        if ($cnx->HasFailedTrans()) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                }

                break;
            case 6:  // ANALIZADA

                switch ($ap['idTipAps']) { // TIPO DE AP
                    case "1": //AMORTIZACION
                        break;
                    case "2": //ANTICIPO
                        //AUMENTA EL EJERCIDO DE LA OBRA Y SUMA ANTICIPO
                        $queryObra = "UPDATE pobra SET MontoEjercido = MontoEjercido+" . $ap['monto'] . ", sumaAnticipo = sumaAnticipo+" . $ap['monto'] . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //AUMENTA EL EJERCIDO DE LA FUENTE Y SUMA ANTICIPO
                        $queryFte = "UPDATE relsolfte SET MontoEjercido = MontoEjercido+" . $ap['monto'] . ", sumaAnticipo = sumaAnticipo+" . $ap['monto'] . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($rsFte);
                        if ($ap['idContrato'] !== 0) { //ES POR CONTRATO
//                      //AUMENTA EL EJERCIDO DEL CONTRATO 
                            $queryContrato = "UPDATE pcontrato SET montoEjercido = montoEjercido+" . $ap['monto'] . " WHERE idContrato=" . $ap['idContrato'] . "";
                            $rsContrato = $cnx->Execute($queryContrato);
//                ChromePhp::log($rsContrato);
                        }
//                        $cnx->CompleteTrans();
//
//                        if ($cnx->HasFailedTrans()) {
//                            return false;
//                        } else {
//                            return true;
//                        }
                        break;
                    case "4"://ESTIMACION
                        //AUMENTA EL EJERCIDO DE LA OBRA Y COMPROBADO
                        $queryObra = "UPDATE pobra SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ", comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //AUMENTA EL EJERCIDO DE LA FUENTE Y COMPROBADO
                        $queryFte = "UPDATE relsolfte SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ",  comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($rsFte);
                        //AUMENTA EL EJERCIDO DEL CONTRATO 
                        $queryContrato = "UPDATE pcontrato SET montoEjercido = montoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . " WHERE idContrato=" . $ap['idContrato'] . "";
                        $rsContrato = $cnx->Execute($queryContrato);
//                ChromePhp::log($rsContrato);

                        foreach ($ap['montosConceptos'] as $key) {
                            //AUMENTA EL EJERCIDO DE LOS CONCEPTOS
                            $query4 = "UPDATE relprefte set montoEjercido=montoEjercido+" . $key[3] . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }
//                        $cnx->CompleteTrans();
//
//                        if ($cnx->HasFailedTrans()) {
//                            return false;
//                        } else {
//                            return true;
//                        }
                        break;
                    case "6"://PAGO
                        //AUMENTA EL EJERCIDO DE LA OBRA Y COMPROBADO
                        $queryObra = "UPDATE pobra SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ", comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //AUMENTA EL EJERCIDO DE LA FUENTE Y COMPROBADO
                        $queryFte = "UPDATE relsolfte SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ",  comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($rsFte);

                        foreach ($ap['montosConceptos'] as $key) {
                            //AUMENTA EL EJERCIDO DE LOS CONCEPTOS
                            $query4 = "UPDATE relprefte set montoEjercido=montoEjercido+" . $key[3] . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }
//                        $cnx->CompleteTrans();
//
//                        if ($cnx->HasFailedTrans()) {
//                            return false;
//                        } else {
//                            return true;
//                        }
                        break;
                    case "7"://COMPROBACION
                        //AUMENTA EL EJERCIDO DE LA OBRA Y COMPROBADO
                        $queryObra = "UPDATE pobra SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ", comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idObr=" . $ap['idObr'] . "";
                        $rsObra = $cnx->Execute($queryObra);
//                ChromePhp::log($queryObra);
                        //AUMENTA EL EJERCIDO DE LA FUENTE Y COMPROBADO
                        $queryFte = "UPDATE relsolfte SET MontoEjercido = MontoEjercido+" . ($ap['monto'] - ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion'])) . ",  comprobado = comprobado+" . ($ap['montoAmortizacion'] + $ap['montoIvaAmortizacion']) . " WHERE idFte=" . $ap['idFte'] . " AND idSol=$idSol";
                        $rsFuente = $cnx->Execute($queryFte);
//                ChromePhp::log($rsFte);
                        foreach ($ap['montosConceptos'] as $key) {
                            //AUMENTA EL EJERCIDO DE LOS CONCEPTOS
                            $query4 = "UPDATE relprefte set montoEjercido=montoEjercido+" . $key[3] . " WHERE idPresu=" . $key[0] . " AND idFte=" . $ap['idFte'] . "";
                            $rs4 = $cnx->Execute($query4);
//                            ChromePhp::log($query4);
                        }
//                        $cnx->CompleteTrans();
//
//                        if ($cnx->HasFailedTrans()) {
//                            return false;
//                        } else {
//                            return true;
//                        }
                        break;
                }

                //FUNCION PARA AJUSTAR LOS CENTAVOS/PESOS NEGATIVOS EN LOS DISPONIBLES
                $queryNeg = "Select idFte, disponible from relsolfte where idSol=$idSol and disponible<0";
                $rsNeg = $cnx->Execute($queryNeg);
                while (!$rsNeg->EOF) {
                    $queryPos = "Select idFte, disponible from relsolfte where idSol=$idSol and disponible>0 limit 1";
                    $rsPos = $cnx->Execute($queryPos);
                    while (!$rsPos->EOF) {
                        $disponible = $rsNeg->fields['disponible'] * (-1);
                        $fteNeg = $rsNeg->fields['idFte'];
                        $ftePos = $rsPos->fields['idFte'];


                        $queryUpdate = "update relsolfte 
                                        set MontoEjercido = MontoEjercido + $disponible,
                                        disponible = disponible - $disponible,
                                        comprobado = comprobado - $disponible
                                        Where idFte = $ftePos and idSol=$idSol;
                                        ";
                        $rsUp1 = $cnx->Execute($queryUpdate);

                        $queryUpdate2 = "update relsolfte 
                                        set MontoEjercido = MontoEjercido - $disponible,
                                        disponible = disponible + $disponible,
                                        comprobado = comprobado + $disponible
                                        Where idFte = $fteNeg and idSol=$idSol;
                                        ";
                        $rsUp2 = $cnx->Execute($queryUpdate2);

                        $rsPos->movenext();
                    }
                    $rsNeg->movenext();
                }
                $cnx->CompleteTrans();

                if ($cnx->HasFailedTrans()) {
                    return false;
                } else {
                    return true;
                }
                break;
        }
    }

    public function cambiarEstado($idAps, $estado, $tipo) {
        global $cnx;
        if ($tipo == "4") {
            $cnx->StartTrans();
        }
        $query = "Update pautpag set idEdoAps=" . $estado . " WHERE idAps = " . $idAps . "";
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    //INGRESO
    public function catalogoAreas() {
        global $cnx;
        $query = "SELECT * FROM carea where idDir<>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function obtenerTurnos() {
        global $cnx;
        $query = "SELECT idTurAps FROM papstur
                ORDER BY idTurAps DESC 
                LIMIT 1";
        $rs = $cnx->Execute($query);
        while (!$rs->EOF) {
            $data = (int) $rs->fields['idTurAps'] + 1;
            $rs->movenext();
        }
        return $data;
    }

    public function updateApTurno($ap) {
        global $cnx;
        $resp = array();
        foreach ($ap as $value) {
            $query = "UPDATE pAutPag SET idEdoAps=5,idRelAps=0,IdTurAps=" . $value[3] . ",idUsu=" . $_SESSION['USERID'] . ",FecRec='" . date('Y-m-d', strtotime($value[2])) . "',ObsAps='" . utf8_decode($value[4]) . "',FecAlt=now() WHERE idAps =" . $value[0] . "";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
            if ($rs) {
                array_push($resp, array($value[3], $value[2]));
            } else {
                return false;
            }
        }
        return $resp;
    }

    public function registraTurno($ap, $area) {
        global $cnx;
        $query = "INSERT INTO papstur(idTurAps,idDir,idUsu,FecTur) "
                . "VALUES(" . $ap[0][0] . "," . $area . "," . $_SESSION['USERID'] . ",'" . date('Y-m-d', strtotime($ap[0][1])) . "')";
        try {
            $rs = $cnx->Execute($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    //ANALISIS
    public function getApByIdAnalisis($CveAps) {
        global $cnx;
        $cnx->SetCharSet('utf8');
        $query = "select *,pautpag.monto as montoAp,pautpag.FecRec as fechaRecepcion from pAutPag 
                    LEFT JOIN pobra using(idObr)
                    LEFT JOIN psolicitud on psolicitud.idSol = pobra.VerExpTec
                    LEFT JOIN relsolfte on (psolicitud.idSol = relsolfte.idSol and pAutPag.idFte = relsolfte.idFte)
                    LEFT JOIN catfte2015 on (relsolfte.idFte = catfte2015.idFte)
                    LEFT JOIN ctipaps using(idTipAps)
                    LEFT JOIN catue on catue.idUE = pautpag.idUE
                    LEFT JOIN catsector on catsector.idSec = pautpag.idSec
                    LEFT JOIN cdepto using(idDpt)
                    LEFT JOIN carea using(idDir)
                    LEFT JOIN cEdoAps using(idEdoAps)
                    LEFT JOIN cempresa on cempresa.idEmp = pautpag.idEmp
                    LEFT JOIN pcontrato using(idContrato)
                    where CveAps like'" . $CveAps . "'";
        $rs = $cnx->Execute($query);
//        ChromePhp::log($query);
        $data = array();
        while (!$rs->EOF) {
            if ($rs->fields['idTipAps'] === "4" || $rs->fields['idTipAps'] === "6" || $rs->fields['idTipAps'] === "7") { //SI ES ESTIMACION BUSCAR LOS CONCEPTOS PAGADOS
                $montoConceptos = array();
                $queryPre = "Select idPresu,claveObj,concept,relappre.total,relappre.iva,totalConIva from relappre
                                left join ppresupuestoobra using(idPresu) where idAps=" . $rs->fields['idAps'] . "";
                $rs2 = $cnx->Execute($queryPre);
                while (!$rs2->EOF) {
                    array_push($montoConceptos, $rs2->fields);
                    $rs2->movenext();
                }
                $rs->fields['montosConceptos'] = $montoConceptos;
            }

            //BUSCAMOS LA DOCUMENTACION COMPROBATORIA
            $queryComp = "Select * from relapdoc where idAps=" . $rs->fields['idAps'] . "";
            $rs3 = $cnx->Execute($queryComp);
            $comprobantes = array();
            while (!$rs3->EOF) {
                $rs3->fields['folio'] = utf8_encode($rs3->fields['folio']);
                $rs3->fields['tipoDocumento'] = utf8_encode($rs3->fields['tipoDocumento']);
                array_push($comprobantes, $rs3->fields);
                $rs3->movenext();
            }
            $rs->fields['ObsAps'] = utf8_encode($rs->fields['ObsAps']);
            $rs->fields['comprobantes'] = $comprobantes;
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function aceptarAp($ap, $idSol) {
        global $cnx;
        $cnx->StartTrans();
        foreach ($ap as $datosAp) {
            $queryUpdt = "UPDATE pautpag set ObsAps='" . utf8_decode($datosAp['tipos']['ObsAps']) . "',"
                    . "AutPagCP=" . $datosAp['tipos']['AutPagCP'] . ","
                    . "DesAfe=" . $datosAp['tipos']['DesAfe'] . ","
                    . "Error=" . $datosAp['tipos']['Error'] . ","
                    . "Finiquito=" . $datosAp['tipos']['Finiquito'] . ","
                    . "SolAfe=" . $datosAp['tipos']['SolAfe'] . ","
                    . "idUsuVal=" . $_SESSION['USERID'] . ","
                    . "FecVal=now()"
                    . " WHERE idAps=" . $datosAp['idAps'] . "";
            $rs = $cnx->Execute($queryUpdt);
            $this->cambiarEstado($datosAp['idAps'], 6, "0");
            return $this->modificaMontos(6, $datosAp, $idSol, 0);
        }
    }

    public function cancelaAp($ap, $idSol) {
        global $cnx;
        $cnx->StartTrans();
        foreach ($ap as $key) {
            $query = "UPDATE pautpag SET idRelAps=0,FecEnt=null,FecEnv=null,idUsuVal=" . $_SESSION['USERID'] . ",FecVal=now() WHERE idAps=" . $key['idAps'];
            $rs = $cnx->Execute($query);
            $this->cambiarEstado($key['idAps'], 2, "0");
            $this->generaDevolucion($key['datosDevolucion']);
            return $this->modificaMontos(2, $key, $idSol, 1);
//            ChromePhp::log($query);
        }
    }

    public function generaDevolucion($datosDevolucion) {
        global $cnx;
        $query = "INSERT INTO dApsDev(idAps,idUsu,FecDev,ObsDev,OfiDev)"
                . "VALUES(" . $datosDevolucion['idAps'] . "," . $_SESSION['USERID'] . ",'" . date('Y-m-d', strtotime($datosDevolucion['FecDev'])) . "','" . utf8_decode($datosDevolucion["Obs"]) . "','" . $datosDevolucion["OfiDev"] . "')";
        $rs = $cnx->Execute($query);
//        ChromePhp::log("Devolucion:" . $query);
    }

    //LISTADO
    public function listadoApGeneral($condicion, $parametro) {
        global $cnx;
        switch ($condicion) {
            case 1:
                $mesActual = getdate();
                $inicioMes = $mesActual['year'] . "-" . $mesActual['mon'] . "-01";
                $where = "where FecCre <=now() AND FecCre >='" . $inicioMes . "'";
                break;
            case 2:
                $where = "where FecCre='" . $parametro . "'";
                break;
            case 3:
                $where = "where CveAps like '" . $parametro . "'";
                break;

            default:
                break;
        }


        $query = "SELECT idAps,CveAps,pa.idEdoAps,NomEdoAps,FecCre FROM pautpag pa
                    left join cedoaps edo on pa.idEdoAps = edo.idEdoAps
                    " . $where;

//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);

        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getDevoluciones($idAps) {
        global $cnx;
        $query = "SELECT * FROM dApsDev
                WHERE idAps =" . $idAps;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $tmp['idUsu'] = utf8_encode($rs->fields['idUsu']);
            $tmp['FecDev'] = utf8_encode($rs->fields['FecDev']);
            $tmp['ObsDev'] = utf8_encode($rs->fields['ObsDev']);
            $tmp['OfiDev'] = utf8_encode($rs->fields['OfiDev']);
            array_push($data, $tmp);
            $rs->movenext();
        }
//        ChromePhp::log($data);
        return $data;
    }

    //ENVIO
    public function getCatEjercicio() {
        global $cnx;

        $query = "SELECT * FROM catejercicio Where Ejercicio != 0 ORDER BY Ejercicio DESC";
        $rs = $cnx->Execute($query);

        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getCatTipRel() {
        global $cnx;

        $query = "SELECT * FROM ctiprel";
        $rs = $cnx->Execute($query);

        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getApsRel($idRel) {
        global $cnx;

        $query = "SELECT * FROM papsrel WHERE idRelAps='" . $idRel . "'";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $queryAp = "   SELECT PA.idAps,PA.CveAps,PA.idTipAps,PA.idFte,PA.monto,(PA.montoAmortizacion-PA.montoIvaAmortizacion) as montoAmortizacion,PA.idAps,PA.idRelAps,CUE.IdUE,CUE.NomUE,CS.IdSec,CS.NomSec,CEMP.NomEmp,CF.TipoFte,S.Ejercicio FROM pautpag PA
                        left join cedoaps CE using (idEdoAps)
                        left join catue CUE using(idUe)
                        left join catsector CS on (CS.idSec = PA.idSec)
                        LEFT JOIN cempresa CEMP using(idEmp)
                        LEFT JOIN catfte2015 CF using(idFte)
                        LEFT JOIN pobra O using(idObr)
                        LEFT JOIN psolicitud S on(S.idSol = O.VerExpTec)
                        where idRelAps= $idRel";
            $rsAp = $cnx->Execute($queryAp);
            $dataAp = array();
            while (!$rsAp->EOF) {
                $rsAp->fields['NomEmp'] = utf8_encode($rsAp->fields['NomEmp']);
                $rsAp->fields['NomSec'] = utf8_encode($rsAp->fields['NomSec']);
                $rsAp->fields['NomUE'] = utf8_encode($rsAp->fields['NomUE']);
                if ($rsAp->fields['TipoFte'] == "F") {
                    $rsAp->fields['TipoFte'] = "Federal";
                } else {
                    $rsAp->fields['TipoFte'] = "Estatal";
                }
                array_push($dataAp, $rsAp->fields);
                $rsAp->movenext();
            }
            $rs->fields['Aps'] = $dataAp;
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function insertRelacion($ejercicio, $fechaEnvio, $tipoRel, $oficio, $userId) {
        global $cnx;

        $query = "select MAX(idRelAPs) idRelAps FROM papsrel";
        $rs = $cnx->Execute($query);

        while (!$rs->EOF) {
            $idRelAps = $rs->fields['idRelAps'];
            $rs->movenext();
        }
        $idRelAps = (int) $idRelAps + 1;
        $cveAps = $ejercicio . " - " . $idRelAps;
        $query = "INSERT INTO papsrel (idRelAps, idTipRel, idUsu, Ejercicio, CveRelAps, FecEnv, OfiRel) 
                    VALUES ('" . $idRelAps . "','" . $tipoRel . "', '" . $userId . "', '" . $ejercicio . "', '" . $cveAps . "', '" . $fechaEnvio . "', '" . $oficio . "');";
        $rs = $cnx->Execute($query);

        if ($rs) {
            return $idRelAps;
        } else {
            return false;
        }
    }

    public function updateRelAps($relacion, $cveAp) {
        global $cnx;
        $query = "UPDATE pautpag SET idRelAps = " . $relacion . ",idEdoAps = 1,FecEnv=now() WHERE idAps = " . $cveAp;
//         ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRelApsDel($eliminados) {
        global $cnx;
        foreach ($eliminados as $cveAp) {
            $query = "UPDATE pautpag SET idRelAps = 0,idEdoAps = 6,FecEnv=null WHERE idAps = " . $cveAp;
         ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }
    }

    public function dataPdfEnvio($idRelAps) {
        global $cnx;

        $query = "SELECT OfiRel, TitTipRel, TxtTipRel, CcpTipRel,FecEnv,Ejercicio
                FROM papsrel
                LEFT JOIN ctiprel using(idTipRel) 
                WHERE idRelAps = " . $idRelAps;
        
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getApProceso($cveAp) {
        global $cnx;
        $query = "SELECT PA.idAps,PA.CveAps,PA.idTipAps,PA.idFte,PA.monto,(PA.montoAmortizacion-PA.montoIvaAmortizacion) as montoAmortizacion,PA.idAps,CUE.IdUE,CUE.NomUE,CS.IdSec,CS.NomSec,CEMP.NomEmp,CF.TipoFte,S.Ejercicio FROM pautpag PA
                        left join cedoaps CE using (idEdoAps)
                        left join catue CUE using(idUe)
                        left join catsector CS on (CS.idSec = PA.idSec)
                        LEFT JOIN cempresa CEMP using(idEmp)
                        LEFT JOIN catfte2015 CF using(idFte)
                        LEFT JOIN pobra O using(idObr)
                        LEFT JOIN psolicitud S on(S.idSol = O.VerExpTec)
                        where 
                        UPPER(CE.NomEdoAps)=UPPER('ANALIZADA')
                        and idRelAps = 0
                        and (PA.Error IS NULL OR PA.Error != 1)
                        and CveAps = '" . $cveAp . "'";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
            $rs->fields['NomSec'] = utf8_encode($rs->fields['NomSec']);
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            if ($rs->fields['TipoFte'] == "F") {
                $rs->fields['TipoFte'] = "Federal";
            } else {
                $rs->fields['TipoFte'] = "Estatal";
            }
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
    //ENTREGA
    
     public function getApAceptado($cveAp) {
        global $cnx;
        $query = "  SELECT * FROM pautpag
                    left join cedoaps using (idEdoAps)
                    where UPPER(NomEdoAps)='ACEPTADO'
                    and CveAps = '" . $cveAp . "' "
                . "and FecEnt is null";

        $rs = $cnx->Execute($query);

        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    

    public function updateFechaAp($datos) {
        global $cnx;
        foreach($datos as $val){
        $query = "update pautpag set FecEnt = STR_TO_DATE('".$val[2]."','%d-%m-%Y') where idAps =".$val[0]."";
        ChromePhp::log($query);
            $res = $cnx->Execute($query);
        }
        return $res;
    }

}

//    //VERSION VIEJA
//
//    public function getApById($CveAps) {
//
//        global $cnx;
//        $query = "Select * from pAutPag pag 
//                    LEFT JOIN dautpag dpag on pag.idAps = dpag.idAps
//                    LEFT JOIN doficio dof on dpag.idDetOfi = dof.idDetOfi
//                    LEFT JOIN dobra obr on obr.idDetObr = dof.idDetObr
//                    LEFT JOIN catsector sec on sec.IdSec = obr.idSec
//                    LEFT JOIN cdepto dpt on dpt.idDpt = sec.IdDpt
//                    LEFT JOIN carea area on dpt.idDir = area.idDir
//                    LEFT JOIN cEdoAps edo on pag.idEdoAps = edo.idEdoAps
//                    LEFT JOIN cempresa emp on pag.idEmp = emp.idEmp
//                where pag.CveAps like '" . $CveAps . "'";
//        $rs = $cnx->Execute($query);
//        ChromePhp::log($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//   
//
//    public function catalogoObras($idObra) {
//        global $cnx;
//        $query = "SELECT idDetObr,Ejercicio FROM dObra where idObr=" . $idObra;
//        $rs = $cnx->Execute($query);
////        ChromePhp::log($query);       
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function catalogoAreas() {
//        global $cnx;
//        $query = "SELECT * FROM carea where idDir<>0";
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    
//
//   
//
////    public function registraAP($ap) {
////
////        global $cnx;
////        $query = "INSERT INTO pautpag(idEdoAps,idEmp,idTurAps,idUsu,CveAps,FecRec,ObsAps,FecAlt,RetCicem,RetCnic,RetIspt,RetOtr,RetSup)"
////                . " VALUES(" . $ap['idEdoAps'] . "," . $ap['idEmp'] . "," . $ap['idTurAps'] . "," . $_SESSION['USERID'] . ",'" . $ap['CveAps'] . "','" . date('Y-m-d', strtotime($ap["FecRec"])) . "','" . utf8_decode($ap['ObsAps']) . "',now(),0,0,0,0,0)";
////
////        $rs = $cnx->Execute($query);
////        ChromePhp::log($query);
////        if ($rs) {
////            $resp = array($ap['idTurAps'], $ap['FecRec']);
////            return $resp;
////        } else {
////            return "Error";
////        }
////    }
//
//    
//
//    
//
//    
//
//   
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MÓDULO DE APLICACIÓN
//    //-------------------------------------------------------------------------------------------
//   
//
//    public function getFolioByFecha($folFecha) {
//        global $cnx;
//        $query = "select idAps,CveAps, fecrec 
//                    from pautpag 
//                    where CveAps like '" . $folFecha . "%'
//                    order by idAps DESC limit 1;";
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            $folio = $rs->fields['CveAps'];
//            $rs->movenext();
//        }
//        return $folio;
//    }
//
//    public function getMovimientos($idAps) {
//        global $cnx;
//        $query = "select *, dap.idRef as referencia from dautpag dap
//                    left join pautpag pap on pap.idAps = dap.idAps
//                    left join doficio dof on dof.idDetOfi = dap.idDetOfi
//                    left join poficio pof on pof.idOfi = dof.idOfi
//                    left join dobra dob on dob.idDetObr = dof.idDetObr
//                    left join catsector sec on sec.IdSec = dob.idSec
//                    left join catfte2015 fte on fte.idFte = dof.idFte
//                    left join cInversion inv on inv.idInv = dof.idInv
//                    left join crecurso rec on rec.idRec = dof.idRec
//                    left join ctipaps tip on tip.idTipAps = dap.idTipAps
//                    where dap.idAps=" . $idAps;
//        $rs = $cnx->Execute($query);
//        ChromePhp::log($query);
//        $data = array();
//        $tmp = array();
//        while (!$rs->EOF) {
//            $temp['idDetAps'] = utf8_encode($rs->fields['idDetAps']);
//            $temp['ejercicio'] = utf8_encode($rs->fields['Ejercicio']);
//            $temp['idObr'] = utf8_encode($rs->fields['idObr']);
//            $temp['idDetObr'] = utf8_encode($rs->fields['idDetObr']);
//            $temp['NomObr'] = utf8_encode($rs->fields['NomObr']);
//            $temp['idModEje'] = utf8_encode($rs->fields['idModEje']);
//            $temp['idTipAps'] = utf8_encode($rs->fields['idTipAps']);
//            $temp['nomTipAps'] = utf8_encode($rs->fields['NomTipAps']);
//            $temp['CveAps'] = utf8_encode($rs->fields['CveAps']);
//            $temp['idDetOfi'] = utf8_encode($rs->fields['idDetOfi']);
//            $temp['CveOfi'] = utf8_encode($rs->fields['CveOfi']);
//            $temp['idRef'] = $rs->fields['referencia'];
//            $rs2 = $cnx->Execute("Select CveAps from pautpag pp left join dautpag dp on pp.idAps = dp.idAps Where dp.idDetAps=" . $temp['idRef'] . "");
//            $temp['CveRef'] = "";
//            while (!$rs2->EOF) {
//                $temp['CveRef'] = $rs2->fields['CveAps'];
//                $rs2->movenext();
//            }
//            $temp['idFte'] = utf8_encode($rs->fields['idFte']);
//            $temp['DscFte'] = utf8_encode($rs->fields['DscFte']);
//            $temp['idRec'] = utf8_encode($rs->fields['idRec']);
//            $temp['nomRec'] = utf8_encode($rs->fields['NomRec']);
//            $temp['idInv'] = utf8_encode($rs->fields['idInv']);
//            $temp['nomInv'] = utf8_encode($rs->fields['NomInv']);
//            $temp['monto'] = utf8_encode($rs->fields['Monto']);
//            $temp['iva'] = utf8_encode($rs->fields['Iva']);
//            $temp['RetCicem'] = utf8_encode($rs->fields['RetCicem']);
//            $temp['RetCnic'] = utf8_encode($rs->fields['RetCnic']);
//            $temp['RetIspt'] = utf8_encode($rs->fields['RetIspt']);
//            $temp['RetOtr'] = utf8_encode($rs->fields['RetOtr']);
//            $temp['RetSup'] = utf8_encode($rs->fields['RetSup']);
//            $temp['NomSec'] = utf8_encode($rs->fields['NomSec']);
//            ChromePhp::log($rs->fields['referencia']);
//            array_push($data, $temp);
//            $rs->movenext();
//        }
//
//        return $data;
//    }
//
//    public function getObraAplicacion($idObra) {
//        global $cnx;
//        $query = "Select idDetObr,idObr,idDep,NomObr,IdUE,NomUE,dobra.idSec,NomSec from dobra dobra 
//                        left join catue ue on ue.IdUE = dobra.idDep
//                        left join catsector sec on sec.IdSec = dobra.idSec
//                        where dobra.idObr =" . $idObra;
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            $temp['idDetObr'] = utf8_encode($rs->fields['idDetObr']);
//            $temp['idObr'] = utf8_encode($rs->fields['idObr']);
//            $temp['idDep'] = utf8_encode($rs->fields['idDep']);
//            $temp['NomObr'] = utf8_encode($rs->fields['NomObr']);
//            $temp['IdUE'] = utf8_encode($rs->fields['IdUE']);
//            $temp['NomUE'] = utf8_encode($rs->fields['NomUE']);
//            $temp['idSec'] = utf8_encode($rs->fields['idSec']);
//            $temp['NomSec'] = utf8_encode($rs->fields['NomSec']);
//            array_push($data, $temp);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getTipoAp() {
//        global $cnx;
//        $query = "SELECT * FROM ctipaps where idTipAps<>0";
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getApById2($CveAps) {
//        global $cnx;
//        $query = "Select pag.*,edo.NomEdoAps,emp.NomEmp,emp.RfcEmp from pAutPag pag 
//                LEFT JOIN cEdoAps edo on pag.idEdoAps = edo.idEdoAps
//                LEFT JOIN cempresa emp on pag.idEmp = emp.idEmp
//                where pag.CveAps like '" . $CveAps . "'";
////        
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            $temp['idAps'] = utf8_encode($rs->fields['idAps']);
//            $temp['CveAps'] = utf8_encode($rs->fields['CveAps']);
//            $temp['PrmMod'] = utf8_encode($rs->fields['PrmMod']);
//            $temp['idEdoAps'] = utf8_encode($rs->fields['idEdoAps']);
//            $temp['NomEdoAps'] = utf8_encode($rs->fields['NomEdoAps']);
//            $temp['FecRec'] = utf8_encode($rs->fields['FecRec']);
//            $temp['FecCre'] = utf8_encode($rs->fields['FecCre']);
//            $temp['NumEst'] = utf8_encode($rs->fields['NumEst']);
//
//            $temp['AutPagCP'] = utf8_encode($rs->fields['AutPagCP']);
//            $temp['Error'] = utf8_encode($rs->fields['Error']);
//            $temp['Finiquito'] = utf8_encode($rs->fields['Finiquito']);
//            $temp['DesAfe'] = utf8_encode($rs->fields['DesAfe']);
//            $temp['SolAfe'] = utf8_encode($rs->fields['SolAfe']);
//
////           
//            $temp['idEmp'] = utf8_encode($rs->fields['idEmp']);
//            $temp['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
//            $temp['RfcEmp'] = utf8_encode($rs->fields['RfcEmp']);
//            $temp['ObsAps'] = utf8_encode($rs->fields['ObsAps']);
//            $temp['Iva'] = utf8_encode($rs->fields['Iva']);
//            array_push($data, $temp);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
////    public function getOficios($idObr, $FecRec) {
////        global $cnx;
////        $query = "select doficio.*,poficio.FecFir,poficio.CveOfi,obra.Ejercicio,obra.idModEje,fuente.DscFte,inversion.NomInv,recurso.NomRec,CONVERT(tipo.NomTipOfi USING utf8) AS NomTipOfi from doficio doficio
////                    join poficio poficio on poficio.idOfi = doficio.idOfi
////                    left join dObra obra on doficio.idDetObr = obra.idDetObr
////                    left join catfte2015 fuente on fuente.idFte = doficio.idFte
////                    left join cInversion inversion on inversion.idInv = doficio.idInv
////                    left join crecurso recurso on recurso.idRec = doficio.idRec
////                    left join ctipofi tipo on tipo.idTipOfi = doficio.idTipOfi
////                    left join cedoofi estado on estado.IdEdoOfi = poficio.IdEdoOfi
////                    where obra.idObr =" . $idObr . " 
////                    and poficio.IdEdoOfi = 1
////                    and doficio.idTipOfi NOT IN (5,6)
////                    and FecFir <='" . $FecRec . "'
////                    and doficio.MonAut > 0    
////                    order by doficio.idOfi,poficio.FecFir,obra.Ejercicio desc";
////        ChromePhp::log("QUERY OFICIOS:");
////        ChromePhp::log($query);
////        $rs = $cnx->Execute($query);
////        $data = array();
////        while (!$rs->EOF) {
////            $rs->fields['NomTipOfi'] = utf8_encode($rs->fields['NomTipOfi']);
////            array_push($data, $rs->fields);
////            $rs->movenext();
////        }
////
////        return $data;
////    }
//
//    public function getMontoOficio($idDetOfi) {
//        global $cnx;
//        $query = "select idDetOfi,estado.NomEdoOfi,doficio.idTipOfi,MonAut from doficio
//                    left join poficio poficio on poficio.idOfi = doficio.idOfi
//                    left join cedoofi estado on estado.idEdoOfi = poficio.idEdoOFi
//                    where (idDetOfi =" . $idDetOfi . " or IdRef=" . $idDetOfi . ")
//                    and estado.idEdoOfi <> 2;";
//
//        $rs = $cnx->Execute($query);
//        ChromePhp::log("Monto oficios QUERY:");
//        ChromePhp::log($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getMontoAp($idDetOfi, $idAps) {
//        global $cnx;
//        $query = "select dap.Monto,dap.idTipAps from dautpag dap
//                    left join pautpag pap on pap.idAps = dap.idAps
//                    where 
//                    -- dap.idAps <> " . $idAps . " and
//                    dap.idDetOfi = " . $idDetOfi . "
//                    and pap.idEdoAps <> 2
//                    and dap.idTipAps in (2,3,4,6)";
//
//        $rs = $cnx->Execute($query);
//        ChromePhp::log("Monto ap QUERY:");
//        ChromePhp::log($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getOficiosAP($idObr, $idAps, $fecrec, $mov) {
//        global $cnx;
//        if ($mov == "3") {
//            $tipAps = 'and dap.idTipAps IN (2,4,6)';
//        } else {
//            $tipAps = 'and dap.idTipAps IN (2)';
//        }
//        $query = "select * from dobra obra
//                    left join doficio oficio on oficio.idDetObr = obra.idDetObr
//                    left join poficio poficio on poficio.idOfi = oficio.idOfi
//                    left join dautpag dap on dap.idDetOfi = oficio.idDetOfi
//                    left join pautpag pap on pap.idAps = dap.idAps
//                    left join cinversion inv on inv.idInv = oficio.idInv
//                    left join catfte2015 fte on fte.idFte = oficio.idFte
//                    left join crecurso rec on rec.idRec = oficio.idRec
//                    left join ctipaps tip on tip.idTipAps = dap.idTipAps
//                    left join ctipofi tipofi on tipofi.idTipOfi = oficio.idTipOfi
//                    where obra.idObr = " . $idObr . "
//                    and oficio.MonAut > 0
//                    and dap.idAps <> " . $idAps . "
//                    and dap.Monto >0
//                    and oficio.idTipOfi IN (1,2,3,4,7)
//                    and poficio.FecFir <= '" . $fecrec . "'
//                    and poficio.IdEdoOfi = 1 
//                    " . $tipAps . "
//                    and pap.FecRec <= '" . $fecrec . "'
//                    and pap.idEdoAps = 1
//                    order by obra.Ejercicio , pap.FecEnv , pap.CveAps DESC;";
//        ChromePhp::log($query);
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getMontoApDevolucion($idDetAps, $idAps) {
//        global $cnx;
//        $query = "select dap.Monto,dap.idTipAps from dautpag dap
//                    left join pautpag pap on pap.idAps = dap.idAps
//                    left join ctipaps tap on tap.idTipAps = dap.idTipAps
//                    left join cedoaps eap on eap.idEdoAps = pap.idEdoAps
//                    where dap.idAps <> " . $idAps . "
//                    and (dap.idDetAps = " . $idDetAps . " or dap.IdRef=" . $idDetAps . ")
//                    and dap.idTipAps in (1,2,3,4,5,6)
//                    and eap.idEdoAps <> 2";
//        ChromePhp::log($query);
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getMontoApAmIva($idDetAps, $idAps) {
//        global $cnx;
//        $query = "select dap.Monto,dap.idTipAps from dautpag dap
//                    left join pautpag pap on pap.idAps = dap.idAps
//                    left join ctipaps tap on tap.idTipAps = dap.idTipAps
//                    left join cedoaps eap on eap.idEdoAps = pap.idEdoAps
//                    where dap.idAps <> " . $idAps . "
//                    and (dap.idDetAps = " . $idDetAps . " or dap.IdRef=" . $idDetAps . ")
//                    and dap.idTipAps in (1,2,3,5)
//                    and pap.idEdoAps <> 2";
//
//        ChromePhp::log("Query montos AP Amortizacion-Iva");
//        ChromePhp::log($query);
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getContratos($idDetObr) {
//        global $cnx;
//        $query = "SELECT * FROM dContrato WHERE IdDetObr=" . $idDetObr . "";
////        ChromePhp::log($query);
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getMontoAutorizado($idDetObr, $idDep) {
//        global $cnx;
//        $query = "SELECT * FROM dOficio WHERE IdDetObr=" . $idDetObr . " AND idDep=" . $idDep . "";
//        ChromePhp::log($query);
//        $monto = 0;
//        $rs = $cnx->Execute($query);
//
//        while (!$rs->EOF) {
//            if ($rs->fields["idTipOfi"] == 5 || $rs->fields["idTipOfi"] == 6) {
//                $monto = $monto - $rs->fields["MonAut"];
//            } else {
//                $monto = $monto + $rs->fields["MonAut"];
//            }
//            $rs->movenext();
//        }
//        return $monto;
//    }
//
//    public function borrarAp($apBorradas) {
//        global $cnx;
//        for ($i = 0; $i < count($apBorradas); $i++) {
//            $query = "delete from dautpag where idDetAps=" . $apBorradas[$i];
//            $rs = $cnx->Execute($query);
//            ChromePhp::log("Detalles borrados QUERY:");
//            ChromePhp::log($query);
//        }
//        if ($rs) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    public function actualizarPrincipal($apPrincipal) {
//        global $cnx;
//        foreach ($apPrincipal as $key) {
//            $query = "Update pautpag set "
//                    . "NumEst=" . $key['NumEst'] . ","
//                    . "idEmp=" . $key['idEmp'] . ","
//                    . "ObsAps='" . utf8_decode($key['ObsAps']) . "',"
//                    . "PrmMod=" . $key['PrmMod'] . ","
//                    . "Iva=" . $key['Iva'] . ","
//                    . "RetCnic=" . $key['RetCnic'] . ","
//                    . "RetCicem=" . $key['RetCicem'] . ","
//                    . "RetSup=" . $key['RetSup'] . ","
//                    . "RetISPT=" . $key['RetISPT'] . ","
//                    . "RetOtr=" . $key['RetOtr'] . " "
//                    . "where IdAps=" . $key['idAps'];
//            $rs = $cnx->Execute($query);
//            ChromePhp::log("Actualizacion principal QUERY:");
//            ChromePhp::log($query);
//        }
////        return $query;
////            
//        if ($rs) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
////    public function registraAP($ap, $folio, $fechaAlt) {
////        global $cnx;
////
////        if ($fechaAlt == '0') {
////            $FecCre = date("Y-m-d");
////            $FecSis = date("Y-m-d");
////        } else {
////            $FecCre = $fechaAlt;
////            $FecSis = date("Y-m-d");
////        }
////        ChromePhp::log("Fechas" . $FecCre);
////        foreach ($ap as $key) {
////            $query = "INSERT INTO pautpag(idEdoAps,idEmp,idUsu,CveAps,ObsAps,FecAlt,RetCicem,RetCnic,RetIspt,RetOtr,RetSup,NumEst,PrmMod,Iva,FecCre,FecSis) VALUES("
////                    . "4,"
////                    . "" . $key['idEmp'] . ","
////                    . "" . $_SESSION['USERID'] . ","
////                    . "'" . $folio . "',"
////                    . "'" . utf8_decode($key['ObsAps']) . "',"
////                    . "now(),"
////                    . "" . $key['RetCicem'] . ","
////                    . "" . $key['RetCnic'] . ","
////                    . "" . $key['RetISPT'] . ","
////                    . "" . $key['RetOtr'] . ","
////                    . "" . $key['RetSup'] . ","
////                    . "" . $key['NumEst'] . ","
////                    . "" . $key['PrmMod'] . ","
////                    . "" . $key['Iva'] . ","
////                    . "'" . date('Y-m-d', strtotime($FecCre)) . "',"
////                    . "'" . date('Y-m-d', strtotime($FecSis)) . "')";
////
////            $rs = $cnx->Execute($query);
////            ChromePhp::log("Registro principal QUERY:");
////            ChromePhp::log($query);
////        }
////        if ($rs) {
////            $data = array();
////            $idAps = $cnx->Insert_ID();
////            array_push($data, $idAps, $folio);
////            return $data;
////        } else {
////            return false;
////        }
////    }
////
////    public function registrarDetalle($apDetalle) {
////        global $cnx;
////        ChromePhp::log($apDetalle);
////        foreach ($apDetalle as $key) {
////
////            $query = "Insert into dautpag(IdAps,IdDetOfi,IdRef,IdTipAps,IvaAmo,Monto,RetCicem,RetCnic,RetIspt,RetOtr,RetSup) values("
////                    . $key['idAps'] . ","
////                    . $key['idDetOfi'] . ","
////                    . $key['idRef'] . ","
////                    . $key['idTipAps'] . ","
////                    . $key['IvaAmo'] . ","
////                    . str_replace(",", "", $key['Monto']) . ","
////                    . $key['RetCicem'] . ","
////                    . $key['RetCnic'] . ","
////                    . $key['RetISPT'] . ","
////                    . $key['RetOtr'] . ","
////                    . $key['RetSup'] . ")";
////            $rs = $cnx->Execute($query);
////            ChromePhp::log("Detalles registrados QUERY:");
////            ChromePhp::log($query);
////        }
////        ChromePhp::log($apDetalle);
//////        return $query;
////
////        if ($rs) {
////            return true;
////        } else {
////            return false;
////        }
////    }
//
//    
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MÓDULO DE CONTROL
//    //-------------------------------------------------------------------------------------------
//
//    public function getApByIdControl($CveAps) {
//
//        global $cnx;
//        $query = "Select pag.*,edo.NomEdoAps, emp.NomEmp from pAutPag pag 
//                LEFT JOIN cEdoAps edo on pag.idEdoAps = edo.idEdoAps
//                LEFT JOIN cempresa emp on pag.idEmp = emp.idEmp
//                LEFT JOIN papsrel rel on rel.IdRelAps = pag.IdRelAps
//                -- LEFT JOIN ctiprel tiprel on tiprel.IdRelAps = rel.IdRelAps
//                where pag.CveAps like '" . $CveAps . "'";
//
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            $temp['idAps'] = utf8_encode($rs->fields['idAps']);
//            $temp['CveAps'] = utf8_encode($rs->fields['CveAps']);
//            $temp['PrmMod'] = utf8_encode($rs->fields['PrmMod']);
//            $temp['idEdoAps'] = utf8_encode($rs->fields['idEdoAps']);
//            $temp['NomEdoAps'] = utf8_encode($rs->fields['NomEdoAps']);
//            $temp['FecRec'] = utf8_encode($rs->fields['FecRec']);
//            $temp['FecEnv'] = utf8_encode($rs->fields['FecEnv']);
//            $temp['FecEnt'] = utf8_encode($rs->fields['FecEnt']);
//            $temp['idEmp'] = utf8_encode($rs->fields['idEmp']);
//            $temp['NomEmp'] = utf8_encode($rs->fields['NomEmp']);
//            $temp['ObsAps'] = utf8_encode($rs->fields['ObsAps']);
//            $temp['Iva'] = utf8_encode($rs->fields['Iva']);
//            $temp['Error'] = utf8_encode($rs->fields['Error']);
//            $temp['Finiquito'] = utf8_encode($rs->fields['Finiquito']);
//            $temp['AutPagCP'] = utf8_encode($rs->fields['AutPagCP']);
//            $temp['DesAfe'] = utf8_encode($rs->fields['DesAfe']);
//            $temp['SolAfe'] = utf8_encode($rs->fields['SolAfe']);
//            $temp['idTurAps'] = utf8_encode($rs->fields['idTurAps']);
//            $temp['idRelAps'] = utf8_encode($rs->fields['idRelAps']);
//            $temp['CveApsRel'] = utf8_encode($rs->fields['CveApsRel']);
//            array_push($data, $temp);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    public function getEstadoAp() {
//        global $cnx;
//        $query = "SELECT * FROM cEdoAps where idEdoAps<>0";
//        $rs = $cnx->Execute($query);
//        $data = array();
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }
//
//    
//
//    public function actualizaAp($principal) {
//
//        global $cnx;
//        foreach ($principal as $key) {
//            $FecRec = $key['FecRec'] != "" ? "'" . date('Y-m-d', strtotime($key['FecRec'])) . "'" : 'Null';
//            $FecEnt = $key['FecEnt'] != "" ? date('Y-m-d', strtotime($key['FecEnt'])) : 'Null';
//            $FecEnv = $key['FecEnv'] != "" ? date('Y-m-d', strtotime($key['FecEnv'])) : 'Null';
//            $query = "UPDATE pautpag set "
//                    . "idEdoAps=" . $key['idEdoAps'] . ","
//                    . "idTurAps=" . $key['idTurAps'] . ","
//                    . "idRelAps=" . $key['idRelAps'] . ","
//                    . "FecRec=" . $FecRec . ","
//                    . "FecEnv=" . $FecEnv . ","
//                    . "FecEnt=" . $FecEnv . ","
//                    . "PrmMod=" . $key['PrmMod'] . ","
//                    . "Finiquito=" . $key['Finiquito'] . ","
//                    . "AutPagCP=" . $key['AutPagCP'] . ","
//                    . "DesAfe=" . $key['DesAfe'] . ","
//                    . "SolAfe=" . $key['SolAfe'] . ","
//                    . "Error=" . $key['Error'] . ","
//                    . "ObsAps='" . utf8_decode($key['ObsAps']) . "' "
//                    . "WHERE idAps=" . $key['idAps'];
//            $rs = $cnx->Execute($query);
//        }
//        ChromePhp::log($query);
//
//        if ($rs) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    
//
//    //-------------------------------------------------------------------------------------------
//    //          FUNCIONES DE MÓDULO DE LISTADO
//    //-------------------------------------------------------------------------------------------
//
//    
