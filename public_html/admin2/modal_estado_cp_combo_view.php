<?php 
	 
	include ('../framework/dbconf.php');
	
	$params = array($_SESSION['peri_codi']);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params); 
?>

<td width='120px'>Curso:</td>
<td><select id="curs_para_codi" 
		name="curs_para_codi" 
		class="select"
		onchange="load_ajax_alum_curso_cupo('div_cupo','modal_estado_cp_cupo_view.php','curs_para_codi='+ this.value,this.value);"
		onkeyup="load_ajax_alum_curso_cupo('div_cupo','modal_estado_cp_cupo_view.php','curs_para_codi='+ this.value, this.value);">
		<option value="0">Seleccione...</option>
		 <?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view))
				{  ?>
					<option value="<?= $row_curs_peri_view["curs_para_codi"]; ?>">
						<?= $row_curs_peri_view["curs_deta"]." \"".$row_curs_peri_view["para_deta"]."\""; ?>
					</option>
		 <?php  }?>
	</select>
</td>