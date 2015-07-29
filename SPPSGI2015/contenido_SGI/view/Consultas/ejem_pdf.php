<?php
date_default_timezone_set('America/Mexico_City');

//--
	//Incluimos la librería
	include('../../libs/adodb/adodb.inc.php'); 
	// Creamos una conexión con el Driver MySQLi
	$cnx = ADONewConnection('mysqli'); 
	//Nos conectamos a la base dedatos
	$cnx->connect('localhost', 'usgi2015', 'cnx5gi2015', 'sgi2015'); 
	//$cnx->connect('192.168.20.5', 'usgi2015', 'cnx5gi2015', 'sgi2015'); 

	$sSql = " SELECT * FROM catestprg2015 ";
	$rs = $cnx->Execute($sSql); 
	//Si ha habido algun error
	if(!$rs) 
	{
	  //Mostramos el mensaje de error
	  echo $cnx->ErrorMsg(); 
	}
	else
	{
		$avPrg = array();
	  //Mientras no estemos al final de RecordSet
	  
	  while(!$rs->EOF) 
	  {
	 	//Imprimimos los datos
	 	$avPrg[] =  $rs->fields;
	    /*
	    $avPrg[$i][0] =  $rs->fields[0];
	    $avPrg[$i][1] =  $rs->fields[1];
	    $avPrg[$i][2] =  $rs->fields[2];
	    $avPrg[$i][3] =  $rs->fields[3];
	   */
		//Nos movemos al siguiente registro
	    $rs->MoveNext(); 
	  }
	  //Cerramos el RecordSet, esto es opcional
	  $rs->Close(); 
	}
	//Cerramos la conexión. Opcional.
	//$cnx->Close();



// incluir libreria
require_once('../../libs/tcpdf/tcpdf.php');


// encabezado
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'gem_hztl.jpg';
        $this->Image($image_file, 15, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Inversión ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// crear nuevo documento pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// establecer información
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('autor');
$pdf->SetTitle('ejemplo');
$pdf->SetSubject('consulta');
$pdf->SetKeywords('sgi,inversioón,solicitud');

// establecer encabezado
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// establecer encabezado y pie de pagina
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// fijar default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// establecer margen
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// fijar auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// fijar image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// establecer lenguajes
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
    require_once(dirname(__FILE__).'/lang/spa.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// establecer el font
$pdf->SetFont('helvetica', 'B', 20);
// agregar una página
$pdf->AddPage();

$pdf->Write(0, 'Catálogo', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 8);

//---------------------------------


$tbl = <<<EOD
<table border="1"  cellpadding="0" cellspacing="1" align="center" fontsize="14">
<tr>
<td></td><td><br /><br /><br /><br /></td>
</tr>
<tr>
<th colspan="2"><h1>Estructura Programática</h1></th>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, ''); 

$pdf->Ln();
$pdf->SetLineStyle(array('width' => 0.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
$pdf->SetFillColor(255,255,128);
$pdf->SetTextColor(0,0,128);

$pdf->Ln();


$tbl = <<<EOD
<table border="1"  cellpadding="1" cellspacing="1" align="center" fontsize="12">
<tr>
<th colspan="1">ID</th>
<th colspan="1">CLAVE</th>
<th colspan="1">DESCRIPCIÓN</th>
<th colspan="1">TIPO</th>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Ln();

//<td>{$value['id']}</td> 


$tbl = '<table border="1"  cellpadding="0" cellspacing="3" align="center" fontsize="10">';
foreach ($avPrg as $key => $value) {

		$tbl .="<tr>
		<td>{$value[0]}</td> 
		<td>{$value[1]}</td>
		<td>{$value[2]}</td> 
		<td>{$value[3]}</td>
		</tr>";
 }

$tbl = '</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

/*
echo '<pre>';
print_r($value);
echo '<pre>';
*/

//---------------------------------
//Close and output PDF document
$pdf->Output('ejempl0.pdf', 'I');

?>