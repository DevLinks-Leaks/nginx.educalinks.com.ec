<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql_opc = "{call usua_add(?,?,?,?,?)}";
		$params_opc= array($_POST['usua_username'],$_POST['usua_nombre'],$_POST['usua_apellido'],$_POST['usua_email'],$_POST['rol_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
			
			//Para auditoría
			$detalle="Código: ".$usua_view_opc;
			$detalle.=" Usuario: ".$_POST['usua_username'];
			$detalle.=" Nombres: ".$_POST['usua_nombre'].' '.$_POST['usua_apellido'];
			$detalle.=" e-Mail: ".$_POST['usua_email'];
			$detalle.=" Rol: ".$_POST['rol_codi'];
			registrar_auditoria (32, $detalle);
		}
		else
		{
			echo "-1";
		}
	break;
	case 'upd':
		$sql_opc = "{call usua_upd(?,?,?,?,?)}";
		$params_opc= array($_POST['usua_username'],$_POST['usua_nombre'],$_POST['usua_apellido'],$_POST['usua_email'],$_POST['rol_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
			//Para auditoría
			$detalle.="Usuario: ".$_POST['usua_username'];
			$detalle.=" Nombres: ".$_POST['usua_nombre'].' '.$_POST['usua_apellido'];
			$detalle.=" e-Mail: ".$_POST['usua_email'];
			$detalle.=" Rol: ".$_POST['rol_codi'];
			registrar_auditoria (33, $detalle);
		}
		else
		{
			echo "-1";
		}
	break;
	case 'del':
		$sql_opc = "{call usua_del(?)}";
		$params_opc= array($_POST['usua_username']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=$_POST['usua_username'];
		echo $usua_view_opc;

		//Para auditoría
		$detalle.="Usuario: ".$_POST['usua_username'];
		registrar_auditoria (34, $detalle);
	break;
	case 'veri_usua':
		$sql_opc = "{call usua_veri_username(?)}";
		$params_opc= array($_POST['usua_username']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc = sqlsrv_fetch_array($stmt_opc);
		if($_POST['usua_username']!=""){
			if($usua_view_opc['veri']>0){
				echo "<img src='../imagenes/butones/x_roja.png' /> El usuario actualmente ya existe, por favor escoger uno diferente.";}else{echo "<img src='../imagenes/butones/green_check.png' />";}
		}else{echo"";}
	break;
	case 'add_rol':
		$sql_opc = "{call rol_add(?,?,?)}";
		$params_opc= array($_POST['rol_deta'],$_POST['rol_estado'],$_POST['rol_finan']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$rol_view_opc=0;
		$rol_view_opc=lastId($stmt_opc);
		if($rol_view_opc>0)
		{
			echo $rol_view_opc;

			//Para auditoría
			$detalle="Código: ".$rol_view_opc;
			$detalle.=" Descripción: ".$_POST['rol_deta'];
			$detalle.=" Estado: ".$_POST['rol_estado'];
			registrar_auditoria (29, $detalle);
		}
		else
		{
			echo "-1";
		}
	break;
	case 'upd_rol':
		$sql_opc = "{call rol_upd(?,?,?)}";
		$params_opc= array($_POST['rol_codi'],$_POST['rol_deta'],$_POST['rol_finan']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$rol_view_opc=0;
		$rol_view_opc=lastId($stmt_opc);
		if($rol_view_opc>0)
		{
			echo $rol_view_opc;
			
			//Para auditoría
			$detalle="Código: ".$_POST['rol_codi'];
			$detalle.=" Descripción: ".$_POST['rol_deta'];
			registrar_auditoria (30, $detalle);
		}
		else
		{
			echo "-1";
		}
	break;
	case 'del_rol':
		$sql_opc = "{call rol_del(?)}";
		$params_opc= array($_POST['rol_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$rol_view_opc=$_POST['rol_codi'];
		echo $rol_view_opc;

		//Para auditoría
		$detalle="Código: ".$_POST['rol_codi'];
		registrar_auditoria (31, $detalle);
	break;
	
}
?>