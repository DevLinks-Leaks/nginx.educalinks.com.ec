
<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$params = array($texto);
	$sql="{call rol_busq(?)}";
	$rol_busq = sqlsrv_query($conn, $sql, $params);?>
    
    <div class="main_lista">
    <table class="table table-striped" id="rol_table">
		<thead>
			<tr>
			<th width="85%">Roles de Usuarios</th>
			<th width="15%">Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php $cc = 0; while ($row_rol_busq = sqlsrv_fetch_array($rol_busq)){ $cc +=1;?>
			<tr>
			<td><?= $row_rol_busq["rol_deta"];?>
				<input type="hidden" id="rol_codi_edi_<?= $row_rol_busq["rol_codi"]?>" name="rol_codi_edi_<?= $row_rol_busq["rol_codi"]?>" value="<?= $row_rol_busq["rol_codi"]?>">
				<input type="hidden" id="rol_deta_edi_<?= $row_rol_busq["rol_codi"]?>" name="rol_deta_edi_<?= $row_rol_busq["rol_codi"]?>" value="<?= $row_rol_busq["rol_deta"]?>">
				<input type="hidden" id="rol_finan_edi_<?= $row_rol_busq["rol_codi"]?>" name="rol_finan_edi_<?= $row_rol_busq["rol_codi"]?>" value="<?= $row_rol_busq["rol_finan"]?>">
			</td>
			<td>
				<?php if (permiso_activo(47)){?>
				<a class='btn btn-default' data-toggle="modal" data-target="#ModalRolEdi" onclick="carga_info_rol_edit('<?= $row_rol_busq["rol_codi"]?>');" class="option"><span class="fa fa-edit btn_opc_lista_editar"></span> Editar</a>
				<?php }if (permiso_activo(48)){?>
				<a class='btn btn-default' onClick="load_ajax_del_rol('rol_main','script_usua.php','opc=del_rol&rol_codi=<?= $row_rol_busq['rol_codi']?>');" class="option"><span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</a>            	
				<?php }?>
			</td>
			</tr>
			<?php  }?>
		</tbody>
		<tfoot>
			<tr class="pager_table">
				<td> <span class="icon-users icon"></span>Total de Roles de Usuarios ( <?php echo $cc;?> )</td>
				<td class="right"> <div class="paging"></div> </td>
			</tr>
		</tfoot>
	</table>
</div>