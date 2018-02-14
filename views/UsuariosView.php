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
          <a href="#">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Administración</li>
      </ol>
      
         <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Usuarios
          <button onclick="create_user()">Crear</button>
        </div>
        <div class="card-body">
           <?php
              $msg->display();
          ?>
          <div class="table-responsive">
            <table class="table table-bordered" id="users_table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Nick</th>
                  <th>Aseguradora</th>
                  <th>Rol</th>
                  <th>Correo</th>
                  <th>opciones</th>                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>id</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Nick</th>
                  <th>Aseguradora</th>
                  <th>Rol</th>
                  <th>Correo</th>
                  <th>opciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php if($usuarios!=null){  foreach($usuarios as $usuario){  ?>
                <tr>
                  <td><?php echo $usuario->id ?></td>
                  <td><?php echo $usuario->nombres ?></td>
                  <td><?php echo $usuario->apellidos ?></td>
                  <td><?php echo $usuario->nombre_login ?></td>
                  <td><?php echo $asqlmodel->param_relation($usuario->aseguradora,"id","nombre") ?></td>
                  <td><?php echo $rsqlmodel->param_relation($usuario->rol,"id","nombre") ?></td>
                  <td><?php echo $usuario->email ?></td>
                  <td>
                    <?php unset($usuario->password); unset($usuario->created); unset($usuario->updated); ?>
                      <button onclick="edit_user(<?php echo str_replace('"',"'",json_encode($usuario)) ?>)" title="editar"> <i class="fa fa-fw fa-pencil"></i> </button> 
                      <a onclick="return confirm_click();" href="<?php echo $helper->url("User","delete"); ?>&id=<?php echo $usuario->id; ?>"><button title="eliminar"><i class="fa fa-fw fa-trash"></i></button></a>
                      <button onclick="add_password(<?php echo $usuario->id ?>)" title="asignar clave"> <i class="fa fa-fw fa-key"></i> </button>
                  </td>
                </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted"></div>
      </div>
     
    </div>
  </div>


    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <?php include('subviews/footer.php') ?>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
   <script>

    $( document ).ready(function(){
       $('#users_table').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"}});
    });

    function create_user()
    {
      $("#modal_create_user").modal('show');
    }

    function edit_user(user)
    {
      $("#edit_id").val(user.id);
      $("#edit_nombres").val(user.nombres);
      $("#edit_apellidos").val(user.apellidos);
      $("#edit_correo").val(user.email);
      $("#edit_aseguradora").val(user.aseguradora);
      $("#edit_nombre_login").val(user.nombre_login);
      $("#edit_rol").val(user.rol);      
      $("#modal_edit_user").modal('show');
    }

    function confirm_click(){return confirm("¿Esta seguro?");}
       
  </script>

    <!-- Modal -->
  <div class="modal fade" id="modal_create_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="post" action="<?php echo $helper->url("User","create"); ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label class="form-control">Nombres</label>
                <input class="form-control" type="text" maxlength="200" name="nombres" required>
            </div>
            <div class="form-group">
                <label class="form-control">Apellidos</label>
                <input class="form-control" type="text" maxlength="200" name="apellidos" required>
            </div>
            <div class="form-group">
                <label class="form-control">Nombre Login</label>
                <input class="form-control" type="text" maxlength="15" name="nombre_login" required>
            </div>
            <div class="form-group">
                <label class="form-control">Correo</label>
                <input class="form-control" type="email" maxlength="100" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-control">Aseguradora</label>
                <select  class="form-control" name="aseguradora" required>
                    <option>Selecciona</option>
                  <?php foreach($aseguradoras as $aseguradora) { ?>
                    <option value="<?php echo $aseguradora->id ?>"><?php echo $aseguradora->nombre ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-control">Rol</label>
                <select class="form-control" name="rol" required>
                  <option>Selecciona</option>
                  <option value="1">Administrador</option>
                  <option value="2">Cliente</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>     
    </div>
  </div>


 <!-- Modal -->
  <div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="post" action="<?php echo $helper->url("User","update"); ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" id="edit_id" name="id">
          <div class="modal-body">
            <div class="form-group">
                <label class="form-control">Nombres</label>
                <input class="form-control" id="edit_nombres" type="text" maxlength="200" name="nombres" required>
            </div>
            <div class="form-group">
                <label class="form-control">Apellidos</label>
                <input class="form-control" id="edit_apellidos" type="text" maxlength="200" name="apellidos" required>
            </div>
            <div class="form-group">
                <label class="form-control">Nombre Login</label>
                <input class="form-control" id="edit_nombre_login" type="text" maxlength="15" name="nombre_login" required>
            </div>
            <div class="form-group">
                <label class="form-control">Correo</label>
                <input class="form-control" id="edit_correo" type="email" maxlength="100" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-control">Aseguradora</label>
                <select  class="form-control" id="edit_aseguradora" name="aseguradora" required>
                    <option>Selecciona</option>
                  <?php foreach($aseguradoras as $aseguradora) { ?>
                    <option value="<?php echo $aseguradora->id ?>"><?php echo $aseguradora->nombre ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-control">Rol</label>
                <select class="form-control" id="edit_rol" name="rol" required>
                  <option>Selecciona</option>
                  <option value="1">Administrador</option>
                  <option value="2">Cliente</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </form>
      </div>      
    </div>
  </div>

   <!-- Modal -->
  <div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="post" onsubmit="return check_passwords()" action="<?php echo $helper->url("User","set_password"); ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asignar Contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" id="psw_id" name="id">
          <div class="modal-body">
            <div class="form-group">
              <label class="form-control">Contraseña</label>
              <input type="password" class="form-control" name="password" maxlength="10">
            </div>
            <div class="form-group">
              <label class="form-control">Confirmar contraseña</label>
              <input type="password" class="form-control" name="password2" maxlength="10">
            </div>
            <div class="form-group">
              <label class="form-control">¿Debe cambiar la contraseña?</label>
              <input type="checkbox" class="form-control" name="must_changue" >
            </div>             
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Asignar</button>
          </div>
        </form>
      </div>      
    </div>
  </div>

  <script>
    function add_password(id)
    {
      $("#psw_id").val(id);
      $("#modal_password").modal('show');
    }

    function check_passwords()
    {

      var errors = [];

      psw1 = $("input[name='password']").val();
      psw2 = $("input[name='password2']").val();
      

      re = /[A-Z]/;
     
      if(!re.test(psw1)) {
        errors.push("La contraseña debe tener al menos una mayuscula (A-Z)!");        
   
      }

      re = /[a-z]/;
     
      if(!re.test(psw1)) {
        errors.push("La contraseña debe tener al menos una minuscula (a-z)!");        
   
      }

      re = /[0-9]/;

      if(!re.test(psw1)) {
        errors.push("La contraseña debe tener al menos un numero!");      
   
      }

      re = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

      if(!re.test(psw1)) {
        errors.push("La contraseña debe tener al menos un caracter especial!");      
   
      }      

      if(psw1.length < 7)
      {
        errors.push("La contraseña debe tener al menos 7 digitos!");      
    
      }

      if(psw1 != psw2)
      {
        errors.push("No escribio contraseñas iguales!");      
   
      }

      //alert(errors.length);

      if(errors.length == 0)
      {
        return true;
      }
      else
      {
         errors_string = "";

        errors.forEach(function(element) {
            errors_string += element+"\n" ;
        });

        alert(errors_string);

        return false;
      }  
        
      
    }
  </script>


