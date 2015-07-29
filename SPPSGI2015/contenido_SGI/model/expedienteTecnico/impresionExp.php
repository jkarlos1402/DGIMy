<?php

ob_start();
include "../../libs/tcpdf/tcpdf.php";
require_once('../../libs/tcpdf/tcpdf.php');
require_once('../../libs/tcpdf/tcpdf_barcodes_1d.php');

class MYPDF extends TCPDF {

    public function Header() {
        $this->SetFont('Helvetica', 'B', 8);

        $this->SetLineWidth(0.5);
        $this->Line(12, 280, 195, 280);
        $this->Ln(0.5);
        // Logo
        $image_file = K_PATH_IMAGES . 'gem_hztl.jpg';
        $this->Image($image_file, 10, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES . 'logo_GEM_hztl.jpg';
        $this->Image($image_file, 150, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
    }

//    public function Footer() {
//
//        // Position at 15 mm from bottom
//        $this->SetY(-15);
//        // Set font
//        //$this->SetFont('helvetica', 'I', 8);
//
//        $this->Cell(0, 10, 'SECRETARÍA DE FINANZAS', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//        $this->Cell(0, 10, 'SECRETARÍA DE FINANZAS', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//        $this->Cell(0, 10, 'SECRETARÍA DE FINANZAS', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//        $this->Ln(3);
//
////        $this->SetFont('helvetica', 'I', 8);
////        // Page number
////        $this->Cell(270, 0, "", 0, 1, 'R');
////        $this->Cell(270, 0, "SECRETARÍA DE FINANZAS", 0, 1, 'R');
////        $this->Cell(270, 0, "SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO", 0, 1, 'R');
////        $this->Cell(270, 0, "DIRECCIÓN GENERAL DE INVERSIÓN", 0, 0, 'R');
////        // Set font
////        $this->Ln(20);
//    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();



//print_r($_POST);

$turno = $_POST['Turno'];
$area = utf8_encode($_POST['area']);
//echo $area;
$fechaTurno = $_POST['fechaTurno'];

$cuerpo = "";
for ($i = 0; $i < count($_POST['idSol']); $i++) {
    $cuerpo.="<tr>";
    $cuerpo.="<td>" . $_POST['idSol'][$i] . "</td><td>" . $_POST['ue'][$i] . "</td><td>" . $_POST['tipo'][$i] . "</td>";
    $cuerpo.="</tr>";
}
$cuerpo = utf8_encode($cuerpo);
//echo $cuerpo;
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="center" width= "100%">

<tr>
  <th colspan="3">TURNADO A DIRECCIONES DE ÁREA</th>
 </tr>
        <tr>
  <th colspan="3">TURNO:<span class="text">$turno</span></th>
 </tr>
<tr><td colspan="1"><span class="head">Turnado a: </span><span class="text">$area</span></td><td colspan="2"><span class="head">Fecha: </span><span class="text">$fechaTurno</span><br><span class="head">Turnada por: </span><span class="text">Ventanilla</span></td></tr>
     
 <tr>
  <td width= "25%">NUM. SOLICITUD</td>
  <td width= "45%">UNIDAD EJECUTORA</td>
  <td width= "30%">TIPO DE SOLICITUD</td>
 </tr>
    $cuerpo
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('turnoExpedientes' . $turno . '.pdf', 'I');
