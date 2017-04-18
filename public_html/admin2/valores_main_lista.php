
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_valo'])){
		if($_POST['add_valo']=='Y'){		
	 		$valo_deta=$_POST['valo_deta'];	 
			$params = array($valo_deta);
			$sql="{call valo_add(?)}";
			$valo_add = sqlsrv_query($conn, $sql, $params);  

			//Para auditoría
			//$detalle="Descripción: ".$_POST['aula_deta'];
			//registrar_auditoria (26, $detalle);
		}
	}
	
	if(isset($_POST['del_valo'])){
		if($_POST['del_valo']=='Y'){		
	 		$valo_codi=$_POST['valo_codi'];	 
			$params = array($valo_codi);
			$sql="{call valo_del(?)}";
			$valo_del = sqlsrv_query($conn, $sql, $params);  
			$row_valo_upd = sqlsrv_fetch_array($valo_del);
			
			//Para auditoría
			//$detalle="Código: ".$_POST['aula_codi'];
			//registrar_auditoria (28, $detalle);
		}
	}
							 
		
	$params = array();
	$sql="{call valo_view()}";
	$valo_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 



<div class="valores_main_lista">


<table   class="table_striped">
 <thead>
  <tr>
    <th width="77%"><strong>Listado de Valores </strong></td>
    <th width="23%"><strong>Opciones</strong></td>
  </tr>
 </thead>

 <tbody>
 <?php  while ($row_valo_view = sqlsrv_fetch_array($valo_view)) { $cc +=1; ?>
  <tr >
    <td height="29">
    	<div id="valo_<?= $row_valo_view["valo_codi"]; ?>">
    		<input  type="text"  value="<?= $row_valo_view["valo_deta"]; ?>" id="valo_deta_<?= $row_valo_view["valo_codi"]; ?>" name="valo_deta_<?= $row_valo_view["valo_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" />
    	</div>
    </td>
	

    <td>
    	<div class="menu_options">
    		<ul>
    			<li>

    				<a class="option" id="bt_valo_edit_<?= $row_valo_view["valo_codi"]; ?>" onclick="valo_upd(<?= $row_valo_view["valo_codi"]; ?>)"  >Editar</a>
    			</li>

    			<li>

    			<a class="option" id="bt_valo_dele_<?= $row_valo_view["valo_codi"]; ?>" onclick="valo_del(<?= $row_valo_view["valo_codi"]; ?>)" >Eliminar</a>
    			</li>
    		</ul>
    	</div>
 



      <script>
      	function valo_upd(valo_codi){
			if (document.getElementById('bt_valo_edit_' + valo_codi).innerHTML == 'Editar'){
				document.getElementById('valo_deta_' + valo_codi).disabled = '';
				document.getElementById('valo_deta_' + valo_codi).style = 'width:100%; height=100%; border:none; background:#CADBF4;';
				document.getElementById('bt_valo_edit_' + valo_codi).innerHTML = 'Actualizar';
				document.getElementById('bt_valo_dele_' + valo_codi).innerHTML = 'Cancelar'; 
				document.getElementById('valo_deta_' + valo_codi).select();
				document.getElementById('valo_deta_' + valo_codi).focus();
					
			}else{
					 
				load_ajax('valo_'+ valo_codi,'script_valores.php','valo_codi=' + valo_codi + '&valo_deta=' + document.getElementById('valo_deta_' + valo_codi).value + '&upd_valo=Y'); 
				document.getElementById('bt_valo_edit_' + valo_codi).innerHTML = 'Editar';
				document.getElementById('bt_valo_dele_' + valo_codi).innerHTML = 'Eliminar';
				 
			}
			
		}
		
		function valo_del(valo_codi){
			
			if (document.getElementById('bt_valo_edit_' + valo_codi).innerHTML == 'Editar'){
				if (confirm("Esta seguro que desea Eliminar" + valo_codi )) {					 
					load_ajax('valo_main','valores_main_lista.php','valo_codi=' + valo_codi + '&del_valo=Y'); 					
				}				
			}else{
				
				load_ajax('valo_'+ valo_codi,'script_valores.php','valo_codi=' + valo_codi );			 
				document.getElementById('bt_valo_edit_' + valo_codi).innerHTML = 'Editar';
				document.getElementById('bt_valo_dele_' + valo_codi).innerHTML = 'Eliminar';
			
				
			}
		}
 
      
      </script>
      
      
      
    </td>
  </tr>
 
 <?php  }?>

   <tr  class="pager_table">
    <td colspan="2">
    <span class="icon-books icon"></span> Total de Valores ( <?php echo $cc;?> )</td>
  </tr>

</table>

</div>