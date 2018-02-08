<?php
class Estado_siniestro extends EntidadBase{   
     
    public function __construct($adapter) {
        $table="aoacol_aoacars.estado_siniestro";
        parent::__construct($table, $adapter,get_class_vars(get_class($this)));
    }


}
?>