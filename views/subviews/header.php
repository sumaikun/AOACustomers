<?php //print_r($_SESSION)
    if(strpos($_SERVER['HTTP_USER_AGENT'],'Safari') and !strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')){
        $wsafari = true;
      }
      else{
        $wsafari = false;
      }
      
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
    margin-top: 2em !important;
    
  }

  .normal_pos{
    max-width: 245px;
    height: 125px;
    margin-top: 15px;
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
    <a class="navbar-brand" href="<?php echo $helper->url("index","home"); ?>">AOA administración operativa Automotriz</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul  style="background-color: #97af00!important;" class="navbar-nav navbar-sidenav" id="exampleAccordion">

        <li style="background-color:#F5FBEF;">
          <img  class="responsive <?php echo $_SESSION['CURRENT_MENU_STATE']['img_class'] ?>" id="aoa_image" src="http://www.aoacolombia.com/assets/img/logo.png">
          <br>
          <br>
        </li>

        <?php if($_SESSION['rol']==1): ?>
        <li class="nav-item menu_l" data-toggle="tooltip" data-placement="right" title="Usuarios">
          <a style="color:white; "  class="nav-link" href="<?php echo $helper->url("User","index"); ?>">
            <i class="fa fa-fw fa-user"></i>
            <span  class="nav-link-text">Usuarios</span>
          </a>
        </li>
       <?php endif ?>

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

        <!--
        <li style="background-color:#F5FBEF;">
              <img  class="responsive <?php echo $_SESSION['CURRENT_MENU_STATE']['img_class'] ?>" id="otheremp_image" src="http://app.aoacolombia.com/Control/desarrollo/<?php echo $_SESSION['ruta_foto'] ?>">
        
        </li>
        -->
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
            $("#aoa_image").removeClass('normal_pos');
            $("#aoa_image").addClass('rotate90');  
          }
          else
          {
            $("#aoa_image").removeClass('rotate90');
            $("#aoa_image").addClass('normal_pos'); 
          }
          
        }
      </script>

      <ul class="navbar-nav ml-auto">
        <!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        -->
        <!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li>
        <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" id="search_control" type="text" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
 