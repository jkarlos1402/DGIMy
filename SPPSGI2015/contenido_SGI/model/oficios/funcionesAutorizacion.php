<?php include 'funcionesAutorizacionModel.php';

class Autorizaciones{
    
    var $insAutorizacionModel;
    
    function __construct(){ 
        //crea de inicio la Instancia para el modelo de datos de Autorizaciones        
        $this->insAutorizacionModel = new autorizacionModel();      	
    } 
    
    public function codifica($string){
        return ($string);
    }
    public function obtenerOficio($claveOficio){ 
        
        $infOficio = $this->insAutorizacionModel->revisaOficio($claveOficio);
        //por default la informacion del resultado es FALSE, si se obtienen registros se cambia a TRUE
        
        
        if($infOficio){
            $dataOficio['resultado'] = TRUE;
            $dataOficio['infOficio'] = $infOficio;        
        }
        else{
            $dataOficio['resultado'] = FALSE;
            $nextId = end($this->insAutorizacionModel->maxOficio());
            $dataOficio['nextId'] = $nextId['nextId'];        
        }
        
        return $dataOficio;
        
    }
    
    public function obtenerAnexo($cveOficio, $fecha){        
        
        $data = $this->insAutorizacionModel->getAnexo($cveOficio, $fecha);        
        return $data;
        
    }
    
    public function obtenerOficioClave($claveOficio){ 
        
        $infOficio = $this->insAutorizacionModel->revisaOficioClave($claveOficio);
        //por default la informacion del resultado es FALSE, si se obtienen registros se cambia a TRUE
        
        $dataOficio['resultado'] = FALSE;
            
        if($infOficio){
            $dataOficio['resultado'] = TRUE;
            $dataOficio['infOficio'] = $infOficio;        
        }        
        return $dataOficio;        
    }
    
    public function obtenerObra($idObra, $ejercicio){
        $infObra = $this->insAutorizacionModel->obtenerObra($idObra, $ejercicio); 
        //la informacion por default es false, si se btienen registros cambia a True y se complementa la informacion
        $dataObra['resultado'] = FALSE;
        
        if($infObra){
            $dataObra['resultado'] = TRUE;
            $dataObra['infObra'] = $infObra; 
        }
        
        return $dataObra;
        
    }
    
    public function obtenerDep($idDep, $addlike){
        $infDep = $this->insAutorizacionModel->obtenerDependencia($idDep, $addlike); 
        //la informacion por default es false, si se btienen registros cambia a True y se complementa la informacion
        $dataDep['resultado'] = FALSE;
        
        if($infDep){
            $dataDep['resultado'] = TRUE;
            $dataDep['infDependencia'] = $infDep; 
        }
        
        return $dataDep;
    }

    public function obtenerDepLetra($Dep, $addlike){
        $infDep = $this->insAutorizacionModel->obtenerDependenciaLetra($Dep, $addlike); 
        
        //la informacion por default es false, si se btienen registros cambia a True y se complementa la informacion
        $dataDep['resultado'] = FALSE;
        
        if($infDep){
            $dataDep['resultado'] = TRUE;
            $dataDep['infDependencia'] = $infDep; 
        }
        
        return $dataDep;
    }
    
    public function infoSelects(){
        
        $data = array();
        
        $tipOficios = $this->insAutorizacionModel->tipOficios();        
                
        if($tipOficios){
            $txt = '';
            foreach($tipOficios as $key => $val){                
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[1]) ."</option>"; 
            }
            $data['tipOficios'] = $txt;
        }  
        
