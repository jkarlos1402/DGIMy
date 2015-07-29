<?php

session_start();
include_once '../../libs/ChromePhp.php';
include_once 'bancoModel.php';

class Banco {

    var $instanciabanco;

    function __construct() {
        $this->instanciabanco = new BancoModel();
    }

    public function getInfoBcoSol($rolUsu, $idUsu) {
        $dataResponse = array();

        $infoSolBco = $this->instanciabanco->getInfoBancoSol($rolUsu, $idUsu);

        if (count($infoSolBco) == 0) {
            $dataResponse['infoRes'] = false;
        } else {
            foreach ($infoSolBco as $key => $infoBco) {
//                echo $infoBco['IdSol'];
                $lastMov = ($this->instanciabanco->getLastMovBco($infoBco['IdBco']));
                $lastMovA = ($lastMov[0]);

                $infoSolBco[$key]['tipMov'] = $lastMovA['tipMov'];
                $infoSolBco[$key]['fecMov'] = $lastMovA['fecMov'];
                $infoSolBco[$key]['status'] = $lastMovA['status'];
                $infoSolBco[$key]['obs'] = $lastMovA['obs'];
            }
            $dataResponse['infoData'] = $infoSolBco;
            $dataResponse['infoRes'] = true;
        }

        return $dataResponse;
    }

    public function guardarStatusBanco($data) {
        $dataResponse = array();

        $resQry = $this->instanciabanco->insertStatus($data);
        if ($resQry) {
            $dataResponse['infores'] = true;
        } else {
            $dataResponse['infores'] = false;
        }

        return $dataResponse;
    }

    public function obtenerInfoSol($idBco, $status) {
        $dataResponse = array();

        $resQry = $this->instanciabanco->getInfoSol($idBco, $status);
        
        if (count($resQry) > 0) {
            $lastMovBco = $this->instanciabanco->getLastMovBco($idBco);
            $movBco = $lastMovBco[0];
            $dataResponse['tipMov'] = $movBco['tipMov'];
            $dataResponse['obs'] = $resQry[0]['obs'];

            $existMovBco = $this->instanciabanco->existMovBco($idBco, 3);
            $idSol = $resQry[0]['IdSol'];

            $resFed = $this->instanciabanco->getMontosFte($idSol, '1');
            $resFteFed = '';
            if (count($resFed) > 0) {
                foreach ($resFed as $fed) {
                    $resFteFed.="<div><b>" . number_format($fed['monto'], 2, '.', ',') . "</b>&nbsp;(" . $fed['DscFte'] . ")</div>";
                }
            }

            $resEst = $this->instanciabanco->getMontosFte($idSol, '2');
            $resFteEst = '';
            if (count($resEst) > 0) {
                foreach ($resEst as $est) {
                    $resFteEst.="<div><b>" . number_format($est['monto'], 2, '.', ',') . "</b>&nbsp;(" . $est['DscFte'] . ")</div>";
                }
            }

            $resEstSol = $this->instanciabanco->getEstSol($idSol);
            
            if($resEstSol != false){
                $infoEstSol = false;
                $infoDetEva = false;
                for ($i = 0; $i < count($resEstSol); $i++) {   
                    $idEva = $resEstSol[$i]['IdEva']; 
                    $resEstSol[$i]['infoDetEva'] = $this->instanciabanco->getDetEva($idEva, 'resp');
                }
            }
            
            $dataResponse['infoRes'] = true;
            $dataResponse['infoData'] = $resQry;
            $dataResponse['infoFteFed'] = $resFteFed;
            $dataResponse['infoFteEst'] = $resFteEst;
            $dataResponse['infoDictamen'] = (int) $existMovBco;
            $dataResponse['infoEstSol'] = $resEstSol;
            $dataResponse['infoDetEva'] = $infoDetEva;
        } else {
            $dataResponse['infoRes'] = false;
        }
        return $dataResponse;
    }

    public function obtenerCombos() {
        $dataResponse = array();

        $resEva = $this->instanciabanco->catTipEva();
        $comboTipEva = "<option value='0'>--Selecciona una opci&oacute;n</option>";
        foreach ($resEva as $tipEva) {
            $comboTipEva .="<option value='" . $tipEva['IdTipEva'] . "'>" . $tipEva['NomTipEva'] . "</option>";
        }
        $dataResponse['catTipEva'] = $comboTipEva;

        $resEva = $this->instanciabanco->catPPI();
        $comboTipEva = "<option value='0'>--Selecciona una opci&oacute;n</option>";
        foreach ($resEva as $tipEva) {
            $comboTipEva .="<option value='" . $tipEva['IdPPI'] . "'>" . $tipEva['NomPPI'] . "</option>";
        }
        $dataResponse['catPPI'] = $comboTipEva;

        return $dataResponse;
    }

