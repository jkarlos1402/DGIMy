<?php

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class BancoModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        //$cnx->Close();
    }

    public function getInfoBancoSol($rolUsu, $idUsu) {
        $filtroUsu = "";
        if ($rolUsu !== "2") {
            $filtroUsu = " and psolicitud.IdSec in (select idSec from rususec where idUsu = '" . $idUsu . "') ";
        }
        global $cnx;
        $query = "  select IdBco, IdSol, NomObr, Monto, NomUE, NumDictamen, relsolbco.Status AS NumStatus,  
                    CASE relsolbco.Status
                    WHEN 2 THEN 'Revisado'
                    WHEN 3 THEN 'En revisión'
                    WHEN 4 THEN 'En revisión'
                    WHEN 5 THEN 'En revisión'
                    WHEN 6 THEN 'Aceptado'
                    WHEN 7 THEN 'Cancelado'
                    END AS Status
                    from relsolbco
                    inner join psolicitud using(IdSol) 
                    inner join movbco using(IdBco)
                    inner join catue using(IdUE)
                    where relsolbco.Status IN (2, 3, 4, 5, 6, 7) 
                    " . $filtroUsu . "
                    group by idBco
                    order by IdBco DESC";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();

        while (!$rs->EOF) {
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function insertStatus($data) {
        global $cnx;
        if ($data['status'] == 7) {
            $status = "cancelado";
        } else if ($data['status'] == 10 || $data['status'] == 9 || $data['status'] == 5 || $data['status'] == 6 || $data['status'] == 3 || $data['status'] == 4) {
            $status = "bloqueado";
        } else {
            $status = "activo";
        }
        if ($data['status'] !== "5") {
            $query = "insert into movbco (IdBco, FecMov,tipMov,status) "
                    . " values (" . $data['idBco'] . ", NOW()," . $data['status'] . ", '" . $status . "')";
            $respfest = $cnx->Execute($query);
        }
        if ($data['status'] === "5" || $data['status'] === "2" || $data['status'] === "4") {
            $query = "UPDATE relsolbco set Status = '" . $data['status'] . "' WHERE IdBco = '" . $data['idBco'] . "'";
            $respfest = $cnx->Execute($query);
        }
        if ($data['status'] == "4") { //INGRESO FISICO
            $query = "UPDATE relsolbco set FecIng = STR_TO_DATE('" . $data['FecIng'] . "','%d-%m-%Y') WHERE IdBco = '" . $data['idBco'] . "'";
            $respfest = $cnx->Execute($query);
        }
        if ($data['status'] == "2") { //DEVOLUCION CON OBSERVACIONES, SE BORRA LA FECHA DE INGRESO FISICO
            $query = "UPDATE relsolbco set FecIng = NULL WHERE IdBco = '" . $data['idBco'] . "'";
            $respfest = $cnx->Execute($query);
        }
        return $respfest;
    }

    public function getInfoSol($idBco, $status) {
        global $cnx;
        $qry = "select *,DATE_FORMAT(relsolbco.FecIng, '%d-%m-%Y') as FecIngEstudio,DATE_FORMAT(relsolbco.FecReg, '%d-%m-%Y') as FecRegistro from relsolbco
                inner join movbco using (IdBco)
                inner join psolicitud using(IdSol)
                left join catsector using(IdSec)
                left join catue using (IdUE)
                where IdBco='" . $idBco
                . "' order by idmovbco desc limit 1";
        
        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function catTipEva() {

        global $cnx;
        $qry = "select * from cattipeva where IdTipEva >0 and Activo=1";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function catPPI() {
        global $cnx;
        $qry = "select * from catppi";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function getMontosFte($idSol, $tipFte) {
        global $cnx;
        $qry = "select *
                from relsolfte rsf
                left join catfte2015 using(idFte)
                where idSol=" . $idSol . "
                and rsf.tipoFte = " . $tipFte;

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function getCatPunto($idTipEva) {
        global $cnx;
        $qry = "select * from catPunto where IdTipEva=" . $idTipEva . " and Activo=1 order by NumCon ASC";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function getCatInciso($idPto) {
        global $cnx;
        $qry = "select * from catinciso where IdPto = " . $idPto . " and Activo=1 order by NumCon ASC";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function getSubInc($subInc) {
        global $cnx;
        $qry = "select * from catsubinc where IdInc = " . $subInc . " and Activo=1
                order by NumCon ASC";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function guardarEstSol($data, $idEva, $banderaNuevo) {
        global $cnx;
        if ($banderaNuevo) {
            $query = "insert into estsol (IdSol, IdEva, FecAce, IdTipInf, TasDes, VAN, TIR, TRI, VACPta, CAEPta, VACAlt, CAEAlt, obs) "
                    . "     values (" . (int) $data['IdSol'] . ", " . (int) $idEva . ", CURDATE()," . (int) $data['IdTipInf'] . ", '" . (float) $data['TasDes'] . "', " . (float) $data['VAN'] . ", " . (float) $data['TIR'] . ", " . (float) $data['TRI'] . ", " . (float) $data['VACPta'] . ", " . (float) $data['CAEPta'] . ", " . (float) $data['VACAlt'] . ", " . (float) $data['CAEAlt'] . ",'" . utf8_decode($data['Observaciones']) . "')";
//        ChromePhp::log($query);
            $res = $cnx->Execute($query);
        } else {
            $query = "update estsol set FecAce = CURDATE(),IdTipInf = " . (int) $data['IdTipInf'] . ",TasDes = '" . (float) $data['TasDes'] . "',VAN = " . (float) $data['VAN'] . ",TIR = " . (float) $data['TIR'] . ",TRI = " . (float) $data['TRI'] . ",VACPta = " . (float) $data['VACPta'] . ",CAEPta = " . (float) $data['CAEPta'] . ",VACAlt = " . (float) $data['VACAlt'] . ",CAEAlt = " . (float) $data['CAEAlt'] . ",obs = '" . utf8_decode($data['Observaciones']) . "'  WHERE IdSol = " . (int) $data['IdSol'] . " AND IdEva = " . (int) $idEva;
//        ChromePhp::log($query);
            $res = $cnx->Execute($query);
            $query = "select IdEst from estsol WHERE IdSol = " . (int) $data['IdSol'] . " AND IdEva = " . (int) $idEva;
//        ChromePhp::log($query);
            $res = $cnx->Execute($query);
            if (count($res->fields) === 1) {
                $query = "insert into estsol (IdSol, IdEva, FecAce, IdTipInf, TasDes, VAN, TIR, TRI, VACPta, CAEPta, VACAlt, CAEAlt, obs) "
                        . "     values (" . (int) $data['IdSol'] . ", " . (int) $idEva . ", CURDATE()," . (int) $data['IdTipInf'] . ", '" . (float) $data['TasDes'] . "', " . (float) $data['VAN'] . ", " . (float) $data['TIR'] . ", " . (float) $data['TRI'] . ", " . (float) $data['VACPta'] . ", " . (float) $data['CAEPta'] . ", " . (float) $data['VACAlt'] . ", " . (float) $data['CAEAlt'] . ",'" . utf8_decode($data['Observaciones']) . "')";
//        ChromePhp::log($query);
                $res = $cnx->Execute($query);
            }
        }
        return $res;
    }

    public function guardaDetEva($idSol, $observaciones, $banderaNuevo) {
        global $cnx;
        if ($banderaNuevo) {
            $maxEva = end($this->maxDetEva());
            $idEva = $maxEva['IdEva'];
            foreach ($observaciones as $obs) {
                $query = "insert into deteva (IdEva, IdSubInc, IdRsp, Observa,Pagina) 
                        VALUES (" . (int) $idEva . ", " . (int) $obs['IdSubInc'] . ", " . (int) $obs['IdRsp'] . ", '" . utf8_decode($obs['Observa']) . "','" . $obs['Pagina'] . "')";
//            ChromePhp::log($query);                
                $res = $cnx->Execute($query);
            }
        } else {
            $maxEva = end($this->currentDetEva($idSol));
            $idEva = $maxEva['IdEva'];
            if (!isset($idEva) || $idEva === "") {
                $maxEva = end($this->maxDetEva());
                $idEva = $maxEva['IdEva'];
                foreach ($observaciones as $obs) {
                    $query = "insert into deteva (IdEva, IdSubInc, IdRsp, Observa,Pagina) 
                        VALUES (" . (int) $idEva . ", " . (int) $obs['IdSubInc'] . ", " . (int) $obs['IdRsp'] . ", '" . utf8_decode($obs['Observa']) . "','" . $obs['Pagina'] . "')";
//            ChromePhp::log($query);
                    $res = $cnx->Execute($query);
                }
            } else {
                foreach ($observaciones as $obs) {
                    $query = "update deteva set IdRsp = " . (int) $obs['IdRsp'] . ",Observa = '" . utf8_decode($obs['Observa']) . "',Pagina = '" . $obs['Pagina'] . "' WHERE IdEva = " . $idEva . " AND IdSubInc = " . (int) $obs['IdSubInc'];
//            ChromePhp::log($query);
                    $res = $cnx->Execute($query);
                }
            }
        }
        return $idEva;
    }

    public function guardaTipEva($idSol, $idTipEva) {
        global $cnx;
        $query = "UPDATE psolicitud SET IdTipEva = '" . $idTipEva . "' WHERE IdSol = '" . $idSol . "'";
        $res = $cnx->Execute($query);
        return $res;
    }

    public function updateDictamen($idBco, $numDictamen) {
        global $cnx;
        $query = "UPDATE relsolbco SET NumDictamen = '" . $numDictamen . "', Status=6  WHERE IdBco = '" . $idBco . "'";
        $res = $cnx->Execute($query);
        return $res;
    }

    public function maxDictamen() {
        global $cnx;
        $maxDictamen = "select left(now(),4) Ejercicio, right(MAX(NumDictamen), 4) numDictamen FROM relsolbco 
                        Where Left(NumDictamen, 2) = right(left(NOW(), 4),2)";
        $resDic = $cnx->Execute($maxDictamen);

        $data = array();

        while (!$resDic->EOF) {
            array_push($data, $resDic->fields);
            $resDic->movenext();
        }
        $row = end($data);
        $cve = substr($row[0], -2) . substr("000" . (int) ($row[1] + 1), -4);
        return $cve;
    }

    public function maxDetEva() {

        global $cnx;
        $qry = "select MAX(IdEva)+1 as IdEva from deteva";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function currentDetEva($idSol) {

        global $cnx;
        $qry = "select IdEva from estsol where IdSol = '" . $idSol . "' order by IdEst desc limit 1";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function delDetEva($IdSol) {
        global $cnx;
        $query = "DELETE FROM deteva where IdEva IN (select IdEva from estsol where IdSol = '" . $IdSol . "')";
        $res = $cnx->Execute($query);

        $query2 = "DELETE FROM estsol where IdSol = '" . $IdSol . "'";
        $res2 = $cnx->Execute($query2);
    }

    public function existMovBco($idBco, $tipMov) {
        global $cnx;
        $qry = "select * from movbco where IdBco = " . $idBco . " and tipMov=" . $tipMov;

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastMovBco($idBco) {

        global $cnx;
        $qry = "select idmovbco,tipMov,DATE_FORMAT(fecMov, '%d-%m-%Y') fecMov,status from movbco where idBco = " . $idBco . " order by idmovbco DESC LIMIT 1";

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            $rs->fields['obs'] = utf8_encode($rs->fields['obs']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getEstSol($idSol) {
        global $cnx;
        $qry = "select IdEst,IdSol,IdEva,DATE_FORMAT(FecAce, '%d-%m-%Y') FecAce,IdTipInf,TasDes,VAN,TIR,TRI,VACPta,CAEPta,VACAlt,CAEAlt,obs from estsol where IdSol =  " . $idSol . " order by IdEva DESC";
        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            $rs->fields['obs'] = utf8_encode($rs->fields['obs']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getDetEva($idEva, $cond2 = "") {
        global $cnx;

        $qry = "select * from deteva 
                inner join catsubinc using (IdSubInc)
                where IdEva =   " . $idEva; // . "  and Observa != '' and Observa is not null";
//        if ($cond2 != "") {
//            $qry = "select * from deteva 
//                    inner join catsubinc using (IdSubInc)
//                    where IdEva =  " . $idEva . "  and ( (Observa != '' and Observa is not null) or ( IdRsp = 1))";
//        }

        $rs = $cnx->Execute($qry);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }

        return $data;
    }

    public function getEstatusBco($idBco) {
        global $cnx;

        $qry = "select Status from relsolbco                 
                where IdBco =   " . $idBco;

        $rs = $cnx->Execute($qry);
        $idStatus = "0";
        while (!$rs->EOF) {
            $data = $rs->fields['Status'];
            $rs->movenext();
        }
        return $data;
    }

    public function getInfoBcoFicha($idBco) {
        global $cnx;
        $qry = "SELECT 
                    IdSol,
                    IdBco,
                    DATE_FORMAT(FecReg, '%d-%m-%Y') FecReg,
                    NomObr,
                    psolicitud.IdSec,
                    NomSec,
                    IdUE,
                    NomUE,
                    Justifi,
                    PriCar,
                    DurAgs,
                    DurMes,
                    IdCob,
                    NomCob,
                    ObsCoo,
                    LatIni,
                    LonIni,
                    LatFin,
                    LonFin,
                    IdMet,
                    NomMet,
                    CanMet,
                    IdBen,
                    NomBen,
                    CanBen,
                    monto,
                    FteMun,
                    MonMun,
                    NomLoc,
                    vidaPry,
                    FactLeg,
                    FactAmb,
                    FactTec
                FROM
                    relsolbco
                        JOIN
                    psolicitud USING (IdSol)
                        JOIN
                    catsector USING (IdSec)
                        JOIN
                    catue USING (IdUE)
                        JOIN
                    catcobertura USING (IdCob)
                        JOIN
                    catmeta USING (IdMet)
                        JOIN
                    catbeneficiario USING (IdBen)
                WHERE
                    IdBco = '" . $idBco . "' limit 1";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = end($rs->GetArray());
        if ($data['IdCob'] === '2') {
            $data['regiones'] = $this->getRegionesSolEtiquetas($data['IdSol']);
        }else if($data['IdCob'] === '3'){
            $data['municipios'] = $this->getMunicipiosSolEtiquetas($data['IdSol']);
        }
        $data['fuentes'] = $this->getFuentesSolEtiquetas($data['IdSol']);
        $data['accionesF'] = $this->getAccionesF($data['IdSol']);
        $data['accionesE'] = $this->getAccionesE($data['IdSol']);
        return $data;
    }

    public function getRegionesSolEtiquetas($idSol) {
        global $cnx;

        $qry = "SELECT 
                    CveReg,NomReg
                FROM
                    relregsol
                        JOIN
                    catregion USING (IdReg)
                WHERE
                    IdSol = '" . $idSol . "'";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = $rs->GetArray();
        return $data;
        
    }
    public function getMunicipiosSolEtiquetas($idSol) {
        global $cnx;

        $qry = "SELECT 
                    CveFed,NomMun
                FROM
                    relmunsol
                        JOIN
                    catmunicipio USING (IdMun)
                WHERE
                    IdSol = '" . $idSol . "'";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = $rs->GetArray();
        return $data;        
    }

    public function getFuentesSolEtiquetas($idSol) {
        global $cnx;

        $qry = "SELECT 
                    idFte, monto, pjeInv, DscFte, catfte2015.TipoFte
                FROM
                    relsolfte
                        JOIN
                    catfte2015 USING (idFte)
                WHERE
                    IdSol = '" . $idSol . "'";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = $rs->GetArray();
        return $data;        
    }
    
    public function getAccionesF($idSol) {
        global $cnx;

        $qry = "SELECT 
                    IdAcu, CONCAT(CveAcu, ' ', NomAcu) AS NomAcu
                FROM
                    relacusol
                        JOIN
                    catacuerdo USING (IdAcu)
                WHERE
                    IdSol = '" . $idSol . "' AND IdTipAcu = 4";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = $rs->GetArray();
        return $data;        
    }
    
    public function getAccionesE($idSol) {
        global $cnx;

        $qry = "SELECT 
                    IdAcu, CONCAT(CveAcu, ' ', NomAcu) AS NomAcu
                FROM
                    relacusol
                        JOIN
                    catacuerdo USING (IdAcu)
                WHERE
                    IdSol = '" . $idSol . "' AND IdTipAcu IN (1, 2)";
        $rs = $cnx->Execute($qry);
        $data = array();
        $data = $rs->GetArray();
        return $data;        
    }
}
