<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call curs_para_alum_cons(?,?)}";
		$params = array($_SESSION['peri_codi'], $_GET['curso_paralelo']);
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
				echo 'Alumno: <select  class="form-control" id="sl_alumnos" name="sl_alumnos">';
				echo '<option value="0">Seleccione</option>';
				while($curso_view= sqlsrv_fetch_array($stmt))
				{
					echo '<option value="'.$curso_view["codigo"].'">'.$curso_view["nombres"].'</option>';
				}
				echo '<option value="-1">TODOS</option>';
				echo '</select>';
			}
			else
			{
				echo 'Alumno:<select  class="form-control" id="sl_alumnos" name="sl_alumnos"  disabled="disabled">';
                echo '<option value="0">Seleccione</option>';
                echo '</select>';
			}
		}
?>