<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if(isset($_POST['aula_codi'])){
	 $aula_codi=$_POST['aula_codi'];
	}
	
	
	// Actualizacion de Aulas
	if(isset($_POST['upd_aula'])){
		if($_POST['upd_aula']=='Y'){
			 
			include ('../framework/dbconf.php');
			$params = array($aula_codi,$_POST['aula_deta']);
			$sql="{call aula_upd(?,?)}";
			$aula_upd = sqlsrv_query($conn, $sql, $params);  
			$row_aula_upd = sqlsrv_fetch_array($aula_upd);
			
			//Para auditoría
			$detalle="Código: ".$aula_codi;
			$detalle.=" Descripción: ".$_POST['aula_deta'];
			registrar_auditoria (27, $detalle);
			
			  
		}
	}
	
 	$params = array($aula_codi);
	$sql="{call aula_info(?)}";
	$aula_info = sqlsrv_query($conn, $sql, $params);  
	$row_aula_info = sqlsrv_fetch_array($aula_info);
	 	
?>

<input  type="text"  value="<?= $row_aula_info["aula_deta"]; ?>" id="aula_deta_<?= $row_aula_info["aula_codi"]; ?>" name="aula_deta_<?= $row_aula_info["aula_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" />