<?php

include_once '../../model/banco/bancoModel.php';
$bancoModel = new BancoModel();
$infoBcoPDF = $bancoModel->getInfoBcoFicha($_POST['idBcoFicha']);
// zona horaria	
date_default_timezone_set('America/Mexico_City');
require_once('../../libs/tcpdf/tcpdf.php');
include_once 'rpt_logos_encabezado.php';
// create new PDF 
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//-----------------------------
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(15, 30, 15);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set font
$pdf->SetFont('helvetica', '', 9);

# creamos una página en blanco	
$pdf->Addpage();
$pdf->SetFont('helvetica', '', 9);

// define barcode style
$style = array(
    'position' => 'R',
    'align' => 'C',
    'stretch' => 0,
    'fitwidth' => 1,
    'cellfitalign' => '',
    'border' => 1,
    'hpadding' => '2',
    'vpadding' => '2',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'Helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

$styleBC = array(
    'position' => 'R',
    'border' => 1,
    'padding' => 2,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => array(255, 255, 255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);
$estilo_tabla = "<style>
    .tablaFicha{
        width: 100%;
        font-size: 10px;        
    }
    .celdaTablaFicha{
        border: 1px solid #CCCCCC;
        vertical-align: middle;
    }
    .fecha{
        text-align: right;
    }
    .encabezado{
        background-color: #EFEFEF;
    }
</style>";

$sTituloReporte = "FICHA DE INGRESO A BANCO DE PROYECTOS";
//--------------------Contenido del reporte >---------------------------------------------------

$pdf->SetFont('times', 'L', 6);


$pdf->write1DBarcode($infoBcoPDF['IdBco'], 'C39', '', '', '', 12, 0.4, $style, 'N');
$pdf->Ln();

$pdf->SetFont('times', '', 9);
$pdf->Cell(0, 0, strtoupper($sTituloReporte), 0, 1, 'C', 0, 1);
$pdf->Ln(2);

$inicio_tabla_nomProyecto = "";
$inicio_tabla_nomProyecto .= "<table class=\"tablaFicha\" cellpadding=\"5\">
    <tr>
        <td colspan=\"6\" class=\"fecha\">FECHA DE REGISTRO:</td>
        <td class=\"celdaTablaFicha\">" . $infoBcoPDF['FecReg'] . "</td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\">NOMBRE DEL PROYECTO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['NomObr']) . "</td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\">SECTOR:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['NomSec']) . "</td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\">UNIDAD EJECUTORA:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['NomUE']) . "</td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\">OBJETIVO DEL PROYECTO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['Justifi']) . "</td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">VIDA &Uacute;TIL DEL PROYECTO:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['vidaPry']) . " A&Ntilde;OS</td>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">MONTO TOTAL DE INVERSI&Oacute;N:</td>
        <td class=\"celdaTablaFicha\" colspan=\"2\">$" . number_format($infoBcoPDF['monto'],2) . " </td>
    </tr>
    <tr>
        <td class=\"celdaTablaFicha encabezado\">COBERTURA:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['NomCob']) . "</td>";
if ($infoBcoPDF['IdCob'] === "2") {
    $inicio_tabla_nomProyecto .= "<td class=\"celdaTablaFicha encabezado\">REGIONES:</td>
        <td class=\"celdaTablaFicha\" colspan=\"4\">";
    $regionesFicha = "";
    for ($i = 0; $i < count($infoBcoPDF['regiones']); $i++) {
        $regionesFicha .= $infoBcoPDF['regiones'][$i]['CveReg'] . " " . utf8_encode($infoBcoPDF['regiones'][$i]['NomReg']) . ", ";
    }
    $regionesFicha = trim($regionesFicha, ", ");
    $inicio_tabla_nomProyecto .= $regionesFicha . "</td> ";
} else if ($infoBcoPDF['IdCob'] === "3") {
    $inicio_tabla_nomProyecto .= "<td class=\"celdaTablaFicha encabezado\">MUNICIPIOS:</td>
        <td class=\"celdaTablaFicha\" colspan=\"4\">";
    $municipiosFicha = "";
    for ($i = 0; $i < count($infoBcoPDF['municipios']); $i++) {
        $municipiosFicha .= utf8_encode($infoBcoPDF['municipios'][$i]['NomMun']) . ", ";
    }
    $municipiosFicha = trim($municipiosFicha, ", ");
    $inicio_tabla_nomProyecto .= $municipiosFicha . "</td>";
}
$inicio_tabla_nomProyecto .= "</tr>";
if($infoBcoPDF['NomLoc'] !== ""){
        $inicio_tabla_nomProyecto .= "
    <tr>
        <td class=\"celdaTablaFicha encabezado\">LOCALIDAD:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['NomLoc']) ."</td>
    </tr>";
    }
$inicio_tabla_nomProyecto .= "    
    <tr>
        <td class=\"celdaTablaFicha encabezado\">DESCRIPCI&Oacute;N DEL PROYECTO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"6\">" . utf8_encode($infoBcoPDF['PriCar']) . "</td>
    </tr>";
if(count($infoBcoPDF['accionesF']) > 0){
    $accFedFicha = "";
    $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">ACCIONES DE GOBIERNO FEDERALES:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    for ($i = 0; $i < count($infoBcoPDF['accionesF']); $i++) {
            $accFedFicha .= utf8_encode($infoBcoPDF['accionesF'][$i]['NomAcu']) . ", ";
    }
    $accFedFicha = trim($accFedFicha, ", ");
    $inicio_tabla_nomProyecto .= $accFedFicha . "</td>";
    $inicio_tabla_nomProyecto .= "</tr>";
}
if(count($infoBcoPDF['accionesE']) > 0){
    $accEstFicha = "";
    $inicio_tabla_nomProyecto .= "<tr>          
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">ACCIONES DE GOBIERNO ESTATALES:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    for ($i = 0; $i < count($infoBcoPDF['accionesE']); $i++) {
        $accEstFicha .= utf8_encode($infoBcoPDF['accionesE'][$i]['NomAcu']) . ", ";
    }
    $accEstFicha = trim($accEstFicha, ", ");
    $inicio_tabla_nomProyecto .= $accEstFicha . "</td>";
    $inicio_tabla_nomProyecto .= "</tr>";
}
if ($infoBcoPDF['ObsCoo'] !== "") {
    $inicio_tabla_nomProyecto .= "<tr>
        <td class = \"celdaTablaFicha encabezado\" colspan=\"2\">UBICACI&Oacute;N DEL PROYECTO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"5\">" . utf8_encode($infoBcoPDF['ObsCoo']) . "</td>                        
    </tr>";
} else {
    $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" rowspan=\"2\" colspan=\"2\">UBICACI&Oacute;N DEL PROYECTO:</td>               
        <td class=\"celdaTablaFicha encabezado\">LATITUD:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['LatIni']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">LONGITUD:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['LonIni']) . "</td>                       
    </tr>";
    if (floatval($infoBcoPDF['LatFin']) != 0) {
        $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\">LATITUD FINAL:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['LatFin']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">LONGITUD FINAL:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['LonFin']) . "</td> 
    </tr>";
    }
}
$inicio_tabla_nomProyecto .= "
    <tr>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"3\">TIEMPO ESTIMADO DE DESARROLLO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"2\">" . utf8_encode($infoBcoPDF['DurAgs']) . " A&Ntilde;OS</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">" . utf8_encode($infoBcoPDF['DurMes']) . " MESES</td>
    </tr>";
