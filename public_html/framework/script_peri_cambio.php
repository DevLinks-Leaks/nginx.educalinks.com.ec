<?php

	 
	if(isset($_POST['upd_peri'])){
		if($_POST['upd_peri']=='Y'){
			
			include ('../framework/dbconf.php');
		 
			$peri_codi = $_POST['peri_codi'];
						
			$params = array($peri_codi);
			$sql="{call peri_info(?)}";			 
			$peri_info = sqlsrv_query($conn, $sql, $params);  
			$row_peri_info = sqlsrv_fetch_array($peri_info);
			
			
			$_SESSION['peri_codi']=$row_peri_info['peri_codi'];
			$_SESSION['peri_deta']=$row_peri_info['peri_deta'];	
			$_SESSION['peri_ano']=$row_peri_info['peri_ano'];			
			 
		 
		}
	}
	




?>