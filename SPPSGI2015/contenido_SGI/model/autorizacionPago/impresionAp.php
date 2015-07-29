<?php

ob_start();
include "../../libs/tcpdf/tcpdf.php";
require_once('../../libs/tcpdf/tcpdf.php');
require_once('../../libs/tcpdf/tcpdf_barcodes_1d.php');

print_r($_POST);
extract($_POST);
$ue = utf8_encode($ue);
$sector = utf8_encode($sector);
$nombreObra = utf8_encode($nombreObra);
$movimiento = utf8_encode($movimiento);
$modEjecucion = utf8_encode($modEjecucion);
$beneficiario = utf8_encode($beneficiario);
$observaciones = utf8_encode($observaciones);
$comprobantes = array();
array_push($comprobantes, array('folio' => $noFolio, 'tipoDocumento' => $tipoDocumento, 'importe' => $importe, 'partida' => $partida));

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
        $this->Image($image_file, 120, 5, 40, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);


        $this->Cell(270, 0, "", 0, 1, 'R');
        $this->Cell(270, 0, "SECRETARÍA DE FINANZAS", 0, 1, 'R');
        $this->Cell(270, 0, "SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO", 0, 1, 'R');
        $this->Cell(270, 0, "DIRECCIÓN GENERAL DE INVERSIÓN", 0, 0, 'R');
// Set font
        $this->Ln(20);
    }

// Page footer
//        public function Footer() {
//            // Position at 15 mm from bottom
//            $this->SetY(-15);
//            $this->SetFont('times', 'L', 8);
//
//            $this->SetLineWidth(0.5);
//            $this->Line(12,280,195,280);
//            $this->Ln(0.5);
//
//
//            $this->Cell(90,0, utf8_encode("Secretaría de Finanzas"),0,0,'R'); 
//            $this->Cell(5,0,'',0); 
//            $this->Cell(90,0, utf8_encode('Calle Colorín No. 101'),0,1); 
//
//            $this->Cell(90,0, utf8_encode("SubSecretaria de Planeación y Presupuesto"),0,0,'R'); 
//            $this->Cell(5,0,'',0); 
//            $this->Cell(90,0,'Colonia Lomas Altas',0,1); 
//            
//            // Set font
//            $this->SetFont('Helvetica', 'I', 7);
//            // Page number
//            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//        }
}

// -- set new background ---

