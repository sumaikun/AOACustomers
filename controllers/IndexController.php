<?php
namespace controllers;

use core\ControladorBase;
use Containers\EntidadesAseguradoras;
use Observable\Subject as Subject;
use Observable\Observer as Observer;
use libraries\FlashMessages;
use core\Conectar;
use models\Aseguradoras;
use models\SQLModel;
use views\HtmlStates\menu_open;
use views\HtmlStates\menu_collapse;

class IndexController extends ControladorBase implements Subject, Observer{
     
    public $conectar;
    public $adapter;    
  
     
    public function __construct() {

        parent::__construct();       
    
        $this->conectar=new Conectar();
        $this->adapter=$this->conectar->conexion();
        $this->message = new FlashMessages();
        $this->EntidadesAseguradoras = new EntidadesAseguradoras($this->adapter);
      
    }



    public function registerObserver(Observer $observer)
    {
       
    }
    public function removeObserver(Observer $observer)
    {

    }
    public function NotifyObserver()
    {
        $this->update();
    }
    public function update()
    {
        $this->admin_change_aseguradora();
    }
     
    public function index(){
       
        $this->view("Login");
    }

    public function home(){       
        //Cargamos la vista index y le pasamos valores para generar las gráficas.        

        $sqlmodel = new SQLModel('undefined',$this->adapter);
        
        if(!isset($_SESSION['id']))
        {
            $this->message->warning('Acesso no autorizado');
            $this->redirect('Index');
        }      

        
        
        if(isset($_POST['aseguradora_select']) and $_SESSION['rol']==1)
        {

            if($_POST['aseguradora_select'] !=0 and $_POST['aseguradora_select'] !=null)
            {
               $_SESSION['aseguradora'] = $_POST['aseguradora_select'];
               $this->NotifyObserver();
            }
            
            
        }
        else
        {
            $this->NotifyObserver();
        }

      
        $aseguradora = $_SESSION['aseguradoras'];


        //Grafica de área

        $areachartvalues = [];
        $datearray = array();
        $countarray = array();
        $countarray2 = array();
      
        $max_area = 0;

        if(isset($_POST['area_week']) and !empty($_POST['area_week']))
        {
            $week = explode('-',$_POST['area_week']);
        
            $year = $week[0];
                
            $f_date = date('Y-m-d', strtotime($year.$week[1]."0")); 
            //echo "first day :".$date;
        } 
        else{
            //echo "first day :".date('Y-m-d',strtotime('-10 days'));
            $f_date = date('Y-m-d',strtotime('-10 days'));
        }     
        
        //exit;

        for($i=0;$i<=10;$i++)
        {
             $date = date('Y-m-d', strtotime($f_date."+".$i." days"));
             $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fec_siniestro = '$date' and aseguradora in ($aseguradora)";
             //echo $sql;
             $data = $sqlmodel->executeSql($sql);

             if($max_area< $data->count)
             {
                $max_area = $data->count;   
             }

             $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fecha_inicial = '$date' and aseguradora in ($aseguradora)";
             //echo $sql;
             $data2 = $sqlmodel->executeSql($sql);
             $inarray = array("date"=>$date,"count"=>$data->count,"count"=>$data2->count);
             array_push($areachartvalues, $inarray);
             array_push($datearray, $date);
             array_push($countarray, $data->count);
             array_push($countarray2, $data2->count);     
        }         
        


        //Gráfica de barras

        $spanish_months = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


        
       if(isset($_POST['pie_year']))
        {
            $year = $_POST['pie_year']; 
        }
        else{
            $year = date('Y');
        }

        if(isset($_POST['bar_month']))
        {
            $month = $_POST['bar_month'];
            $month = explode('-',$month);
            //print_r($month);
            //echo ;
            $month = $month[1];           
            $month_date = $_POST['bar_month']; 
        }
        else
        {
            $month = date('m');
            $month_date = $year."-".$month;    
        }
        

        $bar_labels = array();
        $total_month_siniesters = array();
        $total_month_services = array();
        $total_month_siniesters_percent = array();
        $total_month_services_percent = array();

        $current_month = $spanish_months[intval($month)];
        
        //echo  $current_month;
        
        array_push($bar_labels, $current_month);        


        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fec_siniestro like '%$month_date%' and aseguradora in ($aseguradora)";
        //echo $sql;
        $data1 = $sqlmodel->executeSql($sql);

        //print_r($data);

        //echo "<br>";

        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fecha_inicial like '%$month_date%' and aseguradora in ($aseguradora)";
        //echo $sql;
        $data2 = $sqlmodel->executeSql($sql);

        //print_r($data);

        //exit;

        array_push($total_month_siniesters, $data1->count);
        array_push($total_month_services, $data2->count);

        $total_count = $data1->count+$data2->count;

        $max_bar = $data1->count+70;

        if($total_count > 0)
        {
            $percent1 =  ceil(($data1->count*100)/$total_count)."% ";
            //$percent2 =  (int)($percent1*-1)+100;
            //$percent2 =  $percent2."%";
            $percent2 =  ceil((($data2->count*100)/$total_count)-1)."% ";
        }
        else
        {
            $percent1 = "0%";
            $percent2 = "0%";            
        }

        
        array_push($total_month_siniesters_percent, $percent1);
        array_push($total_month_services_percent, $percent2);

        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where YEAR(fec_siniestro) = '$year'  and aseguradora in ($aseguradora)";
       
        $data1 = $sqlmodel->executeSql($sql);    

        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where YEAR(fecha_inicial) = '$year' and aseguradora in ($aseguradora)";
      
        $data2 = $sqlmodel->executeSql($sql);        

        $total_count = $data1->count+$data2->count;

         if($total_count > 0)
        {
            $percent1 =  ceil(($data1->count*100)/$total_count)."% ";

            $percent2 =  ceil((($data2->count*100)/$total_count)-1)."% ";

            //$percent2 = 100-$percent1."% ";
        }
        else
        {
            $percent1 = "0% ";
            $percent2 = "0% ";            
        }

        $year_labels = array("Siniestros -> ".$percent1,"Servicios -> ".$percent2);        

        $year_siniesters = array($data1->count,$data2->count);


        // Modificar aseguradoras para que aparescan donde pertenescan entidades
      
        $aseguradoras = $this->EntidadesAseguradoras->query(null);

        //print_r($aseguradoras);

        //exit;

        //

        $max_area = $max_area+7;

        
        

        //datos para select de años.

        $sql = "select min(YEAR(fec_siniestro)) as min_date from siniestro where aseguradora in ($aseguradora) and fec_siniestro != '0000-00-00' LIMIT 1";

        $year_min_date = $sqlmodel->executeSql($sql);

        $year_min = $year_min_date->min_date; 


        if(!isset($_SESSION['CURRENT_MENU_STATE']))
        {
            $menu_open = new menu_open();
            //echo json_encode($menu_open->current_state());
            //exit;
            $_SESSION['CURRENT_MENU_STATE'] = $menu_open->current_state();  
        }

        $sql = "SELECT max_days_month FROM aseguradora WHERE id in ($aseguradora) LIMIT 1";
      
        $data3 = $sqlmodel->executeSql($sql);  

        $max_month_days = $data3->max_days_month;
        //print_r($data3);

        //exit; 

        $first_day_period = date('Y-m-01');

        $first_next_period = date("Y-m-d", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));

