<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call curs_para_cons(?,?)}";
		$params = array($_SESSION['peri_codi'], $_GET['curso']);
		
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
				echo 'Paralelo: <select  class="form-control" id="sl_paralelos" name="sl_paralelos" onchange="CargarAsignaturas(this.value);">';
				echo '<option value="0">Seleccione...</option>';
				while($curso_view= sqlsrv_fetch_array($stmt))
				{
					echo '<option value="'.$curso_view["codigo"].'">'.$curso_view["descripcion"].'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo 'Paralelo:<select id="sl_paralelos" name="sl_paralelos"  disabled="disabled">';
                echo '<option value="-1">Seleccione</option>';
                echo '</select>';
			}
		}
?>