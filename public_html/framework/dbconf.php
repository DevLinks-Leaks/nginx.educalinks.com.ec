<?php
	session_start();
	if (isset($_SESSION['db']) == false) header('Location: ../index.php');
	$connectionInfo = array("Database"=>$_SESSION['db'], 
							"UID"=>$_SESSION['user'], 
							"PWD"=>$_SESSION['pass'], 
							"CharacterSet"=>"UTF-8");
							
	$serverName = $_SESSION['host'];
	$conn = sqlsrv_connect($serverName, $connectionInfo);
	if( $conn === false)
	{	echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
	}
?>
