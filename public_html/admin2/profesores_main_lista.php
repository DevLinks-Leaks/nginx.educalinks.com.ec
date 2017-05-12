<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$params = array($texto);
	$sql="{call prof_busq(?)}";
	$usua_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;?>
    <table class="table table-striped" id="usua_table">
    <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
      <tr>
        <th width="50%">Profesor</th>
        <th width="50%" style='text-align:center;'>Atenci&oacute;n a Padres</th>
      </tr>
      </thead>
      <tbody>
     <?php  while ($row_usua_busq = sqlsrv_fetch_array($usua_busq)){ $cc +=1;?>
      <tr>
        <td><?php echo $row_usua_busq["prof_usua"]." - ".$row_usua_busq["prof_apel"]." ".$row_usua_busq["prof_nomb"];?>
        <input type="hidden" id="usua_nombre_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_nombre_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_nomb"]?>">
        <input type="hidden" id="usua_apellido_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_apellido_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_apel"]?>">
        <input type="hidden" id="usua_email_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_email_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_mail"]?>">
        <input type="hidden" id="usua_username_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_username_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_usua"]?>">
        <input type="hidden" id="usua_dire_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_dire_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_dire"]?>">
        <input type="hidden" id="usua_telf_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_telf_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_telf"]?>">
        <input type="hidden" id="usua_cedu_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_cedu_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_cedu"]?>">
        <input type="hidden" id="usua_codi_edi_<?= $row_usua_busq["prof_codi"]?>" name="usua_codi_edi_<?= $row_usua_busq["prof_codi"]?>" value="<?= $row_usua_busq["prof_codi"]?>">
        </td>
        <td style='text-align:center;'>
			<?php if (permiso_activo(525)){?>
				<a data-toggle="modal" data-target="#ModalUsuaEdi" onclick="carga_info_prof_usua_edit('<?= $row_usua_busq["prof_codi"]?>');" class="btn btn-default"><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</a>
			<?php }if (permiso_activo(526)){?>
				<a onClick="load_ajax_del_prof('usua_main','script_profe.php','opc=del&prof_codi=<?= $row_usua_busq['prof_codi']?>');" class="btn btn-default"><span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</a>
			<?php }?>
				<a onClick="window.location='profesores_horario.php?prof_codi=<?= $row_usua_busq['prof_codi']?>';"
					title='Atenci&oacute;n a Padres' onmouseover='$(this).tooltip("show");' data-placement='left'
					class="btn btn-default"><span style='color:#185d26' class="fa fa-calendar"></span></a>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td>
            <span class="icon-users icon"></span> Total de Profesores ( <?php echo $cc;?> )
            </td>
            <td class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>