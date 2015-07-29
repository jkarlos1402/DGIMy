<?php

    $db_hostname = "192.168.20.5";
    $db_user     = "usgi2015";
    $db_password = "ctrlu5u";
    $db_database = "ctrlusuarios";
       
    $errorDbConexion = false;
	//--- Conexi�n con la base de datos		
    $cnn_mysqli = new mysqli($db_hostname, $db_user, $db_password,$db_database);   
    
    /* verificamos la conneccion */
    if ($cnn_mysqli->connect_errno) {
        printf("Error de conecci�n: %s\n", $cnn_mysqli->connect_error);
        $errorDbConexion = true;
        exit();
    }
   
    //$mysqli->close();  cerrar coneccion 

	// Evitando problemas con acentos
	//$cnn_mysqli->query('SET NAMES "utf8"');
       
?>
