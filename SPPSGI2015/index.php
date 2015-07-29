<?php


include ("inc/session.php");
include ("adodb/adodb.inc.php");
include ("inc/cnxbds.php");

date_default_timezone_set('America/Mexico_City');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Sistema de Planeaci&oacute;n y Presupuesto:: SPP2015</title>

<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/framecontent.css">
<!-- <link rel="stylesheet" type="text/css" href="css/mnuizq.css"> -->
<link rel="stylesheet" type="text/css" href="css/mnutbl.css">
<!-- <link rel="stylesheet" type="text/css" href="css/form1.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="css/minical.css"> -->
<link rel="stylesheet" type="text/css" href="css/contenidos.css">
<link rel="stylesheet" type="text/css" href="css/tabla1.css">

<script language="JavaScript" src="js/funmnu.js" type="text/JavaScript"></script>
<script language="JavaScript" src="js/funval.js" type="text/JavaScript"></script>
<script language="JavaScript" src="js/windows.js" type="text/JavaScript"></script>
<!--
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
-->
<script language="JavaScript" > 

  function cambia_contenido(x,y)
  {
  	document.location= "index.php?x="+x+"&y="+y+"&msg=0";					
  }
  	
  function Procesar(opc){
  	if(opc==1){      
  		guardar();
  	}else if(opc==2){
  		editar();
  	}else if(opc==3){
  		eliminar();
  	}else if(opc==4){
  		cerrar();
  	}else if(opc==5){
  		vista();
  	}else if(opc==6){
  		imprimir();
  	}else if(opc==7){
  		exportar();
  	}else if(opc==8){
  		ayuda();
  	}else if(opc==9){
  		norma();	
  	}else if(opc==10){
  		docentregar();
  	}		
  }	
</script>

</head>
<!--body onload="onLoad()"-->
<body >

<?php

include ("inc/avMsg.php");
//----------------------------despliega ventana de mensajes
$imsg=0;
if(isset($_REQUEST["msg"])) $imsg = $_REQUEST["msg"];
if ($imsg>0){ 
	print "<script>PopItMsg(".$imsg.",'".$msg[$imsg]."')</script>";	
}
$imsg = 0;

//------------------------------------------
$iX = $_REQUEST["x"];
$iY = $_REQUEST["y"];
//------------------------------------------

if(!isset($iX)) $iX=0;
if(!isset($iY)) $iY=0;        

// include ("inc/MiniCal.php");
include ("inc/avPgs.php");
include ("inc/avTitPgs.php");
       
$sPag = $avPag[$iX][$iY];   
		  
?>  

<style type="text/css">

.fondo-gray {
  -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
  -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
  box-shadow:inset 0px 1px 0px 0px #ffffff;
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9));
  background:-moz-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
  background:-webkit-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
  background:-o-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
  background:-ms-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
  background:linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9',GradientType=0);
  background-color:#f9f9f9;

  color:#666666;

  text-shadow:0px 1px 0px #ffffff;
}

.barra-menu {
  height:50px; 
  font-size:9px; 
  color:#666666;   
  padding: 4px 10px; 
  /*margin-left:10px;*/
}

/* color fondo banner principal*/
.barra-banner {
  background-color: #0a2e3a; /* #0a2e3a;*/
  color: #79B837;
}

.border-bottom-gray{
  border-bottom: 1px #C5CBC0 solid;
}

</style>

<?php
  
  $sis = $_SESSION['SIS'];

  $sTit_SIS = array(
                  'SPP'=>'Sistema de Planeaci&oacute;n y Presupuesto',
                  'SGI'=>'Sistema de Gasto de Inversi&oacute;n'
                  );
  
?>

<div id="framecontentTop" style=" overflow: hidden">
  <div class="innertube">     
            
        <div style=" height:46px; padding-left:30px;" class="barra-banner">
		      <img src="img/gem.png"  /> 
          <span style="margin-left:70px; font-size:18px; color:#BFCFCC;">:: <? echo $sTit_SIS[$sis] ?> ::</span>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <? echo $avMnuGE[$iX][0]." ::: [ ".$avMnuGE[$iX][$iY]." ] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " ?>
          <? echo  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  En sesion: [ ". $_SESSION["ORGDSC"] ." ] " ?>        

        </div>                        

    	<!-- <div >            -->
      		<div class="fondo-gray barra-menu border-bottom-gray">      
<!--       		  <span style="color:#135C4B; font-size: 14px;">Ejercicio Presupuestal 2015</span>
            <span style=" margin-left: 40px; "> -->
            <?              
              if($sis==1) include ('inc/MnuBtn.php') ;
              if($sis==2) include ('inc/Menu_Botones_acciones.php') ;
            ?>
            
          </span>
      		</div> 
    	<!-- </div>       -->
      <!-- <div style="height:1px; background-color: #C5CBC0">&nbsp;</div>          -->
         
  </div>    
</div>

<!-- Menu lateral izaquierdo -->
<div id="framecontentLeft">

  <div class="left_content">    	                               
    <?php
      include("inc/Menu_vertical_izquierdo.php"); 
    ?>  
  </div>  

</div>

<!-- content top -->

<div id="maincontent" >
    <div class="innertube">   
        <div class="subcontent" id="contenido">              			
            <? include ($sPag) ?>
        </div>
        <br />

      <br />
      <br />
      <div style="height:1px; width:820px;  background-color: #C5CBC0">&nbsp;</div>         
 	    
    
        <div style="width:820px;  background-color:#FFF; ">        
         <div class="ppag">                  
            <div class="cajapieizq Estiloppizq">
                <p>
                Secretar&iacute;a de Finanzas<br>
                Subsecretar&iacute;a de Planeaci&oacute;n y Presupuesto<br>                
<?php
                if($sis==1) echo "Direcci&oacute;n General de Planeaci&oacute;n y Gasto P&uacute;blico";
                if($sis==2) echo "Direcci&oacute;n General de Inversi&oacute;n";
                if($sis==3) echo "Direcci&oacute;n General de Inversi&oacute;n";
?>                
                </p>            
            </div>
            <div class="cajapieder Estiloppder">
                <p>AV. Del Colorin Número 101, Colonia Lomas Altas, <br>
                  Toluca. Estado de M&eacute;xico. CP 50060<br/>
                  Tel&eacute;fonos: 01 (722) 214 9469, 214 0133
                 
                </p>            
            </div>                          
       	</div>                             
      </div> 

   
      
  </div>
</div>

</body>
</html>
