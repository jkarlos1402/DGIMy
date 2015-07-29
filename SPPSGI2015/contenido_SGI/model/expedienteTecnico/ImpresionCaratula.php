<?php

ob_start();
include "../../libs/tcpdf/tcpdf.php";
require_once('../../libs/tcpdf/tcpdf.php');
require_once('../../libs/tcpdf/tcpdf_barcodes_1d.php');

class MYPDF extends TCPDF {

    public function Header() {
        $this->SetFont('freesans', 'B', 8);

        $this->SetLineWidth(0.5);
        $this->Line(12, 280, 195, 280);
        $this->Ln(0.5);
        // Logo

        $image_file = K_PATH_IMAGES . 'gem_hztl.jpg';
        $this->Image($image_file, 10, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES . 'logo_GEM_hztl.jpg';
        $this->Image($image_file, 150, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);


//        $this->Cell(270, 0, "", 0, 1, 'R');
//        $this->Cell(270, 0, "SECRETARÍA DE FINANZAS", 0, 1, 'R');
//        $this->Cell(270, 0, "SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO", 0, 1, 'R');
//        $this->Cell(270, 0, "DIRECCIÓN GENERAL DE INVERSIÓN", 0, 0, 'R');
//        // Set font
//        $this->Ln(20);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('freesans', 'L', 8);

        $this->SetLineWidth(0.5);
        $this->Line(12, 280, 195, 280);
        $this->Ln(0.5);


        $this->Cell(90, 0, 'SECRETARÍA DE FINANZAS', 0, 0, 'R');
        $this->Cell(5, 0, '', 0);
        $this->Cell(90, 0, 'CALLE COLORÍN No. 101', 0, 1);

        $this->Cell(90, 0, "SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO", 0, 0, 'R');
        $this->Cell(5, 0, '', 0);
        $this->Cell(90, 0, 'COLONIA LOMAS ALTAS', 0, 1);

        $this->Cell(90, 0, "DIRECCIÓN GENERAL DE INVERSIÓN", 0, 0, 'R');
        $this->Cell(5, 0, '', 0);

        // Set font
        // Page number
//            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'freesans', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set font
$pdf->SetFont('freesans', '', 10);

// add a page
$pdf->AddPage();


date_default_timezone_set('UTC-06:00');
$ejercicio = $_POST['ejercicioCaratula'];
$ue = utf8_encode($_POST['ueCaratula']);
$idSol = $_POST['idsolCaratula'];
$nombreObra = utf8_encode($_POST['nomobraCaratula']);
$tipoSol = utf8_encode($_POST['tiposolCaratula']);
$montof = $_POST['montofedCaratula'];
$montoe = $_POST['montoestCaratula'];
$montom = $_POST['montomunCaratula'];
$montoTotal = $_POST['montototalCaratula'];
$numContrato = $_POST['numContrato'];
$montoContrato = $_POST['montoContrato'];
$marcaAgua = $_POST['marcaAgua'];

$hoy = date("d-m-Y H:i:s");

// Right alignment
//$style['align'] = 'R';
//$pdf->write1DBarcode($idSol,'C128A', '', '', '', 15, 0.4, $style, 'N');
//$pdf->Ln(2);
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center" width= "100%">
 <tr>
  <th colspan="3">EXPEDIENTE TECNICO</th>
 </tr>
        
 <tr>
  <td width= "25%">EJERCICIO<p>$ejercicio</p><br></td>
  <td width= "45%">UNIDAD EJECUTORA<p>$ue</p></td>
  <td width= "30%">NO. SOLICITUD<p></p></td>
 </tr>
 <tr>
  <td>TIPO EXPEDIENTE<p>$tipoSol</p></td>
  <td>NOMBRE DE LA OBRA<p>$nombreObra</p><br></td>
  <td>FECHA DE IMPRESION<p class="info">$hoy</p></td>
 </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

if (isset($_POST['montofedCaratula'])) {
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center" width= "100%">
 <tr nobr="true">
  <td width= "100%">MONTOS PRESUPUESTALES</td>
 </tr>
 <tr nobr="true">
  <td width= "40%">FEDERAL</td>
  <td width= "60%" style="text-align: right;">$ $montof</td>
 </tr>
 <tr nobr="true">
  <td>ESTATAL</td>
  <td style="text-align: right;">$ $montoe</td>
 </tr>
  <tr nobr="true">
  <td>MUNICIPAL</td>
  <td style="text-align: right;">$ $montom</td>
 </tr>
   <tr nobr="true">
  <td>TOTAL</td>
  <td style="text-align: right;"><b>$ $montoTotal</b></td>
 </tr>
</table></center>
EOD;

    $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
}

if (isset($_POST['numContrato'])) {
    $contratos = "";
    for ($i = 0; $i < count($numContrato); $i++) {
        $contratos.="<tr><td>$numContrato[$i]</td><td>$ ".number_format($montoContrato[$i], 2)."</td></tr>";
    }
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center" width= "100%">
 <tr nobr="true">
  <td width= "100%">CONTRATOS</td>
 </tr>
 <tr nobr="true">
  <td width= "40%">CONTRATO</td>
  <td width= "60%">MONTO</td>
 </tr>
 $contratos
   <tr nobr="true">
  <td>TOTAL</td>
  <td><b>$ $montoTotal</b></td>
 </tr>
</table></center>
EOD;

    $pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
}

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center" width= "100%">
 <tr nobr="true">
  <td width= "33%">UNIDAD EJECUTORA</td>
  <td width= "33%">ANALISTA</td>
  <td width= "34%">JEFE DE DEPARTAMENTO</td>
 </tr>
 <tr nobr="true">
  <td width= "33%"><p></p><p></p><p></p>NOMBRE Y FIRMA</td>
  <td width= "33%"><p></p><p></p><p></p>NOMBRE Y FIRMA</td>
  <td width= "34%"><p></p><p></p><p></p>NOMBRE Y FIRMA</td>
 </tr>

</table></center>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <th colspan="3">RECIBIO</th>
 </tr>
 <tr nobr="true">
  <td colspan="3"><p></p><p></p><p></p><p></p>NOMBRE Y FIRMA</td>
 </tr>
</table>
EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');
ob_end_clean();
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => true,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'freesans',
    'fontsize' => 8,
    'stretchtext' => 4
);

if ($marcaAgua === '1') {

    // get the current page break margin
    $bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
    $auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
    $pdf->SetAutoPageBreak(false, 0);
// set bacground image
    $img_file = K_PATH_IMAGES . 'marcaAgua.jpg';
    $pdf->SetAlpha(0.1);
    $pdf->Image($img_file, 0, 0, 130, 300, '', '', '', false, 300, 'C', false, false, 0);
//    $pdf->Image($img_file, 0, 0, 0, 0, '', '', '', false, 300, '', false, false, 0);

    $pdf->SetAlpha(1);
// restore auto-page-break status
    $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
    $pdf->setPageMark();
} else {
    $pdf->write1DBarcode($idSol, 'C128', 150, 40, 70, 18, 0.4, $style, 'N');
}

//Close and output PDF document
$pdf->Output('SolicitudNo' . $idSol . '.pdf', 'I');
