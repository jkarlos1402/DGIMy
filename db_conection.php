<?php

    $db_hostname = "192.168.20.5";
    $db_user     = "uadminusu";
    $db_password = "ctrlu5u";
    $db_database = "ctrlusuarios";
       
    $errorDbConexion = false;
	//--- Conexi�n con la base de datos		
    $cnx = new mysqli($db_hostname, $db_user, $db_password, $db_database);   
    
    /* verificamos la conneccion */
    if ($cnx->connect_errno) {
        printf("Error de conexion: %s\n", $cnx->connect_error);
        $errorDbConexion = true;
        exit();
    }
   
    //$mysqli->close();  cerrar coneccion 

	// Evitando problemas con acentos
	//$cnn_mysqli->query('SET NAMES "utf8"');
       
?>