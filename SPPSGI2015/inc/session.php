<?
	session_start();
	//function check_login() {
		if (!isset ($_SESSION['USERID']) || !$_SESSION['USERID']) {		
			header('Location: ../index.html');
		}
	//}
?>