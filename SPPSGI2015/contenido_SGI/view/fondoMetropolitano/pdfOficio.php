<?php  
session_start();

$idOfi = $_POST['idOfiFon'];

include_once("../../libs/adodb/adodb.inc.php");
require("../../includes/conexion-config.php");

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
    
    */
$fecha = explode('-',$dataOfi['FecOfi']);
$dia= $fecha[2]." de ".$meses[((int)$fecha[1])]." de ".$fecha[0];

    $contenido1 = '<table>                    
                    <tr>                        
                        <td align="center">'.$dataOfi['Frase'].'
                        </td>
                    </tr>   
                    <tr><td></td></tr>                    
                  </table>                  
                  <table align="right">
                    <tr>
                        <td></td>
                        <td>OFICIO NO. 203230000/'.$dataOfi['CveOfi'].'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Toluca, M&eacute;xico a '.$dia.'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>                                                                             
                </table>
                <table>
                    <tr><td></td></tr>                    
                    <tr>
                        <td>'.nl2br($dataOfi['TitOfi']).'</td>
                    </tr>
                    <tr>
                        <td><b>P R E S E N T E</b></td>
                    </tr>                    
                    <tr><td></td></tr>                    
                    <tr>
                        <td><span style="text-align:justify; ">'.nl2br($dataOfi['Txt2Ofi']).'</span></td>
                    </tr>
                    <tr>
                        <td>
                            <table style=\"font-size: 12px\">
                                <tr bgcolor="#DDDDDD">
                                    <td width="100px"></td>
                                    <td width="270px"><b>Proyecto</b></td>
                                    <td width="100px" align="center"><b>Monto</b></td>                                    
                                </tr>';
                        foreach($dataOfi2 as $dato){
                            $tot += $dato['Monto'];
                            $contenido1 .= "<tr>";
                            $contenido1 .= "    <td>".$dato['CvePry']."</td>";
                            $contenido1 .= "    <td>".$dato['NomPry']."</td>";
                            $contenido1 .= "    <td style=\"text-align:right;\">".number_format($dato['Monto'],2,'.',',')."</td>";                            
                            $contenido1 .= "</tr>";                            
                        }
    $contenido1 .='             <tr bgcolor="#F2F2F2">'
            . '                     <td></td>'
            . '                     <td align="right">TOTAL:</td>'
            . '                     <td align="right"><b>'.number_format($tot,2,'.',',').'</b></td>'
            . '                 </tr>';                        

    $contenido1 .='         </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span style="text-align:justify; ">'.nl2br($dataOfi['Txt1Ofi']).'</span></td>
                    </tr>

                </table>
                <table align="center">
                    <tr><td></td></tr>
                    <tr><td></td></tr>                    
                    <tr><td>A T E N T A M E N T E</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>                    
                    <tr><td style=\"text-align: center\">'.($dataOfi3['NomSrv']).'</td></tr>                                        
                    <tr><td style=\"text-align: center\">'.($dataOfi3['CarSrv']).'</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>         
                    <tr><td></td></tr>
                    <tr><td></td></tr> 
                    
                </table>
                <table style="font-size: 9px; bottom:0">
                    <tr><td></td><td></td></tr>                                                                                
                    <tr><td width="40px">C.C.P.</td><td width="500px">'. nl2br(trim(trim($dataOfi['CcpOfi'], 'C.C.P.'))).'</td></tr>                       
                </table>';
        
                
       
    include "../../libs/tcpdf/tcpdf.php"; 


    class MYPDF extends TCPDF {

       public function Footer() {

           $this->SetY(-15);

           $this->SetFont('helvetica', 'I', 8);
           
       }
       
       public function Header() {
           
       }
    }   
    
    
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(20, 30, 20, true);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->AddPage();
    $pdf->writeHTML($contenido1, true, false, false, false, '');
    
    ob_end_clean();
    $pdf->Output('Oficio.pdf', 'I');
    


?>

