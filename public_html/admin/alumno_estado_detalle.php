<div class="div_alum_est_matr_checks">
<?php 

	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$alum_codi=0;
	$peri_codi=0;
	
	if(isset($_POST['peri_codi']))
		$peri_codi = $_POST['peri_codi'];
	else 
		$peri_codi = $_SESSION['peri_codi'];
	
	if(isset($_POST['alum_codi']))
		$alum_codi = $_POST['alum_codi'];
	else 
		die('<small>Resultado desconocido.</small>');
	
	$params = array($alum_codi, $peri_codi, 'A');
	$sql="{call alum_info_alum_est_info(?,?,?)}";
	$alum_info_alum_est_info = sqlsrv_query($conn, $sql, $params);
	echo "<br />";
	echo "<table width='100%'><tr><td width='120px' height='40px' valign='bottom' colspan='2'><b>Estados de estudiante matriculado</b></td></tr>";
	echo "<tr><td width='120px' height='1px' colspan='2'><div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div></td></tr>";
	echo "<tr><td width='120px'></td><td align='left'>";
	while ($row_alum_info_alum_est_info = sqlsrv_fetch_array($alum_info_alum_est_info))
	{
		echo "<table><tr><td width='150px'>";
		echo "	<input id='check_column_1' name='check_column_1' type='checkbox' "; 
		if($row_alum_info_alum_est_info["alum_alum_est_peri_matr_nueva"]==1){echo ' checked ';} 
		echo "	onClick=\"load_ajax_alum_info_est('div_checks', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, ".$alum_codi.", ".$peri_codi.", 1)\">
				<label for='check_column_1'>Matr&iacute;cula Nueva</label>";
		echo "</td><td align='left'>";
		echo "	<input id='check_column_2' name='check_column_2' type='checkbox' "; 
		if($row_alum_info_alum_est_info["alum_alum_est_peri_matr_extr"]==1){echo ' checked ';} 
		echo "	onClick=\"load_ajax_alum_info_est('div_checks', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, ".$alum_codi.", ".$peri_codi.", 2)\">
				<label for='check_column_2'>Matr&iacute;cula extranjero</label>";
		echo "</td></tr>";
		echo "<tr><td width='150px'>";
		echo "	<input id='check_column_3' name='check_column_3' type='checkbox' "; 
		if($row_alum_info_alum_est_info["alum_alum_est_peri_matr_con_pase"]==1){echo ' checked ';} 
		echo "	onClick=\"load_ajax_alum_info_est('div_checks', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, ".$alum_codi.", ".$peri_codi.", 3)\">
				<label for='check_column_3'>Matr&iacute;cula con pase</label>";
		echo "</td><td align='left'>";
		echo "	<input id='check_column_4' name='check_column_4' type='checkbox' "; 
		if($row_alum_info_alum_est_info["alum_alum_est_peri_ret_con_pase"]==1){echo ' checked ';} 
		echo "	onClick=\"load_ajax_alum_info_est('div_checks', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, ".$alum_codi.", ".$peri_codi.", 4)\">
				<label for='check_column_4'>Retiro con pase</label>";
		echo "</td></tr>";
		echo "<tr><td width='150px'>";
		echo "	<input id='check_column_5' name='check_column_5' type='checkbox' "; 
		if($row_alum_info_alum_est_info["alum_alum_est_peri_ret_exp"]==1){echo ' checked ';} 
		echo "	onClick=\"load_ajax_alum_info_est('div_checks', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, ".$alum_codi.", ".$peri_codi.", 5)\">
				<label for='check_column_5'>Retiro expulsado</label>";
		echo "</td><td align='left'>";
		echo "</td></tr>";
		echo "<tr><td width='120px'>";
		echo "</td></tr></table>";
	}
	echo "</td></tr></table>";
	
	$params_docu = array($peri_codi, '%');
	$sql_docu="{call docu_consulta(?,?)}";
	$docu_busq = sqlsrv_query($conn, $sql_docu, $params_docu);
	$i=0;
	$aux=array();
	while ($row_docu_busq = sqlsrv_fetch_array($docu_busq))
	{
		$aux[$i][0]=$row_docu_busq['docu_peri_codi'];
		$aux[$i][1]=$row_docu_busq['docu_descr'];
		$i++;
	}
	
	$params_alum_docu = array($alum_codi, $peri_codi);
	$sql_alum_docu="{call alum_info_docu(?,?)}";
	$docu_alum_docu = sqlsrv_query($conn, $sql_alum_docu, $params_alum_docu);
	$j=0;
	$aux2=array();
	while ($row_alum_docu = sqlsrv_fetch_array($docu_alum_docu))
	{
		$aux2[$j][0]=$row_alum_docu['docu_peri_codi'];
		$aux2[$j][1]=$row_alum_docu['alum_docu_peri_estado_documento'];
		$j++;
	}
	$x = $y = 0;
	$aux3=array();
	while($x<$i)
	{
		$f=0;
		$y=0;
		while($y<$j)
		{
			if($f==0)
			{
				if($aux[$x][0]==$aux2[$y][0])
				{
					$aux3[$x][0]=$aux[$x][0];
					$aux3[$x][1]=$aux[$x][1];
					$aux3[$x][2]=$aux2[$y][1];
					$f++;
				}
			}
			$y++;
		}
		if($f==0)
		{
			$aux3[$x][0]=$aux[$x][0];
			$aux3[$x][1]=$aux[$x][1];
			$aux3[$x][2]=0;
		}
		$x++;
	}
	$c=0;
	
	echo "
		  <table width='100%'><tr><td width='120px' height='40px' colspan='2' valign='bottom'><b>Documentos entregados</b></td></tr>";
	echo "<tr><td width='120px' height='1px' colspan='2'><div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div></td></tr>";
	echo "<tr><td width='120px'></td><td align='left'>";
	if($i>0)
	{
		while($c<$i)
		{
			echo "	<input id='check_".$aux3[$c][0]."' name='check_".$aux3[$c][0]."' type='checkbox' "; 
					if($aux3[$c][2]==1){echo ' checked ';} 
			echo "	onClick=\"load_ajax_alum_docu('div_checks', 'script_alum.php', 'alum_info_docu_check', 
					this.checked, ".$alum_codi.", ".$peri_codi.", ".$aux3[$c][0].")\">
					<label for='check_column_".$c."'>".$aux3[$c][1]."</label>";
			echo "<br />";
			$c++;
		}
	}else
	{
		echo "<i>-No hay objetos en esta categor&iacute;a-</i>";
	}
	echo "	</td></tr>
			</table>
			<br>";
?>
</div>