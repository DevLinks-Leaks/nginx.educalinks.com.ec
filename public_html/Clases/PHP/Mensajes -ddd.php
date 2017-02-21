 
<?php  



	if(isset($_POST['DO'])){
		
		
		if ($_POST['DO']=='ADD'){
			
				session_start();
				include ('../../framework/dbconf.php');  
			
				
			
				$mens_de = $_POST['mens_de'];
				$mens_de_tipo = $_POST['mens_de_tipo'];
				$mens_para = $_POST['mens_para'];
				$mens_para_tipo = $_POST['mens_para_tipo'];
				$mens_titu = $_POST['mens_titu'];
				$mens_deta = str_replace("**","&",$_POST['mens_deta']);
			 		 
				$params = array($mens_de,$mens_de_tipo,$mens_para,$mens_para_tipo,$mens_titu,$mens_deta);
				$sql="{call mens_add(?,?,?,?,?,?)}";
				sqlsrv_query($conn, $sql, $params);  
			
		}
		
		
		if ($_POST['DO']=='DEL'){
			
				session_start();
				include ('../../framework/dbconf.php');  
			
			
			
				$mens_codi = $_POST['mens_codi'];
			 
			 
			 
				$params = array($mens_codi);
				$sql="{call mens_del(?)}";
				sqlsrv_query($conn, $sql, $params);  
			
		}
		
		
		
		 
	}
	
 

	
	
 
?>

 
 
	 