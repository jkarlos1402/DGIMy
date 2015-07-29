<?php

include_once '../../libs/ChromePhp.php';
include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class ExpedienteTecnicoModel {

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }

//Funcion para llenado de acciones de gobierno federal hoja 1
    public function accionesFed() {

        global $cnx;
        $query = "SELECT idacu, cveacu, nomacu "
                . "FROM catacuerdo WHERE idtipacu = 4 ORDER BY cveacu";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de acciones de gobierno estatal hoja 1
    public function accionesEst() {

        global $cnx;
        $query = "SELECT idacu, cveacu, nomacu "
                . "FROM catacuerdo WHERE idtipacu = 1 OR idtipacu = 2 ORDER BY cveacu";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para conocer si es usuario global hoja 1
    public function usuarioUni($usuario) {
        global $cnx;
        $query = "SELECT distinct acceso FROM ".$_SESSION['dbNameCtrlUsuarios'].".relusuacc 
                WHERE idusu = -(SELECT idusu FROM ".$_SESSION['dbNameCtrlUsuarios'].".usuarios WHERE lgnusu = '" . $usuario . "')
                AND idmnu = -3
                AND acceso = 1";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields['acceso']);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de unidad ejecutora dependencia normal hoja 1
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

//Funcion para llenado de unidad responsable dependencia normal hoja 1
    public function unidadResponsable($idue) {

        global $cnx;
        $query = "SELECT a.nomsec as ur FROM catsector a, catue b WHERE a.idsec = b.idsec AND b.idue = $idue";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['ur'] = utf8_encode($rs->fields['ur']);
            array_push($data, $rs->fields['ur']);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de unidad ejecutora dependencia global hoja 1
    public function comboUnidadEjecutora() {

        global $cnx;
        $query = "SELECT idue, nomue FROM catue WHERE idue > 0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de unidad responsable dependencia global hoja 1
    public function comboUnidadResponsable() {

        global $cnx;
        $query = "SELECT idsec, nomsec FROM catsector WHERE idsec > 0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de ejercicio    
    public function comboEjercicio() {
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

//Funcion para llenado de solicitud de presupuesto   
    public function comboSolPre() {
        global $cnx;
        $query = "SELECT idsolpre, nomsolpre FROM catsolpre WHERE idsolpre IN (1,3,8,9,10,11,13)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funcion para llenado de modalidad de ejecucion    
    public function comboModEje() {
        global $cnx;
        $query = "SELECT idmodeje, nommodeje FROM cmodeje WHERE idmodeje IN(2,3)";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de tipo de obra    
    public function comboTipObr() {
        global $cnx;
        $query = "SELECT idtipobr, nomtipobr FROM ctipobr WHERE idtipobr > 0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de fuente federal   
    public function comboFteFed() {
        global $cnx;
        $query = "SELECT idFte, CveFte, DscFte FROM catfte2015 WHERE TipoFte = 'F'";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de fuente estatal   
    public function comboFteEst() {
        global $cnx;
        $query = "SELECT idFte, CveFte, DscFte FROM catfte2015 WHERE TipoFte = 'E'";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
//Funciones para llenado de fuente banco   
    public function comboFteBco() {
        global $cnx;
        $query = "SELECT idFteBco, NomFteBco FROM catftebco";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de grupo social  
    public function comboGpoSoc() {
        global $cnx;
        $query = "SELECT idgpo, Nomgpo FROM catgposoc";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de metas 
    public function comboMetas() {
        global $cnx;
        $query = "SELECT idmet,NomMet FROM catmeta WHERE idmet!=0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Funciones para llenado de beneficiarios 
    public function comboBeneficiarios() {
        global $cnx;
        $query = "SELECT idben,nomben FROM catbeneficiario WHERE idben>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function comboTipLoc() {
        global $cnx;
        $query = "SELECT * FROM ctiploc WHERE idTipLoc>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function removeConceptos($conceptos) {
        global $cnx;
        foreach ($conceptos as $concepto) {
            $sSql = "DELETE FROM ppresupuestoobra WHERE idPresu = $concepto";
            $rs = $cnx->Execute($sSql);
            $sSql2 = "DELETE FROM relprefte WHERE idPresu= $concepto";
            $rs2 = $cnx->Execute($sSql2);
        }
    }

    //funcion para el eliminado de programas de la hoja4
    public function removeProgramas($programas) {
        global $cnx;
        foreach ($programas as $programa) {
            $sSql = "DELETE FROM pprograma WHERE idprograma = $programa";
            $rs = $cnx->Execute($sSql);
        }
    }

   

    //HOJA 2
    public function consultarCoberturas() {
        global $cnx;
        $query = "SELECT IdCob, NomCob FROM catcobertura WHERE idCob>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function consultarTipLoc() {
        global $cnx;
        $query = "SELECT idTipLoc, NomTipLoc FROM ctiploc WHERE idTipLoc > 0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomTipLoc'] = utf8_encode($rs->fields['NomTipLoc']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function consultaRegMun() {
        global $cnx;
        $query = "SELECT IdCob, NomCob FROM catcobertura WHERE idCob>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function consultaRegiones() {
        global $cnx;
        $query = "SELECT IdReg, CveReg, NomReg FROM catregion WHERE idReg>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function consultaMunicipios() {
        global $cnx;
        $query = "SELECT * FROM catmunicipio WHERE idMun>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarUsuarioBanco($usuario) {
        global $cnx;
        $query = "SELECT distinct acceso FROM ".$_SESSION['dbNameCtrlUsuarios'].".relusuacc 
               WHERE idusu = -(SELECT idusu FROM ".$_SESSION['dbNameCtrlUsuarios'].".usuarios WHERE lgnusu = '" . $usuario . "')
               AND idmnu = -2
               AND acceso = 1";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarSolicitud($idSol, $idue) {
        global $cnx;
        $query = "SELECT * FROM psolicitud 
                LEFT JOIN catsector USING (idsec) 
                LEFT JOIN catue USING (idue) 
                WHERE idue = $idue
                AND idsol = " . $idSol;
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            $rs->fields['ObjOtrObs'] = utf8_encode($rs->fields['ObjOtrObs']);
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
            $rs->fields['FteMun'] = utf8_encode($rs->fields['FteMun']);
            $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
            $rs->fields['ObsCoo'] = utf8_encode($rs->fields['ObsCoo']);
            $rs->fields['ObsUE'] = utf8_encode($rs->fields['ObsUE']);
            $rs->fields['CriSoc'] = utf8_encode($rs->fields['CriSoc']);
            $rs->fields['DepNor'] = utf8_encode($rs->fields['DepNor']);
            $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarSolicitudArea($idSol, $idusu) {
        global $cnx;
        $query = "SELECT * FROM psolicitud 
                LEFT JOIN catsector USING (idsec) 
                LEFT JOIN catue USING (idue) 
                LEFT JOIN catsolpre USING (idsolpre)
                WHERE psolicitud.idsec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu)
                AND idsol = $idSol";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomSolPre'] = utf8_encode($rs->fields['NomSolPre']);
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            $rs->fields['ObjOtrObs'] = utf8_encode($rs->fields['ObjOtrObs']);
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
            $rs->fields['FteMun'] = utf8_encode($rs->fields['FteMun']);
            $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
            $rs->fields['ObsCoo'] = utf8_encode($rs->fields['ObsCoo']);
            $rs->fields['ObsUE'] = utf8_encode($rs->fields['ObsUE']);
            $rs->fields['CriSoc'] = utf8_encode($rs->fields['CriSoc']);
            $rs->fields['DepNor'] = utf8_encode($rs->fields['DepNor']);
            $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarAccionesEst($idSol) {
        global $cnx;
        $query = "SELECT 
                        cveacu, idacu, LEFT(nomacu, 50) AS nomacu
                    FROM
                        catacuerdo
                            left join
                        relacusol USING (idacu)
                    WHERE
                        idSol = " . $idSol . "
                            AND (idtipacu = 1 OR idtipacu = 2)
                    ORDER BY cveacu";
//        //ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {            
            array_push($data, array_map('utf8_decode',$rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function buscarAccionesFed($idSol) {
        global $cnx;
        $query = "SELECT 
                            cveacu, idacu, LEFT(nomacu, 60) AS nomacu
                    FROM
                        catacuerdo
                    left join relacusol using (idacu)
                    WHERE
                        idtipacu = 4
                            AND idsol = " . $idSol . "
                    ORDER BY cveacu";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $tmp['cveacu'] = utf8_encode($rs->fields['cveacu']);
            $tmp['idacu'] = utf8_encode($rs->fields['idacu']);
            $tmp['nomacu'] = utf8_encode($rs->fields['nomacu']);
            array_push($data, $tmp);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarAcuSolicitud($idSol) {
        global $cnx;
        $query = "select * from relacusol where idSol =" . $idSol;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarMunSolicitud($idSol) {
        global $cnx;
//        $query = "select * from relmunsol where idSol =".$idSol;
        $query = "SELECT r.idsol,c.idmun,c.nommun FROM relmunsol r, catmunicipio c WHERE  r.idmun=c.idmun AND r.idsol=$idSol AND c.idmun>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nommun'] = utf8_encode($rs->fields['nommun']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarRegSolicitud($idSol) {
        global $cnx;
//        $query = "select * from relregsol where idSol =".$idSol;
        $query = "SELECT r.idsol,c.idreg,c.cvereg,c.nomreg FROM relregsol r, catregion c WHERE  r.idreg=c.idreg AND r.idsol=$idSol AND c.idreg>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['nomreg'] = utf8_encode($rs->fields['nomreg']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

   
  

    public function getModAdjCont() {
        global $cnx;
        $query = "select * from cmodadjcontr";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["dscmod"] = utf8_encode($rs->fields["dscmod"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getTipObrCont() {
        global $cnx;
        $query = "select * from ctipobrcontr";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["dsctipo"] = utf8_encode($rs->fields["dsctipo"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Buscar id, tipo, monto y porcentajes de fuentes fed
    public function buscarFuentesFed($idSol) {
        global $cnx;
//        $query = "SELECT a.idFte as idFte, a.monto, a.pjeInv, a.disponible, CONCAT(b.CveFte, b.DscFte)AS nombre, a.cuenta FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 1 and a.idFte = b.idFte";
        $query = "SELECT a.idFte as idFte, a.monto, a.pjeInv, a.disponible, b.DscFte AS nombre, a.cuenta FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 1 and a.idFte = b.idFte";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, array_map('utf8_decode',$rs->fields));
            $rs->movenext();
        }
        return $data;
    }

//Buscar id, tipo, monto y porcentajes de fuentes est
    public function buscarFuentesEst($idSol) {
        global $cnx;
//        $query = "SELECT a.idFte, a.monto, a.pjeInv, a.disponible, CONCAT(b.CveFte, b.DscFte)AS nombre, a.cuenta FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 2 AND a.idFte = b.idFte";
        $query = "SELECT a.idFte, a.monto, a.pjeInv, a.disponible, b.DscFte AS nombre, a.cuenta FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 2 AND a.idFte = b.idFte";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, array_map('utf8_decode',$rs->fields));
            $rs->movenext();
        }
        return $data;
    }

    public function getListadoSolicitudes($idue, $fecIni, $fecFin) {
        global $cnx;
        if($fecIni == "" && $fecFin == ""){
            $query = "SELECT idSol,NomSolPre,NomObr,NomEdo,idEdoSol,Reingreso,count(idEva) as NumObs FROM psolicitud
                        LEFT JOIN catedosol using(idEdoSol)
                        left join evaexp using(idSol)
                        left join catsolpre using(IdSolPre)
                        WHERE IdUE = " . $idue . "
                        GROUP BY idSol
                        ORDER BY idsol DESC ";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }else{
            $query = "SELECT idSol,NomSolPre,NomObr,NomEdo,idEdoSol,Reingreso,count(idEva) as NumObs FROM psolicitud
                        LEFT JOIN catedosol using(idEdoSol)
                        left join evaexp using(idSol)
                        left join catsolpre using(IdSolPre)
                        WHERE IdUE = " . $idue . " 
                        AND FecCap BETWEEN '".$fecIni."' AND '".$fecFin."'
                        GROUP BY idSol
                        ORDER BY idsol DESC ";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }
        
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            $rs->fields["NomSolPre"] = utf8_encode($rs->fields["NomSolPre"]);
            $rs->fields["NomEdo"] = utf8_encode($rs->fields["NomEdo"]);

            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getObservaciones($idSol) {
        global $cnx;
        $query = "SELECT * FROM evaexp WHERE idSol=" . $idSol . " "
                . "ORDER BY FecEva,idEva DESC ";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["ObsDgi"] = utf8_encode($rs->fields["ObsDgi"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function setEstatusSolicitud($idSol, $estado, $tipoFecha) {
        global $cnx;
        $query = "UPDATE psolicitud SET idEdoSol=" . $estado . "," . $tipoFecha . "=now() WHERE idSol=" . $idSol;
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
            if ($estado === "6") {
                $query = "UPDATE pcontrato SET estatus = '1' WHERE IdSol = '$idSol' AND estatus = '0'";
                $rs = $cnx->Execute($query);
            }
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function updateVersionSolicitud($idSol) {
        global $cnx;
        $query = "UPDATE pobra SET VerExpTec=" . $idSol . " WHERE IdSol=" . $idSol;
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function setObservaciones($idSol, $obs) {
        global $cnx;
        $query = "INSERT INTO evaexp (idsol,feceva,obsdgi) VALUES($idSol,now(),'" . utf8_decode($obs) . "')";
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function setReingreso($idSol, $val) {
        global $cnx;
        $query = "UPDATE psolicitud SET Reingreso=" . $val . " WHERE idSol=" . $idSol;
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

//Buscar idsol de banco
    public function buscarBanco($idBco) {
        global $cnx;
        $query = "SELECT IdSol FROM relsolbco
                LEFT JOIN movbco USING (idbco)
                WHERE IdBco = " . $idBco . "                 
                LIMIT 1";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['IdSol'];
        return $data;
    }

//Buscar id de banco
    public function buscarBancoSol($id) {
        global $cnx;
        $query = "SELECT IdBco FROM relsolbco WHERE IdSol = $id";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['IdBco'];
        return $data;
    }

    public function getObraSolicitud($idObr, $tipoSolicitud) {
        global $cnx;
        $condicion = "";
        switch ($tipoSolicitud) {
            case "2":
                $condicion = "1,9"; //SI ES AUTORIZACIÓN BUSCAR QUE LA SOLICITUD ANTERIOR SEA
                // ASIGANCION, ASIGNACION ADICIONAL
                break;
            case "12":
                $condicion = "3"; //SI ES AMPLIACION-AUTORIZACION QUE LA SOLICITUD SEA 
                // ASIGANCION DE AMPLIACION
                break;
            case "7":
                $condicion = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12"; //CANCELACION
                break;
            case "4": //SOLICITUD DE REDUCCIÓN
                $condicion = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12";
                break;
        }
        $query = "SELECT * FROM pobra
                    LEFT JOIN psolicitud USING(idSol)
                    LEFT JOIN catsector using (idsec)
                    LEFT JOIN catue using (idue) 
                    LEFT JOIN cmodeje using (idModEje) 
                    LEFT JOIN ctipobr using (idTipObr) 
                    WHERE pobra.idObr=" . $idObr . "
                    AND (idSolPre = " . $tipoSolicitud . " 
                    OR  (idSolPre in(" . $condicion . ") and idEdoSol = 6))";
//        ChromePhp::log($query);
        try {
            $data = array();
            $rs = $cnx->Execute($query);
            while (!$rs->EOF) {
                $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
                $rs->fields['ObjOtrObs'] = utf8_encode($rs->fields['ObjOtrObs']);
                $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
                $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
                $rs->fields['FteMun'] = utf8_encode($rs->fields['FteMun']);
                $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
                $rs->fields['ObsCoo'] = utf8_encode($rs->fields['ObsCoo']);
                $rs->fields['ObsUE'] = utf8_encode($rs->fields['ObsUE']);
                $rs->fields['CriSoc'] = utf8_encode($rs->fields['CriSoc']);
                $rs->fields['DepNor'] = utf8_encode($rs->fields['DepNor']);
                $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
                $rs->fields['NomModEje'] = utf8_encode($rs->fields['NomModEje']);
                array_push($data, $rs->fields);
                $rs->movenext();
            }
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function obtenerTurnos() {
        global $cnx;
        $query = "SELECT idTurExp FROM psolicitud
                ORDER BY idTurExp DESC 
                LIMIT 1";
        $rs = $cnx->Execute($query);
        while (!$rs->EOF) {
            $data = (int) $rs->fields['idTurExp'] + 1;
            $rs->movenext();
        }
        return $data;
    }

    public function registraTurno($turno, $area, $fecha) {
        global $cnx;
        $query = "INSERT INTO pexptur(idTurExp,idDir,idUsu,FecTur) "
                . "VALUES(" . $turno . "," . $area . "," . $_SESSION['USERID'] . ",'" . date('Y-m-d', strtotime($fecha)) . "')";
        try {
            $rs = $cnx->Execute($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

//    public function catalogoAreas() {
//        global $cnx;
//        
//        $query = "SELECT nomdir FROM psolicitud p LEFT JOIN catsector s ON p.idsec=s.idsec 
//				LEFT JOIN cdepto d ON s.iddpt=d.iddpt 
//				LEFT JOIN carea a ON d.iddir=a.iddir where idsol=" . $idsol . "";
//        ChromePhp::log($query);
//        $rs = $cnx->Execute($query);
//        while (!$rs->EOF) {
//            array_push($data, $rs->fields);
//            $rs->movenext();
//        }
//        return $data;
//    }

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

    public function getFolio() {
        global $cnx;
        $query = "select idsol,fecCap 
                    from psolicitud 
                    where fecCap = '" . date("Y-m-d") . "'
                    order by idsol DESC limit 1;";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $folio = $rs->fields['idsol'];
            $rs->movenext();
        }
        return $folio;
    }

    public function getExById($idSol) {
        global $cnx;
        $query = "SELECT *,idsol FROM psolicitud pag 
                        LEFT JOIN catsector sec ON sec.IdSec = pag.idSec
                        LEFT JOIN cdepto dpt ON dpt.idDpt = sec.IdDpt
                        LEFT JOIN carea AREA ON dpt.idDir = AREA.idDir
                        LEFT JOIN catedosol edo ON pag.idEdoSol = edo.idEdoSol
                    where pag.idSol like '" . $idSol . "' AND pag.idEdoSol=3";
        $rs = $cnx->Execute($query);
//        ChromePhp::log($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    //funcion para el guardado o actualizacion de la hoja1 del estudio socioeconomico
    public function guardadoHoja1EstSoc($post, $idue, $idur, $idusu) {
        global $cnx;
        //print_r($post);        
        //se procesan las opciones de factiiidades para crear los json a guardar en BD
        $data = array();
        foreach ($post as $key => $val) {
            if (stristr($key, 'fl_')) {
                $data['factibilidad_legal']['cu'][] = array($key => $val);
            }
            if (stristr($key, 'fa_')) {
                if (stristr($key, 'fa_us')) {
                    $data['factibilidad_ambiental']['uso_suelo'][] = array($key => $val);
                } elseif (stristr($key, 'fa_ia')) {
                    $data['factibilidad_ambiental']['impacto_ambiental'][] = array($key => $val);
                } elseif (stristr($key, 'fa_ea')) {
                    $data['factibilidad_ambiental']['extensiones_avisos'][] = array($key => $val);
                }
            }
            if (stristr($key, 'ft_')) {
                $data['factibilidad_tecnica']['cu'][] = array($key => $val);
            }
        }
        $factLeg = json_encode($data['factibilidad_legal']);
        $factAmb = json_encode($data['factibilidad_ambiental']);
        $factTec = json_encode($data['factibilidad_tecnica']);

        extract($post);

//        $montoInversion = str_replace(",", "", $montoInversion);
//        $municipal = str_replace(",", "", $municipal);

        $montoInversion = str_replace(",", "", $montoInversion);
        $municipal = str_replace(",", "", $municipal);
        $montoInversion = ($montoInversion*1)-($municipal*1);
        
        //$solpre = $solpreval*1;
        //cuando el registro se va a hacer por primera vez
//        $idsol == "";
        if ($idsol == "") {

            if (isset($ue)) {
                $uE = $idue;
                $uR = $idur;
            }
            if (isset($ue2) && $ue2 != 0) {
                $uE = $ue2;
                $uR = $ur2;
            }
            if (isset($ue3) && $ue3 != 0) {
                $uE = $ue3;
                $uR = $ur3;
            }



            $IdEdoSol = 1;            
            
            $query = "INSERT INTO psolicitud (
                        Ejercicio, NomObr, IdUE, IdSec, Justifi, IdModEje, IdTipObr, Monto, MonMun, FteMun, 
                        PriCar, IdGpo, IdEdoSol, IdUsu, FactLeg, FactAmb, FactTec, 
                        IdMet, CanMet, IdBen, CanBen, DurAgs, DurMes, vidaPry
                    ) VALUES(
                        '" . ($ejercicio*1) . "', '" . utf8_decode($nomobra) . "', '" . ($uE*1) . "', '" . ($uR*1) . "', '" . utf8_decode($jusobr) . "', " . ($modalidad*1) . ", " . ($tipobr*1) . ", " . ($montoInversion*1) . ", " . ($municipal*1) . ", '" . utf8_decode($fmun) . "',
                        '" . utf8_decode($caract) . "', '" . ($grupoSocial)*1 . "', " . ($IdEdoSol*1) . ", ".($idusu*1)." , '" . $factLeg . "', '" . $factAmb . "', '" . $factTec . "', 
                        " . ($metas*1) . ", " . (str_replace(',', '', $textmetas)*1) . ", " . (int) $beneficiario . ", " . (str_replace(',','',$textbeneficiario)*1) . ", " . (int) $anios . ", " . (int) $meses . ", " . ($vidaPry*1) . "
                    )";

//            ChromePhp::log($query);
            $result = $cnx->GetRow($query);
            $noSol = $cnx->Insert_ID();

            $queryBco = "INSERT INTO relsolbco (IdSol, Status, FecReg) VALUES ( " . $noSol . ", 1, NOW())";
            $resultBco = $cnx->GetRow($queryBco);
            $idBco = $cnx->Insert_ID();


            if (isset($origen)) {
                foreach ($origen as $key => $value) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $value . ")";
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }

            if (isset($origen2)) {
                foreach ($origen2 as $key => $value) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $value . ")";
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }


            if (isset($federal)) {
                foreach ($federal as $key => $value) {
                    $value = str_replace(',', '', $value);
                    $queryffed = "INSERT INTO relsolfte (idSol, idFte, tipoFte, monto, pjeInv) VALUES
                                    (" . $noSol . "," . $ffed[$key] . ", 1," . $value . "," . (($value / $montoInversion) * 100) . ")";
                    $respffed = $cnx->GetRow($queryffed);
                }
            }

            if (isset($estatal)) {
                foreach ($estatal as $key => $value) {
                    $value = str_replace(',', '', $value);
                    $queryfest = "INSERT INTO relsolfte (idSol, idFte, tipoFte, monto, pjeInv) VALUES
                                    (" . $noSol . "," . $fest[$key] . ", 2," . $value . "," . (($value / $montoInversion) * 100) . ")";
                    $respfest = $cnx->GetRow($queryfest);
                }
            }
            /*
              if(isset($municipal) && $municipal>0){
              $value = str_replace(',', '', $municipal);
              $queryfest = "INSERT INTO relsolfte VALUES
              (".$noSol.",".$fmun.", 3,".$municipal.",".(($municipal/$montoInversion)*100).",".$montoInversion.")";
              $respfest = $cnx->GetRow($queryfest);
              } */

            $respuesta = array('noSol' => $noSol, 'idBco' => $idBco);
        } else {
            $noSol = $idsol;
            ## Revisar si estos campos tambien se actualizan Ejercicio, IdUe, IdEdoSol                     

            $modificacion = "UPDATE psolicitud SET   NomObr='" . utf8_decode($nomobra) . "',"
                    . "IdModEje=" . ($modalidad * 1) . ", IdTipObr=" . ($tipobr * 1) . ", PriCar='" . utf8_decode($caract) . "', IdGpo='" . ($grupoSocial*1) . "', "
                    . "Justifi='" . utf8_decode($jusobr) . "', CanMet=" . str_replace(',','',$textmetas) . ", CanBen=" .(str_replace(',','',$textbeneficiario)*1) . ","
                    . "IdMet=" . ($metas * 1) . ", IdBen=" . ($beneficiario * 1) . ", Monto=" . ($montoInversion * 1) . ","
                    . "FactLeg='" . $factLeg . "', FactAmb='" . $factAmb . "', FactTec='" . $factTec . "', "
                    . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", DurAgs=" . (int) $anios . ", DurMes=" . (int) $meses.", vidaPry=" .($vidaPry*1);

            $modificacion .= " WHERE IdSol=" . $idsol;
            $result = $cnx->GetRow($modificacion);

            $consultaacc = "DELETE FROM relacusol WHERE idsol=$idsol";
            $resconacc = $cnx->GetRow($consultaacc);

            if (isset($origen)) {
                foreach ($origen as $key => $value) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $value . ")";
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }

            if (isset($origen2)) {
                foreach ($origen2 as $key => $value) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $value . ")";
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }

            $cff = "DELETE FROM relsolfte WHERE idSol=$idsol ";

            $rescff = $cnx->GetRow($cff);

            if (isset($federal)) {
                foreach ($federal as $key => $value) {
                    $value = str_replace(',', '', $value);
                    $queryffed = "INSERT INTO relsolfte (idSol, idFte, tipoFte, monto, pjeInv) VALUES
                                    (" . $noSol . "," . $ffed[$key] . ", 1," . $value . "," . (($value / $montoInversion) * 100) . ")";
                    $respffed = $cnx->GetRow($queryffed);
                }
            }

            if (isset($estatal)) {
                foreach ($estatal as $key => $value) {
                    $value = str_replace(',', '', $value);
                    $queryfest = "INSERT INTO relsolfte (idSol, idFte, tipoFte, monto, pjeInv) VALUES
                                    (" . $noSol . "," . $fest[$key] . ", 2," . $value . "," . (($value / $montoInversion) * 100) . ")";
                    $respfest = $cnx->GetRow($queryfest);
                }
            }

            $respuesta = array('noSol' => $noSol, 'update' => true);
        }        

        return $respuesta;
    }

    public function guardadoHoja2EstSoc($post) {
        global $cnx;
        extract($post);

        if ($idsol != '') {
            if ($rut != "") {
                $ruta = "imagenes/" . $rut;
                $imgCondicion = ", Imagen='" . utf8_decode($ruta) . "'";
            } else {
                $imgCondicion = '';
            }

            $modificacion = "UPDATE psolicitud SET IdCob=" . (int) $tipoCobertura1 . ", idTipLoc=" . (int) $tipLoc . ", NomLoc='" . utf8_decode($inputEmail3) . "',
                            CooGeo=" . ($coor * 1) . ", ObsCoo='" . utf8_decode($obscoor) . "', LatIni=" . ($lat * 1) . ", "
                    . "LonIni=" . ($lon * 1) . ", LatFin=" . ($lat2 * 1) . ", LonFin=" . ($lon2 * 1) . " " . $imgCondicion . ", vidaPry=".($vidaPry*1);


            $modificacion .= " WHERE IdSol=" . $idsol;
            $result = $cnx->GetRow($modificacion);

            if (($tipoCobertura1 * 1) == 2) {
                if ($listcob != "") {
                    $lcob = explode(",", $listcob);

                    $delreg = "DELETE FROM relregsol WHERE idSol=$idsol";
                    $resdelreg = $cnx->GetRow($delreg);

                    foreach ($lcob as $region) {
                        $inreg = "INSERT INTO relregsol VALUES (" . $idsol . "," . $region . ")";
                        $resinreg = $cnx->GetRow($inreg);
                    }
                }
            } else {
                if (($tipoCobertura1 * 1) == 3) {
                    if ($listcob != "") {
                        $lcob = explode(",", $listcob);

                        $delmun = "DELETE FROM relmunsol WHERE idSol=$idsol";
                        $resdelmun = $cnx->GetRow($delmun);

                        foreach ($lcob as $municipio) {
                            $inmun = "INSERT INTO relmunsol VALUES (" . $idsol . "," . $municipio . ")";
                            $resinmun = $cnx->GetRow($inmun);
                        }
                    }
                }
            }
        }
        $respuesta = $idsol;

        return $respuesta;
    }

    public function getExpTById($idSol) {
        global $cnx;
        $query = "SELECT * from psolicitud WHERE idSol=" . $idSol . " ";
        $rs = $cnx->Execute($query);
        while (!$rs->EOF) {
            $data = $rs->fields["idSol"];
            $rs->movenext();
        }
        return $data;
    }

    public function cambiarEstado($idSol, $estado) {
        global $cnx;

        $query = "Update psolicitud set idEdosol=" . $estado . " WHERE idsol = " . $idSol . "";
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    public function getEstadoEx() {
        global $cnx;
        $query = "SELECT * FROM catedosol where idEdoSol<>0";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function updateExTurno($exps, $idSol) {
//        ChromePhp::log($ex);
        global $cnx;
        $query = "UPDATE psolicitud SET idEdoSol=4,idTurExp=" . $exps['idTurExp'] . ",idUsu=" . $_SESSION['USERID'] . ",FecRec='" . date('Y-m-d', strtotime($exps['FecRec'])) . "',ObsDGI='" . utf8_decode($exps['ObsDGI']) . "',FecAlt=now() WHERE idSol =" . $idSol . "";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
//        ChromePhp::log($rs);
        if ($rs) {
            $resp = array($exps['idTurExp'], $exps['FecRec']);
            return $resp;
        } else {
            return "Error";
        }
    }

    public function getDictamen($idSol) {
        global $cnx;
        $query = "select Status from relsolbco where idSol=" . $idSol;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function cloneExpedienteTecnico($idSol) {
        global $cnx;
        $query = "insert into psolicitud (EvaSoc,Ejercicio,IdSolPre,ObjEstSoc,ObjPryEje,ObjDerVia,ObjMIA,ObjObr,ObjAcc,ObjOtr,ObjOtrObs,IdUE,IdSec,IdObr,NomObr,IdModEje,IdTipObr,Monto,MonMun,FteMun,PriCar,IdCob,NomLoc,CooGeo,ObsCoo,LatIni,LonIni,LatFin,LonFin,Imagen,Ene,Feb,Mar,Abr,May,Jun,Jul,Ago,Sep,Oct,Nov,Dic,ObsUE,CriSoc,DepNor,Justifi,IdEdoSol,FecCap,IdBen,IdMet,CanMet,CanBen,FecMod,FecEnv,FecIng,FecEval) select EvaSoc,Ejercicio,IdSolPre,ObjEstSoc,ObjPryEje,ObjDerVia,ObjMIA,ObjObr,ObjAcc,ObjOtr,ObjOtrObs,IdUE,IdSec,IdObr,NomObr,IdModEje,IdTipObr,Monto,MonMun,FteMun,PriCar,IdCob,NomLoc,CooGeo,ObsCoo,LatIni,LonIni,LatFin,LonFin,Imagen,Ene,Feb,Mar,Abr,May,Jun,Jul,Ago,Sep,Oct,Nov,Dic,ObsUE,CriSoc,DepNor,Justifi,IdEdoSol,FecCap,IdBen,IdMet,CanMet,CanBen,FecMod,FecEnv,FecIng,FecEval,vidaPry from psolicitud where idSol=" . $idSol;
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = $cnx->Insert_ID();
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function cambiarTipoSolicitud($idSol, $idTipo) {
        global $cnx;
        $query = "Update psolicitud set IdSolPre=" . $idTipo . " ,IdEdoSol=2,FecMod=now(),FecEnv=null,FecIng=null,FecEval=null WHERE idsol = " . $idSol . "";
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function updateObraSol($idSolNew, $idObr) {
        global $cnx;
        $query = "Update pobra set IdSol=" . $idSolNew . " WHERE idObr = " . $idObr . "";
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

    public function updateConceptoContrato($idSolNew, $contratos) {
        foreach ($contratos as $value) {
            global $cnx;
            $query = "Update ppresupuestoobra set IdContrato=" . $value[1] . " WHERE idSol = " . $idSolNew . " AND IdContrato=" . $value[0];
//            ChromePhp::log($query);
            try {
                $rs = $cnx->Execute($query);
                $data = "ok";
            } catch (Exception $ex) {
                $data = $ex;
            }
        }

        return $data;
    }

    public function updateProgramaContrato($idSolNew, $contratos) {
        foreach ($contratos as $value) {
            global $cnx;
            $query = "Update pprograma set IdContrato=" . $value[1] . " WHERE idSol = " . $idSolNew . " AND IdContrato=" . $value[0];
//            ChromePhp::log($query);
            try {
                $rs = $cnx->Execute($query);
                $data = "ok";
            } catch (Exception $ex) {
                $data = $ex;
            }
        }

        return $data;
    }

    public function cloneRelAcuSol($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from relacusol where idSol =" . $idSolOld;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        foreach ($data as $value) {
            $query2 = "insert into relacusol values(" . $idSolNew . "," . $value["IdAcu"] . ")";
//           ChromePhp::log($query2);
            try {
                $rs = $cnx->Execute($query2);
                $data = $idSolNew;
            } catch (Exception $ex) {
                $data = $ex;
            }
        }
        return $data;
    }

    public function cloneRelSolFte($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from relsolfte where idSol =" . $idSolOld;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        foreach ($data as $value) {
            $query2 = "insert into relsolfte values(" . $idSolNew . "," . $value["idFte"] . "," . $value["tipoFte"] . "," . $value["monto"] . "," . $value["MontoAutorizado"] . "," . $value["MontoEjercido"] . "," . $value["pjeInv"] . "," . $value["disponible"] . "," . $value["cuenta"] . ")";
//           ChromePhp::log($query2);
            try {
                $rs = $cnx->Execute($query2);
                $data = $idSolNew;
            } catch (Exception $ex) {
                $data = $ex;
            }
        }
        return $data;
    }

    public function cloneConceptos($idSolOld, $idSolNew) {
        global $cnx;
        $query = "Select * from ppresupuestoobra where idSol=" . $idSolOld;
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
//        ChromePhp::log($data);
        foreach ($data as $value) {
            $query2 = "INSERT INTO ppresupuestoobra (IdSol,claveObj,concept"
                    . ",uniMedi,cantidad,precioUni"
                    . ",importe,iva,total,idContrato)"
                    . " VALUES (" . $idSolNew . ",'" . $value['claveObj'] . "','" . $value['concept'] . "'"
                    . ",'" . $value['uniMedi'] . "'," . $value['cantidad'] . "," . $value['precioUni'] . ""
                    . "," . $value['importe'] . "," . $value['iva'] . "," . $value['total'] . "," . $value['idContrato'] . ")";
//            ChromePhp::log($query2);
            try {
                $rs3 = $cnx->Execute($query2);
                $idPresu = $cnx->Insert_ID();
                $query3 = "Select * from relprefte where idPresu=" . $value['idPresu'];
//                ChromePhp::log($query3);
                $rs2 = $cnx->Execute($query3);
                $data2 = array();
                while (!$rs2->EOF) {
                    array_push($data2, $rs2->fields);
                    $rs2->movenext();
                }
                foreach ($data2 as $value2) {
                    $query4 = "INSERT INTO relprefte (idPresu,idFte,saldoEjercido,saldoDisponible) "
                            . "VALUES (" . $idPresu . "," . $value2['idFte'] . "," . $value2['saldoEjercido'] . "," . $value2['saldoDisponible'] . ")";
//                    ChromePhp::log($query4);
                    try {
                        $rs3 = $cnx->Execute($query4);
                    } catch (Exception $ex) {
                        $data = $ex;
                    }
                }
            } catch (Exception $ex) {
                $data = $ex;
            }
        }
    }

    public function cloneContratos($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from pcontrato where idSol =" . $idSolOld;
//         ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        $contratos = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        foreach ($data as $value) {
            $value['importeGarCump'] = ($value['importeGarCump'] == null) ? "0.00" : $value['importeGarCump'];
            $value['contratoPadre'] = ($value['contratoPadre'] == null) ? "0" : $value['contratoPadre'];
//            ChromePhp::log( $value['folioGarCump']);
//            ChromePhp::log( $value['importeGarCump']);
//            ChromePhp::log( $value['importeGarCump']);
            $query2 = "Insert into pcontrato (IdSol,numContra,fecCeleb,descrip,"
                    . "idEmp,idTipContr,idMod,monto,montoAutActual,montoEjercido,fecInicioContr,fecTerminoContr,"
                    . "diasCal,inmuDispo,motNoDisp,fecDisp,idTipObrContr,"
                    . "folioGar,fecEmisGar,importeGar,fecIniGar,fecFinGar,"
                    . "importeAnti,motivImporte,formaPagoAnti,"
                    . "folioGarCump,fecEmisGarCump,importeGarCump,fecIniGarCump,fecFinGarCump,"
                    . "avanceFinan,contratoPadre,estatus)"
                    . " values(" . $idSolNew . ",'" . $value['numContra'] . "','" . $value['fecCeleb'] . "','" . $value['descrip'] . "'"
                    . "," . $value['idEmp'] . "," . $value['idTipContr'] . "," . $value['idMod'] . "," . $value['monto'] . "," . $value['montoAutActual'] . "," . $value['montoEjercido'] . ",'" . $value['fecInicioContr'] . "','" . $value['fecTerminoContr'] . "'"
                    . "," . $value['diasCal'] . "," . $value['inmuDispo'] . ",'" . $value['motNoDisp'] . "','" . $value['fecDisp'] . "'," . $value['idTipObrContr'] . ""
                    . ",'" . $value['folioGar'] . "','" . $value['fecEmisGar'] . "'," . $value['importeGar'] . ",'" . $value['fecIniGar'] . "','" . $value['fecFinGar'] . "'"
                    . "," . $value['importeAnti'] . ",'" . $value['motivImporte'] . "','" . $value['formaPagoAnti'] . "'"
                    . ",'" . $value['folioGarCump'] . "',STR_TO_DATE( '" . $value['fecEmisGarCump'] . "', '%Y-%m-%d' )," . $value['importeGarCump'] . ",STR_TO_DATE( '" . $value['fecIniGarCump'] . "', '%Y-%m-%d' ),STR_TO_DATE( '" . $value['fecFinGarCump'] . "', '%Y-%m-%d' )"
                    . ",'" . $value['avanceFinan'] . "'," . $value['contratoPadre'] . "," . $value['estatus'] . ")";
//            ChromePhp::log($query2);
            try {
                $rs = $cnx->Execute($query2);
                array_push($contratos, array($value['idContrato'], $cnx->Insert_ID()));
            } catch (Exception $ex) {
                $contratos = $ex;
            }
        }
        return $contratos;
    }

    public function updateContratoPadre($idSolNew, $contratos) {
        foreach ($contratos as $value) {
            global $cnx;
            $query = "Update pcontrato set contratoPadre=" . $value[1] . " WHERE idSol = " . $idSolNew . " AND contratoPadre=" . $value[0];
//            ChromePhp::log($query);
            try {
                $rs = $cnx->Execute($query);
                $data = "ok";
            } catch (Exception $ex) {
                $data = $ex;
            }
        }
    }

    public function cloneProgramas($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from pprograma where idSol =" . $idSolOld;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        foreach ($data as $value) {
            $query2 = "Insert into pprograma (IdSol,priconcp,priene,prifeb,primar,priabr,primay,prijun,prijul,priago,prisep,prioct,prinov,pridic,pritotal,idContrato) VALUES  ($idSolNew,'" . $value['priconcp'] . "'," . $value['priene'] . "," . $value['prifeb'] . "," . $value['primar'] . "," . $value['priabr'] . "," . $value['primay'] . "," . $value['prijun'] . "," . $value['prijul'] . "," . $value['priago'] . "," . $value['prisep'] . "," . $value['prioct'] . "," . $value['prinov'] . "," . $value['pridic'] . "," . $value['pritotal'] . "," . $value['idContrato'] . ")";

//            ChromePhp::log($query2);
            try {
                $rs = $cnx->Execute($query2);
                $data = $idSolNew;
            } catch (Exception $ex) {
                $data = $ex;
            }
        }
        return $data;
    }

    public function getExById2($idSol) {
        global $cnx;
        $query = "Select idsol, idedosol, idturexp,fecalt,fecrec from psolicitud 
                where idSol like '" . $idSol . "'";
//        
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $temp['idSol'] = utf8_encode($rs->fields['idSol']);
            $temp['idEdoSol'] = utf8_encode($rs->fields['idEdoSol']);
            $temp['idTurExp'] = utf8_encode($rs->fields['idTurExp']);
            $temp['fecAlt'] = utf8_encode($rs->fields['fecAlt']);
            $temp['FecRec'] = utf8_encode($rs->fields['FecRec']);

            array_push($data, $temp);
            $rs->movenext();
        }
        return $data;
    }

    public function verificaAutorizacion($usuario, $pass) {
        global $cnx;
        $query = "SELECT permisoAut FROM ".$_SESSION['dbNameCtrlUsuarios'].".usuarios 
                WHERE lgnusu = '$usuario'
                AND pwdusu = md5('$pass')";
        $rs = $cnx->Execute($query);
        $permiso = "0";
        while (!$rs->EOF) {
            $permiso = $rs->fields["permisoAut"];
            $rs->movenext();
        }
        return $permiso;
    }

    public function getInfoSol($numBco) {

        global $cnx;
        $query = "  select * from relsolbco 
                    inner join psolicitud using(IdSol)
                    where idBco = " . $numBco;
        $rs = $cnx->Execute($query);
        $data = array();

        while (!$rs->EOF) {
            array_push($data, array_map('utf8_encode', $rs->fields));
            $rs->movenext();
        }
        return $data;
    }

//Buscar idsol de obra
    public function buscarObra($idObra) {
        global $cnx;
        $query = "SELECT IdSol FROM pobra where idObr=$idObra";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = $rs->fields['IdSol'];
        return $data;
    }

//Buscar id de banco
    public function buscarIdBanco($idSol) {
        global $cnx;
        $query = "SELECT idBco FROM relsolbco WHERE idsol =$idSol";
        $rs = $cnx->Execute($query);
        $data = $rs->fields['idBco'];
        return $data;
    }

//Buscar solicitud para Asignación de Ampliación
    public function buscarSol($idSol, $idue) {
        global $cnx;
        $query = "SELECT * FROM psolicitud 
                LEFT JOIN catsector USING (idsec) 
                LEFT JOIN catue USING (idue) 
                WHERE idsolpre IN (2, 10, 12, 13) 
                AND idedosol = 6 
                AND idue = $idue
                AND idsol = " . $idSol;
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomUE'] = utf8_encode($rs->fields['NomUE']);
            $rs->fields['ObjOtrObs'] = utf8_encode($rs->fields['ObjOtrObs']);
            $rs->fields['NomObr'] = utf8_encode($rs->fields['NomObr']);
            $rs->fields['PriCar'] = utf8_encode($rs->fields['PriCar']);
            $rs->fields['FteMun'] = utf8_encode($rs->fields['FteMun']);
            $rs->fields['NomLoc'] = utf8_encode($rs->fields['NomLoc']);
            $rs->fields['ObsCoo'] = utf8_encode($rs->fields['ObsCoo']);
            $rs->fields['ObsUE'] = utf8_encode($rs->fields['ObsUE']);
            $rs->fields['CriSoc'] = utf8_encode($rs->fields['CriSoc']);
            $rs->fields['DepNor'] = utf8_encode($rs->fields['DepNor']);
            $rs->fields['Justifi'] = utf8_encode($rs->fields['Justifi']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//funcion para la actualizacion de las fuentes para Asignación de Ampliación
    public function guardadoFuentes($post) {
        global $cnx;
        extract($post);

//        $montoInversion = str_replace(",", "", $montoInversion);
//        $municipal = str_replace(",", "", $municipal);
        
        $montoInversion = str_replace(",", "", $montoInversion);
        $municipal = str_replace(",", "", $municipal);
        $montoInversion = ($montoInversion*1)-($municipal*1);
        
        $hoy = date('Y-m-d');

        $modificacion = "UPDATE psolicitud SET Monto=" . ($montoInversion * 1) . ","
                . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", IdEdoSol = 2,"
                . "FecCap = STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' )";
        $modificacion .= " WHERE IdSol=" . $idsol;
        $result = $cnx->GetRow($modificacion);

        $porcenfed = explode(",", $porfed);

        $cff = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=1";
        $rescff = $cnx->GetRow($cff);

        for ($i = 0; $i < count($ffed); $i++) {
            if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                if ($fcta[$i] == "") {
                    $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta) "
                            . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ", null)";
                    $respffed = $cnx->GetRow($queryffed);
                } else {
                    $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta) "
                            . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . $fcta[$i] . ")";
                    $respffed = $cnx->GetRow($queryffed);
                }
            }
        }

        $porcenest = explode(",", $porest);

        $cfe = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=2";
        $rescfe = $cnx->GetRow($cfe);

        for ($j = 0; $j < count($fest); $j++) {
            if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                if ($ecta[$j] == "") {
                    $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta) "
                            . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ", null)";

                    $respfest = $cnx->GetRow($queryfest);
                } else {
                    $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta) "
                            . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . $ecta[$j] . ")";

                    $respfest = $cnx->GetRow($queryfest);
                }
            }
        }

        $respuesta = $idsol;

        return $respuesta;
    }

//Buscar montos federales
    public function buscarMontosFed($idObra) {
        global $cnx;
//        $query = "SELECT a.idFte, CONCAT(b.CveFte, ' ', b.DscFte) AS NomFte, a.monto AS MontoAsignado, 
//                a.MontoAutorizado as MontoAutorizado, (a.monto - a.MontoAutorizado) AS Disponible
//                FROM relsolfte a, catfte2015 b, pobra c
//                WHERE a.idFte = b.idFte
//                AND a.idsol = c.IdSol
//                AND a.tipofte = 1
//                AND c.idobr = $idObra";
        $query = "SELECT a.idFte, b.DscFte AS NomFte, a.monto AS MontoAsignado, 
                a.MontoAutorizado as MontoAutorizado, (a.monto - a.MontoAutorizado) AS Disponible
                FROM relsolfte a, catfte2015 b, pobra c
                WHERE a.idFte = b.idFte
                AND a.idsol = c.IdSol
                AND a.tipofte = 1
                AND c.idobr = $idObra";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomFte'] = utf8_encode($rs->fields['NomFte']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Buscar montos estatales
    public function buscarMontosEst($idObra) {
        global $cnx;
//        $query = "SELECT a.idFte, CONCAT(b.CveFte, ' ', b.DscFte) AS NomFte, a.monto AS MontoAsignado, 
//                a.MontoAutorizado as MontoAutorizado, (a.monto - a.MontoAutorizado) AS Disponible
//                FROM relsolfte a, catfte2015 b, pobra c
//                WHERE a.idFte = b.idFte
//                AND a.idsol = c.IdSol
//                AND a.tipofte = 2
//                AND c.idobr = $idObra";
        $query = "SELECT a.idFte, b.DscFte AS NomFte, a.monto AS MontoAsignado, 
                a.MontoAutorizado as MontoAutorizado, (a.monto - a.MontoAutorizado) AS Disponible
                FROM relsolfte a, catfte2015 b, pobra c
                WHERE a.idFte = b.idFte
                AND a.idsol = c.IdSol
                AND a.tipofte = 2
                AND c.idobr = $idObra";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['NomFte'] = utf8_encode($rs->fields['NomFte']);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function ExtracDatos($idSol) {
        global $cnx;
        $query = "SELECT ps.idSol, ue.nomUE, ev.nomSolPre
        FROM psolicitud AS ps INNER JOIN catsolpre ev ON ps.idsolpre = ev.idsolpre INNER JOIN catue ue ON ps.idue = ue.idue
        WHERE idSol like '" . $idSol . "'";

        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['idSol'] = utf8_encode($rs->fields['idSol']);
            $rs->fields['nomUE'] = utf8_encode($rs->fields['nomUE']);
            $rs->fields['nomSolPre'] = utf8_encode($rs->fields['nomSolPre']);

            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function ExtracDatos2($idSol) {
        global $cnx;

        $query = "SELECT ps.idsol, ps.ejercicio, ps.nomObr, ps.monto, ps.monmun, ue.nomUE, ev.nomSolPre, SUM(rsf.monto) AS montofed
        FROM psolicitud ps INNER JOIN catsolpre ev ON ps.idsolpre = ev.idsolpre INNER JOIN catue ue ON ps.idue = ue.idue
	INNER JOIN relsolfte rsf ON ps.idsol = rsf.idsol AND rsf.tipoFte=1
		WHERE    ps.idSol like '" . $idSol . "'";

//        $query = "SELECT ps.idsol, SUM(rsf.monto) AS montomun
//        FROM psolicitud ps INNER JOIN relsolfte rsf ON ps.idsol = rsf.idsol AND rsf.tipoFte=2
//		WHERE ps.idSol like '" . $idSol . "'";


        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['idsol'] = utf8_encode($rs->fields['idsol']);
            $rs->fields['ejercicio'] = utf8_encode($rs->fields['ejercicio']);
            $rs->fields['nomObr'] = utf8_encode($rs->fields['nomObr']);
            $rs->fields['nomUE'] = utf8_encode($rs->fields['nomUE']);
            $rs->fields['nomSolPre'] = utf8_encode($rs->fields['nomSolPre']);
            $rs->fields['monto'] = utf8_encode($rs->fields['monto']);
            $rs->fields['montofed'] = utf8_encode($rs->fields['montofed']);
            $rs->fields['monest'] = utf8_encode($rs->fields['monest']);
            $rs->fields['monmun'] = utf8_encode($rs->fields['monmun']);


            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function ExtracDatos3($idSol) {
        global $cnx;

        $query = "SELECT ps.idsol, SUM(rsf.monto) AS monest
        FROM psolicitud ps INNER JOIN relsolfte rsf ON ps.idsol = rsf.idsol AND rsf.tipoFte=2
		WHERE ps.idSol like '" . $idSol . "'";

        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields['idsol'] = utf8_encode($rs->fields['idsol']);
            $rs->fields['monest'] = utf8_encode($rs->fields['monest']);

            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }


    
    public function consultarObras($idusu, $fecIni, $fecFin) {
        global $cnx;
        if($fecIni == "" && $fecFin == ""){
            $query = "SELECT COUNT(a.idobr) AS NumObr, a.idsol, a.idObr, b.MontoAsignado, a.NomObr
                    FROM psolicitud a, pobra b WHERE a.idobr = b.idobr 
                    AND a.IdSec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu) GROUP BY a.idobr";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }else{
            $query = "SELECT COUNT(a.idobr) AS NumObr, a.idsol, a.idObr, b.MontoAsignado, a.NomObr
                    FROM psolicitud a, pobra b WHERE a.idobr = b.idobr 
                    AND a.IdSec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu)"
                    . "AND b.FecReg BETWEEN '$fecIni' AND '$fecFin' GROUP BY a.idobr";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
    public function consultarObrasOficios($idusu, $fecIni, $fecFin) {
        global $cnx;
        if($fecIni == "" && $fecFin == ""){
            $query = "SELECT COUNT(c.idobr) AS NumObrOfi, b.idObr AS idObr, c.idUsu FROM pobra b, poficio c 
                    WHERE c.idobr = b.idobr AND c.IdUsu = $idusu GROUP BY b.idobr";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }else{
            $query = "SELECT COUNT(c.idobr) AS NumObrOfi, b.idObr AS idObr, c.idUsu FROM pobra b, poficio c 
                    WHERE c.idobr = b.idobr AND c.IdUsu = $idusu "
                    . "AND b.FecReg BETWEEN '$fecIni' AND '$fecFin' GROUP BY b.idobr";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        }
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
    public function solicitudesObras($idObr) {
        global $cnx;
        $query = "SELECT IdSol, NomSolPre, NomObr, Monto, NomEdo, IdObr FROM psolicitud
            LEFT JOIN catsolpre USING (IdSolPre)
            LEFT JOIN catedosol USING (IdEdoSol)
            WHERE idObr = $idObr ";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomSolPre"] = utf8_encode($rs->fields["NomSolPre"]);
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            $rs->fields["NomEdo"] = utf8_encode($rs->fields["NomEdo"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
    
    
    public function oficiosObras($idObr) {
        global $cnx;
        $query = "SELECT * FROM poficio 
                LEFT JOIN cedoofi USING(idEdoOFi)
                LEFT JOIN catsolpre USING(IdSolPre)
                LEFT JOIN pobra USING (idObr)
                LEFT JOIN psolicitud USING (IdSol) 
                WHERE poficio.idObr = $idObr
                ORDER BY idOfi DESC ";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomSolPre"] = utf8_encode($rs->fields["NomSolPre"]);
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            $rs->fields["NomEdoOfi"] = utf8_encode($rs->fields["NomEdoOfi"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }
    
    public function enviarDictaminar($idBco){
        global $cnx;
        $queryfirma = "INSERT INTO movbco (IdBco, fecMov, tipMov, obs, status)  VALUES
                                (" . $idBco . ", NOW(), 3, '', 'bloqueado')";
        $respfest = $cnx->GetRow($queryfirma);
        $queryfirma = "UPDATE relsolbco SET Status = 3 WHERE IdBco = '$idBco'";
        $respfest = $cnx->GetRow($queryfirma);
        
        return $respfest;

    }
}
