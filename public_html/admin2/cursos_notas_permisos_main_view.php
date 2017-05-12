<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['peri_codi'])) $PERI_CODI=$_POST['peri_codi'];
	else $PERI_CODI=$_SESSION['peri_codi'];
	
	$params = array($PERI_CODI);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<div class="cursos_notas_permisos_main_view">	
	<select class="form-control input-sm" id="cmb_cursos"
		onchange="load_ajax( 'div_cursos', 'cursos_notas_permisos_main_view_mate.php', 'curs_para_codi=' + document.getElementById('cmb_cursos').value)" >
		<option value='-1'>- Seleccione un curso -</option>
	<?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) { $cc +=1; ?>
		<option value='<?= $row_curs_peri_view["curs_para_codi"]; ?>'><?= $row_curs_peri_view["curs_deta"]; ?> - <?= $row_curs_peri_view["para_deta"]; ?></option>
	 <?php  }   ?>
	</select>
	<br>
	<div id="div_cursos" name="div_cursos">
	</div>
</div>