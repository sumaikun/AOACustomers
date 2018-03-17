<?php
namespace core;
use controllers\IndexController as IndexController;
//FUNCIONES PARA EL CONTROLADOR FRONTAL
//use controllers\IndexController as IndexController;
//use controllers\ReportController;

class UrlDispatcher
{
    private $controller;
    private $action;


     public function __construct($controller,$action) {
        $this->controller =  ucwords($controller).'Controller';
        $this->action = $action;

      
    }

    public function load(){    
        
        //$accion=$action; 
        $controller = $this->controller;
        $class = 'controllers\\'.$controller;       
        $controllerObj=new $class();
        $action = $this->action;
        $controllerObj->$action();
        
    }

    

}

 

 
?>