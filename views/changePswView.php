<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <?php
        $msg->display();

        //echo apcu_fetch('pre_session_user');
    ?>
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post" onsubmit="return check_passwords()" action="<?php echo $helper->url("index","change_password"); ?>">         
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input class="form-control" id="exampleInputPassword1" name="password_prev" type="password" placeholder="Contraseña" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Nueva Contraseña</label>
            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="nueva Contraseña" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Confirmar</label>
            <input class="form-control" id="exampleInputPassword1" name="password2" type="password" placeholder="Confirmar" required>
          </div>          
          <button class="btn btn-primary btn-block" type="submit">Cambiar</button>
        </form>
     
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script>
     function check_passwords()
    {

      psw1 = $("input[name='password']").val();
      psw2 = $("input[name='password2']").val();
      

      re = /[A-Z]/;
     
      if(!re.test(psw1)) {
        alert("Error: La contraseña debe tener al menos una mayuscula (A-Z)!");        
        return false;
      }
      re = /[0-9]/;

      if(!re.test(psw1)) {
        alert("Error: La contraseña debe tener al menos un numero!");      
        return false;
      }

      if(psw1.length < 7)
      {
        alert("Error: La contraseña debe tener al menos 7 digitos!");      
        return false; 
      }

      if(psw1 != psw2)
      {
        alert("Error: No escribio contraseñas iguales!");      
        return false;
      }        
        return true;
      
    }
  </script>
</body>

</html>