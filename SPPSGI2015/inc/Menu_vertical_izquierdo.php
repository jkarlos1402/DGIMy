<?php
    //------------
include ("inc/cnxbds_sgi.php");
// include ("inc/cnxbds_usu.php");

$sSql  = " ";

$sSql .= " SELECT distinct idMnu, r.Xi, r.Yi, modulo, submodulo, orden, link, etiqueta, ruta, sistema  ";
$sSql .= " FROM ctrlusuarios.modulo_rutas r LEFT JOIN ctrlusuarios.relusuacc  USING(idmnu) ";
$sSql .= " WHERE modulo IN ( ";
$sSql .= " SELECT DISTINCT modulo_rutas.modulo FROM ctrlusuarios.modulo_rutas  LEFT JOIN ctrlusuarios.relusuacc ac USING(idmnu) ";
$sSql .= " WHERE ac.idusu = ".$_SESSION["USERID"];
$sSql .= " AND ac.acceso = 1 ";
$sSql .= " ) ";
$sSql .= " AND link = 0 ";
//$sSql .= " AND relusuacc.idusu = ".$_SESSION["USERID"];

$sSql .= " UNION ALL ";

$sSql .= " SELECT distinct  idMnu, r.Xi, r.Yi, modulo, submodulo, orden, link, etiqueta, ruta, sistema ";
$sSql .= " FROM ctrlusuarios.modulo_rutas r LEFT JOIN ctrlusuarios.relusuacc a USING(idmnu) ";
$sSql .= " WHERE a.idusu = ".$_SESSION["USERID"];
$sSql .= " AND a.acceso = 1 ";
$sSql .= " AND link = 1 ";  //AGREGADO 16042015
$sSql .= " ORDER BY modulo,submodulo,orden ";

/*
$sSql .= " SELECT idMnu, r.Xi, r.Yi, modulo, submodulo, orden, link, etiqueta, ruta, sistema  ";
$sSql .= " FROM ctrlusuarios.modulo_rutas r LEFT JOIN ctrlusuarios.relusuacc  USING(idmnu) ";
$sSql .= " WHERE modulo IN ( ";
$sSql .= " SELECT DISTINCT modulo_rutas.modulo FROM ctrlusuarios.modulo_rutas  LEFT JOIN ctrlusuarios.relusuacc ac USING(idmnu) ";
$sSql .= " WHERE ac.idusu = ".$_SESSION["USERID"];
$sSql .= " AND ac.acceso = 1 ";
$sSql .= " ) ";
$sSql .= " AND link = 0 ";

$sSql .= " UNION ALL ";

$sSql .= " SELECT idMnu, r.Xi, r.Yi, modulo, submodulo, orden, link, etiqueta, ruta, sistema ";
$sSql .= " FROM ctrlusuarios.modulo_rutas r LEFT JOIN ctrlusuarios.relusuacc a USING(idmnu) ";
$sSql .= " WHERE a.idusu = ".$_SESSION["USERID"];
$sSql .= " AND a.acceso = 1 ";

$sSql .= " ORDER BY modulo,submodulo,orden ";
*/

$cnn->SetFetchMode(ADODB_FETCH_ASSOC);
$arr = $cnn->GetAll($sSql);

$avXY = array();
$m = 0;
$n = 0;

foreach ($arr as $key => $value) {
  $m = $value['modulo'];  
  $avXY[$m][] = $value;  
}

?>



<link rel="stylesheet" href="tendina_menu_style.css">

<style type="text/css">
  .mnu-inicio{ height: 25px; background: #2B2B2B; color: #F7F7F7; padding: 2px 10px;  }
</style>


<ul class="dropdown">
  <div class="mnu-inicio"><span class="glyphicon glyphicon-list"></span> M&oacute;dulos</div> 
  <div class="separador"></div> 

<?php
foreach ($avXY as $Xi => $value) {  
  
  $sm = 0;
  $sm_ant = 0;
  $sm_act = 0;
//-------Modulo--  
  echo '<li>';
//-------Modulo--

  foreach ($value as $ind => $data) {  
    $Yi = $data['Yi'];
    
    $sm_act = $data['submodulo'];
  
    if($data['submodulo']==0 ){
      echo '<a class="'.$Xi.'" href="#"><i class="fa fa-caret-right"></i>&nbsp; :: '.$data['etiqueta'].'</a>';
      echo "<ul>";
    }

    if($sm_ant <> $sm_act && $sm==1){
      $sm = 0;
      echo " </ul>";
      echo "</li>";  
    }

    if($data['link']==0){                          
        if($data['submodulo'] > 0 ){
          $sm = 1;
          echo '<li>';                       
          echo ' <a class="inv_'.$ind.'" href="#"><i class="fa fa-angle-right"></i>&nbsp;'.$data['etiqueta'].'</a>';
          echo " <ul>";          
        }        
    }

    if($data['link']==1){
      echo '<li><a class="'.$Xi.'_'.$Yi.'" href="javascript:cambia_contenido('.$Xi.','.$Yi.')"> &nbsp;. '.$data['etiqueta'].'</a></li>';
    }

    $sm_ant = $sm_act;

  }    

  if($sm==1){
          echo " </ul>";
      echo "</li>";  
  }

  //-------Modulo--
  echo " </ul>";  
  echo '</li>';
  //-------Modulo--
}

?> 

  <div class="separador"></div>
      <ul>
          <li><a class="pry_3" href="../logout.php"><span class="glyphicon glyphicon-off "> </span> Cerrar Sesion </a></li>
      </ul>    
  <div class="separador"></div>

</ul>


<br>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="tendina.min.js"></script>

<script>
  $('.dropdown').tendina({
    animate: true,
    speed: 500,
    onHover: false,
    hoverDelay: 300,
    activeMenu: $('.inicio'),
    openCallback: function(clickedEl) {
      clickedEl.addClass('opened');
      console.log('Hi');
    },
    closeCallback: function(clickedEl) {
      clickedEl.addClass('closed');
      console.log('Bye!');
    }
  })
</script>

