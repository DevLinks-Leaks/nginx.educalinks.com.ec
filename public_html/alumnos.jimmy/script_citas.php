<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'cita_add':
		if(isset($_POST['hora_codi'])){$hora_codi=$_POST['hora_codi'];}else{$hora_codi="";}
		if(isset($_POST['alum_curs_para_mate_codi'])){$alum_curs_para_mate_codi=$_POST['alum_curs_para_mate_codi'];}else{$alum_curs_para_mate_codi="";}
		if(isset($_POST['prof_codi'])){$prof_codi=$_POST['prof_codi'];}else{$prof_codi="";}
		if(isset($_POST['hora_dia'])){$hora_dia=$_POST['hora_dia'];}else{$hora_dia="";}
		if(isset($_POST['fecha_cita'])){$fecha_cita=$_POST['fecha_cita'];}else{$fecha_cita="";}
		
		$repre_codi=$_SESSION['repr_codi'];
		$fecha_cita = str_replace('/','-',$fecha_cita);
		$fecha_cita_date = date('Y-m-d',strtotime($fecha_cita));

		$sql_opc = "{call hora_prof_fech_add(?,?,?,?)}";
		$params_opc= array($repre_codi,$hora_codi,$alum_curs_para_mate_codi,$fecha_cita_date);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$usua_view_opc=0;
		$usua_view_opc=lastId($stmt_opc);
		if($usua_view_opc>0)
		{
			echo $usua_view_opc;
		}
		
	break;
}
?>