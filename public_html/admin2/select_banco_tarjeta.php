<?
	session_start();
    include ('../framework/dbconf.php');		
	$sql="{call cata_hijo_view(?)}";
	$params = array($_GET['idpadre']);
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
			// echo '<option value="">SELECCIONE</option>';
			while($banc_tarj_view= sqlsrv_fetch_array($stmt))
			{
				echo '<option value="'.$banc_tarj_view["codigo"].'">'.$banc_tarj_view["descripcion"].'</option>';
			}
		}
		else
		{
            echo '';
		}
	}
?>