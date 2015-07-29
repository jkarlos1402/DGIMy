<?php

	// zona horaria
	date_default_timezone_set('America/Mexico_City');
	//Incluimos la librería
	include('../../libs/adodb/adodb.inc.php'); 	
	//include '../../libs/adodb/adodb.inc.php'; 
	//include '../../includes/conexion-database.php';

	// incluimos parametros de conexion
	require_once('../../includes/conexion-config.php');	
	// Creamos una conexión con el Driver MySQLi
	$cnx = ADONewConnection('mysqli'); 
	// Nos conectamos a la base dedatos
	$cnx->connect($db_host, $db_username, $db_password, $db_database); 

	require '../../libs/fpdf/fpdf.php';
	require '../../libs/fpdf/tbl_estprg.php';

//----- Datos para el Reporte


//----------------Obteniendo datos bd -----------------------

$sSql = " select * from catestprg2015 ";
$rs = $cnx->Execute($sSql); 

$avPrg = array();
while(!$rs->EOF){
	$id = $rs->fields["idPrg"];
	$avPrg[$id]["cve"] = $rs->fields["CvePrg"];
	$avPrg[$id]["dsc"] = utf8_decode( $rs->fields["DscPrg"] );
	$avPrg[$id]["tpo"] = $rs->fields["TpoPrg"];
	$rs->movenext();
}
//-----------------------------------------------------------------------------




//-----------------------Inicio pdf---------------------------------------------
$pdf=new PDF_MC_Table('L','mm','Letter');
$pdf->AddFont('GillSans','','GillSans.php');
$pdf->AddFont('GillSans','B','GillSans_B.php');
$pdf->AddFont('GillSans','BI','GillSans_BI.php');
$pdf->AddFont('GillSans','I','GillSans_I.php');
$pdf->AddFont('GillSans','L','GillSans_L.php');
$pdf->AddFont('GillSans','LI','GillSans_LI.php');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetLeftMargin(25);

//----------------------------------------------

$pdf->SetFont('GillSans','',10);
$pdf->SetFillColor(249, 250, 252);

$pdf->Cell(70,4,' Estructura Programática ',0,0,'L',0);
$pdf->Cell(70,4,'Ejercicio: 2015 ',0,0,'L',0);
$pdf->Ln(5);

$pdf->SetFont('GillSans','B',10);
$pdf->Cell(240,4,'Catálogo de Programas',1,1,'C',1);
$pdf->SetFont('GillSans','',10);
$y = $pdf->GetY();
$x = $pdf->GetX();
$pdf->MultiCell(20,8,'ID',1,'C',1);
$pdf->SetXY($x+20,$y);
$pdf->MultiCell(40,8,'Clave',1,'C',1);
$pdf->SetXY($x+60,$y);
$pdf->MultiCell(150,8,'Descripción',1,'C',1);
$pdf->SetXY($x+210,$y);
$pdf->Cell(30,8,'Tipo',1,0,'C',1);

$pdf->Cell(0,4,'',0,1,'C',0);
$pdf->Ln(4);
//ciclo
$pdf->SetFont('GillSans','L',12);
$pdf->SetWidths(array(20,40,150,30));	

foreach ($avPrg as $key => $value) {
	
	$c1 = $key;
	$c2 = $value['cve'];
	$c3 = $value['dsc'];
	$c4 = $value['tpo'];

	$pdf->Row(array($c1,$c2,$c3,$c4));	

}

//-----------------------Termina ciclo----------------------------------------


$pdf->Output("Programas.pdf",'I');

?>
