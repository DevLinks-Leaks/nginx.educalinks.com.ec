
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');

	if(isset($_POST['add_peri_dist_cab'])){
		if($_POST['add_peri_dist_cab']=='Y'){
			 
	 		$peri_dist_cab_deta=$_POST['peri_dist_cab_deta'];	 
			$peri_dist_cab_ano=$_POST['peri_dist_cab_ano'];	
			$params = array($peri_dist_cab_deta,$peri_dist_cab_ano);
			$sql="{call peri_dist_cab_add(?,?)}";
			sqlsrv_query($conn, $sql, $params);  
		}
	}
	
	if(isset($_POST['upd_peri_dist_cab'])){
		if($_POST['upd_peri_dist_cab']=='Y'){
			 
			$peri_dist_cab_codi=	$_POST['peri_dist_cab_codi'];	 
			$peri_dist_cab_deta=	$_POST['peri_dist_cab_deta'];	 
			$peri_dist_cab_ano=	$_POST['peri_dist_cab_ano'];	
			
			$params = array($peri_dist_cab_codi,$peri_dist_cab_deta,$peri_dist_cab_ano);
			$sql="{call peri_dist_cab_upd(?,?,?)}";
			sqlsrv_query($conn, $sql, $params);  			  
		}
	}
	
	if(isset($_POST['del_peri_dist_cab'])){
		if($_POST['del_peri_dist_cab']=='Y'){		
	 		$peri_dist_cab_codi=$_POST['peri_dist_cab_codi'];	 
			$params = array($peri_dist_cab_codi);
			$sql="{call peri_dist_cab_del(?)}";
			sqlsrv_query($conn, $sql, $params);  
		}
	}

	$params = array($peri_codi);
	$sql="{call peri_dist_cab_view(?)}";
	$peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 	
?> 
<table width="100%"   class="table table-striped">
	<thead>
		<tr>
			<th width="40%"><strong>Listado de Distribuciones</strong></th>
			<th colspan="2" class='text-center'><strong>Opciones</strong></th>
		</tr>
	</thead>
<tbody>
 <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { $cc +=1; ?>
  <tr >
    <td height="29">  <?= $row_peri_dist_cab_view["peri_dist_cab_deta"]; ?> - Año : <?= $row_peri_dist_cab_view["peri_dist_cab_ano"]; ?></td>
    <td width="60%" style='text-align:center'>
               <?php if (permiso_activo(54)){?>
			    
				    <a class="btn bg-olive" href="admin_periodos_notas.php?peri_dist_cab_codi=<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>&peri_codi=<?= $row_peri_dist_cab_view["peri_codi"]; ?>" >
				    <span class="fa fa-users"></span> Dist. Notas
				    </a>
			    
                 <?php }?>
                    <?php if (permiso_activo(54)){?>
			    
				    <a class="btn bg-olive" href="admin_periodos_notas_modelos.php?peri_dist_cab_codi=<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>" >
				    <span class="fa fa-users"></span> Modelos de Notas
				    </a>
                 <?php }?>
                 <?php if (permiso_activo(54)){?>
			    
				    <a class="btn btn-default" onclick="peri_dist_cab_del(<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>)">
				    <span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar
				    </a>
			    
                 <?php }?>
    </td>
    </tr>
 <?php  }?>

</tbody>

 <tfoot>
 	<tr class="pager_table">
            <td colspan="3">
            <span class="icon-calendar icon"></span> Total de Periodos ( <?php echo $cc;?> )
            </td>
            
        </tr>
 </tfoot>
</table>

 
      
