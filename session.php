<?
    session_start();
	
    if(!$_SESSION['LOGIN_STATUS']){
        header("Location: ../index.html");	
    }                    
/*
    if(isset($_GET['logout'])){
            session_destroy();
            header("Location: index.html");
    }            
*/            
            /*
            if (!isset ($_SESSION['USERID']) || !$_SESSION['USERID']) {		
                    header('Location: ../index.html');
            }	
            */
?>