<?php
	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	if(isset($_POST['opc']))
	{
		$opc=$_POST['opc'];
	}
	else
	{
		$opc="";
	}
	switch($opc)
	{
		case 'upd':
			$sql = "{call para_sist_upd(?,?)}";
			$params = array($_POST['sist_codi'],$_POST['sist_valo']);
			$stmt = sqlsrv_query($conn, $sql,$params);
			if( $stmt_opc === false )
			{
				echo "Error in executing statement .\n"; die( print_r( sqlsrv_errors(), true));
			}
			else
			{
				echo "1";
			}
		break;
	}
?>