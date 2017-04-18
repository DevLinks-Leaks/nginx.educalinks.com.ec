<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'hora_aten_add':
		$hora_ini=$_POST['hora_ini'];
		$hora_fin=$_POST['hora_fin'];
		if($hora_ini >= $hora_fin){
			echo '-2';
		}else{
			$sql_opc = "{call hora_prof_add(?,?,?,?,?)}";
			$params_opc= array($_POST['prof_codi'],$_POST['hora_ini'],$_POST['hora_fin'],$_POST['dia_week'],$_POST['peri_codi']);
			$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
			if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
			$hor_view_opc=sqlsrv_fetch_array($stmt_opc);
			$hora_aten_res = $hor_view_opc['veri'];
			if($hora_aten_res>0){
				echo $hora_aten_res;
			}elseif($hora_aten_res=-3){
				echo "-3";
			}else{
				echo "-1";
			}
		}
		
	break;
	
	case 'hora_aten_del':
		$sql_opc = "{call hora_prof_del(?)}";
		$params_opc= array($_POST['hora_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=$_POST['hora_codi'];
		echo $usua_view_opc;
	break;
	
}
?>