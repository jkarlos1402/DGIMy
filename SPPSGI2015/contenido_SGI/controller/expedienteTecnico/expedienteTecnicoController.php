<?php

include_once '../../libs/ChromePhp.php';
include '../../model/expedienteTecnico/funcionesExpedienteTecnico.php';


if ($_POST) {
    //se obtienen los elementos del post como variables    
    extract($_POST);

    //si en las variables obtenidas se encuentra la variable de accion continuamos con el caso de la accion recibida
    if (isset($accion) && !empty($accion)) {

        $expedienteTecnico = new ExpedienteTecnico();

        switch ($accion) {
            case "buscarAcciones":
                $espacio = " ";
                $puntos = "...";
                $rAccionesFed = '';
                $rAccionesEst = '';
                foreach ($_SESSION['catalogos']['accionesFederales'] as $key => $rows) {
                    $rAccionesFed .= "<option value='" . $rows[0] . "'>" . $rows[1] . "" . $espacio . "" . utf8_encode($rows[2]) . "</option>";
                }
                foreach ($_SESSION['catalogos']['accionesEstatales'] as $key => $rows2) {
                    $rAccionesEst .= "<option value='" . $rows2[0] . "'>" . $rows2[1] . "" . $espacio . "" . utf8_encode($rows2[2]) . "</option>";
                }

                $combos['accionesFed'] = $rAccionesFed;
                $combos['accionesEst'] = $rAccionesEst;
                echo json_encode($combos);
                break;
            case "buscarUsuarioUni":
                $data = $expedienteTecnico->buscarUsuarioUni();
                $uuni = '';
                $idue = '';
                $idur = '';

                if (count($data['usuarioUni']) == 0) {
                    $uuni .= "";
                } else {
                    foreach ($data['usuarioUni'] as $key => $value) {
                        $uuni .= $value;
                    }
                }

                if (!isset($data['buscarUE'])) {
                    $idue .= "<input disabled type='text' id='ue' name='ue' class='form-control' value='0'>";
                } else {
                    foreach ($data['buscarUE'] as $key => $value) {
                        $idue .= "<input disabled type='text' id='ue' name='ue' class='form-control' value='$value'>";
                    }
                }

                if (!isset($data['buscarUR'])) {
                    $idur .= "<input disabled type='text' id='ur' name='ur' class='form-control' value='0'>";
                } else {
                    foreach ($data['buscarUR'] as $key => $value) {
                        $idur .= "<input disabled type='text' id='ur' name='ur' class='form-control' value='$value'>";
                    }
                }

                if (!isset($data['comboUE'])) {
                    $rComboUE = "<option value=0>Selecciona...</option>";
                } else {
                    $rComboUE = "<option value=0>Selecciona...</option>";
                    foreach ($data['comboUE'] as $key => $rows) {
                        $rComboUE .= "<option value='" . $rows['idue'] . "'>" . utf8_encode($rows['nomue']) . "</option>";
                    }
                }

                if (!isset($data['comboUR'])) {
                    $rComboUR = "<option value=0>Selecciona...</option>";
                } else {
                    $rComboUR = "<option value=0>Selecciona...</option>";
                    foreach ($data['comboUR'] as $key => $rows) {
                        $rComboUR .= "<option value='" . $rows['idsec'] . "'>" . utf8_encode($rows['nomsec']) . "</option>";
                    }
                }

                $combos['buscarUE'] = $idue;
                $combos['buscarUR'] = $idur;
                $combos['comboUE'] = $rComboUE;
                $combos['comboUR'] = $rComboUR;
                $combos['usuarioUni'] = $uuni;

                echo json_encode($combos);
                break;
            case "guardaHoja3":
                $data = $expedienteTecnico->guardarHoja3($_POST);
                echo json_encode($data);
                break;
            case "guardaHoja4":
                $data = $expedienteTecnico->guardarHoja4($_POST);
                echo json_encode($data);
                break;
            case "llenarcombos":
                $espacio = " ";
                $data = $expedienteTecnico->combos();

                $rEjercicio = "<option value=''>Selecciona...</option>";
                foreach ($data['ejercicio'] as $key => $rows) {
                    $rEjercicio .= "<option value='" . $rows . "'>" . $rows . "</option>";
                }

                $rSolPre = "<option value=''>Selecciona...</option>";
                foreach ($data['solPre'] as $key => $rows) {
                    $rSolPre .= "<option value='" . $rows['idsolpre'] . "'>" . utf8_encode($rows['nomsolpre']) . "</option>";
                }

                $rModEje = "<option value=''>Selecciona...</option>";
                foreach ($data['modEje'] as $key => $rows) {
                    $rModEje .= "<option value='" . $rows['idmodeje'] . "'>" . utf8_encode($rows['nommodeje']) . "</option>";
                }

                $rTipObr = "<option value=''>Selecciona...</option>";
                foreach ($data['tipObr'] as $key => $rows) {
                    $rTipObr .= "<option value='" . $rows['idtipobr'] . "'>" . utf8_encode($rows['nomtipobr']) . "</option>";
                }

                $rFteFed = "<option value=''>Selecciona...</option>";
                foreach ($data['fteFed'] as $key => $rows) {
                    $rFteFed .= "<option value='" . $rows['idFte'] . "'>" .  utf8_encode($rows['DscFte']) . "</option>";
                }

                $rFteEst = "<option value=''>Selecciona...</option>";
                foreach ($data['fteEst'] as $key => $rows) {
                    $rFteEst .= "<option value='" . $rows['idFte'] . "'>" .  utf8_encode($rows['DscFte']) . "</option>";
                }
                
                $rFteBco = "<option value=''>Selecciona...</option>";
                foreach ($data['fteBco'] as $key => $rows) {
                    $rFteBco .= "<option value='" . $rows['idFteBco'] . "'>" . utf8_encode($rows['NomFteBco']) . "</option>";
                }

                $rGpoSoc = "<option value=''>Selecciona...</option>";
                foreach ($data['gpoSoc'] as $key => $rows) {
                    $rGpoSoc .= "<option value='" . $rows['idgpo'] . "'>" . $rows['Nomgpo'] . "</option>";
                }

                $rMetas = "<option value=''>Selecciona...</option>";
                foreach ($data['metas'] as $key => $rows) {
                    $rMetas .= "<option value='" . $rows['idmet'] . "'>" . utf8_encode($rows['NomMet']) . "</option>";
                }

                $rBeneficiarios = "<option value=''>Selecciona...</option>";
                foreach ($data['beneficiarios'] as $key => $rows) {
                    $rBeneficiarios .= "<option value='" . $rows['idben'] . "'>" . utf8_encode($rows['nomben']) . "</option>";
                }
                
                $rTipCobertura = "<option value=''>Selecciona...</option>";
                foreach ($data['tiploc'] as $key => $rows) {
                    $rTipCobertura .= "<option value='" . $rows['idTipLoc'] . "'>" . utf8_encode($rows['NomTipLoc']) . "</option>";
                }

                $combos['ejercicio'] = $rEjercicio;
                $combos['solPre'] = $rSolPre;
                $combos['modEje'] = $rModEje;
                $combos['tipObr'] = $rTipObr;
                $combos['fteFed'] = $rFteFed;
                $combos['fteEst'] = $rFteEst;
                $combos['fteBco'] = $rFteBco;
                $combos['gpoSoc'] = $rGpoSoc;
                $combos['metas'] = $rMetas;
                $combos['beneficiarios'] = $rBeneficiarios;
                $combos['tiploc'] = $rTipCobertura;

                echo json_encode($combos);
                break;

            //HOJA 2
            case "consultaCoberturas":
                $data = $expedienteTecnico->buscarCoberturas();
                $comboRespuesta = "<option value=0>Selecciona...</option>";
                foreach ($data as $key => $rows) {
                    $comboRespuesta .= "<option value='" . $rows['IdCob'] . "'>" . $rows['NomCob'] . "</option>";
                }

                echo $comboRespuesta;
                break;
                
            case "llenarCombos":
                $data = $expedienteTecnico->buscarCombos();
                
                $rcobertura = "<option value=''>Selecciona...</option>";
                foreach ($data['cobertura'] as $key => $rows) {
                    $rcobertura .= "<option value='" . $rows['IdCob'] . "'>" . $rows['NomCob'] . "</option>";
                }
                
                $rtiploc = "<option value=''>Selecciona...</option>";
                foreach ($data['tiploc'] as $key => $rows) {
                    $rtiploc .= "<option value='" . $rows['idTipLoc'] . "'>" . $rows['NomTipLoc'] . "</option>";
                }
                
                $combos['cobertura'] = $rcobertura;
                $combos['tiploc'] = $rtiploc;
                
                echo json_encode($combos);
                break;

            case "cambioCobertura":
                $comboRegMun = "";
                $data = $expedienteTecnico->cambioCobertura($tipoCobertura);
                switch ($tipoCobertura) {
                    case 2:
                        foreach ($data as $key => $rows) {
                            $comboRegMun .= "<option value='" . $rows['IdReg'] . "'>" . $rows['CveReg'] . " " . utf8_encode($rows['NomReg']) . "</option>";
                        }
                        break;
                    case 3:
                        foreach ($data as $key => $rows) {
                            $comboRegMun .= "<option value='" . $rows['IdMun'] . "'>" . utf8_encode($rows['NomMun']) . "</option>";
                        }
                        break;
                }
                echo $comboRegMun;
                break;

            case "buscaSolicitud":
                $data = $expedienteTecnico->buscaSolicitud($id);
                echo json_encode($data);
                break;

            case "getFuentesSeleccionadas":
                $data = $expedienteTecnico->getFuentesSeleccionadas($idFuentes);
                $comboFteSelec = "<option value='-1'>Seleccione una fuente...</option>";
                foreach ($data as $key => $rows) {
                    $comboFteSelec .= "<option value='" . $rows['idFte'] . "'>" .utf8_encode($rows['DscFte']) . "</option>";
                }
                echo $comboFteSelec;
                break;

            case "getHoja3":
//                ChromePhp::log($idSol);
                $data = $expedienteTecnico->getHoja3($idSol);
                echo json_encode($data);
                break;
            case "getHoja3Ampliacion":
                $data = $expedienteTecnico->getHoja3Ampliacion($idSol);
                echo json_encode($data);
                break;
            case "getHoja3Reduccion":
                $data = $expedienteTecnico->getHoja3Reduccion($idSol);
                echo json_encode($data);
                break;

            case "getDatosHoja4":
                $data = $expedienteTecnico->getDatosHoja4($idSol, $tipoSolicitud);
                if ($tipoSolicitud === "1" || $tipoSolicitud === "3" || $tipoSolicitud === "10" || $tipoSolicitud === "11" || $tipoSolicitud === "13" || $tipoSolicitud === "9") {
                    for ($i = 0; $i < count($data["trabajos"]); $i++) {
                        $data["trabajos"][$i]["acciones"] = '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>';
                        $data["trabajos"][$i][15] = '<span  class="glyphicon glyphicon glyphicon-pencil editaAvaFis" style="cursor:pointer;" onClick="editaAvaFis(this);"></span><span  class="glyphicon glyphicon-remove eliminaAvaFis" style="cursor:pointer;" onClick="eliminaAvaFis(this);"></span>';
                    }
                }
                echo json_encode($data);
                break;

            case "consultaRFC":
                $data = $expedienteTecnico->consultaEmpresaByRFC($rfcEmpresa);
                echo json_encode($data);
                break;            

            case "combosContratos":
                $tipos = $expedienteTecnico->consultaTiposContratos();

                $comboTipos = '<option value="">Seleccione</option>';
                foreach ($tipos as $tipo) {
                    $comboTipos .= '<option value="' . $tipo["idTipContr"] . '">' . $tipo["tipoContrato"] . '</option>';
                }
                $combos["tipos"] = $comboTipos;
                $modAdjs = $expedienteTecnico->consultaModAdjCont();
                $comboModos = '<option value="">Seleccione</option>';
                foreach ($modAdjs as $modAdj) {
                    $comboModos .= '<option value="' . $modAdj["idmod"] . '">' . $modAdj["dscmod"] . '</option>';
                }
                $combos["modAdj"] = $comboModos;
                $tipoObrContrs = $expedienteTecnico->consultaTipObrCont();
                $comboTipObrContr = '<option value="">Seleccione</option>';
                foreach ($tipoObrContrs as $tipoObrContr) {
                    $comboTipObrContr .= '<option value="' . $tipoObrContr["idtipo"] . '">' . $tipoObrContr["dsctipo"] . '</option>';
                }
                $combos["tipObrContr"] = $comboTipObrContr;
                echo json_encode($combos);
                break;

            case "guardaHoja1":
                $data = $expedienteTecnico->guardarHoja1($_POST);
                echo json_encode($data);
                break;

            case "guardaHoja5":
                $data = $expedienteTecnico->guardarHoja5($_POST);
                echo json_encode($data);
                break;

            case "guardaHoja7":
                $data = $expedienteTecnico->guardarHoja7($_POST);
                echo json_encode($data);
                break;

            case "guardaHoja2":
                $data = $expedienteTecnico->guardarHoja2($_POST);
                echo json_encode($data);
                break;

            case "guardadoHoja1EstSoc":
                $data = $expedienteTecnico->guardadoHoja1EstSoc($_POST);
                echo json_encode($data);
                break;

            case "guardadoHoja2EstSoc":
                $data = $expedienteTecnico->guardadoHoja2EstSoc($_POST);
                echo json_encode($data);
                break;

            case "cabiarEstatusET":
                if(is_array($idSol)){
                    foreach ($idSol as $id){
                        $data = $expedienteTecnico->setEstatusSolicitud($id[0], $estado,$tipoSolicitud);
                        if($data){
                            $data2= $expedienteTecnico->setTurno($id[0],$turno);
                        }
                    }
                }else{
                    
                    $data = $expedienteTecnico->setEstatusSolicitud($idSol, $estado,$tipoSolicitud);
                }
                
                echo ($data);
                break;

            case "buscarFolio":
                $data = $expedienteTecnico->getExById($idsol);
                echo json_encode($data);
                break;

            case "consultaArea":
                $data = $expedienteTecnico->obtenerAreas();
                echo $data["areas"];
                break;

            case "consultaTurnos":
                $data = $expedienteTecnico->obtenerTurnos();
                echo $data["turno"];
                break;

            case "guardarObservaciones":
                $data = $expedienteTecnico->setEstatusSolicitud($idSol, $estado,$tipoSolicitud);
//                ChromePhp::log("SET STATUS:".$data);
                if ($data == "ok") {
                    $data2 = $expedienteTecnico->setObservaciones($idSol, $obs,$reingreso);
                } else {
                    $data2 = "error";
                }
//                 ChromePhp::log("SET OBSERVACION:".$data2);
                echo ($data2);
                break;

            case "getSolicitudesPorDependencia":
                $idue = $_SESSION["IDUE"];
                $data = $expedienteTecnico->getListadoSolicitudes($idue, $fecIni, $fecFin);
                echo json_encode($data);
                break;

            case "getObservaciones":
                $data = $expedienteTecnico->getObservaciones($idSol);
                echo json_encode($data);
                break;

            case "buscaBanco":
                $data = $expedienteTecnico->buscaBanco($id);
                echo json_encode($data);
                break;
            case "getObraSolicitud":
                $data = $expedienteTecnico->getObraSolicitud($idObr, $tipoSolicitud);
                echo json_encode($data);
                break;

            case "getExpTById":
                
                $data = $expedienteTecnico->getExpTById($idsol);
                 echo json_encode($data);
                break;

            case "consultasol":
                //obtiene la informacion de la obra
                $data = $expedienteTecnico->obtenersol($idsol, $ejercicio);
                echo json_encode($data);
                break;

            case "cloneSolicitud":
                if ($EvaSoc == "1") { //Incluye Estudio
                    $dict = $expedienteTecnico->getDictamen($idSol);
                    
                    if ($dict[0]["Status"] == "6")  { //Estudio Aceptado
                        $data = $expedienteTecnico->cloneExpedienteTecnico($idSol, $idTipo, $idObr,"1");
                    } else {
                        $data = "false";
                    }
                } else { //No incluye Estudio
                    $data = $expedienteTecnico->cloneExpedienteTecnico($idSol, $idTipo, $idObr,"0");
                }
                echo $data;
                break;
                
            case "verificaAutorizacion":                
                $data = $expedienteTecnico->verificaAutorizacion($usuario,$pass);                
                echo $data;
                break;
            
            case "consultaNumBco":
                $data = json_encode($expedienteTecnico->getInfoBco($numBco));
                echo $data;
                break;
            
            case "buscaObra":
                $data = $expedienteTecnico->buscaObra($id, $tipoObra);
                echo json_encode($data);
                break;
            
            case "buscaSol":
                $data = $expedienteTecnico->buscaSol($id, $tipoObra);
                echo json_encode($data);
                break;
            
            case "guardaFuentes":
                $data = $expedienteTecnico->guardarFuentes($_POST);
                echo json_encode($data);
                break;
            
            case "montosCancelar":
                $data = $expedienteTecnico->montosCancelar($idObra);
                echo json_encode($data);
                break;
            
            case "llenaExp":
                $data = $expedienteTecnico->llenaPdf($nombreArea, $ex);
                echo $data;
                break; 
            
            case "consultaDatos":
                $data = $expedienteTecnico->obtenerDatos($idSol);
                echo json_encode($data);
                break;
            
            case "consultaDatos2":
                $data = $expedienteTecnico->obtenerDatos2($idSol);
                echo json_encode($data);
                break;
            
            case "consultaDatos3":
                $data = $expedienteTecnico->obtenerDatos3($idSol);
                echo json_encode($data);
                break;
            
            case "guardarMontos":
                $data = $expedienteTecnico->guardarMontos($_POST);
                echo json_encode($data);
                break;
            
            case "getContratosHoja4":
                $data = $expedienteTecnico->getDatosHoja4($idSol, "");
                echo json_encode($data);
                break;
            
            case "cancelarMontos":
                $data = $expedienteTecnico->cancelarMontos($_POST);
                echo json_encode($data);
                break;
            
            case "consultasObras":
                $data = $expedienteTecnico->consultasObras($fecIni, $fecFin);
                echo json_encode($data);
                break;
            
            case "solicitudesObras":
                $data = $expedienteTecnico->solicitudesObras($idObr);
                echo json_encode($data);
                break;
            
            case "guardaAsigAdic":
                $data = $expedienteTecnico->guardaAsigAdic($_POST);
                echo json_encode($data);
                break;
            
            case "oficiosObras":
                $data = $expedienteTecnico->oficiosObras($idObr);
                echo json_encode($data);
                break;
            
            case "apObras":
                $data = $expedienteTecnico->apObras($idObr);
                echo json_encode($data);
                break;
            
            case "actualizarIdUsu":
                $data = $expedienteTecnico->actualizarIdUsu($sol);
                echo json_encode($data);
                break;
            
            case "buscaSolicitudAct":
                $data = $expedienteTecnico->buscaSolicitudAct($id);
                echo json_encode($data);
                break;
            case "getOficioAsignacionObr":
                $data = $expedienteTecnico->getOficioAsigObr($idObr);
                echo json_encode($data);
                break;
        }
    }
}
?>
