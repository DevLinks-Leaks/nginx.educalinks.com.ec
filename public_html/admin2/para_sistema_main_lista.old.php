<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$params = array($texto);
	$sql="{call para_sist_main_busq(?)}";
	$para_sist_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>

<table class="table table-striped" id="para_sist_table">
  <thead>
  <tr>
    <th width="50%">Parámetro</th>
    <th width="22%">Valor</th>
    <th width="28%">Opciones</th>
  </tr>
  </thead>
  <tbody>
 <?php  while ($row_para_sist = sqlsrv_fetch_array($para_sist_busq)){ $cc +=1;?>
  <tr>
    <td>
        <?php echo $row_para_sist["para_sist_deta"];?>
        <input id="para_sist_codi_<?= $row_para_sist["para_sist_codi"];?>" type="hidden" data-para_sist_codi="<?= $row_para_sist["para_sist_codi"];?>" data-para_sist_deta="<?= $row_para_sist["para_sist_deta"];?>" data-para_sist_valo="<?= $row_para_sist["para_sist_valu"];?>"/>
    </td>
    <td>
        <?php echo $row_para_sist["para_sist_valu"];?>
    </td>
    <td>
		<?php if (permiso_activo(85)){?>
			<a data-toggle="modal" data-target="#ModalUsuaEdi" onclick="carga_info_para_sist_edit
			('<?= $row_para_sist['para_sist_codi']?>');" class="btn btn-default"><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</a>
		<?php } ?>
    </td>
  </tr>
 <?php  }?>
  </tbody>
  <tfoot>
     <tr class="pager_table" >
       <td colspan="3"><span class="icon-users icon"></span> Total Parámetros ( <?php echo $cc;?> )</td>
     </tr>
     <tr class="pager_table">
       <td colspan="3" class="right"><div class="paging"></div></td>
     </tr>
     </tfoot>
</table>
</div>