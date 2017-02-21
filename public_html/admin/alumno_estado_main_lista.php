<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];
		else $texto='%';
	$params = array(0,$texto);
	$sql="{call alum_est_busq(?,?)}";
	$alum_est_busq = sqlsrv_query($conn, $sql, $params);
	$cc = 0;?>

    <table class="table_striped" id="alum_est_table">
      <thead>
      <tr>
        <th width="50%">Estados de alumnos</th>
        <th width="50%">Opciones</th>
        
      </tr>
      </thead>
      <tbody>
     <?php  while ($row_alum_est_busq = sqlsrv_fetch_array($alum_est_busq)){ $cc +=1;?>
      <tr>
        <td><?php echo $row_alum_est_busq["alum_est_codi"]." - ".$row_alum_est_busq["alum_est_det"];?>
        <input type="hidden" id="alum_est_det_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" name="alum_est_det_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" value="<?= $row_alum_est_busq["alum_est_det"]?>">
        <input type="hidden" id="alum_est_codi_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" name="alum_est_codi_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" value="<?= $row_alum_est_busq["alum_est_codi"]?>">
        <input type="hidden" id="peri_codi_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" name="peri_codi_edi_<?= $row_alum_est_busq["alum_est_codi"]?>" value="<?= $row_alum_est_busq["peri_codi"]?>">
        </td>
        <td>
        <div class="menu_options">
        	<ul>
        		<?php if (permiso_activo(50)){?>
                <li>
					<input
						class="option"
						onClick="load_ajax_alum_est('alum_est_main','script_alum_est.php','check',
								0,
								<?php if($row_alum_est_busq["peri_codi"]==NULL){echo $_SESSION['peri_codi'];} else {echo $row_alum_est_busq["peri_codi"]; }?>,
								<?= $row_alum_est_busq["alum_est_codi"] ?>,
								<?php if($row_alum_est_busq["alum_est_peri_codi"]==NULL){echo 0;} else {echo $row_alum_est_busq["alum_est_peri_codi"]; }?>,
								this.checked);"
						title="Seleccionar para periodo"
						type="checkbox" <? echo ($row_alum_est_busq["alum_est_peri_estado"]!='A'?"":"checked")?>/>
                </li>
				<li>
                	<a data-toggle="modal" data-target="#ModalAlumEstEdi" onclick="carga_info_alum_est_edit('<?= $row_alum_est_busq["alum_est_codi"]?>');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                </li>
                <?php }if (permiso_activo(51)){?>
                <li>
                	<a 
					onClick="load_ajax_alum_est_del('alum_est_main','script_alum_est.php', 'del',
											0,0,
											<?=$row_alum_est_busq["alum_est_codi"] ?>,
											0,0);"
					class="option"><span class="icon-remove icon"></span>Eliminar</a>
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
            <td colspan="1">
            <span class="icon-users icon"></span> Total de Items de Estados de Alumnos ( <?php echo $cc;?> )
            </td>
            <td class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>