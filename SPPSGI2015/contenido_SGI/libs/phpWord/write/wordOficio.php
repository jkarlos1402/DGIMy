<?php


$idOfi = $_POST['idOfiFon'];

include_once("../../../libs/adodb/adodb.inc.php");
require("../../../includes/conexion-config.php");

$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
               'Agosto','Septiembre','Octubre','Noviembre','Diciembre');

global $cnx;
$query = "  select * from pofifon
            inner join detofifon using (IdOfiFon)
            inner join detfonmet using(IdDetFon)
            inner join catejercicio using (Ejercicio)
            where IdOfiFon = '".$idOfi."' limit 1";
$rs = $cnx->Execute($query);

$numRows = $rs->_numOfRows;
    
$dataOfi = array();        

if($numRows>0){                       
    while (!$rs->EOF) {
        array_push($dataOfi, array_map('utf8_encode',$rs->fields));
        $rs->movenext();
    }        
    $dataOfi = end($dataOfi);
}


$query2 = "  select * from pofifon 
            inner join detofifon using (IdOfiFon) 
            inner join detfonmet using(IdDetFon) 
            inner join pfonmet using (IdFonMet)
            inner join catejercicio using (Ejercicio) where IdOfiFon = '".$idOfi."'";

$rs2 = $cnx->Execute($query2);

$numRows2 = $rs2->_numOfRows;
    
$dataOfi2 = array();        

if($numRows2>0){                       
    while (!$rs2->EOF) {
        array_push($dataOfi2, array_map('utf8_encode',$rs2->fields));
        $rs2->movenext();
    }            
}


$query3 = " select UPPER(NomSrv) NomSrv, UPPER(CarSrv) CarSrv from catsrvpub where CveSrv = 'dgi'";

$rs3 = $cnx->Execute($query3);

$numRows3 = $rs3->_numOfRows;
    
$dataOfi3 = array();        

if($numRows3>0){                       
    while (!$rs3->EOF) {
        array_push($dataOfi3, array_map('utf8_encode',$rs3->fields));
        $rs3->movenext();
    }            
    $dataOfi3 = end($dataOfi3);
}

/*
echo "<pre>";
    print_r($dataOfi);
echo "</pre>"; 
exit;
 * 
 */

include_once 'Sample_Header.php';

// New Word document
//echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultParagraphStyle(
    array(
        'align'      => 'both',
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
        'spacing'    => 15,
        'name' => 'Tahoma'
    )
);

// Sample
$section = $phpWord->addSection(array('breakType' => 'continuous'));

$section->addText(
    htmlspecialchars(
        $dataOfi['Frase']
    ),    
    array('bold' => false),
    array('space' => array('before' => 600, 'after' => 250),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        'OFICIO NO. 203230000/'.$dataOfi['CveOfi']
    ),    
    array('bold' => true),
    array('space' => array('before' => 100, 'after' => 150),'align' => 'right')
);

$fecha = explode('-',$dataOfi['FecOfi']);
$dia= $fecha[2]." de ".$meses[((int)$fecha[1])]." de ".$fecha[0];
//acentos
$section->addText(
    htmlspecialchars(
        utf8_encode('Toluca, México a '.$dia)
    ),        
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 250),'align' => 'right')
);
//Acentos
$tit = nl2br(($dataOfi['TitOfi']));

$titular = explode("<br />", $tit);


foreach($titular as $tit){
    
    $section = $phpWord->addSection(
        array(
            'colsNum'   => 2,
            'colsSpace' => 100,
            'breakType' => 'continuous',
        )
    );
    
    $section->addText(
        htmlspecialchars(
            trim($tit)
        ),    
        array('name' => 'Tahoma','bold' => false),
        array('space' => array('before' => 50, 'after' => 50), 'align' => 'left')        
    );
}

$section = $phpWord->addSection(array('breakType' => 'continuous'));

$section->addText(
    htmlspecialchars(
        'PRESENTE'
    ),    
    array('name' => 'Tahoma', 'bold' => false),
    array('space' => array('before' => 50, 'after' => 50), 'align' => 'left')
);


$section->addText(
    htmlspecialchars(
        $dataOfi['Txt2Ofi']
    ),    
    array('bold' => false),
    array('space' => array('before' => 450, 'after' => 350),'align' => 'left')
);


//Tabla de proyectos

$styleTable = array('borderSize' => 10, 'borderColor' => 'DDDDDD', 'cellMargin' => 5);
$styleFirstRow = array('borderBottomSize' => 1, 'borderBottomColor' => '0000FF', 'bgColor' => 'DDDDDD');
$styleCell = array('valign' => 'center');
$styleCell1 = array('gridSpan' => 2, 'valign' => 'center');
$fontStyle = array('bold' => true, 'align' => 'center');
$phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
$table = $section->addTable('Fancy Table');
$table->addRow(300);
$table->addCell(8000, $styleCell1)->addText(htmlspecialchars('Proyecto'), $fontStyle);
$table->addCell(2000, $styleCell)->addText(htmlspecialchars('Monto'), $fontStyle);
$tot = 0;
foreach($dataOfi2 as $dato){
    $tot += $dato['Monto'];
    $table->addRow();
    $table->addCell(2000)->addText(htmlspecialchars($dato['CvePry']));
    $table->addCell(6000)->addText(htmlspecialchars($dato['NomPry']));
    $table->addCell(2000)->addText(htmlspecialchars(number_format($dato['Monto'],2,'.',',')), array('bold'=>false),array('align'=>'right'));
}

$table->addRow();
$table->addCell(8000, $styleCell1)->addText(htmlspecialchars('TOTAL:'), array('bold'=>true),array('align'=>'right'));
$table->addCell(2000, $styleCell)->addText(htmlspecialchars(number_format($tot,2,'.',',')), array('bold'=>true),array('align'=>'right'));



$section->addText(
    htmlspecialchars(
        ''
    ),    
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 150),'align' => 'left')
);
//acentos
$text = nl2br(($dataOfi['Txt1Ofi']));
$textos = explode("<br />", $text);

foreach($textos as $texto){
    $section->addText(
        htmlspecialchars(
            trim($texto)
        ),    
        array('bold' => false),
        array('space' => array('before' => 110, 'after' => 110),'align' => 'left')
    );
}


$section->addText(
    htmlspecialchars(
        'A T E N T A M E N T E'
    ),    
    array('bold' => false),
    array('space' => array('before' => 500, 'after' => 500),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        $dataOfi3['NomSrv']
    ),    
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 100),'align' => 'center')
);

$section->addText(
    htmlspecialchars(
        $dataOfi3['CarSrv']
    ),    
    array('bold' => false),
    array('space' => array('before' => 100, 'after' => 500),'align' => 'center')
);


$section->addText(
    htmlspecialchars(            
        ''
    ),    
    array('size'=>8, 'bold' => false),
    array('space' => array('before' => 500, 'after' => 500),'align' => 'left')
);

//acentos
$textCcp = nl2br(($dataOfi['CcpOfi']));
$textosCcp = explode("<br />", $textCcp);

foreach($textosCcp as $ccp){
    $section->addText(
        htmlspecialchars(            
            $ccp
        ),    
        array('size'=>7, 'bold' => false),
        array('space' => array('before' => 80, 'after' => 80),'align' => 'left')
    );
}


// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
