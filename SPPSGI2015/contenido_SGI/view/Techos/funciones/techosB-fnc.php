<?php

// Función para ejercicio

	include_once("../../../libs/adodb/adodb.inc.php");
	require("../../../includes/conexion-config.php");

	$cnx->SetFetchMode(ADODB_FETCH_ASSOC);

	$sec = $_POST['sec'];

		
		$query = "SELECT idue, idsec, nomue FROM catue WHERE idsec =".$sec;

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['idue'] . "'>" . utf8_encode($rows['nomue']) . "</option>";
    	}

	$salidaJson = array('respuesta' =>$respuesta);
	echo json_encode($salidaJson);

?>