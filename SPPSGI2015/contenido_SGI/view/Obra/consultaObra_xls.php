<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once ('../../libs/phpexcel/Classes/PHPExcel.php');
require_once ('../../libs/phpexcel/Classes/PHPExcel/IOFactory.php');

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");
           
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objWorksheet = $objPHPExcel->getActiveSheet();

// Set document properties
$objPHPExcel->getProperties()->setCreator("aaaaaa")
->setLastModifiedBy("aaaaa")
->setTitle("Office 2007 XLSX Test Document")
->setSubject("Office 2007 XLSX Test Document")
->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
->setKeywords("office 2007 openxml php")
->setCategory("Test result file");

/*// Merge cells
echo date('H:i:s') . " Merge cells\n";
$objPHPExcel->getActiveSheet()->mergeCells('B3:O3');*/

//-----------Estilos--------------

$styleArray1 = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

//------------Imagen en encabezado---------
// $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&Please');
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setWorksheet($objWorksheet);
  $objDrawing->setName("logo");
  $objDrawing->setDescription("Description");
  $objDrawing->setPath('../img/GEM_hrz.jpg');
  $objDrawing->setHeight(50);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setOffsetX(1);
  $objDrawing->setOffsetY(5);

  //-------------titulo de reporte--

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:A4');
$objWorksheet->setCellValueByColumnAndRow(2, 4, 'LISTADO DE SOLICITUDES POR OBRA');

$objWorksheet->getStyle('A4')->applyFromArray($styleArray1);

//-----------------------------

// Add some data

$objPHPExcel->getActiveSheet()->setCellValue('A6', 'No. Solicitud');
$objPHPExcel->getActiveSheet()->setCellValue('B6', 'Tipo de Solicitud');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Nombre de la Obra');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'Monto');
$objPHPExcel->getActiveSheet()->setCellValue('E6', 'Estado');
$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(84);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFill()->getStartColor()->setARGB('008000'); 

$idObr="";
$cont=7;

if(!empty($_REQUEST['idObr'])&&($_REQUEST['idObr'])!=0){
    $idObr = $_REQUEST['idObr'];
}
    $query = "SELECT IdSol, NomSolPre, NomObr, Monto, NomEdo FROM psolicitud
            LEFT JOIN catsolpre USING (IdSolPre)
            LEFT JOIN catedosol USING (IdEdoSol)
            WHERE idObr = ".$idObr;

    $rs = $cnx->Execute($query);
    
    foreach ($rs as $key => $rows) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$cont.'', $rows['IdSol']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$cont.'', utf8_encode($rows['NomSolPre']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$cont.'', utf8_encode($rows['NomObr']));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$cont.'', $rows['Monto']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$cont.'', utf8_encode($rows['NomEdo']));
        $cont ++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('E'.+$cont.'')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':E'.$cont.'')->getBorders()->getTop()->applyFromArray(
        array(
            'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
            'color' => array('rgb' => '808080')
        )
    );

$objPHPExcel->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Obras.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
