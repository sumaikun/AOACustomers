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
    <tr>
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
        <button onclick="update_entity('<?php echo $entidad->id ?>')"  title="Editar"><i class="fa fa-pencil"></i></button>
      </td>
     </tr> 
     <?php }} ?>
  </tbody>                                        
</table>