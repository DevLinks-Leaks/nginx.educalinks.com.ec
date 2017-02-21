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

    <table class="table_striped" id="docu_table">
      <thead>
      <tr>
        <th width="50%">Documentos</th>
        <th width="50%">Opciones</th>
        
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
        <td>
        <div class="menu_options">
        	<ul>
        		<?php if (permiso_activo(50)){?>
                <li>
					<input
						class="option"
						onClick="load_ajax_docu('docu_main','script_docu.php','check',
								0,
								<?php if($row_docu_busq["peri_codi"]==NULL){echo $_SESSION['peri_codi'];} else {echo $row_docu_busq["peri_codi"]; }?>,
								<?=$row_docu_busq["docu_codi"] ?>,
								<?php if($row_docu_busq["docu_peri_codi"]==NULL){echo 0;} else {echo $row_docu_busq["docu_peri_codi"]; }?>,
								this.checked);"
						title="Seleccionar para periodo"
						type="checkbox" <? echo ($row_docu_busq["docu_peri_estado"]=='I'?"":"checked")?>/>
                </li>
				<li>
                	<a data-toggle="modal" data-target="#ModalDocuEdi" onclick="carga_info_docu_edit('<?= $row_docu_busq["docu_codi"]?>');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                </li>
                <?php }if (permiso_activo(51)){?>
                <li>
                	<a 
					onClick="load_ajax_docu_del('docu_main','script_docu.php', 'del',
											0,0,
											<?=$row_docu_busq["docu_codi"] ?>,
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
            <span class="icon-users icon"></span> Total de Items de Documento ( <?php echo $cc;?> )
            </td>
            <td class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>