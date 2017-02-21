<?
        include ('../framework/dbconf.php');
		$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
		$total_alumnos=$_POST['alumnos_seleccionados'];
		
		$sql="{call alum_curs_para_mate_prof_add(?,?)}";
		
		$cont=1;
		while ($cont<=$total_alumnos)
		{
			echo $_POST['alumno_'.$cont]."**";
			$params = array($_POST['alumno_'.$cont], $curs_para_mate_prof_codi);
			$stmt = sqlsrv_query($conn, $sql, $params);
			
			if( $stmt === false )
			{
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}
			$cont++;
		}
?>