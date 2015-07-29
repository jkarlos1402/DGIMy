<?php

// Función para proyecto

	include_once("../../../libs/adodb/adodb.inc.php");
	require("../../../includes/conexion-config.php");

	$cnx->SetFetchMode(ADODB_FETCH_ASSOC);

	$ejer = $_POST['ejer'];
	$initabla = "catestprg";
	$tabla = $initabla.$ejer;
	$puntos = "...";

		
		$query = "SELECT idprg, CONCAT (cveprg,' ', LEFT (dscprg, 60) ) AS prg, LENGTH(dscprg) as num  FROM ".$tabla." WHERE tpoprg = 'PRY'";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
    		if($rows['num'] <= 60){
    			$respuesta .= "<option value='" . $rows['idprg'] . "'>" . utf8_encode($rows['prg']) ."</option>";
    		}else{
    			$respuesta .= "<option value='" . $rows['idprg'] . "'>" . utf8_encode($rows['prg']) ."".$puntos. "</option>";
    		}
		    
    	}

	$salidaJson = array('respuesta' =>$respuesta);
	echo json_encode($salidaJson);

?>