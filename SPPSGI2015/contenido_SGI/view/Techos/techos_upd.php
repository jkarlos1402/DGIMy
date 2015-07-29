<?php

include_once ("../../libs/adodb/adodb.inc.php");
require_once ("../../includes/conexion-config.php");

$cnx->SetFetchMode(ADODB_FETCH_ASSOC);

$mov	= ($_POST['mov']*1);
$ejer	= ($_POST['ejer']*1);
$ue		= ($_POST['ue']*1);
$fte	= ($_POST['fte']*1);
$inv	= ($_POST['inv']*1);
$proy	= ($_POST['proy']*1);
$monto  = str_replace(",","",$_POST['monto']);
$obs	= ($_POST['obs']);
$hoy	= date ('Y-m-d');

try{

if($mov == 1){

	$capturado = "SELECT idtecfin, ejercicio, idue, idfte, idinv, idprg, techo, monini FROM ptecfin
					WHERE ejercicio= ".$ejer." 
					AND idue= ".$ue."
					AND idfte= ".$fte."
					AND idinv= ".$inv."
					AND idprg= ".$proy;

	$respcap = $cnx->Execute($capturado);

	foreach ($respcap as $key => $value) {
		$valor = $value['idtecfin'];
	}

	if($valor != ""){
			
			$respuesta = "Techo registrado con anterioridad";

		}else{

			/*  ---------  Autorización  -----------  */

			$query = "INSERT INTO pTecFin
					(Ejercicio, IdUE, IdFte, IdInv, IdPrg, Techo, MonIni)
				VALUES
					(".$ejer.",".$ue.",".$fte.",".$inv.",".$proy.",".$monto.",".$monto.")";

				$result = $cnx->Execute($query);

				$tecfin = $cnx->Insert_ID();

			$query2 = "INSERT INTO dTecFin 
				(IdTipMov, IdTecFin, Ejercicio, IdUE, IdFte, IdInv, IdPrg, Monto, FecAlt, Observa) 
			VALUES 
				(".$mov.",".$tecfin.",".$ejer.",".$ue.",".$fte.",".$inv.",".$proy.",".$monto.",'".$hoy."','".$obs."')";

				$result2 = $cnx->Execute($query2);

			/*  ---------  Fin de Autorización  -----------  */
			$respuesta="Datos guardados correctamente";
		}
}else{

	$consulta = "SELECT IdTecFin FROM ptecfin
					WHERE ejercicio= ".$ejer." 
					AND idue= ".$ue."
					AND idfte= ".$fte."
					AND idinv= ".$inv."
					AND idprg= ".$proy;

	$respcon = $cnx->Execute($consulta);

	foreach ($respcon as $key => $value) {
		$valorcon = $value['IdTecFin'];
	}

	$query3 = "INSERT INTO dTecFin 
				(IdTipMov, IdTecFin, Ejercicio, IdUE, IdFte, IdInv, IdPrg, Monto, FecAlt, Observa) 
			VALUES 
				(".$mov.",".$valorcon.",".$ejer.",".$ue.",".$fte.",".$inv.",".$proy.",".$monto.",'".$hoy."','".$obs."')";

				$result3 = $cnx->Execute($query3);

		$sum = "SELECT SUM(monto) AS suma FROM dtecfin WHERE idtecfin = ".$valorcon." AND (idtipmov = 1 OR idtipmov = 2)";

		$respsum = $cnx->Execute($sum);

		foreach ($respsum as $key => $value) {
			$a = $value['suma'];
		}

		$rest = "SELECT SUM(monto)AS resta FROM dtecfin WHERE idtecfin = ".$valorcon." AND idtipmov = 3";

		$resprest = $cnx->Execute($rest);

		foreach ($resprest as $key => $value) {
			$b = $value['resta'];
		}

		$valtech = $a - $b;

		$modificacion = "UPDATE pTecFin SET techo =".$valtech." WHERE IdTecFin=".$valorcon;

		$respmod = $cnx->Execute($modificacion);
	$respuesta2 = $valtech;

	$respuesta="Techo modificado correctamente, el valor del techo es de: ".$valtech;
}

}catch (Exception $e){
	$respuesta="Error".$e;
}

	$salidaJson = array('respuesta' =>$respuesta, 'respuesta2' =>$respuesta2);
	echo json_encode($salidaJson);


?>