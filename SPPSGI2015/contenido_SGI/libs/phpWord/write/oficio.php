<?php
session_start();

include_once("../../../libs/adodb/adodb.inc.php");
require("../../../includes/conexion-config.php");

//si viene de la peticion del formulario se procesa el PDF
$idOficioPdf='';
if(isset($_POST['idOficioWord'])){
    $idOficioPdf=$_POST['idOficioWord'];    
}
else if(isset($_GET['idOficioWord'])){
    $idOficioPdf=$_GET['idOficioWord'];    
}
     
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
    
$queryEj = " select UPPER(Frase) Frase from catejercicio where Ejercicio =  '".$ano."'";
$rsEje = $cnx->Execute($queryEj);
$nRowsEj = $rsEje->_numOfRows;

$dataEje = array(); 

if($nRowsEj>0){                       
    while (!$rsEje->EOF) {
        array_push($dataEje, array_map('utf8_encode',$rsEje->fields));
        $rsEje->movenext();
    }        
    $dataEje = end($dataEje);
}



include_once 'Sample_Header.php';

// New Word document
//echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultParagraphStyle(
    array(
        'align'      => 'both',
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
        'spacing'    => 15,
        'name' => 'Tahoma'
    )
);

// Sample
$section = $phpWord->addSection(array('breakType' => 'continuous'));

$section->addText(
    htmlspecialchars(
        $dataEje['Frase']
    ),    
    array('bold' => false),
    array('space' => array('before' => 600, 'after' => 250),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        '203200-'.$dataOfi['PfjOfi'].'-'.substr($dataOfi['CveOfi'],2,4).'/'.substr($ano,2,2)
    ),    
    array('bold' => false),
    array('space' => array('before' => 80, 'after' => 80),'align' => 'right')
);

$section->addText(
    htmlspecialchars(
        'Toluca de Lerdo, México;'
    ),    
    array('bold' => false),
    array('space' => array('before' => 80, 'after' => 80),'align' => 'right')
);

$section->addText(
    htmlspecialchars(
        $fechaOficio
    ),    
    array('bold' => false),
    array('space' => array('before' =>80, 'after' => 80),'align' => 'right')
);


$table = $section->addTable('Table');
$table->addRow(300);
$table->addCell(6000, array('valign' => 'center'))->addText(htmlspecialchars('Asunto:'), array('bold'=>true),array('align'=>'right'));
$table->addCell(4000, array('valign' => 'center'))->addText(htmlspecialchars(nl2br($dataOfi['AsuOfi'])), array('bold'=>false),array('align'=>'right'));


//Acentos
$tit = nl2br($dataOfi['TitOfi']);
$titular = explode("<br />", $tit);

foreach($titular as $tit){
    
    $section = $phpWord->addSection(
        array(
            'colsNum'   => 2,
            'colsSpace' => 100,
            'breakType' => 'continuous',
        )
    );
    
    $section->addText(
        htmlspecialchars(
            trim($tit)
        ),    
        array('name' => 'Tahoma','bold' => false),
        array('space' => array('before' => 50, 'after' => 50), 'align' => 'left')        
    );
}

$section = $phpWord->addSection(array('breakType' => 'continuous'));

$section->addText(
    htmlspecialchars(
        'PRESENTE'
    ),    
    array('name' => 'Tahoma', 'bold' => false),
    array('space' => array('before' => 50, 'after' => 50), 'align' => 'left')
);

$section->addText(
    htmlspecialchars(
        ''
    ),    
    array('bold' => false),
    array('space' => array('before' => 200, 'after' => 200),'align' => 'left')
);

//Acentos
$texto = nl2br($dataOfi['TxtOfi']);
$textos = explode("<br />", $texto);

foreach($textos as $txt){
    
    $section->addText(
        htmlspecialchars(
            trim($txt)
        ),    
        array('name' => 'Tahoma','bold' => false),
        array('space' => array('before' => 50, 'after' => 50), 'align' => 'left')        
    );
}


$section->addText(
    htmlspecialchars(
        'A T E N T A M E N T E'
    ),    
    array('bold' => false),
    array('space' => array('before' => 500, 'after' => 500),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        'EL SUBSECRETARIO'
    ),    
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 100),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        'M. EN F. FRANCISCO GONZÁLEZ ZOZAYA'
    ),    
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 100),'align' => 'center')
);