$contenido = <<<EOD
        <style>
    .head{background-color: #aaa7a7; text-align:center;}
    .cifras{background-color:#aaa7a7; text-align:right;}
    .titulo{font-weight: bold; font-size: 18px;}
    .conBorde{border-collapse:collapse; border: #000 solid 1px;}
   table{text-align:center;}
   .mainContent{border:none;}
  .aplicacion{border: #000 solid 1px;text-align: left;}
  .formulas{width:20%; text-align:right;}
  
</style>
EOD;
        
        
        
if(isset($folioAmortizacion)&&$folioAmortizacion!==""){
    $tablaAmortizacion = '
                <table border="1" style="width:100%" cellpadding="5">
                <tr class="head" style="font-weight:bold"><td >AMORTIZACIÓN</td></tr>
                </table>
                <table border="1" style="width:100%" cellpadding="5">
                <tr><td>FOLIO QUE AMORTIZA</td><td>I.V.A. DE LA AMORTIZACIÓN</td></tr>
                <tr><td>'.$folioAmortizacion.'</td><td>$'.$montoIvaAmortizacion.'</td></tr>
                </table>';
}
$contenido .= <<<EOD
        <style>
    .head{background-color: #aaa7a7; text-align:center;}
    .cifras{background-color:#aaa7a7;}
    .titulo{font-weight: bold; font-size: 18px;}
    .conBorde{border-collapse:collapse; border: #000 solid 1px;}
   table{text-align:center;}
   .mainContent{border:none;}
  .aplicacion{border: #000 solid 1px;text-align: left;}
  .formulas{width:20%; text-align:right;}
  
</style>
<table style="width:100%" class="mainContent" cellspacing="10">
    <tr>
        <td colspan="2">
            <table class="conBorde" style="width: 100%" cellpadding="5">
                <tr><td class="head titulo">Programa de Acciones para el Desarrollo-<b>Autorizaci&oacute;n de Pago</b></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="conBorde" border="1" style="width: 100%;" cellpadding="5">
                <tr><td style="width:10%">EJERCICIO FISCAL<p>$ejercicio </p></td><td style="width:70%">UNIDAD EJECUTORA<p>$ue</p></td><td colspan="4" style="text-align:left !important; width:20%">FOLIO:<p class="info">&nbsp;</p></td></tr>
                <tr><td rowspan="2">N&Uacute;MERO DE OBRA<p class="info">$obra</p></td><td rowspan="2">NOMBRE DE LA OBRA O ACCI&Oacute;N<p class="info">$nombreObra</p></td><td class="head">FECHA</td><td class="head">D&Iacute;A</td><td class="head">MES</td><td class="head">A&Ntilde;O</td></tr>
                    <tr><td style="font-size:6px;">INGRESO</td><td colspan="3"><p></p></td></tr>
            </table>
        </td>
</tr>
<tr>
    <td style="width: 50%">
        <table class="conBorde" border="1" style="width: 100%" cellpadding="5">
            <tr><td class="conBorde" border="1" colspan="5" style="font-weight:bold;"><span style="width:50%;float:left">PARTIDA PRESUPUESTAL: </span> <span style="width:50%;float:right">SECTOR: $sector</span></td></tr>
            <tr><td class="conBorde" border="1" colspan="2" style="text-align:center">CONCEPTO DE PAGO: <b>$movimiento</b></td><td  class="conBorde" border="1" colspan="3" style="text-align:center">PRESPUESTO AUTORIZADO: $$presupuestoAutorizado</td></tr>

            <tr><td colspan="5" class="head" style="font-weight:bold">LISTADO DE MOVIMIENTOS</td></tr>
            <tr><td colspan="5">
                <table style="width:100%" cellpadding="5">
                <tr><td>FUENTE</td><td>CUENTA</td></tr>
                <tr><td>$descFtes[0]</td><td>$cuentaFtes[0]</td></tr>
                </table>
            </td></tr>
            <tr><td class="conBorde" border="1" style="width:100%" colspan="4">OBRA EJECUTADA POR: <b>$modEjecucion</b></td></tr>
            <tr><td class="conBorde" border="1" style="width:43%">No. DE CONTRATO</td><td class="conBorde" border="1" style="width:13%">INICIO</td><td class="conBorde" border="1" style="width:13%">FIN</td><td class="conBorde" border="1" style="width: 31%">IMPORTE</td></tr>
            <tr><td class="conBorde" border="0" style="width:43%">$noContrato</td><td class="conBorde" border="0" style="width:13%">$fechaIniContrato</td><td class="conBorde" border="0" style="width:13%">$fechaFinContrato</td><td class="conBorde" border="0" style="width: 31%">$importeContrato</td></tr>
        </table>
        <p></p>
        $tablaAmortizacion
        <p></p>
        <table class="conBorde" border="1" style="width: 100%;margin-top:10px;" cellpadding="5">
            <tr><td class="head" colspan="2" style="font-weight:bold">DATOS DE BENEFICIARIO</td></tr>
            <tr><td class="conBorde" style="width:70%">NOMBRE: $beneficiario</td><td style="width:30%">R.F.C.: $rfc</td></tr>
            <tr><td class="head" colspan="2" style="font-weight:bold;">OBSERVACIONES</td></tr>
            <tr><td colspan="2" style="font-size:6.5px;" class="conBorde">$observaciones</td></tr>
        </table>
    </td>
    <td style="width: 50%">
        <table class="aplicacion conBorde" border="1" style="width: 100%" cellpadding="5">
            <tr><td colspan="3" class="head"><b>APLICACI&Oacute;N PRESUPUESTAL</b></td></tr>
            <tr><td style="width:50%">IMPORTE SIN IVA</td><td class="formulas">(A)</td><td style="width:30%; text-align:right" class="cifras">$$impSinIva</td></tr>
            <tr><td>AMORTIZACI&Oacute;N DE ANTICIPO</td><td class="formulas">(B)</td><td style="text-align:right" class="cifras">$$amortizacion</td></tr>
            <tr><td>SUBTOTAL</td><td class="formulas">(C)=(A-B)</td><td style="text-align:right" class="cifras">$$subtotal</td></tr>
            <tr><td>I.V.A.</td><td class="formulas">(D)</td><td style="text-align:right" class="cifras">$$iva</td></tr>
            <tr><td>AFECTACI&Oacute;N PRESUPUESTAL</td><td class="formulas">(E)=(C+D)</td><td style="text-align:right" class="cifras">$$afectacionPresupuestal</td></tr>
            <tr><td>RETENCIONES</td><td class="formulas">(F)</td><td style="text-align:right" class="cifras">$$retenciones</td></tr>
            <tr><td>0.2% I.C.I.C.</td><td class="formulas"></td><td style="text-align:right" class="cifras">$$icic</td></tr>
            <tr><td>0.5% C.M.I.C.</td><td class="formulas"></td><td style="text-align:right" class="cifras">$$cmic</td></tr>
            <tr><td>2% DE SUPERVISI&Oacute;N</td><td class="formulas"></td><td style="text-align:right" class="cifras">$$supervision</td></tr>
            <tr><td>ISPT</td><td class="formulas"></td><td style="text-align:right" class="cifras">$$ispt</td></tr>
            <tr><td>OTRO</td><td class="formulas"></td><td style="text-align:right" class="cifras">$$otro</td></tr>
        </table>
        <p></p>
        <table class="aplicacion conBorde" border="1" style="width: 100%; margin-top:10px;" cellpadding="5">
            <tr><td  style="width:50%">IMPORTE NETO A PAGAR (PESOS)</td><td class="formulas">(G)=(E-F)</td><td style="width:30%; text-align:right;" class="cifras">$$neto</td></tr>
            <tr><td colspan="3" class="head" style="text-align:left">CANTIDAD CON LETRA: <b>$letra</b></td></tr>
        </table>
        <p></p>
        <table class="conBorde" border="1" style="width: 100%; margin-top:10px;" cellpadding="5">
            <tr><td rowspan="2">RECIBI&Oacute;<p class="info">&nbsp;</p></td><td rowspan="2">ANALIZ&Oacute;<p class="info">&nbsp;</p></td><td rowspan="2">REVIS&Oacute;<p class="info">&nbsp;</p></td><td colspan="4">RELACI&Oacute;N DE ENV&Iacute;O</td></tr>
            <tr><td>No.<p class="info">&nbsp;</p></td><td>D&Iacute;A<p class="info">&nbsp;</p></td><td>MES<p class="info">&nbsp;</p></td><td>A&Ntilde;O<p class="info">&nbsp;</p></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table class="conBorde" border="1"   style="width: 100%" cellpadding="5">
            <tr><td style="width: 33%">BENEFICIARIO<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td><td style="width: 33%">AUTORIZ&Oacute; LA DEPENDENCIA EJECUTORA<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td><td style="width: 34%">Vo. Bo. DE LA SECRETAR&Iacute;A DE FINANZAS<br><br><br><br><p><hr align="left" style="width:98%;"><span>NOMBRE, CARGO Y FIRMA</span></p></td></tr>
        </table>
    </td>
</tr>
<tr><td colspan="2">Leyenda</td></tr>
</table>
EOD;

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));


//-----------------------------
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 19, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetAutoPageBreak(true, 0);


// set auto page breaks
//    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set font
$pdf->SetFont('helvetica', '', 6.5);

$pdf->Addpage();

$pdf->writeHTML($contenido, true, false, false, false, '');


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
    $pdf->Image($img_file, 0, 0, 280, 200, '', '', '', false, 300, 'C', false, false, 0);


    $pdf->SetAlpha(1);
// restore auto-page-break status
    $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
    $pdf->setPageMark();
} else {
    $pdf->write1DBarcode($CveAps, 'C128', 235, 33, 43, 13, 0.4, $style, 'N');
}

if (count($comprobantes) > 0) {

    $tablaComprobantes = "";
    for ($i = 0; $i < count($comprobantes[0]['folio']); $i++) {
        $tablaComprobantes.="<tr class='mainContent'><td style='text-align:left;' class='mainContent'>" . $comprobantes[0]['folio'][$i] . "</td>"
                . "<td >" . $comprobantes[0]['tipoDocumento'][$i] . "</td>"
                . "<td >" . $comprobantes[0]['importe'][$i] . "</td>"
                . "<td >" . $comprobantes[0]['partida'][$i] . "</td>"
                . "</tr>";
    }
    $contenido2 = <<<EOD
            <style>
    .head{background-color: #aaa7a7; text-align:center;}
    .titulo{font-weight: bold; font-size: 12px;}
    .subtitulo{font-weight: bold;}
    .conBorde{border: black solid 1; border-collapse:collapse; }
            
            </style>
        <table class="head conBorde titulo" border="1" width="100%">
            <tr><td>RELACIÓN DE DOCUMENTACIÓN SOPORTE DE LA AUTORIZACIÓN DE PAGO</td></tr>
        </table>
        <br><br><br>
        <table border="1" cellpadding="10" style="border-collapse:collapse;" width="100%">            
            <tr class="head subtitulo"><td width="20%">No. DE FOLIO</td><td width="45%">TIPO DE DOCUMENTO</td><td width="20%">IMPORTE $</td><td width="15%">PARTIDA<br>PRESUPUESTAL</td></tr>
            $tablaComprobantes
        </table>           
EOD;

    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->Addpage("P");
//    $pdf->writeHTMLCell($w=0, $h=200, $x='', $y='', $contenido2, $border='L', $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $pdf->writeHTML($contenido2, true, false, false, false, '');
    
    $pdf->setCellHeightRatio(5);
    $contenido3 = <<<EOD
            <style>
    .head{background-color: #aaa7a7; text-align:center;}
    .titulo{font-weight: bold; font-size: 12px;}
    .subtitulo{font-weight: bold;}
    .conBorde{border: black solid 1; border-collapse:collapse; }
            </style>
        <table border="1" cellpadding="10" style="border-collapse:collapse;" width="100%">            
            <tr class="head subtitulo" style="line-height: 100%;"><td width="20%">TITULAR DE LA UNIDAD<BR>EJECUTORA</td><td width="80%">DIRECCIÓN GENERAL DE INVERSIÓN<BR>(RECIBE ORIGINAL Y COPIA)</td></tr>
            <tr class="subtitulo"><td></td><td></td></tr>
        </table>           
EOD;

    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 250, $contenido3, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
}
ob_end_clean();


//echo"<pre>";
//print_r($_POST);
//echo"</pre>";
$pdf->Output('Ap' . $CveAps . '.pdf', 'I');


//            <tr><td class="conBorde" border="1" colspan="2" style="text-align:center">' . $concepto . '</td><td class="conBorde" border="1" colspan="3" style="text-align:center">$'.$_SESSION['montoAutorizado'].'</td></tr>
?>

