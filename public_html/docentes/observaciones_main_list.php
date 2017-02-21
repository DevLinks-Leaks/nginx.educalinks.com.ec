<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}

switch($opc){
	case 'obs_add':
		if(isset($_POST['curs_para_mate_codi'])){$curs_para_mate_codi=$_POST['curs_para_mate_codi'];}else{$curs_para_mate_codi="";}
		if(isset($_POST['alum_curs_para_codi'])){$alum_curs_para_codi=$_POST['alum_curs_para_codi'];}else{$alum_curs_para_codi="";}
		if(isset($_POST['tipo_obs'])){$tipo_obs=$_POST['tipo_obs'];}else{$tipo_obs="";}
		if(isset($_POST['obs_deta'])){$obs_deta=$_POST['obs_deta'];}else{$obs_deta="";}
		$prof_codi=$_SESSION['prof_codi'];
		
		$params_opc=array($curs_para_mate_codi,$alum_curs_para_codi,$prof_codi,$tipo_obs,$obs_deta);
		$sql_opc="{call observacion_add(?,?,?,?,?)}";
		$stmp_opc = sqlsrv_query($conn, $sql_opc,$params_opc); 
		if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
		$veri=lastId($stmp_opc);
		if ($veri>0){echo "OK";}else{echo "KO";}
	break;
	case 'obs_view':
		
	break;
	
}
?>