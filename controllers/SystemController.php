<?php
namespace controllers;

use core\ControladorBase;
use libraries\FlashMessages;
use core\Conectar;
use models\Seguimiento;
use models\SQLModel;
use models\Aseguradoras;

class SystemController extends ControladorBase{
     
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
        echo json_encode(array("status"=>"X","desc"=>"Index del System"));
    }

    public function META_COLUMNS()
    {
        $request_body = file_get_contents('php://input');
        if($request_body)
        {
            $request = json_decode($request_body);
        }

        $sql = "SHOW COLUMNS FROM ".$request->table;
        $sqlmodel = new SQLModel('undefined',$this->adapter);           
        $columns = $sqlmodel->executeSql($sql);        
        $array = array("status"=>1,"columns"=>$columns,"sql"=>$sql);
        echo json_encode($array);
    }   

 
}