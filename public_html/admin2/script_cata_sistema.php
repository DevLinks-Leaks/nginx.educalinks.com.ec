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
		case 'add':
			$sql = "{call cata_add(?,?)}";
			$params = array($_POST['cata_padr_codi'],$_POST['cata_deta']);
			$stmt = sqlsrv_query($conn, $sql,$params);
			if( $stmt_opc === false )
			{
				echo "Error in executing statement .\n"; 
				die( print_r( sqlsrv_errors(), true));
			}
			else
			{
				echo "1";
			}
		break;
		case 'upd':
			$sql = "{call cata_upd(?,?,?)}";
			$params = array($_POST['cata_codi'],$_POST['cata_deta'],$_POST['cata_padr_codi']);
			$stmt = sqlsrv_query($conn, $sql,$params);
			if( $stmt_opc === false )
			{
				echo "Error in executing statement .\n"; 
				die( print_r( sqlsrv_errors(), true));
			}
			else
			{
				echo "1";
			}
		break;
	}
?>