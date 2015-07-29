<?php
session_start();
include("../../../adodb/adodb.inc.php");
include ('../../cnxbds_ctrlUsuarios.php');

class Usuario {

    public function __destruct() {
        global $cnn;
        $cnn->Close();
    }

    public function getSistemas() {        
        global $cnn;
        $query = "select idsistema,descsistema from ".$_SESSION['dbNameCtrlUsuarios'].".cat_sistema";
        $rs = $cnn->Execute($query);
        if(!$rs){
            echo $cnn->ErrorMsg();
        }
        $arrayEjercicios = Array();
        while (!$rs->EOF) {
            array_push($arrayEjercicios, array("idsistema" => $rs->fields['idsistema'], "descsistema" => $rs->fields['descsistema']));
            $rs->movenext();
        }
        return $arrayEjercicios;
    }

    public function pushUser($form) {
        global $cnn;
        extract($form);
        //SE BUSCA QUE NO EXISTA EL USUARIO
        $query = "select idusu from ".$_SESSION['dbNameCtrlUsuarios'].".usuarios where upper(lgnusu) like upper('" . utf8_decode($lgnUser) . "')";
        $rs = $cnn->Execute($query);
        if (count($rs->fields) === 1) {
            //se procede a la insercion en la tabla usuarios
            $sistema = "";
            for ($i = 0; $i < count($sistUser); $i ++) {
                $sistema .= $sistUser[$i] . ",";
            }
            $sistema = trim($sistema, ",");
            $uniEje = isset($ueUser) ?  $ueUser : "0";
            $query = "insert into ".$_SESSION['dbNameCtrlUsuarios'].".usuarios(lgnusu, pwdusu, tpousu, nvlusu, dscusu, fechaCreacion, intentos, estatus, sistema, idUE, idRol) values('" . utf8_decode($lgnUser) . "', md5('" . utf8_decode($passUser) . "'), '" . utf8_decode($tipoUser) . "', '" . utf8_decode($nivelUser) . "', '" . utf8_decode($descUser) . "', now(), 0, 1, '" . utf8_decode($sistema) . "'," . utf8_decode($uniEje) . "," . utf8_decode($rolUser) . ")";
            //echo $query;
            $rs = $cnn->Execute($query);
            $idusu = $cnn->Insert_ID();
            //se procede a la insercion en la tabla infousuario
            $telUser = $telUser !== "" ? $telUser : '0';
            $extUser = $extUser !== "" ? $extUser : '0';
            $query = "insert into ".$_SESSION['dbNameCtrlUsuarios'].".infousuario(idusu, nombreUsu, aPaternoUsu, aMaternoUsu, emailUsu, telefonoUsu, extUsu) values(" . $idusu . ", '" . utf8_decode($nombreUser) . "', '" . utf8_decode($apPatUser) . "', '" . utf8_decode($apMatUser) . "', '" . utf8_decode($emailUser) . "', " . utf8_decode($telUser) . ", " . utf8_decode($extUser) . ")";
            $rs = $cnn->Execute($query);
            return array("idusu" => $idusu, "lgnusu" => $lgnUser, "sistemasusu" => $sistema);
        } else {
            return array("error" => "El usuario ya existe");
        }
    }