$section->addText(
    htmlspecialchars(            
        ''
    ),    
    array('size'=>8, 'bold' => false),
    array('space' => array('before' => 500, 'after' => 500),'align' => 'left')
);

//acentos
$textCcp = nl2br(($dataOfi['CcpOfi']));
$textosCcp = explode("<br />", $textCcp);
$i=0;
foreach($textosCcp as $ccp){
    $ccp = str_replace('C.C.P.', '', $ccp);
    $cad = '            ';
    if($i==0){
        $cad = 'C.C.P. ';
        $i=1;
    }
    $texto = $cad.trim($ccp);
    
    $section->addText(
        htmlspecialchars(            
            $texto
        ),    
        array('size'=>7, 'bold' => false),
        array('space' => array('before' => 80, 'after' => 80),'align' => 'left')
    );
}


$section = $phpWord->addSection(array('orientation' => 'landscape'));

$styleTable = array('borderSize' => 10, 'borderColor' => 'DDDDDD', 'cellMargin' => 5);
$styleFirstRow = array('borderBottomSize' => 1, 'borderBottomColor' => '0000FF', 'bgColor' => 'DDDDDD');
$styleCell = array('valign' => 'center');
$styleCell1 = array('gridSpan' => 2, 'valign' => 'center');
$fontStyle = array('bold' => true, 'align' => 'center');
$fontStyleCel = array('bold' => false, 'align' => 'center', 'size'=>8);
$fontStyleCe2 = array('bold' => false, 'size'=>8);
$phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
$table = $section->addTable('Fancy Table');
$table->addRow(300);
$table->addCell(7500, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars('ANEXO'), $fontStyle);
$table->addCell(7500, array('gridSpan' => 5, 'valign' => 'center'))->addText(htmlspecialchars($dataSec['NomSec']), $fontStyle);
$table->addCell(3000, array('gridSpan' => 2, 'valign' => 'center'))->addText(
                                                                        htmlspecialchars(
                                                                                $dataOfi['NomSolPre'].'
                                                                                203200-'.$dataOfi['PfjOfi'].'-'.substr($dataOfi['CveOfi'],2,4).'/'.substr($ano,2,2)
                                                                        ), $fontStyle);



        $qry = "select distinct(idObr) from doficio 
                where idOfi = '".$idOficioPdf."'";
        $rs = $cnx->Execute($qry);
        $numRows = $rs->_numOfRows;
        
        if($numRows>0){
            $tipfuente = array('S/T','Federal','Estatal');
            
            $table->addRow(150);
            $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars('Id Obra'), $fontStyle);
            $table->addCell(6000, array('gridSpan' => 2, 'valign' => 'center'))->addText(htmlspecialchars('Nombre Obra'), $fontStyle);
            $table->addCell(4500, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars('Fuente'), $fontStyle);
            $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars('Tipo'), $fontStyle);
            $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars('Cuenta'), $fontStyle);
            $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars('Monto'), $fontStyle);
            $table->addCell(1500, array( 'valign' => 'center'))->addText(htmlspecialchars('Inversión'), $fontStyle);
            
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
                $contenido2='';
                if($numRows2>0){
                    $band=0;            
                    
                    while (!$rs2->EOF) {
                        $cellRowSpan=array('valign' => 'center');                       
                        
                        $monto = 0;
                        if(($rs2->fields['tipOfi']==1) || ($rs2->fields['tipOfi']==3) || ($rs2->fields['tipOfi']==9)){
                            $monto = number_format($rs2->fields['monto'],2,'.',',');
                        }
                        else if(($rs2->fields['tipOfi']==2) || ($rs2->fields['tipOfi']==10) || ($rs2->fields['tipOfi']==11) || ($rs2->fields['tipOfi']==12) || ($rs2->fields['tipOfi']==13)){
                            $monto = number_format($rs2->fields['MontoAutorizado'],2,'.',',');
                        }
                        else{
                            $monto = number_format($rs2->fields['monto'],2,'.',',');
                        }
                                                
                        $table->addRow(150);
                        if($band==0){ 
                            $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
                            $table->addCell(1500, $cellRowSpan)->addText(htmlspecialchars($rs2->fields['idObr']), $fontStyleCel);
                            $table->addCell(6000, array('vMerge' => 'restart','gridSpan' => 2, 'valign' => 'center'))->addText(htmlspecialchars($rs2->fields['NomObr']."\n".$rs2->fields['NomTipObr']), $fontStyleCel);
                            $band=1;
                        }
                        else{
                            $table->addCell(null, array('vMerge' => 'continue'));
                            $table->addCell(null, array('vMerge' => 'continue', 'gridSpan' => 2));
                        }
                        
                        $table->addCell(4500, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($rs2->fields['DscFte']), $fontStyleCel);
                        $table->addCell(1500, array('valign' => 'center' ))->addText(htmlspecialchars($tipfuente[((int)$rs2->fields['tipoFte'])]), $fontStyleCel);
                        $table->addCell(1500)->addText(htmlspecialchars($rs2->fields['cuenta']), $fontStyleCe2);
                        $table->addCell(1500)->addText(htmlspecialchars($monto), $fontStyleCe2);
                        $table->addCell(1500, array('align' => 'right'))->addText(htmlspecialchars(round($rs2->fields['pjeInv'],2)), $fontStyleCe2);
                        
                        $rs2->movenext();
                    }
                    
                }
                
                $qryOf = "select distinct(idOfi) from doficio where idObr = '".$rs->fields['idObr']."'
                            and idOfi != '".$idOficioPdf."'";
                
                $rsOf = $cnx->Execute($qryOf);
                $numRowsOf = $rsOf->_numOfRows;
                 
                if($numRowsOf>0){
                                        
                    $table->addRow(150);                        
                    $table->addCell(18000, array('gridSpan' => 10, 'valign' => 'center'))->addText(htmlspecialchars('HISTORICO'), $fontStyle);
                    
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
                                    
                                    $monto =0;
                                    if(($rsHist->fields['tipOfi']==1) || ($rsHist->fields['tipOfi']==3) || ($rsHist->fields['tipOfi']==9)){
                                        $monto = number_format($rsHist->fields['monto'],2,'.',',');
                                    }
                                    else if(($rsHist->fields['tipOfi']==2) || ($rsHist->fields['tipOfi']==10) || ($rsHist->fields['tipOfi']==11) || ($rsHist->fields['tipOfi']==12) || ($rsHist->fields['tipOfi']==13)){
                                        $monto = number_format($rsHist->fields['MontoAutorizado'],2,'.',',');
                                    }
                                    else{
                                        $monto = number_format($rsHist->fields['monto'],2,'.',',');
                                    }
                                    
                                    
                                    
                                    
                                    $table->addRow(150);
                                    
                                    if($bandH==0){ 
                                        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
                                        
                                        $table->addCell(1500, $cellRowSpan)->addText(htmlspecialchars("Oficio: ".$rsHist->fields['idOfi']."\nTipo: ".($rsHist->fields['NomSolPre'])), $fontStyleCel);
                                        $table->addCell(6000, array('vMerge' => 'restart','gridSpan' => 2, 'valign' => 'center'))->addText(htmlspecialchars(''), $fontStyleCel);                                                                            
                                        $bandH=1;
                                    }
                                    else{
                                        $table->addCell(null, array('vMerge' => 'continue'));
                                        $table->addCell(null, array('vMerge' => 'continue', 'gridSpan' => 2));
                                    }
                                    
                                    $table->addCell(4500, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($rsHist->fields['DscFte']), $fontStyleCel);
                                    $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars($tipfuente[((int)$rsHist->fields['tipoFte'])]), $fontStyleCel);
                                    $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars($rsHist->fields['cuenta']), $fontStyleCe2);
                                    $table->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars($monto), $fontStyleCe2);
                                    $table->addCell(1500, array( 'valign' => 'center'))->addText(htmlspecialchars(round($rsHist->fields['pjeInv'],2)), $fontStyleCe2);
                                    $rsHist->movenext();
                                }
                            }                        
                        $rsOf->movenext();
                    }    
                }
                
                
                $rs->movenext();
            }                                                        
            
        }

// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
