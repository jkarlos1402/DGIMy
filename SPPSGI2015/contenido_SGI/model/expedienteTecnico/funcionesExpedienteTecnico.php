<?php

session_start();
include_once '../../libs/ChromePhp.php';
include_once 'funcionesExpedienteTecnicoModel.php';

class ExpedienteTecnico {

    var $instanciaExpTecModel;

    function __construct() {
        $this->instanciaExpTecModel = new ExpedienteTecnicoModel();
    }

    function buscarAcciones() {
        $combos['accionesFed'] = $this->instanciaExpTecModel->accionesFed();
        $combos['accionesEst'] = $this->instanciaExpTecModel->accionesEst();

        return $combos;
    }

    function buscarUsuarioUni() {

        $usuario = $_SESSION["USER"];
        $idue = $_SESSION["IDUE"];


        $combos['usuarioUni'] = $this->instanciaExpTecModel->usuarioUni($usuario);
        foreach ($combos['usuarioUni'] as $key => $value) {
            if (!isset($uuni)) {
                $uuni = $value;
            } else {
                $uuni .= $value;
            }
        }

        if (!isset($uuni)) {
            $combos['buscarUE'] = $this->instanciaExpTecModel->unidadEjecutora($idue);
            $combos['buscarUR'] = $this->instanciaExpTecModel->unidadResponsable($idue);
        } else {
            $combos['comboUE'] = $this->instanciaExpTecModel->comboUnidadEjecutora();
            $combos['comboUR'] = $this->instanciaExpTecModel->comboUnidadResponsable();
        }

        return $combos;
    }

    //HOJA 2
    function buscarCoberturas() {
        $cobertura = $this->instanciaExpTecModel->consultarCoberturas();
        return $cobertura;
    }

    function buscarCombos() {
        $combos['cobertura'] = $this->instanciaExpTecModel->consultarCoberturas();
        $combos['tiploc'] = $this->instanciaExpTecModel->consultarTipLoc();
        return $combos;
    }

    function combos() {
        $combos['ejercicio'] = $this->instanciaExpTecModel->comboEjercicio();
        $combos['solPre'] = $this->instanciaExpTecModel->comboSolPre();
        $combos['modEje'] = $this->instanciaExpTecModel->comboModEje();
        $combos['tipObr'] = $this->instanciaExpTecModel->comboTipObr();
        $combos['fteFed'] = $this->instanciaExpTecModel->comboFteFed();
        $combos['fteEst'] = $this->instanciaExpTecModel->comboFteEst();
        $combos['fteBco'] = $this->instanciaExpTecModel->comboFteBco();
        $combos['gpoSoc'] = $this->instanciaExpTecModel->comboGpoSoc();
        $combos['metas'] = $this->instanciaExpTecModel->comboMetas();
        $combos['beneficiarios'] = $this->instanciaExpTecModel->comboBeneficiarios();
        $combos['tiploc'] = $this->instanciaExpTecModel->comboTipLoc();

        return $combos;
    }

    function cambioCobertura($tipoCobertura) {

        switch ($tipoCobertura) {
            case 1:
                $respuesta = "vacio";
                break;
            case 2:
                $respuesta = $this->instanciaExpTecModel->consultaRegiones();
                break;
            case 3:
                $respuesta = $this->instanciaExpTecModel->consultaMunicipios();
                break;
        }

        return $respuesta;
    }

    public function guardarHoja3($post) {
        extract($post);
        if (count($conceptosEliminados) > 0) {
            $this->instanciaExpTecModel->removeConceptos($conceptosEliminados);
        }
        if (count($conceptos) > 0) {
            $resp = $this->instanciaExpTecModel->mergeConceptos($conceptos, $idSol, $pp, $relprefte, $modulo, $idSolPre);
        }
        return $resp;
    }

