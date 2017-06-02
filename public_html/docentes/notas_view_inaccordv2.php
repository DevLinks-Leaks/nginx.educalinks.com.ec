<?php 
	session_start();	 
	include ('../framework/dbconf.php');
 	include ('../framework/funciones.php'); 
  
	$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi']; 
	$params = array($curs_para_mate_prof_codi);
	$sql="{call nota_perm_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<table id='tbl_<?php echo $_POST['curs_para_mate_prof_codi'];?>' class="table table-striped">
	<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
		<tr>
			<th width="17" style='text-align:center;'>#</th>
			<th width="54" style='text-align:center;'>Cod. Permiso</th>
			<th width="60" style='text-align:center;'>Unidad</th>
			<th width="58" style='text-align:center;'>Fecha Inicio</th>
			<th width="99" style='text-align:center;'>Fecha Terminacion</th>
			<th width="46" style='text-align:center;'>Estado</th>
			<th width="75" style='text-align:center;'>Fecha de Ingreso</th>
			<th width="73" style='text-align:center;'>Usuario Asigno</th>
			<th width="129" style='text-align:center;'>Opciones</th>
		</tr>
	</thead>
	<tbody>
<?php  
	while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) 
	{ 
		$cc +=1; 
		$url_impr="actas/notas_ingresadas_pdf.php?peri_dist_codi="
				.$row_curs_peri_view['peri_dist_codi']."&curs_para_mate_codi="
				.$row_curs_peri_view['curs_para_mate_codi']."&curs_para_mate_prof_codi="
				.$row_curs_peri_view['curs_para_mate_prof_codi'];

		if ($row_curs_peri_view['nota_peri_esta_resu']=='A') 
		{ 
			$url="notas_upload.php?peri_dist_codi="
			.$row_curs_peri_view['peri_dist_codi']."&nota_perm_codi=".$row_curs_peri_view['nota_perm_codi']
			."&curs_para_mate_prof_codi=".$row_curs_peri_view['curs_para_mate_prof_codi'];
		}
?>
		<tr>
			<td style='text-align:center;'><?= $cc?></td>
			<td style='text-align:center;'><?= $row_curs_peri_view['nota_perm_codi']?></td>
			<td style='text-align:center;'><?= $row_curs_peri_view['peri_dist_padr'].'-'.$row_curs_peri_view['peri_dist_deta']?></td>
			<td style='text-align:center;'><?=  date_format($row_curs_peri_view['nota_peri_fec_ini'], 'd/M/Y' ); ?></td>
			<td style='text-align:center;'><?= date_format($row_curs_peri_view['nota_peri_fec_fin'], 'd/M/Y' ); ?></td>
			<td style='text-align:center;'><?= $row_curs_peri_view['resu']?></td>
			<td style='text-align:center;'><?= date_format($row_curs_peri_view['nota_peri_fec_in'], 'd/M/Y' ); ?></td>
			<td style='text-align:center;'><?= $row_curs_peri_view['usua_codi']?></td>
			<td style='text-align:center;'>
				<div class="btn-group-vertical">
					<?if ($row_curs_peri_view['nota_peri_esta_resu']=='A') {?>
					  <a onclick="form_notas_send(<?=$row_curs_peri_view['curs_para_mate_prof_codi'];?>,<?=$row_curs_peri_view['curs_para_mate_codi'];?>,<?=$row_curs_peri_view['peri_dist_codi'];?>,<?=$row_curs_peri_view['nota_perm_codi']?>,'in')" class="btn btn-success"> 
						  <span class="fa fa-plus"> </span> Ingresar Notas</a>
					<?}?>
						<a href="actas/notas_ingresadas_pdf.php?peri_dist_codi=<?=$row_curs_peri_view['peri_dist_codi'];?>&curs_para_mate_codi=<?=$row_curs_peri_view['curs_para_mate_codi'];?>&curs_para_mate_prof_codi=<?=$row_curs_peri_view['curs_para_mate_prof_codi'];?>" target="_blank" class="btn btn-default"> 
						  <span class="fa fa-print"> </span> Imprimir  Notas
						</a>
					  <a href="JavaScript:imprimirActa(<?=$row_curs_peri_view['curs_para_codi'];?>,<?=$row_curs_peri_view['curs_para_mate_codi'];?>,<?=$row_curs_peri_view['peri_dist_codi'];?>);" class="btn btn-default"><span class="fa fa-print"> </span> Imprimir Acta</a>          
				</div>
			</td>
		</tr>
 <?php  }   ?>
	</tbody>
</table>