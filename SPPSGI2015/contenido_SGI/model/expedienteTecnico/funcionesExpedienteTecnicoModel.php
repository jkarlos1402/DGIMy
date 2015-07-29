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
        $query = "SELECT distinct acceso FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".relusuacc 
                WHERE idusu = -(SELECT idusu FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".usuarios WHERE lgnusu = '" . $usuario . "')
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
        $query = "SELECT NomUE FROM catue where idue=" . ($idue * 1);
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
        $query = "SELECT a.nomsec as ur FROM catsector a, catue b WHERE a.idsec = b.idsec AND b.idue =" . ($idue * 1);
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
        $query = "SELECT idsolpre, nomsolpre FROM catsolpre WHERE idsolpre IN (1,3,9,10,11,13)";
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
        $query = "SELECT idgpo, Nomgpo FROM catgposoc where idgpo!=0";
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

    //funcion para el eliminado de contratos de la hoja4
    public function removeContratos($contratos) {
        global $cnx;
        foreach ($contratos as $contrato) {
            for ($i = 0; $i < count($contrato["programas"]); $i++) {
                $sql = "DELETE FROM pprograma WHERE idPrograma = " . $contrato["programas"][$i];
                $rs = $cnx->Execute($sql);
            }
            $sSql = "DELETE FROM pcontrato WHERE idContrato = " . $contrato["idContrato"];
            $rs = $cnx->Execute($sSql);
        }
    }

    public function mergeConceptos($conceptos, $idSol, $pp, $relprefte, $modulo, $idSolPre) {
        global $cnx;
        $idConceptosAdd = array();
        $ind = 0;
        $index = 0;
        ChromePhp::log($conceptos);
        foreach ($conceptos as $concepto) {
            $id = $concepto[0];
            $claveObj = $concepto[1];
            $concept = $concepto[2];
            $uniMedi = $concepto[3];
            $cantidad = str_replace(",", "", $concepto[4]);
            $precioUni = str_replace(",", "", $concepto[5]);
            $import = str_replace(",", "", $concepto[6]);
            $iva = str_replace(",", "", $concepto[7]);
            $total = str_replace(",", "", $concepto[8]);
//            if ($pp) {
//                $idFte = explode(",", $concepto[9]);
//            } else {
//                $idFte = $concepto[9];
//            }
            $idContrato = $concepto[10];
//         ChromePhp::log($idSolPre);
            if ($id == "") { // ES CONCEPTO NUEVO
                $sSql = "INSERT INTO ppresupuestoobra (IdSol,claveObj,concept,uniMedi,cantidad,precioUni,importe,iva,total,idContrato) VALUES  (" . $idSol . ",'" . utf8_decode($claveObj) . "','" . utf8_decode($concept) . "','" . utf8_decode($uniMedi) . "'," . $cantidad . "," . $precioUni . "," . $import . "," . $iva . "," . $total . "," . $idContrato . ")";
//                ChromePhp::log($sSql);
                try {
                    $rs = $cnx->Execute($sSql);
                    $idPresu = $cnx->Insert_ID();
                    array_push($idConceptosAdd, array($cnx->Insert_ID(), $ind));
//                    ChromePhp::log($pp);

                    if ($modulo == "3" || $idSolPre == "10" || $idSolPre == "11" || $idSolPre == "13") {
                        if ($pp == "true") {
                            $delSql = "Delete from relprefte where idPresu=" . $idPresu;
                            $delrs = $cnx->Execute($delSql);
                            $tmpArray = $relprefte[$index];
                            foreach ($tmpArray as $datos) {
                                $sql2 = "INSERT INTO relprefte (idPresu,idFte,montoEjercido,montoAutorizado) VALUES (" . $idPresu . "," . $datos[0] . ",0.00," . $datos[2] . ")";
                                try {
                                    $rs2 = $cnx->Execute($sql2);
                                } catch (Exception $ex2) {
                                    
                                }
                            }
                        } else {
                            $delSql = "Delete from relprefte where idPresu=" . $idPresu;
                            $delrs = $cnx->Execute($delSql);
                            $tmpArray = $relprefte[$index][0];
//                       ChromePhp::log($tmpArray);
                            $sql2 = "INSERT INTO relprefte (idPresu,idFte,montoEjercido,montoAutorizado) VALUES (" . $idPresu . "," . $tmpArray[0] . ",0.00," . $tmpArray[2] . ")";
//                        ChromePhp::log($sql2);
                            try {
                                $rs2 = $cnx->Execute($sql2);
                            } catch (Exception $ex2) {
                                
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $idConceptosAdd = $ex;
                }
            } else { // ES ACTUALIZACION DE CONCEPTO
                if ($idSolPre != "4") { //DIFERENTE DE REDUCCION
                    $sSql = "UPDATE ppresupuestoobra  SET claveobj='" . utf8_decode($claveObj) . "',concept='" . utf8_decode($concept) . "',unimedi='" . utf8_decode($uniMedi) . "',cantidad=" . $cantidad . ",preciouni=" . $precioUni . ",importe=" . $import . ",iva=" . $iva . ",total=" . $total . ",idContrato=" . $idContrato . " WHERE idpresu=" . $id . "";
                    try {
                        $rs = $cnx->Execute($sSql);
                        if ($modulo == "3" || $idSolPre == "10" || $idSolPre == "11" || $idSolPre == "13") {
                            if ($pp == "true") {
//                                $delSql = "Delete from relprefte where idPresu=" . $id . "";
                                $delSql = "Delete from relprefte where idPresu=" . $id." and montoEjercido<>montoAutorizado";
                                $delrs = $cnx->Execute($delSql);
                                $tmpArray = $relprefte[$index];
//                            ChromePhp::log($relprefte[$index]);
                                $sqlVerif = "SELECT count(*) from relprefte where idPresu = $id"; // BUSCAMOS SI EL ID A INSERTAR NO FUE ELIMINADO
//                                ChromePhp::log($sqlVerif);
                                $rsVerif = $cnx->Execute($sqlVerif);
                                while (!$rsVerif->EOF) {
                                    if ($rsVerif->fields[0] == 0) {
                                        foreach ($tmpArray as $datos) {
//                                            ChromePhp::log($datos);
                                            $sql2 = "INSERT INTO relprefte (idPresu,idFte,montoEjercido,montoAutorizado) VALUES (" . $id . "," . $datos[0] . ",0.00," . $datos[2] . ")";
//                            ChromePhp::log($sql2);
                                            try {
                                                $rs2 = $cnx->Execute($sql2);
                                            } catch (Exception $ex2) {
                                                
                                            }
                                        }
                                    }
                                    $rsVerif->movenext();
                                }
                            } else {
                                $delSql = "Delete from relprefte where idPresu=" . $id;
                                $delrs = $cnx->Execute($delSql);
                                $tmpArray = $relprefte[$index][0];
//                      ChromePhp::log($tmpArray);
                                $sql2 = "INSERT INTO relprefte (idPresu,idFte,montoEjercido,montoAutorizado) VALUES (" . $id . "," . $tmpArray[0] . ",0.00," . $tmpArray[2] . ")";
//                        ChromePhp::log($sql2);
                                try {
                                    $rs2 = $cnx->Execute($sql2);
                                } catch (Exception $ex2) {
                                    
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $idConceptosAdd = $ex;
                    }
                } else { // SI ES REDUCCION
                    if ($concepto[13] > 0) {
                        $reduccion = str_replace(",", "", $concepto[13]);
                        $sSql = "UPDATE ppresupuestoobra  SET total=" . ($total - $reduccion) . " WHERE idpresu=" . $id . "";

                        try {
                            $rs = $cnx->Execute($sSql);
                            if ($pp == "true") {
                                $tmpArray = $relprefte[$index];
//                            ChromePhp::log($relprefte[$index]);
                                foreach ($tmpArray as $datos) {
                                    $sql2 = "UPDATE relprefte set montoAutorizado=" . ($datos[2] - $datos[1]) . " WHERE idPresu=" . $id . " AND idFte=" . $datos[0];
                                    try {
                                        $rs2 = $cnx->Execute($sql2);
                                    } catch (Exception $ex2) {
                                        
                                    }
                                }
                            } else {
                                $tmpArray = $relprefte[$index][0];
//                      ChromePhp::log($tmpArray);
                                $sql2 = "UPDATE relprefte set montoAutorizado=" . ($tmpArray[2] - $tmpArray[1]) . " WHERE idPresu=" . $id . " AND idFte=" . $tmpArray[0];
//                        ChromePhp::log($sql2);
                                try {
                                    $rs2 = $cnx->Execute($sql2);
                                } catch (Exception $ex2) {
                                    
                                }
                            }
                        } catch (Exception $ex) {
                            $idConceptosAdd = $ex;
                        }
                    }
                }
            }
            $index++;
            $ind++;
        }
        return $idConceptosAdd;
    }

    //funcion para el guardado o actualizacion de programas de la hoja4
    public function mergeProgramas($programas, $idsol, $idContrato) {
        global $cnx;
        $idProgramas = array();
        $i = 0;
        if ($idContrato === "") {
            if (is_array($programas)) {
                foreach ($programas as $programa) {
                    if ($programa[0] == "") {
                        $sSql = "Insert into pprograma (IdSol,priconcp,priene,prifeb,primar,priabr,primay,prijun,prijul,priago,prisep,prioct,prinov,pridic,pritotal) VALUES  ($idsol,'$programa[1]',$programa[2],$programa[3],$programa[4],$programa[5],$programa[6],$programa[7],$programa[8],$programa[9],$programa[10],$programa[11],$programa[12],$programa[13],$programa[14])";
//                //ChromePhp::log($sSql);
                        $rs = $cnx->Execute($sSql);
                        array_push($idProgramas, array("id" => $cnx->insert_ID(), "index" => $i));
                    } else {
                        $sSql = "UPDATE pprograma SET priconcp='$programa[1]',priene=$programa[2],prifeb=$programa[3],"
                                . "primar=$programa[4],priabr=$programa[5],primay=$programa[6],prijun=$programa[7],"
                                . "prijul=$programa[8],priago=$programa[9],prisep=$programa[10],prioct=$programa[11],prinov=$programa[12],"
                                . "pridic=$programa[13],pritotal=$programa[14] WHERE idprograma=$programa[0]";
                        $rs = $cnx->Execute($sSql);
                    }
                    $i++;
                }
            }
        } else {
            if (is_array($programas)) {
                foreach ($programas as $programa) {
                    if ($programa[0] == "") {
                        $sSql = "Insert into pprograma (IdSol,priconcp,priene,prifeb,primar,priabr,primay,prijun,prijul,priago,prisep,prioct,prinov,pridic,pritotal,idContrato) VALUES  ($idsol,'$programa[1]',$programa[2],$programa[3],$programa[4],$programa[5],$programa[6],$programa[7],$programa[8],$programa[9],$programa[10],$programa[11],$programa[12],$programa[13],$programa[14],$idContrato)";
//                //ChromePhp::log($sSql);
                        $rs = $cnx->Execute($sSql);
                        array_push($idProgramas, array("id" => $cnx->insert_ID(), "index" => $i));
                    } else {
                        $sSql = "UPDATE pprograma SET priconcp='$programa[1]',priene=$programa[2],prifeb=$programa[3],"
                                . "primar=$programa[4],priabr=$programa[5],primay=$programa[6],prijun=$programa[7],"
                                . "prijul=$programa[8],priago=$programa[9],prisep=$programa[10],prioct=$programa[11],prinov=$programa[12],"
                                . "pridic=$programa[13],pritotal=$programa[14] WHERE idprograma=$programa[0]";
                        $rs = $cnx->Execute($sSql);
                    }
                    $i++;
                }
            }
        }
        return $idProgramas;
    }

    //funcion para la actualizacion de los calendarizados financieros de la solicitud, proviene de la hoja4
    public function updateCalFinaOfSol($datos, $idSol, $idContrato) {
        global $cnx;
        if ($idContrato === "" && $idSol !== "") {
            $calene = ($datos[0]);
            $calfeb = ($datos[1]);
            $calmar = ($datos[2]);
            $calabr = ($datos[3]);
            $calmay = ($datos[4]);
            $caljun = ($datos[5]);
            $caljul = ($datos[6]);
            $calago = ($datos[7]);
            $calsep = ($datos[8]);
            $caloct = ($datos[9]);
            $calnov = ($datos[10]);
            $caldic = ($datos[11]);
            $sSql2 = "Update psolicitud set Ene = $calene, Feb = $calfeb, Mar = $calmar, Abr = $calabr, May = $calmay, Jun = $caljun, Jul = $caljul, Ago = $calago, Sep = $calsep, Oct = $caloct, Nov = $calnov, Dic = $caldic where IdSol = $idSol";
            $rs2 = $cnx->Execute($sSql2);
        }
    }

    public function addEmpresa($nomEmpresa, $nomRep, $objEmp, $rfcEmp, $padronContr) {
        global $cnx;
        $query = "insert into cempresa(NomEmp,NomRep,ObjEmp,RfcEmp,padronContr) values('$nomEmpresa','$nomRep',$objEmp,'$rfcEmp','$padronContr')";
        $rs = $cnx->Execute($query);
        return $cnx->Insert_ID();
    }

    //funcion para el guardado o actualizacion de contratos de la hoja4
    public function mergeContratos($contratos, $idsol) {
        global $cnx;
        $idsAdd = array();
        $i = 0;
        foreach ($contratos as $contrato) {
            if ($contrato[23] === "") {
                $contrato[23] = $this->addEmpresa($contrato[6], "", 0, $contrato[4], $contrato[5]);
            }
            $avaFinPhp = "";
            for ($k = 0; $k < 12; $k++) {
                $temp = $contrato[22][$k] !== "" ? $contrato[22][$k] : "0.00";
                $avaFinPhp .= "," . $temp;
            }
            $avaFinPhp = trim($avaFinPhp, ",");
            $contrato[20]["porcentaje"] = $contrato[20]["porcentaje"] !== "" && isset($contrato[20]["porcentaje"]) ? $contrato[20]["porcentaje"] : "0.00";
            $contrato[20]["importe"] = $contrato[20]["importe"] !== "" && isset($contrato[20]["importe"]) ? $contrato[20]["importe"] : "0.00";
            $contrato[19]["importe"] = $contrato[19]["importe"] !== "" && isset($contrato[19]["importe"]) ? $contrato[19]["importe"] : "0.00";
            $contrato[19]["importeCump"] = $contrato[19]["importeCump"] !== "" && isset($contrato[19]["importeCump"]) ? $contrato[19]["importeCump"] : "0.00";
            $contrato[8] = $contrato[8] !== "" ? $contrato[8] : "0.00";
            $contrato[9] = $contrato[9] !== "" ? $contrato[9] : "0.00";
            $contrato[25] = $contrato[25] !== "" ? $contrato[25] : "0.00";
            if ($contrato[0] === "" || $contrato[0] === "0") {
                $queryContrato = "Insert into pcontrato (IdSol,numContra,fecCeleb,descrip,"
                        . "idEmp,idTipContr,idMod,monto,montoAutActual,fecInicioContr,fecTerminoContr,"
                        . "diasCal,inmuDispo,motNoDisp,fecDisp,idTipObrContr,"
                        . "folioGar,fecEmisGar,importeGar,fecIniGar,fecFinGar,"
                        . "folioGarCump,fecEmisGarCump,importeGarCump,fecIniGarCump,fecFinGarCump,"
                        . "pjeAnti,importeAnti,motivImporte,formaPagoAnti,avanceFinan,contratoPadre) "
                        . "values ($idsol,"
                        . "'" . utf8_decode($contrato[1]) . "',"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[2]) . "', '%d-%m-%Y' ),"
                        . "'" . utf8_decode($contrato[3]) . "',"
                        . $contrato[23] . ","
                        . $contrato[7] . ","
                        . $contrato[8] . ","
                        . $contrato[9] . ","
                        . $contrato[25] . ","
                        . "STR_TO_DATE( '" . utf8_decode($contrato[10]) . "', '%d-%m-%Y' ),"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[11]) . "', '%d-%m-%Y' ),"
                        . $contrato[12] . ","
                        . $contrato[13] . ","
                        . "'" . utf8_decode($contrato[14]) . "',"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[15]) . "', '%d-%m-%Y' ),"
                        . $contrato[16] . ","
                        . "'" . $contrato[19]["folio"] . "',"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["fechaEmision"]) . "', '%d-%m-%Y' ),"
                        . $contrato[19]["importe"] . ","
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["inicioPlazo"]) . "', '%d-%m-%Y' ),"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["finPlazo"]) . "', '%d-%m-%Y' ),"
                        . "'" . $contrato[19]["folioCump"] . "',"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["fechaEmisionCump"]) . "', '%d-%m-%Y' ),"
                        . $contrato[19]["importeCump"] . ","
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["inicioPlazoCump"]) . "', '%d-%m-%Y' ),"
                        . "STR_TO_DATE( '" . utf8_decode($contrato[19]["finPlazoCump"]) . "', '%d-%m-%Y' ),"
                        . $contrato[20]["porcentaje"] . ","
                        . $contrato[20]["importe"] . ","
                        . "'" . utf8_decode($contrato[20]["motivos"]) . "',"
                        . "'" . utf8_decode($contrato[20]["formaPago"]) . "',"
                        . "'" . $avaFinPhp . "'," . $contrato[24] . ")";
                $rs3 = $cnx->Execute($queryContrato);
                $idAdd = $cnx->Insert_ID();
                $idsTrabajos = array();
                if (count($contrato[21]) > 0) {
                    $idsTrabajos = $this->mergeProgramas($contrato[21], $idsol, $idAdd);
                }
                array_push($idsAdd, array("id" => $idAdd, "index" => $i, "idsTrabajos" => $idsTrabajos));
            } else {
                $sSql = " UPDATE pcontrato SET numContra = '" . utf8_decode($contrato[1]) . "',"
                        . "fecCeleb = STR_TO_DATE( '" . utf8_decode($contrato[2]) . "', '%d-%m-%Y' ),"
                        . "descrip = '" . utf8_decode($contrato[3]) . "',"
                        . "idEmp = " . $contrato[23] . ","
                        . "idTipContr = " . $contrato[7] . ","
                        . "idMod = " . $contrato[8] . ","
                        . "monto = " . $contrato[9] . ","
                        . "montoAutActual = " . $contrato[25] . ","
                        . "fecInicioContr = STR_TO_DATE( '" . utf8_decode($contrato[10]) . "', '%d-%m-%Y' ),"
                        . "fecTerminoContr = STR_TO_DATE( '" . utf8_decode($contrato[11]) . "', '%d-%m-%Y' ),"
                        . "diasCal = " . $contrato[12] . ","
                        . "inmuDispo = " . $contrato[13] . ","
                        . "motNoDisp = '" . utf8_decode($contrato[14]) . "',"
                        . "fecDisp = STR_TO_DATE( '" . utf8_decode($contrato[15]) . "', '%d-%m-%Y' ),"
                        . "idTipObrContr = " . $contrato[16] . ","
                        . "folioGar = '" . utf8_decode($contrato[19]["folio"]) . "',"
                        . "fecEmisGar = STR_TO_DATE( '" . utf8_decode($contrato[19]["fechaEmision"]) . "', '%d-%m-%Y' ),"
                        . "importeGar = " . $contrato[19]["importe"] . ","
                        . "fecIniGar = STR_TO_DATE( '" . utf8_decode($contrato[19]["inicioPlazo"]) . "', '%d-%m-%Y' ),"
                        . "fecFinGar = STR_TO_DATE( '" . utf8_decode($contrato[19]["finPlazo"]) . "', '%d-%m-%Y' ),"
                        . "folioGarCump = '" . utf8_decode($contrato[19]["folioCump"]) . "',"
                        . "fecEmisGarCump = STR_TO_DATE( '" . utf8_decode($contrato[19]["fechaEmisionCump"]) . "', '%d-%m-%Y' ),"
                        . "importeGarCump = " . $contrato[19]["importeCump"] . ","
                        . "fecIniGarCump = STR_TO_DATE( '" . utf8_decode($contrato[19]["inicioPlazoCump"]) . "', '%d-%m-%Y' ),"
                        . "fecFinGarCump = STR_TO_DATE( '" . utf8_decode($contrato[19]["finPlazoCump"]) . "', '%d-%m-%Y' ),"
                        . "pjeAnti = " . $contrato[20]["porcentaje"] . ","
                        . "importeAnti = " . $contrato[20]["importe"] . ","
                        . "motivImporte = '" . utf8_decode($contrato[20]["motivos"]) . "',"
                        . "formaPagoAnti = '" . utf8_decode($contrato[20]["formaPago"]) . "',"
                        . "avanceFinan = '" . $avaFinPhp . "',"
                        . "contratoPadre = " . $contrato[24]
                        . " WHERE idContrato = $contrato[0]";
                $rs3 = $cnx->Execute($sSql);
                $idsTrabajos = array();
                if (count($contrato[21]) > 0) {
                    $idsTrabajos = $this->mergeProgramas($contrato[21], $idsol, $contrato[0]);
                }
                array_push($idsAdd, array("id" => $contrato[0], "index" => $i, "idsTrabajos" => $idsTrabajos));
            }
            $i++;
        }
        return $idsAdd;
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
        $query = "SELECT distinct acceso FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".relusuacc 
               WHERE idusu = -(SELECT idusu FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".usuarios WHERE lgnusu = '" . $usuario . "')
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

    public function buscarSolicitud($idSol, $idue, $tipoObra) {
        if($tipoObra == ""){
            $nsp = "";
        }elseif ($tipoObra == "10" || $tipoObra == "11" || $tipoObra == "13") {
            $nsp = " AND idsolpre IN (10,11,13) ";
        }else{
            $nsp = " AND idsolpre NOT IN (10,11,13) ";
        }
        global $cnx;
        $query = "SELECT * FROM psolicitud 
                LEFT JOIN catsector USING (idsec) 
                LEFT JOIN catue USING (idue) 
                WHERE idue = $idue
                    $nsp
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
            $rs->fields['NomSec'] = utf8_encode($rs->fields['NomSec']);
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
            $tmp['cveacu'] = utf8_encode($rs->fields['cveacu']);
            $tmp['idacu'] = utf8_encode($rs->fields['idacu']);
            $tmp['nomacu'] = utf8_encode($rs->fields['nomacu']);
            array_push($data, $tmp);
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
        $query = "SELECT r.idsol,c.idmun,c.nommun FROM relmunsol r, catmunicipio c WHERE  r.idmun=c.idmun AND r.idsol=$idSol AND c.idmun>0";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarRegSolicitud($idSol) {
        global $cnx;
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

    public function buscarContratoSolicitud($idSol) {
        global $cnx;
        $query = "select * from pcontrato where idSol =" . $idSol;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarProgramaSolicitud($idSol) {
        global $cnx;
        $query = "select * from pprograma where idSol =" . $idSol;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rsPrograma->fields["priconcp"] = utf8_encode($rsPrograma->fields["priconcp"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function buscarPresupuestoSolicitud($idSol) {
        global $cnx;
        $query = "select * from ppresupuestoobra where idSol =" . $idSol;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getConceptos($idSol) {
        global $cnx;
        $query = "select * from ppresupuestoobra where IdSol = $idSol";
        $rs = $cnx->Execute($query);
//       ChromePhp::log($query);
        $data = array();

        while (!$rs->EOF) {
            $rs->fields["claveObj"] = utf8_encode($rs->fields["claveObj"]);
            $rs->fields["concept"] = utf8_encode($rs->fields["concept"]);
            $rs->fields["uniMedi"] = utf8_encode($rs->fields["uniMedi"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
//        ChromePhp::log($data);
        return $data;
    }

    public function getConceptosReduccion($idSol) {
        global $cnx;

        $query = "select ppresupuestoobra.*,sum((montoAutorizado-montoEjercido)) as disponibleReduccion from ppresupuestoobra
                    left join relprefte using(idPresu) where idSol=" . $idSol . " group by idPresu;";
        $rs = $cnx->Execute($query);
//      ChromePhp::log($query);
        $data = array();
//        ChromePhp::log($rs->fields);
        if ($rs->fields) {
            while (!$rs->EOF) {
                $rs->fields["claveObj"] = utf8_encode($rs->fields["claveObj"]);
                $rs->fields["concept"] = utf8_encode($rs->fields["concept"]);
                $rs->fields["uniMedi"] = utf8_encode($rs->fields["uniMedi"]);
                array_push($data, $rs->fields);
                $rs->movenext();
            }
        } else {
            $data = null;
        }
//        ChromePhp::log($data);
        return $data;
    }

    public function getRelPreFte($idPresu) {
        global $cnx;
        $query = "select idFte,idPresu,montoAutorizado,dscfte from relprefte
                    left join catfte2015 using(idFte)
                where idPresu =" . $idPresu;
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getFuentesH3($idFuentes) {
        global $cnx;
        $f = "";
        foreach ($idFuentes as $value) {
            $f.=$value . ",";
        }
        $f = substr($f, 0, -1);
        $query = "select * from catfte2015 where idFte in(" . $f . ")";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }

        return $data;
    }

    public function getContratos($idSol, $tipoSolicitud) {
        global $cnx;
//        if ($tipoSolicitud === "2" || $tipoSolicitud === "3" || $tipoSolicitud === "12") {
        $query = "select idContrato,IdSol,numContra,DATE_FORMAT(fecCeleb, '%d-%m-%Y') fecCeleb,"
                . "descrip,idEmp,idTipContr,idMod,monto,montoAutActual,DATE_FORMAT(fecInicioContr, '%d-%m-%Y') fecInicioContr,"
                . "DATE_FORMAT(fecTerminoContr, '%d-%m-%Y') fecTerminoContr,diasCal,inmuDispo,"
                . "motNoDisp,DATE_FORMAT(fecDisp, '%d-%m-%Y') fecDisp,idTipObrContr,"
                . "folioGar,DATE_FORMAT(fecEmisGar, '%d-%m-%Y') fecEmisGar,importeGar,"
                . "DATE_FORMAT(fecIniGar, '%d-%m-%Y') fecIniGar,"
                . "DATE_FORMAT(fecFinGar, '%d-%m-%Y') fecFinGar,"
                . "folioGarCump,DATE_FORMAT(fecEmisGarCump, '%d-%m-%Y') fecEmisGarCump,importeGarCump,"
                . "DATE_FORMAT(fecIniGarCump, '%d-%m-%Y') fecIniGarCump,"
                . "DATE_FORMAT(fecFinGarCump, '%d-%m-%Y') fecFinGarCump,pjeAnti,importeAnti,motivImporte,"
                . "formaPagoAnti,avanceFinan,contratoPadre,estatus from pcontrato where IdSol = $idSol";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["numContra"] = utf8_encode($rs->fields["numContra"]);
            $rs->fields["descrip"] = utf8_encode($rs->fields["descrip"]);
            $rs->fields["motNoDisp"] = utf8_encode($rs->fields["motNoDisp"]);
            $rs->fields["motivImporte"] = utf8_encode($rs->fields["motivImporte"]);
            $rs->fields["formaPagoAnti"] = utf8_encode($rs->fields["formaPagoAnti"]);
            $rs->fields["folioGar"] = utf8_encode($rs->fields["folioGar"]);
            $rs->fields["folioGarCump"] = utf8_encode($rs->fields["folioGarCump"]);
            $rs->fields["empresa"] = $this->getEmpresaById($rs->fields["idEmp"]);
            $sqlPrograma = "select idPrograma,priconcp,priene,prifeb,primar,priabr,"
                    . "primay,prijun,prijul,priago,prisep,prioct,prinov,pridic,pritotal"
                    . " from pprograma where IdSol = $idSol and idContrato = " . $rs->fields["idContrato"];
            $rsPrograma = $cnx->Execute($sqlPrograma);
            $programas = array();
            while (!$rsPrograma->EOF) {
                $rsPrograma->fields["priconcp"] = utf8_encode($rsPrograma->fields["priconcp"]);
                array_push($programas, $rsPrograma->fields);
                $rsPrograma->movenext();
            }
            $rs->fields["programas"] = $programas;
            array_push($data, $rs->fields);
            $rs->movenext();
        }
//        }
        return $data;
    }

//funcion para el guardado o actualizacion de la hoja1
    public function guardadoHoja1($post, $idue, $idur, $idusu) {
        global $cnx;
        extract($post);
        if ($solpre == 3) {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - (($municipal * 1) + ($montoTotalAA * 1));
        } else {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - ($municipal * 1);
        }

        if ($idue == 0 && $idur == 0) {
            $idue = $ue2;
            $idur = $ur2;
        }

        if ($idsol == "") {
            $IdEdoSol = 2;
            $hoy = date('Y-m-d');

            $query = "INSERT INTO psolicitud 
                    (EvaSoc, IdSolPre, ObjEstSoc, ObjPryEje, ObjDerVia, ObjMIA, 
                    ObjObr, ObjAcc, ObjOtr, ObjOtrObs, 
                    NomObr, IdModEje, IdTipObr, PriCar,
                    Justifi, FecCap, 
                    IdEdoSol, Ejercicio, CanMet, CanBen, IdMet, 
                    IdBen, Monto, MonMun, FteMun,
                    IdUE, IdSec, IdUsu)
                    VALUES   
            (" . ($evasoc * 1) . "," . ($solpre * 1) . "," . ($obj0 * 1) . "," . ($obj1 * 1) . "," . ($obj2 * 1) . "," . ($obj3 * 1) . "," . ($obj4 * 1) . ","
                    . "" . ($obj5 * 1) . "," . ($obj6 * 1) . ",'" . utf8_decode($otroobs) . "',"
                    . "'" . utf8_decode($nomobra) . "'," . ($modalidad * 1) . "," . ($tipobr * 1) . ",'" . utf8_decode($caract) . "',"
                    . "'" . utf8_decode($jusobr) . "',STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' ),"
                    . "" . $IdEdoSol . "," . ($ejercicio * 1) . "," . (str_replace(',', '', $textmetas) * 1) . ", " . (str_replace(',', '', $textbeneficiario) * 1) . ", " . (str_replace(',', '', $metas) * 1) . ","
                    . "" . ($beneficiario * 1) . "," . ($montoInversion * 1) . "," . ($municipal * 1) . ",'" . utf8_decode($fmun) . "', "
                    . "" . ($idue * 1) . ", " . ($idur * 1) . ", " . ($idusu * 1) . ")";

            $result = $cnx->GetRow($query);
            $noSol = $cnx->Insert_ID();

            if ($origen != "") {
                $idacciones = explode(",", $origen);
                foreach ($idacciones as $acciones) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $acciones . ")";
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }

            $porcenfed = explode(",", $porfed);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            } else {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            }

            $porcenest = explode(",", $porest);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";
//                        ChromePhp::log($queryffed);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            } else {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ")";
//                        ChromePhp::log($queryfest);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            }

            $respuesta = $noSol;
        } else {
            if ($nbp !== null || $nbp !== "0" || $nbp !== "") {
                $hoy = date('Y-m-d');
                $modificacion = "UPDATE psolicitud SET EvaSoc=" . ($evasoc * 1) . ", IdSolPre=" . ($solpre * 1) . ", "
                        . "ObjEstSoc=" . ($obj0 * 1) . ", ObjPryEje=" . ($obj1 * 1) . ", ObjDerVia=" . ($obj2 * 1) . ",ObjMIA=" . ($obj3 * 1) . ","
                        . "ObjObr=" . ($obj4 * 1) . ", ObjAcc=" . ($obj5 * 1) . ", ObjOtr=" . ($obj6 * 1) . ", "
                        . "ObjOtrObs='" . utf8_decode($otroobs) . "', Monto=" . ($montoInversion * 1) . ","
                        . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", IdEdoSol = 2, "
                        . "FecCap = STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' ), IdUsu=" . ($idusu * 1);
                $modificacion .= " WHERE IdSol=" . $idsol;
//                ChromePhp::log($modificacion);
                $result = $cnx->GetRow($modificacion);

                $porcenfed = explode(",", $porfed);

                $cff = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=1";
                $rescff = $cnx->GetRow($cff);

                if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                    for ($i = 0; $i < count($ffed); $i++) {
                        if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
//                            ChromePhp::log($queryffed);
                            $respffed = $cnx->GetRow($queryffed);
                        }
                    }
                } else {
                    for ($i = 0; $i < count($ffed); $i++) {
                        if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ")";
//                            ChromePhp::log($queryffed);
                            $respffed = $cnx->GetRow($queryffed);
                        }
                    }
                }

                $porcenest = explode(",", $porest);

                $cfe = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=2";
                $rescfe = $cnx->GetRow($cfe);

                if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                    for ($j = 0; $j < count($fest); $j++) {
                        if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";
//                            ChromePhp::log($queryfest);
                            $respfest = $cnx->GetRow($queryfest);
                        }
                    }
                } else {
                    for ($j = 0; $j < count($fest); $j++) {
                        if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ")";
//                            ChromePhp::log($queryfest);
                            $respfest = $cnx->GetRow($queryfest);
                        }
                    }
                }

                $respuesta = $idsol;
            } else {
                $modificacion = "UPDATE psolicitud SET EvaSoc=" . ($evasoc * 1) . ", IdSolPre=" . ($solpre * 1) . ", "
                        . "ObjEstSoc=" . ($obj0 * 1) . ", ObjPryEje=" . ($obj1 * 1) . ", ObjDerVia=" . ($obj2 * 1) . ",ObjMIA=" . ($obj3 * 1) . ","
                        . "ObjObr=" . ($obj4 * 1) . ", ObjAcc=" . ($obj5 * 1) . ", ObjOtr=" . ($obj6 * 1) . ", "
                        . "ObjOtrObs='" . utf8_decode($otroobs) . "', IdObr=" . ($noobra * 1) . ", NomObr='" . utf8_decode($nomobra) . "',"
                        . "IdModEje=" . ($modalidad * 1) . ", IdTipObr=" . ($tipobr * 1) . ", PriCar='" . utf8_decode($caract) . "', "
                        . "Justifi='" . utf8_decode($jusobr) . "', CanMet=" . (str_replace(',', '', $textmetas) * 1) . ", CanBen=" . (str_replace(',', '', $textbeneficiario) * 1) . ","
                        . "IdMet=" . ($metas * 1) . ", IdBen=" . ($beneficiario * 1) . ", Monto=" . ($montoInversion * 1) . ", IdEdoSol = 2,"
                        . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", IdUsu=" . ($idusu * 1);

                $modificacion .= " WHERE IdSol=" . $idsol;
//                ChromePhp::log($modificacion);
                $result = $cnx->GetRow($modificacion);

                if ($origen != "") {
                    $idacciones = explode(",", $origen);

                    $consultaacc = "DELETE FROM relacusol WHERE idsol=$idsol";
                    $resconacc = $cnx->GetRow($consultaacc);

                    foreach ($idacciones as $acciones) {
                        $qinsacc = "INSERT INTO relacusol VALUES (" . $idsol . "," . $acciones . ")";
                        $resinacc = $cnx->GetRow($qinsacc);
                    }
                }

                $porcenfed = explode(",", $porfed);

                $cff = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=1";
                $rescff = $cnx->GetRow($cff);

                if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                    for ($i = 0; $i < count($ffed); $i++) {
                        if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
//                            ChromePhp::log($queryffed);
                            $respffed = $cnx->GetRow($queryffed);
                        }
                    }
                } else {
                    for ($i = 0; $i < count($ffed); $i++) {
                        if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ")";
//                            ChromePhp::log($queryffed);
                            $respffed = $cnx->GetRow($queryffed);
                        }
                    }
                }

                $porcenest = explode(",", $porest);

                $cfe = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=2";
                $rescfe = $cnx->GetRow($cfe);

                if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                    for ($j = 0; $j < count($fest); $j++) {
                        if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";
//                            ChromePhp::log($queryfest);
                            $respfest = $cnx->GetRow($queryfest);
                        }
                    }
                } else {
                    for ($j = 0; $j < count($fest); $j++) {
                        if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ")";
//                            ChromePhp::log($queryfest);
                            $respfest = $cnx->GetRow($queryfest);
                        }
                    }
                }
                $respuesta = $idsol;
            }
        }
        return $respuesta;
    }

