<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if(isset($_POST['para_codi'])){
	 $para_codi=$_POST['para_codi'];
	}
	
	
	// Actualizacion de paras
	if(isset($_POST['upd_para'])){
		if($_POST['upd_para']=='Y'){
			 
			include ('../framework/dbconf.php');
			$params = array($para_codi,$_POST['para_deta']);
			$sql="{call para_upd(?,?)}";
			$para_upd = sqlsrv_query($conn, $sql, $params);  
			$row_para_upd = sqlsrv_fetch_array($para_upd);	
			  
			//Para auditoría
			$detalle="Código: ".$para_codi;
			$detalle.=" Descripción: ".$_POST['para_deta'];
			registrar_auditoria (13, $detalle);
		}
	}
	
 	$params = array($para_codi);
	$sql="{call para_info(?)}";
	$para_info = sqlsrv_query($conn, $sql, $params);  
	$row_para_info = sqlsrv_fetch_array($para_info);
	 	
?>

<input  type="text"  value="<?= $row_para_info["para_deta"]; ?>" id="para_deta_<?= $row_para_info["para_codi"]; ?>" name="para_deta_<?= $row_para_info["para_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" />