    public function findUserByLgnUser($lgnUser) {
        global $cnn;
        // se procede a la busqueda del usuario
        $query = "select * from ".$_SESSION['dbNameCtrlUsuarios'].".usuarios where lgnusu = '" . $lgnUser . "'";
        $rs = $cnn->Execute($query);
        if(!$rs){
            echo $cnn->ErrorMsg();
        }
        $usuario = null;
        while (!$rs->EOF) {
            $usuario["idusu"] = utf8_encode($rs->fields['idusu']);
            $usuario["lgnusu"] = utf8_encode($rs->fields['lgnusu']);
            $usuario["pwdusu"] = utf8_encode($rs->fields['pwdusu']);
            $usuario["tpousu"] = utf8_encode($rs->fields['tpousu']);
            $usuario["nvlusu"] = utf8_encode($rs->fields['nvlusu']);
            $usuario["dscusu"] = utf8_encode($rs->fields['dscusu']);
            $usuario["fechaCreacion"] = utf8_encode($rs->fields['fechaCreacion']);
            $usuario["intentos"] = utf8_encode($rs->fields['intentos']);
            $usuario["fechaUltimoIntento"] = utf8_encode($rs->fields['fechaUltimoIntento']);
            $usuario["estatus"] = utf8_encode($rs->fields['estatus']);
            $usuario["sistema"] = utf8_encode($rs->fields['sistema']);
            $usuario["idUE"] = utf8_encode($rs->fields['idUE']);
            $usuario["idRol"] = utf8_encode($rs->fields['idRol']);
            $rs->movenext();
        }
        if ($usuario !== null) {
            //busqueda de la informacion del usuario
            $query = "select * from ".$_SESSION['dbNameCtrlUsuarios'].".infousuario where idusu = '" . $usuario["idusu"] . "'";
            $rs = $cnn->Execute($query);
            while (!$rs->EOF) {
                $usuario["nombreUsu"] = utf8_encode($rs->fields['nombreUsu']);
                $usuario["aPaternoUsu"] = utf8_encode($rs->fields['aPaternoUsu']);
                $usuario["aMaternoUsu"] = utf8_encode($rs->fields['aMaternoUsu']);
                $usuario["emailUsu"] = utf8_encode($rs->fields['emailUsu']);
                $usuario["telefonoUsu"] = utf8_encode($rs->fields['telefonoUsu']);
                $usuario["extUsu"] = utf8_encode($rs->fields['extUsu']);
                $rs->movenext();
            }
        }
        return $usuario;
    }

    public function updateUser($form) {
        global $cnn;
        extract($form);
        $sistema = "";
        for ($i = 0; $i < count($sistUser); $i ++) {
            $sistema .= $sistUser[$i] . ",";
        }
        $sistema = trim($sistema, ",");
        $uniEje = isset($ueUser) ?  $ueUser : "0";
        //se procede a la actualizacion de la tabla usuarios
        $query = "update ".$_SESSION['dbNameCtrlUsuarios'].".usuarios set lgnusu = '" . utf8_decode($lgnUser) . "', pwdusu = md5('" . utf8_decode($passUser) . "'), tpousu = '" . utf8_decode($tipoUser) . "', nvlusu = '" . utf8_decode($nivelUser) . "', dscusu = '" . utf8_decode($descUser) . "', sistema =  '" . utf8_decode($sistema) . "', idUE = " . utf8_decode($uniEje) . ", idRol = " . utf8_decode($rolUser) . " where idusu = " . $idUser;
        $rs = $cnn->Execute($query);
        $idusu = $idUser;
        //se procede a la actualizacion en la tabla infousuario
        $telUser = $telUser !== "" ? $telUser : '0';
        $extUser = $extUser !== "" ? $extUser : '0';
        $query = "update ".$_SESSION['dbNameCtrlUsuarios'].".infousuario set nombreUsu = '" . utf8_decode($nombreUser) . "', aPaternoUsu = '" . utf8_decode($apPatUser) . "', aMaternoUsu = '" . utf8_decode($apMatUser) . "', emailUsu = '" . utf8_decode($emailUser) . "', telefonoUsu = " . utf8_decode($telUser) . ", extUsu = " . utf8_decode($extUser) . " where idusu = " . $idusu;
        $rs = $cnn->Execute($query);
        if ($cnn->Affected_Rows() === 0){            
            $query = "insert into ".$_SESSION['dbNameCtrlUsuarios'].".infousuario(idusu, nombreUsu, aPaternoUsu, aMaternoUsu, emailUsu, telefonoUsu, extUsu) values(" . $idusu . ", '" . utf8_decode($nombreUser) . "', '" . utf8_decode($apPatUser) . "', '" . utf8_decode($apMatUser) . "', '" . utf8_decode($emailUser) . "', " . utf8_decode($telUser) . ", " . utf8_decode($extUser) . ")";
            $rs = $cnn->Execute($query);
        }
        return array("idusu" => $idusu, "lgnusu" => $lgnUser, "sistemasusu" => $sistema);
    }

