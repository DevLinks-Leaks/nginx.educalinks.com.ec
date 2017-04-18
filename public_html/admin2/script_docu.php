<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$sql_opc = "{call docu_add(?,?)}";
		$params_opc= array($_POST['docu_descr'], $_POST['peri_codi']);
		$options_tareas =  array( "Scrollable" => "buffered" );
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc, $options_tareas);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while($row_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC)) 
			{	echo $row_count_tareas;
				$detalle1=" Código: ".$row_docu['docu_peri_codi'];
				$detalle1+=" Descripción: ".$_POST['docu_descr'];
				$detalle1+=" Periodo activo: ".$_POST['peri_codi'];
				$detalle1+=" Documento: ".$row_docu['docu_codi'];
				registrar_auditoria (48, $detalle1);
				$detalle2="Código: ".$row_docu['docu_codi'];
				$detalle2+=" Descripción: ".$_POST['docu_descr'];
				registrar_auditoria (48, $detalle2);
			}			
		}
		else
		{
			echo "-1";
		}
	break;
	case 'upd':
		$sql_opc = "{call docu_upd(?,?)}";
		$params_opc= array($_POST['docu_codi'], $_POST['docu_descr']);
		$options_tareas =  array( "Scrollable" => "buffered" );
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc, $options_tareas);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while( $row_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC) ) 
			{	echo $row_count_tareas;
				$detalle2=" Código: ".$row_docu['docu_codi'];
				$detalle2+=" Descripción: ".$row_docu['docu_descr'];
				registrar_auditoria (49, $detalle2);
			}			
		}
		else
		{
			echo "-1";
		}
	break;
	case 'del':
		$sql_opc = "{call docu_del(?)}";
		$params_opc= array($_POST['docu_codi']);
		$options_tareas =  array( "Scrollable" => "buffered" );
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc, $options_tareas);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while( $row_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC) ) 
			{	echo $row_count_tareas;
				$detalle2="Código: ".$row_docu['docu_codi'];
				registrar_auditoria (50, $detalle2);
			}			
		}
		else
		{
			echo "-1";
		}
	break;
	case 'check':
		$sql_opc="{call docu_check(?,?,?,?)}";
		$params_opc = array($_POST['check'], $_POST['docu_codi'], $_POST['peri_codi'], $_POST['docu_peri_codi']);
		$options_tareas =  array( "Scrollable" => "buffered" );
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc, $options_tareas);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while( $row_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC) ) 
			{	echo $row_count_tareas;
				$detalle2=" Código: ".$row_docu['codigo'];
				$detalle2+=" Filas modificadas: ".$row_docu['columnas'];
				$detalle2+=" Filas creadas: ".$row_docu['insertado'];
				registrar_auditoria (49, $detalle2);
			}			
		}
		else
		{
			echo $row_count_tareas;
		}
	break;
	//////////////////////////////////////////////
}
?>