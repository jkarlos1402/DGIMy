<?php
/** Error reporting */
error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');

require ('contenido_SGI/libs/phpexcel/Classes/PHPExcel.php');
require ('contenido_SGI/libs/phpexcel/Classes/PHPExcel/IOFactory.php');
require ('contenido_SGI/libs/phpexcel/Classes/PHPExcel/Writer/Excel2007.php');

include_once("contenido_SGI/libs/adodb/adodb.inc.php");
require("contenido_SGI/includes/conexion-config.php");

/** PHPExcel */
//include 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
//include 'PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


// Add some data

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', utf8_encode('Número de Proyecto'));
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Proyecto');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total Proyectos');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Monto');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', utf8_encode('Sesión'));
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Fecha');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Oficio');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Tipo de Oficio');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Observaciones');
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);


$objPHPExcel->getActiveSheet()->SetCellValue('B2', utf8_encode('Total General'));
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 30);
$objPHPExcel->getActiveSheet()->SetCellValue('D2', number_format('12223244',2,'.',','));

global $cnx;
$query = "  select * from pofifon pof
            inner join detofifon dof using (IdOfiFon)
            inner join detfonmet dfm using (IdDetFon)
            inner join pfonmet pfm using (IdFonMet)
            inner join catue cue on cue.IdUE = dfm.IdUE
            inner join catsesion cs using (IdSesion)
            inner join cattipofifon cto using (IdTipOfi)
            order by dfm.Ejercicio Desc";

$rs = $cnx->Execute($query);
$cont=3;

$ue = '';
$totDep = 0;
foreach ($rs as $key => $rows) {
    $nue = $rows['NomUE'];
    if($ue != $nue){
        $ue = $nue;        
        $objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':I'.$cont)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':I'.$cont)->getFill()->getStartColor()->setARGB('008000'); 
        
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$cont, utf8_encode($ue));    
        $cont++;
    }
    
    $rows = array_map('utf8_encode', $rows);
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$cont.'', $rows['CvePry']);    
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$cont.'', $rows['NomPry']);        
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$cont.'', '');    
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$cont.'', number_format($rows['Monto'],2,'.',','));    
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$cont.'', $rows['NomSes']);    
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$cont.'', $rows['FecOfi']);    
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$cont.'', $rows['CveOfi']);    
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$cont.'', $rows['NomTipOfi']);    
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$cont.'', $rows['ObsFon']);         
    $cont ++;
}
    


// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Simple');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

// Echo done
//echo date('H:i:s') . " Descargar Excel\r\n";

echo "<a href='contenido_SGI/view/fondoMetropolitano/reportes.xlsx'>Descargar Excel</a>";