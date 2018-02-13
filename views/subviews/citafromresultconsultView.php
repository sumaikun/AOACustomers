
<div class="normal_plate" style="width:22em; height:15em;" ></div>
<div class="normal_plate_letter" style="margin-top: -2.6em; font-size: 5em;" ><?php if($cita != null){ echo $cita->placa; }  ?></div>
<br>
<table class="table table-striped">
	<tr>
		<td style="font-weight: bold; font-size: 0.7em;">Fecha</td>
		<td style="font-weight: bold; font-size: 0.7em;">
			<?php if($cita != null){ echo $cita->fecha." ".$cita->hora; }  ?>
		</td>
	</tr>
	<tr>
		<td style="font-weight: bold; font-size: 0.7em;">Conductor</td>
		<td style="font-weight: bold; font-size: 0.7em;">
			<?php if($cita != null){ echo $cita->conductor; }  ?>
		</td>
	</tr>
</table>



