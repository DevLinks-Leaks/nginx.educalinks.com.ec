
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
<table width="100%"   class="table table-striped">
	<thead>
		<tr>
			<th width="40%"><strong>Listado de periodos</strong></th>
			<th colspan="2"><strong>Opciones</strong></th>
		</tr>
	</thead>
	<tbody>
	 <?php while ($row_peri_view = sqlsrv_fetch_array($peri_view)) { $cc +=1; ?>
		<tr>
			<td height="29">  <?= $row_peri_view["peri_deta"]; ?> 
			 - Año : <?= $row_peri_view["peri_ano"]; ?></td>
			<td width="60%">
			<?php if (permiso_activo(55)){?>
			    <a class="btn btn-default" href="admin_periodos_etapas.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
				    <span class="fa fa-arrows-h btn_opc_lista_print"></span> Etapas
				    </a>
			    <?php }?>
                 
                 <?php if (permiso_activo(55)){?>
			    <a class="btn btn-default" href="admin_periodos_distribucion.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
				    <span class="fa fa-columns btn_opc_lista_print"></span> Distribuciones de notas</a>
			    <?php }?>
                 <?php if (para_sist(406)=='1'){?>
	                 <?php if (permiso_activo(531)){?>
					    <a class="btn btn-default" href="admin_periodos_promociones.php?peri_codi=<?= $row_peri_view["peri_codi"]; ?>">
					    <span class="fa fa-columns btn_opc_lista_print"></span> Promociones</a>
	                 <?php }?>
                 <?php }?>
                 
                 <?php if (permiso_activo(53)){?>
			    <a class="btn btn-default" onclick="peri_edi(<?= $row_peri_view["peri_codi"]; ?>,'<?= $row_peri_view["peri_deta"]; ?>',<?= $row_peri_view["peri_ano"]; ?>)" data-toggle="modal" data-target="#peri_nuev" >
				    <span class="fa fa-edit btn_opc_lista_editar"></span> Editar
				    </a>
			    <?php }?>
                 
                 
                 <?php if (permiso_activo(54)){?>
			    <a class="btn btn-default" onclick="peri_del(<?= $row_peri_view["peri_codi"]; ?>)">
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

 
      
