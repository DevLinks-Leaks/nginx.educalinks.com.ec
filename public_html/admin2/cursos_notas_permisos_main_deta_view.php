
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');  
	
	if(isset($_GET['curs_para_mate_codi'])) $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
	if(isset($_GET['curs_para_mate_prof_codi'])) $curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
	 
	if(isset($_GET['nota_perm_del'])){
		if($_GET['nota_perm_del']=='Y'){
			 
			$nota_perm_codi=$_GET['nota_perm_codi'];
			
			$params = array($nota_perm_codi);
			$sql="{call nota_perm_del(?)}";
			$nota_perm_del = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($nota_perm_del);	
		 
			//Para auditoría
		 
			$detalle.=" nota_perm_codi: ".$nota_perm_codi;
			$detalle.=" Usuario: ".$usua_codi;
			registrar_auditoria(37, $detalle);
		 
		
		}
	}
	$params = array($curs_para_mate_prof_codi);
	$sql="{call nota_perm_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
 

?>


 <table class="table table-striped">
 <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
    <tr>
    <th style='text-align:center;'>#</th>
    <th style='text-align:center;'>Unidad</th>
    <th style='text-align:center;'>Fecha Inicio</th>
    <th style='text-align:center;'>Fecha Terminacion</th>
    <th style='text-align:center;'>Estado</th>
    <th style='text-align:center;'>Fecha de Ingreso</th>
    <th style='text-align:center;'>Usuario Asigno</th>
    <th style='text-align:center;'>Eliminar</th>
  </thead>
  <?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) { $cc +=1; ?>
    <tr>
		<td style='text-align:center;'><?= $cc?></td>
		<td style='text-align:center;'><?= $row_curs_peri_view['peri_dist_padr'].'-'.$row_curs_peri_view['peri_dist_deta']?></td>
		<td style='text-align:center;'><?=  date_format($row_curs_peri_view['nota_peri_fec_ini'], 'd/M/Y' ); ?></td>
		<td style='text-align:center;'><?= date_format($row_curs_peri_view['nota_peri_fec_fin'], 'd/M/Y' ); ?></td>
		<td style='text-align:center;'><?= $row_curs_peri_view['resu']?></td>
		<td style='text-align:center;'><?= date_format($row_curs_peri_view['nota_peri_fec_in'], 'd/M/Y' ); ?></td>
		<td style='text-align:center;'><?= $row_curs_peri_view['usua_codi']?></td>
		<td style='text-align:center;'> <a class="btn btn-default"
				title='Eliminar' onmouseover='$(this).tooltip("show");' data-placement='left'
				onclick="nota_perm_del(<?= $row_curs_peri_view['nota_perm_codi']?>,<?= $curs_para_mate_codi?>,<?= $curs_para_mate_prof_codi?>)"> 
					<span class="fa fa-trash btn_opc_lista_eliminar"></span>
			</a>
		</td>
  </tr>
 <?php  }   ?>
<tfoot>
 <tr class="pager_table">
    <td colspan="8" ><span class="icon-users icon"> </span> Total de Permisos Asignados ( <?php echo $cc;?> )</td>
 </tr>
 </tfoot>
</table>