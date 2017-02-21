<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql	= "{call moti_bloq_add(?,?)}";
		$params	= array($_POST['moti_bloq_deta'],$_POST['moti_bloq_obli']);
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
		{	$detalle="Motivo Detalle: ".$_POST['moti_bloq_deta']." Obligatorio: ".$_POST['moti_bloq_obli'];
			registrar_auditoria (51, $detalle);
			echo $rows_affected;
		}
		else
		{	echo "-1";
		}
	break;
	case 'upd':
		$sql		= "{call moti_bloq_upd(?,?,?)}";
		$params		= array($_POST['moti_bloq_codi'],$_POST['moti_bloq_deta'],$_POST['moti_bloq_obli']);
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
		{	$detalle = "Motivo Detalle: ".$_POST['moti_bloq_deta']." Obligatorio: ".$_POST['moti_bloq_obli']." (alum_moti_bloq_opci=".
			$_POST['moti_bloq_codi'].")";
			registrar_auditoria (52, $detalle);
			echo $rows_affected;
		}
		else
		{	echo "-1";
		}
	break;
	case 'del':
		$sql		= "{call moti_bloq_del(?)}";
		$params		= array($_POST['moti_bloq_codi']);
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
		{	$detalle = "(alum_moti_bloq_opci=".$_POST['moti_bloq_codi'].")";
			registrar_auditoria (53, $detalle);
			echo $rows_affected;
		}
		else
		{	echo "-1";
		}
	break;
}
?>