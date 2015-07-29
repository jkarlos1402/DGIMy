<?php
ob_start();
session_start();
include "../../libs/tcpdf/tcpdf.php";
require_once('../../libs/tcpdf/tcpdf.php');
require_once('../../libs/tcpdf/tcpdf_barcodes_1d.php');
extract($_POST);
class MYPDF extends TCPDF {

    public function Footer() {
        
        $this->SetY(-15);
        
        $this->SetFont('helvetica', 'I', 8);

        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data

// set header and footer fonts

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
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

$i=1;
$contenido="";
for($j=0;$j<count($CveAps);$j++){
    $contenido .= "<tr style='text-align:center;'><td>$CveAps[$j]</td></tr>";
//    echo $j;
//    if($i==1){
//        $contenido.="<tr>";
//    }
//    $contenido .= "<td>$CveAps[$j]</td>";
//    if($i==3){
//        $contenido.="</tr>";
//        $i=1;
//    }else{
//        $i++;
//    }
}
$area = utf8_encode($area);
$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="center" width= "100%">

<tr>
  <th colspan="3">TURNADO A DIRECCIONES DE ÁREA</th>
 </tr>
        <tr>
  <th colspan="3">TURNO: <span>$Turno</span></th>
 </tr>
<tr><td colspan="2"><span class="head">Turnado a: </span><span class="text">$area</span></td><td colspan="1"><span class="head">Fecha: </span><span class="text">$fechaTurno</span><br><span class="head">Turnada por: </span><span class="text">Ventanilla</span></td></tr>
     
 <tr>
  <td colspan="3">A.P.</td>
 </tr>
   $contenido
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
ob_end_clean();
$pdf->Output('turno.pdf', 'I');
print_r($_POST);

?>