if (floatval($infoBcoPDF['IdBen']) != 0) {
    $inicio_tabla_nomProyecto .= "
    <tr>
        <td class=\"celdaTablaFicha encabezado\">BENEFICIADOS:</td>                
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">UNIDAD DE MEDIDA:</td>
        <td class=\"celdaTablaFicha\" colspan=\"2\">" . utf8_encode($infoBcoPDF['NomBen']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">CANTIDAD:</td>
        <td class=\"celdaTablaFicha\">" . number_format($infoBcoPDF['CanBen'],2) . "</td>        
    </tr>";
}
$inicio_tabla_nomProyecto .= "
    <tr>
        <td class=\"celdaTablaFicha encabezado\">METAS:</td>               
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">UNIDAD DE MEDIDA:</td>
        <td class=\"celdaTablaFicha\" colspan=\"2\">" . utf8_encode($infoBcoPDF['NomMet']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">CANTIDAD:</td>
        <td class=\"celdaTablaFicha\">" . number_format($infoBcoPDF['CanMet'],2) . "</td>        
    </tr>";
$bndFederal = true;
$bndEstatal = true;
$contadorFederal = 1;
$contadorEstatal = 1;
for ($i = 0; $i < count($infoBcoPDF['fuentes']); $i++) {
    if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "F" && $bndFederal) {
        $numRowsFed = $numRowsFed + 1;
    }
    if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "E" && $bndFederal) {
        $numRowsEst = $numRowsEst + 1;
    }
}
for ($i = 0; $i < count($infoBcoPDF['fuentes']); $i++) {
    if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "F" && $bndFederal) {
        $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" rowspan=\"".$numRowsFed."\">FUENTES FEDERALES:</td>  
        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['fuentes'][$i]['DscFte']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
        <td class=\"celdaTablaFicha\">$" . number_format($infoBcoPDF['fuentes'][$i]['monto'],2) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
        <td class=\"celdaTablaFicha\">" . round(($infoBcoPDF['fuentes'][$i]['pjeInv']),2) . "%</td>        
    </tr>";
        $bndFederal = false;
    } else if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "F" && !$bndFederal) {
        $inicio_tabla_nomProyecto .= "<tr>          
        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['fuentes'][$i]['DscFte']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
        <td class=\"celdaTablaFicha\">$" . number_format($infoBcoPDF['fuentes'][$i]['monto'],2) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
        <td class=\"celdaTablaFicha\">" . round(($infoBcoPDF['fuentes'][$i]['pjeInv']),2) . "%</td>       
    </tr>";
        $contadorFederal++;
    }
    $inicio_tabla_nomProyecto = str_replace("numRowsFed", $contadorFederal, $inicio_tabla_nomProyecto);
    if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "E" && $bndEstatal) {
        $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" rowspan=\"".$numRowsEst."\">FUENTES ESTATALES:</td>               
        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['fuentes'][$i]['DscFte']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
        <td class=\"celdaTablaFicha\">$" . number_format($infoBcoPDF['fuentes'][$i]['monto'],2) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
        <td class=\"celdaTablaFicha\">" . round(($infoBcoPDF['fuentes'][$i]['pjeInv']),2) . "%</td>        
    </tr>";
        $bndEstatal = false;
    } else if ($infoBcoPDF['fuentes'][$i]['TipoFte'] === "E" && !$bndEstatal) {
        $inicio_tabla_nomProyecto .= "<tr>          
        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['fuentes'][$i]['DscFte']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
        <td class=\"celdaTablaFicha\">$" . number_format($infoBcoPDF['fuentes'][$i]['monto'],2) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">PORCENTAJE:</td>
        <td class=\"celdaTablaFicha\">" . round(($infoBcoPDF['fuentes'][$i]['pjeInv']),2) . "%</td>       
    </tr>";
        $contadorEstatal++;
    }
    $inicio_tabla_nomProyecto = str_replace("numRowsEst", $contadorEstatal, $inicio_tabla_nomProyecto);
}
if ($infoBcoPDF['FteMun'] !== "") {
    $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\">FUENTE MUNICIPAL:</td>               
        <td class=\"celdaTablaFicha encabezado\">NOMBRE:</td>
        <td class=\"celdaTablaFicha\">" . utf8_encode($infoBcoPDF['FteMun']) . "</td>        
        <td class=\"celdaTablaFicha encabezado\">MONTO:</td>
        <td class=\"celdaTablaFicha\" colspan=\"4\">$" . number_format($infoBcoPDF['MonMun'],2) . "</td>                       
    </tr>";
}
//factibilidad Legal
$varFL = 0;
$fL = "";
$jdFL = $infoBcoPDF['FactLeg'];
$objFL = json_decode($jdFL,true);
$arrayFL = array(
    "fl_cu_libder" => "Liberaci&oacute;n de Derecho de V&iacute;a",
    "fl_cu_libter" => "Liberaci&oacute;n del Terreno (libre de gravamen)",
    "fl_cu_cfe" => "Permisos de CFE",
    "fl_cu_telmex" => "Permisos de TELMEX",
    "fl_cu_pemex" => "Permisos de PEMEX",
    "fl_cu_inah" => "Permisos del INAH",
    "fl_cu_inba" => "Permisos del INBA",
    "fl_cu_sep" => "Autorizaci&oacute;n de la SEP",
    "fl_cu_isem" => "Permisos del ISEM",
    "fl_cu_conagua" => "Permisos de CONAGUA",
    "fl_cu_marcas" => "Registro de Marcas",
    "fl_cu_producto" => "Uso del Producto",
    "fl_cu_caem" => "Permisos de CAEM",
    "fl_cu_jc" => "Permisos de la JC",
    "fl_cu_autmun" => "Permisos de la Autoridad Municipal",
);
foreach ($objFL as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if($valor==1){
                $varFL++;
                $fL .= $arrayFL["$clave"]. ", ";
            }
        }
    }
}
if($varFL > 0){
    $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD LEGAL:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    $fL = trim($fL, ", ");
    $inicio_tabla_nomProyecto .= $fL . "</td>";
    $inicio_tabla_nomProyecto .= "</tr>";
}
//factibilidad Ambiental
$varFA1 = 0;
$varFA2 = 0;
$varFA3 = 0;
$fA1 = "";
$fA2 = "";
$fA3 = "";
$jdFA = $infoBcoPDF['FactAmb'];
$objFA = json_decode($jdFA,true);
$arrayFA = array(
    "fa_us_moda" => "Trámite Unificado de Cambio de Uso de Suelo Forestal. Modalidad A",
    "fa_us_solautcu" => "Solicitud de Autorización de Cambio de Uso de Suelo en Terrenos Forestales:",
    "fa_ia_miariesgo" => "MIA con riesgo",
    "fa_ia_miapart" => "MIA Particular",
    "fa_ia_miapr" => "MIA Particular con Riesgo",
    "fa_ia_infpre" => "Informe Preventivo",
    "fa_ia_camb" => "Certificación Ambiental",
    "fa_ea_aamia" => "Liberaci&oacute;n de Derecho de V&iacute;a",
    "fa_ea_actamia" => "Liberaci&oacute;n del Terreno (libre de gravamen)",
    "fa_ea_anramia" => "Permisos de CFE",
    "fa_ea_sepmia" => "Permisos de TELMEX",
    "fa_ea_mpamia" => "Permisos de PEMEX",
    "fa_ea_pcca" => "Permisos del INAH",
    "fa_ea_atscrp" => "Permisos del INBA",
    "fa_ea_salfor" => "Autorizaci&oacute;n de la SEP",
    "fa_ea_plca" => "Permisos del ISEM",
    "fa_ea_apfo" => "Permisos de CONAGUA",
);
foreach ($objFA as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if($valor==1){
                if($key == "uso_suelo"){
                    $varFA1++;
                    $fA1 .= $arrayFA["$clave"]. ", ";
                }
                if($key == "impacto_ambiental"){
                    $varFA2++;
                    $fA2 .= $arrayFA["$clave"]. ", ";
                }
                if($key == "extensiones_avisos"){
                    $varFA3++;
                    $fA3 .= $arrayFA["$clave"]. ", ";
                }
            }
        }
    }
}
if($varFA1 > 0){
    $inicio_tabla_nomProyecto .= "<tr>";
        if($varFA2 > 0 && $varFA3 > 0){
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"3\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }elseif ($varFA2 > 0 || $varFA3 > 0) {
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"2\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }else{
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }
    $inicio_tabla_nomProyecto .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">CAMBIO DE USO DE SUELO</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA1 = trim($fA1, ", ");
    $inicio_tabla_nomProyecto .= $fA1 . "</td> </tr>";
}
if($varFA2 > 0){
    $inicio_tabla_nomProyecto .= "<tr>";
        if($varFA3 > 0 && !$varFA1){
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" rowspan=\"3\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }elseif (!$varFA3 && !$varFA1) {
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }
    $inicio_tabla_nomProyecto .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">MANIFESTACI&Oacute;N DE IMPACTO AMBIENTAL</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA2 = trim($fA2, ", ");
    $inicio_tabla_nomProyecto .= $fA2 . "</td> </tr>";
}
if($varFA3 > 0){
    $inicio_tabla_nomProyecto .= "<tr>";
        if(!$varFA1 && !$varFA2){
            $inicio_tabla_nomProyecto .= "
                <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD AMBIENTAL:</td>";
        }
    $inicio_tabla_nomProyecto .="
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">MODIFICACIONES EXENCIONES Y AVISOS</td>
        <td class=\"celdaTablaFicha\" colspan=\"3\">";
    $fA3 = trim($fA3, ", ");
    $inicio_tabla_nomProyecto .= $fA3 . "</td> </tr>";
}
//factibilidad Técnica
$varFT = 0;
$fT = "";
$jdFT = $infoBcoPDF['FactTec'];
$objFT = json_decode($jdFT,true);
$arrayFT = array(
    "ft_cu_antpry" => "Anteproyecto",
    "ft_cu_pryeje" => "Proyecto Ejecutivo",
    "ft_cu_mecsue" => "Mecánica de Suelos",
    "ft_cu_esth" => "Estudio Hidrológico",
    "ft_cu_estt" => "Estudio Topográfico",
    "ft_cu_estit" => "Estudio de Ingeniería de Tránsito",
    "ft_cu_terref" => "Términos de Referencia",
);
foreach ($objFT as $key => $value) {
    foreach ($value as $key2 => $data) {
        reset($data);
        while (list($clave, $valor) = each($data)) {
            if($valor==1){
                $varFT++;
                $fT .= $arrayFT["$clave"]. ", ";
            }
        }
    }
}
if($varFT > 0){
    $inicio_tabla_nomProyecto .= "<tr>
        <td class=\"celdaTablaFicha encabezado\" colspan=\"2\">FACTIBILIDAD T&Eacute;CNICA:</td>  
        <td class=\"celdaTablaFicha\" colspan=\"5\">";
    $fT = trim($fT, ", ");
    $inicio_tabla_nomProyecto .= $fT . "</td>";
    $inicio_tabla_nomProyecto .= "</tr>";
}
$inicio_tabla_nomProyecto .= "</table>";

