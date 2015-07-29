<?
	$avXY = array();
	$sSql = " Select Yi,X1,X2,X3,X4,X5,X6,X7,X8,X9 from relusuacc where idUsu = ".$_SESSION["USERID"];
    echo $sSql;
//	$sSql = " Select Yi,0 X1,0 X2,0 X3,0 X4,0 X5,0 X6,0 X7,0 X8,0 X9 from relusuacc where idUsu = ".$_SESSION["USERID"];
    
	$rs = &$cnn->Execute($sSql);
	while(!$rs->EOF){
		$y = $rs->fields["Yi"];
		$avXY[1][$y] = $rs->fields["X1"];
		$avXY[2][$y] = $rs->fields["X2"];
		$avXY[3][$y] = $rs->fields["X3"];
		$avXY[4][$y] = $rs->fields["X4"];
		$avXY[5][$y] = $rs->fields["X5"];
		$avXY[6][$y] = $rs->fields["X6"];
		$avXY[7][$y] = $rs->fields["X7"];
		$avXY[8][$y] = $rs->fields["X8"];
		$avXY[9][$y] = $rs->fields["X9"];	
		$rs->movenext();
	} 
	
?>
<dl id="menu">	
        <dt onclick="javascript:montre('smenu1');"><a><? print $avMnuGE[1][0] ?></a></dt>
            <dd id="smenu1">
                <ul>                        	
                    <? if($avXY[1][1]){?><li><a href="javascript:cambia_contenido(1,1)"><? print $avMnuGE[1][1] ?></a></li><? } ?>
                </ul>
                <ul> 
                    <div style="color:#669999; margin-left:15px;"> PLANEACI&Oacute;N  </div> <li>&nbsp;</li>
                    <? if($avXY[1][2]){?><li><a href="javascript:cambia_contenido(1,2)"><? print $avMnuGE[1][2] ?></a></li><? } ?>
                    <? if($avXY[1][3]){?><li><a href="javascript:cambia_contenido(1,3)"><? print $avMnuGE[1][3] ?></a></li><? } ?>
                    <? if($avXY[1][4]){?><li><a href="javascript:cambia_contenido(1,4)"><? print $avMnuGE[1][4] ?></a></li><? } ?>		    		
                    <? if($avXY[1][5]){?><li><a href="javascript:cambia_contenido(1,5)"><? print $avMnuGE[1][5] ?></a></li><? } ?>
                    <? if($avXY[1][6]){?><li><a href="javascript:cambia_contenido(1,6)"><? print $avMnuGE[1][6] ?></a></li><? } ?>
                    <? if($avXY[1][10]){?><li><a href="javascript:cambia_contenido(1,10)"><? print $avMnuGE[1][10] ?></a></li><? } ?>
                    <? if($avXY[1][11]){?><li><a href="javascript:cambia_contenido(1,11)"><? print $avMnuGE[1][11] ?></a></li><? } ?>
        		    <? if($avXY[1][13]){?><li><a href="javascript:cambia_contenido(1,13)"><? print $avMnuGE[1][13] ?></a></li><? } ?>
        		    <? if($avXY[1][14]){?><li><a href="javascript:cambia_contenido(1,14)"><? print $avMnuGE[1][14] ?></a></li><? } ?>
        		    <? if($avXY[1][15]){?><li><a href="javascript:cambia_contenido(1,15)"><? print $avMnuGE[1][15] ?></a></li><? } ?>
        		    <? if($avXY[1][16]){?><li><a href="javascript:cambia_contenido(1,16)"><? print $avMnuGE[1][16] ?></a></li><? } ?>
                    <li>&nbsp;</li>
				</ul>
                <ul>
                    <div style="color:#628B61;  margin-left:15px;"> PRESUPUESTO </div>
            		<li>&nbsp;</li>
                    <? if($avXY[1][7]){?><li><a href="javascript:cambia_contenido(1,7)"><? print $avMnuGE[1][7] ?></a></li><? } ?>
                    <? if($avXY[1][8]){?><li><a href="javascript:cambia_contenido(1,8)"><? print $avMnuGE[1][8] ?></a></li><? } ?>
                    <? if($avXY[1][9]){?><li><a href="javascript:cambia_contenido(1,9)"><? print $avMnuGE[1][9] ?></a></li><? } ?>
                    <? if($avXY[1][12]){?><li><a href="javascript:cambia_contenido(1,12)"><? print $avMnuGE[1][12] ?></a></li><? } ?>
                    <li>&nbsp;</li>
                </ul>
                <ul>
                    <div style="color:#990000;  margin-left:15px;"> INVERSION </div>
                    <li>&nbsp;</li>
                    <li><a href="javascript:cambia_contenido(1,21)"><? print $avMnuGE[1][21] ?></a></li>
                    <li><a href="javascript:cambia_contenido(1,22)"><? print $avMnuGE[1][22] ?></a></li>
                    <li><a href="javascript:cambia_contenido(1,23)"><? print $avMnuGE[1][23] ?></a></li>                    
                    <li>&nbsp;</li>
                </ul>                
            </dd>    

