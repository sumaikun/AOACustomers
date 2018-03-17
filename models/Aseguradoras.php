<?php
namespace models;

use core\EntidadBase;

class Aseguradoras extends EntidadBase{

    
   private $emblema_f;
   private $id;
   private $entidad;
     
    public function __construct($adapter) {
        $table="aoacol_aoacars.aseguradora";
        parent::__construct($table, $adapter,get_class_vars(get_class($this)));
    }

    public function setEmblema_f($emblema_f)
    {
    	$this->emblema_f = $emblema_f;
    }

    public function getEmblema_f()
    {
    	return $this->emblema_f;
    }

    public function setId($id)
    {
    	$this->id = $id;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;
    }

    public function getEntidad()
    {
        return $this->entidad;
    }

     public function get_entities_from_aseguradoras()
    {
        $query = "select distinct(ent.nombre),ent.id as id, 'entidad' as tipo  from aoacol_aoacars.aseguradora as aseg inner join aoa_clientes.Entidad as ent on aseg.entidad = ent.id UNION select CAST(nombre as CHAR) as nombre, id , 'aseguradora' as tipo from aoacol_aoacars.aseguradora where entidad is null";
        //echo $query;
        $result=$this->db()->query($query);
        if($this->db()->error)
        {
            echo $this->db()->error;
            exit; 
        } 
        else
        {
            while($row = $result->fetch_object()) {
                   $resultSet[]=$row;
                }

             return $resultSet;    
        }
    }
}
?>