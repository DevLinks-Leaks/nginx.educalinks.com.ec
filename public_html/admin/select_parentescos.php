<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call parentescos_cons()}";
		$stmt = sqlsrv_query($conn, $sql);

		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			if (sqlsrv_has_rows($stmt))
			{
				echo '<label for="repr_parentesco">Parentesco:</label> <select id="sl_parentescos" name="sl_parentescos"></label>';
				while($rw= sqlsrv_fetch_array($stmt))
				{
					echo '<option value="'.$rw["codigo"].'">'.$rw["descripcion"].'</option>';
				}
				echo "</select>";
			}
		}
?>