    //funcion para guardar hoja4
    public function guardarHoja4($post) {
        extract($post);
        if (!isset($idContrato)) {
            $idContrato = "";
        }
        if ($tipSol === "1" || $tipSol === "3" || $tipSol === "10" || $tipSol === "11" || $tipSol === "13" || $tipSol === "9") {
            if (count($trabajosEliminados) > 0) {
                $this->instanciaExpTecModel->removeProgramas($trabajosEliminados);
            }
            if (count($trabajosFisicos) > 0) {
                $arrayRespuesta["idProgramas"] = $this->instanciaExpTecModel->mergeProgramas($trabajosFisicos, $idSol, "");
            }
            if (count($avanceFinanciero) > 0) {
                $this->instanciaExpTecModel->updateCalFinaOfSol($avanceFinanciero, $idSol, $idContrato);
            }
        }
        if ($tipSol === "2" || $tipSol === "12" || $tipSol === "10" || $tipSol === "11" || $tipSol === "13" || $tipSol === "9") {
            if (count($contratosEliminados) > 0) {
                $this->instanciaExpTecModel->removeContratos($contratosEliminados);
            }
            if (count($contratos) > 0) {
                $arrayRespuesta["idsContratos"] = $this->instanciaExpTecModel->mergeContratos($contratos, $idSol);
            }
        }
        if ($tipSol === "4") {
            if (count($contratosEliminados) > 0) {
                $this->instanciaExpTecModel->removeContratos($contratosEliminados);
            }
            if (count($contratos) > 0) {
                $arrayRespuesta["idsContratos"] = $this->instanciaExpTecModel->mergeContratos($contratos, $idSol);
            }
        }
        $arrayRespuesta['res'] = "correcto";
        return $arrayRespuesta;
    }

    function buscaSolicitud($id) {
        $idrol = $_SESSION["USERIDROL"];
        $idue = $_SESSION["IDUE"];
        $idusu = $_SESSION['USERID'];
        if ($idrol == 1) {
            $solicitud = $this->instanciaExpTecModel->buscarSolicitud($id, $idue, "");
        } else {
            $solicitud = $this->instanciaExpTecModel->buscarSolicitudArea($id, $idusu);
        }
        if (count($solicitud) > 0) {
            $accSolicitud = $this->instanciaExpTecModel->buscarAccionesFed($id);
            $accSolicitudEst = $this->instanciaExpTecModel->buscarAccionesEst($id);
            $acuSolicitud = $this->instanciaExpTecModel->buscarAcuSolicitud($id);
            $munSolicitud = $this->instanciaExpTecModel->buscarMunSolicitud($id);
            $regSolicitud = $this->instanciaExpTecModel->buscarRegSolicitud($id);
            $contratoSolicitud = $this->instanciaExpTecModel->buscarContratoSolicitud($id);
            $prgSolicitud = $this->instanciaExpTecModel->buscarProgramaSolicitud($id);
            $preSolicitud = $this->instanciaExpTecModel->buscarPresupuestoSolicitud($id);
            $fuentesfed = $this->instanciaExpTecModel->buscarFuentesFed($id);
            $fuentesest = $this->instanciaExpTecModel->buscarFuentesEst($id);
            $banco = $this->instanciaExpTecModel->buscarBancoSol($id);

            $arraySolicitud = array('psolicitud' => $solicitud, 'acciFederal' => $accSolicitud, 'acciEstatal' => $accSolicitudEst, 'acuSolicitud' => $acuSolicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'contratoSolicitud' => $contratoSolicitud, 'prgSolicitud' => $prgSolicitud, 'preSolicitud' => $preSolicitud, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest, 'banco' => $banco);
            return $arraySolicitud;
        } else {
            return false;
        }
    }

    public function getFuentesSeleccionadas($idFuentes) {
        $datos = $this->instanciaExpTecModel->getFuentesH3($idFuentes);

        return $datos;
    }

    public function getHoja3($idSol) {
        $datos['conceptos'] = $this->instanciaExpTecModel->getConceptos($idSol);
        $index = 0;

        foreach ($datos['conceptos'] as $value) {
            $resp = $this->instanciaExpTecModel->getRelPreFte($value['idPresu']);
            if (count($resp) > 0) {
                $datos['preftes'][$index] = $resp;
                $index++;
            } else {
                $datos['preftes'] = '';
            }
        }

        return $datos;
    }

    public function getHoja3Ampliacion($idSol) {
        $datos['conceptos'] = $this->instanciaExpTecModel->getConceptos($idSol);
        $index = 0;

        foreach ($datos['conceptos'] as $value) {
            $resp = $this->instanciaExpTecModel->getRelPreFte($value['idPresu']);
            if (count($resp) > 0) {
                $datos['preftes'][$index] = $resp;
            } else {
                $datos['preftes'][$index] = '';
            }
            $index++;
        }

        return $datos;
    }

