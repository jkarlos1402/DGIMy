<?
	$iX = $_REQUEST["x"];
	$iY = $_REQUEST["y"];
	
	$avBtn = array();
	$sSql = " select '0',upd,del,blq,vst,imp,env from relusuprm where idusu = ".$_SESSION["USERID"]." and xi = ".$iX." and yi = ".$iY;	
	$rs = $cnn->Execute($sSql);

	if ($rs){
		while ($arr = $rs->FetchRow()) {	      
			$avBtn = $arr;
		}	
	}	
	$avBtn = array(1,1,1,1,1,1,1,1);
?>


<img src="img/sep_vrt.png"  height="32" width="3" border="0" />
<span>&nbsp;&nbsp;</span>

<? if($avBtn[1]){ ?><span><a href="javascript:Procesar(1)"><img src="img/Guardar.png"  height="32" border="0" title="Guardar"/></a>Guardar</span><? } ?> 
<span>&nbsp;</span>
<? if($avBtn[2]){ ?><span><a href="javascript:Procesar(3)"><img src="img/Eliminar.png" width="32" height="32" border="0" title="Eliminar"/></a>Eliminar</span><? } ?>
<span>&nbsp;</span>
<img src="img/sep_vrt.png"  height="32" width="3" border="0" />
<? if($avBtn[4]){ ?><span><a href="javascript:Procesar(5)"><img src="img/Find.png" width="31" height="32" border="0" title="Buscar"/></a>Buscar</span><? } ?>
<span>&nbsp;</span>
<img src="img/sep_vrt.png"  height="32" width="3" border="0" />
<? if($avBtn[5]){ ?><span><a href="javascript:Procesar(6)"><img src="img/Print.png" height="32" border="0" title="Imprimir"/></a>Imprimir</span><? } ?> 
<span>&nbsp;</span>
<? if($avBtn[6]){ ?><span><a href="javascript:Procesar(7)"><img src="img/xls.png" width="32" height="32" border="0" title="Exportar"/></a>Exportar</span><? } ?>
<span>&nbsp;</span>
<img src="img/sep_vrt.png"  height="32" width="3" border="0" />
<? if($avBtn[3]){ ?><span><a href="javascript:Procesar(4)"><img src="img/Candado.png" height="32" border="0" title="Cerrar captura"/></a>Cerrar</span><? } ?> 
<img src="img/sep_vrt.png"  height="32" width="3" border="0" />
<span>&nbsp;&nbsp;</span>
<!--
<span><a href="javascript:Procesar(8)"><img src="../img/Help.png" width="31" height="32" border="0" /></a>Ayuda</span> 
<span>&nbsp;&nbsp;</span>
<span><a href="javascript:Procesar(9)"><img src="../img/ico_buho.png" width="31" height="32" border="0" /></a>Normatividad</span> 
<span>&nbsp;&nbsp;</span>
<span><a href="javascript:Procesar(10)"><img src="../img/ico_entrega.png" width="31" height="32" border="0" /></a>Doc. a Entregar</span> 
-->
