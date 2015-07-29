<?php

session_start();
ob_start();
require('../../../libs/tcpdf/tcpdf.php');

$datosAp = $_SESSION['datosAp'][0];
$movAp = $_SESSION['movAp'];
$montosAp = $_SESSION['montosAp'][0];
$ejercido=0.00;
$anticipo=0.00;
$reintegro=0.00;
$amortizado=0.00;
$iva=0.00;
$pagar=0.00;
$ret = 0.00;
foreach ($movAp as $key) {
    if ($key['idTipAps'] == 4 || $key['idTipAps'] == 6) {
       $ejercido = $ejercido + $key['monto'];
    }
    if ($key['idTipAps'] == 2) {
       $anticipo = $anticipo + $key['monto'];
    }
    if ($key['idTipAps'] == 3) {
       $reintegro = $reintegro + $key['monto'];
    }
    if ($key['idTipAps'] == 1) {
       $amortizado = $amortizado + $key['monto'];
    }
    if ($key['idTipAps'] == 5) {
       $iva = $iva + $key['monto'];
    }
}

class MYPDF extends TCPDF {

    public function Header() {
       $this->SetFont('Helvetica', 'B', 8);

            $this->SetLineWidth(0.5);
            $this->Line(12,280,195,280);
            $this->Ln(0.5);
            // Logo
            $image_file = K_PATH_IMAGES.'gem_hztl.jpg';
            $this->Image($image_file, 10, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
            $image_file = K_PATH_IMAGES.'logo_GEM_hztl.jpg';
            $this->Image($image_file, 120, 5, 40, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
            
            
            $this->Cell(270,0,"",0,1,'R'); 
            $this->Cell(270,0,"SECRETARÍA DE FINANZAS",0,1,'R'); 
            $this->Cell(270,0,"SUBSECRETARÍA DE PLANEACIÓN Y PRESUPUESTO",0,1,'R'); 
            $this->Cell(270,0,"DIRECCIÓN GENERAL DE INVERSIÓN",0,0,'R'); 
            // Set font
            $this->Ln(20);
                       
        }
    
    // Page footer
    public function Footer() {

        $this->SetY(-15);

        $this->SetFont('helvetica', 'I', 8);

        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}


$contenido.='<style>
                table{
                    border: #000 solid 1px;
                    border-spacing:  5px 5px;
                }
                table td{
                    font-weight: bold;
                    font-size:9px;
                }
                
                .headTabla{
                    text-align: center;
                    font-weight: bold;
                    background-color: #EEEEEE;
                    font-size: 10px;
                }
                .datos{
                    font-weight: normal;
                }
                .result{
                
                border-top: thin solid #000000;
                }
            </style>';

$contenido.= '<table id="impresion" CELLPADDING=5>
                    <tr>
                    <td colspan="2" style="text-align:center; font-size:16px;">Detalle de la Autorizaci&oacute;n de Pago</td>
                    </tr>
                    <tr>
                        <td style="width:65%">
                            <table id="datosGenerales" style="width: 100%;">
                                <tr><td colspan="5" class="headTabla">Datos Generales</td></tr>
                                <tr>
                                    <td>
                                        Folio: <span class="datos">' . $datosAp['CveAps'] . '</span>
                                    </td>
                                    <td>
                                        Estado: <span class="datos">' . $datosAp['NomEdoAps'] . '</span>
                                    </td>
                                    <td>
                                        Turno: <span class="datos">' . $datosAp['idTurAps'] . '</span>
                                    </td>
                                    <td>
                                        Relaci&oacute;n: <span class="datos">' . $datosAp['CveApsRel'] . '</span>
                                    </td>
                                    <td>
                                        Error: <span class="datos">' . $datosAp['Error'] . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Dependencia:
                                    </td>
                                    <td colspan="4">
                                        <span class="datos"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Beneficiario:
                                    </td>
                                    <td colspan="4">
                                        <span class="datos">' . $datosAp['NomEmp'] . '</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:35%">
                            <table id="seguimiento" style="width: 100%;">
                                <tr><td colspan="3" class="headTabla">Seguimiento</td></tr>
                                <tr>
                                    <td>
                                        Recibi&oacute;:
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Analiz&oacute;:
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Envi&oacute;:
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                    <td>
                                        <span class="datos"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="importes" style="width: 100%;">
                                <tr><td colspan="8" class="headTabla">Importes</td></tr>
                                <tr>
                                    <td>
                                        Ejercido:
                                    </td>
                                    <td>
                                        <span class="datos">'.number_format($ejercido,2,'.',',').'</span>
                                    </td>
                                    <td>
                                        Importe:
                                    </td>
                                    <td>
                                        <span class="datos">'.$montosAp['neto'].'</span>
                                    </td>
                                    <td>
                                        C.N.I.C:
                                    </td>
                                    <td>
                                        <span class="datos">'.$montosAp['cmic'].'</span>
                                    </td>
                                    <td>
                                        ISPT:
                                    </td>
                                    <td>
                                       <span class="datos">'.$montosAp['ispt'].'</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Anticipo:
                                    </td>
                                    <td>
                                        <span class="datos">'.number_format($anticipo,2,'.',',').'</span>
                                    </td>
                                    <td>
                                        Amortizado:
                                    </td>
                                    <td>
                                       <span class="datos">'.number_format($amortizado,2,'.',',').'</span>
                                    </td>
                                    <td>
                                        C.I.C.E.M:
                                    </td>
                                    <td>
                                       <span class="datos">'.$montosAp['icic'].'</span>
                                    </td>
                                    <td>
                                        Otras:
                                    </td>
                                    <td>
                                        <span class="datos">'.$montosAp['otro'].'</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Reintegro:
                                    </td>
                                    <td>
                                        <span class="datos">'.number_format($reintegro,2,'.',',').'</span>
                                    </td>
                                    <td>
                                        I.V.A:
                                    </td>
                                    <td>
                                        <span class="datos">'.number_format($iva,2,'.',',').'</span>
                                    </td>
                                    <td>
                                        Supervisi&oacute;n:
                                    </td>
                                    <td>
                                        <span class="datos">'.$montosAp['supervision'].'</span>
                                    </td>
                                    <td>
                                        Retenciones:
                                    </td>';
$ret = str_replace(",", "", $montosAp['supervision'])+str_replace(",", "", $montosAp['otro'])+str_replace(",", "", $montosAp['icic'])+str_replace(",", "", $montosAp['ispt'])+str_replace(",", "", $montosAp['cmic']);
$pagar = $ejercido-$ret;
$contenido.='                                    <td class="result">
                                        <span class="datos">'.number_format($ret,2,'.',',').'</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        P&aacute;guese la cantidad de: <span class="datos">'.number_format($pagar,2,'.',',').'</span><span class="datos"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="detalleMovimientos" style="width: 100%;">
                                <tr><td colspan="9" class="headTabla">Detalle de Movimientos</td></tr>
                                <tr>
                                    <td>Ejercicio</td>
                                    <td>Obra</td>
                                    <td>Movimiento</td>
                                    <td>Oficio</td>
                                    <td>Referencia</td>
                                    <td>Fuente</td>
                                    <td>Inversi&oacute;n</td>
                                    <td>Recurso</td>
                                    <td>Monto</td>
                                </tr>
                                <tr><td colspan="9" class="headTabla">Autorizaciones de Pago</td></tr>';
foreach ($movAp as $key) {
    if ($key['idTipAps'] == 2 || $key['idTipAps'] == 4 || $key['idTipAps'] == 6) {
         
         if($key['idTipAps']==2){
             $tip="Anticipo";
         }
        
         if($key['idTipAps']==4){
             $tip="Estimaci&oacute;n";
         }
         
         if($key['idTipAps']==6){
             $tip="Pago";
         }
        $contenido.='<tr>
                                    <td class="datos">' . $key['ejercicio'] . '</td>
                                    <td class="datos">' . $key['idObr'] . '</td>
                                    <td class="datos">' . $tip . '</td>
                                    <td class="datos">' . $key['CveOfi'] . '</td>
                                    <td class="datos">' . $key['idRef'] . '</td>
                                    <td class="datos">' . $key['idFte'] . '</td>
                                    <td class="datos">' . $key['nomInv'] . '</td>
                                    <td class="datos">' . $key['nomRec'] . '</td>
                                    <td class="datos">' . number_format($key['monto'],2,'.',',') . '</td>
                                </tr>';
    }
}

$contenido.='                    <tr><td colspan="9" class="headTabla">Comprobaciones y Devoluciones</td></tr>';
foreach ($movAp as $key) {
    if ($key['idTipAps'] == 1 || $key['idTipAps'] == 3 || $key['idTipAps'] == 5) {
        if($key['idTipAps']==1){
             $tip="Amortizaci&oacute;n";
         }
          if($key['idTipAps']==3){
             $tip="Devoluci&oacute;n";
         }
         if($key['idTipAps']==5){
             $tip="Iva";
         }
        $contenido.='<tr>
                                    <td class="datos">' . $key['ejercicio'] . '</td>
                                    <td class="datos">' . $key['idObr'] . '</td>
                                    <td class="datos">' . $tip . '</td>
                                    <td class="datos">' . $key['CveOfi'] . '</td>
                                    <td class="datos">' . $key['idRef'] . '</td>
                                    <td class="datos">' . $key['idFte'] . '</td>
                                    <td class="datos">' . $key['nomInv'] . '</td>
                                    <td class="datos">' . $key['nomRec'] . '</td>
                                    <td class="datos">' . number_format($key['monto'],2,'.',',') . '</td>
                                </tr>';
    }
}

$contenido.='               </table>
                        </td>
                    </tr>
                </table>';

echo $contenido;
//echo "<pre>" . print_r($montosAp) . "</pre>";
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    	

    //-----------------------------
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(10, 22, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    

    // set auto page breaks
//    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set font
    $pdf->SetFont('helvetica', '', 6);
    
    $pdf->Addpage();

$pdf->writeHTML($contenido, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Ap.pdf', 'I');
$_SESSION["datosAp"] = null;
$_SESSION["movAp"] = null;
$_SESSION['montosAp']=null;
//$_SESSION["turno"]=null;
//$_SESSION["area"]=null;
?>