    public function getHoja3Reduccion($idSol) {
        $datos['conceptos'] = $this->instanciaExpTecModel->getConceptosReduccion($idSol);
        $index = 0;
//        ChromePhp::log($datos);
        if ($datos['conceptos']) {
            foreach ($datos['conceptos'] as $value) {
                $resp = $this->instanciaExpTecModel->getRelPreFte($value['idPresu']);
                if (count($resp) > 0) {
                    $datos['preftes'][$index] = $resp;
                } else {
                    $datos['preftes'][$index] = '';
                }
                $index++;
            }
        }

        return $datos;
    }

    public function getDatosHoja4($idSol, $tipoSolicitud) {
        if ($tipoSolicitud === "1" || $tipoSolicitud === "3" || $tipoSolicitud === "9") {
            $datos["trabajos"] = $this->instanciaExpTecModel->getTrabajosFisicosSol($idSol);
            $datos["avanceFinancieros"] = $this->instanciaExpTecModel->getAvanceFinaSol($idSol);
        } else if ($tipoSolicitud === "10" || $tipoSolicitud === "11" || $tipoSolicitud === "13") {
            $datos["trabajos"] = $this->instanciaExpTecModel->getTrabajosFisicosSol($idSol);
            $datos["avanceFinancieros"] = $this->instanciaExpTecModel->getAvanceFinaSol($idSol);
            $datos["contratos"] = $this->instanciaExpTecModel->getContratos($idSol, $tipoSolicitud);
        } else {
            $datos["contratos"] = $this->instanciaExpTecModel->getContratos($idSol, $tipoSolicitud);
        }
        return $datos;
    }

    public function guardarHoja1($post) {
        $idue = $_SESSION["IDUE"];
        $idur = $_SESSION["IDUR"];
        $idusu = $_SESSION["USERID"];
        $respuesta = $this->instanciaExpTecModel->guardadoHoja1($post, $idue, $idur, $idusu);

        return $respuesta;
    }

    public function guardarHoja5($post) {
        extract($post);
        $respuesta = $this->instanciaExpTecModel->guardadoHoja5($campo, $idsol);
        return $respuesta;
    }

    public function guardarHoja7($post) {
        extract($post);
        $respuesta = $this->instanciaExpTecModel->guardadoHoja7($criterios, $depnorm, $idsol);
        return $respuesta;
    }

    public function guardarHoja2($post) {
        $respuesta = $this->instanciaExpTecModel->guardadoHoja2($post);
        return $respuesta;
    }

    public function consultaEmpresaByRFC($rfcEmpresa) {
        return $this->instanciaExpTecModel->getEmpresaByRFC($rfcEmpresa);
    }

    public function consultaTiposContratos() {
        return $this->instanciaExpTecModel->getTiposContratos();
    }

    public function consultaModAdjCont() {
        return $this->instanciaExpTecModel->getModAdjCont();
    }

    public function consultaTipObrCont() {
        return $this->instanciaExpTecModel->getTipObrCont();
    }

    public function setEstatusSolicitud($idSol, $estado, $tipoSolicitud) {
        $updateVersion = false;
        switch ($estado) {
            case '3':
                $tipoFecha = "FecEnv";
                break;
            case '4':
                $tipoFecha = "FecIng";
                break;
            case '5':
                $tipoFecha = "FecEval";
                break;
            case '6':
                $tipoFecha = "FecEval";
                if ($tipoSolicitud != "1" && $tipoSolicitud != "10") {
                    $updateVersion = true;
                }
                break;
        }

        $resp = $this->instanciaExpTecModel->setEstatusSolicitud($idSol, $estado, $tipoFecha);
        if ($updateVersion && $resp == "ok") {
            $resp = $this->instanciaExpTecModel->updateVersionSolicitud($idSol);
        }
        return $resp;
    }

    public function setTurno($id, $turno) {
        $resp = $this->instanciaExpTecModel->setTurno($id, $turno);
        return $resp;
    }

