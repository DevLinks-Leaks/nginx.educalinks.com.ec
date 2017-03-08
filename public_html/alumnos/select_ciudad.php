<?
	session_start();
    include ('../framework/dbconf.php');		
	$params = array($_GET["codigo"],null);
	$sql="{call cata_ciudad_cons(?,?)}";
	$stmt = sqlsrv_query($conn, $sql, $params);
	while($ciudad_view= sqlsrv_fetch_array($stmt))
	{
		
		echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
	}
?>