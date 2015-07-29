<?php

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class oficiosModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }

    public function getInfoSol($idSol) {
        global $cnx;
        $query = "  select * from psolicitud ps
                    left join catue using (IdUE)
                    left join catsector cs on cs.IdSec = ps.IdSec
                    left join ctipobr using (IdTipObr)
                    left join cmodeje using (IdModEje)
                    left join catsolpre using (IdSolPre)
                    where IdSol =  '" . $idSol . "'";
        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function getInfoSolFtes($idSol) {
        global $cnx;
        $query = "  select * from relsolfte rs
                    inner join catfte2015 cf USING (idFte)
                    where idSol =  '" . $idSol . "' 
                    order by rs.tipoFte ASC";
        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function getNumFtes($idSol) {
        global $cnx;
        $query = "  select count(idFte) ftes from relsolfte 
                    where idSol =  '" . $idSol . "'";
        $rs = $cnx->Execute($query);

        return $rs->fields['ftes'];
    }

    public function getInfoSolFtesParaOficio($idSol, $idTipSol, $idObr, $ejercicio) {
        global $cnx;
        $query = "SELECT 
                        *
                    FROM
                        relsolfte rs
                            INNER JOIN
                        catfte2015 cf USING (idFte)
                    WHERE
                        idSol = '" . $idSol . "'
                            AND idFte NOT IN (SELECT 
                                idFte
                            FROM
                                doficio
                            WHERE
                                IdObr = '" . $idObr . "'
                                    AND idOfi IN (SELECT 
                                        CveOfi
                                    FROM
                                        poficio
                                    WHERE
                                        IdSolPre = '" . $idTipSol . "' AND Ejercicio = '" . $ejercicio . "' and idEdoOfi <> 2))
                    ORDER BY rs.tipoFte ASC";
        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function getSolObra($idObra) {

        global $cnx;
        $query = "  select * from pobra where idObr =  '" . $idObra . "' limit 1";
        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function getFtesOfi($idOfi, $idObr) {
        global $cnx;
        $query = "  select idFte, montoFte, idObr from doficio "
                . " where idOfi='" . $idOfi . "' and idObr = '" . $idObr . "'";
        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function getMontoFteSol($idFte, $idSol) {
        global $cnx;
        $query = "  select * from relsolfte where idSol = '" . $idSol . "' and idFte = '" . $idFte . "'";
        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function getHistSolObra($idObra, $idSol) {
        global $cnx;
        $query = "  select IdSol from psolicitud 
                    Where IdObr = '" . $idObra . "' 
                    and IdSol!='" . $idSol . "' order by IdSol Desc";

        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

//    public function guardarOficio($idSol, $idFte, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idObr, $ejercicio, $tipImpOfi, $idusu, $idDep) {
//        global $cnx;
//
//        $nuevoOficio = "select  right(MAX(CveOfi), 4) FROM poficio
//                        Where Left(CveOfi, 2) = '" . substr($ejercicio, -2) . "'";
//        $resOfi = $cnx->Execute($nuevoOficio);
//
//        $fila = $this->resultAdoData($resOfi);
//        $row = end($fila);
//
//        $cve = ((int) $row[0] + 1);
//        $cve = substr($ejercicio, -2) . substr("000" . $cve, -4);
//
//        //if(empty($info['firma'])){
//        $fFirma = date('Y-m-d');
//        //}
//        //else{
//        //    $fFirma = $info['firma'];
//        //}
//        $dataSolpre = $this->getTipSol($idSol);
//        $idSolPre = 0;
//        if ($dataSolpre) {
//            $idSolPre = $dataSolpre[0]['IdSolPre'];
//        }
//        $query = "  INSERT INTO poficio (idEdoOfi, IdSolPre, idUsu, idDep, idFte, Ejercicio, idObr, CveOfi, FecOfi, tipImpOfi, TitOfi, AsuOfi, CcpOfi, PfjOfi, IniOfi, TatOfi, TxtOfi)
//                                VALUES  (3, " . (int) $idSolPre . ", " . (int) $idusu . ", " . (int) $idDep . ", " . (int) $idFte . ", " . (int) $ejercicio . ", " . (int) $idObr . ", '" . $cve . "', '" . $fFirma . "', '" . $tipImpOfi . "', '" . utf8_decode($titular) . "', '" . utf8_decode($asunto) . "', '" . utf8_decode($ccp) . "', '" . utf8_decode($prefijo) . "', '" . utf8_decode($refer) . "', '" . utf8_decode($tat) . "', '" . utf8_decode($texto) . "' )";
//
//        $cnx->Execute($query);
//
//        return $cve;
//    }

    public function guardarOficioMulObr($titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idSolPre, $ejercicio, $tipImpOfi, $idusu, $idDep) {
        global $cnx;

        $nuevoOficio = "select  right(MAX(CveOfi), 4) FROM poficio
                        Where Left(CveOfi, 2) = '" . substr($ejercicio, -2) . "'";
        $resOfi = $cnx->Execute($nuevoOficio);

        $fila = $this->resultAdoData($resOfi);
        $row = end($fila);

        $cve = ((int) $row[0] + 1);
        $cve = substr($ejercicio, -2) . substr("000" . $cve, -4);

        $fFirma = date('Y-m-d');

        $query = "  INSERT INTO poficio (idEdoOfi, IdSolPre, idUsu, idDep,  Ejercicio,  CveOfi, FecOfi, tipImpOfi, TitOfi, AsuOfi, CcpOfi, PfjOfi, IniOfi, TatOfi, TxtOfi)
                                VALUES  (3, " . (int) $idSolPre . ", " . (int) $idusu . ", " . (int) $idDep . ", " . (int) $ejercicio . ", '" . $cve . "', '" . $fFirma . "', '" . $tipImpOfi . "', '" . utf8_decode($titular) . "', '" . utf8_decode($asunto) . "', '" . utf8_decode($ccp) . "', '" . utf8_decode($prefijo) . "', '" . utf8_decode($refer) . "', '" . utf8_decode($tat) . "', '" . utf8_decode($texto) . "' )";

        $cnx->Execute($query);

        //return $cnx->Insert_ID();

        return $cve;
    }

    public function guardarDetOficio($idOfi, $idObr, $idFte = 0, $montoFte = 0) {
        global $cnx;

        $detOfi = "select  if(MAX(idDetOfi) IS NULL,0,MAX(idDetOfi)) FROM doficio";
        $resOfi = $cnx->Execute($detOfi);
        $fila = $this->resultAdoData($resOfi);
        $row = end($fila);
        $idDetOfi = $row[0] + 1;
        $query = "INSERT INTO doficio (idDetOfi, idFte, idObr, idOfi, montoFte,idSol) values (" . (int) $idDetOfi . ", " . (int) $idFte . ", " . (int) $idObr . ", " . (int) $idOfi . ", " . (float) $montoFte . ",(select VerExpTec from pobra where idObr = '".$idObr."' limit 1))";        
        $cnx->Execute($query);

        return $idDetOfi;
    }

    public function getTipSol($idSol) {
        global $cnx;
        $query = "  select IdSolPre from psolicitud where IdSol = '" . $idSol . "'";

        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function guardarFechaFirma($fechaFirma, $cveOfi) {
        global $cnx;

        $query = "  update poficio set FecFir = '" . $fechaFirma . "' Where CveOfi = '" . $cveOfi . "'";

        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function guardarStatusOficio($idEdoOfi, $cveOfi) {
        global $cnx;

        $query = "  update poficio set idEdoOFi = '" . $idEdoOfi . "' Where CveOfi = '" . $cveOfi . "'";

        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function getInfoOficio($cveOfi = "") {
        global $cnx;
        $query = "  select *,poficio.IdSolPre as tipoSol from poficio 
                    left join cedoofi using(idEdoOFi)
                    left join catsolpre using(IdSolPre)
                    left join pobra using (idObr)
                    left join psolicitud using (IdSol)
                    where CveOfi = '" . $cveOfi . "'
                    order by idOfi desc";
        if ($cveOfi == "") {
            $query = "  select * from poficio 
                    left join cedoofi using(idEdoOFi)
                    left join catsolpre using(IdSolPre)
                    left join pobra using (idObr)
                    left join psolicitud using (IdSol)                    
                    order by idOfi desc";
        }

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function validaCancelarOficio($cveOfi) {
        global $cnx;
        $query = "SELECT 
                        MontoEjercido
                    FROM
                        relsolfte
                    WHERE
                        IdSol IN (SELECT 
                                VerExpTec
                            FROM
                                pobra
                            WHERE
                                IdObr IN (SELECT 
                                        IdObr
                                    FROM
                                        doficio
                                    WHERE
                                        idOfi = '" . $cveOfi . "'))
                            AND idFte IN (SELECT 
                                idFte
                            FROM
                                doficio
                            WHERE
                                idOfi = '" . $cveOfi . "')";
        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;
        $data = true;
        if ($numRows > 0) {
            while (!$rs->EOF) {
                if ((int) $rs->fields['MontoEjercido'] > 0) {
                    $data = false;
                }
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function getInfoOficioLista($fecIni, $fecFin) {
        global $cnx;
        if ($fecIni == "" && $fecFin == "") {
//            $query = "select * from poficio 
//                    left join cedoofi using(idEdoOFi)
//                    left join catsolpre using(IdSolPre)
//                    left join pobra using (idObr)
//                    left join psolicitud using (IdSol) 
//                    order by idOfi desc";
            $query = "SELECT CveOfi, NomSolPre, pobra.IdSol, psolicitud.Ejercicio, doficio.idObr, NomObr, NomEdoOfi, DscFte
                    FROM poficio, cedoofi, pobra, doficio, psolicitud, catsolpre, catfte2015
                    WHERE cedoofi.idEdoOFi = poficio.idEdoOFi
                    AND pobra.IdSol = psolicitud.IdSol
                    AND doficio.idObr = pobra.idObr
                    AND catsolpre.IdSolPre = poficio.IdSolPre
                    AND poficio.CveOfi = doficio.idOfi
                    AND catfte2015.idFte = doficio.idFte
                    ORDER BY poficio.idOfi DESC";
        } else {
            $query = "select * from poficio 
                    left join cedoofi using(idEdoOFi)
                    left join catsolpre using(IdSolPre)
                    left join pobra using (idObr)
                    left join psolicitud using (IdSol) 
                    where FecOfi BETWEEN '$fecIni' AND '$fecFin'
                    order by idOfi desc";
        }
        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function loadTemplate($ejercicio, $idSolPre, $idFte) {

        global $cnx;
        $query = "  select * from ctxtofi where Ejercicio = '" . $ejercicio . "' AND idTipOfi = '" . $idSolPre . "' AND idFte = '" . (int) $idFte . "'";

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $query2 = "  SELECT cs.*,
                            CASE CveSrv
                                WHEN 'gem' THEN 1
                                WHEN 'sfpa' THEN 2
                                WHEN 'scem' THEN 3
                                WHEN 'dgi' THEN 4
                                WHEN 'dgids' THEN 5
                                WHEN 'uaag' THEN 6
                                ELSE 7
                            END orden
                        FROM catsrvpub cs WHERE FecIni <= CURDATE() AND FecFin >= CURDATE() order by orden ASC";

            $rs2 = $cnx->Execute($query2);
            $data2 = '';
            while (!$rs2->EOF) {
                $data2.= ($rs2->fields['NomSrv'] . ' - ' . $rs2->fields['CarSrv'] . "\n");

                $rs2->movenext();
            }

            $data = array();
            while (!$rs->EOF) {
                $rs->fields['ccp'] = $data2;
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function catEjercicio() {
        global $cnx;
        $query = "  select * from catejercicio where Ejercicio!=0";

        $rs = $cnx->Execute($query);

        return $this->resultAdoData($rs);
    }

    public function catSolPre() {
        global $cnx;
        $query = "  select * from catsolpre";

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function buscarObra($ejercicio, $tipSol, $numObr) {
        global $cnx;
        if ($this->validaCreacionOficio($numObr, $tipSol, $ejercicio)) {
            $query = "select * from pobra PO
                    inner join psolicitud PS using (IdSol)
                    inner join catsolpre CS using (IdSolPre)
                    left join cmodeje cm using (IdModEje)
                    left join ctipobr ct using (IdTipObr)
                    left join relsolbco using (idSol)
                    where Ejercicio = '" . $ejercicio . "'
                    and IdSolPre = '" . $tipSol . "'
                    and IdEdoSol = '6'
                    and PO.idObr = '" . $numObr . "'
                    and (relsolbco.Status is null or relsolbco.Status = 6)";

            $rs = $cnx->Execute($query);

            $numRows = $rs->_numOfRows;

            if ($numRows > 0) {

                $data = array();
                while (!$rs->EOF) {
                    array_push($data, array_map('utf8_encode', $rs->fields));
                    $rs->movenext();
                }
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getInfoObra($idObr) {
        global $cnx;
        $query = "  select NomObr from psolicitud where idObr ='" . $idObr . "'";

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
                array_push($data, $rs->fields);
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function sumObrOfi($idOfi) {
        global $cnx;
        $query = "  select  idObr, sum(montoFte) sum from doficio 
                    where idOfi = '" . $idOfi . "'
                    group by idObr";

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, $rs->fields);
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function updateMontoObra($idObr, $monto) {
        global $cnx;

        $query = "  update pobra set MontoDisponible = '" . $monto . "' Where idObr = '" . $idObr . "'";

        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function updateMontoFteSol($idFte, $idSol, $monto) {
        global $cnx;

        $query = "  update relsolfte set disponible = '" . $monto . "' Where idFte = '" . $idFte . "' and idSol = '" . $idSol . "'";

        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function updateMontoConceptoFte($idFte, $idSol, $idEdoOfi) {
        global $cnx;
        if ($idEdoOfi === "1") {
            $query = "update relprefte set montoDisponible = (montoAutorizado-montoEjercido) where idFte = '" . $idFte . "' and idPresu in (select idPresu from ppresupuestoobra where IdSol =  '" . $idSol . "')";
        } else {
            $query = "update relprefte set montoDisponible = 0.00 where idFte = '" . $idFte . "' and idPresu in (select idPresu from ppresupuestoobra where IdSol =  '" . $idSol . "')";
        }
        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function getInfoFtes($fuentes) {
        $ftesIn = implode(',', $fuentes);
        global $cnx;
        $query = "  select * from catfte2015 where idFte IN (" . $ftesIn . ")";

        $rs = $cnx->Execute($query);

        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode', $rs->fields));
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function resultAdoData($rs) {
        $numRows = $rs->_numOfRows;

        if ($numRows > 0) {

            $data = array();
            while (!$rs->EOF) {
                array_push($data, $rs->fields);
                $rs->movenext();
            }
            return $data;
        } else {
            return false;
        }
    }

    public function validaCreacionOficio($idObr, $tipoSolicitud, $ejercicio) {
        global $cnx;
        $obras = trim($obras, ",");
        $query = "SELECT 
                        idOfi
                    FROM
                        doficio
                    WHERE
                        IdObr = '" . $idObr . "'
                            AND idOfi IN (SELECT
                                CveOfi
                            FROM
                                poficio
                            WHERE
                                IdSolPre = '" . $tipoSolicitud . "' AND Ejercicio = '" . $ejercicio . "' AND tipImpOfi LIKE 'general' AND idEdoOfi <> 2)";
        $rs = $cnx->Execute($query);
        $numRows = $rs->_numOfRows;
        if ($numRows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getEstatusOficio($cveOfi) {
        global $cnx;
        $query = "SELECT 
                        idEdoOfi
                    FROM
                        poficio
                    WHERE
                        CveOfi = '" . $cveOfi . "'";
        $rs = $cnx->Execute($query);
        return $rs->fields['idEdoOfi'];
    }

}
