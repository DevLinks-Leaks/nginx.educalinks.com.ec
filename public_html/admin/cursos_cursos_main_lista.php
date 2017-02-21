 
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_curs'])){
		if($_POST['add_curs']=='Y'){		
	 		$curs_deta=$_POST['curs_deta'];	 
			$nive_codi=$_POST['nive_codi'];	 
			$params = array($curs_deta,$nive_codi);
			$sql="{call curs_add(?,?)}";
			sqlsrv_query($conn, $sql, $params); 
			
		//Para auditoría
		$detalle="Descripción: ".$_POST['curs_deta'];
		registrar_auditoria (6, $detalle); 
		}
	}
	
	if(isset($_POST['upd_curs'])){
		if($_POST['upd_curs']=='Y'){
			$curs_codi=$_POST['curs_codi'];	 
			$curs_deta=$_POST['curs_deta'];	 
			$nive_codi=$_POST['nive_codi'];	
			
			$params = array($curs_codi,$curs_deta,$nive_codi);
			$sql="{call curs_upd(?,?,?)}";
			$curs_upd = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($curs_upd);	
			
			//Para auditoría
			$detalle="Descripción: ".$_POST['curs_deta'];
			$detalle.=" Nivel: ".$_POST['nive_codi'];
			registrar_auditoria (7, $detalle); 
		}
	}
	
	
	if(isset($_POST['del_curs'])){
		if($_POST['del_curs']=='Y'){		
	 		$curs_codi=$_POST['curs_codi'];	 
			$params = array($curs_codi);
			$sql="{call curs_del(?)}";
			$curs_del = sqlsrv_query($conn, $sql, $params);  
			$row_curs_upd = sqlsrv_fetch_array($curs_upd);
			
		//Para auditoría
		$detalle="Código: ".$_POST['curs_codi'];
		registrar_auditoria (8, $detalle); 
		}
	}
							 
		
	$params = array();
	$sql="{call curs_view()}";
	$curs_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?>

<table class="table_striped" id="curs_table">
 <thead>
  <tr>
    <th colspan="2">Listado de Cursos </td>
    <th width="21%">Opciones</td>
  </tr>
</thead>
<tbody>
 <?php  while ($row_curs_view = sqlsrv_fetch_array($curs_view)) { $cc +=1; ?>
  <tr> 
   <td> 
   <?= $row_curs_view["curs_deta"]; ?>
     </td>
    <td width="45%" align="center" valign="middle">
		<?= $row_curs_view["nive_deta"]; ?>
    </td>
   <td>
<div class="menu_options">
	<ul>
     <?php if (permiso_activo(35)){?>
		<li>
			<a id="bt_curs_edit_<?= $row_curs_view["curs_codi"]; ?>"  class="option" data-toggle="modal" data-target="#curs_nuev" 
            	onclick="curs_upda_dial(<?= $row_curs_view["curs_codi"]; ?>,'<?= $row_curs_view["curs_deta"]; ?>',<?= $row_curs_view["nive_codi"]; ?>)"  >
			 <span class="icon-pencil2 icon"></span> Editar
			</a>
		</li>
     <?php }if (permiso_activo(36)){?>
		<li>
			<a id="bt_curs_dele_<?= $row_curs_view["curs_codi"]; ?>" class="option" 
            	onclick="curs_del(<?= $row_curs_view["curs_codi"]; ?>)" >
			<span class="icon-close icon"></span>Eliminar
			
		</a>
		</li>
     <?php }?>
	</ul>
</div>
   </td>
  </tr>
 
 <?php  }?>
   <tr class="pager_table">
    <td colspan="2">
    	<span class="icon-users icon"> </span> Total de Cursos ( <?php echo $cc;?> )
    </td>
  </tr>
</tbody>
</table>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
	    $('#curs_table').datatable({
			pageSize: 20,
			sort: [false, false,false],
			filters: [true,'select',false],
			filterText: 'Escriba para buscar... '
		}) ;
} );
</script>