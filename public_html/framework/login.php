<?php



	$params = array($_SESSION['codigo'],$_SESSION["CODREPRE"] );
	$sql="{call dbo.prof_login(?,?)}";
	$result2 = sqlsrv_query($conn, $sql, $params);  
	
	$_SESSION['valido'] = true;
	$_SESSION['NOMBRE'] = 'Agustin';      
	$_SESSION['APELLIDO'] = 'Agustin';          
	
	   
	$_SESSION['CODIGO'] = '22';
	
	$_SESSION["PERIODO"]=2013;
	$_SESSION["LET"]="A";
	
 
?>