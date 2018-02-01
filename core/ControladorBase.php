<?php
class ControladorBase{
 
    public function __construct() {
        require_once 'Conectar.php';
        require_once 'EntidadBase.php';
        require_once 'ModeloBase.php';
         
        //Incluir todos los modelos
        foreach(glob("models/*.php") as $file){
            //echo $file.'<br>';
            require_once $file;
        }
    }
     
    //Plugins y funcionalidades
     
/*
* Este método lo que hace es recibir los datos del controlador en forma de array
* los recorre y crea una variable dinámica con el indice asociativo y le da el 
* valor que contiene dicha posición del array, luego carga los helpers para las
* vistas y carga la vista que le llega como parámetro. En resumen un método para
* renderizar vistas.
*/
    public function view($vista,$datos=DATOS_DEFECTO){

        if(is_array($datos))
        {
            foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor; 
            }
        }
        
         
        require_once 'core/AyudaVistas.php';
        $helper=new AyudaVistas();
     
        require_once 'libraries/FlashMessages.php';
        $msg = new FlashMessages();

        require_once 'views/'.$vista.'View.php';


    }
     
    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }
     
    //Métodos para los controladores
 
}
?>