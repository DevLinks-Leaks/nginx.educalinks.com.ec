<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	
	case 'upd':
		$sql_opc = "{call usua_upd_all(?,?,?)}";
		$params_opc= array($_POST['usua_username'],$_POST['usua_tipo'],$_POST['usua_pass']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0){
			echo $usua_view_opc;
		}else{
			echo "-1";
		}
	break;
	
	
	
}
?>