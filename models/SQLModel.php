<?php
class SQLModel extends ModeloBase{
    private $table;
     
    public function __construct($table,$adapter){
        $this->table=$table;
        parent::__construct($this->table, $adapter);
    }
    //Metodos de consulta
    public function getOne($param,$value)
    {
        $query="SELECT * FROM $this->table WHERE $param = '$value' LIMIT 1";
        $data=$this->executeSql($query);
        return $data;        
    }

     public function login($name,$password)
    {
        $query="SELECT * FROM $this->table WHERE nombre_login = '$name' and password = '$password' LIMIT 1";
        $data=$this->executeSql($query);
        return $data;        
    }

    public function get_data_by_param($param,$value)
    {
        $query="SELECT * FROM $this->table WHERE id= ".$id;
        $data=$this->executeSql($query);
        return $data;        
    }     


   public function param_relation($foid,$kid,$param)
   {
        $sql = $this->executeSql("select $param from $this->table where $kid = ".$foid." LIMIT 1");  
        if($sql != null)
        {
            return $sql->$param;
        }
        else{return null;}
   }

   public function param_relation_like($foid,$kid,$param)
   {
        $query = "select $param from $this->table where $kid LIKE '%$foid%'"." LIMIT 1";
        //echo $query;
        $sql = $this->executeSql($query);
        if($sql != null)
        {
            return $sql->$param;
        }
        else{return null;}
        //print_r($sql);  
        
   }
}
?>