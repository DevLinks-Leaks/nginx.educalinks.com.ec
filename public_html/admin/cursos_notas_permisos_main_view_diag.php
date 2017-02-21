<?php  
	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
	
	$curs_para_codi=$_POST['curs_para_codi'];
	$pgi=$_POST['pgi'];
	 
	$params = array($curs_para_codi);
	$sql="{call curs_peri_mate_view($curs_para_codi)}";
	$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
	 
 ?>  
<select name="<?= $pgi; ?>_curs_peri_mate_codi"   id="<?= $pgi; ?>_curs_peri_mate_codi" >
 <?php  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) { ?>     
 	 <option value="<?= $row_curs_peri_mate_view['curs_para_mate_codi']; ?>">
	 	<?= $row_curs_peri_mate_view['mate_deta']; ?> / <?= $row_curs_peri_mate_view['prof_nomb']; ?>  <?= $row_curs_peri_mate_view['prof_apel']; ?>
      </option>
<?php }  ?>	  
</select>