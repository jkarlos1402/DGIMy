<?php

include_once '../../libs/ChromePhp.php';
include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class ObraModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }

//Función para la búsqueda de la solicitud y validar que exista
    public function buscarSolicitud($idSol, $idusu) {
        global $cnx;
        $query = "SELECT * FROM psolicitud
                LEFT JOIN catsector USING (idsec)
                LEFT JOIN catue USING (idue)
                LEFT JOIN ctipobr USING (idtipobr)
                LEFT JOIN catcobertura USING (idcob)
                LEFT JOIN catgposoc USING (idgpo)
                LEFT JOIN cmodeje USING (idmodeje)
                LEFT JOIN catsolpre USING (idsolpre)
                WHERE IdEdoSol = 6
                AND (idObr= 0 OR idObr IS NULL)
                AND idsolpre IN (1,10, 11, 13)
                AND psolicitud.idsec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu)
                AND idsol = $idSol";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomTipObr'] = utf8_encode($rs->fields['NomTipObr']);
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
            $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
            $rs->fields['NomCob'] = utf8_encode($rs->fields['NomCob']);
            $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
            $rs->fields['NomSec'] = utf8_encode($rs->fields['NomSec']);
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            $rs->fields['NomGpo'] = utf8_encode($rs->fields['NomGpo']);
            $rs->fields['NomModEje'] = utf8_encode($rs->fields['NomModEje']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para la búsqueda de la solicitud y validar que exista
    public function buscarSolicitudObra($idSol, $idusu) {
        global $cnx;
        $query = "SELECT * FROM psolicitud
                LEFT JOIN catsector USING (idsec)
                LEFT JOIN catue USING (idue)
                LEFT JOIN ctipobr USING (idtipobr)
                LEFT JOIN catcobertura USING (idcob)
                LEFT JOIN catgposoc USING (idgpo)
                LEFT JOIN cmodeje USING (idmodeje)
                LEFT JOIN catsolpre USING (idsolpre)
                WHERE IdEdoSol = 6
                AND psolicitud.idsec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu)
                AND idsol = $idSol";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomTipObr'] = utf8_encode($rs->fields['NomTipObr']);
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
            $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
            $rs->fields['NomCob'] = utf8_encode($rs->fields['NomCob']);
            $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
            $rs->fields['NomSec'] = utf8_encode($rs->fields['NomSec']);
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            $rs->fields['NomGpo'] = utf8_encode($rs->fields['NomGpo']);
            $rs->fields['NomModEje'] = utf8_encode($rs->fields['NomModEje']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
            
//Función para la búsqueda del id de la solicitud por obra
    public function buscarObra($id) {
        global $cnx;
        $query = "SELECT IdSol FROM pobra where idObr=$id";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['IdSol'];
        return $data;
    }
    
//Función para buscar municipios
    public function buscarMunSolicitud($idSol) {
        global $cnx;
        $query = "SELECT r.idsol,c.idmun,c.nommun as NomMun FROM relmunsol r, catmunicipio c WHERE  r.idmun=c.idmun AND r.idsol=$idSol AND c.idmun>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomMun'] = utf8_encode($rs->fields['NomMun']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Función para buscar regiones
    public function buscarRegSolicitud($idSol) {
        global $cnx;
        $query = "SELECT r.idsol,c.idreg,c.cvereg,c.nomreg as NomReg FROM relregsol r, catregion c WHERE r.idreg=c.idreg AND r.idsol=$idSol AND c.idreg>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomReg'] = utf8_encode($rs->fields['NomReg']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Buscar id, monto y nombre de fuentes fed
    public function buscarFuentesFed($idSol) {
        global $cnx;
        $query = "SELECT a.idFte AS idFte, a.monto AS monto, b.DscFte AS nombre, a.cuenta AS cuenta
                FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 1 AND a.idFte = b.idFte";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Buscar id, monto y nombre de fuentes est
    public function buscarFuentesEst($idSol) {
        global $cnx;
        $query = "SELECT a.idFte as idFte, a.monto AS monto, b.DscFte AS nombre, a.cuenta AS cuenta
                FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 2 AND a.idFte = b.idFte";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para buscar programa
    public function buscarPrograma($ejercicio) {
        global $cnx;
        $query = "SELECT idPrg, CONCAT(CvePrg, ' ', DscPrg) AS nombre FROM catestprg "
                . "WHERE TpoPrg = 'P' AND Ejercicio = $ejercicio";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para buscar proyecto
    public function buscarProyecto($prg, $ejercicio) {
        global $cnx;
        $query = "SELECT idPrg, CONCAT(CvePrg, ' ', DscPrg) AS nombre FROM catestprg "
                . "WHERE Ejercicio = $ejercicio AND"
                . " idPrg IN (SELECT idPrgPry FROM relprgpry WHERE idPrgPrg = $prg)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para registrar obra
    public function guardarObra($post) {
        global $cnx;
        extract($post);
//        ChromePhp::log($post);
        $hoy = date('Y-m-d');
        $monto = str_replace(",", "", $costoObra);
        
        try {
            if($valsolpre == 1){
                $query = "INSERT INTO pobra(PryEP,VerExpTec, IdSol, MontoAsignado, FecReg, idClaPry) "
                    . "VALUES(".$pryObra.", ".$solicitudObra.",".$solicitudObra.",".$monto.", STR_TO_DATE('".utf8_decode($hoy)."','%Y-%m-%d'), ".$clapry.")";
//            ChromePhp::log($query);
                $result = $cnx->GetRow($query);
                $noSol = $cnx->Insert_ID();
            }else{
                if($valsolpre == 10){
                    $query = "INSERT INTO pobra(PryEP, VerExpTec, IdSol, MontoAsignado, MontoAutorizado, FecReg, idClaPry) "
                        . "VALUES(".$pryObra.", ".$solicitudObra.", ".$solicitudObra.",".$monto.",".$monto.", STR_TO_DATE('".utf8_decode($hoy)."','%Y-%m-%d'), ".$clapry.")";
                    $result = $cnx->GetRow($query);
                    $noSol = $cnx->Insert_ID();
                }else{
                    $query = "INSERT INTO pobra(PryEP, IdSol, MontoAsignado, MontoAutorizado, FecReg, idClaPry) "
                        . "VALUES(".$pryObra.", ".$solicitudObra.",".$monto.",".$monto.", STR_TO_DATE('".utf8_decode($hoy)."','%Y-%m-%d'), ".$clapry.")";
                    $result = $cnx->GetRow($query);
                    $noSol = $cnx->Insert_ID();
                }
            }

            $qupdate = "UPDATE psolicitud SET IdObr = $noSol WHERE IdSol = $solicitudObra";
            $rupdate = $cnx->GetRow($qupdate);
//            ChromePhp::log($qupdate);

            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] !== "0" && $ffed[$i] !== "" && $idfed[$i] !== "0" && $idfed[$i] !== "") {
                    $queryffed = "UPDATE relsolfte SET cuenta=".$ctafed[$i]." "
                            . "WHERE idSol=".$solicitudObra." "
                            . "AND tipoFte=1 "
                            . "AND idFte = ".$idfed[$i];
                    $respffed = $cnx->GetRow($queryffed);
//                    ChromePhp::log("federal");
//                    ChromePhp::log($queryffed);
                }
            }

            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] !== "0" && $fest[$j] !== "" && $idest[$j] !== "0" && $idest[$j] !== "") {
                    $queryfest = "UPDATE relsolfte SET cuenta=".$ctaest[$j]." "
                            . "WHERE idSol=".$solicitudObra." "
                            . "AND tipoFte=2 "
                            . "AND idFte = ".$idest[$j];
                    $respfest = $cnx->GetRow($queryfest);
//                    ChromePhp::log("estatal");
//                    ChromePhp::log($queryfest);
                }
            }
            
            $respuesta = $noSol;
            
        } catch (Exception $ex) {
            $respuesta = $ex;
        }
        return $respuesta;
    }
    
//Función para la búsqueda del id del proyecto
    public function buscarIdPry($id){
        global $cnx;
        $query = "SELECT PryEp FROM pobra WHERE idObr = $id";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['PryEp'];
        return $data;
    }
    
//Función para buscar programa
    public function buscarPrg($idproyecto) {
        global $cnx;
        $query = "SELECT CONCAT(CvePrg, ' ', DscPrg) AS nombre FROM catestprg WHERE TpoPrg = 'P' AND idPrg IN (SELECT idPrgPrg FROM relprgpry WHERE idPrgPry = $idproyecto)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para buscar proyecto
    public function buscarPry($id) {
        global $cnx;
        $query = "SELECT CONCAT(CvePrg, ' ', DscPrg) AS nombre FROM catestprg WHERE idPrg IN (SELECT PryEp FROM pobra WHERE idObr = $id)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nombre'] = utf8_encode($rs->fields['nombre']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para modificar obra
    public function modificarObra($post) {
        global $cnx;
        extract($post);
        
        try{
            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] !== "0" && $ffed[$i] !== "" && $idfed[$i] !== "0" && $idfed[$i] !== "") {
                    $queryffed = "UPDATE relsolfte SET cuenta=".$ctafed[$i]." "
                            . "WHERE idSol=".$valsol." "
                            . "AND tipoFte=1 "
                            . "AND idFte = ".$idfed[$i];
                    $respffed = $cnx->GetRow($queryffed);
//                    ChromePhp::log($queryffed);
                }
            }

            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] !== "0" && $fest[$j] !== "" && $idest[$j] !== "0" && $idest[$j] !== "") {
                    $queryfest = "UPDATE relsolfte SET cuenta=".$ctaest[$j]." "
                            . "WHERE idSol=".$valsol." "
                            . "AND tipoFte=2 "
                            . "AND idFte = ".$idest[$j];
                    $respfest = $cnx->GetRow($queryfest);
//                    ChromePhp::log($queryfest);
                }
            }

            $respuesta = $noObra;
            
        } catch (Exception $ex) {
            $respuesta = $ex;
        }
        
        return $respuesta;
    }
        
//Función para buscar clasificación de la obra
    public function buscarClaPry() {
        global $cnx;
        $query = "SELECT idClaObr, NomClaObr FROM cclaobr";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomClaObr'] = utf8_encode($rs->fields['NomClaObr']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Función para la búsqueda de la clasificación de la obra
    public function buscarObraClaObr($id) {
        global $cnx;
        $query = "SELECT idClaPry FROM pobra where idObr=$id";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['idClaPry'];
        return $data;
    }
}