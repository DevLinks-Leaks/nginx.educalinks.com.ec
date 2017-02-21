<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'ingr_nota':
		
		$params = array($_SESSION['peri_codi'],$_POST['fecha_ini'],$_POST['fecha_fin']);
		$sql="{call uso_plataforma_ingr_nota(?,?,?)}";
		$uso_plataforma_ingr_nota = sqlsrv_query($conn, $sql, $params);  
		$row_uso_plataforma_ingr_nota= sqlsrv_fetch_array($uso_plataforma_ingr_nota);
		
		echo $row_uso_plataforma_ingr_nota['total'];
	break;
	case 'total_reprobado':
		
		$params = array($_SESSION['peri_codi'],$_POST['peri_dist_codi']);
		$sql="{call uso_plataforma_repr_nota(?,?)}";
		$uso_plataforma_ingr_nota = sqlsrv_query($conn, $sql, $params);  
		$row_uso_plataforma_ingr_nota= sqlsrv_fetch_array($uso_plataforma_ingr_nota);
		
		echo $row_uso_plataforma_ingr_nota['total_reprobados'];
	break;
}
?>