    public function obtenerTipEva($idTipEva) {

        $catPunto = $this->instanciabanco->getCatPunto($idTipEva);
        $idElem = 0;
        foreach ($catPunto as $pto) {
            echo '  <tr><td class="col-sm-12 text-center" colspan="12"><b>' . $pto['NomPto'] . '</b></td></tr>';

            $catInciso = $this->instanciabanco->getCatInciso($pto['IdPto']);
            foreach ($catInciso as $inciso) {
                $etiqueta = !empty($inciso['Etiqueta']) ? $inciso['Etiqueta'] . '. ' : '';
                echo '  <tr><td class="col-sm-12 text-left" colspan="12"><b>' . $etiqueta . '</b>&nbsp;' . $inciso['NomInc'] . '</td></tr>';

                $catSubInc = $this->instanciabanco->getSubInc($inciso['IdInc']);
                if (count($catSubInc) > 0) {

                    foreach ($catSubInc as $subInc) {
                        $etiqueta = isset($subInc['Etiqueta']) ? $subInc['Etiqueta'] : '';
                        echo '  <tr id="row_' . $subInc['IdSubInc'] . '" class="' . $idElem . '">
                                    <td colspan="3" class="col-sm-4 text-left">' . $etiqueta . '&nbsp;' . $subInc['NomSub'] . '</td>
                                    <td colspan="2" class="col-sm-2">
                                    <div class="text-center">
                                       <label class="radio-inline">
                                       <input type="hidden" name="subInc_' . $idElem . '" id="subInc_' . $idElem . '" value="' . $subInc['IdSubInc'] . '" />
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp1_' . $idElem . '" value="1" class="radio_send" onclick="changeRadio(0, ' . $idElem . ')"/>Si
                                       </label>
                                       <label class="radio-inline">
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp2_' . $idElem . '" value="2" class="radio_send" onclick="changeRadio(1, ' . $idElem . ')"/>No
                                       </label>
                                       <label class="radio-inline">
                                       <input type="radio" name="idResp_' . $idElem . '" id="idResp3_' . $idElem . '" value="3" class="radio_send" checked="checked" onclick="changeRadio(0, ' . $idElem . ')" />NA
                                       </label>
                                    </div>
                                    </td>
                                    <td class="col-sm-2">
                                       <div>
                                           <input type="text" name="taPag_' . $idElem . '" id="taPag_' . $idElem . '" class="form-control input-sm text_send" readonly />
                                       </div>
                                    </td>
                                    <td class="col-sm-4">
                                       <div>
                                           <textarea name="taObs_' . $idElem . '" id="taObs_' . $idElem . '" class="form-control input-sm area_send" rows="1" maxlength="1000" readonly></textarea>
                                       </div>
                                    </td>    
                                </tr>';
                        $idElem++;
                    }
                }
            }
        }
    }

