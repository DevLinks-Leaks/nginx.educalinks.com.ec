<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql_opc = "{call alum_bloq_add(?,?,?,?)}";
		$params_opc= array($_POST['alum_nombre'],$_POST['alum_apellido'],$_POST['alum_cedu'],$_POST['alum_obse']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
		}
		else
		{
			echo "-1";
		}
	break;
	case 'upd':
		$sql_opc = "{call alum_bloq_upd(?,?,?,?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['alum_nombre'],$_POST['alum_apellido'],$_POST['alum_cedu'],$_POST['alum_obse']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
		}
		else
		{
			echo "-1";
		}
	break;
	case 'del':
		$sql_opc = "{call alum_bloq_del(?)}";
		$params_opc= array($_POST['alum_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$alum_view_opc=$_POST['alum_codi'];
		echo $alum_view_opc;
		
	break;
}
?>