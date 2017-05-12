<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if (isset($_FILES['archivo'])) 
{
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    
	if ($extension!='exe')
	{	$nombre = $archivo['name'];
		if(!file_exists($_SESSION['ruta_materiales_carga']))
		{
			mkdir($_SESSION['ruta_materiales_carga'],0777,TRUE);
		}
		
		$sql_opc = "{call curs_para_mate_mater_add(?,?,?,?)}";
		$params_opc= array($_POST['mater_titu'],
						   $_POST['mater_deta'],
						   $extension,
						   $_POST['curs_para_mate_prof_codi']);
						   
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		
		
		
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} 
		$mater_view_opc=lastId($stmt_opc);
		if (move_uploaded_file($archivo['tmp_name'], $_SESSION['ruta_materiales_carga'].$mater_view_opc.".".$extension)) 
		{
			//Para auditoría
			$params = array($_POST['curs_para_mate_prof_codi']);
			$sql="{call curs_para_mate_prof_info(?)}";
			$curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params);
			$row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);

			$detalle="Curso paralelo : ".$row_curs_para_mate_prof_info['curs_deta'].' "'.$row_curs_para_mate_prof_info['para_deta'].'"';
			$detalle.=" Nivel : ".$row_curs_para_mate_prof_info['nive_deta'];
			$detalle.=" Materia : ".$row_curs_para_mate_prof_info['mate_deta'];
			$detalle.=" Material título: ".$_POST['mater_titu'];
			$detalle.=" Material detalle: ".$_POST['mater_deta'];
			$detalle.=" Extensión: ".$extension;
			registrar_auditoria (40, $detalle);
			echo 1;

		} else 
		{	echo 0;
		}
	}
	else
	{	echo 2;
	}
}
?>