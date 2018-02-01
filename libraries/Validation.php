<?php

class Validation {

    
    private $db;
    private $conectar;
 
    public function __construct($table, $adapter) {
             
        $this->conectar = null;
        $this->db = $adapter;
    }
    
    
    public function existence($table,$column,$value){
        $query=$this->db->query("SELECT * FROM $table WHERE $column = $value");
        return $query->num_rows;        
    }

}