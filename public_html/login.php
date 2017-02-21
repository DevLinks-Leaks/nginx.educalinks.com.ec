<?php
	if (isset($_POST['colegio']))
	{
		$colegio = $_POST['colegio'];
	}
	else
	{
		echo '{"success":0, "error_message":"No está enviando la variable post -colegio-"}';
		exit ();
	}
	
	if (isset($_POST['username']))
	{
		$username = $_POST['username'];
	}
	else
	{
		echo '{"success":0, "error_message":"No está enviando la variable post -username-"}';
		exit ();
	}
	
	if (isset($_POST['password']))
	{
		$password = $_POST['password'];
	}
	else
	{
		echo '{"success":0, "error_message":"No está enviando la variable post -password-"}';
		exit ();
	}
	
	switch ($colegio)
	{
		case "La Moderna":
			$dbname = "educalinks_moderna";
			$server = "186.101.64.250\MSSQLSERVER2008";
		break;
		
		case 'Ecomundo Babahoyo':
			$dbname = "educalinks_ecobab";
			$server = "108.179.196.99";
		break;
		
		case 'Ecomundo Babahoyo Vespertino':
			$dbname = "educalinks_ecobabvesp";
			$server = "108.179.196.99";
		break;
		
		case 'Maria Auxiliadora':
			$dbname = "educalinks_uemag";
			$server = "108.179.196.99";
		break;
		
		case 'Desarrollo':
			$dbname = "educalinks_desarrollo";
			$server = "186.101.64.250\MSSQLSERVER2008";
		break;
		
	}
	
	$connectionInfo = array("Database"=>$dbname, 
							"UID"=>"sa", 
							"PWD"=>"R3dlink5", 
							"CharacterSet"=>"UTF-8");
	$conn = sqlsrv_connect($server, $connectionInfo);
	if ($conn === false)
	{
		echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
		exit ();
	}
	
	$sql = "select repr_nomb, repr_apel, repr_codi from representantes where repr_usua='$username' and repr_pass='$password'";
	$stmt = sqlsrv_query ($conn, $sql);
	if ($stmt === false)
	{
		die( print_r( sqlsrv_errors(), true));
		exit ();
	}
	
	if (sqlsrv_has_rows($stmt))
	{
		echo '{"success":1, "error_message":"OK"}';
	}
	else
	{
		echo '{"success":0, "error_message":"No hay registro que coincida con el usuario y la clave ingresada"}';
	}
	
?>