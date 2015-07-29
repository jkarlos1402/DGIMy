<?php  
session_start();
ob_start();
  
include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

//si viene de la peticion del formulario se procesa el PDF
$idOficioPdf='';
if(isset($_POST['idOficioWord'])){
    $idOficioPdf=$_POST['idOficioWord'];    
}
else if(isset($_GET['idOficioWord'])){
    $idOficioPdf=$_GET['idOficioWord'];    
}
 
if(!empty($idOficioPdf)){
    
    $Meses = array(
                    1=>'Enero',
                    2=>'Febrero',
                    3=>'Marzo',
                    4=>'Abril',
                    5=>'Mayo',
                    6=>'Junio',
                    7=>'Julio',
                    8=>'Agosto',
                    9=>'Septiembre',
                    10=>'Octubre',
                    11=>'Noviembre',
                    12=>'Diciembre',
        );
    
    $fechaOficio = date('Y/m/d');
    $ano = substr($fechaOficio,0,4);
    $mes = substr($fechaOficio,5,2);    
    $dia = substr($fechaOficio,8,2);
    
    $fechaOficio = (int)$dia." de ".$Meses[(int)($mes)]." de ".$ano;    
    
    
    global $cnx;
    $query = "  select po.*, UPPER(cs.NomSolPre) NomSolPre from poficio po
                inner join catsolpre cs using(IdSolPre)
                where CveOfi = '".$idOficioPdf."'";
    $rs = $cnx->Execute($query);

    $numRows = $rs->_numOfRows;
    
    $dataOfi = array();        
    
    if($numRows>0){                       
        while (!$rs->EOF) {
            array_push($dataOfi, array_map('utf8_encode',$rs->fields));
            $rs->movenext();
        }        
        $dataOfi = end($dataOfi);
    }
    
    $query = " select upper(cs.NomSec) NomSec from rususec
                    inner join catsector cs using (idSec)
                    where idUsu = '".$_SESSION['USERID']."'";
    $rssec = $cnx->Execute($query);
    $nRows = $rssec->_numOfRows;
    
    $dataSec = array(); 
    
    if($nRows>0){                       
        while (!$rssec->EOF) {
            array_push($dataSec, array_map('utf8_encode',$rssec->fields));
            $rssec->movenext();
        }        
        $dataSec = end($dataSec);
    }
        
    /*
    echo "<pre>";
        print_r($dataOfi);
    echo "</pre>";    
    
    */
     $contenido1 = '<table style="align: center; width: 90%">                    
                    <tr>                        
                        <td align="center">'.('2015. A&Ntilde;O DE LOS TRATADOS DE TEOLOYUCAN').'
                        </td>
                    </tr>   
                    <tr><td></td></tr>                    
                  </table>
                  <br />
                  <table style="align: center; width: 90%">
                    <tr>
                        <td width="80%"></td>
                        <td style="text-align: right">203200-'.$dataOfi['PfjOfi'].'-'.substr($dataOfi['CveOfi'],2,4).'/'.substr($ano,2,2).'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right">Toluca de Lerdo, M&eacute;xico;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right">'.$fechaOficio.'</td>
                    </tr>                    
                    <tr>                        
                        <td width="80%" style="text-align: right"><b>ASUNTO:</b></td>
                        <td style="text-align: right">'. nl2br($dataOfi['AsuOfi']).'</td>
                    </tr>                                       
                </table>
                <table>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr>
                        <td><b>'.nl2br($dataOfi['TitOfi']).'</b></td>
                    </tr>
                    <tr>
                        <td><b>P R E S E N T E</b></td>
                    </tr>                    
                    <tr><td></td></tr>                    
                    <tr>
                        <td height="300px" style="height: 450px; vertical-align: middle"><span style="text-align:justify; ">'.nl2br($dataOfi['TxtOfi']).'</span></td>
                    </tr>
                </table>
                <table align="center">
                    <tr><td></td></tr>
                    <tr><td></td></tr>                    
                    <tr><td>A T E N T A M E N T E</td></tr>
                    <tr><td>EL SUBSECRETARIO</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>'.utf8_encode('M. EN F. FRANCISCO GONZ&Aacute;LEZ ZOZAYA').'</td></tr>
                </table>
                <table style="font-size: 9px; bottom:0">
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>                                                            
                    <tr><td width="5px">C.C.P</td><td width="500px">'. nl2br($dataOfi['CcpOfi']).'</td></tr>   
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td>'.nl2br($dataOfi['TatOfi']).'</td></tr>    
                </table>';
        $contenido2 = ''
                . '<table style="font-size: 9px; width: 90%; align: center; margin-top: 100px">
                            <tr style="font-size: 10px; font-weight: bold" bgcolor="#CCC">
                                <td colspan="2" class="bordeAbajoTd">&nbsp;<br />ANEXO<br /></td>
                                <td colspan="6" class="bordeAbajoTd" width="445px" align="center">'.$dataSec['NomSec'].'&nbsp;<br /></td>
                                <td colspan="3" class="bordeAbajoTd" align="right">'.utf8_decode($dataOfi['NomSolPre']).'<br />
                                    203200-'.$dataOfi['PfjOfi'].'-'.substr($dataOfi['CveOfi'],2,4).'/'.substr($ano,2,2).
                                '</td>
                            </tr>                                                        
                            </table>';                       
        
        $qry = "select distinct(idObr) from doficio 
                where idOfi = '".$idOficioPdf."'";
        $rs = $cnx->Execute($qry);
        $numRows = $rs->_numOfRows;
        
        if($numRows>0){
            $tipfuente = array('S/T','Federal','Estatal');
            
            $contenido2.='<table style="font-size: 8px; width: 90%; align: center;">
                            <tr>
                                <td width="80px"><b>Id Obra</b></td>
                                <td width="200px"><b>Nombre Obra</b></td>
                                <td width="200px"><b>Fuente</b></td>
                                <td width="80px"><b>Tipo</b></td>
                                <td width="80px" align="center"><b>Cuenta</b></td>
                                <td width="80px" align="center"><b>Monto</b></td>
                                <td width="80px" align="center"><b>Inversion</b></td>
                            </tr>';   
            
            while (!$rs->EOF) {
                
                $qry2 = "   select dof.*, ps.*, ct.NomTipObr, cf.DscFte,rsf.*, po.IdSolPre tipOfi from doficio dof 
                            inner join poficio po ON po.CveOfi = dof.idOfi
                            inner join psolicitud ps on dof.idObr = ps.idObr
                            inner join pobra pob on pob.VerExpTec = ps.idSol
                            inner join ctipobr ct using (idTipObr)
                            inner join catfte2015 cf on cf.idFte = dof.idFte
                            inner join relsolfte rsf on rsf.idSol=ps.IdSol and dof.idFte = rsf.idFte
                            inner join catsolpre cs on po.IdSolPre = cs.IdSolPre
                            where dof.idOfi = '".$idOficioPdf."' and ps.idObr = '".$rs->fields['idObr']."'";
                
                $rs2 = $cnx->Execute($qry2);
                $numRows2 = $rs2->_numOfRows;
                
                if($numRows2>0){
                    $band=0;                    
                    while (!$rs2->EOF) {
                        $contenido2.= '  <tr bgcolor="#CCC">';
                        if($band==0){
                            $contenido2.= " <td rowspan=\"".$numRows2."\">".$rs2->fields['idObr']."</td>";
                            $contenido2.= " <td rowspan=\"".$numRows2."\">"
                                            .   ($rs2->fields['NomObr'])
                                            ."  <br /><b>(".$rs2->fields['NomTipObr'].")</b>"
                                            ."</td>";
                            $band=1;
                        }        
                                
                        $contenido2.= "         <td>".($rs2->fields['DscFte'])."</td>"
                        . "         <td>".$tipfuente[((int)$rs2->fields['tipoFte'])]."</td>"
                        . "         <td style=\"text-align:right;\">".$rs2->fields['cuenta']."</td>";
                        
                        if(($rs2->fields['tipOfi']==1) || ($rs2->fields['tipOfi']==3) || ($rs2->fields['tipOfi']==9)){
                            $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rs2->fields['monto'],2,'.',',')."</td>";
                        }
                        else if(($rs2->fields['tipOfi']==2) || ($rs2->fields['tipOfi']==10) || ($rs2->fields['tipOfi']==11) || ($rs2->fields['tipOfi']==12) || ($rs2->fields['tipOfi']==13)){
                            $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rs2->fields['MontoAutorizado'],2,'.',',')."</td>";
                        }
                        else{
                            $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rs2->fields['monto'],2,'.',',')."</td>";
                        }
                        
                        $contenido2 .= "         <td style=\"text-align:right;\">".round($rs2->fields['pjeInv'],2)."</td>"
                        . "     </tr>";
                        
                        $rs2->movenext();
                    }
                    
                }
                
                $qryOf = "select distinct(idOfi) from doficio where idObr = '".$rs->fields['idObr']."'
                            and idOfi != '".$idOficioPdf."'";
                
                $rsOf = $cnx->Execute($qryOf);
                $numRowsOf = $rsOf->_numOfRows;
                 
                if($numRowsOf>0){
                    
                    $contenido2 .= '<tr class="color"><td colspan="7"><b>HISTORICO</b></td></tr>';
                    while (!$rsOf->EOF) {                         
                        
                            $qryHist = "   select dof.*, ps.*, ct.NomTipObr, cf.DscFte,rsf.*, cs.NomSolPre, po.IdSolPre tipOfi from doficio dof 
                                            inner join poficio po ON po.CveOfi = dof.idOfi
                                            inner join psolicitud ps on dof.idObr = ps.idObr
                                            inner join pobra pob on pob.VerExpTec = ps.idSol
                                            inner join ctipobr ct using (idTipObr)
                                            inner join catfte2015 cf on cf.idFte = dof.idFte
                                            inner join relsolfte rsf on rsf.idSol=ps.IdSol and dof.idFte = rsf.idFte
                                            inner join catsolpre cs on po.IdSolPre = cs.IdSolPre
                                            where dof.idOfi = '".$rsOf->fields['idOfi']."' and ps.idObr = '".$rs->fields['idObr']."'";
                            
                            $rsHist = $cnx->Execute($qryHist);
                            $numRowsHist = $rsHist->_numOfRows;

                            if($numRowsHist>0){
                                $bandH=0;
                                while (!$rsHist->EOF) {
                                    $contenido2.= '  <tr bgcolor="#CCC">';
                                    if($bandH==0){
                                        $contenido2.= " <td rowspan=\"".$numRowsHist."\">Oficio: ".$rsHist->fields['idOfi']."<br />Tipo: ".($rsHist->fields['NomSolPre'])."</td>";
                                        $contenido2.= " <td rowspan=\"".$numRowsHist."\">"                                                        
                                                        ."</td>";
                                        $bandH=1;
                                    }        

                                    $contenido2.= "         <td>".($rsHist->fields['DscFte'])."</td>"
                                    . "         <td>".$tipfuente[((int)$rsHist->fields['tipoFte'])]."</td>"
                                    . "         <td style=\"text-align:right;\">".$rsHist->fields['cuenta']."</td>";
                                    
                                    //. "         <td style=\"text-align:right;\">".number_format($rsHist->fields['monto'],2,'.',',')."</td>"        
                                    if(($rsHist->fields['tipOfi']==1) || ($rsHist->fields['tipOfi']==3) || ($rsHist->fields['tipOfi']==9)){
                                        $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rsHist->fields['monto'],2,'.',',')."</td>";
                                    }
                                    else if(($rsHist->fields['tipOfi']==2) || ($rsHist->fields['tipOfi']==10) || ($rsHist->fields['tipOfi']==11) || ($rsHist->fields['tipOfi']==12) || ($rsHist->fields['tipOfi']==13)){
                                        $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rsHist->fields['MontoAutorizado'],2,'.',',')."</td>";
                                    }
                                    else{
                                        $contenido2 .= "         <td style=\"text-align:right;\">".number_format($rsHist->fields['monto'],2,'.',',')."</td>";
                                    }
                                    
                                    
                                    $contenido2 .= "         <td style=\"text-align:right;\">".round($rsHist->fields['pjeInv'],2)."</td>"
                                    . "     </tr>";
                                    
                                    $rsHist->movenext();
                                }
                            }
                        $contenido2 .= '<tr class="color"><td colspan="7"></td></tr>';
                        $rsOf->movenext();
                    }    
                }
                
                
                $rs->movenext();
            }                                                        
            
        }
                
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=document_name.doc");
        echo $contenido1;
        echo $contenido2;
        //exit; 

   
}
//caso contrario se envia un Header error
else{
    header(':', true, 404);
    header('X-PHP-Response-Code: 404', true, 404);  
    echo $error_code = "<h1>403 - Forbidden</h1>";
    echo $explanation = "<h3>This section requires a password or is otherwise protected.</h3>";    
}


?>

