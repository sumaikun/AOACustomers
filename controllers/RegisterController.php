<?php
namespace controllers;

use core\ControladorBase;
use libraries\FlashMessages;
use core\Conectar;
use models\Seguimiento;
use models\SQLModel;
use models\Aseguradoras;

class RegisterController extends ControladorBase{
     
    public $conectar;
    public $adapter;
    
     
    public function __construct() {

        parent::__construct();
        
        require 'libraries/FlashMessages.php';  
        $this->conectar=new Conectar();
        $this->adapter=$this->conectar->conexion();
        $this->message = new FlashMessages();
        if(!isset($_SESSION['id']) )
        {
            $this->message->warning('Acesso no autorizado');
            $this->redirect('Index');
        }
        
    }
     
    public function index(){         
     
        //print_r($this->adapter);
        $this->view("Register");
    }

    public function get_asegs(){
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $sql = "Select * from aoacol_aoacars.aseguradora where id in (".$_SESSION['aseguradoras'].")";
         $aseguradoras = $sqlmodel->executeSql($sql);
         echo json_encode(array("status"=>1,"sql"=>$sql,"aseguradoras"=>$aseguradoras));
    }

    public function get_citys(){
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $sql = "Select * from aoacol_aoacars.ciudad ";
         $citys = $sqlmodel->executeSql($sql);
         echo json_encode(array("status"=>1,"sql"=>$sql,"citys"=>$citys));
    }

    public function get_offices(){
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $sql = "Select * from aoacol_aoacars.oficina ";
         $offices = $sqlmodel->executeSql($sql);
         echo json_encode(array("status"=>1,"sql"=>$sql,"offices"=>$offices));
    }


    public function register_data()
    {
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);

        $sql = $this->insert($request->table,$request->form);

        $sqlmodel = new SQLModel('undefined',$this->adapter);

        $sqlmodel->executeSql($sql);
        
        echo json_encode(array("status"=>1,"sql"=>$sql));

    }

    public function insert($table,$array)
    {           
            //$table = $this->request['table'];
            
            if(is_object($array))
            {
                $array =  (array) $array;
            }
            
            $sql = "Insert into ".$table;
            $sql .= " (";
        
            
            foreach($array as $key => $value)
            {
                if($key != 'table' and $key != 'Acc')
                {
                    $sql .= $key.",";
                    
                }
        
                
            }
            $sql = substr_replace($sql, "", -1);
            $sql .= ") values ( ";
            
            foreach($array as $key => $value)
            {
                if($key != 'table' and $key != 'Acc')
                {
                    $sql .= "'".$value."',";
                    
                }
        
                
            }
            $sql = substr_replace($sql, "", -1);
            $sql .= ") ";       
            
            return $sql;
    }
 
}