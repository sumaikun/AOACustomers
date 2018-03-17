<?php
namespace models;
use core\EntidadBase;
class Seguimiento extends EntidadBase{
    
    private $id;
    private $fecha;
    private $hora;
    private $usuario;
    private $descripcion;
    private $tipo;
    private $siniestro;
       
     
    public function __construct($adapter) {
        $this->table="aoacol_aoacars.seguimiento";
        //print_r(get_class_vars(get_class($this)));
        parent::__construct($this->table, $adapter,get_class_vars(get_class($this)));
    }
     
    public function getId() {
        return $this->id;
    }   
     
    public function getFecha() {
        return date("Y-m-d");
    }

    public function getHora() {
        return date("H:i:s");
    }

    public function getUsuario() {
        return $_SESSION["nombres"]." ".$_SESSION["apellidos"];
    }

    public function getDescripcion() {
        return "Consulta desde sistema de clientes";
    }

    public function getTipo() {
        return 2;
    }

    public function getSiniestro() {
        return $this->siniestro;
    }

    public function setSiniestro($siniestro) {
         $this->siniestro = $siniestro;
    }    
    

    //Este objeto no permite update
}
?>