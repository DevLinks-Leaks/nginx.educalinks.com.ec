<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if(isset($_GET['admin_moni_general_new_cc'])){ 
	 
		   
		  include ('dbconf.php');
		  $audi_codi=$_GET['admin_moni_general_new_cc'];
		  $params3 = array($audi_codi);
		  $sql="{call admin_moni_general_new_cc(?)}";
		  $admin_moni_general_new_cc = sqlsrv_query($conn, $sql, $params3);  
		  $row_admin_moni_general_new_cc = sqlsrv_fetch_array($admin_moni_general_new_cc);
		  
		  echo $row_admin_moni_general_new_cc['cc']; 	
		 
		
	}
	 	
?>
