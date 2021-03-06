  <?php include('subviews/header.php') ?>

  <style>
    
    label.form-control
    {
      background-color: #BDBDBD !important;
    }

    @font-face {
    font-family: "LicensePlate";
    src: url(assets/fonts/LicensePlate.ttf) format("truetype");
    }

    #placa_result
    {
       background-image: url("Images/carplate.png");
       background-repeat: no-repeat;
        background-position: center; 
      text-align: center;
      height: 3em;
      color: black;
      font-weight: bold;
      font-size: 5em;
      font-family: LicensePlate;
    }

  </style>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Consulta</a>
        </li>
        <li class="breadcrumb-item active">Consulta de siniestros</li>
      </ol>
      
         <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-arrow-down"></i> Consultas         
        </div>
        <div class="card-body">
           <?php
              $msg->display();
          ?>
            <div class="container text-center">
              <form onsubmit="return fake_form()">
                <div class="form-group">
                  <strong><label >Placa</label></strong>
                  <br>
                  <input type="text" style="text-align: center;"  id="placa"  maxlength="6" autocomplete="off">
                </div>
                <div class="form-group">
                  <strong><label>Cedula</label></strong>
                  <br>
                  <input type="text" id="cedula"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" style="text-align: center;"  maxlength="10" autocomplete="off">
                </div>  
                <div class="form-group">
                  <strong><label >Poliza</label></strong>
                  <br>
                  <input type="text" id="poliza" style="text-align: center;" maxlength="30"  autocomplete="off">
                </div>
                <div class="form-group">
                  <button class="btn btn-success" onclick="consult_data()">Consultar</button>
                </div> 
              </form>
            </div>
            <div class="table-responsive">
              <div id="ajax-content">

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>       


  <?php include('subviews/footer.php') ?>

<script type="text/javascript">
  function consult_data()
  {
    if($("#placa").val()!= "" && $("#placa").val().length<6)
    {      
      alert("Placa : Deben haber por lo menos 6 digitos");
      return false;
    }
    if($("#cedula").val()!= "" && $("#cedula").val().length<6)
    {
      alert("Cedula : Deben haber por lo menos 6 digitos");
      return false;
    }
    if($("#poliza").val()!= "" && $("#poliza").val().length<4)
    {
      alert("Poliza : Deben haber por lo menos 4 digitos");
      return false;
    }

    $.post( "<?php echo $helper->url("Consult","consult"); ?>",{placa:$("#placa").val(),cedula:$("#cedula").val(),poliza:$("#poliza").val()}, function( data ) {
        $("#ajax-content").html(data);
    });
  }

  function fake_form()
  {
    return false;
  }
</script>