<dt onclick="javascript:montre('smenu7');"><a><? print $avMnuGE[7][0] ?></a></dt>
            <dd id="smenu7">
                <ul>              	
                    <div style="color:#339999; margin-left:15px;">Perfil de usuarios</div>
                    <li>&nbsp;</li>	
                    <!--li><a href="../contenido/LogOut.php"><? print $avMnuGE[7][1] ?></a></li-->                    
                    <? if($avXY[7][2]){ ?><li><a href="javascript:cambia_contenido(7,2)"><? print $avMnuGE[7][2] ?></a></li><? } ?>
                    <? if($avXY[7][3]){ ?><li><a href="javascript:cambia_contenido(7,3)"><? print $avMnuGE[7][3] ?></a></li><? } ?>                    
                    <? if($avXY[7][5]){ ?><li><a href="javascript:cambia_contenido(7,5)"><? print $avMnuGE[7][5] ?></a></li><? } ?>
                    <? if($avXY[7][4]){ ?><li><a href="javascript:cambia_contenido(7,4)"><? print $avMnuGE[7][4] ?></a></li><? } ?>
                    <? if($avXY[6][13]){ ?><li><a href="javascript:cambia_contenido(6,13)"><? print $avMnuGE[6][13] ?></a></li><? } ?>
                    <? if($avXY[5][11]){ ?><li><a href="javascript:cambia_contenido(5,11)"><? print $avMnuGE[5][11] ?></a></li><? } ?>
		    <li>&nbsp;</li>
                 </ul>
                 <ul>
                    <div style="color:#993333; margin-left:15px;">Base de Datos</div>
                    <li>&nbsp;</li>
                    <? if($avXY[7][6]){ ?><li><a href="javascript:cambia_contenido(7,6)"><? print $avMnuGE[7][6] ?></a></li><? } ?>
                    <? if($avXY[7][7]){ ?><li><a href="#"><? print $avMnuGE[7][7] ?></a></li><? } ?>
                    <? if($avXY[7][8]){ ?><li><a href="#"><? print $avMnuGE[7][8] ?></a></li><? } ?>
                    <? if($avXY[7][9]){ ?><li><a href="javascript:cambia_contenido(7,9)"><? print $avMnuGE[7][9] ?></a></li><? } ?>
                    <? if($avXY[7][13]){ ?><li><a href="javascript:cambia_contenido(7,13)"><? print $avMnuGE[7][13] ?></a></li><? } ?>
					<li>&nbsp;</li>
                </ul>
                 <ul>
                    <div style="color:#669900; margin-left:15px;">Descargas</div>
                    <li>&nbsp;</li>	    
                    <li><a href="../doc/Manuales/Manual_usuario.pdf"><? print $avMnuGE[7][10] ?></a></li>
                    <!--li><a href="javascript:cambia_contenido(7,11)"><? print $avMnuGE[7][11]?></a></li-->
                    <li><a href="javascript:cambia_contenido(7,12)"><? print $avMnuGE[7][12]?></a></li> 
                    <li>&nbsp;</li>
                </ul>
            </dd>
                                                
</dl>            