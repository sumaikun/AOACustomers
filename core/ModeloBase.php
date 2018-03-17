<?php

namespace core;

class ModeloBase{
    private $table;
    private $fluent;
     
    public function __construct($table, $adapter) {
        $this->table=(string) $table;
        $this->db = $adapter;
    }
     
    public function getConetar(){
        return $this->conectar;
    }
     
    public function db(){
        return $this->db;
    }
     
    //false arreglo si uno , true varios si uno

    public function executeSql($query){
     
        $sql = $query;
        //echo $sql;        
        $query=$this->db()->query($query);
         if($this->db()->error)
        {
            echo $this->db()->error;
            exit; 
        } 
        if($query==true){
            //echo "here true";
            $sql = strtoupper($sql);
            if($this->words_search($sql, "INSERT") or $this->words_search($sql, 'UPDATE') or $this->words_search($sql, 'DELETE')){
                //echo "con activated";
                return true;
            }
            elseif($query->num_rows==1 and (strpos($sql, "LIMIT 1") or strpos($sql, "COUNT") or strpos($sql, "min"))){
                if($row = $query->fetch_object()) {
                    $resultSet=$row;
                }
            }
            elseif($query->num_rows>0){
                while($row = $query->fetch_object()) {
                   $resultSet[]=$row;
                }
            }            
            else{
                $resultSet=null;
            }
        }else{
            //echo "here";
            $resultSet=false;
        }
         
        return $resultSet;
    }

    private function words_search($string,$word)
    {
        $string = strtoupper($string);
        $word = strtoupper($word);
        $string_array = explode(' ', $string);
        if(in_array($word, $string_array))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*elseif($query->num_rows==1 and $unite == true){
                if($row = $query->fetch_object()) {
                    $resultSet=$row;
                }
            }*/


    //Aqui podemos montarnos métodos para los modelos de consulta
     
}
?>