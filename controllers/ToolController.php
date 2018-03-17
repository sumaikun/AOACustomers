<?php
namespace controllers;

use core\ControladorBase;
use libraries\FlashMessages;
use core\Conectar;
use models\Aseguradoras;
use models\Entidades;
use models\SQLModel;

class ToolController extends ControladorBase{
     
    public $conectar;
    public $adapter;
    
     
    public function __construct() {

        parent::__construct();
        
        require 'libraries/FlashMessages.php';  
        $this->conectar=new Conectar();
        $this->adapter=$this->conectar->conexion();
        $this->message = new FlashMessages();
        //print_r($_SESSION);
        if(!isset($_SESSION['id']) )
        {
            $this->message->warning('Acesso no autorizado');
            $this->redirect('Index');
        }

        if($_SESSION['rol'] != 1)
        {
            $this->message->warning('Acesso no autorizado');
            $this->redirect('Index');
        }
        
    }
     
    public function index(){
        
    }

    public function entities()
    {
        $modelAseguradora =  new Aseguradoras($this->adapter);
        $aseguradoras = $modelAseguradora->orderBy("nombre","ASC");
        $modelEntidades =  new Entidades($this->adapter);        
        $entidades = $modelEntidades->orderBy("nombre","ASC");      
       
        $this->view('Entities',compact("entidades","aseguradoras"));
    }

    public function get_entities()
    {
        $modelEntidades =  new Entidades($this->adapter);
        $entidades = $modelEntidades->orderBy("nombre","ASC");
        echo $this->view("subviews/entidades_table",compact("entidades"));
    }

    public function save_entity()
    {        
        $aseguradoras = explode("aseguradoras%5B%5D=", $_REQUEST['aseguradoras']);
        unset($aseguradoras[0]);

        $post_aseg = [];

        foreach($aseguradoras as $aseguradora)
        {
            $aseguradora = str_replace("&","",$aseguradora);
            array_push($post_aseg, $aseguradora);            
        }

        $nombre = $_REQUEST['nombre'];

        $entidades = new Entidades($this->adapter);

        $id = $entidades->last_table_id();        
        
        foreach($post_aseg as $aseg)
        {

            $sqlmodel = new SQLModel("undefined",$this->adapter);
            $sql = "SELECT * from aoacol_aoacars.aseguradora  where id = $aseg LIMIT 1";
            $c_aseguradora = $sqlmodel->executeSql($sql);
            //print_r($c_aseguradora);
            //print_r($c_aseguradora->entidad);
            
            if(isset($c_aseguradora->entidad))
            {
                if($c_aseguradora->entidad==null)
                { 
                    $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = $id where id = $aseg";
                    $sqlmodel->executeSql($sql);
                }
                else
                {
                    echo "La aseguradora ".$c_aseguradora->nombre." no pudo guardarse por que ya esta asociada a otra entidad \n";
                }
            }                
            else
            {
                $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = $id where id = $aseg";
                $sqlmodel->executeSql($sql);
            }    
        }

        $entidades->setId($id);

        $entidades->setNombre($nombre);

        $entidades->save($entidades);

        echo "Guardado";

    }

    public function delete_entity()
    {
        $id = $_REQUEST['id'];
        $sqlmodel = new SQLModel("undefined",$this->adapter);
        $sql = "SELECT * from  aoacol_aoacars.aseguradora  where entidad = $id";
        $aseguradoras = $sqlmodel->executeSql($sql);
        if($aseguradoras != null)
        {
            foreach($aseguradoras as $aseguradora)
            {
                $sqlmodel2 = new SQLModel("undefined",$this->adapter);
                $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = null where id = ".$aseguradora->id;
                $sqlmodel2->executeSql($sql);
            }    
        }
                
        $modelEntidades = new Entidades($this->adapter);
        $modelEntidades->deleteById($id);
        $this->redirect('Tool','entities');
    }
    

    public function look_for_aseguradoras()
    {
        $sqlmodel = new SQLModel("undefined",$this->adapter);
        $sql = "SELECT id from aoacol_aoacars.aseguradora WHERE  entidad = ".$_REQUEST['id'];
        $aseguradoras = $sqlmodel->executeSql($sql);
        echo json_encode($aseguradoras);
    }


    public function update_entity()
    {
        $aseguradoras = explode("aseguradoras%5B%5D=", $_REQUEST['aseguradoras']);
        unset($aseguradoras[0]);

        $post_aseg = [];

        foreach($aseguradoras as $aseguradora)
        {
            $aseguradora = str_replace("&","",$aseguradora);
            array_push($post_aseg, $aseguradora);            
        }

        $id = $_REQUEST['id'];     

        $sqlmodel = new SQLModel("undefined",$this->adapter);
        $sql = "SELECT * from aoacol_aoacars.aseguradora  where entidad = $id ";
        $p_aseguradoras = $sqlmodel->executeSql($sql);

        foreach($p_aseguradoras as $asegs)
        {
            if(!in_array($asegs->id, $post_aseg))
            {
                $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = null where id = ".$asegs->id;
                $sqlmodel->executeSql($sql);
            }
        }
  
        
        foreach($post_aseg as $aseg)
        {

            $sqlmodel = new SQLModel("undefined",$this->adapter);
            $sql = "SELECT * from aoacol_aoacars.aseguradora  where id = $aseg  LIMIT 1";
            $c_aseguradora = $sqlmodel->executeSql($sql);

            if(isset($c_aseguradora->entidad))
            { 
                if($c_aseguradora->entidad==null or $c_aseguradora->entidad == $id)
                {
                    $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = $id where id = $aseg";
                    $sqlmodel->executeSql($sql);
                }
                else
                {
                    echo "La aseguradora ".$c_aseguradora->nombre." no pudo guardarse por que ya esta asociada a otra entidad \n";
                }    
                
            }
            else
            {
                $sql = "UPDATE aoacol_aoacars.aseguradora SET entidad = $id where id = $aseg";
                $sqlmodel->executeSql($sql);
            }
            
        }

        echo "Actualizado";
    }
    
     
    
 
}