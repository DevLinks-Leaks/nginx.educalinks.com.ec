 
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_indi'])){
		if($_POST['add_indi']=='Y'){		
	 		$indi_deta=$_POST['indi_deta'];	 
			$valo_codi=$_POST['valo_codi'];	 
			$params = array($indi_deta,$valo_codi);
			$sql="{call indi_add(?,?)}";
			sqlsrv_query($conn, $sql, $params); 
			
		//Para auditoría
		//$detalle="Descripción: ".$_POST['curs_deta'];
		//registrar_auditoria (6, $detalle); 
		
		}
	}
	
	if(isset($_POST['upd_indi'])){
		if($_POST['upd_indi']=='Y'){
			$indi_codi=$_POST['indi_codi'];	 
			$indi_deta=$_POST['indi_deta'];	 
			$valo_codi=$_POST['valo_codi'];	
			
			$params = array($indi_codi,$indi_deta,$valo_codi);
			$sql="{call indi_upd(?,?,?)}";
			$indi_upd = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($indi_upd);	
			
			//Para auditoría
			//$detalle="Descripción: ".$_POST['curs_deta'];
			//$detalle.=" Nivel: ".$_POST['nive_codi'];
			//registrar_auditoria (7, $detalle); 
		}
	}
	
	
	if(isset($_POST['del_indi'])){
		if($_POST['del_indi']=='Y'){		
	 		$indi_codi=$_POST['indi_codi'];	 
			$params = array($indi_codi);
			$sql="{call indi_del(?)}";
			$indi_del = sqlsrv_query($conn, $sql, $params);  
			//$row_indi_upd = sqlsrv_fetch_array($indi_upd);
			
		//Para auditoría
		//$detalle="Código: ".$_POST['curs_codi'];
		//registrar_auditoria (8, $detalle); 
		}
	}
							 
		
	$params = array();
	$sql="{call indi_view()}";
	$indi_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?>

<table  class="table_striped">
 <thead>
  <tr>
    <th>Listado de Indicadores </td>
    <th width="21%">Opciones</td>
  </tr>
</thead>
<tbody>
 <?php  while ($row_indi_view = sqlsrv_fetch_array($indi_view)) { $cc +=1; ?>
  <tr > 
   <td> 
   <table>
    <td width="55%"  >
   <?= $row_indi_view["indi_deta"]; ?>
      
    
     </td>
    <td width="45%" align="center" valign="middle">
		<?= $row_indi_view["valo_deta"]; ?>
    </td>
    </table>
   </td> 
   <td>
 

<div class="menu_options">
	<ul>
		<li>
			<a id="bt_indi_edit_<?= $row_indi_view["indi_codi"]; ?>"  class="option" data-toggle="modal" data-target="#indi_nuev" 
            	onclick="indi_upda_dial(<?= $row_indi_view["indi_codi"]; ?>,'<?= $row_indi_view["indi_deta"]; ?>',<?= $row_indi_view["valo_codi"]; ?>)"  >
			 <span class="icon-pencil2 icon"></span> Editar
			</a>
		</li>
		<li>
			<a id="bt_indi_dele_<?= $row_indi_view["indi_codi"]; ?>" class="option" 
            	onclick="indi_del(<?= $row_indi_view["indi_codi"]; ?>)" >
			<span class="icon-close icon"></span>Eliminar
			
		</a>
		</li>
	</ul>
</div>

   </td>
  </tr>
 
 <?php  }?>
   <tr class="pager_table">
    <td colspan="2">
    	<span class="icon-users icon"> </span> Total de Indicadores ( <?php echo $cc;?> )
    </td>
  </tr>
</tbody>
</table>