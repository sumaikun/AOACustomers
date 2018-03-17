<?php
namespace controllers;

use core\ControladorBase;
use libraries\FlashMessages;
use core\Conectar;
use models\Seguimiento;
use models\SQLModel;
use models\Aseguradoras;

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
     
        //print_r($this->adapter);
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
            if($conditionwhere!=" ")
            {
                $conditionwhere .= " and ";
            }
            $conditionwhere .="placa = '".$_POST['placa']."'  ";
        }
        if(!empty($_POST['poliza']))
        {
            if($conditionwhere!=" ")
            {
                $conditionwhere .= " and ";
            }
            $conditionwhere .="numero = '".$_POST['poliza']."'  ";
        }
        if(!empty($_POST['cedula']))
        {
            if($conditionwhere!=" ")
            {
                $conditionwhere .= " and ";
            }
            $conditionwhere .="asegurado_id = '".$_POST['cedula']."'  ";
        }
        $query = "Select * from aoacol_aoacars.siniestro  where $conditionwhere ";
        //echo $query;
        $siniestros = $sqlmodel->executeSql($query,false);

        $ModelAseguradoras = new Aseguradoras($this->adapter);
        $aseguradoras = $ModelAseguradoras->getArray("nombre");

       
        echo $this->view('subviews/resultconsult',compact("siniestros","aseguradoras"));
    } 

    public function get_services()
    {
        $seguimiento = new Seguimiento($this->adapter);

        $seguimiento->setSiniestro($_POST["siniestro"]);

        $seguimiento->save($seguimiento);

         if($_SESSION['rol'] != 1){
            $secure_data .=" and  s.aseguradora = '".$_SESSION['aseguradora']."' ";   
         }
         else
         {
            $secure_data = " ";  
         }

         $siniestro = $_POST["siniestro"];
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $query = "select c.*,o.nombre as noficina,ec.nombre as nestado,c.estadod,ec.color_co
         from cita_servicio c,estado_citas ec,oficina o, siniestro s where c.siniestro = $siniestro and c.oficina=o.id and 
         c.estado=ec.codigo and s.id = c.siniestro ".$secure_data." order by c.fecha,c.hora,c.id";
         //echo $query;
         $servicios = $sqlmodel->executeSql($query);
         echo $this->view('subviews/servicesfromresultconsult',compact("servicios"));        
    } 

     public function get_obs()
    {
         if($_SESSION['rol'] != 1){
            $secure_data .=" and  aseguradora = '".$_SESSION['aseguradora']."' ";   
         }
         else
         {
            $secure_data = " ";  
         }

         $siniestro = $_POST["siniestro"];
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         $query = "select numero,observaciones,obsconclusion from siniestro where id = $siniestro ".$secure_data." LIMIT 1";
         $observaciones = $sqlmodel->executeSql($query); 
         $obs = explode("\n", $observaciones->observaciones);
         //print_r($obs); 
         echo $this->view('subviews/obsfromresultconsult',compact("obs"));        
    }

    public function get_seg()
    {

       if($_SESSION['rol'] != 1){
            $secure_data .=" and  aseguradora = '".$_SESSION['aseguradora']."' ";   
         }
         else
         {
            $secure_data = " ";  
         }

         $siniestro = $_POST["siniestro"];
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         
         $query = "select s.*,t.nombre as ntipo,t_tipifica_seguimiento(tipificacion) as ntipi 
         from seguimiento s,tipo_seguimiento t where s.siniestro=$siniestro and s.tipo=t.id 
         union
         select s.*,t.nombre as ntipo,t_tipifica_seguimiento(tipificacion) as ntipi 
         from seguimiento_hst s,tipo_seguimiento t where s.siniestro=$siniestro and s.tipo=t.id 
         order by fecha,hora";

         $seguimientos = $sqlmodel->executeSql($query);
         
         echo $this->view('subviews/segfromresultconsult',compact("seguimientos"));
    }

    public function get_appointment()
    {
        if($_SESSION['rol'] != 1){
            $secure_data .=" and  aseguradora = '".$_SESSION['aseguradora']."' ";   
         }
         else
         {
            $secure_data = " ";  
         }

         $siniestro = $_POST["siniestro"];
         $sqlmodel = new SQLModel('undefined',$this->adapter);
         
         $query = "Select * from aoacol_aoacars.cita_servicio where siniestro = '$siniestro' and estado = 'C' order by id desc LIMIT 1";

         $cita = $sqlmodel->executeSql($query);
         
         echo $this->view('subviews/citafromresultconsult',compact("cita"));
    }  
    
 
}