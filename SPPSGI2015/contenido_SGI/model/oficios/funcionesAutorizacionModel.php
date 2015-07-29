<?php 
session_start();

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

class autorizacionModel{
    
    var $conexion;
    var $cnx;
    
    function __construct(){         

        global $cnx;                
        $this->cnx=$cnx;        
        $this->cnx->SetCharSet('utf8');
    } 
    
    function __destruct(){                
                
        global $cnx;
        $cnx->Close();        
    }
    
    public function revisaOficio($idOficio){                
        
	$query = "  SELECT * FROM poficio        
                    LEFT JOIN ctipofi USING (idTipOfi)
                    WHERE idOfi = '".$idOficio."'";        
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function revisaOficioClave($claveOficio){                
        
	$query = "  SELECT * FROM poficio                    
                    WHERE CveOfi = '".$claveOficio."'";        
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function maxOficio(){
        $query = "  SELECT  (max(idOfi) +1) as nextId FROM poficio";        
        $rs = $this->cnx->Execute($query);                
        return $this->resultAdoData($rs);                
        
    }
    
    
    public function tipOficios(){        
        
	$query = "SELECT * FROM catsolpre";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);
        
    }
    
    public function estadOficios(){        
        
        $query = "SELECT * FROM cedoofi";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function catRecursos(){
        
        $query = "SELECT * FROM crecurso";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function catFuentes(){
        
        $query = "SELECT * FROM catfte2015 ORDER BY DscFte ASC";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function catInversion(){
        
        $query = "SELECT * FROM cinversion";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function catEjercicio(){
        
        $query = "SELECT * FROM catejercicio where Ejercicio != 0";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }    
    
    public function obtenerObra($idObra, $ejercicio){
        
        $query = "  select * from pobra PO
                    left join dobra DOb USING (idObr)
                    left join catsector CS ON DOb.idSec = CS.idSec
                    left join catue on catue.IdUE = DOb.idDep
                    where idObr = '".$idObra."'";
        
        if(!empty($ejercicio)){
            $query .= " and Ejercicio = ".$ejercicio;
        }
        //echo $query;
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function guardarOficio($info){
        $nuevoOficio = "select * from 
                        (
                        SELECT MAX(idOfi) FROM poficio
                        ) temp1 
                        inner join 
                        (
                        select  right(MAX(CveOfi), 4) FROM poficio
                        Where Left(CveOfi, 2) = '".substr($info['ejercicio'], -2)."'
                        ) temp2";
        $resOfi = $this->cnx->Execute($nuevoOficio);        
                
        $fila = $this->resultAdoData($resOfi);        
        $row = end($fila);       
        $id = ((int)$row[0]+1);    
        
        $cve = ((int)$row[1]+1);    
        $cve = substr("000".$cve, -4);
        
        if(empty($info['firma'])){
            $fFirma = date('Y-m-d');
        }
        else{
            $fFirma = $info['firma'];
        }
        
        $query = "  INSERT INTO poficio (idUsu, idOfi, CveOfi, idEdoOfi, idTipOfi, FecFir, FecOfi,OfiCp, FecAlt)
                                VALUES  (".$_SESSION['USERID'].", '".$id."', '".substr($info['ejercicio'], -2).$cve."', '".$info['estado']."', '".$info['tipo']."',  
                                         '".$fFirma."', '".$info['fecha']."',  
                                          ".$info['cp'].", '".date('Y-m-d')."')";
        
        $this->cnx->Execute($query);        
        return $id;
        
    }
    
    public function obtenerMontos($idObra, $idOficio, $ejercicio){        
        //revisa si ya se tiene informacion de algun oficio para esa obra y ejercicio
        $existOfi = "select 
                    *
                    FROM pobra
                    inner join dobra DOb using (idObr)
                    inner join doficio DOf using (idDetObr)
                    where 
                    idObr = ".$idObra."
                    and Ejercicio = ".$ejercicio;
        
        $resExistOfi = $this->cnx->Execute($existOfi);        
        
        $fila = $this->resultAdoData($resExistOfi);                
        
        
        $query = "  select 
                    MonExp, MonAut, MonAsi, NomTipOfi, idDetOfi
                    FROM pobra
                    left join dobra DOb using (idObr)
                    left join doficio DOf using (idDetObr)
                    left join poficio PO using (idOfi)
                    left join cedoofi CE using (idEdoOfi)                                        
                    left join ctipofi CTo  on DOf.idTipOfi = CTo.idTipOfi
                    where 
                    idObr = ".$idObra."
                    and Ejercicio = ".$ejercicio;
                    if(count($fila)>0){
                        $query .= " AND UPPER(NomEdoOfi)!='CANCELADO' 
                                    AND (OfiCP = 0 or OfiCP = null)";
                    }
                    if($idOficio){
                        $query .= " AND  idOfi != ".$idOficio;
                    }
        //echo $query."\n";            
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
   
    }
    
    public function obtenerMontosCancelaciones($idDetOfi, $idOfi){        
        $query = "  select 
                    MonAut, MonAsi, NomTipOfi,idDetOfi
                    from
                    doficio DOf 
                    left join poficio PO using (idOfi)
                    left join cedoofi CE using (idEdoOfi)                                        
                    left join ctipofi CTo  on DOf.idTipOfi = CTo.idTipOfi
                    where 
                    UPPER(NomEdoOfi)!='CANCELADO' 
                    and (OfiCP = 0 or OfiCP = null)
                    and (idDetOfi = ".$idDetOfi." OR idRef = ".$idDetOfi.")
                    and idOfi!= '".$idOfi."'";
        //echo $query."\n";            
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
   
    }
    
    public function obtenerMontosAps($idDetOfi){        
        $query = "  select * from dautpag 
                    left join pautpag using (idAps)
                    left join ctipaps using (idTipAps)
                    left join cedoaps using (idEdoAps)
                     where 
                    UPPER(NomTipAps) IN ('ANTICIPO', 'DEVOLUCION', 'ESTIMACION', 'PAGO')
                    and UPPER(NomEdoAps) IN ('ACEPTADO', 'PROCESO')
                    and AutPagCP = 0
                    and 
                    idDetOfi='".$idDetOfi."'";
        //echo $query;
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
   
    }
    
    public function guardarDoficio($info, $idOficio, $i){
        
        $dOficio = "SELECT MAX(idDetOfi) FROM doficio";
        $resOfi = $this->cnx->Execute($dOficio);        
        
        $fila = $this->resultAdoData($resOfi);                
        $row = end($fila);
        $id = ((int)$row[0]+1);                
                
        $query = "  INSERT INTO doficio (idDetOfi, idDep, idFte, idInv, idDetObr, idOfi, idRec, idRef, idTipOfi, MonAsi, MonAut)
                                VALUES  ('".$id."','".$info['uEjecutora']."', '".$info['fuente']."',  
                                         '".$info['inversion']."', '".$info['idObra']."', '".$idOficio."',
                                         '".$info['recurso']."', ".(int)$info['referencia'].", '".$info['tipOficio']."', 
                                         '".$info['montoAsignado']."', '".$info['montoAutorizado']."'  )";
        
        $this->cnx->Execute($query);        
        return $id;        
    }
    
    public function ActualizarOficio($info){
        if(empty($info['firma'])){
            $fFirma = date('Y-m-d');
        }
        else{
            $fFirma = $info['firma'];
        }
        $query = "  UPDATE poficio SET  idEdoOfi='".$info['estado']."', idTipOfi='".$info['tipo']."',  
                                        FecFir='".$fFirma."', FecOfi='".$info['fecha']."',  
                                        OfiCp=".$info['cp']."
                    WHERE idOfi='".$info['idOficio']."'";
        
        $this->cnx->Execute($query);        
        
        return $info['idOficio'];
    }
    
    public function obtenerDependencia($idDependencia, $like){
        if(empty($like)){
            $query = "SELECT * FROM catue Where IdUE = '".$idDependencia."'";
        }
        else{
            $query = "SELECT * FROM catue Where IdUE LIKE '%".$idDependencia."%'";
        }
        
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
        
    }
    
    public function obtenerDependenciaLetra($Dependencia, $like){
        if(empty($like)){
            $query = "SELECT * FROM catue Where NomUE = '".$Dependencia."' and IdUE != 0";
        }
        else{
            $query = "SELECT * FROM catue Where NomUE LIKE '%".$Dependencia."%' and IdUE != 0";
        }
        
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
        
    }
    
    public function guardaTextosPdf($cveOficio, $titular, $asunto, $ccp, $prefijo, $refer, $tat, $texto){                                                                       
        $query = "  UPDATE poficio SET  TitOfi='".$titular."', CcpOfi='".$ccp."',   
                                        AsuOfi='".$asunto."', TatOfi='".$tat."',  
                                        PfjOfi='".$prefijo."', TxtOfi='".$texto."',
                                        IniOfi='".$refer."'
                    WHERE CveOfi='".$cveOficio."'";
        $result = $this->cnx->Execute($query);        
        return $result;
    }
    
    public function obtenerCamposGrid($idOficio){
        $query = "  select CF.idFte, CF.CveFte, CF.DscFte, CI.idInv, CI.CveInv, CI.NomInv, CR.idRec, CR.CveRec, CR.NomRec,
                    CUe.IdUE,CUe.NomUE, DOf.idRef, DOf.MonAsi, DOf.MonAut, DOb.idDetObr, DOb.NomObr, CT.idTipOfi, CT.CveTipOfi, CT.NomTipOfi, DOf.idDetOfi, DOb.idObr
                    FROM doficio DOf
                    left join catue CUe on CUe.IdUE = DOf.idDep
                    left join catfte2015 CF using (idFte)
                    left join cinversion CI using (idInv)
                    left join crecurso CR using (idRec)
                    left join dobra DOb using (idDetObr)
                    left join ctipofi CT using (idTipOfi)
                    Where IdOfi=".$idOficio." order by idObr ASC";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function deleteGrid($idOficio){
        $query = "DELETE FROM doficio WHERE idOfi = '".$idOficio."'";
        
        $result = $this->cnx->Execute($query);        
        return $result;
    }        
    
    public function updateOficio($idOficio, $estado, $fecha, $modificable, $cp){
        $query = "  UPDATE poficio SET  idEdoOfi='".$estado."', FecOfi='".$fecha."',   
                                        OfiCP=".$cp.", PrmMod=".$modificable."                                        
                    WHERE idOfi='".$idOficio."'";
        $result = $this->cnx->Execute($query);        
        if($result){
            return TRUE;
        }
        return $result;
    }
    
    public function updatecambiarInfOficio($fuente, $inversion,$recursos,$uEjecutora,$idDetOfi){
        $query = "  UPDATE doficio SET  idFte='".$fuente."', idInv='".$inversion."',  
                                        idRec='".$recursos."', idDep='".$uEjecutora."'                                        
                    WHERE idDetOfi='".$idDetOfi."'";
        
        $result = $this->cnx->Execute($query);        
        return $result;
        
    }
    
    public function obtenerApsOfi($idOficio){
        $query = "  select 
                    idAPS, NomEdoAps, doficio.idDetObr, idOfi, NomTipOfi
                    from dautpag
                    Left join pautpag using (idAps)
                    left join cedoaps using (idEdoAps)
                    left join doficio using (idDetOfi)                    
                    left join ctipofi using (idTipOfi)
                    Where IdOfi=".$idOficio;
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function obtenerGridOfis($idOficio){
        $query = "  select 
                    idOfi, NomEdoOfi, NomTipOfi, idDetObr
                    FROM poficio
                    left join cedoofi using (idEdoOfi)
                    left join doficio using (idOfi)
                    left join ctipofi on doficio.idTipOfi = ctipofi.idTipOfi
                    left join dobra using (idDetObr)
                    Where IdOfi=".$idOficio." order by idDetObr ASC";
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);                
    }
    
    public function otenerOficioReferencia($idObr, $referencia){
        $query = "  select distinct(idOfi)
                    FROM doficio
                    left join poficio using (idOfi)
                    where idDetObr =".$idObr."
                    and idOfi LIKE '%".$referencia."%'";
                    
                    
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);
    }
    
    public function getOficiosReferencia($idObra, $ejercicio, $cveOficio){
        $query = "  select CveOfi, idDetOfi from poficio
                    left join cedoofi CE using (idEdoOfi)                    
                    left join doficio DOf using(idOfi)
                    left join ctipofi CT on CT.idTipOfi = DOf.idTipOfi
                    WHERE 
                    UPPER(NomEdoOfi) = 'ACEPTADO'
                    AND
                    LEFT(CveOfi, 2) = '".  substr($ejercicio, -2) ."'
                    AND UPPER(NomTipOfi) NOT IN ('CANCELACION', 'REDUCCION')
                    AND 
                     idDetObr = (   select idDetobr from pobra
                                    left join dobra using(idObr)
                                    where idObr =".$idObra." and Ejercicio = '".$ejercicio."')
                    and CveOfi != '".$cveOficio."'";
        //echo $query;
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);
    }
    
    public function getAnexo($cveOficio, $fecha){
        
        $queryin = "select distinct(idObr)
                            from poficio PO
                            left join cedoofi CE using(idEdoOfi)
                            left join doficio DOf using(idOfi)
                            left join dobra DOb using (idDetObr)
                            WHERE CveOfi = '".$cveOficio."'";
        $resin = $this->cnx->Execute($queryin);        
        
        $datos = $this->resultAdoData($resin);
        $in = '';
        foreach($datos as $dato){
            $in .= $dato['idObr'].", ";
        }                        
        $in = trim($in,', ');
        
        $query = "  select idObr, idDetObr, NomObr, NomLoc, CvePrg, CveOfi, idOfi, FecOfi, 
                    if(NomInv IS NULL, 'InvSC', NomInv) NomInv, MonAsi, MonAut, AsiNvo, AutNvo, NomClaObr, NomTipObr, NomSec,
                    if(NomUE IS NULL, 'Dependencia inexistente en catalogo', NomUE) NomUE, idRec, NomTipOfi, NomMun
                    from poficio PO
                    left join cedoofi CE using(idEdoOfi)
                    left join ctipofi CTo using (idTipOfi)
                    left join doficio DOf using(idOfi)
                    left join catue CUe on CUe.IdUE = DOf.idDep
                    left join catfte2015 CF using (idFte)
                    left join cinversion CIn using (idInv)
                    left join dobra DOb using (idDetObr)
                    left join cclaobr CCo using (idClaObr)
                    left join catsector CS on CS.idSec = DOb.idSec
                    left join catestprg20".substr($cveOficio, 0,2)." CP using (idPrg)
                    left join ctipobr CT using (idTipObr)
                    left join catmunicipio CM using (idMun)    
                    WHERE 
                    OfiCP != 1 AND                    
                    Ejercicio = CONCAT('20', left(CveOfi,2))
                    and FecOfi<= '".$fecha."'
                    and idObr IN (".$in.")
                    order by NomUE ASC, idObr ASC, CveOfi DESC";        
        //  echo $query;
        //exit;
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);
    }
    
    public function detalleReferencia($idObra, $ejercicio, $referencia){
        $query = "  select * from doficio 
                    left join catue on catue.idUE = idDep
                    where idDetOfi = '".$referencia."'";
        
        $rs = $this->cnx->Execute($query);        
        
        return $this->resultAdoData($rs);
    }
    
    public function OficioTemplate($tipOficio, $ejercicio, $fuente, $recurso){
        
        $query = "  select * from ctxtofi
                    where
                    idTipOfi = '".$tipOficio."'
                    and Ejercicio = '".$ejercicio."'";
        
        $rs = $this->cnx->Execute($query);        
        return $this->resultAdoData($rs);
    }
    
    public function guardarOficioTemplate($tipo, $ejercicio, $fuente, $asunto, $prefijo, $fundamento, $complemento){
        $qryIdtxt = "SELECT MAX(idTxtOfi) FROM ctxtofi";
        $res = $this->cnx->Execute($qryIdtxt);        
        
        $fila = $this->resultAdoData($res);                
        $row = end($fila);
        $id = ((int)$row[0]+1);                                        
        
        $query = "  INSERT INTO ctxtofi (idTxtOfi, idTipOfi, Ejercicio, idFte,  AsuOfi, PfjOfi, fundamento, complemento)"
                . " values (".$id.", ".$tipo.", ".$ejercicio.", ".(int)$fuente.", '".$asunto."', '".$prefijo."', '".$fundamento."', '".$complemento."')";                
        $res2 = $this->cnx->Execute($query);        
        if($res2){       
            return $id;        
        }    
        else{
            return false;
        }    
    }
    
    public function resultAdoData($result){
        $data = array();
        while (!$result->EOF) {
            array_push($data, $result->fields);
            $result->movenext();
        }        
        return $data;        
    }
            
}

?>