        $total_days = date("t");

        $last_day_period = date('Y-m')."-".$total_days;

        //exit;

        $current_days = 0;

        //fechas que inician y terminan en el periodo

        $query = 'select  sum(datediff(fecha_final,fecha_inicial)) as diff  from siniestro where fecha_inicial >= "'.$first_day_period.'" and fecha_final<= "'.$first_next_period.'" and aseguradora in ('.$aseguradora.')  LIMIT 1';
         
     
        $cdata = $sqlmodel->executeSql($query);

        $current_days += $cdata->diff;  
        //terminan en el periodo
        $query = 'select sum(datediff(fecha_final,"'.$first_day_period.'")) as diff  from siniestro where fecha_inicial < "'.$first_day_period.'" and fecha_final >= "'.$first_day_period.'" and fecha_final < "'.$first_next_period.'" and aseguradora in ('.$aseguradora.') LIMIT 1';

        $cdata = $sqlmodel->executeSql($query);

        $current_days += $cdata->diff;

        //no han terminado en el periodo
        $query = 'select sum(datediff("'.$last_day_period.'",fecha_inicial)) as diff  from siniestro where fecha_inicial > "'.$first_day_period.'" and fecha_final> "'.$first_next_period.'" and aseguradora in ('.$aseguradora.') LIMIT 1';

        $cdata = $sqlmodel->executeSql($query);

        $current_days += $cdata->diff;

        //echo $current_days;

        //exit;

        $saseguradora = $_SESSION['aseguradora'];

