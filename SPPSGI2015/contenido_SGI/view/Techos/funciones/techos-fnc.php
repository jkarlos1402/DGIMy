<?php

	include_once("contenido_SGI/libs/adodb/adodb.inc.php");
	require("contenido_SGI/includes/conexion-config.php");

	$cnx->SetFetchMode(ADODB_FETCH_ASSOC);

// Función para movimiento
function movimiento($cnx){
	try{

		$query = "SELECT idtipmov, nomtipmov FROM cattipmov";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['idtipmov'] . "'>" . $rows['nomtipmov'] . "</option>";
    	}

	}catch(Exception $e){
		$respuesta = "Error";
	}
		return $respuesta;
}

// Función para ejercicio
function ejercicio($cnx){
	try{
		
		$query = "SELECT ejercicio FROM catejercicio WHERE ejercicio != 0";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['ejercicio'] . "'>" . $rows['ejercicio'] . "</option>";
    	}

	}catch(Exception $e){
		$respuesta = "Error";
	}
		return $respuesta;
}

// Función para sector
function sector($cnx){
	try{

		$query = "SELECT idsec, nomsec FROM catsector WHERE idsec != 0";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['idsec'] . "'>" . $rows['nomsec'] . "</option>";
    	}

	}catch(Exception $e){
		$respuesta = "Error";
	}
		return $respuesta;
}

// Función para fuente
function fuente($cnx){
	try{

		$query = "SELECT idfte, nomfte FROM cfuente";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['idfte'] . "'>" . $rows['nomfte'] . "</option>";
    	}

	}catch(Exception $e){
		$respuesta = "Error";
	}
		return $respuesta;
}

// Función para inversión
function inversion($cnx){
	try{

		$query = "SELECT idinv, nominv FROM cinversion";

  		$arr = $cnx->GetAll($query);
  		$respuesta = "<option value=0>Selecciona...</option>";

    	foreach ($arr as $key => $rows) {
		    $respuesta .= "<option value='" . $rows['idinv'] . "'>" . $rows['nominv'] . "</option>";
    	}

	}catch(Exception $e){
		$respuesta = "Error";
	}
		return $respuesta;
}
?>