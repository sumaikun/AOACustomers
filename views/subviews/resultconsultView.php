<table class="table ">
	<theader>
		<th>ID</th>
		<th>Nombre <br> Asegurado</th>
	</theader>
	<tbody>
		<?php if($siniestros!=null){ foreach($siniestros as $siniestro){  ?>
		<tr>
			<td><?php echo $siniestro->id ?></td>
			<td><?php echo $siniestro->asegurado_nombre ?></td>
		</tr>	
		<?php }} ?>
	</tbody>
</table>