        $ejercicios = $this->insAutorizacionModel->catEjercicio();
        if($ejercicios){
            $txt = '';
            foreach($ejercicios as $key => $val){
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[0]) ."</option>"; 
            }
            $data['ejercicios'] = $txt;
        }
        
        $estadOficios = $this->insAutorizacionModel->estadOficios();
        if($estadOficios){
            $txt = '';
            foreach($estadOficios as $key => $val){
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[2]) ."</option>"; 
            }
            $data['estadOficios'] = $txt;
        }
        
        $catRecuros = $this->insAutorizacionModel->catRecursos();
        if($catRecuros){
            $txt = '';
            foreach($catRecuros as $key => $val){
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[2]) ."</option>"; 
            }
            $data['catRecursos'] = $txt;
        }
        
        $catFuentes = $this->insAutorizacionModel->catFuentes();
        if($catFuentes){
            $txt = '';
            foreach($catFuentes as $key => $val){
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[2]) ."</option>"; 
            }
            $data['catFuentes'] = $txt;
        }
        
        $catInversiones = $this->insAutorizacionModel->catInversion();
        if($catInversiones){
            $txt = '';
            foreach($catInversiones as $key => $val){
                $txt .= "<option value='".$val[0]."'>". $this->codifica($val[2]) ."</option>"; 
            }
            $data['catInversiones'] = $txt;
        }
        
        
        return $data;
    }
    
    public function guardarPdf($idOficio){
        $data['resultado'] = TRUE;
        $data['URL'] = "test.php";
        $data['form'] = "<form id='FormularioInfoPdf' name='FormularioInfoPdf' method='post' action='contenido_SGI/vistas/Inversion/funciones/pdfAutorizacion.php' target='new'>"
                    .   "   <input type='text' name='idOficio'  value='".$idOficio."' />"
                    .   "   <input type='submit' value='Submit' id='submitPdf'>"
                    .   "</form>";
        return $data;
    }
    
    public function guardarOficio($datos, $infOfi, $opcion){
                     
        if($opcion=='Actualizar'){
            $idOficio = $this->insAutorizacionModel->ActualizarOficio($infOfi);
        }                
        else{            
            $idOficio = $this->insAutorizacionModel->guardarOficio($infOfi);        
        }                
        
        
        $this->insAutorizacionModel->deleteGrid($idOficio);
        
        //se recibe el array de datos por almacenar
        $i=0;
        foreach($datos as $dato){                        
            $i++;
            //se obtiene el ultimo array para quitar la posicion 0  solo leer los valores
            $info = end($dato);            
            $this->insAutorizacionModel->guardarDoficio($info, $idOficio, $i);                       
        }
        
        
        
        $data['idOficio'] = $idOficio;
        $info = end($this->insAutorizacionModel->revisaOficio($idOficio));        
        $data['cveOficio'] = $info['CveOfi'];
        
        $data['resultado']= TRUE;
        
        
        
        return $data;
    }
    
    public function guardarTextosPdf($cveOficio, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto){
        
        $update = $this->insAutorizacionModel->guardaTextosPdf($cveOficio, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto);
        
        if($update){
            $data['resultado']=TRUE;
        }
        else {
            $data['resultado']=FALSE;
        }
        return $data;
        
    }   
    
    public function obtenerGrid($idOficio){
        $datos = $this->insAutorizacionModel->obtenerCamposGrid($idOficio);
        return $datos;        
    }
    
    public function calcularMontos($tipo, $movimiento, $idOficio, $idObra, $ejercicio, $referencia){    
        
        $data = array();                        
        $data['resultado']= FALSE;
        
        if($tipo==1){
            $data['montoPorAutorizar'] = 0;
            $data['montoPorAsignar'] = 0;
            $data['resultado']= TRUE;
        }
        
        if($tipo==2 || $tipo==3 || $tipo==4){
            
            $result = $this->insAutorizacionModel->obtenerMontos($idObra, $idOficio, $ejercicio);
            
            $monAsi = 0;
            $monAut = 0;
            $monExp = 0;
            foreach($result as $row){                
                
                $monExp = $row['MonExp'];
                
                if(stristr(strtoupper($row['NomTipOfi']), 'CANCE') || stristr(strtoupper($row['NomTipOfi']), 'REDU')){
                    $monAsi = (float)$monAsi-(float)$row['MonAsi'];
                    $monAut = (float)$monAut-(float)$row['MonAut'];
                }
                else{
                    $monAsi = (float)$monAsi+(float)$row['MonAsi'];
                    $monAut = (float)$monAut+(float)$row['MonAut'];
                }                
            }
            
            $data['montoPorAutorizar'] = $monAut;
            $data['montoPorAsignar'] = $monAsi;
            $data['montoExpediente'] = $monExp;
            $data['resultado']= TRUE;
        }                        
        
        ////####### CAncelaciones y reducciones  ###########/////
        if($tipo==5 || $tipo==6 || ($tipo==7 && $movimiento==6 )){
            $monAsi = 0;
            $monAut = 0;
            $monExp = 0;
            
            if($referencia!=0){
                $result = $this->insAutorizacionModel->obtenerMontosCancelaciones($referencia, $idOficio);                       
                foreach($result as $row){                
                
                    $monExp = 0;
                
                    if(stristr(strtoupper($row['NomTipOfi']), 'CANCE') || stristr(strtoupper($row['NomTipOfi']), 'REDU')){
                        $monAsi = (float)$monAsi-(float)$row['MonAsi'];
                        $monAut = (float)$monAut-(float)$row['MonAut'];
                    }
                    else{
                        $monAsi = (float)$monAsi+(float)$row['MonAsi'];
                        $monAut = (float)$monAut+(float)$row['MonAut'];
                    }                
                }
            
                $datos = $this->insAutorizacionModel->obtenerMontosAps($referencia);            
                foreach($datos as $dato){
                    if(strtoupper($dato['NomTipAps'] == 'DEVOLUCION')){
                        $monAsi = (float)$monAsi+(float)$dato['Monto'];
                        $monAut = (float)$monAut+(float)$dato['Monto'];
                    }
                    else{
                        $monAsi = (float)$monAsi-(float)$dato['Monto'];
                        $monAut = (float)$monAut-(float)$dato['Monto'];
                    }
                }
            }
            $data['montoPorAutorizar'] = $monAut;
            $data['montoPorAsignar'] = $monAsi;
            $data['montoExpediente'] = $monExp;
            $data['resultado']= TRUE;
        }        
        
        if(count($data)>0){
            $data['resultado'] = TRUE;
        }
        
        return $data;
        
    }
    
    public function updateOficio($idOficio, $estado, $fecha, $modificable, $cp){
        $datos = $this->insAutorizacionModel->updateOficio($idOficio, $estado, $fecha, $modificable, $cp);
        return $datos;        
    }
    
    public function cambiarInfOficio($fuente, $inversion,$recursos,$uEjecutora,$idDetOfi){
        
        foreach($idDetOfi as $idMovOfi){
            $movOfi = end($idMovOfi);           
            $this->insAutorizacionModel->updatecambiarInfOficio($fuente, $inversion, $recursos, $uEjecutora, $movOfi['idDetOfi']);
        }
        
    }
    
    public function obtenerAps($idOficio){
        $data = $this->insAutorizacionModel->obtenerApsOfi($idOficio);
        if(count($data)==0){
            return false;
        }
        return $data;
    }
    
    public function obtenerGridOfis($idOficio){
        
        $data = $this->insAutorizacionModel->obtenerGridOfis($idOficio);
        if(count($data)==0){
            return false;
        }
        return $data;
    }
    
    public function oficioReferencia($idObr, $referencia){
        
        $data = $this->insAutorizacionModel->otenerOficioReferencia($idObr, $referencia);
        if(count($data)==0){
            return false;
        }
        return $data;
                        
    }
    
    public function getOficioReferencia($idObra, $ejercicio, $cveOficio){
        
        $data = $this->insAutorizacionModel->getOficiosReferencia($idObra, $ejercicio, $cveOficio);
        $txt = '';
        if(count($data)>0){            
            $txt = '<option value="0">Elige una opcion</option>';
            foreach($data as $key => $val){
                $txt .= "<option value='".$val[1]."'>". $this->codifica($val[0]) ."</option>"; 
            }           
        }
        return $txt;
    }
    
    public function detalleReferencia($idObra, $ejercicio, $referencia){
        
        $data = $this->insAutorizacionModel->detalleReferencia($idObra, $ejercicio, $referencia);
        
        $datos['resultado']=false;
        if(count($data)>0){
            $datos['resultado']=true;
            $datos['informacion'] = end($data);
        }
        return $datos;
        
    }
    
    public function getOficioTemplate($tipOficio, $ejercicio, $fuente, $recurso){
        
        $data = $this->insAutorizacionModel->OficioTemplate($tipOficio, $ejercicio, $fuente, $recurso);
        
        $datos['resultado']=false;
        if(count($data)>0){
            $datos['resultado']=true;
            $datos['informacion'] = end($data);
        }
        return $datos;
    }
    
    public function guardarOficioTemplate($tipo, $ejercicio, $fuente, $asunto, $prefijo, $fundamento, $complemento){
        
        $id = $this->insAutorizacionModel->guardarOficioTemplate($tipo, $ejercicio, $fuente,  $asunto, $prefijo, $fundamento, $complemento);
        
        
        $datos['resultado']=false;
        if($id){                    
            $datos['resultado']=true;
            $datos['idTxt'] = $id;
        }
        return $datos;
        
    }
    
}

?>