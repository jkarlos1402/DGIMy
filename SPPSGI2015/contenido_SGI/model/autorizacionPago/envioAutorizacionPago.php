<?php
ob_start();

if ($_POST) {
    extract($_POST);
    $Meses = array(
        '1' => 'Enero',
        '2' => 'Febrero',
        '3' => 'Marzo',
        '4' => 'Abril',
        '5' => 'Mayo',
        '6' => 'Junio',
        '7' => 'Julio',
        '8' => 'Agosto',
        '9' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    );


    include 'funcionesApModel.php';
    $model = new aplicacionModel();
    $result = $model->dataPdfEnvio($relacion);
    
    //print_r($result);
    //exit;

    $cveAp = '';
    foreach ($result as $row) {
        $ofirel = $row['OfiRel'];
        $fecha = $row['FecEnv'];
        $TitTipRel = $row['TitTipRel'];
        $TxtTipRel = $row['TxtTipRel'];
        $CcpTipRel = $row['CcpTipRel'];
        $ejRel = $row['Ejercicio'];
    }






    $fechaOficio = $fecha;
    $ano = substr($fechaOficio, 0, 4);
    $mes = substr($fechaOficio, 5, 2);
    $dia = substr($fechaOficio, 8, 2);

    $fechaOficio = (int) $dia . " de " . $Meses[($mes)] . " de " . $ano;
    //session_start();
require_once('../../libs/tcpdf/tcpdf.php');
//require_once('../../libs/tcpdf/tcpdf_barcodes_1d.php');

    $contenido = '<table>                    
                    <tr>                        
                        <td align="center">"2015. AÑO DEL BICENTENARIO LUCTUOSO DE JOSÉ MARÍA MORELOS Y PAVÓN"
                        </td>
                    </tr>   
                    <tr><td></td></tr>                    
                  </table>
         
                  <table align="right">
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>                    
                    <tr>                        
                        <td>
                        </td>
                        <td>' . $ofirel . '</td>
                    </tr>                                       
                    <tr>
                        <td></td>
                        <td>Toluca de Lerdo, México; ' . $fechaOficio . '</td>
                    </tr>
                </table>
         
                <table>
                    <tr><td></td></tr>
                    <tr>
                        <td width="300">' . utf8_encode($TitTipRel) . '</td>
                    </tr>
                    <tr>
                        <td>P R E S E N T E.</td>
                    </tr>                    
                    <tr><td></td></tr>
                </table>
                
                <table>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr>
                        <td><span style="text-align:justify; heigth: 400">' . utf8_encode($TxtTipRel) . '</span></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                </table>
                <table align="center">
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>A T E N T A M E N T E</td></tr>
                    <tr><td>DIRECTOR DE</td></tr>
                    <tr><td>REGISTRO Y CONTROL DE LA INVERSIÓN</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>C. VÍCTOR MANUEL DÍAZ REYES</td></tr>
                </table>
                <table style="font-size: 10px">
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td>' . utf8_encode($CcpTipRel) . '</td></tr>   
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>    
                </table>';

    //echo $contenido;
    //exit;


    class MYPDF extends TCPDF {
        
        public $rel;
        public $oficio;
        public $eR;
     
        public function setData($rel,$oficio,$ejRel){
        $this->rel = $rel;
        $this->oficio=$oficio;
        $this->eR=$ejRel;
        }
        
        //Page header
        public function Header() {
            $this->SetFont('helvetica', 'n', 7);
            // Logo
            $image_file = K_PATH_IMAGES . 'gem_hztl.jpg';
            $this->Image($image_file, 10, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
            $image_file = K_PATH_IMAGES . 'logo_GEM_hztl.jpg';
            $this->Image($image_file, 150, 5, 40, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
            
            $this->Cell(200, 0, "DETALLE DE AUTORIZACIONES DE PAGO", 0, 1, 'C');
            $this->Cell(200, 0, "RELACIÓN DE ENVÍO: ".$this->rel." EJERCICIO: ".$this->eR, 0, 1, 'C');
            $this->Cell(200, 0, "NO. DE OFICIO:", 0, 1, 'C');
            $this->Cell(200, 0, $this->oficio, 0, 0, 'C');
            // Set font
            $this->Ln(20);
            
        }

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
//            $this->SetY(-15);
//            $this->SetFont('Helvetica', 'L', 8);
//
            $this->SetLineWidth(0.5);
            $this->Line(12, 280, 195, 280);
           
//
//
//            $this->Cell(90, 0, utf8_encode("Secretaría de Finanzas"), 0, 0, 'R');
//            $this->Cell(5, 0, '', 0);
//            $this->Cell(90, 0, utf8_encode('Calle Colorín No. 101'), 0, 1);
//
//            $this->Cell(90, 0, utf8_encode("SubSecretaria de Planeación y Presupuesto"), 0, 0, 'R');
//            $this->Cell(5, 0, '', 0);
//            $this->Cell(90, 0, 'Colonia Lomas Altas', 0, 1);

            // Set font
            $this->SetFont('Helvetica', 'I', 7);
            // Page number
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }

    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setData($relacion, $ofirel,$ejRel);
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //-----------------------------
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(10, 30, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set font
//    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->Addpage();


    $html = <<<EOF
<style> 
</style>                
$contenido                
EOF;



    $sumejercido = 0;
    $sumanticipo = 0;
    $sumamortizado = 0;
   

    for ($i = 0; $i < count($idAps); $i++) {
        $params;
        if ($idTipAps[$i] == '2') {
            $anticipo = number_format($monto[$i], 2, '.', ',');
            $sumanticipo = $sumanticipo + (float)$monto[$i];
            $ejercido = '0.00';
            $amortizado = '0.00';
        }
        if ($idTipAps[$i] == '4' || $idTipAps[$i] == '6') {
            $ejercido = number_format($monto[$i], 2, '.', ',');
            $sumejercido = $sumejercido + (float)$monto[$i];
            $amortizado = number_format($montoAmortizacion[$i], 2, '.', ',');
            $sumamortizado = $sumamortizado + (float)$montoAmortizacion[$i];
            $anticipo ='0.00';
        }
        if ($idTipAps[$i] == '7') {
            $amortizado = number_format($montoAmortizacion[$i], 2, '.', ',');
             $sumamortizado = $sumamortizado + (float)$montoAmortizacion[$i];
            $ejercido = '0.00';
             $anticipo ='0.00';
        }
        if($i==0){
            $cont.='<tr class="sector"><td colspan="7"><span class="di">'.$NomSec[$i].'</span></td></tr>';
            $cont.='<tr class="ue"><td colspan="7">'.$NomUe[$i].'</td></tr>';
        }else{
            if($idSec[$i]!==$idSec[$i-1]){
                $cont.='<tr><td colspan="7">'.$NomSec[$i].'</td></tr>';
            }
            if($idUe[$i]!==$idUe[$i-1]){
                $cont.='<tr><td></td><td colspan="6">'.$NomUe[$i].'</td></tr>';
            }
        }
        $cveAp = $CveAps[$i];
       $params = $pdf->serializeTCPDFtagParameters(array($ano.'$I2$I'.$cveAp, 'C39', '', '', 50, 5, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>false, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
        $cont .= '   <tr>
                            <td width="10%" class="bold">' . utf8_encode($CveAps[$i]) . '</td>
                            <td width="20%">' . utf8_encode($NomEmp[$i]) . '</td>
                            <td >' . utf8_encode($TipoFte[$i]) . '</td>    
                            <td>' . utf8_encode($ejercicio[$i]) . '</td>        
                            <td class="izquierda">' . $ejercido . '</td>                                        
                            <td class="izquierda">' . $anticipo . '</td>
                            <td class="izquierda">' . $amortizado . '</td>
                        </tr>';
        $cont .= '<tr><td><tcpdf method="write1DBarcode" params="'.$params.'" /></td></tr>';

//                     <tr>
//                        <td colspan="7">
//                        </td>
//                     </tr>';
        
        
        
    }
    $sumejercido = number_format($sumejercido, 2, '.', ',');
    $sumanticipo = number_format($sumanticipo, 2, '.', ',');
    $sumamortizado = number_format($sumamortizado, 2, '.', ',');
    $pdf->SetPrintHeader(true);
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->AddPage();
    $html2 = <<<EOF
<style> 
.Tabla{
    font-size: 9px;
}
.sector{
    background-color:#b2b2b2;
            font-size: 11px;
            font-weight:bold;
            text-align: center;
        }
.ue{
            font-size: 10px;
    background-color:#d1d1d1;
        font-weight:bold;
    }
.izquierda{
    text-align:right;        
    }
.bold{
   font-weight:bold;         
    }
        
</style>  
<table class="Tabla" CELLSPACING="5">
    <thead>
        <tr class="bold">
            <th width="10%">Folio</th>
            <th width="20%">Sector / Dependencia <br />Beneficiario</th>
            <th >Inversión</th> 
            <th >Ejercicio</th> 
            <th class="izquierda">Monto<br />Ejercido</th>
            <th class="izquierda">Monto<br />de Anticipo</th>
            <th class="izquierda">Monto <br />Amortizado</th>
        </tr>    
    </thead>
   
     $cont      
   
   
    <tr class="bold">
      <td colspan="2"></td>
      <td>Total</td>
      <td></td>
      <td class="izquierda">$sumejercido</td>
      <td class="izquierda">$sumanticipo</td>
      <td class="izquierda">$sumamortizado</td>
    </tr>
     
</table>    
EOF;
    $pdf->SetPrintFooter(true);
    $pdf->writeHTML($html2, true, false, true, false, '');
    $pdf->lastPage();

    $style = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => true,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false, //array(255,255,255),
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 4
    );

    ob_end_clean();
    $pdf->Output($relacion.'-'.$ofirel, 'I');
} else {
    header(':', true, 404);
    header('X-PHP-Response-Code: 404', true, 404);
    echo $error_code = "<h1>403 - Forbidden</h1>";
    echo $explanation = "<h3>This section requires a password or is otherwise protected.</h3>";
}

?>