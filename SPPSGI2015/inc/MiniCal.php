<?
	require_once("cal/src/activecalendar.php");
	
	$iYear = date("Y")*1;
	$iMonth = date("m")*1;
	$cal = new activeCalendar();
	$thisMonth = $cal->actmonth; 
	//---------- trimestre
	/*
	$MesApertura = array(0,1,0,0,1,0,0,1,0,0,1,0,0);
	$bMes = $MesApertura[$iMonth];
	if($bMes){
		for ($x=1;$x<15;$x++){ 
			$iDia = date("w",mktime(0,0,0,$iMonth,$x,$iYear))."<br>"; 
			if($iDia>0 && $iDia<6){
				$cal->setEvent($iYear,$iMonth,$x); 
			}
		}
	}		
	*/
?> 