  <?php include('subviews/header.php') ?>

  <style>
    label.form-control{
      /*background-color: #848484 !important;*/
      background-color: #A4A4A4 !important;
    }
     /*.load_table{
      display: none;
    }*/
   
  </style>
  
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Registros</a>
        </li>
        <li class="breadcrumb-item active">Reportes</li>
      </ol>
      
         <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Detalles de servicio          
        </div>
        <div class="card-body">
           <?php
              $msg->display();
          ?>
         
            <form method="post">
               <?php if($_SESSION['rol']==1): ?>
              <div class="form-group inner_img">
                <label class="form-control">Aseguradora</label>
                  <select  class="form-control" name="aseguradora_select"  required>
                      <option value="0">Selecciona</option>
                    <?php foreach($aseguradoras as $aseguradora) { ?>
                      <option value="<?php echo $aseguradora->id.','.$aseguradora->tipo ?>" <?php $currents = $aseguradora->id.','.$aseguradora->tipo; if($saseguradora == $currents): ?> 
                      selected <?php endif ?> > <?php echo $aseguradora->nombre ?> </option>
                    <?php } ?>
                  </select>
              </div>
               <?php endif ?>
               <div class="form-group">
                 <label class="form-control">Fecha Inicial</label>
                 <input class="form-control"  type="date" max=<?php echo date('Y-m-d'); ?> <?php if(isset($_POST['fecha1'])){ ?> value="<?php echo $_POST['fecha1'] ?>" <?php } ?> name="fecha1" id="fecha1">
               </div>
               <div class="form-group">
                 <label class="form-control">Fecha Final</label>
                 <input class="form-control" type="date" max=<?php echo date('Y-m-d'); ?> <?php if(isset($_POST['fecha2'])){ ?> value="<?php echo $_POST['fecha2'] ?>" <?php } ?> name="fecha2" id="fecha2">
               </div>
               <input type="hidden" name="type_of_filter" id="type_of_filter">
               <button type="submit" onclick="return filter_html()" class="btn btn-warning">Filtrar</button>
               <button type="submit" onclick="return filter_excel()" class="btn btn-success"><i class="fal fa-table"></i>Generar Excel</button>
            </form>
          <br>
          
          <script>
            
            function filter_html()
            {
              $("#type_of_filter").val(1);
              return true;
            }

            function filter_excel()
            {
              $("#type_of_filter").val(2);
              return true;
            }

          </script>

          <div>
            <div class="lds-css">
            <div class="lds-gear" style="100%;height:100%">
              <div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>
          </div>
        </div>

            <?php include('subviews/report_tableView.php') ?>


        </div>
        <div class="card-footer small text-muted">Ultimo siniestro el <?php echo $registros[0]->fec_siniestro; ?></div>
      </div>
     
    </div>
  </div>


    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <?php include('subviews/footer.php') ?>

<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"> </script>
<script>
  webshims.setOptions('forms-ext', {types: 'date'});
  webshims.polyfill('forms forms-ext');
  $.webshims.formcfg = {
  en: {
      dFormat: '-',
      dateSigns: '-',
      patterns: {
          d: "yy-mm-dd"
      }
  }
  };

</script>
<script>

   $( document ).ready(function(){
       $('#registers_table').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"}});
       //$(".load_table").show();
       $(".lds-css").fadeOut(5000, function() {
          //alert("faded out");
        });;
       $("html, body").animate({ scrollTop:  500}, 600);    
    });

   $("#fecha1").click(function(){
    $("#fecha2").prop('required',true);
  });
  
  $("#fecha2").click(function(){      
    $("#fecha1").prop('required',true);
  });

</script>


