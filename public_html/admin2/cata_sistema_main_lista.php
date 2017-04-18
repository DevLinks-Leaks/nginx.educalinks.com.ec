<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>  
<div class="main_list">
<?php
	$params = array();
	$sql="{call cata_view()}";
	$cata_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
    <table class="table_striped" id="cata_sist_table">
      <thead>
      <tr>
        <th width="50%">Ítem</th>
        <th width="22%">Grupo</th>
        <th width="28%">Opciones</th>
      </tr>
      </thead>
      <tbody>
     <?php  while ($row_cata = sqlsrv_fetch_array($cata_view)){ $cc +=1;?>
      <tr>
        <td>
			<?php echo $row_cata["cata_deta"];?>
            <input 
            	id="cata_sist_codi_<?= $row_cata["cata_codi"];?>" 
                type="hidden" 
                data-cata_deta="<?= $row_cata["cata_deta"];?>"
                data-cata_padr_codi="<?= $row_cata["cata_padr_codi"];?>" />
        </td>
        <td>
			<?php echo $row_cata["cata_padr_deta"];?>
        </td>
        <td>
        <div class="menu_options">
        	<ul>
        		<?php if (permiso_activo(161)){?>
                <li>
                	<a data-toggle="modal" data-target="#ModalCataEdit" onclick="carga_info_cata_sist_edit
                    ('<?= $row_cata['cata_codi']?>');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                </li>
                <?php } ?>
            </ul>
        </div>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td colspan="1">
            <span class="icon-users icon"></span> Total de ítems ( <?php echo $cc;?> )
            </td>
            <td colspan="2" class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>