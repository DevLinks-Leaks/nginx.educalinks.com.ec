<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql	= "{call bloq_opci_add(?,?)}";
		$params	= array($_POST['opci_codi'], $_POST['bloq_moti_codi']);
		$stmt	= sqlsrv_query($conn, $sql, $params);
		if($stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$rows_affected	= sqlsrv_rows_affected($stmt);
		if ($rows_affected === false)
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($rows_affected>0)
		{	echo $rows_affected;
		}
		else
		{	echo "-1";
		}
	break;
	case 'del':
		$sql		= "{call bloq_opci_del(?)}";
		$params		= array($_POST['bloq_opci_codi']);
		$stmt		= sqlsrv_query( $conn, $sql, $params);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$rows_affected	= sqlsrv_rows_affected($stmt);
		if ($rows_affected === false)
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($rows_affected>0)
		{	echo $rows_affected;
		}
		else
		{	echo "-1";
		}
	break;
}
?>