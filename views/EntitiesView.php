  <?php include('subviews/header.php') ?>

  <style>
    label.form-control{
      /*background-color: #848484 !important;*/
      background-color: #A4A4A4 !important;
    }
  </style>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Entidades</a>
        </li>
        <li class="breadcrumb-item active">Administración</li>
      </ol>
      
         <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> </div>
        <div class="card-body">
           <?php
              $msg->display();
          ?>

          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div id="accordion">
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Creación de entidades
                        </button>
                      </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                          <div class = "container">
                            <button onclick="new_entity()" class="btn btn-primary">Crear entidad</button>
                            <br><br>
                            <div class="row">
                              <div class="col-md-3" id="entidades_table">
                                  <table class=" table table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <th colspan="3">
                                            Nombre
                                          </th>
                                         <tr> 
                                      </thead>
                                      <tbody>
                                        <?php if($entidades != null){foreach($entidades as $entidad){  ?>
                                        <tr onclick="look_for_aseguradoras('<?php echo $entidad->id ?>')" >
                                          <td>
                                            <?php echo $entidad->nombre ?>
                                          </td>
                                          <td>
                                            <form method="post" onsubmit="return delete_entity()" action="<?php echo $helper->url("Tool","delete_entity"); ?>">
                                              <input type="hidden" name="id" value="<?php echo $entidad->id ?>">
                                              <button  title="Eliminar">X</button>
                                            </form>
                                          </td>
                                          <td>  
                                            <button onclick="update_entity('<?php echo $entidad->id ?>')" title="Editar"><i class="fa fa-pencil"></i></button>
                                          </td>
                                         </tr> 
                                         <?php }} ?>
                                      </tbody>                                        
                                  </table>
                              </div>
                              <div class="row col-md-9" style="font-size: 0.6em;">
                                  <?php foreach($aseguradoras as $aseguradora){  ?>
                                        <fieldset class="col-sm-3">
                                         <label>
                                            <input type="checkbox" value="<?php echo $aseguradora->id; ?>" class="aseguradoras"  name="aseguradoras[]"/>
                                            <span><?php echo $aseguradora->nombre; ?></span>
                                         </label>
                                      </fieldset>
                                  <?php } ?>                                                                     
                                </div>
                              </div>
                            </div>                        
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
            </div>            
          </div>
        <div class="card-footer small text-muted"></div>
      </div>

       
     
    </div>
  </div>


 <div id="Modal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="form-control">Nombre de la entidad</label>
          <input class="form-control" id="nombre_entidad" type="text" max="150">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="post_new_entity()" data-dismiss="modal">Crear</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


  <script>

      function new_entity()
      {
          $("#Modal1").modal("show");
          
      }

      function post_new_entity()
      {
        console.log();

        if($('.aseguradoras:checked').serialize() == "" ||  $('.aseguradoras:checked').serialize() == null)
        {
          return alert("Debe seleccionar primero las aseguradoras para generar una entidad");
        }

        if($("#nombre_entidad").val()=="" || $("#nombre_entidad").val() == null)
        {          
          return alert("El nombre de la entidad no puede ir vacio");
        }
        
        $.post( "<?php echo $helper->url("Tool","save_entity"); ?>",{aseguradoras:$('.aseguradoras:checked').serialize(),nombre:$("#nombre_entidad").val()},function( data ) {
              alert(data);
              get_entities();
          });  
      }


      function update_entity(id)
      {
        if($('.aseguradoras:checked').serialize() == "" ||  $('.aseguradoras:checked').serialize() == null)
        {
          return alert("Debe seleccionar primero las aseguradoras para actualizar entidad");
        }
    
        
        $.post( "<?php echo $helper->url("Tool","update_entity"); ?>",{aseguradoras:$('.aseguradoras:checked').serialize(),id:id},function( data ) {
              alert(data);
              get_entities();
          }); 
      }

      function get_entities()
      {
        $.post( "<?php echo $helper->url("Tool","get_entities"); ?>",{},function( data ) {
              $("#entidades_table").html(data);
          });  
      }


      function delete_entity()
      {
        if(confirm("¿Esta seguro de borrar esta entidad?, esto dejara libre las aseguradoras relacionadas"))
        {
          return true;
        }
        else
        {
          return false;
        }

      }

      function look_for_aseguradoras(id)
      {
        $('.aseguradoras').prop('checked', false);
        $.post( "<?php echo $helper->url("Tool","look_for_aseguradoras"); ?>",{id:id},function( data ) {
              jQuery.each(JSON.parse(data), function(key,value) {
                $('input[type=checkbox][value='+value.id+']').prop('checked', true);
                console.log(value.id);
              });
          });          
      }

      
  </script>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <?php include('subviews/footer.php') ?>


