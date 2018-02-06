
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

        if($_SESSION['rol'] != 1){
            $conditionwhere .="aseguradora = '".$_SESSION['aseguradora']."' ";   
        }

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
        $query = "Select * from aoacol_aoacars.siniestro  where $conditionwhere ";
        //echo $query;
        $siniestros = $sqlmodel->executeSql($query,false);

        $ModelAseguradoras = new Aseguradoras($this->adapter);
        $aseguradoras = $ModelAseguradoras->getArray("nombre");

        /*foreach($siniestros as $siniestro)
        {
            print_r($siniestro);
        }
        //print_r($siniestros);*/
        echo $this->view('subviews/resultconsult',compact("siniestros","aseguradoras"));
    } 

    public function get_services()
    {
         $siniestro = $_POST["siniestro"];
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $query = "select c.*,o.nombre as noficina,ec.nombre as nestado,c.estadod,ec.color_co
         from cita_servicio c,estado_citas ec,oficina o where c.siniestro = $siniestro and c.oficina=o.id and 
         c.estado=ec.codigo order by c.fecha,c.hora,c.id";
         $servicios = $sqlmodel->executeSql($query,false);
         echo $this->view('subviews/servicesfromresultconsult',compact("servicios"));        
    }  
    
 
}