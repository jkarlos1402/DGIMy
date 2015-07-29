<?php

include("../../../adodb/adodb.inc.php");
include ('../../../../inc/cnxbds_sgi.php');

class SGI {

    public function __destruct() {
        global $cnx;
        $cnx->Close();
    }

    public function getOrganizaciones() {
        global $cnx;
        $query = "select idOrg,CveOrg,DscOrg from ".$_SESSION['dbNameSGI'].".catestorg2015 where Estatus = 1 order by CveOrg asc";
        $rs = $cnx->Execute($query);
        $arrayOrganzaciones = Array();
        while (!$rs->EOF) {
            array_push($arrayOrganzaciones, array("idOrg" => $rs->fields['idOrg'], "CveOrg" => $rs->fields['CveOrg'], "DscOrg" => $rs->fields['DscOrg']));
            $rs->movenext();
        }
        return $arrayOrganzaciones;
    }

    public function getSectores() {
        global $cnx;
        $query = "select IdSec,NomSec from ".$_SESSION['dbNameSGI'].".catsector where IdSec > 0 order by NomSec asc";
        $rs = $cnx->Execute($query);
        $arraySectores = Array();
        while (!$rs->EOF) {
            array_push($arraySectores, array("IdSec" => $rs->fields['IdSec'], "NomSec" => $rs->fields['NomSec']));
            $rs->movenext();
        }
        return $arraySectores;
    }

    public function pushSectoresByUser($sectores, $idusu) {
        global $cnx;
        //se registran los sectores a los que pertenece el usuario registrado
        $query = "insert into ".$_SESSION['dbNameSGI'].".rususec(idUsu, idSec) values";
        for ($i = 0; $i < count($sectores); $i ++) {
            $query .= "(" . $idusu . ", " . $sectores[$i] . "),";
        }
        $query = trim($query, ",");
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    public function pushDependenciasByUser($dependencias, $idusu) {
        global $cnx;
        //se registran los sectores a los que pertenece el usuario registrado
        $query = "insert into ".$_SESSION['dbNameSGI'].".relusudep(idUsu, idOrg) values";
        for ($i = 0; $i < count($dependencias); $i ++) {
            $query .= "(" . $idusu . ", " . $dependencias[$i] . "),";
        }
        $query = trim($query, ",");
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    public function getDependenciasByIdUsu($idUsu) {
        global $cnx;
        $query = "select * from ".$_SESSION['dbNameSGI'].".relusudep where idUsu = '" . $idUsu . "'";
        $rs = $cnx->Execute($query);
        while (!$rs->EOF) {
            $dependencias.= utf8_encode($rs->fields['idOrg']) . ",";
            $rs->movenext();
        }
        $dependencias = trim($dependencias, ",");
        return $dependencias;
    }

    public function getSectoresByIdUsu($idUsu) {
        global $cnx;
        $query = "select * from ".$_SESSION['dbNameSGI'].".rususec where idUsu = '" . $idUsu . "'";
        $rs = $cnx->Execute($query);
        $sectores = "";
        while (!$rs->EOF) {
            $sectores.= utf8_encode($rs->fields['idSec']) . ",";
            $rs->movenext();
        }
        $sectores = trim($sectores, ",");
        return $sectores;
    }

    public function updateSectoresByUser($sectores, $idusu) {
        global $cnx;
        //se eliminan los sectores actuales 
        $query = "delete from ".$_SESSION['dbNameSGI'].".rususec where idUsu = " . $idusu;
        $rs = $cnx->Execute($query);
        //se registran los sectores a los que pertenece el usuario registrado
        $query = "insert into ".$_SESSION['dbNameSGI'].".rususec(idUsu, idSec) values";
        for ($i = 0; $i < count($sectores); $i ++) {
            $query .= "(" . $idusu . ", " . $sectores[$i] . "),";
        }
        $query = trim($query, ",");
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateDependenciasByUser($dependencias, $idusu) {
        global $cnx;
        //se eliminan las dependencias existentes
        $query = "delete from ".$_SESSION['dbNameSGI'].".relusudep where idUsu = ".$idusu;
        $rs = $cnx->Execute($query);
        //se registran los sectores a los que pertenece el usuario registrado
        $query = "insert into ".$_SESSION['dbNameSGI'].".relusudep(idUsu, idOrg) values";
        for ($i = 0; $i < count($dependencias); $i ++) {
            $query .= "(" . $idusu . ", " . $dependencias[$i] . "),";
        }
        $query = trim($query, ",");
        $rs = $cnx->Execute($query);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getUEs(){
         global $cnx;
        //query para seleccionar las unidades ejecutoras
        $query = "select IdUE,NomUE,IdSec from ".$_SESSION['dbNameSGI'].".catue where IdUE > 0";
        $rs = $cnx->Execute($query);
        $arrayUE = Array();
        while (!$rs->EOF) {
            array_push($arrayUE, array("IdUE" => $rs->fields['IdUE'], "NomUE" => $rs->fields['NomUE'],"IdSec" => $rs->fields['IdSec']));
            $rs->movenext();
        }
        return $arrayUE;
    }
}