    public function guardarEvaluacion($datos, $observaciones, $generales) {
//        ChromePhp::log($datos);
        $dataResponse = array();
        $estatusBco = $this->instanciabanco->getEstatusBco($generales['IdBco']);
        //si viene el check de ingreso fisico se guarda aun cuando se tengan observaciones o se dictamine
        if (isset($generales['IngresoFisico'])) {
            if ($generales['IngresoFisico'] !== "false" && $generales['IngresoFisico'] !== "") {
                // 4. Ingreso               
                $data = array('idBco' => $generales['IdBco'], 'status' => '4', 'FecIng' => $generales['IngresoFisico'], 'observaciones' => $generales['Observaciones']);
                $this->instanciabanco->insertStatus($data);
                $dataResponse['ingresoFisico'] = true;
            }
        }

        if ($generales['AccionSeguir'] === "1" || $generales['AccionSeguir'] === "2") {
            //update con el tipo de evaluacion en la tabla psolicitud
            $this->instanciabanco->guardaTipEva($datos['IdSol'], $generales['IdTipEva']);
            $idEva = 0;
            if (count($observaciones) > 0) {

                //se borran los registros anteriores de las observaciones
                // $this->instanciabanco->delDetEva($datos['IdSol']);
                //guarda la informacion de las observaciones, recupera el IdEva
                if ($estatusBco === "4") {
                    $idEva = $this->instanciabanco->guardaDetEva($datos['IdSol'], $observaciones, true);
                } else {
                    $idEva = $this->instanciabanco->guardaDetEva($datos['IdSol'], $observaciones, false);
                }
                //Guarda la informaicon de Indicadores de rentailidad
                $datos['Observaciones'] = $generales['Observaciones'];
                $this->instanciabanco->guardarEstSol($datos, $idEva, false);
            }

            //Dependiendo el tipo de accion a seguir se guarda un status u otro
            //si es el caso 1 = Guardar el status de movBco se cambia a 5
            if ($generales['AccionSeguir'] === "1") {
                // 5. Revision
                $data = array('idBco' => $generales['IdBco'], 'status' => '5', 'observaciones' => utf8_decode($generales['Observaciones']));
                $this->instanciabanco->insertStatus($data);
                $dataResponse['ingresoFisico'] = false;
            }
            //si es el caso 2 = Enviar observaciones a dependencia el status de movBco se cambia a 2
            else if ($generales['AccionSeguir'] === "2") {
                // 2. Edicion                
                $data = array('idBco' => $generales['IdBco'], 'status' => '2', 'observaciones' => utf8_decode($generales['Observaciones']));
                $this->instanciabanco->insertStatus($data);
                $dataResponse['ingresoFisico'] = false;
            }

            $dataResponse['observaciones'] = true;
            $dataResponse['idBco'] = $generales['IdBco'];
            $dataResponse['idEva'] = $idEva;
            $dataResponse['AccionSeguir'] = $generales['AccionSeguir'];
        } else if ($generales['AccionSeguir'] === "3") {

            //update con el tipo de evaluacion en la tabla psolicitud
            $resUpdate = $this->instanciabanco->guardaTipEva($datos['IdSol'], $generales['IdTipEva']);
            if (count($observaciones) > 0) {
                //se borran los registros anteriores de las observaciones
//                $this->instanciabanco->delDetEva($datos['IdSol']);                
                if ($estatusBco === "5") {
                    $idEva = $this->instanciabanco->guardaDetEva($datos['IdSol'], $observaciones, false);
                } else {
                    $idEva = $this->instanciabanco->guardaDetEva($datos['IdSol'], $observaciones, true);
                }
            }
            $datos['Observaciones'] = $generales['Observaciones'];
            $this->instanciabanco->guardarEstSol($datos, $idEva, false);
            // 6. Aceptado
            $data = array('idBco' => $generales['IdBco'], 'status' => '6', 'observaciones' => utf8_decode($generales['Observaciones']));
            $this->instanciabanco->insertStatus($data);

            $numDictamen = $this->instanciabanco->maxDictamen();
            $this->instanciabanco->updateDictamen($generales['IdBco'], $numDictamen);

            $dataResponse['dictamen'] = $numDictamen;
            $dataResponse['idBco'] = $generales['IdBco'];
        }

        return $dataResponse;
    }

    public function revisaBloqueo($post) {

        $data = $this->instanciabanco->getLastMovBco($post['numBco']);
        $response['bloqueo'] = 0;
        $response['tipMov'] = "";
        if ($data) {
            $data = end($data);
            if (strtolower($data['status']) == 'bloqueado') {
                $response['bloqueo'] = 1;
            }
            $response['tipMov'] = $data['tipMov'];
        }

        return $response;
    }

    public function consultaEstSol($idSol) {
        $solicitudes = array();
        $solicitudes = $this->instanciabanco->getEstSol($idSol);
        if (($solicitudes)) {
            for ($i = 0; $i < count($solicitudes); $i++) {
                $obs = $this->instanciabanco->getDetEva($solicitudes[$i]['IdEva']);
                if ($obs) {
                    $solicitudes[$i]["opcion"] = "<div onclick=\"mostrarObs('" . $solicitudes[$i]['IdEva'] . "')\" class='btn btn-warning' >obs</div>";
                    $solicitudes[$i][13] = "<div onclick=\"mostrarObs('" . $solicitudes[$i]['IdEva'] . "')\" class='btn btn-warning' >obs</div>";
                } else {
                    $solicitudes[$i]["opcion"] = "";
                    $solicitudes[$i][13] = "";
                }
            }
        }
        return $solicitudes;
    }

    public function consultaDetEva($idEva) {
        $obs = $this->instanciabanco->getDetEva($idEva);
//        echo "<table id='lista2'>"
//        . "     <tr>"
//        . "     <td>Inciso</td>"
//        . "     <td>Observaciones</td>"
//        . " </tr>";
//        foreach ($obs as $ob) {
//            echo "<tr><td>" . $ob['NomSub'] . "</td><td>" . $ob['Observa'] . "</td></tr>";
//        }
//        echo "<table>";        
        return $obs;
    }

}
