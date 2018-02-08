<?php
class Aseguradoras extends EntidadBase{

    
   private $emblema_f;
   private $id;
     
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

 
}
?>