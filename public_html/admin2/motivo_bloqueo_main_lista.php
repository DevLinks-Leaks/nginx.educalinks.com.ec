<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>  
<div class="main_lista">
	<?php 
	$params = array();
	$sql	= "{call moti_bloq_all()}";
	$stmt 	= sqlsrv_query($conn, $sql, $params);
	if ($stmt === false)
	{	die(print_r(sqlsrv_errors(),true));
	}
	$cc = 0;
	?>
    <table class="table table-striped" id="moti_table">
	<thead>
		<tr>
			<th width="60%">Motivo</th>
			<th width="20%">Obligatorio</th>
			<th width="20%" align='center'>Opciones</th>
		</tr>
	</thead>
      <tbody>
     <?php  while ($row = sqlsrv_fetch_array($stmt)){ $cc +=1;?>
      <tr>
        <td>
			<?= $row["moti_bloq_deta"]; ?>
			<input id="moti_bloq_deta_<?= $row["moti_bloq_codi"]?>" type="hidden" value="<?= $row["moti_bloq_deta"]?>" />
			<input id="moti_bloq_obli_<?= $row["moti_bloq_codi"]?>" type="hidden" value="<?= $row["moti_bloq_obli"]?>" />
		</td>
		<td>
			<?= ($row["moti_bloq_obli"]=="true"?'SI':'NO'); ?>
		</td>
        <td>
			<? if (permiso_activo(517)){?>
				<a class='btn btn-default' title='Editar' onclick="show_edit(<?= $row["moti_bloq_codi"];?>);" data-toggle="modal" data-target="#ModalMotiEdi">
					<span class="fa fa-pencil btn_opc_lista_editar"></span><span class='hidden-sm hidden-xs'> Editar</span>
				</a>
			<?}?>
			<? if (permiso_activo(518)){?>
				<a class='btn btn-default' title='Eliminar' onclick="load_ajax_moti('moti_main','script_moti_bloq.php','del',<?= $row["moti_bloq_codi"];?>);">
					<span class="fa fa-trash btn_opc_lista_eliminar"></span><span class='hidden-sm hidden-xs'>  Eliminar</span>
				</a>
			<?}?>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td>
            <span class="icon-users icon"></span> Total de Motivos ( <?= $cc;?> )
            </td>
            <td class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>