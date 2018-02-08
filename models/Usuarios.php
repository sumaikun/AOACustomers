<?php
class Usuarios extends EntidadBase{
    
    private $id;
    private $nombres;
    private $apellidos;
    //private $password;
    private $nombre_login;
    private $rol;
    private $email;
    private $aseguradora;   
     
    public function __construct($adapter) {
        $this->table="aoa_clientes.usuarios";
        //print_r(get_class_vars(get_class($this)));
        parent::__construct($this->table, $adapter,get_class_vars(get_class($this)));
    }
     
    public function getId() {
        return $this->id;
    }
 
    public function setId($id) {
        $this->id = $id;
    }
     
    public function getNombres() {
        return $this->nombres;
    }
 
    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function getApellidos() {
        return $this->apellidos;
    }
 
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    /*
 
    public function getPassword() {
        return $this->password;
    }
 
    public function setPassword($password) {
        $this->password = $password;
    }*/

    public function getNombre_Login() {
        return $this->nombre_login;
    }   
 
    public function setNombre_login($nombre_login) {
        $this->nombre_login = $nombre_login;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRol() {
        return $this->rol;
    }
 
    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getAseguradora() {
        return $this->aseguradora;
    }
 
    public function setAseguradora($aseguradora) {
        $this->aseguradora = $aseguradora;
    }    
    
 
    /*public function save(){
        
        $query="INSERT INTO $this->table (nombres,apellidos,nombre_login,rol,email,aseguradora)
                VALUES('".$this->nombres."',
                       '".$this->apellidos."',
                       '".$this->nombre_login."',
                       '".$this->rol."',
                       '".$this->email."',
                       '".$this->aseguradora."'
                       );";
        $save=$this->db()->query($query);
        if($this->db()->error)
        {
            echo $this->db()->error;
            exit; 
        } 
        return $save;
    }

    public function update(){
        
        $query="UPDATE $this->table SET nombres = '".$this->nombres."', apellidos = '".$this->apellidos."', nombre_login = '".$this->nombre_login."', rol = '".$this->rol."', email = '".$this->email."', aseguradora = '".$this->aseguradora."' WHERE id = ".$this->id." ";
        //echo $query;
        $save=$this->db()->query($query);
        if($this->db()->error)
        {
            echo $this->db()->error;
            exit; 
        } 
        //$this->db()->error;
        return $save;
    }*/

  
    public function set_password($password,$psw_change)
    {
        $password = hash('ripemd160', $password);
        $query = "UPDATE $this->table SET password = '$password' , psw_change = $psw_change  where id = $this->id ";
        //echo $query;
        $save=$this->db()->query($query);
        if($this->db()->error)
        {
            echo $this->db()->error;
            exit; 
        } 
        //$this->db()->error;
        return $save;
    }

    
 
}
?>