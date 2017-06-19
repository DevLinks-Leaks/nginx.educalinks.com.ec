<?php
	$domain=$_SERVER['HTTP_HOST'];
	$serverName = "certuslinks.com";		 
	$db = "Certuslinks_admin"; 
	$uid = "sa";
	$pwd = "$3cur!ty@@";
	$charset = "UTF-8";

	$connectionInfo = array("Database"=>$db, 
							"UID"=>$uid, 
							"PWD"=>$pwd, 
							"CharacterSet"=>$charset);
	$conn = sqlsrv_connect($serverName, $connectionInfo);

	if(!$conn)
	{
		echo "La conexión no se pudo establecer.<br/>";
		die( print_r( sqlsrv_errors(), true));
	}
?>
