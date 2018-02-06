 <style>
 .min_plate
    {
       background-image: url("Images/carplate.png");
       background-repeat: no-repeat;
       background-position: center; 
       text-align: center;      
       color: black;
       font-weight: bold;      
       font-family: LicensePlate;
       background-size: 60px 30px;;
    }

    .panel-head-services{
    	/*background-color: #01DF3A;*/
    	text-align: center;
    	font-weight: bold;
    	border-radius: 1em;
	    border: 0.1em solid #73AD21;
	    padding: 0.3em;  
    }

    .panel-min-text{
    	font-size: 0.7em;
    	text-align: center;
    }
</style>    
<table class="table table-bordered table-hover">
	<theader>
		<th>Aseguradora</th>
		<th>Siniestro</th>
		<th>Placa</th>
		<th>Nombre <br> Asegurado</th>
		<th>Número <br>de identidad</th>
		<th>Ingreso</th>
	</theader>
	<tbody>
		<?php if($siniestros!=null){ foreach($siniestros as $siniestro){  ?>
		<tr ondblclick="siniester_info(<?php echo $siniestro->id ?>)">
			<td><?php echo $aseguradoras[$siniestro->aseguradora] ?> </td>
			<td><?php echo $siniestro->numero ?> </td>
			<td><div class="min_plate"><?php echo $siniestro->placa ?></div></td>
			<td><?php echo $siniestro->asegurado_nombre ?></td>
			<td><?php echo $siniestro->asegurado_id ?></td>
			<td><?php echo $siniestro->ingreso ?></td>
		</tr>	
		<?php }} ?>
	</tbody>	
</table>
*Haz doble click en alguno de los resultados para mas opciones.


<script>
	function siniester_info(Sini)
	{
		 $.post( "<?php echo $helper->url("Consult","get_services"); ?>",{siniestro:Sini}, function( data ) {
        	$("#ajax-services-content").html(data);
        	$("#myModal").modal('show');
    	});
		
	}

	$(window).bind('hashchange', function() {
		var type = window.location.hash.substr(1);
	 	alert(type);
	});
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consulta de siniestros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-6 col-lg-6 col-sm-6 ">
        	<div class="panel panel-primary">
		      <div class="panel-head-services">Servicio</div>
		      <div class="panel-body">
		      	<div class="row container">
			      	<div class="col-md-6 col-lg-6 col-sm-6 panel-min-text">
			      		<a href="#observaciones" style="text-decoration:none">Ver Observaciones</a>
			      	</div>
			      	<div class="col-md-6 col-lg-6 col-sm-6 panel-min-text">
			      		<a href="#seguimientos" style="text-decoration:none">Ver Seguimientos</a>
			      	</div>
			      	<div class="col-md-12 col-lg-12 col-sm-12 panel-min-text">
			      		<div id="ajax-services-content"></div>
			      	</div>
		      	</div>
		      </div>
		    </div>
        </div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>