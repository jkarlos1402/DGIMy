<?php
	
    // zona horaria	
    date_default_timezone_set('America/Mexico_City');

    //Incluimos la librería de conexion
    include ("../../libs/adodb/adodb.inc.php");
    require_once ("../../includes/conexion-config.php");
	
    $cnx = ADONewConnection('mysqli'); 	
    $cnx->connect($db_host, $db_username, $db_password, $db_database); 	

    $idSol = $_POST['idSol'];
    $idBco = $_POST['idBco'];
				
    $qryEva = "select MAX(IdEva) as IdEva from estsol where idSol = '".$idSol."'";
    $infoEva = end($cnx->GetAll($qryEva));	
    $idEva = $infoEva['IdEva'];

	//-------------------------------------------------------	

    $sSql = "SELECT FecReg, NomObr, PriCar, NumDictamen, 
            psolicitud.Monto AS Monto, MonMun, FteMun,
            NomUE, NomSec, obs, IdTipEva, psolicitud.idSec AS IdSec
            FROM psolicitud 
            LEFT JOIN relsolbco USING(idSol) 
            LEFT JOIN catsector USING(idSec) 
            LEFT JOIN catue USING(idUE) 
            LEFT JOIN estsol USING(idSol)
            WHERE idSol =".$idSol;

    $cnx->SetFetchMode(ADODB_FETCH_ASSOC);

    $avData = array_shift( $cnx->GetAll($sSql));
    
    $query = "SELECT observa, nomrsp, nompto, catinciso.etiqueta as etinc, nominc, imprime, catsubinc.etiqueta as etsub, nomsub
                FROM deteva, catpunto, catinciso, catsubinc, catrespuesta
                WHERE deteva.ideva = ".$idEva."
                AND catsubinc.idsubinc = deteva.idsubinc
                AND catinciso.idinc = catsubinc.idinc
                AND catpunto.idpto = catinciso.idpto
                AND deteva.idrsp = catrespuesta.idrsp
                AND catsubinc.idsubinc NOT IN (36, 37, 38, 39, 40, 41, 42)
                ORDER BY catpunto.numcon, catinciso.numcon";

    $avData2 = $cnx->GetAll($query);
    
    
    $queryPPI = "SELECT catppi.NomPPI AS NomPPI FROM catppi, estsol 
                WHERE catppi.IdPPI = estsol.IdTipInf 
                AND estsol.idSol =".$idSol;
    
    $rPPI = array_shift( $cnx->GetAll($queryPPI));
	
	$qrySol = "select FecReg, NomObr, PriCar, NumDictamen from psolicitud inner join relsolbco using(idSol) where idSol = '".$idSol."'";
	$infoSol = end($cnx->GetAll($qrySol));	
        
        $qryBcoPry = "select * FROM bcopry where IdBco = '".$idBco."'";
	$infoBco = end($cnx->GetAll($qryBcoPry));	
	
	$qryInd = "select * from estsol where idSol = '".$idSol."' and IdEVa = '".$idEva."' order by idEst Desc ";
	$infoInd = end($cnx->GetAll($qryInd));	
        
        $qresp = "SELECT CONCAT(TitRes, ' ', NomRes, ' ', ApeRes) AS Responsable, CarRes 
                    FROM carea
                    LEFT JOIN catresarea USING(idres)
                    LEFT JOIN cdepto USING(iddir)
                    LEFT JOIN catsector USING(idDpt)
                    WHERE idsec = ".$avData['IdSec'];
        $infoRes = end($cnx->GetAll($qresp));
        
        $qFtes = "SELECT DscFte, relsolfte.monto AS monto, 
                    CASE relsolfte.tipoFte
                    WHEN 1 THEN 'Federal'
                    WHEN 2 THEN 'Estatal'
                    END AS tipoFte 
                    FROM relsolfte
                    LEFT JOIN catfte2015 USING(idFte)
                    WHERE idSol =".$idSol;
        
        $rFtes = $cnx->GetAll($qFtes);
		
    if( $idSol ){
        //-------------------------------------------------------
        switch ($avData['IdTipEva']) {
            case 1:
                $sTituloReporte = "DICTAMEN DE FICHA TÉCNICA";
                break;
            case 2:
                $sTituloReporte = "DICTAMEN DE ESTUDIO DE PRE-INVERSIÓN";
                break;
            case 3:
                $sTituloReporte = "DICTAMEN DE COSTO-BENEFICIO SIMPLIFICADO (NIVEL DE PERFIL)";
                break;
            case 4:
                $sTituloReporte = "DICTAMEN DE COSTO-BENEFICIO (NIVEL DE PREFACTIBILIDAD)";
                break;
            case 5:
                $sTituloReporte = "DICTAMEN DE COSTO-EFICIENCIA SIMPLIFICADO (NIVEL DE PERFIL)";
                break;
            case 6:
                $sTituloReporte = "DICTAMEN DE COSTO-EFICIENCIA (NIVEL DE PREFACTIBILIDAD)";
                break;
            default:
                break;
        }

        //------------------------------------------------------------
        // Incluir libreria TCPDF
        require_once('../../libs/tcpdf/tcpdf.php');

        //--------------------------Encabezado de Pagina-----------------------------------------
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
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => true,
			'font' => 'Helvetica',
			'fontsize' => 6,
			'stretchtext' => 4
		);

		$styleBC = array(
			'position'=>'R', 
			'border'=>1, 
			'padding'=>2, 
			'fgcolor'=>array(0,0,0), 
			'bgcolor'=>array(255,255,255), 
			'text'=>true, 
			'font'=>'helvetica', 
			'fontsize'=>8, 
			'stretchtext'=>4
		);

		$estilo_tabla = "
		<style>
			table.general {
				color: #000;
				font-family: times;
				font-size: 8pt;
				border: 1px solid rgb(200,200,200);
				background-color: #FFF;               
			}    
			td {        
				background-color: #FFF;                
			}
			td.contenido {
				border: 1px solid rgb(200);
			}    
			th {
				background-color: rgb(230);
				border: 1px solid rgb(170);      
			}
			.divi {
			  background-color: #b0e0e6;   
			  position: absolute;   
			margin-left: auto;
			margin-right: auto;      
			   margin-left: 10px;
			}
		  .center{ text-align: center; }
		  .right { text-align: right; }
		  .fila_0 { background-color: #FFF;}
		  .fila_1 { background-color: rgb(240); }
		</style>
		";
                
                $mi_estilo_tabla = "
		<style>  
                    th.verde {
                        background-color: #7DAB49;     
                    }
                    th.concepto {
                        background-color: #BBBFBC;     
                    }
                    td.concepto {
                        background-color: #BBBFBC; 
                    }
                    td.cuadro {
                        background-color: #FFFFFF;
                        border: 1px solid #000000;      
                    }
                    td.renglon {
                        background-color: #E1E0E0;
                    }
		</style>
		";

		//--------------------Contenido del reporte >---------------------------------------------------

		$pdf->SetFont('times', 'L', 6);
		$pdf->Cell(0, 0, 'NÚMERO DE PROYECTO',0,1,'R', 0, 1);

		$pdf->write1DBarcode($idBco, 'C39', '', '', '', 12, 0.4, $style, 'N');
		$pdf->Ln();

		$pdf->SetFont('times', '', 9);
		$pdf->Cell(0, 0, strtoupper( $sTituloReporte ),0,1,'C', 0, 1);
		$pdf->Ln(2);

                $pdf->SetFont('times', '', 7);
		$pdf->Cell(160, 0, 'Número de dictamen:',0,0,'R', 0, 0);
		$pdf->Cell(0, 0, substr($infoSol['NumDictamen'],0,10),1,1,'R', 0, 0);
		$pdf->Ln(1);
                
		$pdf->SetFont('times', '', 7);
		$pdf->Cell(160, 0, 'Fecha de ecaluación:',0,0,'R', 0, 0);
		$pdf->Cell(0, 0, substr($infoSol['FecReg'],0,10),1,1,'R', 0, 0);
		$pdf->Ln(1);
             
                $inicio_tabla_nomProyecto = "";
                $inicio_tabla_nomProyecto .= "<tr>
                            <th width=\"155\">Nombre de la obra:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($avData['NomObr'])."</td>
                        </tr>  
			<tr>        
                            <th width=\"155\">Descripción del proyecto:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($avData['PriCar'])."</td>
			</tr>
                        <tr>       
                            <th width=\"155\">Monto total de inversión:</th>
                            <td width=\"485\" class=\"contenido\">$".number_format($avData['Monto'],2)."</td>
			</tr>
                        <tr>        
                            <th width=\"155\">Sector:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($avData['NomSec'])."</td>
			</tr>
                        <tr>        
                            <th width=\"155\">Tipo de PPI:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($rPPI['NomPPI'])."</td>
			</tr>";
                
                foreach ($rFtes as $key => $valoresFtes) {  
                    $inicio_tabla_nomProyecto .= "
                        <tr nobr=\"true\">
                           <th width=\"155\">Fuente de financiamiento ".$valoresFtes['tipoFte'].":</th>
                           <td width=\"485\" class=\"contenido\">$".number_format($valoresFtes['monto'],2)." ".utf8_encode($valoresFtes['DscFte'])."</td>
                        </tr>";
                }
                        
                if($avData['MonMun'] !== "" && $avData['MonMun'] !== "0.00"){
                    $inicio_tabla_nomProyecto .= "
                        <tr nobr=\"true\">
                           <th width=\"155\">Fuente de financiamiento Municipal:</th>
                           <td width=\"485\" class=\"contenido\">$".number_format($avData['MonMun'],2)." ".utf8_encode($avData['FteMun'])."</td>
                        </tr>";
                }

                $inicio_tabla_nomProyecto .= "<tr>        
                            <th width=\"155\">Unidad Responsable:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($avData['NomUE'])."</td>
			</tr>
                        <tr>        
                            <th width=\"155\">Observaciones generales:</th>
                            <td width=\"485\" class=\"contenido\">".utf8_encode($infoInd['obs'])."</td>
			</tr>";

		$tabla_nomProyecto = "
		<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" class=\"general\" >
                        $inicio_tabla_nomProyecto
		</table>
		";

$html = <<<EOD
$estilo_tabla
$tabla_nomProyecto
EOD;

		$pdf->writeHTML($html, true, false, false, false, '');


		$pdf->SetFont('times', '', 9);
		$pdf->Cell(0, 0, strtoupper('Resultado del dictamen'),0,1,'C', 0, 1);
		$pdf->Ln(2);

//----tabla detalle
$row_Conceptos = "";
$i=0;

$punto = "";
$inciso = "";

foreach ($avData2 as $key => $value) {  
    $auxpto = utf8_encode($value['nompto']);
    $auxinc = utf8_encode($value['etinc']);

    if($punto == "" || $punto != $auxpto){
         $row_Conceptos .= "
            <tr nobr=\"true\">
               <th colspan=\"3\" align=\"center\" class=\"verde\"><FONT SIZE=\"8\">". utf8_encode($value['nompto']) ."</font></th>
            </tr>";
    }
    
    if(($inciso == "" || $inciso != $auxinc) && $value['imprime'] == 1){
        if($value['etinc'] != ""){
            $impinc = $value['etinc'].' '.utf8_encode($value['nominc']);
        }else{
            $impinc = utf8_encode($value['nominc']);
        }

        $bandColor = false;
        
         $row_Conceptos .= "
            <tr nobr=\"true\">
               <th align=\"left\" class=\"concepto\"><FONT SIZE=\"7\">". $impinc ."</font></th>
               <td class=\"concepto\"></td>
               <td class=\"concepto\"></td>
            </tr>";
    }

    if($value['etsub'] != ""){
            $impsub = ' '.$value['etsub'].' '.utf8_encode($value['nomsub']);
        }else{
            $impsub = utf8_encode($value['nomsub']);
        }

        if($bandColor){
            $var = " renglon";
        }else{
            $var = "";
        }
        
    $row_Conceptos .= "
            <tr nobr=\"true\">
               <td class=\"".$var."\"><FONT SIZE=\"7\">". $impsub ."</font></td>
               <td align=\"center\" class=\"cuadro".$var."\"><FONT SIZE=\"7\">".$value['nomrsp']."</font></td>
               <td class=\"".$var."\"></td>
            </tr>"; 

    $punto = utf8_encode($value['nompto']);
    $inciso = utf8_encode($value['etinc']);
    
    $bandColor = !$bandColor;
}

$tabla_conceptos = <<<EOD
<table border="0" class="general">
    <tr>        
        <th width="570" align="left" ba class="concepto"><FONT SIZE="8">&nbsp;&nbsp;&nbsp;CONCEPTO</font></th>
        <th width="40" class="concepto"></th>
        <th width="30" class="concepto"></th>
    </tr>
   $row_Conceptos
     
</table>
        $mi_estilo_tabla
EOD;

$pdf->writeHTML($tabla_conceptos, true, false, false, false, '');
//------tabla detalle

$row_indicadores = "";

if($avData['IdTipEva'] !== "2"){
    if (($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000") && $avData['IdTipEva'] === "1" && $avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4" || $avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){  
        $row_indicadores .= "
            <tr nobr=\"true\">
               <th colspan=\"3\" align=\"center\" class=\"verde\"><FONT SIZE=\"8\">INDICADORES DE RENTABILIDAD</font></th>
            </tr>";
    }elseif ($avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4" || $avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6") {
        $row_indicadores .= "
            <tr nobr=\"true\">
               <th colspan=\"3\" align=\"center\" class=\"verde\"><FONT SIZE=\"8\">INDICADORES DE RENTABILIDAD</font></th>
            </tr>";
    }
    
    if($avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4" || $avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <th colspan=\"3\" align=\"left\" class=\"concepto\"><FONT SIZE=\"8\">Indicadores de rentabilidad</font></th>
                </tr>";
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;Tasa social de descuento:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">".$infoInd['TasDes']." %</font></td>
                   <td></td>
                </tr>";
    }
    
    if($infoInd['VAN'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAN:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VAN'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if($avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAN o VPN:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VAN'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if(($infoInd['TIR'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")) || $avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;TIR:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">".$infoInd['TIR']." %</font></td>
                   <td></td>
                </tr>";
    }
    
    if(($infoInd['TRI'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")) || $avData['IdTipEva'] === "3" || $avData['IdTipEva'] === "4"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;TRI:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">".$infoInd['TRI']." %</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if($infoInd['VACPta'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAC Propuesta:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VACPta'],2)."</font></td>
                   <td></td>
                </tr>";
    }
    
    if($avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <th colspan=\"3\" align=\"left\" class=\"concepto\"><FONT SIZE=\"8\">Proyecto propuesto</font></th>
                </tr>";
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAC o VPC:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VACPta'],2)."</font></td>
                   <td></td>
                </tr>";
    }
    
    if($infoInd['CAEPta'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;CAE Propuesta:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['CAEPta'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if($avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;CAE:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['CAEPta'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if($infoInd['VACAlt'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAC Alternativa:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VACAlt'],2)."</font></td>
                   <td></td>
                </tr>";
    }
    
    if($avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <th colspan=\"3\" align=\"left\" class=\"concepto\"><FONT SIZE=\"8\">Alternativa</font></th>
                </tr>";
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;VAC o VPC:</font></td>
                   <td align=\"center\"><FONT SIZE=\"7\">$ ".number_format($infoInd['VACAlt'],2)."</font></td>
                   <td></td>
                </tr>";
    }
    
    if($infoInd['CAEAlt'] !== "" && $avData['IdTipEva'] === "1" && ($avData['Monto'] > "30000000" && $avData['Monto'] < "50000000")){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;CAE Alternativa:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['CAEAlt'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }
    
    if($avData['IdTipEva'] === "5" || $avData['IdTipEva'] === "6"){
        $row_indicadores .= "
                <tr nobr=\"true\">
                   <td class=\"renglon\"><FONT SIZE=\"7\">&nbsp;&nbsp;&nbsp;CAE:</font></td>
                   <td align=\"center\" class=\"renglon\"><FONT SIZE=\"7\">$ ".number_format($infoInd['CAEAlt'],2)."</font></td>
                   <td class=\"renglon\"></td>
                </tr>";
    }

$tabla_indicadores = <<<EOD
<table>
    <tr>        
        <th width="560"></th>
        <th width="60"></th>
        <th width="20"></th>
    </tr>
   $row_indicadores
</table>
    $mi_estilo_tabla
EOD;

$pdf->writeHTML($tabla_indicadores, true, false, false, false, '');
}

    $pdf->Ln(20);
    $row_responsable = "";
    $row_responsable .= "
                <tr nobr=\"true\">
                   <td></td>
                   <td align=\"center\"><FONT SIZE=\"9\">".utf8_encode($infoRes['Responsable'])."</font></td>
                   <td></td>
                </tr>";
    $row_responsable .= "
                <tr nobr=\"true\">
                   <td></td>
                   <td align=\"center\"><FONT SIZE=\"9\">".utf8_encode($infoRes['CarRes'])."</font></td>
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
EOD;

$pdf->writeHTML($responsable, true, false, false, false, '');
  
// ---------------------------------------------------------------

} else{  
  $pdf->writeHTML('No existe información', true, false, false, false, '');
}
//--------------------Contenido del reporte <---------------------------------------------------

$pdf->lastPage();

# visualizamos el documento
$pdf->Output('Dictamen.pdf','I');
?>
