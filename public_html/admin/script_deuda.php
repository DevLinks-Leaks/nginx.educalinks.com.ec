<?php
		 
	// Actualizacion de Valores (Comportamiento)
	if($_POST['opc']=='upd')
	{		 
		include ('../framework/dbconf.php');
		$params = array($_POST['alum_codi'],$_POST['curs_para_codi'],$_POST['tiene_deuda']);
		$sql="{call alum_acti_desa_deuda_upd(?,?,?)}";
		$alum_deuda = sqlsrv_query($conn, $sql, $params);  
		sqlsrv_fetch_array($alum_deuda);
	}	
		
?>