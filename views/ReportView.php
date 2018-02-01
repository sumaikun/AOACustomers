  <?php include('subviews/header.php') ?>

  <style>
    label.form-control{
      /*background-color: #848484 !important;*/
      background-color: #A4A4A4 !important;
    }
     .load_table{
      display: none;
    }
   
  </style>
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
                      <option value="<?php echo $aseguradora->id ?>" <?php if($saseguradora == $aseguradora->id): ?> 
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
               <button type="submit" class="btn btn-warning">Filtrar</button>
            </form>
          <br>
         

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

          <div class="table-responsive load_table">
            <table class="table table-bordered" id="registers_table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>placa</th>
                  <th>Nombre<br>Cliente</th>
                  <th>Identificación</th>
                  <th>Celular</th>
                  <th>Ciudad</th>
                  <th>Fecha<br>Notificación</th>
                  <th>Dirección</th>
                  <th>Vehiculo<br>Reemplazo</th>
                  <th>Entrega</th>
                  <th>Dias<br>prestados</th>
                  <th>Fecha<br>Devolución</th>
                  <th>Estado</th>                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>id</th>
                  <th>placa</th>
                  <th>Nombre<br>Cliente</th>
                  <th>Identificación</th>
                  <th>Celular</th>
                  <th>Ciudad</th>
                  <th>Fecha<br>Notificación</th>
                  <th>Dirección</th>
                  <th>Vehiculo<br>Reemplazo</th>
                  <th>Entrega</th>
                  <th>Dias<br>prestados</th>
                  <th>Fecha<br>Devolución</th>
                  <th>Estado</th>
                </tr>
              </tfoot>
              <tbody>
                <?php if($registros!=null){  foreach($registros as $registro){  ?>
                <tr>
                  <td><?php echo $registro->id ?></td>
                  <td><?php echo $registro->placa ?></td>
                  <td><?php echo $registro->asegurado_nombre ?></td>
                  <td><?php echo $registro->asegurado_id ?></td>
                  <td><?php echo $registro->declarante_celular ?></td>
                  <td><?php if(isset($ciudades[$registro->ciudad_siniestro])) {echo $ciudades[$registro->ciudad_siniestro]; } else{$registro->ciudad_siniestro; } ?></td>
                  <td><?php echo $registro->fec_siniestro ?></td>
                  <td><?php echo $registro->asegurado_direccion ?></td>
                  <td><?php echo $rsqlModel->param_relation($lsqlModel->param_relation_like($registro->placa,"placa","linea"),"id","nombre") ?></td>
                  <td><?php echo $registro->fecha_inicial ?></td>
                  <td><?php echo $registro->id ?></td>
                  <td><?php echo $registro->fecha_final ?></td>
                  <td><?php echo $estados_siniestro[$registro->estado] ?></td>
                </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Ultimo siniestro el <?php echo $registros[0]->fec_siniestro; ?></div>
      </div>
     
    </div>
  </div>


    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <?php include('subviews/footer.php') ?>

<script>

   $( document ).ready(function(){
       $('#registers_table').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"}});
       $(".load_table").show();
       $(".lds-css").fadeOut(5000, function() {
          //alert("faded out");
        });;
    });

   $("#fecha1").click(function(){
    $("#fecha2").prop('required',true);
  });
  
  $("#fecha2").click(function(){      
    $("#fecha1").prop('required',true);
  });

</script>


