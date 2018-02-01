<?php
class EntidadBase{
    private $table;
    private $db;
    private $conectar;
 
    public function __construct($table, $adapter) {
        $this->table=(string) $table;
         
        /*
        require_once 'Conectar.php';
        $this->conectar=new Conectar();
        $this->db=$this->conectar->conexion();
         */
        $this->conectar = null;
        $this->db = $adapter;
    }
     
    public function getConetar(){
        return $this->conectar;
    }
     
    public function db(){
        return $this->db;
    }
     
    public function getAll(){
        $resultSet = null;
        
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
         
        return $resultSet;
    }

    public function getArray($component){
        $resultSet = null;
        
        $query=$this->db->query("SELECT id,$component FROM $this->table ORDER BY id DESC");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[$row->id]=$row->$component;
        }
         
        return $resultSet;   
    }

    public function getArrayDefined($component,$idcomponent){
        $resultSet = null;
        
        $query=$this->db->query("SELECT $idcomponent,$component FROM $this->table ORDER BY $idcomponent DESC");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[$row->$idcomponent]=$row->$component;
        }
         
        return $resultSet;   
    }

    public function orderBy($param,$type="DESC"){
        $resultSet = null;
        
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY $param $type");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
         
        return $resultSet;
    }
     
    public function getById($id){
        $resultset = null;
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");
 
        if($row = $query->fetch_object()) {
           $resultSet=$row;
        }
         
        return $resultSet;
    }
     
    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");
 
        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
         
        return $resultSet;
    }
     
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id"); 
        return $query;
    }
     
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'"); 
        return $query;
    }
     
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
     
}
?>