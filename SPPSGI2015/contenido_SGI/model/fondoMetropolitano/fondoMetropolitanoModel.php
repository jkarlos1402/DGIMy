<?php

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class fondoMetropolitanoModel{

    var $conexion;

    function __construct() {
        
    }

    function __destruct() {
        global $cnx;
        $cnx->Close();
    }  
    
    public function getEjercicios(){
        
        global $cnx;
        $query = "  select * from catejercicio where Ejercicio!=0 order by Ejercicio DESC ";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }  
    
    public function getCcp(){
        global $cnx;
        
        $query = "select * from 
                    (
                    SELECT cs.*,
                    CASE CveSrv	
                            WHEN 'sfpa' THEN 1
                            WHEN 'dsur' THEN 2
                            WHEN 'spp' THEN 3		
                    END orden
                    FROM catsrvpub cs 
                    WHERE FecIni <= CURDATE() AND FecFin >= CURDATE()
                    order by orden asc
                    ) temp                     
                    where orden is not null";
        
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);                 
    }
    
    public function getccpSectorUE($ue){
        
        global $cnx;
        
        $query = "  select * from catue
                    inner join catsrvpub using(IdSec)
                    where IdUE = '".$ue."'";
        
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);                 
    }
    
    public function getccpDirArea($sector){
        global $cnx;
        
        $query = "  select * from catsector
                    inner join cdepto using (IdDpt)
                    inner join carea ca using(IdDir)
                    inner join catresarea cr on cr.idRes = cdepto.idRes
                    where IdSec = '".$sector."'";
        
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs); 
    }
    
    
    public function getFuentes(){
        
        global $cnx;
        $query = "  select * from catftefon";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getSectores(){
        
        global $cnx;
        $query = "  select * from catsector where IdSec!=0";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getSesion($ejercicio){
        global $cnx;
        $query = "  select * from catsesion ";
        
        if($ejercicio!=0){
            $query .= " Where Ejercicio='".$ejercicio."'";
        }
        
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs); 
    }
    
    public function getInfoSesion($idSesion){
        global $cnx;
        $query = "  select * from catsesion Where IdSesion='".$idSesion."'";        
        
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs); 
    }
    
    public function getGrupoSocial(){
        global $cnx;
        $query = "  select * from catgposoc where idGpo!=0";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getUE($idSector){
        global $cnx;
        $query = "  select * from catue where IdSec='".$idSector."'";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getTipOfi(){
        global $cnx;
        $query = "  select * from cattipofifon where IdTipOfi!=0";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getSesionExistOficios($idSesion){
        global $cnx;
        $query = "  select * from pofifon where IdSesion = '".$idSesion."'";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getInfopFM($cvePry){
        global $cnx;
        $query = "  select * from pfonmet where CvePry = '".$cvePry."'";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function getInfoDetFM($cvePry, $ejercicio){
        global $cnx;
        $query = "  select * from pfonmet
                    inner join detfonmet using (IdFonMet)
                    inner join catue using(IdUE)
                    where CvePry = '".$cvePry."'
                    and Ejercicio = '".$ejercicio."'";
        $rs = $cnx->Execute($query);
        
        return $this->resultAdoData($rs);         
    }
    
    public function infoGridSesiones($ejercicio){
        global $cnx;
        $query = "  select * from catsesion ";
        
        if($ejercicio!=0){
            $query .= " where Ejercicio = '".$ejercicio."'";
        }
        
        $query .= " ORDER BY Ejercicio DESC, FecSes DESC";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;         
        
    }
    
    public function maxConsecutivoFonMet(){
        global $cnx;
        $query = "  select MAX(NumPry) NumPry from pfonmet";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;         
    }
    
    public function maxConsecutivoOfiFon(){
        global $cnx;
        $query = "  select MAX(IdOfiFon) IdOfiFon from pofifon";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;         
    }
    
    public function getTitular($ue){
        global $cnx;
        $query = "  select UPPER(Titulo) Titulo, UPPER(NomTit) NomTit, UPPER(ApeTit) ApeTit, UPPER(CarTit) CarTit 
                    from catue
                    inner join cattitular using(IdTit)
                    where IdUE ='".$ue."'";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;         
    }
    
    public function guardarSesion($ejercicio, $fecha, $sesion){
        global $cnx;
        $query = "  INSERT INTO catsesion (Ejercicio, NomSes, FecSes) VALUES (".(int)$ejercicio.", '".utf8_decode($sesion)."', '".$fecha."')";
        $rs = $cnx->Execute($query);
        return $rs;
    }
    
    public function borrarSesion($idSesion){
        
        global $cnx;
        $query = "  DELETE FROM catsesion WHERE IdSesion = '".$idSesion."'";
        $rs = $cnx->Execute($query);
        return $rs;
    }
    
    public function guardarDatosPfon($idFte, $nomPry, $cvePry, $numPry){
        
        global $cnx;
        $query = "  INSERT INTO pfonmet (IdFte, NomPry, CvePry, NumPry) VALUES (".(int)$idFte.", '".utf8_decode($nomPry)."', '".$cvePry."', ".(int)$numPry.")";
        $rs = $cnx->Execute($query);
        
        if($rs){
            $id = $cnx->Insert_ID();
            return $id;
        }
        else {
            return false;
        }        
        
    }
    
    public function guardarDatosDetFon($idpFontMet, $ejercicio, $idUe, $avanceFisico, $terminado, $observaciones, $grupoSocial){        
        global $cnx;
        $query = "  INSERT INTO detfonmet (IdFonMet, Ejercicio, FecAlt, IdUE, AvaFis, Terminado, ObsFon, IdGpo) VALUES "
                . " (".(int)$idpFontMet.", ".(int)$ejercicio.", curdate(), '".$idUe."', '".$avanceFisico."', ".(int)$terminado.", '".utf8_decode($observaciones)."', '".$grupoSocial."')";
        $rs = $cnx->Execute($query);
        
        if($rs){
            $id = $cnx->Insert_ID();
            return $id;
        }
        else {
            return false;
        }
    
    }
    
    public function guardarPlantilla($ejercicio, $fuente, $tipOfi, $texto){
        global $cnx;
        $query = "  INSERT INTO cattxtfon (Ejercicio, IdFte, IdTipOfi, TxtOfi) VALUES "
               . " ( ".(int)$ejercicio.", '".$fuente."',  ".(int)$tipOfi.", '".utf8_decode($texto)."')";
        $rs = $cnx->Execute($query);
        
        if($rs){
            $id = $cnx->Insert_ID();
            return $id;
        }
        else {
            return false;
        }
    }
    
    public function guardarDeposito($idDetFon, $fecha, $monto){
        global $cnx;
        $query = "  INSERT INTO detdepfon (IdDetFon, FecDep, Monto) VALUES "
               . " ( ".(int)$idDetFon.", '".$fecha."',  ".(float)$monto.")";
        $rs = $cnx->Execute($query);
        
        if($rs){        
            return true;
        }
        else {
            return false;
        }        
    }
    
    public function guardarpOficio($tipOfi, $cveOfi, $sesion, $fecha, $texto, $texto2, $titular, $ccp){
        global $cnx;
        $query = "  INSERT INTO pofifon (IdTipOfi, CveOfi, IdSesion, FecAlt, FecOfi, Txt1Ofi, Txt2Ofi, TitOfi, CcpOfi) VALUES "
               . " ( ".(int)$tipOfi.", '".$cveOfi."',  ".(int)$sesion.", curdate(), '".$fecha."', '".utf8_decode($texto)."', '".utf8_decode($texto2)."', '".utf8_decode($titular)."', '".utf8_decode($ccp)."')";
        $rs = $cnx->Execute($query);
        
        if($rs){
            $id = $cnx->Insert_ID();
            return $id;
        }
        else {
            return false;
        }
    
    }
    
    public function guardarDetOfi($idpOfi, $idDetFon, $monto){
        global $cnx;
        $query = "  INSERT INTO detofifon (IdDetFon, IdOfiFon, Monto) VALUES "
               . " ( ".(int)$idDetFon.", ".(int)$idpOfi.", ".(float)$monto.")";
        $rs = $cnx->Execute($query);
        
        if($rs){
            $id = $cnx->Insert_ID();
            return $id;
        }
        else {
            return false;
        }
    }
        
    public function borrarDepositos($idDetFon){
        
        global $cnx;
        $query = "  DELETE FROM detdepfon WHERE IdDetFon = '".$idDetFon."'";
        $rs = $cnx->Execute($query);
        return $rs;
    }
    
    public function getDepositos($idDetFon){        
        global $cnx;
        $query = "  select * from detdepfon where IdDetFon='".$idDetFon."'";

        $rs = $cnx->Execute($query);                
        
        $numRows = $rs->_numOfRows;
        
        if($numRows>0){
            
            $data = array();        
            while (!$rs->EOF) {
                $rs->fields['FecDep'] = date("d-m-Y", strtotime($rs->fields['FecDep']));
                
                array_push($data, $rs->fields);
                $rs->movenext();
            }
            return $data;
        }
        else{
            return false;
        }        
        return $datos;        
    }
    
    public function checkPlantilla($ejercicio, $fuente, $tipOfi){
        global $cnx;
        $query = "  select * from cattxtfon where Ejercicio='".$ejercicio."' AND IdFte='".$fuente."' AND IdTipOfi='".$tipOfi."'";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;
    }
    
    public function listaProyectos($ejercicio, $fuente, $ue){
        global $cnx;
        $query = "  select * from pfonmet inner join 
                    detfonmet using (IdFonMet)
                    where Ejercicio = '".$ejercicio."'
                    and IdFte = '".$fuente."'
                    and IdUE = '".$ue."'    
                    order by CvePry DESC, Ejercicio DESC, FecAlt DESC";

        $rs = $cnx->Execute($query);
        $datos = $this->resultAdoData($rs);
        return $datos;
    }
    
    public function actualizarTextoPlantilla($idTxt, $texto){
        global $cnx;
        
        $query = "Update cattxtfon set TxtOfi='".utf8_decode($texto)."' Where IdTxtFon='".$idTxt."' ";
        $rs = $cnx->Execute($query);
        return $rs;
    }
    
    public function updateDatospFon($idFonMet,$idFte,$nomPry, $cvePry){
        global $cnx;
        
        $query = "Update pfonmet set IdFte='".$idFte."', NomPry='".utf8_decode($nomPry)."', CvePry='".$cvePry."' Where IdFonMet='".$idFonMet."' ";
        $rs = $cnx->Execute($query);
        return $rs;
    }
    
    public function updateDatosDetFon($idDetFon,$ejercicio, $idUe, $avanceFisico, $terminado, $observaciones, $grupoSocial){
        global $cnx;
        
        $query = "Update detfonmet set ejercicio='".$ejercicio."', IdUE='".$idUe."', AvaFis='".$avanceFisico."', Terminado='".$terminado."', ObsFon='".utf8_decode($observaciones)."', IdGpo='".$grupoSocial."' Where IdDetFon='".$idDetFon."' ";
        $rs = $cnx->Execute($query);
        return $rs;
    }

    public function resultAdoData($rs){
        $numRows = $rs->_numOfRows;
        
        if($numRows>0){
            
            $data = array();        
            while (!$rs->EOF) {
                array_push($data, array_map('utf8_encode' , $rs->fields));
                $rs->movenext();
            }
            return $data;
        }
        else{
            return false;
        }        
    }
        
}
