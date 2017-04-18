
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


 <table class=" table_striped ">
 <thead>
    <tr>
    <th>#</th>
    <th>Unidad</th>
    <th>Fecha Inicio</th>
    <th>Fecha Terminacion</th>
    <th>Estado</th>
    <th>Fecha de Ingreso</th>
    <th>Usuario Asigno</th>
    <th>&nbsp;</th>
  </thead>
  <?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) { $cc +=1; ?>
    <tr>
      <td><?= $cc?></td>
    <td><?= $row_curs_peri_view['peri_dist_padr'].'-'.$row_curs_peri_view['peri_dist_deta']?></td>
    <td><?=  date_format($row_curs_peri_view['nota_peri_fec_ini'], 'd/M/Y' ); ?></td>
    <td><?= date_format($row_curs_peri_view['nota_peri_fec_fin'], 'd/M/Y' ); ?></td>
    <td><?= $row_curs_peri_view['resu']?></td>
    <td><?= date_format($row_curs_peri_view['nota_peri_fec_in'], 'd/M/Y' ); ?></td>
    <td><?= $row_curs_peri_view['usua_codi']?></td>
    <td> <div class="menu_options">
              <ul>
                <li>
                  <a   class="option"  onclick="nota_perm_del(<?= $row_curs_peri_view['nota_perm_codi']?>,<?= $curs_para_mate_codi?>,<?= $curs_para_mate_prof_codi?>)"> 
                      <span class="icon-close icon"> </span> Eliminar
                  </a>
            
                </li>
              </ul>
            </div>           
     </td>
  </tr>
 <?php  }   ?>
<tfoot>
 <tr class="pager_table">
    <td colspan="8" ><span class="icon-users icon"> </span> Total de Permisos Asignados ( <?php echo $cc;?> )</td>
 </tr>
 </tfoot>
</table>