//funcion para el guardado o actualizacion de la hoja5
    public function guardadoHoja5($campo, $idsol) {
        global $cnx;
        $modificacion = "UPDATE psolicitud SET ObsUE='" . utf8_decode($campo) . "'";
        $modificacion .= " WHERE IdSol=" . $idsol;
        $result = $cnx->GetRow($modificacion);
        $respuesta = $idsol;
        return $respuesta;
    }

//funcion para el guardado o actualizacion de la hoja7
    public function guardadoHoja7($criterios, $depnorm, $idsol) {
        global $cnx;
        $modificacion = "UPDATE psolicitud SET CriSoc='" . utf8_decode($criterios) . "', DepNor='" . utf8_decode($depnorm) . "'";
        $modificacion .= " WHERE IdSol=" . $idsol;
        $result = $cnx->GetRow($modificacion);
        $respuesta = $idsol;
        return $respuesta;
    }

//funcion para el guardado o actualizacion de la hoja2
    public function guardadoHoja2($post) {
        global $cnx;
        extract($post);
//        ChromePhp::log($post);
        if (($nbp != null || $nbp != "") && ($solpre == 1 || $solpre == 10)) {
            $respuesta = $idsol;
        } else {
            if ($solpre == 9) {
                $imgCondicion = ", Imagen='" . utf8_decode($imagen) . "'";
            } else {
                if ($rut != "") {
                    $ruta = "imagenes/" . $rut;
                    $imgCondicion = ", Imagen='" . utf8_decode($ruta) . "'";
                } else {
                    $imgCondicion = '';
                }
            }

            $modificacion = "UPDATE psolicitud SET IdCob='" . ($tipoCobertura1 * 1) . "', NomLoc='" . utf8_decode($inputEmail3) . "',
                            CooGeo=" . ($coor * 1) . ", ObsCoo='" . utf8_decode($obscoor) . "', LatIni=" . ($lat * 1) . ", "
                    . "LonIni=" . ($lon * 1) . ", LatFin=" . ($lat2 * 1) . ", LonFin=" . ($lon2 * 1) . " " . $imgCondicion . ", "
                    . "idTipLoc=" . ($tipLoc * 1);

            $modificacion .= " WHERE IdSol=" . $idsol;
//            ChromePhp::log($modificacion);
            $result = $cnx->GetRow($modificacion);

            if (($tipoCobertura1 * 1) == 2) {
                if ($disponiblesCobertura != "") {
                    $lcob = explode(",", $disponiblesCobertura);

                    $delreg = "DELETE FROM relregsol WHERE idsol=$idsol";
                    $resdelreg = $cnx->GetRow($delreg);

                    foreach ($lcob as $region) {
                        $inreg = "INSERT INTO relregsol VALUES (" . $idsol . "," . $region . ")";
                        $resinreg = $cnx->GetRow($inreg);
                    }
                }
            } else {
                if (($tipoCobertura1 * 1) == 3) {
                    if ($disponiblesCobertura != "") {
                        $lcob = explode(",", $disponiblesCobertura);

                        $delmun = "DELETE FROM relmunsol WHERE idsol=$idsol";
                        $resdelmun = $cnx->GetRow($delmun);

                        foreach ($lcob as $municipio) {
                            $inmun = "INSERT INTO relmunsol VALUES (" . $idsol . "," . $municipio . ")";
                            $resinmun = $cnx->GetRow($inmun);
                        }
                    }
                }
            }
            $respuesta = $idsol;
        }
        return $respuesta;
    }

    public function getTrabajosFisicosSol($idSol) {
        global $cnx;
        $query = "select idPrograma,priconcp,priene,prifeb,primar,priabr,primay,prijun,prijul,priago,prisep,prioct,prinov,pridic,pritotal from pprograma where IdSol = $idSol and idContrato is null";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["priconcp"] = utf8_encode($rs->fields["priconcp"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getAvanceFinaSol($idSol) {
        global $cnx;
        $query = "select Ene, Feb, Mar, Abr, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic from psolicitud where IdSol = $idSol";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getEmpresaByRFC($rfcEmpresa) {
        global $cnx;
        $query = "select idEmp,NomEmp,RfcEmp,padronContr from cempresa where RfcEmp = UPPER('" . $rfcEmpresa . "') limit 1";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomEmp"] = utf8_encode($rs->fields["NomEmp"]);
            $rs->fields["RfcEmp"] = utf8_encode($rs->fields["RfcEmp"]);
            $rs->fields["padronContr"] = utf8_encode($rs->fields["padronContr"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getEmpresaById($idEmpresa) {
        global $cnx;
        $query = "select idEmp,NomEmp,RfcEmp,padronContr from cempresa where idEmp = '$idEmpresa' limit 1";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomEmp"] = utf8_encode($rs->fields["NomEmp"]);
            $rs->fields["RfcEmp"] = utf8_encode($rs->fields["RfcEmp"]);
            $rs->fields["padronContr"] = utf8_encode($rs->fields["padronContr"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getTiposContratos() {
        global $cnx;
        $query = "select * from cattipcontr";
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["tipoContrato"] = utf8_encode($rs->fields["tipoContrato"]);
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
        $query = "SELECT a.idFte as idFte, a.monto AS monto, a.pjeInv, (a.monto - a.disponible) as disponible, b.DscFte AS nombre, a.cuenta, a.MontoAmpliado AS MontoAmpliado, (a.MontoAmpliado + a.monto) AS montoTotalAm FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 1 and a.idFte = b.idFte";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

//Buscar id, tipo, monto y porcentajes de fuentes est
    public function buscarFuentesEst($idSol) {
        global $cnx;
        $query = "SELECT a.idFte, a.monto AS monto, a.pjeInv, (a.monto - a.disponible) as disponible, b.DscFte AS nombre, a.cuenta, a.MontoAmpliado AS MontoAmpliado, (a.MontoAmpliado + a.monto) AS montoTotalAm FROM relsolfte a, catfte2015 b WHERE a.idSol = $idSol AND a.tipoFte = 2 AND a.idFte = b.idFte";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getListadoSolicitudes($idue, $fecIni, $fecFin) {
        global $cnx;
        $UE = "";
        if (!$idue) {
            if ($fecIni !== "" || $fecFin !== "") {
                $UE = " WHERE ";
            }
        } else {
            if ($fecIni == "" || $fecFin == "") {
                $UE = "WHERE IdUE = " . $idue . " ";
            }else{
                $UE = "WHERE IdUE = " . $idue . " AND ";
            }
        }
        if ($fecIni == "" || $fecFin == "") {
            $query = "SELECT idSol,NomSolPre,NomObr,NomEdo,idEdoSol,Reingreso,count(idEva) as NumObs FROM psolicitud
                        LEFT JOIN catedosol using(idEdoSol)
                        left join evaexp using(idSol)
                        left join catsolpre using(IdSolPre)
                        " . $UE . "
                        GROUP BY idSol
                        ORDER BY idsol DESC ";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        } else {
            $query = "SELECT idSol,NomSolPre,NomObr,NomEdo,idEdoSol,Reingreso,count(idEva) as NumObs FROM psolicitud
                        LEFT JOIN catedosol using(idEdoSol)
                        left join evaexp using(idSol)
                        left join catsolpre using(IdSolPre)
                        " . $UE . " 
                        FecCap BETWEEN '" . $fecIni . "' AND '" . $fecFin . "'
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
                join psolicitud using(IdSol)
                WHERE IdBco = '" . $idBco . "' and IdSolPre is null
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
                $rs->fields['NomSec'] = utf8_encode($rs->fields['NomSec']);
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
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        while (!$rs->EOF) {
            $data = (int) $rs->fields['idTurExp'] + 1;
            $rs->movenext();
        }
        return $data;
    }

    public function setTurno($id, $turno) {
        global $cnx;
        $query = "UPDATE psolicitud SET idTurExp=" . $turno . " WHERE idSol=" . $id;
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
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
        $query = "SELECT * FROM psolicitud pag 
                        LEFT JOIN catsector sec ON sec.IdSec = pag.idSec
                        LEFT JOIN cdepto dpt ON dpt.idDpt = sec.IdDpt
                        LEFT JOIN carea AREA ON dpt.idDir = AREA.idDir
                        LEFT JOIN catedosol edo ON pag.idEdoSol = edo.idEdoSol
                    where pag.idSol = " . $idSol . " AND pag.idEdoSol=3";
        $rs = $cnx->Execute($query);
//        ChromePhp::log($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function getExpTById($idSol) {
        global $cnx;
        $query = "SELECT idSol,nomUe,nomSolPre,idDir,NomDir,psolicitud.idSec,nomsec FROM psolicitud
                        left join catsector using(idSec)
                        left join cdepto using(idDpt)
                        left join carea using(idDir)
                        left join catedosol using(idEdoSol)
                        left join catsolpre using(idSolPre)
                        left join catue using(idUe)
                        where idSol = " . $idSol . " AND idEdoSol=3;";
        try {
            $rs = $cnx->Execute($query);
            $data = Array();
            while (!$rs->EOF) {
                $rs->fields['nomUe'] = utf8_encode($rs->fields['nomUe']);
                $rs->fields['nomSolPre'] = utf8_encode($rs->fields['nomSolPre']);
                $rs->fields['NomDir'] = utf8_encode($rs->fields['NomDir']);
                $rs->fields['nomsec'] = utf8_encode($rs->fields['nomsec']);
                array_push($data, $rs->fields);
                $rs->movenext();
            }
//            ChromePhp::log($data);
            return $data;
        } catch (Exception $ex) {
            $data = $ex;
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
        $query = "insert into psolicitud (EvaSoc,Ejercicio,IdSolPre,ObjEstSoc,ObjPryEje,ObjDerVia,ObjMIA,ObjObr,ObjAcc,ObjOtr,ObjOtrObs,IdUE,IdSec,IdObr,NomObr,IdModEje,IdTipObr,Monto,MonMun,FteMun,PriCar,IdCob,NomLoc,CooGeo,ObsCoo,LatIni,LonIni,LatFin,LonFin,Imagen,Ene,Feb,Mar,Abr,May,Jun,Jul,Ago,Sep,Oct,Nov,Dic,ObsUE,CriSoc,DepNor,Justifi,DurAgs,DurMes,IdGpo,IdTipEva,IdEdoSol,FecCap,FactLeg,FactAmb,FactTec,idTipLoc,IdBen,IdMet,CanMet,CanBen,FecMod,FecEnv,FecIng,FecEval,vidaPry) select EvaSoc,Ejercicio,IdSolPre,ObjEstSoc,ObjPryEje,ObjDerVia,ObjMIA,ObjObr,ObjAcc,ObjOtr,ObjOtrObs,IdUE,IdSec,IdObr,NomObr,IdModEje,IdTipObr,Monto,MonMun,FteMun,PriCar,IdCob,NomLoc,CooGeo,ObsCoo,LatIni,LonIni,LatFin,LonFin,Imagen,Ene,Feb,Mar,Abr,May,Jun,Jul,Ago,Sep,Oct,Nov,Dic,ObsUE,CriSoc,DepNor,Justifi,DurAgs,DurMes,IdGpo,IdTipEva,IdEdoSol,FecCap,FactLeg,FactAmb,FactTec,idTipLoc,IdBen,IdMet,CanMet,CanBen,FecMod,FecEnv,FecIng,FecEval,vidaPry from psolicitud where idSol=" . $idSol;
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = $cnx->Insert_ID();
            $query = "UPDATE psolicitud SET IdUsu = '" . $_SESSION['USERID'] . "' WHERE IdSol = '" . $data . "'";
            $rs = $cnx->Execute($query);
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
    
    public function updateApContrato($idObr, $contratos) {
        foreach ($contratos as $value) {
            global $cnx;
            $query = "Update pautpag set IdContrato=" . $value[1] . " WHERE idObr = " . $idObr . " AND IdContrato=" . $value[0];
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
            $query2 = "insert into relsolfte values(" . $idSolNew . "," . $value["idFte"] . "," . $value["tipoFte"] . "," . $value["monto"] . "," . $value["MontoAutorizado"] . "," . $value["MontoEjercido"] . "," . $value["pjeInv"] . "," . $value["disponible"] . "," . $value["cuenta"] . "," . $value["sumaAnticipo"] . "," . $value["retenciones"] . "," . $value["comprobado"] . "," . $value["pagado"] . "," . $value["MontoAmpliado"] . ")";
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

    public function cloneRelMunSol($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from relmunsol where idSol =" . $idSolOld;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (!$data) {
            $data = $idSolNew;
        } else {
            foreach ($data as $value) {
                $query2 = "insert into relmunsol values(" . $idSolNew . "," . $value["IdMun"] . ")";
//               ChromePhp::log($query2);
                try {
                    $rs = $cnx->Execute($query2);
                    $data = $idSolNew;
                } catch (Exception $ex) {
                    $data = $ex;
                }
            }
        }
        return $data;
    }

    public function cloneRelRegSol($idSolOld, $idSolNew) {
        global $cnx;
        $query = "select * from relregsol where idSol =" . $idSolOld;
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        if (!$data) {
            $data = $idSolNew;
        } else {
            foreach ($data as $value) {
                $query2 = "insert into relregsol values(" . $idSolNew . "," . $value["IdReg"] . ")";
//               ChromePhp::log($query2);
                try {
                    $rs = $cnx->Execute($query2);
                    $data = $idSolNew;
                } catch (Exception $ex) {
                    $data = $ex;
                }
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
                    $query4 = "INSERT INTO relprefte (idPresu,idFte,montoEjercido,montoAutorizado,montoDisponible) "
                            . "VALUES (" . $idPresu . "," . $value2['idFte'] . "," . $value2['montoEjercido'] . "," . $value2['montoAutorizado'] . "," . $value2['montoDisponible'] . ")";
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
            $value['pjeAnti'] = ($value['pjeAnti'] == null) ? "0.00" : $value['pjeAnti'];
//            ChromePhp::log( $value['folioGarCump']);
//            ChromePhp::log( $value['importeGarCump']);
//            ChromePhp::log( $value['importeGarCump']);
            $query2 = "Insert into pcontrato (IdSol,numContra,fecCeleb,descrip,"
                    . "idEmp,idTipContr,idMod,monto,montoAutActual,montoEjercido,fecInicioContr,fecTerminoContr,"
                    . "diasCal,inmuDispo,motNoDisp,fecDisp,idTipObrContr,"
                    . "folioGar,fecEmisGar,importeGar,fecIniGar,fecFinGar,"
                    . "pjeAnti,importeAnti,motivImporte,formaPagoAnti,"
                    . "folioGarCump,fecEmisGarCump,importeGarCump,fecIniGarCump,fecFinGarCump,"
                    . "avanceFinan,contratoPadre,estatus)"
                    . " values(" . $idSolNew . ",'" . $value['numContra'] . "','" . $value['fecCeleb'] . "','" . $value['descrip'] . "'"
                    . "," . $value['idEmp'] . "," . $value['idTipContr'] . "," . $value['idMod'] . "," . $value['monto'] . "," . $value['montoAutActual'] . "," . $value['montoEjercido'] . ",'" . $value['fecInicioContr'] . "','" . $value['fecTerminoContr'] . "'"
                    . "," . $value['diasCal'] . "," . $value['inmuDispo'] . ",'" . $value['motNoDisp'] . "','" . $value['fecDisp'] . "'," . $value['idTipObrContr'] . ""
                    . ",'" . $value['folioGar'] . "','" . $value['fecEmisGar'] . "'," . $value['importeGar'] . ",'" . $value['fecIniGar'] . "','" . $value['fecFinGar'] . "'"
                    . "," . $value["pjeAnti"] . "," . $value['importeAnti'] . ",'" . $value['motivImporte'] . "','" . $value['formaPagoAnti'] . "'"
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

    public function updateRelSolBco($idSol, $idSolNew) {
        global $cnx;
        $query = "Update relsolbco set IdSol=" . $idSolNew . " WHERE IdSol = " . $idSol . "";
//        ChromePhp::log($query);
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
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
        $query = "SELECT permisoAut FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".usuarios 
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
        $query = "SELECT VerExpTec FROM pobra 
                WHERE MontoAsignado = MontoEjercido
                AND idobr = $idObra";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = $rs->fields['VerExpTec'];
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

    public function buscarSol($idSol, $idue, $tipoObra) {
        if($tipoObra == "10" || $tipoObra == "11" || $tipoObra == "13"){
            $nsp = "10, 13";
        }else{
            $nsp = "2, 12";
        }
        global $cnx;
        $query = "SELECT * FROM psolicitud 
                LEFT JOIN catsector USING (idsec) 
                LEFT JOIN catue USING (idue) 
                WHERE idsolpre IN ($nsp) 
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

    public function guardadoFuentes($post) {
        global $cnx;
        extract($post);

        if (($solpre * 1) === 3 || ($solpre * 1) === 13) {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            if ($banAm == "1") {
                $montoInversion = ($montoInversion * 1) - ($montoTotalAAe * 1);
            } else {
                $montoInversion = ($montoInversion * 1) - (($montoTotalAAe * 1) + ($municipal * 1));
            }
            $hoy = date('Y-m-d');

            $montoTotal = $montoInversion;
            if ($banAm == "1") {
                $montoMunicipal = ($municipal * 1);
            } else {
                $qminv = "SELECT MonMun FROM psolicitud WHERE IdSol =" . $idsol;
//                    ChromePhp::log($qminv);
                $rminv = $cnx->Execute($qminv);
                foreach ($rminv as $value) {
                    $montoMunicipal = ($value['MonMun'] * 1) + ($municipal * 1);
                }
            }

            $modificacion = "UPDATE psolicitud SET Monto=" . ($montoTotal * 1) . ","
                    . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($montoMunicipal * 1) . ", IdEdoSol = 2,"
                    . "FecCap = STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' )";
            $modificacion .= " WHERE IdSol=" . $idsol;
//            ChromePhp::log($modificacion);
            $result = $cnx->GetRow($modificacion);

            $porcenfed = explode(",", $porfed);
            
            $montoTotalSA = 0;
            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                    $montoTotalSA = $montoTotalSA + (str_replace(",", "", $federal[$i]) * 1);
                }
            }
            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                    $montoTotalSA = $montoTotalSA + (str_replace(",", "", $estatal[$j]) * 1);
                }
            }

            $qmfed = "SELECT monto FROM relsolfte WHERE tipoFte = 1 AND idsol =" . $idsol;
//                ChromePhp::log($qmfed);
            $result = $cnx->GetRow($qmfed);

            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                    $montoTotalFF[$i] = ($result[$i] * 1) + (str_replace(",", "", $federal[$i]) * 1);
                    $montoTotalFF2[$i] = (str_replace(",", "", $federal[$i]) * 1);
                    $porcentaje[$i] = (($montoTotalFF2[$i]) * 100)/($montoTotalSA * 1);
                    $pff[$i] = round($porcentaje[$i], 5);

                    $queryffed = "UPDATE relsolfte SET MontoAmpliado = " . (str_replace(",", "", $federal[$i]) * 1) . ""
                            . ", pjeInv = " . $pff[$i] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $ffed[$i] . " AND tipoFte = 1";
//                            ChromePhp::log($queryffed);
                    $resffed = $cnx->GetRow($queryffed);
                }
            }

            $porcenest = explode(",", $porest);

            $qmest = "SELECT monto FROM relsolfte WHERE tipoFte = 2 AND idsol =" . $idsol;
//                ChromePhp::log($qmest);
            $result2 = $cnx->GetRow($qmest);

            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                    $montoTotalFE[$j] = ($result2[$j] * 1) + (str_replace(",", "", $estatal[$j]) * 1);
                    $montoTotalFE2[$j] = (str_replace(",", "", $estatal[$j]) * 1);
                    $porcentaje2[$j] = (($montoTotalFE2[$j]) * 100)/($montoTotalSA * 1);
                    $pfe[$j] = round($porcentaje2[$j], 5);

                    $queryfest = "UPDATE relsolfte SET MontoAmpliado = " . (str_replace(",", "", $estatal[$j]) * 1) . ""
                            . ", pjeInv = " . $pfe[$j] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $fest[$j] . " AND tipoFte = 2";
//                            ChromePhp::log($queryfest);
                    $resffest = $cnx->GetRow($queryfest);
                }
            }

            $respuesta = $idsol;

            return $respuesta;
        } else {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - ($municipal * 1);
            $hoy = date('Y-m-d');

            $modificacion = "UPDATE psolicitud SET Monto=" . ($montoInversion * 1) . ","
                    . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", IdEdoSol = 2,"
                    . "FecCap = STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' )";
            $modificacion .= " WHERE IdSol=" . $idsol;
            $result = $cnx->GetRow($modificacion);

            $porcenfed = explode(",", $porfed);

            $cff = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=1";
            $rescff = $cnx->GetRow($cff);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11) {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        if ($fcta[$i] == "") {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ", null," . str_replace(",", "", $federal[$i]) . ")";
                            $respffed = $cnx->GetRow($queryffed);
                        } else {
                            $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . $fcta[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
                            $respffed = $cnx->GetRow($queryffed);
                        }
                    }
                }
            } else {
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
            }

            $porcenest = explode(",", $porest);

            $cfe = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=2";
            $rescfe = $cnx->GetRow($cfe);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11) {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        if ($ecta[$j] == "") {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ", null," . str_replace(",", "", $estatal[$j]) . ")";

                            $respfest = $cnx->GetRow($queryfest);
                        } else {
                            $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, cuenta, MontoAutorizado) "
                                    . "VALUES(" . $idsol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . $ecta[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";

                            $respfest = $cnx->GetRow($queryfest);
                        }
                    }
                }
            } else {
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
            }

            $respuesta = $idsol;

            return $respuesta;
        }
    }

//Buscar montos federales
    public function buscarMontosFed($idObra) {
        global $cnx;
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
        $query = "SELECT ps.idSol, ps.idturexp, ue.nomUE, ev.nomSolPre
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

        $query = "SELECT ps.idsol, ps.ejercicio, ps.nomObr, ps.monto, ps.fecEnv, ps.monmun, ue.nomUE, ev.nomSolPre, SUM(rsf.monto) AS montofed
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
            $rs->fields['fecEnv'] = utf8_encode($rs->fields['fecEnv']);
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

//funcion para el guardado o actualizacion de los montos autorizados de obra y fuentes
    public function guardarMontoAutorizado($idsol, $montoInv) {
        global $cnx;
        try {
            $qobra = "UPDATE pobra SET MontoAutorizado = $montoInv WHERE idsol = $idsol";
//            ChromePhp::log($qobra);
            $result = $cnx->GetRow($qobra);

            $qbfed = "SELECT idFte FROM relsolfte WHERE tipoFte = 1 AND idsol = $idsol ";
//            ChromePhp::log($qbfed);
            $rbfed = $cnx->GetCol($qbfed);
            foreach ($rbfed as $value) {
                $qffed = "UPDATE relsolfte SET MontoAutorizado = (SELECT SUM(montoAutorizado) AS montoAutorizado 
                    FROM ppresupuestoobra
                    LEFT JOIN relprefte USING(idPresu) 
                    WHERE idSol=$idsol AND idFte = $value) 
                    WHERE idSol = $idsol AND idFte = $value";
//                ChromePhp::log($qffed);
                $rffed = $cnx->GetCol($qffed);
            }

            $qbest = "SELECT idFte FROM relsolfte WHERE tipoFte = 2 AND idsol = $idsol ";
//            ChromePhp::log($qbest);
            $rbest = $cnx->GetCol($qbest);
            foreach ($rbest as $value) {
                $qfest = "UPDATE relsolfte SET MontoAutorizado = (SELECT SUM(montoAutorizado) AS montoAutorizado 
                    FROM ppresupuestoobra
                    LEFT JOIN relprefte USING(idPresu) 
                    WHERE idSol=$idsol AND idFte = $value) 
                    WHERE idSol = $idsol AND idFte = $value";
//                ChromePhp::log($qfest);
                $rfest = $cnx->GetCol($qfest);
            }
            $respuesta = $idsol;
        } catch (Exception $ex) {
            $respuesta = $ex;
        }
        return $respuesta;
    }

    public function guardarMontoAsignado($post) {
        global $cnx;
        extract($post);
//        ChromePhp::log($post);
        try {
            $qobra = "UPDATE pobra SET MontoAsignado = $montoInv WHERE idsol = $idsol";
//            ChromePhp::log($qobra);
            $result = $cnx->Execute($qobra);

            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - (($montoTotalAAe * 1) + ($municipal * 1));
            $hoy = date('Y-m-d');

            $montoTotal = $montoInversion;
            $montoMunicipal = ($municipal * 1);

            $porcenfed = explode(",", $porfed);

            $qmfed = "SELECT monto FROM relsolfte WHERE tipoFte = 1 AND idsol =" . $idsol;
//                ChromePhp::log($qmfed);
            $result = $cnx->GetRow($qmfed);

            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                    $monto[$i] = ($result[$i] * 1) + (str_replace(",", "", $federal[$i]) * 1);

                    $queryffed = "UPDATE relsolfte SET monto = " . $monto[$i] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $ffed[$i] . " AND tipoFte = 1";
                    ChromePhp::log($queryffed);
                    $resffed = $cnx->GetRow($queryffed);
                }
            }

            $porcenest = explode(",", $porest);

            $qmest = "SELECT monto FROM relsolfte WHERE tipoFte = 2 AND idsol =" . $idsol;
//                ChromePhp::log($qmest);
            $result2 = $cnx->GetRow($qmest);

            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                    $monto[$j] = ($result2[$j] * 1) + (str_replace(",", "", $estatal[$j]) * 1);

                    $queryfest = "UPDATE relsolfte SET monto = " . $monto[$j] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $fest[$j] . " AND tipoFte = 2";
                    ChromePhp::log($queryfest);
                    $resffest = $cnx->GetRow($queryfest);
                }
            }

            $respuesta = $idsol;
        } catch (Exception $ex) {
            $respuesta = $ex;
        }
        return $respuesta;
    }
    
    public function guardarMontoAsignadoAut($post) {
        global $cnx;
        extract($post);
//        ChromePhp::log($post);
        try {
            $qobra = "UPDATE pobra SET MontoAsignado = $montoInv, MontoAutorizado = $montoInv WHERE idsol = $idsol";
//            ChromePhp::log($qobra);
            $result = $cnx->Execute($qobra);

            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - (($montoTotalAAe * 1) + ($municipal * 1));
            $hoy = date('Y-m-d');

            $montoTotal = $montoInversion;
            $montoMunicipal = ($municipal * 1);

            $porcenfed = explode(",", $porfed);

            $qmfed = "SELECT monto FROM relsolfte WHERE tipoFte = 1 AND idsol =" . $idsol;
//                ChromePhp::log($qmfed);
            $result = $cnx->GetRow($qmfed);

            for ($i = 0; $i < count($ffed); $i++) {
                if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                    $monto[$i] = ($result[$i] * 1) + (str_replace(",", "", $federal[$i]) * 1);

                    $queryffed = "UPDATE relsolfte SET monto = " . $monto[$i] . ", MontoAutorizado = " . $monto[$i] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $ffed[$i] . " AND tipoFte = 1";
                    ChromePhp::log($queryffed);
                    $resffed = $cnx->GetRow($queryffed);
                }
            }

            $porcenest = explode(",", $porest);

            $qmest = "SELECT monto FROM relsolfte WHERE tipoFte = 2 AND idsol =" . $idsol;
//                ChromePhp::log($qmest);
            $result2 = $cnx->GetRow($qmest);

            for ($j = 0; $j < count($fest); $j++) {
                if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                    $monto[$j] = ($result2[$j] * 1) + (str_replace(",", "", $estatal[$j]) * 1);

                    $queryfest = "UPDATE relsolfte SET monto = " . $monto[$j] . ", MontoAutorizado = " . $monto[$j] . " "
                            . "WHERE idSol = " . $idsol . " AND idFte = " . $fest[$j] . " AND tipoFte = 2";
                    ChromePhp::log($queryfest);
                    $resffest = $cnx->GetRow($queryfest);
                }
            }

            $respuesta = $idsol;
        } catch (Exception $ex) {
            $respuesta = $ex;
        }
        return $respuesta;
    }

//funcion para la cancelación de montos por fuentes
    public function canceladoMontos($post) {
        global $cnx;
        extract($post);

        for ($i = 0; $i < count($ffed); $i++) {
            $monto[$i] = str_replace(",", "", $fedasig[$i]) - str_replace(",", "", $fedcan[$i]);
            $queryffed = "UPDATE relsolfte SET monto = " . $monto[$i] . " WHERE idsol = " . $solicitud . " AND idfte = " . $idfed[$i] . " AND tipofte = 1";
//            ChromePhp::log($queryffed);
            $respffed = $cnx->GetRow($queryffed);
        }
//
        for ($j = 0; $j < count($fest); $j++) {
            $monto[$j] = str_replace(",", "", $estasig[$j]) - str_replace(",", "", $estcan[$j]);
            $queryfest = "UPDATE relsolfte SET monto = " . $monto[$j] . " WHERE idsol = " . $solicitud . " AND idfte = " . $idest[$j] . " AND tipofte = 2";
//            ChromePhp::log($queryfest);
            $respfest = $cnx->GetRow($queryfest);
        }

        $respuesta = $idsol;
        return $respuesta;
    }

    public function consultarObras($idusu, $fecIni, $fecFin) {
        global $cnx;
        if ($fecIni == "" && $fecFin == "") {
            $query = "SELECT COUNT(a.idobr) AS NumObr, a.idsol, a.idObr, b.MontoAsignado, a.NomObr
                    FROM psolicitud a, pobra b WHERE a.idobr = b.idobr 
                    AND a.IdSec IN (SELECT idSec FROM rususec WHERE idUsu = $idusu) GROUP BY a.idobr";
//            ChromePhp::log($query);
            $rs = $cnx->Execute($query);
        } else {
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

    public function consultarObrasOficios($idusu) {
        global $cnx;
//        $query = "SELECT COUNT(c.idobr) AS NumObrOfi, b.idObr AS idObr, c.idUsu FROM pobra b, poficio c 
//                WHERE c.idobr = b.idobr AND c.IdUsu = $idusu GROUP BY b.idobr";
        $query = "SELECT COUNT(*) AS NumObrOfi, b.idObr AS idObr, c.idUsu
                FROM pobra b, poficio c, doficio d
                WHERE d.idobr = b.idobr 
                AND d.idOfi = c.cveOfi
                GROUP BY b.idobr";
//            ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function consultarObrasAp($idusu) {
        global $cnx;
        $query = "SELECT COUNT(c.idObr) AS NumObrAp, b.idObr AS idObr, c.idUsu 
                FROM pobra b, pautpag c 
                WHERE c.idobr = b.idobr GROUP BY b.idobr";
//            ChromePhp::log($query);
        $rs = $cnx->Execute($query);
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

//funcion para el guardado o actualizacion de la hoja1 de Asignación Adicional
    public function guardadoAsigAdic($post, $idue, $idur, $idusu) {
        global $cnx;
        extract($post);
        if ($solpre == 3) {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - (($municipal * 1) + ($montoTotalAA * 1));
        } else {
            $montoInversion = str_replace(",", "", $montoInversion);
            $municipal = str_replace(",", "", $municipal);
            $montoInversion = ($montoInversion * 1) - ($municipal * 1);
        }

        if ($idue == 0 && $idur == 0) {
            $idue = $ue2;
            $idur = $ur2;
        }

        if ($idsol == "") {
            $IdEdoSol = 2;
            $hoy = date('Y-m-d');

            $query = "INSERT INTO psolicitud 
                    (EvaSoc, IdSolPre, ObjEstSoc, ObjPryEje, ObjDerVia, ObjMIA, 
                    ObjObr, ObjAcc, ObjOtr, ObjOtrObs, 
                    NomObr, IdModEje, IdTipObr, PriCar,
                    Justifi, FecCap, 
                    IdEdoSol, Ejercicio, CanMet, CanBen, IdMet, 
                    IdBen, Monto, MonMun, FteMun,
                    IdUE, IdSec, IdUsu, IdObr)
                    VALUES   
            (" . ($evasoc * 1) . "," . ($solpre * 1) . "," . ($obj0 * 1) . "," . ($obj1 * 1) . "," . ($obj2 * 1) . "," . ($obj3 * 1) . "," . ($obj4 * 1) . ","
                    . "" . ($obj5 * 1) . "," . ($obj6 * 1) . ",'" . utf8_decode($otroobs) . "',"
                    . "'" . utf8_decode($nomobra) . "'," . ($modalidad * 1) . "," . ($tipobr * 1) . ",'" . utf8_decode($caract) . "',"
                    . "'" . utf8_decode($jusobr) . "',STR_TO_DATE( '" . utf8_decode($hoy) . "', '%Y-%m-%d' ),"
                    . "" . $IdEdoSol . "," . ($ejercicio * 1) . "," . ($textmetas * 1) . ", " . ($textbeneficiario * 1) . ", " . ($metas * 1) . ","
                    . "" . ($beneficiario * 1) . "," . ($montoInversion * 1) . "," . ($municipal * 1) . ",'" . utf8_decode($fmun) . "', "
                    . "" . ($idue * 1) . ", " . ($idur * 1) . ", " . ($idusu * 1) . ", " . ($noobra * 1) . ")";

            $result = $cnx->GetRow($query);
            $noSol = $cnx->Insert_ID();

            if ($origen != "") {
                $idacciones = explode(",", $origen);
                foreach ($idacciones as $acciones) {
                    $queryacc = "INSERT INTO relacusol VALUES (" . $noSol . "," . $acciones . ")";
//                    ChromePhp::log($queryacc);
                    $resultacc = $cnx->GetRow($queryacc);
                }
            }

            $porcenfed = explode(",", $porfed);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            } else {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            }

            $porcenest = explode(",", $porest);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";
//                        ChromePhp::log($queryffed);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            } else {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ")";
//                        ChromePhp::log($queryfest);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            }

            $qObra = "UPDATE pobra SET IdSol = " . $noSol . " WHERE idObr = " . $noobra;
            $rObra = $cnx->GetRow($qObra);

            $respuesta = $noSol;
        } else {
            $modificacion = "UPDATE psolicitud SET EvaSoc=" . ($evasoc * 1) . ", IdSolPre=" . ($solpre * 1) . ", "
                    . "ObjEstSoc=" . ($obj0 * 1) . ", ObjPryEje=" . ($obj1 * 1) . ", ObjDerVia=" . ($obj2 * 1) . ",ObjMIA=" . ($obj3 * 1) . ","
                    . "ObjObr=" . ($obj4 * 1) . ", ObjAcc=" . ($obj5 * 1) . ", ObjOtr=" . ($obj6 * 1) . ", "
                    . "ObjOtrObs='" . utf8_decode($otroobs) . "', IdObr=" . ($noobra * 1) . ", NomObr='" . utf8_decode($nomobra) . "',"
                    . "IdModEje=" . ($modalidad * 1) . ", IdTipObr=" . ($tipobr * 1) . ", PriCar='" . utf8_decode($caract) . "', "
                    . "Justifi='" . utf8_decode($jusobr) . "', CanMet=" . ($textmetas * 1) . ", CanBen=" . ($textbeneficiario * 1) . ","
                    . "IdMet=" . ($metas * 1) . ", IdBen=" . ($beneficiario * 1) . ", Monto=" . ($montoInversion * 1) . ", IdEdoSol = 2,"
                    . "FteMun='" . utf8_decode($fmun) . "', MonMun=" . ($municipal * 1) . ", IdUsu=" . ($idusu * 1) . ", IdObr=" . ($noobra * 1);

            $modificacion .= " WHERE IdSol=" . $idsol;
//                ChromePhp::log($modificacion);
            $result = $cnx->GetRow($modificacion);

            if ($origen != "") {
                $idacciones = explode(",", $origen);

                $consultaacc = "DELETE FROM relacusol WHERE idsol=$idsol";
//                    ChromePhp::log($consultaacc);
                $resconacc = $cnx->GetRow($consultaacc);

                foreach ($idacciones as $acciones) {
                    $qinsacc = "INSERT INTO relacusol VALUES (" . $idsol . "," . $acciones . ")";
//                        ChromePhp::log($qinsacc);
                    $resinacc = $cnx->GetRow($qinsacc);
                }
            }

            $porcenfed = explode(",", $porfed);

            $cff = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=1";
            $rescff = $cnx->GetRow($cff);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . "," . str_replace(",", "", $federal[$i]) . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            } else {
                for ($i = 0; $i < count($ffed); $i++) {
                    if ($ffed[$i] != 0 && $ffed[$i] != "" && $federal[$i] != 0 && $federal[$i] != "") {
                        $queryffed = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $ffed[$i] . ", 1," . str_replace(",", "", $federal[$i]) . "," . $porcenfed[$i] . ")";
//                        ChromePhp::log($queryffed);
                        $respffed = $cnx->GetRow($queryffed);
                    }
                }
            }

            $porcenest = explode(",", $porest);

            $cfe = "DELETE FROM relsolfte WHERE idsol=$idsol and tipoFte=2";
            $rescfe = $cnx->GetRow($cfe);

            if (($solpre * 1) === 10 || ($solpre * 1) === 11 || ($solpre * 1) === 13) {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv, MontoAutorizado) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . "," . str_replace(",", "", $estatal[$j]) . ")";
//                        ChromePhp::log($queryfest);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            } else {
                for ($j = 0; $j < count($fest); $j++) {
                    if ($fest[$j] != 0 && $fest[$j] != "" && $estatal[$j] != 0 && $estatal[$j] != "") {
                        $queryfest = "INSERT INTO relsolfte(idSol, idFte, tipoFte, monto, pjeInv) "
                                . "VALUES(" . $noSol . "," . $fest[$j] . ", 2," . str_replace(",", "", $estatal[$j]) . "," . $porcenest[$j] . ")";
//                        ChromePhp::log($queryfest);
                        $respfest = $cnx->GetRow($queryfest);
                    }
                }
            }

            $respuesta = $idsol;
        }
        return $respuesta;
    }

    public function oficiosObras($idObr) {
        global $cnx;
        $query = "SELECT poficio.CveOfi, NomSolPre, pobra.IdSol, NomObr, NomEdoOfi, 
                    doficio.IdObr as idObr, DscFte, idDetOfi
                    FROM poficio, catsolpre, doficio, pobra, cedoofi, psolicitud, catfte2015
                    WHERE catsolpre.IdSolPre = poficio.IdSolPre
                    AND doficio.idObr = pobra.idObr
                    AND pobra.IdSol = psolicitud.IdSol
                    AND cedoofi.idEdoOFi = poficio.idEdoOFi
                    AND poficio.CveOfi = doficio.idOfi
                    AND catfte2015.idFte = doficio.idFte
                    AND doficio.idObr = $idObr
                    ORDER BY poficio.idOfi DESC ";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomSolPre"] = utf8_encode($rs->fields["NomSolPre"]);
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            $rs->fields["NomEdoOfi"] = utf8_encode($rs->fields["NomEdoOfi"]);
            $rs->fields["DscFte"] = utf8_encode($rs->fields["DscFte"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function apObras($idObr) {
        global $cnx;
        $query = "SELECT pautpag.idObr, idAps, NomTipAps, NomObr, pautpag.Monto, NomEdoAps FROM pautpag
            LEFT JOIN ctipaps USING (idTipAps)
            LEFT JOIN pobra USING (idObr)
            LEFT JOIN psolicitud USING (IdSol)
            LEFT JOIN dautpag USING (idAps)
            LEFT JOIN cedoaps USING (idEdoAps)
            WHERE pautpag.idObr = $idObr
            ORDER BY idAps DESC ";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = array();
        while (!$rs->EOF) {
            $rs->fields["NomSolPre"] = utf8_encode($rs->fields["NomTipAps"]);
            $rs->fields["NomObr"] = utf8_encode($rs->fields["NomObr"]);
            $rs->fields["NomEdoOfi"] = utf8_encode($rs->fields["NomEdoAps"]);
            array_push($data, $rs->fields);
            $rs->movenext();
        }
        return $data;
    }

    public function actualizarIdUsu($sol, $idusu) {
        global $cnx;
        $query = "UPDATE psolicitud SET  IdUsu = " . $idusu . " WHERE idSol=" . $sol;
        try {
            $rs = $cnx->Execute($query);
            $data = "ok";
        } catch (Exception $ex) {
            $data = $ex;
        }
        return $data;
    }

//Buscar si es la solicitud actual de la obra
    public function buscarSolObra($id) {
        global $cnx;
        $query = "SELECT idObr FROM pobra where IdSol=$id";
//        ChromePhp::log($query);
        $rs = $cnx->Execute($query);
        $data = $rs->fields['idObr'];
        return $data;
    }

    public function getOficioAsignacionObr($idObr) {
        global $cnx;
        $query = "select CveOfi,DATE_FORMAT(FecOfi, '%d-%m-%Y') FecOfi from poficio where idEdoOfi = 1 AND CveOfi in (select distinct(idOfi) from doficio where idobr = '$idObr') and IdSolPre in (1,3,9) order by FecOfi DESC limit 1";
        $rs = $cnx->Execute($query);
        $data['CveOfi'] = $rs->fields['CveOfi'];
        $data['FecOfi'] = $rs->fields['FecOfi'];
        return $data;
    }

    public function validaObraModifPresu($idObr, $tipoSolicitud, $ejercicio) {
        global $cnx;
        $correspondencias = array();
        $correspondencias["2"] = "1,9";
        $correspondencias["12"] = "3";
        $correspondencias["4"] = "2,10,11,12,13";
        $correspondencias["7"] = "1,2,3,4,9,10,11,12,13";
        $query = "SELECT 
                        distinct(idOfi)
                FROM
                        doficio
                WHERE
                        IdObr = '" . $idObr . "'
                AND idOfi IN (SELECT
                                    CveOfi
                            FROM
                                    poficio
                            WHERE
                                    IdSolPre in (" . $correspondencias[$tipoSolicitud] . ") 
                            AND Ejercicio = '" . $ejercicio . "' 
                            AND FecFir IS NOT NULL 
                            AND idEdoOfi <> 2)";
        $rs = $cnx->Execute($query);
        $numRows = $rs->_numOfRows;
        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

}
