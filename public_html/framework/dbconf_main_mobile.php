
<?php
	$serverName = "certuslinks.com";		 
	$db = "Certuslinks_admin"; 
	$uid = "sa";
	$pwd = "R3dlink51981";
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
