<?
	session_start();
    include ('../framework/dbconf.php');		
	$params = array($_GET['codigo'],null);
	$sql="{call cata_provincia_cons(?,?)}";
	$stmt = sqlsrv_query($conn, $sql, $params);
	while($provincia_view= sqlsrv_fetch_array($stmt))
	{
		echo '<option value="'.$provincia_view["codigo"].'" '.$seleccionado.'>'.$provincia_view["descripcion"].'</option>';
	}
?>