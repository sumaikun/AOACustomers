<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/png" href="http://www.aoacolombia.com/assets/img/logo_footer.png" />
  <title>SACAP AOA</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="">
  <style>
    .btn:hover{
      background-color: #0B610B!important;
    }
    .log_btn{
       background-color: #0A0A2A !important; border-color: #0A0A2A; color:white;
    }
  </style>
  <div class="container">
    <?php
        $msg->display();
       echo  $_SERVER['HTTP_HOST'];
    ?>
    <br>
    <br>
    <div class="text-center">
      <image src="http://www.aoacolombia.com/assets/img/logo.png" class="img-responsive center-block">
    </image>
      <br>
      <br>
    <div class="card card-login mx-auto mt-5">
      <div class="card-header" style="background-color: #0B610B!important;">Login</div>
      <div class="card-body" style="background-color: #97af00!important;">
        <?php if($_SERVER['HTTP_HOST']=="sac.aoacolombia.com"): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
         <script>
           function onSubmit(token) {
             document.getElementById("demo-form").submit();
           }
         </script>
        <?php endif ?>

        <form method="post" action="<?php echo $helper->url("index","login"); ?>">
          <div class="form-group">
            <label for="exampleInputEmail1">Usuario</label>
            <input class="form-control" id="exampleInputEmail1" type="text" autocomplete="off" aria-describedby="emailHelp" placeholder="Usuario de login" name='name_login' maxlength="40" requried>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Contraseña" required>
          </div>
           <?php if($_SERVER['HTTP_HOST']=="sac.aoacolombia.com"){  ?>          
          <button class="btn log_btn g-recaptcha btn-block" data-sitekey="6LfQe0kUAAAAAIEhjVXl923H36LApinBbkz-eXww" data-callback='onSubmit' type="submit">Entrar</button>
           <?php } else{  ?>
           <button class="btn log_btn  btn-block"  type="submit">Entrar</button>
           <?php } ?>
        </form>
     
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>