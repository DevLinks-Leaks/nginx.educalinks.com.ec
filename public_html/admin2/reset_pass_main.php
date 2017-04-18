<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$params = array($texto);
	$sql="{call usua_busq_all(?)}";
	$usua_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;?>
    <table class="table table-striped" id="usua_table">
		<thead>
			<tr>
				<th width="85%">Usuario</th>
				<th width="15%">Opciones</th>
			</tr>
		</thead>
		<tbody>
		 <?php  while ($row_usua_busq = sqlsrv_fetch_array($usua_busq)){ $cc +=1;?>
			<tr>
				<td><?php echo $row_usua_busq["usua_codi"]." - ".$row_usua_busq["usua_apel"]." ".$row_usua_busq["usua_nomb"];?>
					<input type="hidden" id="usua_nombre_edi_<?= $row_usua_busq["usua_codi"]?>" name="usua_nombre_edi_<?= $row_usua_busq["usua_codi"]?>" value="<?= $row_usua_busq["usua_nomb"]?>">
					<input type="hidden" id="usua_apellido_edi_<?= $row_usua_busq["usua_codi"]?>" name="usua_apellido_edi_<?= $row_usua_busq["usua_codi"]?>" value="<?= $row_usua_busq["usua_apel"]?>">
					<input type="hidden" id="usua_email_edi_<?= $row_usua_busq["usua_codi"]?>" name="usua_email_edi_<?= $row_usua_busq["usua_codi"]?>" value="<?= $row_usua_busq["usua_mail"]?>">
					<input type="hidden" id="usua_username_edi_<?= $row_usua_busq["usua_codi"]?>" name="usua_username_edi_<?= $row_usua_busq["usua_codi"]?>" value="<?= $row_usua_busq["usua_codi"]?>">
					<input type="hidden" id="usua_tipo_edi_<?= $row_usua_busq["usua_codi"]?>" name="usua_tipo_edi_<?= $row_usua_busq["usua_codi"]?>" value="<?= $row_usua_busq["usua_tipo"]?>">
				</td>
				<td>
					<a class='btn btn-default' data-toggle="modal" data-target="#ModalUsuaEdi" onclick="carga_info_usua_edit('<?= $row_usua_busq["usua_codi"]?>');" class="option"><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</a>
				</td>
			</tr>
		 <?php  }?>
		</tbody>
		<tfoot>
			<tr class="pager_table">
				<td colspan="1">
				<span class="icon-users icon"></span> Total de Usuarios ( <?php echo $cc;?> )
				</td>
				<td class="right"><div class="paging"></div></td>
				
			</tr>
		</tfoot>
	</table>
</div>