    public function obtenerAreas() {
        $data = array();
        $areas = $this->instanciaExpTecModel->catalogoAreas();

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

        $turno = $this->instanciaExpTecModel->obtenerTurnos();
        if ($turno) {
            $dataTurno['turno'] = $turno;
        } else {
            $dataTurno['turno'] = 1;
        }
        return $dataTurno;
    }

    public function ingresaEx($exps) {

        foreach ($exps as $key) {
            $busqueda = $this->instanciaExpTecModel->getExById($key['idsol']);
            if (count($busqueda) > 0) {
//                ChromePhp::log("ACCION:Actualizacion");
                //$resp = $this->instanciaExpTecModel->updateExTurno($key, $busqueda[0]['idSol']);

                $resp = $this->instanciaExpTecModel->updateExTurno($key, $busqueda[0]['idsol']);
            }
        }
        return $resp;
    }

    public function registraTurno($data, $area) {
        if ($data != "Error") {
            $resp = $this->instanciaExpTecModel->registraTurno($data[0], $area, $data[1]);
            return $resp;
        }
    }

    public function getExById($idSol) {
        $data = array();
        $exps = $this->instanciaExpTecModel->getExById($idSol);
        return $exps;
    }

    public function cambiarEstado($idSol, $estado) {
        $respb = $this->instanciaExpTecModel->cambiarEstado($idSol, $estado);
        return $respb;
    }

    public function getEstadoEx() {
        $data = array();
        $estado = $this->instanciaExpTecModel->getEstadoEx();
        $resp = "";
        if ($estado) {
            foreach ($estado as $key) {
                $resp .= "<option value='" . $key["idEdosol"] . "'>" . $key["NomEdo"] . "</option>";
            }
            $data["estados"] = $resp;
        } else {
            $data[] = null;
        }
        return $data;
    }

    public function setObservaciones($idSol, $obs, $reingreso) {
        $resp = $this->instanciaExpTecModel->setObservaciones($idSol, $obs);
//        ChromePhp::log($resp);
        $resp = $this->instanciaExpTecModel->setReingreso($idSol, $reingreso);
        return $resp;
    }

    public function getListadoSolicitudes($idue, $fecIni, $fecFin) {
        return $this->instanciaExpTecModel->getListadoSolicitudes($idue, $fecIni, $fecFin);
    }

    public function getObservaciones($idSol) {
        return $this->instanciaExpTecModel->getObservaciones($idSol);
    }

    public function getObraSolicitud($idObr, $tipoSolicitud) {
        if ($this->instanciaExpTecModel->validaObraModifPresu($idObr, $tipoSolicitud, date("Y"))) {
            $solicitud = $this->instanciaExpTecModel->getObraSolicitud($idObr, $tipoSolicitud);
            if (count($solicitud) > 0) {
                $arraySolicitud = array('psolicitud' => $solicitud);
            } else {
                $arraySolicitud = "false";
            }
        } else {
            $arraySolicitud = "false";
        }
        return $arraySolicitud;
    }

