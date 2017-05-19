<?php 
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

$response = file_get_contents($_SESSION['web_service_url'].'/api/listadobl?api_token='.$_SESSION['api_token']);

$response = json_decode($response,true);

$response = $response['result'];
$cc=0;
?>  
<div class="main_lista">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Listado de alumnos bloqueados</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<?php 
			if(isset($_POST['texto'])) $texto=$_POST['texto'];		
			else   $texto='%';


			?>

			<table class="table table-striped" id="blacklist_table">
				<thead>
					<tr>
						<th width="50%">Alumno</th>
						<th width="25%">Motivo Bloqueo</th>
						<th width="25%">Opciones</th>
					</tr>
				</thead>
				<tbody>
				 <?php  
				 foreach($response as $item) {
					 $cc +=1;?>
					 <tr>
						<td><?= $item["bl_alum_apel"]." ".$item["bl_alum_nomb"]?>
						</td>
						<td><?= $item["bl_moti_bloq_deta"]?>
						</td>
						<td>
							<?php if (permiso_activo(529)){?>
								<a class='btn btn-default' data-toggle="modal" data-target="#BlacklistEdit" onclick="load_ajax('modal_main_blacklist','script_alumnos_blacklist.php','bl_codi=<?= $item["bl_codi"]; ?>&bl_moti_bloq_deta=<?= $item["bl_moti_bloq_deta"];?>&opc=edit_view');" class="option"><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</a>
							<?php }if (permiso_activo(530)){?>
								<a class='btn btn-default' onClick="load_ajax_del_alum_bl('modal_main_blacklist','script_alumnos_blacklist.php','bl_codi=<?= $item["bl_codi"]; ?>&opc=del');" class="option"><span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</a>
							<?php }?>
					 </td>
				 </tr>
				 <?php  }?>
				</tbody>
				<tfoot>
				   <tr class="pager_table">
					<td colspan="2">
						<span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc;?> )
					</td>
				</tr>
				<tr>
					<td colspan="2" class="left">
						<div class="paging"></div>
					</td>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>