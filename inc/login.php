<?php
    session_start();
    //include_once('db_conection.php');
    $db_hostname = "localhost";
    $db_user     = "uadminusu";
    $db_password = "ctrlu5u";
    $db_database = "ctrlusuarios";       

    $errorDbConexion = false;
	//--- Conexión con la base de datos		
    $cnx = new mysqli($db_hostname, $db_user, $db_password, $db_database);   
    
    /* verificamos la conneccion */
    
    if ($cnx->connect_errno) {
        printf("Error de conexion: %s\n", $cnx->connect_error);
        $errorDbConexion = true;
        exit();
    }
    
    //------------

    $avMensaje = array();
	
    function sText_Protect($str,$con){
      	$str = trim($str);
        $str = htmlentities($str);
      	$str = preg_replace('/\s(?=\s)/', '', $str);
      	$str = preg_replace('/[\n\r\t]/', '', $str);		
        $str = $con->real_escape_string($str);        
        return($str);
    }
    
    if(isset($_POST['usuario']) && !empty($_POST['usuario'])){	   
        $usu = sText_Protect($_POST['usuario'],$cnx);
    }
    else{
        $avMensaje[]='Escribe el nombre del usuario';
    }

    if(isset($_POST['password']) && !empty($_POST['password'])){	   
        $pwd = sText_Protect($_POST['password'],$cnx);
    }
    else{
            $avMensaje[]='Escribe la contrase&ntilde;a';
    }

    $countError = count($avMensaje);
    $msg = "";    
    
    //-------------    
	if($countError > 0){ 
            for($i=0;$i<$countError;$i++){
                echo ucfirst($avMensaje[$i]).'<br/>';
            }
	}else{  //----escribio usu y pwd--	            		  
            $sSql = " SELECT idusu FROM catusuarios WHERE lgnusu = '".$usu."' and pwdusu=md5('".$pwd."')";               
            $rs = $cnx->query($sSql);
            $row = $rs->fetch_row();                 
            $idusu = $row[0];  
            unset($sSql,$rs,$row);                   
            if ($idusu>0){   //-----existe usu ---                                                                    
                    //--------          
                   $_SESSION['LOGIN_STATUS'] =  true;
                   $_SESSION['year'] = $_POST['lstyear'];
                   //---ORG---
                   $_SESSION["ORGID"] = 0;
                   $_SESSION["ORGDSC"] = ' - Dependencia no seleccionada -';
                   $_SESSION["ORGTPO"] = " ";
                   //---USU---			                    
                   $_SESSION['USER'] = $usu;
                   $_SESSION['USERID'] = $idusu; 			                     
                   $_SESSION['USERTPO'] = "";
                   //---------                    			 			
                   $msg = 'Autentificado';  
                   unset($sSql,$rs,$row);              
               }
               else{
                   $msg = "Datos incorrectos!!!";                  
               }                 
               echo $msg;     
	}//----escribio usu y pwd--
?>