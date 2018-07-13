<?php //print_r($_SESSION)
    if(strpos($_SERVER['HTTP_USER_AGENT'],'Safari') and !strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')){
        $wsafari = true;
      }
      else{
        $wsafari = false;
      }
      
?>


<?php 
  //lamento el codigo de servidor en una vista se como se deberia hacer pero al menos por hoy me la pela y ya casi son las 6
  function base64_encode_image($filename=string,$filetype=string) {
      //echo "<br>";
      if ($filename) {
           $remoteFile = $filename;
          $ch = curl_init($remoteFile);
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HEADER, true);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
          $data = curl_exec($ch);
          curl_close($ch);
          if ($data === false) {
            echo 'cURL failed';
            exit;
          }

          $contentLength = 'unknown';
          $status = 'unknown';
          if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
            $status = (int)$matches[1];
          }
          if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
            $contentLength = (int)$matches[1];
          }

          //echo 'HTTP Status: ' . $status . "\n";
          //echo 'Content-Length: ' . $contentLength;
          if(!is_numeric($contentLength))
          {
            $contentLength = 0;
          }
          $imgbinary = fread(fopen($filename, "r"), $contentLength+100);
          return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
      }
  }
  
  $url = "http://app.aoacolombia.com/Control/operativo/".$_SESSION['ruta_foto'];

  $image_64 = base64_encode_image($url,"png");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sistemas de clientes AOA</title>

  <!--Angular-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js" ></script>

  <script src='js/Modules/app.js'></script>
  <script src='js/Services/ChartService.js'></script>
  <script src='js/Services/SystemService.js'></script>
  <script src='js/Services/RegisterService.js'></script>
  <script src='js/Controllers/ChartController.js'></script>
  <script src='js/Controllers/RegisterController.js'></script>


  <link rel="shortcut icon" type="image/png" href="assets/img/icon.png" />

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <!-- Loading gear -->
  <link href="css/gear.css" rel="stylesheet">
</head>

<style>
  .menu_l:hover{
    background-color: #0B610B !important;
  }
  .rotate90 {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
    margin-left: -0.7em !important;
    max-width: 10em !important;
    height: 2.6em !important;
   
    
  }

   .first_label_normal
  {
     /*margin-top: 1.4em !important;*/
  }

  .first_label_collapse
  {
    margin-top: 2em !important;
  }

  .normal_pos{
    max-width: 245px;
    height: 125px;
    margin-top: 15px;
  }

  .second_label_normal
  {
     /*margin-top: 1.4em !important;*/
  }

  .second_label_collapse
  {
     /*margin-top: 10em !important;
     height: 75px !important;*/
  }

</style>

<?php if($wsafari): ?>
  <?php //echo "en condicion"; exit; ?>
  <style>
    .navbar-collapse{
      margin-left: 40em;
    }
    #search_control{
      width:9em;
    }
    .navbar-sidenav
    {
        float: left;
        clear: left;
        display: block
    }
  </style>
<?php endif  ?>

<body class="fixed-nav sticky-footer bg-dark <?php echo $_SESSION['CURRENT_MENU_STATE']['menu_class'] ?>" id="page-top">

  <?php //print_r($_SESSION['CURRENT_MENU_STATE']); ?>


  <!-- Navigation-->
  <nav style="background-color: #0B610B!important;" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php echo $helper->url("index","home"); ?>">AOA Administración Operativa Automotriz</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul  style="background-color: #97af00!important;" class="navbar-nav navbar-sidenav" id="exampleAccordion">

        <li style="background-color:#F5FBEF;">
          <img  class="responsive <?php echo $_SESSION['CURRENT_MENU_STATE']['img_class'] ?>" id="aoa_image" src="assets/img/logo.png">
          <br>
          <br>
        </li>

        <?php if($_SESSION['rol']==1): ?>
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Adminsitración">
          <a style="color:white;" class="nav-link" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion" aria-expanded="false">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Administración</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents" style="">
            <li>
              <a href="<?php echo $helper->url("User","index"); ?>">Usuarios</a>
            </li>
            <li>
              <a href="<?php echo $helper->url("Tool","entities"); ?>">Aseguradoras</a>
            </li>
          </ul>        
        </li>
       <?php endif ?>
      <?php if(in_array($_SESSION['rol'], array(1,2))): ?>
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Tablero">
          <a style="color:white;" class="nav-link" href="<?php echo $helper->url("index","home"); ?>">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Tablero</span>
          </a>
        </li>
     
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Reportes">
          <a style="color:white;" class="nav-link" href="<?php echo $helper->url("Report"); ?>">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Reportes</span>
          </a>
        </li>      
     
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Consultas">
          <a style="color:white;" class="nav-link" href="<?php echo $helper->url("Consult"); ?>">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Consultas</span>
          </a>
        </li>
        <?php endif ?>

        <?php if(in_array($_SESSION['rol'], array(1,2,3))): ?>
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Consultas">
          <a style="color:white;" class="nav-link" href="<?php echo $helper->url("Register"); ?>">
            <i class="fa fa-upload" aria-hidden="true"></i>
            <span class="nav-link-text">Registro de siniestros</span>
          </a>
        </li>
        <?php endif ?>
        
        <li style="background-color:#97af00; background-image: url('<?php echo $image_64 ?>'); background-repeat: no-repeat; background-size: 100% 100%; height:165px;" id="second-image">
              
              <!--<img style="margin-top: 0.8em;" class="responsive <?php //echo $_SESSION['CURRENT_MENU_STATE']['img_class'] ?>" id="otheremp_image" src="http://app.aoacolombia.com/Control/operativo/<?php //echo $_SESSION['ruta_foto'] ?>">-->        
        </li>       
      </ul>

      <ul style="background-color: #0B610B !important" class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" onclick="trigger_transform()" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>

      <script>    

        function trigger_transform()
        {
          //alert("transformed");

          $.post( "<?php echo $helper->url("Index","change_menu_state"); ?>",{}, function( data ){});

          if($("#aoa_image").hasClass('normal_pos'))
          {
            $("#aoa_image").addClass("first_label_collapse");
            $("#aoa_image").removeClass('normal_pos');
            $("#aoa_image").addClass('rotate90');
            $("#otheremp_image").removeClass('normal_pos');
            $("#otheremp_image").addClass('rotate90');
            //$("#second-image").removeClass("second_label_normal");      
            //$("#second-image").addClass("second_label_collapse");
            
          }
          else
          {         
            $("#aoa_image").removeClass('rotate90');
            $("#aoa_image").addClass('normal_pos');
            $("#otheremp_image").removeClass('rotate90');
            $("#otheremp_image").addClass('normal_pos');
            $("#aoa_image").removeClass("first_label_collapse");
            //$("#second-image").removeClass("second_label_collapse");
            //$("#second-image").addClass("second_label_normal");   
          }
          
        }
      </script>

      <ul class="navbar-nav ml-auto">
    
         <span class="pull-right" style="margin-top: 0.4em; color:white"> 
           <?php echo $_SESSION['nombres']." ".$_SESSION['apellidos']; ?>
         </span>
        <li class="nav-item">          
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </nav>
 
