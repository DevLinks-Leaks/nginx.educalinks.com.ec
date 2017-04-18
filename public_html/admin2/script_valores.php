<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if(isset($_POST['valo_codi'])){
	 $valo_codi=$_POST['valo_codi'];
	}
	
	
	// Actualizacion de Valores (Comportamiento)
	if(isset($_POST['upd_valo'])){
		if($_POST['upd_valo']=='Y'){
			 
			include ('../framework/dbconf.php');
			$params = array($valo_codi,$_POST['valo_deta']);
			$sql="{call valo_upd(?,?)}";
			$valo_upd = sqlsrv_query($conn, $sql, $params);  
			$row_valo_upd = sqlsrv_fetch_array($valo_upd);
			
			//Para auditoría
			//$detalle="Código: ".$aula_codi;
			//$detalle.=" Descripción: ".$_POST['aula_deta'];
			//registrar_auditoria (27, $detalle);
			
			  
		}
	}
	
 	$params = array($valo_codi);
	$sql="{call valo_info(?)}";
	$valo_info = sqlsrv_query($conn, $sql, $params);  
	$row_valo_info = sqlsrv_fetch_array($valo_info);
	 	
?>

<input  type="text"  value="<?= $row_valo_info["valo_deta"]; ?>" id="valo_deta_<?= $row_valo_info["valo_codi"]; ?>" name="valo_deta_<?= $row_valo_info["valo_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" />