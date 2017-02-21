 
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_indi_parc'])){
		if($_POST['add_indi_parc']=='Y'){		
	 		$indi_codi=$_POST['indi_codi'];	 
			$peri_dist_codi=$_POST['peri_dist_codi'];	 
			$params = array($peri_dist_codi,$indi_codi);
			$sql="{call indi_parc_add(?,?)}";
			sqlsrv_query($conn, $sql, $params); 
			
		//Para auditoría
		//$detalle="Descripción: ".$_POST['curs_deta'];
		//registrar_auditoria (6, $detalle); 
		
		}
	}
	
	
	if(isset($_POST['del_indi_parc'])){
		if($_POST['del_indi_parc']=='Y'){		
	 		$indi_codi_parc=$_POST['indi_parc_codi'];	 
			$params = array($indi_codi_parc);
			$sql="{call indi_parc_del(?)}";
			$indi_parc_del = sqlsrv_query($conn, $sql, $params);  
			//$row_indi_upd = sqlsrv_fetch_array($indi_upd);
			
		//Para auditoría
		//$detalle="Código: ".$_POST['curs_codi'];
		//registrar_auditoria (8, $detalle); 
		}
	}
							 
	$peri_codi=$_SESSION['peri_codi'];
	$params = array($peri_codi);
	$sql="{call eval_comp_view(?)}";
	$eval_comp_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?>


 


<table  class="table_striped">
 <thead>
  <tr>
  	<th width="15%">Unidad</th>
    <th width="15%">Valor </td>
    <th width="60%">Indicador</th>
    <th width="10%">Opciones</td>
  </tr>
</thead>



<tbody>
 <?php  while ($row_eval_comp_view = sqlsrv_fetch_array($eval_comp_view)) { $cc +=1; ?>
  <tr> 
    <td width="15%">
   <?= $row_eval_comp_view["padre"].'-'.$row_eval_comp_view["peri_dist_deta"]; ?>
     </td>
    <td width="15%" align="center" valign="middle">
		<?= $row_eval_comp_view["valo_deta"]; ?>
    </td>
    <td width="60%">
    	<?= $row_eval_comp_view["indi_deta"]; ?>
    </td>
   <td width="10%">
<div class="menu_options">
	<ul>
		<li>
			<a id="bt_indi_dele_<?= $row_eval_comp_view["indi_parc_codi"]; ?>" class="option" 
            	onclick="indi_parc_del(<?= $row_eval_comp_view["indi_parc_codi"]; ?>)" >
			<span class="icon-close icon"></span>Eliminar
			</a>
		</li>
	</ul>
</div>

   </td>
  </tr>
 
 <?php  }?>
   <tr class="pager_table">
    <td colspan="4">
    	<span class="icon-users icon"> </span> Total de Indicadores ( <?php echo $cc;?> )
    </td>
  </tr>
</tbody>
</table>

 
     