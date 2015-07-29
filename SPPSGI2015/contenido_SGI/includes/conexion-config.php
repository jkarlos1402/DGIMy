<?php
	
	 $db_host     = '192.168.20.5';
	 $db_username = 'usgi2015';
	 $db_password = 'cnx5gi2015';
	 $db_database = 'sgi2015';

	$cnx = ADONewConnection('mysqli'); 
	$cnx->connect($db_host, $db_username, $db_password, $db_database); 
?>