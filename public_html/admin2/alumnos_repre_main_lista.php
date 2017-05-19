<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

	if (isset($_POST["repr_id"]))
	{	$repr_id = $_POST["repr_id"];
	}
	else
	{	$repr_id = "";
	}
	
	if (isset($_POST["repr_apel"]))
	{	$repr_apel = $_POST["repr_apel"];
	}
	else
	{	$repr_apel = "";
	}
  
	$params = array( $repr_id, $repr_apel, $_SESSION['peri_codi'] );
	$sql="{call repr_peri_busq2(?,?,?)}";
	$repr_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<table class="table table-striped" id="repre_table">
	<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
		<tr>
			<th width="5%"></th>
			<th width="15%">ID</th>
			<th width="65%">Nombre</th>
			<th width="15%"></th>
		</tr>
	</thead>
	<tbody>
		<?php  while ($row_repr_busq = sqlsrv_fetch_array($repr_busq)) { $cc +=1; ?>
		<tr onclick="">
			<td class='details-control'><i style='color:green; cursor: pointer' class='fa fa-plus-circle'></i></td>
			<td data-repr_codi="<?= $row_repr_busq["repr_codi"] ?>"><?= '('.$row_repr_busq["repr_tipo_id"].') '.$row_repr_busq["repr_cedula"] ?></td>
			<td><?= $row_repr_busq["repr_apel"]." ".$row_repr_busq["repr_nomb"] ?></td>
			<!--<td>
				<?  /*$params = array($row_repr_busq["repr_codi"]);
					$sql="{call alum_repr_info(?)}";
					$alum_busq = sqlsrv_query($conn, $sql, $params);
					$c=0;
					while($row_alum_busq = sqlsrv_fetch_array($alum_busq)){
						echo $c>0?"<br>":"";
						echo $row_alum_busq['alum_codi']."-".$row_alum_busq['alum_apel']." ".$row_alum_busq['alum_nomb']." (".$row_alum_busq['curs_deta']." ".$row_alum_busq['para_deta'].")";
						$c++;
					}*/?>
			</td>-->
			<td>
				<div class="btn-group" role="group">
					<?php if (permiso_activo(25)){?>
						<!-- <a class="btn btn-default" target="_blank" title="Editar" onmouseover="$(this).tooltip('show')" href="representantes_add.php?repr_codi=<?= $row_repr_busq["repr_codi"]?>" ><span class="fa fa-pencil btn_opc_lista_editar"></span></a> -->
						<a class="btn btn-default" data-toggle="modal" onmouseover="$(this).tooltip('show')" title="Editar" data-target="#modal_representante_edit" onclick="load_modal_repre_view('modal_representante_edit_content','representantes_add_modal.php','repr_codi=<?= $row_repr_busq["repr_codi"]?>&flag=1');"  >
                                    <span class="fa fa-pencil btn_opc_lista_editar"></span>
                        </a>
					<?php }
					if (permiso_activo(26)){?>
					<a class="btn btn-default" title="Eliminar" onmouseover="$(this).tooltip('show')" onclick="load_ajax_del_repr('repr_main','script_repr.php','opc=repr_del&repr_codi=<?= $row_repr_busq["repr_codi"]?>')" ><span class="fa fa-trash btn_opc_lista_eliminar"></span></a>
					<?php }?>
				</div>
			</td>
		</tr>
		<?php  }?>
	</tbody>
	<tfoot>
		<tr class="pager_table" >
			<td colspan="3"><span class="icon-users icon"></span>Total de Representantes ( <?php echo $cc;?> )</td>
			<td class="right"><div class="paging"></div></td>
		</tr>
	</tfoot>
</table>