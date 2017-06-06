<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];
		else $texto='%';
	$params = array($_SESSION['peri_codi'],$texto);
	$sql="{call docu_busq(?,?)}";
	$docu_busq = sqlsrv_query($conn, $sql, $params);
	$cc = 0;?>

    <table class="table table-striped" id="docu_table">
		<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
			<tr>
				<th width="50%">Documentos</th>
				<th style='text-align:center' width="20%">Seleccionar </th>
				<th style='text-align:center' width="30%">Opciones</th>
			</tr>
		</thead>
		<tbody>
     <?php  while ($row_docu_busq = sqlsrv_fetch_array($docu_busq)){ $cc +=1;?>
			<tr>
				<td><?php echo $row_docu_busq["docu_codi"]." - ".$row_docu_busq["docu_descr"];?>
					<input type="hidden" id="docu_descr_edi_<?= $row_docu_busq["docu_codi"]?>" name="docu_descr_edi_<?= $row_docu_busq["docu_codi"]?>" value="<?= $row_docu_busq["docu_descr"]?>">
					<input type="hidden" id="docu_codi_edi_<?= $row_docu_busq["docu_codi"]?>" name="docu_codi_edi_<?= $row_docu_busq["docu_codi"]?>" value="<?= $row_docu_busq["docu_codi"]?>">
					<input type="hidden" id="peri_codi_edi_<?= $row_docu_busq["docu_codi"]?>" name="peri_codi_edi_<?= $row_docu_busq["docu_codi"]?>" value="<?= $row_docu_busq["peri_codi"]?>">
				</td>
				<td style='text-align:center'>
					<?php if (permiso_activo(50)){?>
					<input
						class="option"
						onClick="load_ajax_docu('docu_main','script_docu.php','check',
								0,
								<?php if($row_docu_busq["peri_codi"]==NULL){echo $_SESSION['peri_codi'];} else {echo $row_docu_busq["peri_codi"]; }?>,
								<?=$row_docu_busq["docu_codi"] ?>,
								<?php if($row_docu_busq["docu_peri_codi"]==NULL){echo 0;} else {echo $row_docu_busq["docu_peri_codi"]; }?>,
								this.checked);"
						title="Activar este documento para que aparezca en la ventana de matriculación de alumno."
						type="checkbox" <? echo ($row_docu_busq["docu_peri_estado"]=='I'?"":"checked") ?>
						data-toggle="toggle" data-on="SI" data-off="NO"/>
				</td>
				<td style='text-align:center'>  
					<a data-toggle="modal" data-target="#ModalDocuEdi" onclick="carga_info_docu_edit('<?= $row_docu_busq["docu_codi"]?>');" class="btn btn-default">
					<span class="fa fa-edit btn_opc_lista_editar"></span><span class='hidden-sm hidden-xs'> Editar</span></a>
					<?php }if (permiso_activo(51)){?>
						<a 
						onClick="load_ajax_docu_del('docu_main','script_docu.php', 'del',
												0,0,
												<?=$row_docu_busq["docu_codi"] ?>,
												0,0);"
						class="btn btn-default"><span class="fa fa-trash btn_opc_lista_eliminar"></span><span class='hidden-sm hidden-xs'> Eliminar</span></a>
					<?php }?>
				</td>
			</tr>
     <?php  }?>
		</tbody>
    </table>
</div>