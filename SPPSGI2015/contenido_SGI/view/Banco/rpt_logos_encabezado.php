<?php

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = '../img/gem_hztl.jpg';
        $this->Image($image_file, 10, 5, 50, '', 'JPG', '', 'L', false, 300, '', false, false, 0, false, false, false);
        
        $this->SetFont('times', 'L', 7);
        $this->Cell(50,13,'',0);
        $this->Cell(130,13, "Secretaría de Finanzas",0,0,'L');
        $this->Ln(3);
        $this->Cell(50,13,'',0);
        $this->Cell(130,13, "Subsecretaría de Planeación y Presupuesto",0,0,'L');
        $this->Ln(3);
        $this->Cell(50,13,'',0);
        $this->Cell(130,13, "Dirección General de Inversión",0,0,'L');
        
        $image_file = '../img/logo_GEM_hztl.jpg';
        $this->Image($image_file, 160, 5, 40, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->Ln(20);
            
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
		$this->SetFont('times', 'L', 7);

        $estilo1=array('width' =>0.2,'cap' => 'butt', 'join' => 'miter', 'solid' =>'10,10', 'color' => array(220,220,220,0)); 
//        $this->Line(12,280,195,280,$estilo1); 

		// $this->SetLineWidth(0.5);
		// $this->Line(12,280,195,280);
		// $this->Ln(0.5);

		
//		$this->Cell(90,0,utf8_encode("Secretar�a de Finanzas"),0,0,'R'); 
//		$this->Cell(5,0,'',0); 
//		$this->Cell(90,0,utf8_encode("Calle Color�n No. 101"),0,1); 

//		$this->Cell(90,0,utf8_encode("SubSecretar�a de Planeaci�n y Presupuesto"),0,0,'R'); 
//		$this->Cell(5,0,'',0); 
//		$this->Cell(90,0,'Colonia Lomas Altas',0,1); 
        
        $this->Cell(0,0, "Calle Colorín 101 Col. Lomas Altas, Toluca, Estado de México, C.P. 50060",0,0,'C'); 

		
//        $this->SetFont('Helvetica', 'I', 7);
        // Page number
//        $this->Cell(0, 10, utf8_encode('P�gina ').$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

?>