 
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
							 		
	$params = array($_SESSION['peri_codi']);
	$sql="{call curs_view_promoc(?)}";
	$curs_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?>

<table class="table_striped" id="curs_promoc_table">
 <thead>
  <tr>
    <th >Listado de Cursos </td>
    <th width="21%">Nivel</td>
    <th width="21%">Valor Promoción</td>
    <th width="21%">Opciones</td>
  </tr>
</thead>
<tbody>
 <?php  while ($row_curs_view = sqlsrv_fetch_array($curs_view)) { $cc +=1; ?>
  <tr> 
   <td> 
   <?= $row_curs_view["curs_deta"]; ?>
     </td>
    <td width="25%" align="center" valign="middle">
		<?= $row_curs_view["nive_deta"]; ?>
    </td>
    <td width="20%" align="center" valign="middle">
		<?= $row_curs_view["prom_valu"]; ?>
    </td>
   <td>
<div class="menu_options">
	<ul>
     <?php if (permiso_activo(35)){?>
		<li>
			<a class="option" data-toggle="modal" data-target="#edit_promo" onclick="load_ajax('edit_promo_content','admin_periodos_promociones_modal.php','prom_codi=<?=$row_curs_view["prom_codi"];?>&curs_codi=<?=$row_curs_view["curs_codi"];?>');"  >
			 <span class="icon-pencil2 icon"></span> Editar
			</a>
		</li>
		<?}?>
	</ul>
</div>
   </td>
  </tr>
 
 <?php  }?>
   <tr class="pager_table">
    <td colspan="2">
    	<span class="icon-users icon"> </span> Total de Cursos ( <?php echo $cc;?> )
    </td>
  </tr>
</tbody>
</table>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
	    $('#curs_promoc_table').datatable({
			pageSize: 20,
			sort: [false, false,false,false],
			filters: [true,'select',true,false],
			filterText: 'Escriba para buscar... '
		}) ;
} );
</script>