$html = <<<EOD
$estilo_tabla
$inicio_tabla_nomProyecto
EOD;

$pdf->writeHTML($html, true, false, false, false, '');

$pdf->Ln(5);
    $row_responsable = "";
    $row_responsable .= "
                <tr nobr=\"true\">
                   <td></td>
                   <td align=\"center\"><FONT SIZE=\"9\">Nombre y Firma del Responsable</font></td>
                   <td></td>
                </tr>";
    
$responsable = <<<EOD
    <table border="0" class="general">
        <tr>        
            <th width="150"></th>
            <th width="325"><hr color="black" size=2></th>
            <th width="150"></th>
        </tr>
        $row_responsable
    </table>
        $estilo_tabla
EOD;

$pdf->writeHTML($responsable, true, false, false, false, '');

$pdf->Ln(3);

$row_datosRes = "";
    $row_datosRes .= "
                <tr>
                   <td align=\"right\" rowspan=\"2\"><FONT SIZE=\"8\"><br>Cargo del Responsable: </font></td>
                   <td class=\"celdaTablaFicha\" rowspan=\"2\"></td>
                </tr>
                <tr>
                   <td align=\"right\"><FONT SIZE=\"8\"></font></td>
                   <td class=\"celdaTablaFicha\"></td>
                </tr>
                <tr>
                   <td align=\"right\" rowspan=\"2\"><FONT SIZE=\"8\"><br>Tel&eacute;fono del Responsable: </font></td>
                   <td class=\"celdaTablaFicha\" rowspan=\"2\"></td>
                </tr>
                <tr>
                   <td align=\"right\"><FONT SIZE=\"8\"></font></td>
                   <td class=\"celdaTablaFicha\"></td>
                </tr>
                <tr>
                   <td align=\"right\" rowspan=\"2\"><FONT SIZE=\"8\"><br>Correo electr&oacute;nico del Responsable: </font></td>
                   <td class=\"celdaTablaFicha\" rowspan=\"2\"></td>
                </tr>
                <tr>
                   <td align=\"right\"><FONT SIZE=\"8\"></font></td>
                   <td class=\"celdaTablaFicha\"></td>
                </tr>";
    
$datosRes = <<<EOD
    <table class=\"tablaFicha\" cellpadding=\"5\">
        $row_datosRes
    </table>
        $estilo_tabla
EOD;

$pdf->writeHTML($datosRes, true, false, false, false, '');

$pdf->lastPage();
# visualizamos el documento
$pdf->Output('FichaIngresoBco'.$infoBcoPDF['IdBco'].'.pdf', 'I');




