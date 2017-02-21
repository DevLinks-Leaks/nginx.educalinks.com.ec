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




    <table class="table_striped" id="usua_table">
      <thead>
      <tr>
        <th width="28%">Profesor</th>
        <th colspan="2" width="72%">Opciones</th>
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
        <td colspan="2">
        <div class="menu_options">
        	<ul>
        		<?php if (permiso_activo(525)){?>
                <li>
                	<a data-toggle="modal" data-target="#ModalUsuaEdi" onclick="carga_info_prof_usua_edit('<?= $row_usua_busq["prof_codi"]?>');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                </li>
                <?php }if (permiso_activo(526)){?>
                <li>
                	<a onClick="load_ajax_del_prof('usua_main','script_profe.php','opc=del&prof_codi=<?= $row_usua_busq['prof_codi']?>');" class="option"><span class="icon-remove icon"></span>Eliminar</a>
                </li>
                <?php }?>
                <li>
                	<a onClick="window.location='profesores_horario.php?prof_codi=<?= $row_usua_busq['prof_codi']?>';" class="option"><span class="icon-calendar icon"></span>Atenci&oacute;n a Padres</a>
                </li>
            </ul>
        </div>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td colspan="1">
            <span class="icon-users icon"></span> Total de Profesores ( <?php echo $cc;?> )
            </td>
            <td colspan="2" class="right"><div class="paging"></div></td>
            
        </tr>
      </tfoot>
    </table>
    
</div>

