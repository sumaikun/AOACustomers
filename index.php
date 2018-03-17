<?php

/*foreach (glob("views/HtmlStates/Interfaces/*.php") as $filename)
{	
    require_once $filename;
}

foreach (glob("views/HtmlStates/*.php") as $filename)
{	
    require_once $filename;
}*/

spl_autoload_register('Container_autoload2');
	function Container_autoload2($classname) {
		$namespace = explode("\\" , $classname)[0];
		//echo $namespace." ".$classname;
		//echo "<br>";
		//exit;
		if ($namespace == 'Containers') {
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'Observable') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'FlashMessages') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = "libraries/".$classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'libraries') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'core') {
			//echo "here";		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace =='controllers') {
			//echo "here";		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'models') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'views') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
		if ($namespace == 'config') {		
			$classname = str_replace ('\\', '/', $classname);
			$filename = $classname .".php";
			require_once( __DIR__ . '/' .  $filename);
		}
	/*if ($namespace == 'Reportcontroller') {		
		$classname = str_replace ('\\', '/', $classname);
		$filename = "controllers/".$classname .".php";
		require_once( __DIR__ . '/' .  $filename);
	}*/
	/*if ($namespace == 'IndexController') {		
		$classname = str_replace ('\\', '/', $classname);
		$filename = "controllers/".$classname .".php";
		require_once( __DIR__ . '/' .  $filename);
	}*/
	/*if ($namespace == 'SQLModel') {		
		$classname = str_replace ('\\', '/', $classname);
		$filename = "models/".$classname .".php";
		require_once( __DIR__ . '/' .  $filename);
	}*/

	} 




require_once 'core/error.php';

//Configuración global
require_once 'config/global.php';

use core\UrlDispatcher;

if(isset($_GET["controller"]))
{
	$controller = $_GET["controller"];	
}
else
{
	$controller = CONTROLADOR_DEFECTO;
	$action =  ACCION_DEFECTO;
}

if(isset($_GET["action"]))
{
	$action = $_GET["action"];
}

else
{
	$action =  ACCION_DEFECTO;	
}

$dispatcher = new UrlDispatcher($controller,$action);
$dispatcher->load();

//$dispatcher->lanzarAccion($dispatcher->cargarControlador()); 
 
//Base para los controladores
//require_once 'core/ControladorBase.php';
 
//Funciones para el controlador frontal
/*require_once 'core/ControladorFrontal.func.php';


//Cargamos controladores y acciones
if(isset($_GET["controller"])){
    $controllerObj=cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
}else{
    $controllerObj=cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}*/



?>