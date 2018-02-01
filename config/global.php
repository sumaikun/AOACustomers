<?php
session_start();
//unset($_SESSION['START']);
//control de inactividad
if(!isset($_SESSION['START']))
{
	$now = new DateTime();
	//echo $now->format('Y-m-d H:i:s');
	$current_time = $now->format('o-m-d H:i:s');
	$_SESSION['START'] = $current_time;	
}
else{
	$now = new DateTime();

	$current_time = $now->format('o-m-d H:i:s');

	$ts1 = strtotime($_SESSION['START']);
	$ts2 = strtotime($current_time);
	//echo ($ts2-$ts1)/60; 
 	if(($ts2-$ts1)/60>30)
 	{
 		session_destroy();
 		echo "sesion terminada por inactividad";
 		exit;
 		//echo "cumplida";
 	}
 	else{
 		$_SESSION['START'] = $current_time;		
 	}
	//exit;
}

define("CONTROLADOR_DEFECTO", "Index");
define("ACCION_DEFECTO", "index");
define("DATOS_DEFECTO", "");
//Más constantes de configuración
?>