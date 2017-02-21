<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$params = array($texto);
	$sql="{call alum_bloq_main_busq(?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>

    <table class="table_striped" id="alum_table">
      <thead>
      <tr>
        <th width="72%">Alumno</th>
        <th colspan="2" width="28%">Opciones</th>
      </tr>
      </thead>
      <tbody>
     <?php  while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)){ $cc +=1;?>
      <tr>
        <td><?php echo $row_alum_busq["alum_bloq_cedu"]." - ".$row_alum_busq["alum_bloq_nomb"]." ".$row_alum_busq["alum_bloq_apel"];?>
        <input type="hidden" id="alum_nombre_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" name="alum_nombre_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" value="<?= $row_alum_busq["alum_bloq_nomb"]?>">
        
        <input type="hidden" id="alum_apellido_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" name="alum_apellido_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" value="<?= $row_alum_busq["alum_bloq_apel"]?>">

        <input type="hidden" id="alum_obse_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" name="alum_obse_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" value="<?= $row_alum_busq["alum_bloq_obse"]?>">
        
        <input type="hidden" id="alum_cedu_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" name="alum_cedu_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" value="<?= $row_alum_busq["alum_bloq_cedu"]?>">
        
        <input type="hidden" id="alum_codi_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" name="alum_codi_edi_<?= $row_alum_busq["alum_bloq_codi"]?>" value="<?= $row_alum_busq["alum_bloq_codi"]?>">
        </td>
        <td colspan="2">
        <div class="menu_options">
        	<ul>
        		<?php if (permiso_activo(79)){?>
                <li>
                	<a data-toggle="modal" data-target="#ModalUsuaEdi" onclick="carga_info_alum_edit('<?= $row_alum_busq['alum_bloq_codi']?>');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                </li>
                <?php }if (permiso_activo(80)){?>
                <li>
                	<a onClick="load_ajax_del_alum('alum_main','script_alumnos_bloqueados.php','opc=del&alum_codi=<?= $row_alum_busq['alum_bloq_codi']?>');" class="option"><span class="icon-remove icon"></span>Eliminar</a>
                </li>
                <?php }?>
            </ul>
        </div>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td colspan="2">
            <span class="icon-users icon"></span> Total de Parámetros ( <?php echo $cc;?> )
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

