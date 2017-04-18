<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql_opc = "{call prof_add(?,?,?,?,?,?,?)}";
		$params_opc= array($_POST['usua_username'],$_POST['usua_nombre'],$_POST['usua_apellido'],$_POST['usua_email'],$_POST['usua_dire'],$_POST['usua_telf'],$_POST['usua_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
			
			//Para auditoría
			$detalle="Código: ".$usua_view_opc;
			$detalle.=" Cédula: ".$_POST['usua_cedu'];
			$detalle.=" Nombres: ".$_POST['usua_nombre'].' '.$_POST['usua_apellido'];
			$detalle.=" Usuario: ".$_POST['usua_username'];
			$detalle.=" e-Mail: ".$_POST['usua_email'];
			$detalle.=" Domicilio: ".$_POST['usua_dire'];
			$detalle.=" Teléfono: ".$_POST['usua_telf'];
			registrar_auditoria (9, $detalle); 
		}
		else
		{
			echo "-1";
		}
	break;
	case 'upd':
		$sql_opc = "{call prof_upd(?,?,?,?,?,?,?,?)}";
		echo $_POST['prof_codi'];
		$params_opc= array($_POST['usua_username'],$_POST['usua_nombre'],$_POST['usua_apellido'],$_POST['usua_email'],$_POST['usua_dire'],$_POST['usua_telf'],$_POST['usua_cedu'],$_POST['prof_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
			
			//Para auditoría
			$detalle="Código: ".$_POST['prof_codi'];
			$detalle.=" Cédula: ".$_POST['usua_cedu'];
			$detalle.=" Nombres: ".$_POST['usua_nombre'].' '.$_POST['usua_apellido'];
			$detalle.=" Usuario: ".$_POST['usua_username'];
			$detalle.=" e-Mail: ".$_POST['usua_email'];
			$detalle.=" Domicilio: ".$_POST['usua_dire'];
			$detalle.=" Teléfono: ".$_POST['usua_telf'];
			registrar_auditoria (9, $detalle); 
		}
		else
		{
			echo "-1";
		}
	break;
	case 'del':
		$sql_opc = "{call prof_del(?)}";
		$params_opc= array($_POST['prof_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=$_POST['prof_codi'];
		echo $usua_view_opc;
		
		//Para auditoría
		$detalle="Código: ".$_POST['prof_codi'];
		registrar_auditoria (11, $detalle); 
		
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
		}
	break;
	
}
?>