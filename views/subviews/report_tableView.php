<div class="table-responsive load_table">
            <table style="font-size: 0.65em;" class="table table-bordered" id="registers_table" width="100%" cellspacing="0">
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
                  <td><?php $linea = $lsqlModel->param_relation_like($registro->placa,"placa","linea"); ?>
                  <?php if($linea != null ) echo $rsqlModel->param_relation($linea,"id","nombre") ?></td>
                  <td><?php echo $registro->fecha_inicial ?></td>
                  <td><?php echo $registro->id ?></td>
                  <td><?php echo $registro->fecha_final ?></td>
                  <td><?php echo (isset($estados_siniestro[$registro->estado])?$estados_siniestro[$registro->estado]:"") ?></td>
                </tr>
                <?php }} ?>
              </tbody>
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
            </table>
          </div>