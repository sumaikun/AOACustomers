<table class="table table-borderes table-striped">
	<thead>
		<th>Ciudad</th>
		<th>Fecha</th>
		<th>Estado</th>
		<th>Dias</th>
	</thead>
	<tbody>
		<?php if($servicios!=null){ foreach($servicios as $servicio){  ?>
		<tr>
			<td><?php echo $servicio->noficina ?> </td>
			<td><?php echo $servicio->fecha." ".$servicio->hora ?> </td>
			<td><?php echo $servicio->nestado ?></div></td>
			<td><?php echo $servicio->dias_servicio ?></td>		
		</tr>	
		<?php }} ?>
	</tbody>
</table>