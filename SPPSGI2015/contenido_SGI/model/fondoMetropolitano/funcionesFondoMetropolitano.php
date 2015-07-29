<?php include 'fondoMetropolitanoModel.php';

class FondoMetropolitano{
    
    var $insFondoMetropolitano;
    
    function __construct(){ 
        
        $this->insFondoMetropolitano = new fondoMetropolitanoModel();
    } 
       
    public function getEjercicios(){        
        
        $data['result']=false;
        $catEje = $this->insFondoMetropolitano->getEjercicios();
        
        if($catEje){
            $data['result']=true;    
            $data['ejercicio']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catEje as $eje){
                $data['ejercicio'] .= "<option value='".$eje['Ejercicio']."'>".$eje['Ejercicio']."</option>";
            }
        }
        return $data;        
    }    
    
    public function getFuentes(){
        $data['result']=false;
        $catFte = $this->insFondoMetropolitano->getFuentes();
        
        if($catFte){
            $data['result']=true;    
            $data['fuente']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catFte as $fte){
                $data['fuente'] .= "<option value='".$fte['IdFte']."'>".$fte['NomFte']."</option>";
            }
        }
        return $data;
    }
    
     public function getSectores(){
        $data['result']=false;
        $catSector = $this->insFondoMetropolitano->getSectores();
        
        if($catSector){
            $data['result']=true;    
            $data['sector']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catSector as $sec){
                $data['sector'] .= "<option value='".$sec['IdSec']."'>".$sec['NomSec']."</option>";
            }
        }
        return $data;
    }
    
    public function getGrupoSocial(){
        $data['result']=false;
        $catGpoSocial = $this->insFondoMetropolitano->getGrupoSocial();
        
        if($catGpoSocial){
            $data['result']=true;    
            $data['grupoSocial']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catGpoSocial as $sec){
                $data['grupoSocial'] .= "<option value='".$sec['IdGpo']."'>".$sec['NomGpo']."</option>";
            }
        }
        return $data;
    }


    public function getUE($idSector){
        $data['result']=false;
        $catUE = $this->insFondoMetropolitano->getUE($idSector);
        
        if($catUE){
            $data['result']=true;    
            $data['ue']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catUE as $cue){
                $data['ue'] .= "<option value='".$cue['IdUE']."'>".$cue['NomUE']."</option>";
            }
        }
        return $data;
    }
    
    public function getTipOfi(){
        $data['result']=false;
        $catTipOfi = $this->insFondoMetropolitano->getTipOfi();
        
        if($catTipOfi){
            $data['result']=true;    
            $data['catTipOfi']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catTipOfi as $cTipOfi){
                $data['catTipOfi'] .= "<option value='".$cTipOfi['IdTipOfi']."'>".$cTipOfi['NomTipOfi']."</option>";
            }
        }
        return $data;
    }
    
    public function getSesion($ejercicio){
        $data['result']=false;
        $catSesion = $this->insFondoMetropolitano->getSesion($ejercicio);
        
        if($catSesion){
            $data['result']=true;    
            $data['catSesion']="<option value='0'>Seleccione una opci&oacute;n</option>";
            
            foreach($catSesion as $cSes){
                $data['catSesion'] .= "<option value='".$cSes['IdSesion']."'>".$cSes['NomSes']."</option>";
            }
        }
        return $data;
    }
    
    public function getInfopFonMet($cvePry){
        $data['result']=false;
                
        $res = $this->insFondoMetropolitano->getInfopFM($cvePry);                
        
        if($res){
            $data['result']=true;
            $data['pFonMet']=$res;
        }
        
        return $data;
    }
    
    public function getDetalleFonMet($cvePry, $ejercicio){
        $data['result']=false;
                
        $res = $this->insFondoMetropolitano->getInfoDetFM($cvePry, $ejercicio);                
        
        if($res){
            $data['result']=true;
            $data['detFonMet']=$res;
        }
        
        return $data;
    }
    
    public function guardarSesion($ejercicio, $fecha, $sesion){
        $data['result']=false;
        
        $newDate = date("Y-m-d", strtotime($fecha));
        $res = $this->insFondoMetropolitano->guardarSesion($ejercicio, $newDate, $sesion);
        
        if($res){
            $data['result']=true;
        }
        
        return $data;
    }        
    
    public function gridSesiones($ejercicio){
        $data['result']=false;
                
        $res = $this->insFondoMetropolitano->infoGridSesiones($ejercicio);                
        
        if($res){
            $data['result']=true;
            $data['grid']=$res;
        }
        
        return $data;
    }
    
    public function borrarSesion($idSesion){
        $data['result'] = false;
        $data['exist'] = true;
        
        $sesionOficiosExist = $this->insFondoMetropolitano->getSesionExistOficios($idSesion);
        
        if(!$sesionOficiosExist){
        
            $res = $this->insFondoMetropolitano->borrarSesion($idSesion);
        
            if($res){
                $data['result']=true;            
                $data['exist'] = false;
            }
        }    
        
        return $data;
    }
    
    public function guardarDatos($datos){
        $data['result'] = false;
        
        $maxConsec = $this->insFondoMetropolitano->maxConsecutivoFonMet();
        
        $idConsecutivo = 0;
        
        if($maxConsec){
            $idConsecutivo = $maxConsec[0]['NumPry']+1;
        }
        
        $cons = substr('000'.$idConsecutivo, -4);
        
        if($datos['idFte']==1){            
            $cvePry = 'FMVM'.$cons;
        }
        else{
            $cvePry = 'FMVT'.$cons;
        }
        
        $idpFontMet = $this->insFondoMetropolitano->guardarDatosPfon($datos['idFte'], $datos['nomPry'], $cvePry, $idConsecutivo);

        if($idpFontMet){
            $data['result']=true;            
            $data['detalle']['idpFontMet'] = $idpFontMet;
            $data['detalle']['cveFonMet'] = $cvePry;
            
            
            $idDetFontMet = $this->insFondoMetropolitano->guardarDatosDetFon($idpFontMet, $datos['ejercicio'], $datos['idUe'], $datos['avanceFisico'], $datos['terminado'], $datos['observaciones'], $datos['grupoSocial']);
            $data['detalle']['idDetFontMet'] = $idDetFontMet;
            
        }
        
        
        return $data;
    }
    
    public function guardarModificarDatos($datos){
        $data['result'] = false;

        if($datos['idFte']==1){            
            $cvePry = str_replace('FMVT', 'FMVM', $datos['cveProy']);
        }
        else{
            $cvePry = str_replace('FMVM', 'FMVT', $datos['cveProy']);
        }
        
        $res = $this->insFondoMetropolitano->updateDatospFon($datos['idFonMet'],$datos['idFte'],$datos['nomPry'], $cvePry);
        if($res){
            $data['result'] = true;
            $data['cvePry'] = $cvePry;
            $this->insFondoMetropolitano->updateDatosDetFon($datos['idDetFon'],$datos['ejercicio'], $datos['idUe'], $datos['avanceFisico'], $datos['terminado'], $datos['observaciones'], $datos['grupoSocial']);
        }
        return $data;
        
    }
    
    public function guardarNuevoEjercicio($datos){
        $data['result'] = false;
        
        $idDetFontMet = $this->insFondoMetropolitano->guardarDatosDetFon($datos['idFonMet'], $datos['ejercicio'], $datos['idUe'], $datos['avanceFisico'], $datos['terminado'], $datos['observaciones'], $datos['grupoSocial']);
        if($idDetFontMet){
            $data['result'] = true;
            $data['detalle']['idDetFontMet'] = $idDetFontMet;
        }
        
        return $data;
        
    }
    
    public function guardarPlantilla($ejercicio, $fuente, $tipOfi, $texto){
        $data['result'] = false;
        
        $checkPlantilla = $this->insFondoMetropolitano->checkPlantilla($ejercicio, $fuente, $tipOfi);
                
        if(!$checkPlantilla){
            $idTxt = $this->insFondoMetropolitano->guardarPlantilla($ejercicio, $fuente, $tipOfi, $texto);
        
            if($idTxt){
                $data['result'] = true;
                $data['idTxt']= $idTxt;
            }
        }
        else{
            $idTxt = $checkPlantilla[0]['IdTxtFon'];
            
            $this->insFondoMetropolitano->actualizarTextoPlantilla($idTxt, $texto);
            
            if($idTxt){
                $data['result'] = true;
                $data['idTxt']= $idTxt;
            }
        }
        
        
        
        
        return $data; 
    }
    
    public function listaProyectosEjercicio($ejercicio, $fuente, $ue){
        $resultLista = $this->insFondoMetropolitano->listaProyectos($ejercicio,$fuente,$ue);
        
        if($resultLista){
            foreach($resultLista as $lista){
                echo "  <tr><td colspan='4'>&nbsp;</td></tr>";
                echo "  <tr id='".$lista['IdDetFon']."' class='rowGrid'>"
                . "     <td style='vertical-align: middle'><input type='checkbox' name='proyectosAgregar' id='check_".$lista['IdDetFon']."' value='".$lista['IdDetFon']."'></td>"    
                . "     <td style='vertical-align: middle' id='cve_".$lista['IdDetFon']."'>".$lista['CvePry']."</td>"    
                . "     <td style='vertical-align: middle' id='nom_".$lista['IdDetFon']."'>".utf8_decode($lista['NomPry'])."</td>"    
                . "     <td style='vertical-align: middle'><input type='text' name='monto' id='monto_".$lista['IdDetFon']."' class='form-control  small montoInput' style='text-align: right'></td>"    
                . "     </tr>";
            }    
        }
        else{
            echo "<tr><td colspan='4'><div class='mensajeRojo'>No existen Proyectos para el ejercicio ".$ejercicio."</div></td></tr>";
        }
        echo "Ejercicio".$ejercicio;
    }
    
    public function guardarDepositos($idDetFon, $datos){
        $data['result'] = false;
        
        if(count($datos)>0){
            $data['result'] = true;
            
            $this->insFondoMetropolitano->borrarDepositos($idDetFon);
            
            foreach($datos as $dato){
                $newDate = date("Y-m-d", strtotime($dato['fecha']));
                $this->insFondoMetropolitano->guardarDeposito($idDetFon, $newDate, $dato['monto']);
            }
            
        }                                
    }
    
    public function getDepositos($idDetFon){
        $data['result']=false;
        
        $depositos = $this->insFondoMetropolitano->getDepositos($idDetFon);
        
        if($depositos){
            $data['result']=true;
            $data['depositos']=$depositos;
        }
        
        return $data;
    }
    
    public function getPlantillaOficio($ejercicio, $fuente, $tipOfi){
        $data['result']=false;
        
        $plantilla = $this->insFondoMetropolitano->checkPlantilla($ejercicio, $fuente, $tipOfi);                
        
        if($plantilla){
            $data['result']=true;
            $data['plantilla']=$plantilla;
        }
        
        return $data;
    }
    
    public function guardarOficio($datosOfi, $datos){
        
        $meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
               'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        
        $data['result']=false;
        
        $maxConsec = $this->insFondoMetropolitano->maxConsecutivoOfiFon();
        
        $idConsecutivo = 1;
        
        if($maxConsec){
            $idConsecutivo = $maxConsec[0]['IdOfiFon']+1;
        }
        
        $cons = substr('00'.$idConsecutivo, -3);
        
        
        if($datosOfi['fuente']==1){            
            $cveOfi = $cons.'FM/'.substr($datosOfi['ejercicio'],-2,2);            
        }
        else{
            $cveOfi = $cons.'FT/'.substr($datosOfi['ejercicio'],-2,2);            
        }
        
        $newDate = date("Y-m-d", strtotime($datosOfi['fecha']));
        
        $infoSesion = $this->insFondoMetropolitano->getInfoSesion($datosOfi['sesion']);                
                        
        $sesion = '';        
        $dia = 'de hoy';
        
        if($infoSesion){
            $sesion = $infoSesion[0]['NomSes'];
            if($infoSesion[0]['FecSes']!=$newDate){                
                $fecha = explode('-',$infoSesion[0]['FecSes']);
                
                $dia= $fecha[2]." de ".$meses[((int)$fecha[1])]." de ".$fecha[0];
            }
        }                
        
        if($datosOfi['tipOfi']==2){
            $tipo = "cancelación";
        }
        else{
            $tipo = "asignación";
        }                
        
        $texto2 ='En la '.$sesion.' celebrada el día '.$dia.', se acordó la '.$tipo.' de recursos del Fondo Metropolitano '.$datosOfi['ejercicio']." a los siguietes proyectos: \n" ;
        
        $idpOfi = $this->insFondoMetropolitano->guardarpOficio($datosOfi['tipOfi'], $cveOfi, $datosOfi['sesion'], $newDate, $datosOfi['texto'], $texto2, $datosOfi['titular'], $datosOfi['ccp'] );
        
        if($idpOfi){
            $data['result']=true;
            $data['idOfiFon'] = $idpOfi;
            $data['CveOfi'] = $cveOfi;
            $data['idsDetalle']=array();
            foreach($datos as $dato){
                $idDet = $this->insFondoMetropolitano->guardarDetOfi($idpOfi, $dato['idDetFon'], $dato['monto']);
                
                array_push($data['idsDetalle'], $idDet);                
            }            
        }
        
        return $data;
    }
    
    public function getTitularCopias($ue, $sector){
        $data['resultTitular']=false;                
        $data['resultCopias']=false;                
        
        $resTit = $this->insFondoMetropolitano->getTitular($ue);           
        if($resTit){
            $data['resultTitular']= $resTit[0]['Titulo']."\n".
                                    $resTit[0]['NomTit']." ".$resTit[0]['ApeTit']."\n".
                                    $resTit[0]['CarTit'];            
        }
        
        $ccp = "";
        
        $resCopias = $this->insFondoMetropolitano->getCcp();
        $ccp .= "C.C.P.  ".$resCopias[0]['NomSrv']." - ".$resCopias[0]['CarSrv']."\n";                
        
        $ccpSector = $this->insFondoMetropolitano->getccpSectorUE($ue);        
        if($ccpSector){
            $ccp .= "            ".$ccpSector[0]['NomSrv']." - ".$ccpSector[0]['CarSrv']."\n";            
        }        
        
        //si el sector es diferente de dearrollo urbano y metropolitano se agrega el setor del query
        if($sector!=12){
            $ccp .= "            ".$resCopias[1]['NomSrv']." - ".$resCopias[1]['CarSrv']."\n";            
        }           
        
        $ccp .= "            ".$resCopias[2]['NomSrv']." - ".$resCopias[2]['CarSrv']."\n";        
        
        $ccpDirArea = $this->insFondoMetropolitano->getccpDirArea($sector);                
        $ccp .= "            ".$ccpDirArea[0]['TitRes']." ".$ccpDirArea[0]['NomRes']." ".$ccpDirArea[0]['ApeRes']." - ".$ccpDirArea[0]['CarRes'];       
        
        $data['resultCopias']= $ccp;
        
        return $data;
    }
    
}

?>