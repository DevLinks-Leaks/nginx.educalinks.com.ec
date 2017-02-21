<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call curs_peri_mate_view(?)}";
		$params = array($_GET['curso_paralelo']);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			if (sqlsrv_has_rows($stmt))
			{
				echo 'Asignatura: <select id="sl_asignatura" name="sl_asignatura">';
				echo '<option value="0">Seleccione</option>';
				while($asign_view= sqlsrv_fetch_array($stmt))
				{
					echo '<option value="'.$asign_view["curs_para_mate_codi"].'">'.$asign_view["mate_deta"].'</option>';
				}
				echo '<option value="-1">TODOS</option>';
				echo '</select>';
			}
			else
			{
				echo 'Asignatura:<select id="sl_asignatura" name="sl_asignatura"  disabled="disabled">';
                echo '<option value="0">Seleccione</option>';
                echo '</select>';
			}
		}
?>