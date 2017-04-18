
<?php 

	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_para'])){
		if($_POST['add_para']=='Y'){
			 
	 		$para_deta=$_POST['para_deta'];	 
			$params = array($para_deta);
			$sql="{call para_add(?)}";
			$para_add = sqlsrv_query($conn, $sql, $params);  
			
			//Para auditoría
			$detalle="Descripción: ".$_POST['para_deta'];
			registrar_auditoria (12, $detalle);
			
		}
	}
	
	if(isset($_POST['del_para'])){
		if($_POST['del_para']=='Y'){		
	 		$para_codi=$_POST['para_codi'];	
			$params = array($para_codi);
			$sql="{call para_del(?)}";
			$para_del = sqlsrv_query($conn, $sql, $params);  
			
			//Para auditoría
			$detalle="Código: ".$_POST['para_codi'];
			registrar_auditoria (14, $detalle);
		}
	}
							 
		
	$params = array();
	$sql="{call para_view()}";
	$para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 

<div class="cursos_admin_paralelo_main_lista">
<table class="table table-striped">
 <thead>
  <tr>
    <th width="77%"><strong>Listado de paralelos </strong></td>
    <th width="23%"><strong>Opciones</strong></td>
  </tr>
</thead>
<tbody>

 <?php  while ($row_para_view = sqlsrv_fetch_array($para_view)) { $cc +=1; ?>
  <tr>
    <td height="29"><div id="para_<?= $row_para_view["para_codi"]; ?>"><input  type="text"  value="<?= $row_para_view["para_deta"]; ?>" id="para_deta_<?= $row_para_view["para_codi"]; ?>" name="para_deta_<?= $row_para_view["para_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" /></div>
     </td>
    <td>
      <?php if (permiso_activo(44)){?>
  <button id="bt_para_edit_<?= $row_para_view["para_codi"]; ?>" type="button"  class="btn btn-default" 
	onclick="para_upd(<?= $row_para_view["para_codi"]; ?>)"  ><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</button>
  <?php }if (permiso_activo(45)){?>
  <button id="bt_para_dele_<?= $row_para_view["para_codi"]; ?>" type="button"  class="btn btn-default" 
	onclick="para_del(<?= $row_para_view["para_codi"]; ?>)" ><span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</button>
      <?php }?>
      <script>
      	function para_upd(para_codi)
		{   if (document.getElementById('bt_para_edit_' + para_codi).innerHTML == '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar')
			{   document.getElementById('para_deta_' + para_codi).disabled = '';
				document.getElementById('para_deta_' + para_codi).style = 'width:100%; height=100%; border:none; background:#CADBF4;';
				document.getElementById('bt_para_edit_' + para_codi).innerHTML = '<span class="fa fa-floppy-o"></span> Actualizar';
				document.getElementById('bt_para_dele_' + para_codi).innerHTML = 'Cancelar'; 
				document.getElementById('para_deta_' + para_codi).select();
				document.getElementById('para_deta_' + para_codi).focus();
				$('#bt_para_edit_' + para_codi).toggleClass('btn-default btn-success');
			}
			else
			{   load_ajax('para_'+ para_codi,'script_para.php','para_codi=' + para_codi + '&para_deta=' + document.getElementById('para_deta_' + para_codi).value + '&upd_para=Y'); 
				document.getElementById('bt_para_edit_' + para_codi).innerHTML = '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar';
				document.getElementById('bt_para_dele_' + para_codi).innerHTML = '<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar';
				$('#bt_para_edit_' + para_codi).toggleClass('btn-default btn-success');
			}
			
		}
		
		function para_del(para_codi)
		{   if (document.getElementById('bt_para_dele_' + para_codi).innerHTML == '<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar')
			{   if (confirm("Esta seguro que desea Eliminar"))
				{   load_ajax('curs_para_main','cursos_admin_paralelo_main_lista.php','para_codi=' + para_codi + '&del_para=Y'); 					
				}				
			}
			else
			{   load_ajax('para_'+ para_codi,'script_para.php','para_codi=' + para_codi );			 
				document.getElementById('bt_para_edit_' + para_codi).innerHTML = '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar';
				document.getElementById('bt_para_dele_' + para_codi).innerHTML = '<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar';
				$('#bt_para_edit_' + para_codi).toggleClass('btn-default btn-success');
			}
		}
      </script>
    </td>
  </tr>
 
 <?php  }?>
   <tr class="pager_table">
    <td colspan="2">
    	<span class="icon-books icon"> </span> Total de Cursos ( <?php echo $cc;?> )
    </td>
    
  </tr>
</tbody>
</table>
</div>