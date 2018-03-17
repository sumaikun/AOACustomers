<?php
namespace models;
use core\EntidadBase;
class Ciudades extends EntidadBase{

   
   
     
    public function __construct($adapter) {
        $table="aoacol_aoacars.ciudad";
        parent::__construct($table, $adapter,get_class_vars(get_class($this)));
    }

    
 
}
?>