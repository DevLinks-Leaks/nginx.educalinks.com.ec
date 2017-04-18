
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');

	
	if(isset($_POST['add_peri'])){
		if($_POST['add_peri']=='Y'){
			 
	 		$peri_deta=$_POST['peri_deta'];	 
			$peri_ano=$_POST['peri_ano'];	
			$params = array($peri_deta,$peri_ano);
			$sql="{call peri_add(?,?)}";
			sqlsrv_query($conn, $sql, $params);  
		}
	}
	
	if(isset($_POST['upd_peri'])){
		if($_POST['upd_peri']=='Y'){
			 
			$peri_codi=	$_POST['peri_codi'];	 
			$peri_deta=	$_POST['peri_deta'];	 
			$peri_ano=	$_POST['peri_ano'];	
			
			$params = array($peri_codi,$peri_deta,$peri_ano);
			$sql="{call peri_upd(?,?,?)}";
			sqlsrv_query($conn, $sql, $params);  
			
			
			  
		}
	}
	
	if(isset($_POST['del_peri'])){
		if($_POST['del_peri']=='Y'){		
	 		$peri_codi=$_POST['peri_codi'];	 
			$params = array($peri_codi);
			$sql="{call peri_del(?)}";
			sqlsrv_query($conn, $sql, $params);  
		 
		}
	}
	
	
							 
		
	$params = array();
	$sql="{call peri_view()}";
	$peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 
<table width="100%"   class="table_striped">
 <thead>
  <tr>
    <th width="40%"><strong>Listado de periodo</strong></th>
    <th colspan="2"><strong>Opciones</strong></th>
  </tr>
  </thead>


  <tbody>
 <?php  while ($row_peri_view = sqlsrv_fetch_array($peri_view)) { $cc +=1; ?>
  <tr >
    <td height="29">  <?= $row_peri_view["peri_deta"]; ?> 
     - Año : <?= $row_peri_view["peri_ano"]; ?></td>
    <td width="60%">
    
			<div class="menu_options" style="text-align:left;">
			  <ul>

			<?php if (permiso_activo(55)){?>
			    <li>
				    <a class="option" href="admin_periodos_etapas.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
				    <span class="icon-users icon"></span> Etapas
				    </a>
			    </li>
                 <?php }?>
                 
                 <?php if (permiso_activo(55)){?>
			    <li>
				    <a class="option" href="admin_periodos_distribucion.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
				    <span class="icon-users icon"></span>Distribuciones</a>
			    </li>
                 <?php }?>
                 <?php if (para_sist(406)=='1'){?>
	                 <?php if (permiso_activo(531)){?>
				    <li>
					    <a class="option" href="admin_periodos_promociones.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
					    <span class="icon-users icon"></span>Promociones</a>
				    </li>
	                 <?php }?>
                 <?php }?>
                 
                 <?php if (permiso_activo(53)){?>
			    <li>
				    <a class="option"   onclick="peri_edi(<?= $row_peri_view["peri_codi"]; ?>,'<?= $row_peri_view["peri_deta"]; ?>',<?= $row_peri_view["peri_ano"]; ?>)" data-toggle="modal" data-target="#peri_nuev" >
				    <span class="icon-users icon"></span> Editar
				    </a>
			    </li>
                 <?php }?>
                 
                 
                 <?php if (permiso_activo(54)){?>
			    <li>
				    <a class="option" onclick="peri_del(<?= $row_peri_view["peri_codi"]; ?>)">
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

 
      
