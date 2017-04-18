<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	$params = array($peri_codi);
	$sql="{call area_view(?)}";
	$area_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?> 
<div class="cursos_materias_main">
	<table class="table table-striped" id="mate_table">
		<thead>
		  <tr>
			<th width="60%" class="center">Listado de Áreas</th>
			<th width="40%" class="center">Opciones</th>    
		  </tr>
		</thead>
		<tbody>
			<?php  while ($row_area_view = sqlsrv_fetch_array($area_view)) { $cc +=1; ?>
			<tr >
				<td width="60%" class="center"><?= $row_area_view["area_deta"]; ?></td>
				<td width="40%" class="center">
					<?php if (permiso_activo(523)){?>
					<a class="btn btn-default" onclick="area_edit(<?= $row_area_view["area_codi"]; ?>,'<?= $row_area_view["area_deta"]; ?>')" data-toggle="modal" data-target="#area_edit" >
					<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar
					</a>
					<?php } ?> 
					<?php if (permiso_activo(524)){?>
					<a class="btn btn-default"   onclick="area_del(<?= $row_area_view["area_codi"]; ?>)" >
					<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar 
					</a>
					<?php }?> 
				</td>
			</tr>
		<?php  }?>
		</tbody>
		<tfoot>
			<tr class="pager_table">
				<td >
					<span class="icon-books icon"> </span> Total de Áreas ( <?php echo $cc;?> )
				</td>
				<td class="right" colspan="5">
					<div class="paging"></div>
				</td>
			<tr class="pager_table">
				<td colspan="6" >* No tiene datos asignados en este periodo</td>
			</tr>
		  </tr>
		</tfoot>
	</table>
</div>
