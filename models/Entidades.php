<?php
namespace models;
use core\EntidadBase;
class Entidades extends EntidadBase{

    
  
   private $id;
   private $nombre;
     
    public function __construct($adapter) {
        $table="aoa_clientes.Entidad";
        parent::__construct($table, $adapter,get_class_vars(get_class($this)));
    }

    

    public function setId($id)
    {
    	$this->id = $id;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

   
}
?>