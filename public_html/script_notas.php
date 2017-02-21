<?php
	include ("framework/dbconf.php");
	$xml_notas_filas = $_POST['xml_notas_filas'];
	
	$params = array($xml_notas_filas);
	$sql = "{call notas_xml_add_single(?)}";
	$stmt = sqlsrv_query($conn,$sql,$params);
	
	if ($stmt===false)
	{
		 die( print_r( sqlsrv_errors(), true));
	}
	
	$row = sqlsrv_fetch_array ($stmt);
	echo $row['nota'];
?>