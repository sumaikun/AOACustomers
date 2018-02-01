
<?php

class ReportController extends ControladorBase{
     
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
        /*echo apcu_fetch("login text");
        exit;*/
        $registros = null;
        $sqlmodel = new SQLModel('undefined',$this->adapter);
        $aseguradora = $_SESSION['aseguradora'];

        if(isset($_POST['aseguradora_select']) and $_SESSION['rol']==1)
        {
            if($_POST['aseguradora_select'] !=0 and $_POST['aseguradora_select'] !=null)
            {
                $aseguradora = $_POST['aseguradora_select'];
            }            
        }

        if(isset($_POST['fecha1']) and isset($_POST['fecha2']))
        {
            $date_condition = "and fec_siniestro between '".$_POST['fecha1']."' and '".$_POST['fecha2']."'";
        }
        else
        {
            $date_condition = null;
        }

        $sql = "Select s.*,c.flota as flota,c.placa as cita_placa from aoacol_aoacars.siniestro as s inner join cita_servicio as c on c.siniestro = s.id  where  c.estado = 'C' and s.aseguradora =  $aseguradora ".$date_condition." order by id desc LIMIT 4000";

        $registros = $sqlmodel->executeSql($sql);

        //print_r($registros);

        //exit;

        $modelAseguradora =  new Aseguradoras($this->adapter);
        $aseguradoras = $modelAseguradora->orderBy("nombre","ASC");
        $saseguradora = $aseguradora;

        $ModelCiudad = new Ciudades($this->adapter);
        $ciudades = $ModelCiudad->getArrayDefined("nombre","codigo");
        $ModelEstado = new Estado_siniestro($this->adapter);
        $estados_siniestro = $ModelEstado->getArray("nombre"); 

        $lsqlModel = new SQLModel("aoacol_aoacars.vehiculo",$this->adapter);
        $rsqlModel = new SQLModel("aoacol_aoacars.linea_vehiculo",$this->adapter);

        //print_r($ciudades);
        //echo count($registros);
        //exit;
        set_time_limit(60);
        $this->view("Report",array("registros"=>$registros,"aseguradoras"=>$aseguradoras,"saseguradora"=>$saseguradora,"ciudades"=>$ciudades,"lsqlModel"=>$lsqlModel,"rsqlModel"=>$rsqlModel,"estados_siniestro"=>$estados_siniestro));
    }     
    
 
}