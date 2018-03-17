<?php
namespace core;

use core\ModeloBase;

class EntidadBase{
    private $table;
    private $db;
    private $conectar;
 
    public function __construct($table, $adapter,$model) {
        $this->table=(string) $table;         
        $this->model = $model;      
        $this->db = $adapter;
        $this->sql_manager = new ModeloBase("undefined",$this->db);
    }
     
  
    public function db(){
        return $this->db;
    }
     
    public function getAll(){
         
        $query=$this->sql_manager->executeSql("SELECT * FROM $this->table ORDER BY id DESC");
         
        return $query;
    }

    public function getArray($component){
        
        
        $query=$this->sql_manager->executeSql("SELECT id,$component FROM $this->table ORDER BY id DESC");
        
        $array = [];

        foreach($query as $object)
        {
            $array[$object->id] = $object->$component;
        }  

        return $array;   
    }

    public function getArrayDefined($component,$idcomponent){
        
        
        $query=$this->sql_manager->executeSql("SELECT $idcomponent,$component FROM $this->table ORDER BY $idcomponent DESC");
          
        $array = [];

        foreach($query as $object)
        {
            $array[$object->$idcomponent] = $object->$component;
        }  

        return $array;     
    }

    public function orderBy($param,$type="DESC"){
        
        
        $query=$this->sql_manager->executeSql("SELECT * FROM $this->table ORDER BY $param $type");
          
        return $query;
    }
     
    public function getById($id){
        
        $query=$this->sql_manager->executeSql("SELECT * FROM $this->table WHERE id=$id LIMIT 1");
 
        return $query;
    }
     
    public function getBy($column,$value){
        $query=$this->sql_manager->executeSql("SELECT * FROM $this->table WHERE $column='$value'");
 
        return $query;
    }
     
    public function deleteById($id){
        $query=$this->sql_manager->executeSql("DELETE FROM $this->table WHERE id=$id"); 
        return $query;
    }
     
    public function deleteBy($column,$value){
        $query=$this->sql_manager->executeSql("DELETE FROM $this->table WHERE $column='$value'"); 
        return $query;
    }

     public function save($object)
    {
  
        $sql = "INSERT into $this->table ";
        $sql .= "(";
        foreach($this->model as $key => $temp)
        {
            $sql .= " ".$key.",";
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ") VALUES ( ";
        foreach($this->model as $key => $temp)
        {
            $sql .= " '".$object->{'get'.ucfirst($key)}()."',";
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ")";
        //echo $sql;
        //exit;
        $query=$this->sql_manager->executeSql($sql); 
        return $query;        
        
    }
    public function update($object)
    {
  
        $sql = "UPDATE $this->table ";
        $sql .= "SET";
        foreach($this->model as $key => $temp)
        {
            $sql .= " ".$key."='".$object->{'get'.ucfirst($key)}()."',";
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= " WHERE id = ".$object->getId();
        $query=$this->sql_manager->executeSql($sql); 
        return $query;     
     
    }


    public function last_table_id()
    {
       //echo "SELECT  max(id) as max from $this->table";
        $query = $this->sql_manager->executeSql("SELECT  max(id) as max from $this->table LIMIT 1");

        //print_r($query);
         if($query->max == null)
        {
            $id=1;
        }
        else{
            $id = 1+$query->max;
        }
        return $id;
    }
     
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
     
}
?>