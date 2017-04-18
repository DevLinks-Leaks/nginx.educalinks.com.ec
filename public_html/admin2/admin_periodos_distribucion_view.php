
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
<table width="100%"   class="table_striped">
	<thead>
		<tr>
			<th width="40%"><strong>Listado de Distribuciones</strong></th>
			<th colspan="2"><strong>Opciones</strong></th>
		</tr>
	</thead>
<tbody>
 <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { $cc +=1; ?>
  <tr >
    <td height="29">  <?= $row_peri_dist_cab_view["peri_dist_cab_deta"]; ?> - Año : <?= $row_peri_dist_cab_view["peri_dist_cab_ano"]; ?></td>
    <td width="60%">
			<div class="menu_options" style="text-align:left;">
			  <ul>
               <?php if (permiso_activo(54)){?>
			    <li>
				    <a class="option" href="admin_periodos_notas.php?peri_dist_cab_codi=<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>&peri_codi=<?= $row_peri_dist_cab_view["peri_codi"]; ?>" >
				    <span class="icon-users icon"></span>Dist. Notas
				    </a>
			    </li>
                 <?php }?>
                    <?php if (permiso_activo(54)){?>
			    <li>
				    <a class="option"    href="admin_periodos_notas_modelos.php?peri_dist_cab_codi=<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>" >
				    <span class="icon-users icon"></span> Modelos de Notas
				    </a></li>
                 <?php }?>
               <?php if (permiso_activo(54)){?>
			    <li>
				    <a class="option"   onclick="peri_dist_cab_edi(<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>,'<?= $row_peri_dist_cab_view["peri_dist_cab_deta"]; ?>',<?= $row_peri_dist_cab_view["peri_dist_cab_ano"]; ?>)" data-toggle="modal" data-target="#peri_dist_cab_nuev" >
				    <span class="icon-users icon"></span> Editar
				    </a></li>
                 <?php }?>
                 
                 
                 <?php if (permiso_activo(54)){?>
			    <li>
				    <a class="option" onclick="peri_dist_cab_del(<?= $row_peri_dist_cab_view["peri_dist_cab_codi"]; ?>)">
				    <span class="icon-users icon"></span>Eliminar
				    </a>
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
            <td colspan="3">
            <span class="icon-calendar icon"></span> Total de Periodos ( <?php echo $cc;?> )
            </td>
            
        </tr>
 </tfoot>
</table>

 
      
