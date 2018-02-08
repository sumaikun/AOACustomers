<style>
	.dataTables_info{
		margin-top: 1.6em;
	}
</style>
<table id="seg_table" style="font-size: 0.7em;" class="table table-borderes table-striped">
	<thead>
		<th>Fecha-Hora</th>
		<th>Usuario</th>
		<th>Descripción</th>
		<th>Tipo</th>
		<th>Tipificación</th>
		<th>Fecha<br>Compromiso</th>
		<th>Comp Cumplido</th>		
	</thead>
	<tbody>
		<?php if($seguimientos!=null){ foreach($seguimientos as $seguimiento){  ?>
		<tr>
			<td><?php echo $seguimiento->fecha." ".$seguimiento->hora ?> </td>
			<td><?php echo $seguimiento->usuario ?> </td>
			<td><?php echo $seguimiento->descripcion ?> </td>
			<td><?php echo $seguimiento->ntipo ?> </td>
			<td><?php echo $seguimiento->ntipi ?> </td>
			<td><?php echo (in_array($seguimiento->tipo,array("16","21"))?$seguimiento->fecha_compromiso:"")?> </td>
			<td><?php echo ($seguimiento->cumplido?"SI":"") ?> </td>					
		</tr>	
		<?php }} ?>
	</tbody>
</table>
<!-- (inlist($$seguimiento->tipo,'16,21')?$$seguimiento->fecha_compromiso:"") -->
<script>
 $('#seg_table').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json","pageLength": 10}});
</script>