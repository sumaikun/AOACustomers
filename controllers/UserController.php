
<?php

class UserController extends ControladorBase{
     
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
        //echo "here";  
       
        //Cargamos la vista index y le pasamos valores
        $modeluser = new Usuarios($this->adapter);
        $usuarios = $modeluser->getAll();
        $modelAseguradora =  new Aseguradoras($this->adapter);
        $aseguradoras = $modelAseguradora->orderBy("nombre","ASC");
        $asqlmodel = new SQLModel("aoacol_aoacars.aseguradora",$this->adapter);
        $rsqlmodel = new SQLModel("aoa_clientes.roles",$this->adapter);
        //print_r($aseguradoras);

        $this->view("Usuarios",array("usuarios"=>$usuarios,"aseguradoras"=>$aseguradoras,"asqlmodel"=>$asqlmodel,"rsqlmodel"=>$rsqlmodel));
    }

    public function create(){
        
        $usuario = new Usuarios($this->adapter);
        foreach($_POST as $key => $temp)
        {
            $setter = "set".ucwords($key);
            $usuario->$setter($temp);
        }

        if($usuario->save())
        {
            $this->message->success('Usuario guardado');    
        }
        else{
            $this->message->warning('Existe un error en la información');   
        }        

        $this->redirect('User');
    }

    public function update(){


        $usuario = new Usuarios($this->adapter);
        foreach($_POST as $key => $temp)
        {
            $setter = "set".ucwords($key);
            $usuario->$setter($temp);
        }

        if($usuario->update())
        {
            $this->message->success('Usuario actualizado');    
        }
        else{
            $this->message->warning('Existe un error en la información');   
        }

        $this->redirect('User');
    }


    public function delete()
    {
        $usuario = new Usuarios($this->adapter);
        if($usuario->deleteById($_GET['id']))
        {            
            $this->message->success('Usuario eliminado');    
        }
        else{
            $this->message->warning('Sucede un error');   
        }
        $this->redirect('User');
    }

    public function set_password()
    {
        //print_r($_POST);
        //exit;
        $usuario = new Usuarios($this->adapter);
        $usuario->setId($_POST['id']);
        if(isset($_POST['must_changue']))
        {
            $psw_change = 1;
        }
        else{
            $psw_change = null;
        }

        if($usuario->set_password(md5($_POST['password']),$psw_change))
        {            
            $this->message->success('Contraseña asignada');    
        }
        else{
            $this->message->warning('Sucedio un error');   
        }

         $this->redirect('User');
        
    }



     
    
 
}