
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	
	
	$params = array($peri_codi);
	$sql="{call mate_peri_view(?)}";
	$mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 
<div class="cursos_materias_main">
	<table class="table table-striped" id="mate_table" name='mate_table'>
		<thead>
			<tr>
				<th width="23%" class="center">Listado de Materias</th>
				<th style="text-align:center">Área</th>
				<th style="text-align:center">Agrupada</th>
				<th style="text-align:center">Prom</th>
				<th width="25" style="text-align:center">Opciones</th>      
			</tr>
		</thead>
		<tbody>
     
		<?php  while ($row_mate_view = sqlsrv_fetch_array($mate_view)) { $cc +=1; ?>
			<tr>
				<td style="text-align:left"><?= $row_mate_view["mate_deta"]; ?>  &nbsp;("<?= $row_mate_view["mate_abre"]; ?>")(<?= $row_mate_view["mate_codi"]; ?>)&nbsp;&nbsp; <? if ($row_mate_view["peri_codi"]==0) echo '*';?> 
				 </td>
				<td width="22%" style="text-align:center"><?= $row_mate_view["area_deta"]; ?></td>
				<td width="22%" style="text-align:center"><?= $row_mate_view["mate_padr_deta"]; ?></td>
				<td width="12%" style="text-align:center"><?= $row_mate_view["mate_prom"]; ?></td>
				<td width="41%" style="text-align:center">
					 <?php if (permiso_activo(38)){?>
								<a  class="btn btn-default"  
									onmouseover='$(this).tooltip("show")'
									data-placement="left"
									title='Editar'
									onclick="mate_edit(<?= $row_mate_view["mate_codi"]; ?>,'<?= $row_mate_view["mate_deta"]; ?>','<?= $row_mate_view["mate_abre"]; ?>','<?= $row_mate_view["mate_prom"]; ?>',<?= $row_mate_view["mate_padr"]; ?>,'<?= $row_mate_view["mate_tipo"]; ?>','<?= $row_mate_view["area_codi"]; ?>')" data-toggle="modal" data-target="#mate_edit" >
								<span class="fa fa-pencil btn_opc_lista_editar"></span>
								</a>
					 <?php } ?> 
					 <?php if (permiso_activo(39)){?>
						<a  class="btn btn-default"
							onmouseover='$(this).tooltip("show")'
							title='Eliminar'
							onclick="mate_del(<?= $row_mate_view["mate_codi"]; ?>)" >
						<span class="fa fa-trash  btn_opc_lista_eliminar"></span> 
						</a>
					 <?php }?>
				</td>
			</tr>
 	
 <?php  }?>
		</tbody>
		<tfoot>
			<tr>
				<td>
					<span class="fa fa-books"> </span> Total de Cursos ( <?php echo $cc;?> )
				</td>
				<td class="right" colspan="5">
					<div class="paging"></div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<script>
	$(document).ready(function() {
	    $('#mate_table').DataTable();
	});
</script>