<?php

    session_start();
    include_once('bd_conexion.php');

    $year = $_POST['lstyear'];
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
    $usuario = sText_Protect($_POST['usuario'],$cnn_mysqli);
    }
    else{
            $avMensaje[]='Escribe el nombre del usuario';
    }

    if(isset($_POST['password']) && !empty($_POST['password'])){	   
    $password = sText_Protect($_POST['password'],$cnn_mysqli);
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
        $sSql = " SELECT idusu FROM catusuarios WHERE lgnusu = '$usuario' and estatus=1 ";   
        $rs = $cnn_mysqli->query($sSql);
        $row = $rs->fetch_row();
        //$row = $rs->fetch_assoc();            
	    $idusu = $row[0];  
        unset($sSql,$rs,$row);                   
        if ($idusu>0){   //-----existe usu ---                                                                    
            //------------obtener numero de intentos----------   
            $sSql = " SELECT intentos,TIMESTAMPDIFF(MINUTE,fechaUltimoIntento,NOW()) lapso,estatus FROM catusuarios WHERE idusu = ".$idusu;
            $rs = $cnn_mysqli->query($sSql);            
            $row = $rs->fetch_row(); 
            $iIntentos = $row[0];
            $ilapso    = $row[1];
            $estatus   = $row[2]; 
            unset($sSql,$rs,$row);  
            //-----------------
            $ipermitirintento = 0; 
            //----------------------                   
            if($iIntentos < 4 ){
                $ipermitirintento = 1;    
            }else{      
                $ipermitirintento = 0;
                if($iIntentos>9){   //---- suspender usuario
                    $sSql = " update catusuarios set estatus = 0 where idusu = ".$idusu;            
                    $cnn_mysqli->query($sSql); 
                    $msg = "Usuario suspendido.";                   
                }else{                    
                    $iesperar = floor((pow($iIntentos,3))/12);
                    if( $ilapso >= $iesperar ) {
                        $ipermitirintento = 1;
                    }else  $msg .= "<br> Cuenta bloqueada - [Espere $iesperar minutos para nuevo intento]";
                }                            
    		}  
            //----------------           
            if($ipermitirintento == 1){
                $sSql = " update catusuarios set intentos = intentos+1, fechaUltimoIntento = NOW() where idusu = ".$idusu;            
                $cnn_mysqli->query($sSql); 
                //-------------------------------
                $sSql = "select * from catusuarios where idusu = $idusu AND pwdusu = md5('$password')";   
                $rs = $cnn_mysqli->query($sSql);
                if($rs){ 
                    $row = $rs->fetch_row();
                    $iRows = $rs->num_rows;
                }                          
                if ($iRows>0){                      
                    //---------
                    $sSql = " update catusuarios set intentos = 0 where idusu = ".$idusu;
                    $cnn_mysqli->query($sSql);
                     //--------     
   
                    $bd_sp = "spp".$year;
                    //$sSql = " SELECT idorg FROM ".$bd_sp.".relusudep WHERE idusu = ".$idusu." LIMIT 1 ";   
                    $sSql = " SELECT idorg,dscorg FROM ".$bd_sp.".relusudep LEFT JOIN ".$bd_sp.".catestorg USING(idorg) WHERE idusu = ".$idusu." LIMIT 1 ";

                    $rs = $cnn_mysqli->query($sSql);
                    $row = $rs->fetch_row();        
                    $iOrg = $row[0];
                    $sOrg = $row[1];

                    //---------
                    $_SESSION['LOGIN_STATUS'] =  true;
                    $_SESSION['year'] = $year;
                    //---ORG---
                    $_SESSION["ORGID"] = $iOrg;
                    $_SESSION["ORGDSC"] = $sOrg;
                    $_SESSION["ORGTPO"] = " ";
                    //---USU---			                    
                    $_SESSION['USER'] = $usuario;
                    $_SESSION['USERID'] = $idusu; 			                     
                    $_SESSION['USERTPO'] = "";
                    //---------                    			 			
                    $msg = 'Autentificado';  
                    unset($sSql,$rs,$row);              
                }
                else{
                    $msg = "Datos incorrectos!!!"; 
                    if($iIntentos == 3 )                    $msg .= "<br> Usted lleva 3 intentos de acceso.";
                    //--
                    if($iIntentos > 3 && $iIntentos < 10 )  $msg .= "<br> Cuenta bloqueada - [Espere $ilapso minutos para nuevo intento]";                   
                }                 
            }
            //------------------    
        }else{   //--no existe usu        
                $msg = "No existe el usuario.";
        }    //--no existe usu
        echo $msg;
	}//----escribio usu y pwd--
?>   