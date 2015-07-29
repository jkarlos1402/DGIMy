<?php
session_start();

$db_hostname = "192.168.20.5";
$db_user = "usgi2015";
$db_password = "cnx5gi2015";
$db_database = "ctrlusuarios";

$errorDbConexion = false;
//--- Conexión con la base de datos		
$cnx = new mysqli($db_hostname, $db_user, $db_password, $db_database);
// se colocan los nombres de las bases de datos
$_SESSION['dbNameSGI'] = "sgi2015";
$_SESSION['dbNameCtrlUsuarios'] = "ctrlusuarios";

/* verificamos la conneccion */

if ($cnx->connect_errno) {
    printf("Error de conexion: %s\n", $cnx->connect_error);
    $errorDbConexion = true;
    exit();
}

//------------

$avMensaje = array();

function sText_Protect($str, $con) {
    $str = trim($str);
    $str = htmlentities($str);
    $str = preg_replace('/\s(?=\s)/', '', $str);
    $str = preg_replace('/[\n\r\t]/', '', $str);
    $str = $con->real_escape_string($str);
    return($str);
}

if (isset($_POST['usuario']) && !empty($_POST['usuario'])) {
    $usu = sText_Protect($_POST['usuario'], $cnx);
} else {
    $avMensaje[] = 'Escribe el nombre del usuario';
}

if (isset($_POST['password']) && !empty($_POST['password'])) {
    $pwd = sText_Protect($_POST['password'], $cnx);
} else {
    $avMensaje[] = 'Escribe la contrase&ntilde;a';
}


$countError = count($avMensaje);
$msg = "";

//-------------    
if ($countError > 0) {
    for ($i = 0; $i < $countError; $i++) {
        echo ucfirst($avMensaje[$i]) . '<br/>';
    }
} else {  //----escribio usu y pwd--	            		  
    $sSql = " SELECT idusu, sistema, idRol FROM usuarios WHERE lgnusu = '" . $usu . "' and pwdusu=md5('" . $pwd . "')";
    $rs = $cnx->query($sSql);
    $row = $rs->fetch_row();
    $idusu = $row[0];
    $sis = $row[1];
    $idRol = $row[2];
    unset($sSql, $rs, $row);
    if ($idusu > 0) {   //-----existe usu ---       
        $year = $_POST['lstyear'];
        $tabla = "catestorg";

        switch ($sis) {
            case 'ADM':
                $bd_sp = "spp" . $year;
                break;
            case '1':
                $bd_sp = "spp" . $year;
                break;
            case '2':
                $bd_sp = "sgi" . $year;
                $tabla = "catestorg" . $year;
                break;
            case 'SIAVAMEN':
                $bd_sp = "sgi" . $year;
                $tabla = "catestorg" . $year;
                break;
            case 'BCOPRY':
                $bd_sp = "sgi" . $year;
                $tabla = "catestorg" . $year;
                break;
        }

        $sSql = " SELECT idorg,dscorg FROM " . $bd_sp . ".relusudep LEFT JOIN " . $bd_sp . "." . $tabla . "  USING(idorg) WHERE idusu = " . $idusu . " LIMIT 1 ";
        // if ($resultado = $cnx->query("SELECT idorg,dscorg FROM ".$_SESSION['dbNameSGI'].".relusudep LEFT JOIN ".$_SESSION['dbNameSGI'].".catestorg2015 USING(idorg) WHERE idusu = 608 LIMIT 1")) {
        if ($rs = $cnx->query($sSql)) {
            $row = $rs->fetch_row();
            $_SESSION["ORGID"] = $row[0];
            $_SESSION["ORGDSC"] = $row[1];
            $rs->close();
        } else {
            $_SESSION["ORGID"] = 0;
            $_SESSION["ORGDSC"] = ' Dependencia no seleccionada ';
        }

        //--------          
        $_SESSION['LOGIN_STATUS'] = true;
        $_SESSION['year'] = $_POST['lstyear'];
        //---USU---			                    
        $_SESSION['USER'] = $usu;
        $_SESSION['USERID'] = $idusu;
        $_SESSION['USERTPO'] = "";
        $_SESSION['SIS'] = $sis;
        $_SESSION['USERIDROL'] = $idRol;
        //---------            

        $query = "SELECT idacu, cveacu, nomacu "
                . "FROM " . $_SESSION['dbNameSGI'] . ".catacuerdo WHERE idtipacu = 4 ORDER BY cveacu";
        $rs = $cnx->query($query);
        $data = array();
        while ($row = $rs->fetch_row()) {
            array_push($data, $row);
        }

        $query = "SELECT idacu, cveacu, nomacu "
                . "FROM " . $_SESSION['dbNameSGI'] . ".catacuerdo WHERE idtipacu = 1 OR idtipacu = 2 ORDER BY cveacu";
        $rs = $cnx->query($query);
        $data2 = array();
        while ($row2 = $rs->fetch_row()) {
            array_push($data2, $row2);
        }
        $arrayCatalogos = array('accionesFederales' => $data, 'accionesEstatales' => $data2);
        $_SESSION['catalogos'] = $arrayCatalogos;

        $queryur = "SELECT idSec, idUE, NomUE FROM " . $_SESSION['dbNameSGI'] . ".catue WHERE idue = (SELECT idUE FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".usuarios WHERE idusu = " . $idusu . " LIMIT 1 )";
        $rsur = $cnx->query($queryur);
        $row = $rsur->fetch_row();
        $_SESSION['IDUR'] = $row[0];
        $_SESSION['IDUE'] = $row[1];
        if ($sis === "2") {//solo para SGI
            if ($_SESSION['IDUE'] !== "" && $_SESSION['IDUE'] !== null) {
                $_SESSION["ORGID"] = $row[0];
                $_SESSION["ORGDSC"] = $row[2];
            } else {                
                $queryur = "SELECT nombreUsu, aPaternoUsu, aMaternoUsu FROM " . $_SESSION['dbNameCtrlUsuarios'] . ".infousuario WHERE idusu = '$idusu'";
                $rsur = $cnx->query($queryur);
                $row = $rsur->fetch_row();
                $_SESSION["ORGID"] = 0;
                $_SESSION["ORGDSC"] = $row[1]." ".$row[2]." ".$row[0];
            }
        }

        $msg = "Autentificado,$sis";
        unset($sSql, $rs, $row);
    } else {
        $msg = "Datos incorrectos!!!";
    }
    echo $msg;
}//----escribio usu y pwd--
?>
