<?
	session_start();
    include ('../framework/dbconf.php');		
	$params = array($_GET['codigo'],null);
	$sql="{call cata_parroquia_cons(?,?)}";
	$stmt = sqlsrv_query($conn, $sql, $params);

	echo '<select class="form-control" id="alum_parr_naci" name="alum_parr_naci">';
	echo '<option value="">Seleccione</option>';
	while($parroquia_view= sqlsrv_fetch_array($stmt))
	{
		echo '<option value="'.$parroquia_view["codigo"].'" '.$seleccionado.'>'.$parroquia_view["descripcion"].'</option>';
	}
	echo '</select>';
?>