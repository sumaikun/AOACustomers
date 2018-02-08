<style>
	.dataTables_info{
		margin-top: 1.6em;
	}
</style>
<table id="obs_table" style="font-size: 0.7em;" class="table table-borderes table-striped">
	<thead>
		<th>Ordenar</th>		
	</thead>
	<tbody>
		<?php if($obs!=null){ foreach($obs as $ob){  ?>
		<tr>
			<td><?php echo $ob ?> </td>					
		</tr>	
		<?php }} ?>
	</tbody>
</table>
<script>
 $('#obs_table').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json","pageLength": 5}});
</script>