
<?php

class ConsultController extends ControladorBase{
     
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
     
        $this->view("Consult");
    }  

    public function consult(){
        $sqlmodel = new SQLModel('undefined',$this->adapter);
        $conditionwhere = " ";
        if(!empty($_POST['placa']))
        {
            $conditionwhere .="placa = '".$_POST['placa']."' ";
        }
        if(!empty($_POST['poliza']))
        {
            $conditionwhere .="numero = '".$_POST['poliza']."' ";
        }
        if(!empty($_POST['cedula']))
        {
            $conditionwhere .="asegurado_id = '".$_POST['cedula']."'  ";
        }
        $query = "Select * from aoacol_aoacars.siniestro where $conditionwhere ";
        //echo $query;
        $siniestros = $sqlmodel->executeSql($query,false);
        /*foreach($siniestros as $siniestro)
        {
            print_r($siniestro);
        }
        //print_r($siniestros);*/
        echo $this->view('subviews/resultconsult',array("siniestros"=>$siniestros));
    }   
    
 
}