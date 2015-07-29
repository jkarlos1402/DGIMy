<?php

session_start();
include_once '../../libs/ChromePhp.php';
include_once 'funcionesObraModel.php';

class Obra {
    
    var $instanciaObra;

    function __construct() {
        $this->instanciaObra = new ObraModel();
    }
 
    function buscaSolicitud($id) {
        $idusu = $_SESSION['USERID'];
        $solicitud = $this->instanciaObra->buscarSolicitud($id, $idusu);
        if (count($solicitud) > 0) {
            $munSolicitud = $this->instanciaObra->buscarMunSolicitud($id);
            $regSolicitud = $this->instanciaObra->buscarRegSolicitud($id);
            $fuentesfed = $this->instanciaObra->buscarFuentesFed($id);
            $fuentesest = $this->instanciaObra->buscarFuentesEst($id);
            
            $Solicitud = array('psolicitud' => $solicitud, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest);
            return $Solicitud;
        } else {
            return false;
        }
    }
    
    function buscaSolObra($id) {
        $obra = $this->instanciaObra->buscarObra($id);
        if (count($obra) > 0) {
            $idusu = $_SESSION['USERID'];
            $solicitud = $this->instanciaObra->buscarSolicitudObra($obra, $idusu);
            $clapry = $this->instanciaObra->buscarObraClaObr($id);
            if(count($solicitud) > 0){
                $munSolicitud = $this->instanciaObra->buscarMunSolicitud($obra);
                $regSolicitud = $this->instanciaObra->buscarRegSolicitud($obra);
                $fuentesfed = $this->instanciaObra->buscarFuentesFed($obra);
                $fuentesest = $this->instanciaObra->buscarFuentesEst($obra);
                $idproyecto = $this->instanciaObra->buscarIdPry($id);
                if(count($idproyecto) > 0){
                    $programa = $this->instanciaObra->buscarPrg($idproyecto);
                    $proyecto = $this->instanciaObra->buscarPry($id);
                }
                $Solicitud = array('psolicitud' => $solicitud, 'clapry' => $clapry, 'munSolicitud' => $munSolicitud, 'regSolicitud' => $regSolicitud, 'fuentesfed' => $fuentesfed, 'fuentesest' => $fuentesest, 'programa' => $programa, 'proyecto' => $proyecto);
                return $Solicitud;
            }else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    function buscaPrograma($ejercicio) {
        $programa['programa'] = $this->instanciaObra->buscarPrograma($ejercicio);
        if (count($programa['programa']) > 0) {
            return $programa;
        } else {
            return false;
        }
    }
    
    function buscaProyecto($prg, $ejercicio) {
        $proyecto['proyecto'] = $this->instanciaObra->buscarProyecto($prg, $ejercicio);
        if (count($proyecto['proyecto']) > 0) {
            return $proyecto;
        } else {
            return false;
        }
    }
    
    function guardaObra($post) {
        $registro = $this->instanciaObra->guardarObra($post);
        return $registro;
    }

    function modificarObra($post) {
        $registro = $this->instanciaObra->modificarObra($post);
        return $registro;
    }
    
    function buscaClaPry() {
        $clapry['clapry'] = $this->instanciaObra->buscarClaPry();
        if (count($clapry['clapry']) > 0) {
            return $clapry;
        } else {
            return false;
        }
    }
}
