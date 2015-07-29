<?php

include_once '../../libs/ChromePhp.php';
include '../../model/obra/funcionesObra.php';


if ($_POST) {
    
    extract($_POST);
    
    if (isset($accion) && !empty($accion)) {

        $obra = new Obra();

        switch ($accion) {
            case "buscaSolicitud":
                $data = $obra->buscaSolicitud($id);
                echo json_encode($data);
            break;
            case "buscaSolObra":
                $data = $obra->buscaSolObra($id);
                echo json_encode($data);
            break;
            case "buscaPrograma":
                $data = $obra->buscaPrograma($ejercicio);
                $rPrg = "<option value=''>Selecciona...</option>";
                foreach ($data['programa'] as $key => $rows) {
                    $rPrg .= "<option value='".$rows['idPrg']."'>".$rows['nombre']."</option>";
                }
                $programa['programa'] = $rPrg;
                echo json_encode($programa);
            break;
            case "buscaProyecto":
                $data = $obra->buscaProyecto($prg, $ejercicio);
                $rPry = "<option value=''>Selecciona...</option>";
                foreach ($data['proyecto'] as $key => $rows) {
                    $rPry .= "<option value='".$rows['idPrg']."'>".$rows['nombre']."</option>";
                }
                $proyecto['proyecto'] = $rPry;
                echo json_encode($proyecto);
            break;
            case "guardaObra":
                $data = $obra->guardaObra($_POST);
                echo json_encode($data);
            break;
            case "modificarObra":
                $data = $obra->modificarObra($_POST);
                echo json_encode($data);
            break;
            case "buscaClaPry":
                $data = $obra->buscaClaPry();
                $rClaPry = "<option value=''>Selecciona...</option>";
                foreach ($data['clapry'] as $key => $rows) {
                    $rClaPry .= "<option value='".$rows['idClaObr']."'>".$rows['NomClaObr']."</option>";
                }
                $clapry['clapry'] = $rClaPry;
                echo json_encode($clapry);
            break;
        }
    }
}