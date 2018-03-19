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

class ChartController extends ControladorBase{
     
    public $conectar;
    public $adapter;    
  
     
    public function __construct() {

        parent::__construct();       
    
        $this->conectar=new Conectar();
        $this->adapter=$this->conectar->conexion();
        $this->message = new FlashMessages();
        $this->EntidadesAseguradoras = new EntidadesAseguradoras($this->adapter);
      
    }

    public function areachart()
    {
    	$request_body = file_get_contents('php://input');

    	$request = json_decode($request_body);

    	//print_r($data);    	

    	$sqlmodel = new SQLModel('undefined',$this->adapter);

    	$aseguradora = $_SESSION['aseguradoras'];

    	$areachartvalues = [];
        $datearray = array();
        $countarray = array();
        $countarray2 = array();
      
        $max_area = 0;

        if(isset($request->week) and !empty($request->week))
        {
            $week = explode('-',$request->week);
        
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
             //$inarray = array("date"=>$date,"count"=>$data->count,"count"=>$data2->count);
             //array_push($areachartvalues, $inarray);
             array_push($datearray, $date);
             array_push($countarray, $data->count);
             array_push($countarray2, $data2->count);     
        }  

        $response = array('dates'=>$datearray,"servicios"=>$countarray,"siniestros"=>$countarray2,"max_area"=>$max_area);
        echo json_encode($response);       
        
    }

    public function barchart()
    {
    	$request_body = file_get_contents('php://input');

    	$request = json_decode($request_body);

    	$sqlmodel = new SQLModel('undefined',$this->adapter);

    	$aseguradora = $_SESSION['aseguradoras'];

    	 $spanish_months = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");        
      

        if(isset($request->month))
        {                   
            $month_date = $request->month;
            $month = $request->month;
            $month = explode('-',$month);           
            $month = $month[1];  
        }
        else
        {
        	$year = date('Y');
            $month = date('m');
            $month_date = $year."-".$month;    
        }
        

        $bar_labels = array();
        $total_month_siniesters = array();
        $total_month_services = array();
        $total_month_siniesters_percent = array();
        $total_month_services_percent = array();

        $current_month = $spanish_months[intval($month)];

        array_push($bar_labels, $current_month);

        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fec_siniestro like '%$month_date%' and aseguradora in ($aseguradora)";
     
        $data1 = $sqlmodel->executeSql($sql);

       

        $sql = "SELECT COUNT(id) as count FROM aoacol_aoacars.siniestro where fecha_inicial like '%$month_date%' and aseguradora in ($aseguradora)";
   
        $data2 = $sqlmodel->executeSql($sql);

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

        $response = array('month'=>$bar_labels,"siniestros"=>$total_month_siniesters,'servicios'=> $total_month_services,'siniestros_percent'=>$total_month_siniesters_percent,'services_percent'=>$total_month_services,'max_bar'=>$max_bar);
        echo json_encode($response);  
    }

    public function piechart()
    {
    	$aseguradora = $_SESSION['aseguradoras'];

    	$request_body = file_get_contents('php://input');

    	$request = json_decode($request_body);

    	if(isset($request->year))
        {
            $year = $request->year; 
        }
        else{
            $year = date('Y');
        }

    	$sqlmodel = new SQLModel('undefined',$this->adapter);

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

        $response = array('year'=>$year_labels,"datos"=>$year_siniesters);
        echo json_encode($response);  
    }
}