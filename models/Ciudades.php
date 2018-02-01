<?php
class Ciudades extends EntidadBase{

   
   
     
    public function __construct($adapter) {
        $table="aoacol_aoacars.ciudad";
        parent::__construct($table, $adapter);
    }

    
 
}
?>