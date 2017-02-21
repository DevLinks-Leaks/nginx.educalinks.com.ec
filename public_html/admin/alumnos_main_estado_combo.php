<div class="alumnos_main_estado_combo"  style='width:100%;float:none'>
<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');

	$ALUM_EST_CODI = $PERI_CODI = 0;
	
	if(isset($_POST['peri_codi']))
		$PERI_CODI=$_POST['peri_codi'];
	else
		$PERI_CODI=$_SESSION['peri_codi'];
	
	if(isset($_POST['alum_est_codi']))
		$ALUM_EST_CODI=$_POST['alum_est_codi'];
	else
		$ALUM_EST_CODI=0;
	
	if(isset($_POST['alum_est_det']))
		$ALUM_EST_DET=$_POST['alum_est_det'];
	else
		$ALUM_EST_DET="";
	echo "<br>";
	echo "
	<table>
		<tr>";
	echo "	<td width='120px'>Estado: </td><td>";
	//'M' de estados cambiantes manualmente.
	$params = array($PERI_CODI, '%', 'M');
	$sql="{call alum_est_busq(?,?,?)}";
	$stmt_alum_main_estado_combo = sqlsrv_query($conn, $sql, $params);
            
	$seleccionado="";
	$funcion_ajax="	document.getElementById( 'div_bloqueos_view' ).innerHTML = '';".
					"document.getElementById( 'div_curs' ).innerHTML = '';".
					"var sl_estado = document.getElementById('sl_estado');".
					"var sl_estadoText = sl_estado.options[sl_estado.selectedIndex].innerHTML;".
					"load_ajax_ModalMatri('ModalMatri_footer',sl_estadoText,'".PrimeraMayuscula($ALUM_EST_DET)."');";
	echo "
		<select id='sl_estado' name='sl_estado' " ;
	echo "	onchange=\"".$funcion_ajax."\" 
			onkeyup=\"".$funcion_ajax."\" >;
			<option value='--'>Seleccione...</option>";
	while($row_alum_main_estado_combo= sqlsrv_fetch_array($stmt_alum_main_estado_combo))
	{
		if($row_alum_main_estado_combo["alum_est_peri_codi"]==$ALUM_EST_CODI)
		{
			$seleccionado=" ";
		}else
		{
			$seleccionado="";
		}
		echo "<option ".$seleccionado." value='".$row_alum_main_estado_combo['alum_est_peri_codi']."'>".PrimeraMayuscula($row_alum_main_estado_combo["alum_est_det"])."</option>";
	}
	echo "</select>";
	if ($ALUM_EST_CODI != 0)
		echo "<small><i> Dar click aqu&iacute; para cambiar estado...</i></small>";
	echo "</td></tr></table>
	<br>";
?> 
</div>