    public function inhabilitaUser($idusu) {
        global $cnn;
        $query = "update ".$_SESSION['dbNameCtrlUsuarios'].".usuarios set estatus = 0 where idusu = " . $idusu;
        $rs = $cnn->Execute($query);
        return array("idusu" => $idusu);
    }

    public function habilitaUser($idusu) {
        global $cnn;
        $query = "update ".$_SESSION['dbNameCtrlUsuarios'].".usuarios set estatus = 1 where idusu = " . $idusu;
        $rs = $cnn->Execute($query);
        return array("idusu" => $idusu);
    }

    public function getModulosSGI(){
        global $cnn;        
        //se buscan los permisos actuales
        $query = "SELECT idMnu,Xi,Yi,modulo,submodulo,orden,link,etiqueta,sistema,ruta FROM ".$_SESSION['dbNameCtrlUsuarios'].".modulo_rutas where modulo in 
                    (select distinct(modulo) from ".$_SESSION['dbNameCtrlUsuarios'].".modulo_rutas where sistema = 2 and modulo > 0)
                    and ((Yi = 0 and submodulo = 0) or sistema = 2 or (sistema = 1 and link = 0))
                    order by modulo,submodulo,orden";
        $rs = $cnn->Execute($query);        
        $arrayPermisos = Array();
        while (!$rs->EOF) {
            array_push($arrayPermisos, array("idMnu" => $rs->fields['idMnu'], "Xi" => $rs->fields['Xi'], "Yi" => $rs->fields['Yi'],"modulo" => $rs->fields['modulo'],"submodulo" => $rs->fields['submodulo'],"orden" => $rs->fields['orden'],"link" => $rs->fields['link'],"etiqueta" => utf8_encode($rs->fields['etiqueta'])));
            $rs->movenext();
        }
        return $arrayPermisos;
    }
    
    public function pushPermisosSGIbyUser($formPermisos, $idusu) {
        global $cnn;
        extract($formPermisos);
        //se eliminan permisos actuales si es que existen
        $query = "delete from ".$_SESSION['dbNameCtrlUsuarios'].".relusuacc where idUsu = " . $idusu . " and idMnu in (select idMnu from ".$_SESSION['dbNameCtrlUsuarios'].".modulo_rutas where sistema = 2)";
        $rs = $cnn->Execute($query);
        // sql para dar de alta los permisos del usuario para el sistema sgi
        $query = "insert into ".$_SESSION['dbNameCtrlUsuarios'].".relusuacc(idUsu,idMnu,Xi,Yi,Acceso) values";
        if (isset($modulos)) {
            foreach ($modulos as $modulo) {
                list($idMnu,$xi, $yi) = split("-", $modulo);
                $query .= "(" . $idusu . ",".$idMnu."," . $xi . "," . $yi . ",1),";
            }
            $query = trim($query, ",");
            $rs = $cnn->Execute($query);
            if ($rs) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    
    public function getPermisosSGIByUser($idusu) {
        global $cnn;        
        //se buscan los permisos actuales
        $query = "select idMnu,Xi,Yi from ".$_SESSION['dbNameCtrlUsuarios'].".relusuacc where idUsu = " . $idusu;        
        $rs = $cnn->Execute($query);        
        $arrayPermisos = Array();
        while (!$rs->EOF) {
            array_push($arrayPermisos, array("idMnu" => $rs->fields['idMnu'], "Xi" => $rs->fields['Xi'],"Yi" => $rs->fields['Yi']));
            $rs->movenext();
        }        
        return $arrayPermisos;
    }
    
    public function getRoles() {
        global $cnn;        
        //se buscan los roles actuales
        $query = "select * from ".$_SESSION['dbNameCtrlUsuarios'].".cat_rol";        
        $rs = $cnn->Execute($query);        
        $array = Array();
        while (!$rs->EOF) {
            array_push($array, array("idRol" => $rs->fields['idRol'], "dscRol" => $rs->fields['dscRol']));
            $rs->movenext();
        }        
        return $array;
    }
    
}
