<?php

session_start();

include_once 'oficiosModel.php';

class Oficios {

    var $instanciaOficiosModel;

    function __construct() {
        $this->instanciaOficiosModel = new oficiosModel();
    }

    function getInfoSol($idSol) {
        $dataResponse = array();

        $dataResponse['infoSol'] = $this->instanciaOficiosModel->getInfoSol($idSol);

        return $dataResponse;
    }

    function getInfoSolFtes($idSol) {

        $fteSol = $this->instanciaOficiosModel->getInfoSolFtes($idSol);
        $tipfuente = array('', 'Federal', 'Estatal');
        if ($fteSol) {
            echo "<div style='text-align: right;'><b>Solicitud: " . $idSol . "</b> &nbsp;<button class='btn btn-info' onclick=\"oficioGeneral(" . $idSol . ")\"> Crear Oficio General</button></div><br />";
            echo "<table>"
            . "     <tr>"
            . "<th>Fuente</th>"
            . "<th>Tipo</th>"
            . "<th>Cuenta</th>"
            . "<th>Monto</th>"
            . "<th>% Inversion</th>"
            . "<th>&nbsp;</th>"
            . "     </tr>";
            foreach ($fteSol as $fte) {
                echo "  <tr>"
                . "         <td>" . utf8_encode($fte['DscFte']) . "</td>"
                . "         <td>" . $tipfuente[($fte['tipoFte'])] . "</td>"
                . "         <td>" . $fte['cuenta'] . "</td>"
                . "         <td style='text-align:right'>" . $fte['monto'] . "</td>"
                . "         <td style='text-align:right'>" . $fte['pjeInv'] . "&nbsp;&nbsp;</td>"
                . "         <td><button class='btn btn-warning' onclick=\"llenarInfOficio('" . $idSol . "','" . $fte['idFte'] . "')\"> Crear Oficio </button></td>"
                . "     </tr>"
                . "     <tr><td colspan='6'><div style='height: 2px;'></div></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<div style='font-size: 12px; color: #E70030;'>No se tiene ninguna fuente registrada para la solicitud: " . $idSol . "</div>";
        }

        //return $dataResponse;
    }

    function getHistSol($idObra, $idSol) {
        $dataHist = $this->instanciaOficiosModel->getHistSolObra($idObra, $idSol);

        if ($dataHist) {
            echo "<table>"
            . "     <tr>"
            . "<th>Id Solicitud</th>"
            . "<th>Tipo</th>"
            . "<th>Ejercicio</th>"
            . "<th>Unidad Ejecutora</th>"
            . "<th>Dependencia Responsable</th>"
            . "<th></th>"
            . "     </tr>";

            foreach ($dataHist as $data) {
                if ($data['IdSol'] != null) {
                    $idSol = $data['IdSol'];
                    $dataSol = $this->getInfoSol($idSol);
                    $data = end($dataSol['infoSol']);

                    echo "  <tr>"
                    . "         <td>" . $data['IdSol'] . "</td>"
                    . "         <td>" . ($data['NomSolPre']) . "</td>"
                    . "         <td>" . $data['Ejercicio'] . "</td>"
                    . "         <td>" . ($data['NomUE']) . "</td>"
                    . "         <td>" . ($data['NomSec']) . "</td>"
                    . "         <td><td><button class='btn btn-warning' onclick=\"verInfoSolHist('" . $data['IdObr'] . "', '" . $data['IdSol'] . "')\"> ver Info </button></td>"
                    . "     </tr>";
                }
            }


            echo "</table>";
        } else {
            echo "<div style='font-size: 12px; color: #E70030;'>No se tienen movimientos ninguna fuente registrada para la solicitud: " . $idSol . "</div>";
        }
    }

    function getSolObra($idObra) {

        $dataResponse = array();
        $dataObra = $this->instanciaOficiosModel->getSolObra($idObra);

        $dataResponse['result'] = false;

        if ($dataObra) {
            $dataResponse['idSol'] = $dataObra[0]['IdSol'];
            $dataResponse['result'] = true;
        }

        return $dataResponse;
    }

    function guardarOficio($idSol, $idFte, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idObr, $ejercicio, $tipImpOfi) {
        $dataResponse = array();
        $idusu = $_SESSION['USERID'];
        $idDep = $_SESSION['IDUR'];
        //$res = $this->instanciaOficiosModel->guardarOficio($idSol, $idFte, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idObr, $ejercicio, $tipImpOfi, $idusu, $idDep);

        $idOfi = $this->instanciaOficiosModel->guardarOficioMulObr($titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idSol, $ejercicio, $tipImpOfi, $idusu, $idDep);

        if ($idOfi) {
            $dataResponse['result'] = true;
            $dataResponse['idOfi'] = $idOfi;
            $dataResponse['detOfi'] = array();

            array_push($dataResponse['detOfi'], $this->instanciaOficiosModel->guardarDetOficio($idOfi, $idObr, $idFte));
        }

        return $idOfi;
    }

    function guardarOficioMulObr($titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idSolPre, $ejercicio, $tipImpOfi, $obras) {
        $dataResponse = array();
        $idusu = $_SESSION['USERID'];
        $idDep = $_SESSION['IDUR'];
        $idOfi = $this->instanciaOficiosModel->guardarOficioMulObr($titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto, $idSolPre, $ejercicio, $tipImpOfi, $idusu, $idDep);

        if ($idOfi) {
            $dataResponse['result'] = true;
            $dataResponse['idOfi'] = $idOfi;
            $dataResponse['detOfi'] = array();
            $detOfi = array();
            foreach ($obras as $obra) {

                if (isset($obra['fuentes'])) {
                    foreach ($obra['fuentes'] as $fuente) {
                        array_push($detOfi, $this->instanciaOficiosModel->guardarDetOficio($idOfi, $obra['idObra'], $fuente['fte'], $fuente['montoFte']));
                    }
                } else {
                    array_push($detOfi, $this->instanciaOficiosModel->guardarDetOficio($idOfi, $obra['idObra']));
                }
            }

            $dataResponse['detOfi'] = $detOfi;
        }

        return $dataResponse;
    }

    function getInfoOficio($cveOfi) {
        $dataResponse = array();
        $infoOfi = $this->instanciaOficiosModel->getInfoOficio($cveOfi);
        $isCancelable = $this->instanciaOficiosModel->validaCancelarOficio($cveOfi);
        $dataResponse['result'] = false;
        if ($infoOfi) {
            $dataResponse['result'] = true;
            $dataResponse['info'] = $infoOfi;
            $dataResponse['cancelable'] = $isCancelable;
        }

        return $dataResponse;
    }

    function guardarFechaFirma($fechaFirma, $cveOfi) {
        $dataResponse = array();
        $dataResponse['result'] = false;

        $fechaFirma = explode('-', $fechaFirma);
        $newFech = $fechaFirma[2] . "-" . $fechaFirma[1] . "-" . $fechaFirma[0];

        $result = $this->instanciaOficiosModel->guardarFechaFirma($newFech, $cveOfi);
        if ($result) {
            $dataResponse['result'] = true;
        }

        return $dataResponse;
    }

    function guardarstatusOficio($idEdoOfi, $cveOfi, $tipoSol) {
        $dataResponse = array();
        $dataResponse['result'] = false;

        if ($tipoSol == 2 || $tipoSol == 10 || $tipoSol == 11 || $tipoSol == 12 || $tipoSol == 13) {
            $infObrOfi = $this->instanciaOficiosModel->sumObrOfi($cveOfi);
            $estatusAnterior = $this->instanciaOficiosModel->getEstatusOficio($cveOfi);
            if ($infObrOfi) {

                foreach ($infObrOfi as $infObr) {

                    //update Monto Obra
                    $detObr = $this->instanciaOficiosModel->getSolObra($infObr['idObr']);
                    $montoDisponible = $detObr[0]['MontoDisponible'];

                    $montoUpdate = 0;
                    //si el oficio fue aceptado
                    if ($idEdoOfi == "1") {
                        $montoUpdate = $montoDisponible + $infObr['sum'];
                        $this->instanciaOficiosModel->updateMontoObra($infObr['idObr'], $montoUpdate);
                    }//si el oficio fue cancelado   
                    else if ($idEdoOfi == "2" && $estatusAnterior === "1") {
                        $montoUpdate = $montoDisponible - $infObr['sum'];
                        if ($montoUpdate < 0) {
                            $montoUpdate = 0;
                        }
                        $this->instanciaOficiosModel->updateMontoObra($infObr['idObr'], $montoUpdate);
                    }

                    //update monto fuentes                                    
                    $idSol = $detObr[0]['VerExpTec'];

                    $ftesOfi = $this->instanciaOficiosModel->getFtesOfi($cveOfi, $infObr['idObr']);

                    foreach ($ftesOfi as $fteOfi) {
                        $detFteSol = $this->instanciaOficiosModel->getMontoFteSol($fteOfi['idFte'], $idSol);
                        $disponible = $detFteSol[0]['disponible'];

                        $montoUpdateFte = 0;

                        //si el oficio fue aceptado
                        if ($idEdoOfi == "1") {
                            $montoUpdateFte = $disponible + $fteOfi['montoFte'];
                            $this->instanciaOficiosModel->updateMontoFteSol($fteOfi['idFte'], $idSol, $montoUpdateFte);
                        }//si el oficio fue cancelado   
                        else if ($idEdoOfi == "2" && $estatusAnterior === "1") {
                            $montoUpdateFte = $disponible - $fteOfi['montoFte'];
                            if ($montoUpdateFte < 0) {
                                $montoUpdateFte = 0;
                            }
                            $this->instanciaOficiosModel->updateMontoFteSol($fteOfi['idFte'], $idSol, $montoUpdateFte);
                        }                        

                        //actualizar monto a conceptos de la fuente                        
                        $this->instanciaOficiosModel->updateMontoConceptoFte($fteOfi['idFte'], $idSol, $idEdoOfi);
                    }
                }
            }
        }
        $result = $this->instanciaOficiosModel->guardarStatusOficio($idEdoOfi, $cveOfi);
        if ($result) {
            $dataResponse['result'] = true;
        }

        return $dataResponse;
    }

    function getListadoOficios($fecIni, $fecFin) {
        $dataOficios = $this->instanciaOficiosModel->getInfoOficioLista($fecIni, $fecFin);
        return $dataOficios;
//        if($dataOficios){
//                        
//            foreach($dataOficios as $data){
//                echo "  <tr>"
//                . "         <td>".$data['CveOfi']."</td>"
//                . "         <td>".$data['NomSolPre']."</td>"
//                . "         <td>".$data['IdSol']."</td>"
//                . "         <td>".$data['Ejercicio']."</td>"                        
//                . "         <td>".$data['idObr']."</td>"
//                . "         <td>".$data['NomObr']."</td>"                        
//                . "         <td>".$data['NomEdoOfi']."</td>"                
//                . "     </tr>";                
//            }                                    
//        }
//        else{
//            echo "<tr><td colspan='7'><center><div style='font-size: 12px; color: #E70030;'>No se tienen oficios registrados</div></center></td></tr>";
//        }
    }

    function loadTemplate($ejercicio, $idSol, $idFte) {
        $dataResponse = array();
        $dataResponse['result'] = false;


        $result = $this->instanciaOficiosModel->loadTemplate($ejercicio, $idSol, $idFte);
        if ($result) {
            $dataResponse['result'] = true;
            $dataResponse['info'] = $result;
        }

        return $dataResponse;
    }

    function loadCombos() {
        $dataResponse = array();

        $catSolPre = $this->instanciaOficiosModel->catSolPre();
        if ($catSolPre) {
            $dataResponse['comboTipSol'] = "<option value='0'>Seleccione una opción</option>";
            foreach ($catSolPre as $sol) {
                $dataResponse['comboTipSol'] .= "<option value='" . $sol['IdSolPre'] . "'>" . $sol['NomSolPre'] . "</option>";
            }
        }

        $catEjercicio = $this->instanciaOficiosModel->catEjercicio();
        if ($catEjercicio) {
            $dataResponse['comboEjercicio'] = "<option value='0'>Seleccione una opción</option>";
            foreach ($catEjercicio as $ejercicio) {
                $dataResponse['comboEjercicio'] .= "<option value='" . $ejercicio['Ejercicio'] . "'>" . $ejercicio['Ejercicio'] . "</option>";
            }
        }

        return $dataResponse;
    }

    function buscarObra($ejercicio, $tipSol, $numObr) {
        $dataResponse = array();
        $dataResponse['result'] = false;

        $catObra = $this->instanciaOficiosModel->buscarObra($ejercicio, $tipSol, $numObr);                
        if ($catObra) {
            $dataResponse['result'] = true;
            $dataResponse['info'] = $catObra;
            $dataResponse['numFtes'] = $this->instanciaOficiosModel->getNumFtes($catObra[0]['IdSol']);

            $fuentes = $this->instanciaOficiosModel->getInfoSolFtesParaOficio($catObra[0]['IdSol'], $tipSol, $numObr, $ejercicio);
            if ($fuentes) {
                //
                $dataF = array();
                foreach ($fuentes as $fuente) {
                    array_push($dataF, array_map('utf8_encode', $fuente));
                }
                $dataResponse['infoFtes'] = $dataF;
            } else {
                $dataResponse['result'] = false;
            }
        }

        return $dataResponse;
    }

    function getInfoObra($idObr) {
        $dataResponse = array();
        $dataResponse['result'] = false;

        $catObra = $this->instanciaOficiosModel->getInfoObra($idObr);

        if ($catObra) {
            $dataResponse['result'] = true;
            $dataResponse['info'] = $catObra;
        }

        return $dataResponse;
    }

    function getComboFtes($fuentes) {
        $dataResponse = array();
        $dataResponse['result'] = false;


        $infoFtes = $this->instanciaOficiosModel->getInfoFtes($fuentes);
        if ($infoFtes) {
            $options = "<option value='0'>Selecciona una fuente para cargar la plantilla</option> ";

            foreach ($infoFtes as $fte) {

                $options .= "<option value='" . $fte['idFte'] . "'>" . $fte['DscFte'] . "</option>";
            }

            $dataResponse['result'] = true;
            $dataResponse['combo'] = $options;
        }
        return $dataResponse;
    }

}