    function buscaBanco($id) {
        $banco = $this->instanciaExpTecModel->buscarBanco($id);
        if (count($banco) > 0) {
            $idue = $_SESSION["IDUE"];
            $solicitud = $this->instanciaExpTecModel->buscarSolicitud($banco, $idue, "");
            if (count($solicitud) > 0) {
                $accSolicitud = $this->instanciaExpTecModel->buscarAccionesFed($banco);
                $accSolicitudEst = $this->instanciaExpTecModel->buscarAccionesEst($banco);
                $acuSolicitud = $this->instanciaExpTecModel->buscarAcuSolicitud($banco);
                $munSolicitud = $this->instanciaExpTecModel->buscarMunSolicitud($banco);
                $regSolicitud = $this->instanciaExpTecModel->buscarRegSolicitud($banco);
                $fuentesfed = $this->instanciaExpTecModel->buscarFuentesFed($banco);
                $fuentesest = $this->instanciaExpTecModel->buscarFuentesEst($banco);
                $arraySolicitud = array('psolicitud' => $solicitud, 'acciFederal' => $accSolicitud, 'acciEstatal' => $accSolicitudEst, 'acuSolicitud' => $acuSolicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest);
                return $arraySolicitud;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getExpTById($idSol) {
        $data = array();
        $data = $this->instanciaExpTecModel->getExpTById($idSol);
        return $data;
    }

    public function getDictamen($idSol) {
        $resp = $this->instanciaExpTecModel->getDictamen($idSol);
        return $resp;
    }

    public function cloneExpedienteTecnico($idSol, $idTipo, $idObr, $clonDict) {
        $idSolNew = $this->instanciaExpTecModel->cloneExpedienteTecnico($idSol);
        $this->instanciaExpTecModel->cambiarTipoSolicitud($idSolNew, $idTipo);
        $this->instanciaExpTecModel->updateObraSol($idSolNew, $idObr);
        if ($idTipo == "3" || $idTipo = "4" || $idTipo == "12" || $idTipo == "13") { //Si es Ampliacion asignacion clonar contratos y programas
            $this->instanciaExpTecModel->cloneConceptos($idSol, $idSolNew);

            $contratos = $this->instanciaExpTecModel->cloneContratos($idSol, $idSolNew);

            $this->instanciaExpTecModel->updateContratoPadre($idSolNew, $contratos);

            $this->instanciaExpTecModel->cloneProgramas($idSol, $idSolNew);

            $this->instanciaExpTecModel->updateConceptoContrato($idSolNew, $contratos);

            $this->instanciaExpTecModel->updateProgramaContrato($idSolNew, $contratos);
            
            $this->instanciaExpTecModel->updateApContrato($idObr, $contratos);
        }
        if ($clonDict == "1") {
            $this->instanciaExpTecModel->updateRelSolBco($idSol, $idSolNew);
        }
        $this->instanciaExpTecModel->cloneRelAcuSol($idSol, $idSolNew);
        $this->instanciaExpTecModel->cloneRelMunSol($idSol, $idSolNew);
        $this->instanciaExpTecModel->cloneRelRegSol($idSol, $idSolNew);
        $resp = $this->instanciaExpTecModel->cloneRelSolFte($idSol, $idSolNew);
        return $resp;
    }

    public function obtenersol($idsol, $ejercicio) {
        $infsol = $this->instanciaExpTecModel->obtenersol($idsol, $ejercicio);
        //la informacion por default es false, si se btienen registros cambia a True y se complementa la informacion
        $datasol['resultado'] = FALSE;

        if ($infsol) {
            $datasol['resultado'] = TRUE;
            $datasol['infsol'] = $infsol;
        }

        return $datasol;
    }

    public function guardadoHoja1EstSoc($post) {
        //print_r($_SESSION);
        $idue = $_SESSION["IDUE"];
        //echo "idue::".$idue;
        $idur = $_SESSION["IDUR"];
        //echo "idur::".$idur;
        $idusu = $_SESSION['USERID'];

        $respuesta = $this->instanciaExpTecModel->guardadoHoja1EstSoc($post, $idue, $idur, $idusu);

        return $respuesta;
    }

    public function guardadoHoja2EstSoc($post) {
        $respuesta = $this->instanciaExpTecModel->guardadoHoja2EstSoc($post);
        return $respuesta;
    }

    public function verificaAutorizacion($usuario, $pass) {
        $respuesta = $this->instanciaExpTecModel->verificaAutorizacion($usuario, $pass);
        return $respuesta;
    }

    public function getInfoBco($numBco) {
        $dataResponse = array();
        $infoSolBco = $this->instanciaExpTecModel->getInfoSol($numBco);

        $idSol = $this->instanciaExpTecModel->buscarBanco($numBco);
        if ($idSol) {
            $infoAccFteFed = $this->instanciaExpTecModel->buscarAccionesFed($idSol);
            $infoAccFteEst = $this->instanciaExpTecModel->buscarAccionesEst($idSol);

            $infoFteFed = $this->instanciaExpTecModel->buscarFuentesFed($idSol);
            $infoFteEst = $this->instanciaExpTecModel->buscarFuentesEst($idSol);

            $infoCobMun = $this->instanciaExpTecModel->buscarMunSolicitud($idSol);
            $infoCobReg = $this->instanciaExpTecModel->buscarRegSolicitud($idSol);
        }

        if (count($infoSolBco) == 0) {
            $dataResponse['infoRes'] = false;
        } else {
            $dataResponse['infoRes'] = true;
            $dataResponse['infoSol'] = $infoSolBco;
            $dataResponse['infoAccFed'] = $infoAccFteFed;
            $dataResponse['infoAccEst'] = $infoAccFteEst;
            $dataResponse['infoFteFed'] = $infoFteFed;
            $dataResponse['infoFteEst'] = $infoFteEst;
            $dataResponse['infoCobMun'] = $infoCobMun;
            $dataResponse['infoCobReg'] = $infoCobReg;
        }
        return $dataResponse;
    }

    function buscaObra($id, $tipoObra) {
        $idSol = $this->instanciaExpTecModel->buscarObra($id);
        if (count($idSol) > 0) {
            $idue = $_SESSION["IDUE"];
            $solicitud = $this->instanciaExpTecModel->buscarSolicitud($idSol, $idue, $tipoObra);
            if (count($solicitud) > 0) {
                $accSolicitud = $this->instanciaExpTecModel->buscarAccionesFed($idSol);
                $accSolicitudEst = $this->instanciaExpTecModel->buscarAccionesEst($idSol);
                $acuSolicitud = $this->instanciaExpTecModel->buscarAcuSolicitud($idSol);
                $munSolicitud = $this->instanciaExpTecModel->buscarMunSolicitud($idSol);
                $regSolicitud = $this->instanciaExpTecModel->buscarRegSolicitud($idSol);
                $banco = $this->instanciaExpTecModel->buscarIdBanco($idSol);

                $arraySolicitud = array('psolicitud' => $solicitud, 'acciFederal' => $accSolicitud, 'acciEstatal' => $accSolicitudEst, 'acuSolicitud' => $acuSolicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'banco' => $banco);
                return $arraySolicitud;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function buscaSol($id, $tipoObra) {
        $idSol = $this->instanciaExpTecModel->buscarObra($id);
        if (count($idSol) > 0) {
            $idue = $_SESSION["IDUE"];
            $solicitud = $this->instanciaExpTecModel->buscarSol($idSol, $idue, $tipoObra);
            if (count($solicitud) > 0) {
                $accSolicitud = $this->instanciaExpTecModel->buscarAccionesFed($idSol);
                $accSolicitudEst = $this->instanciaExpTecModel->buscarAccionesEst($idSol);
                $acuSolicitud = $this->instanciaExpTecModel->buscarAcuSolicitud($idSol);
                $munSolicitud = $this->instanciaExpTecModel->buscarMunSolicitud($idSol);
                $regSolicitud = $this->instanciaExpTecModel->buscarRegSolicitud($idSol);
                $fuentesfed = $this->instanciaExpTecModel->buscarFuentesFed($idSol);
                $fuentesest = $this->instanciaExpTecModel->buscarFuentesEst($idSol);
                $banco = $this->instanciaExpTecModel->buscarIdBanco($idSol);

                $arraySolicitud = array('psolicitud' => $solicitud, 'acciFederal' => $accSolicitud, 'acciEstatal' => $accSolicitudEst, 'acuSolicitud' => $acuSolicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'banco' => $banco, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest);
                return $arraySolicitud;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function guardarFuentes($post) {
        $respuesta = $this->instanciaExpTecModel->guardadoFuentes($post);
        return $respuesta;
    }

    function montosCancelar($idObra) {
        $montoFed = $this->instanciaExpTecModel->buscarMontosFed($idObra);
        $montoEst = $this->instanciaExpTecModel->buscarMontosEst($idObra);
        if (count($montoFed) > 0 && count($montoEst) > 0) {
            $montos = array('montoFed' => $montoFed, 'montoEst' => $montoEst);
            return $montos;
        } else {
            return false;
        }
    }

    public function obtenerDatos($idSol) {
        $extda = $this->instanciaExpTecModel->ExtracDatos($idSol);
        $data = array('psolicitud' => $extda);
        return $data;
    }

    public function obtenerDatos2($idSol) {
        $extda = $this->instanciaExpTecModel->ExtracDatos2($idSol);
        $data = array('psolicitud' => $extda);
        return $data;
    }

    public function obtenerDatos3($idSol) {
        $extda = $this->instanciaExpTecModel->ExtracDatos3($idSol);
        $data = array('psolicitud' => $extda);
        return $data;
    }

    public function guardarMontos($post) {
        extract($post);
//        ChromePhp::log($post);
        if ($idobsol == 6) {
            if($tipoSol == 2 || $tipoSol == 12 || $tipoSol == 4 || $tipoSol == 7){
//                ChromePhp::log($solpre);
                $montos = $this->instanciaExpTecModel->guardarMontoAutorizado($idsol, $montoInv);
            }else if($tipoSol==3){
                $montos = $this->instanciaExpTecModel->guardarMontoAsignado($post);
            }elseif ($tipoSol==13) {
                $montos = $this->instanciaExpTecModel->guardarMontoAsignadoAut($post);
            }
            if (count($montos) > 0) {
                return $montos;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function cancelarMontos($post) {
        $respuesta = $this->instanciaExpTecModel->canceladoMontos($post);
        return $respuesta;
    }

    public function consultasObras($fecIni, $fecFin) {
        $idusu = $_SESSION['USERID'];
        $obra = $this->instanciaExpTecModel->consultarObras($idusu, $fecIni, $fecFin);
        $oficios = $this->instanciaExpTecModel->consultarObrasOficios($idusu);
        $Ap = $this->instanciaExpTecModel->consultarObrasAp($idusu);
        $data = array('obra' => $obra, 'oficios' => $oficios, 'ap' => $Ap);
        return $data;
    }

    public function solicitudesObras($idObr) {
        return $this->instanciaExpTecModel->solicitudesObras($idObr);
    }

    public function guardaAsigAdic($post) {
        $idue = $_SESSION["IDUE"];
        $idur = $_SESSION["IDUR"];
        $idusu = $_SESSION["USERID"];
        $respuesta = $this->instanciaExpTecModel->guardadoAsigAdic($post, $idue, $idur, $idusu);
        return $respuesta;
    }

    public function oficiosObras($idObr) {
        return $this->instanciaExpTecModel->oficiosObras($idObr);
    }

    public function apObras($idObr) {
        return $this->instanciaExpTecModel->apObras($idObr);
    }

    public function actualizarIdUsu($sol) {
        $idusu = $_SESSION["USERID"];
        $respuesta = $this->instanciaExpTecModel->actualizarIdUsu($sol, $idusu);
        return $respuesta;
    }

    function buscaSolicitudAct($id) {
        $idrol = $_SESSION["USERIDROL"];
        $idue = $_SESSION["IDUE"];
        $idusu = $_SESSION['USERID'];
        $obra = $this->instanciaExpTecModel->buscarSolObra($id);
        if ($obra > 0) {
            if ($idrol == 1) {
                $solicitud = $this->instanciaExpTecModel->buscarSolicitud($id, $idue);
            } else {
                $solicitud = $this->instanciaExpTecModel->buscarSolicitudArea($id, $idusu);
            }
            if (count($solicitud) > 0) {
                $accSolicitud = $this->instanciaExpTecModel->buscarAccionesFed($id);
                $accSolicitudEst = $this->instanciaExpTecModel->buscarAccionesEst($id);
                $acuSolicitud = $this->instanciaExpTecModel->buscarAcuSolicitud($id);
                $munSolicitud = $this->instanciaExpTecModel->buscarMunSolicitud($id);
                $regSolicitud = $this->instanciaExpTecModel->buscarRegSolicitud($id);
                $contratoSolicitud = $this->instanciaExpTecModel->buscarContratoSolicitud($id);
                $prgSolicitud = $this->instanciaExpTecModel->buscarProgramaSolicitud($id);
                $preSolicitud = $this->instanciaExpTecModel->buscarPresupuestoSolicitud($id);
                $fuentesfed = $this->instanciaExpTecModel->buscarFuentesFed($id);
                $fuentesest = $this->instanciaExpTecModel->buscarFuentesEst($id);
                $banco = $this->instanciaExpTecModel->buscarBancoSol($id);

                $arraySolicitud = array('psolicitud' => $solicitud, 'acciFederal' => $accSolicitud, 'acciEstatal' => $accSolicitudEst, 'acuSolicitud' => $acuSolicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'contratoSolicitud' => $contratoSolicitud, 'prgSolicitud' => $prgSolicitud, 'preSolicitud' => $preSolicitud, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest, 'banco' => $banco);
                return $arraySolicitud;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getOficioAsigObr($idObr) {
        $respuesta = $this->instanciaExpTecModel->getOficioAsignacionObr($idObr);
        return $respuesta;
    }

}
