<?php

include 'funcionesUsuariosModel.php';
include 'funcionesSGIModel.php';
extract($_POST);

switch ($accionUser) {
    case 'getSistemas':
        $usuarioBean = new Usuario();
        $sistemas = $usuarioBean->getSistemas();
        $optionsSistema = "";
        foreach ($sistemas as $sistema) {
            $optionsSistema .= "<option value='" . $sistema['idsistema'] . "'>" . utf8_encode($sistema['descsistema']) . "</option>";
        }
        echo $optionsSistema;
        break;
    case 'getOrganizaciones':
        $sgiBean = new SGI();
        $organizaciones = $sgiBean->getOrganizaciones();
        $optionsOrganizaciones = "";
        foreach ($organizaciones as $organizacion) {
            $optionsOrganizaciones .= "<option value='" . $organizacion['idOrg'] . "'>" . utf8_encode($organizacion['CveOrg']) . " " . utf8_encode($organizacion['DscOrg']) . "</option>";
        }
        echo $optionsOrganizaciones;
        break;
    case 'getSectores':
        $sgiBean = new SGI();
        $sectores = $sgiBean->getSectores();
        $optionsSectores = "";
        foreach ($sectores as $sector) {
            $optionsSectores .= "<option value='" . $sector['IdSec'] . "'>" . utf8_encode($sector['NomSec']) . "</option>";
        }
        echo $optionsSectores;
        break;
    case 'pushUser':
        $userBean = new Usuario();
        $usuario = $userBean->pushUser($_POST);
        if (isset($usuario['idusu'])) {
            $sgiBean = new SGI();
            //se valida que el usuario tenga acceso a SGI
            if (in_array("2", $_POST['sistUser'])) {
                $res = $sgiBean->pushSectoresByUser($_POST['secUser'], $usuario['idusu']);
            }
            $res = $sgiBean->pushDependenciasByUser($_POST['depUser'], $usuario['idusu']);
        }
        echo json_encode($usuario);
        break;
    case 'buscaUserByLgnUser':
        $userBean = new Usuario();
        $usuario = $userBean->findUserByLgnUser($_POST['lgnUser']);
        if ($usuario === null) {
            $usuario["error"] = "No existe el usuario ingresado";
        } else {
            $sgiBean = new SGI();
//            $dependencias = $sgiBean->getDependenciasByIdUsu($usuario['idusu']);
//            $usuario['dependencias'] = $dependencias;
            $sectores = $sgiBean->getSectoresByIdUsu($usuario['idusu']);
            $usuario['sectores'] = $sectores;
        }
        echo json_encode($usuario);
        break;
    case 'updateUser':
        $userBean = new Usuario();
        $usuario = $userBean->updateUser($_POST);
        if (in_array("2", $_POST['sistUser'])) {
            $sgiBean = new SGI();
            $res = $sgiBean->updateSectoresByUser($_POST['secUser'], $usuario['idusu']);
        }
        $sgiBean->updateDependenciasByUser($_POST['depUser'], $usuario['idusu']);
        echo json_encode($usuario);
        break;
    case 'inhabilitaUser':
        $userBean = new Usuario();
        $usuario = $userBean->inhabilitaUser($idUser);
        echo json_encode($usuario);
        break;
    case 'habilitaUser':
        $userBean = new Usuario();
        $usuario = $userBean->habilitaUser($idUser);
        echo json_encode($usuario);
        break;
    case 'mergePermisosSGI':
        $usuarioBean = new Usuario();
        $res = $usuarioBean->pushPermisosSGIbyUser($_POST, $idUserPermiso);
        if ($res) {
            $usuario['idusu'] = $idUserPermiso;
            echo json_encode($usuario);
        }
        break;
    case 'getModulosSGI':
        $usuarioBean = new Usuario();
        $res = $usuarioBean->getModulosSGI();
        echo json_encode($res);
        break;
    case 'getPermisosSGIByUser':
        $usuarioBean = new Usuario();
        $res = $usuarioBean->getPermisosSGIByUser($idusu);
        echo json_encode($res);
        break;
    case 'getUEs':
        $sgiBean = new SGI();
        $ues = $sgiBean->getUEs();
        $optionsUE = "<option value='-1'>Seleccione</option>";
        foreach ($ues as $ue) {
            $optionsUE .= "<option value='" . $ue['IdUE'] . "' class='".$ue['IdSec']."'>" . utf8_encode($ue['NomUE']) . "</option>";
        }
        echo $optionsUE;                
        break;
    case 'combos':
        $usuarioBean = new Usuario();
        $roles = $usuarioBean->getRoles();
        $optionsRol = "<option value='-1'>Seleccione</option>";
        foreach ($roles as $rol) {
            $optionsRol .= "<option value='" . $rol['idRol'] . "'>" . utf8_encode($rol['dscRol']) . "</option>";
        }
        echo $optionsRol;                
        break;
}