        $this->view("index",array("areachartvalues"=>$areachartvalues,"datearray"=>$datearray,"countarray"=>$countarray,
        "bar_labels"=>$bar_labels,"total_month_services"=>$total_month_services,"total_month_siniesters"=>$total_month_siniesters,"countarray2"=>$countarray2,"total_month_services_percent"=>$total_month_services_percent,"total_month_siniesters_percent"=>$total_month_siniesters_percent,
        "year_siniesters"=>$year_siniesters,"aseguradoras"=>$aseguradoras,"max_bar"=>$max_bar,"max_area"=>$max_area,"saseguradora"=>$saseguradora,"year_min"=>$year_min,"post"=>$_POST,"year_labels"=>$year_labels,"max_month_days"=>$max_month_days,"current_days"=>$current_days));
    }


    public function login()
    {
        $password = hash('ripemd160',md5($_POST['password']));
      
        $sqlmodel = new SQLModel("aoa_clientes.usuarios",$this->adapter);
        $user = $sqlmodel->login($_POST['name_login'],$password);

        //print_r($user);

        //exit;

        if($user == null)
        {
            $this->message->warning('El usuario no existe o escribio mal sus credenciales');
            $this->redirect('Index');
        }
        else
        {
        

            $update = date($user->updated);
            $current_date = date('Y-m-d H:m:s');
            $date1=date_create($update);
            $date2=date_create($current_date);
            $diff=date_diff($date1,$date2);


            if($user->psw_change != null or $diff->d>30)
            {
                //apcu_store('pre_session_user', $user->id);
                $_SESSION['pre_session_user'] = $user->id;
                $this->message->warning('Debe cambiar sus credenciales');
                $this->view('changePsw');
            }
            else{
                foreach($user as $key=>$temp)
                {
                    $_SESSION[$key] = $temp;
                }

                $modelaseguradora = new Aseguradoras($this->adapter);
                $aseguradora = $modelaseguradora->getById($_SESSION['aseguradora']);

                $_SESSION['ruta_foto'] = $aseguradora->emblema_f;

                $_SESSION['aseguradora'] = $this->change_for_entity($_SESSION['aseguradora']); 

                //print_r($_SESSION);
                //exit;               
                if($_SESSION['rol'] == 3)
                {
                    $this->redirect('Register','index');
                }   
                else
                {
                    $this->redirect('Index','home');    
                }
                
            }
        }
    }

    public function admin_change_aseguradora()
    {
        //print_r($_SESSION);
        $arra_post = explode(",", $_SESSION['aseguradora']);

        if($arra_post[1] == "entidad")
        {
            $sqlmodel = new SQLModel("undefined",$this->adapter);
            $sql = "SELECT group_concat(id) as asegs from aoacol_aoacars.aseguradora where entidad = ".$arra_post[1]." LIMIT 1";
            $composed = $sqlmodel->executeSql($sql);
            //print_r($composed);
            //exit;
            $_SESSION['aseguradoras'] = $composed->asegs;            
            $obsaseguradora =  explode(",",$composed->asegs);             
             $id = $obsaseguradora[0];                
        }
        else
        {
            $_SESSION['aseguradoras'] = $arra_post[0];
            $id = $arra_post[0];
        }

        $modelaseguradora = new Aseguradoras($this->adapter);        

        $aseguradora = $modelaseguradora->getById($id);
      
        $_SESSION['ruta_foto'] = $aseguradora->emblema_f;
        
        //$_SESSION['aseguradora'] = $this->change_for_entity($id);
      
    }



    public function view_changepsw()
    {
        $this->view('changePsw');
    }

    public function change_password()
    {
        if(!$_SESSION['pre_session_user'])
        {
            $this->message->warning('El usuario no existe o escribio mal sus credenciales');
            $this->redirect('Index');   
        }

        $password_prev = hash('ripemd160',md5($_POST['password_prev']));
        $password = md5($_POST['password']);        



        if($password_prev == $password)
        {
            $this->message->warning('No puede dejar la misma contraseña');
            $this->redirect('Index','view_changepsw');
        }

        $sqlmodel = new SQLModel("aoa_clientes.usuarios",$this->adapter);
        $user = $sqlmodel->getOne('id',$_SESSION['pre_session_user']);
 
        if($password_prev != $user->password)
        {
            $this->message->warning('La contraseña previa no corresponde intentelo nuevamente');
            $this->redirect('Index','view_changepsw');
        }
        else
        {

            $usuario = new Usuarios($this->adapter);
            $usuario->setId($_SESSION['pre_session_user']);
            $usuario->set_password($password,"null");
           
            foreach($user as $key=>$temp)
            {
                $_SESSION[$key] = $temp;
            }

            $modelaseguradora = new Aseguradoras($this->adapter);
            $aseguradora = $modelaseguradora->getById($_SESSION['aseguradora']);

            $_SESSION['ruta_foto'] = $aseguradora->emblema_f;
            
            $_SESSION['aseguradora'] = $this->change_for_entity($_SESSION['aseguradora']);

            $this->redirect('Index','home'); 
        }
    }

    function logout()
    {
        session_destroy();
        $this->redirect('Index');   
    }

     
    public function change_menu_state()
    {
        if($_SESSION['CURRENT_MENU_STATE']['menu_class'] == " ")
        {
            $menu = new menu_collapse();            
            $_SESSION['CURRENT_MENU_STATE'] = $menu->current_state(); 
        }
        else
        {
            $menu = new menu_open();            
            $_SESSION['CURRENT_MENU_STATE'] = $menu->current_state();
        }
    }

    public function change_for_entity($id)
    {
        $aseguradora = new Aseguradoras($this->adapter);
        $current_aseguradora = $aseguradora->getById($id);
        if($current_aseguradora->entidad != null)
        {
            return $current_aseguradora->entidad.','.'entidad';
        }
        else
        {
            return $current_aseguradora->id.','.'aseguradora';
        }
    }



 
}