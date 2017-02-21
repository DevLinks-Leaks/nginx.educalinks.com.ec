<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
 

	if(isset($_POST['add_nota']))
	{
		
		$fil=$_POST['fil'];
		$peri_dist_codi=$_POST['peri_dist_codi'];
		
		$i=1;
		while ($i<=$fil)
		{
			$alum_curs_para_mate_codi=$_POST['alum_curs_para_mate_codi_'.$i];
			$nota_peri_cual_codi=$_POST['nota_peri_cual_codi_'.$i];
			
			$params = array($peri_dist_codi,$alum_curs_para_mate_codi,$nota_peri_cual_codi);
			$sql="{call nota_cual_add(?,?,?)}";
			$nota_add = sqlsrv_query($conn, $sql, $params);  
			
			// EXECUCION SI TIENE GRUPO LA MATERIA DE ACTUALIZAR
			$params = array($alum_curs_para_mate_codi,$peri_dist_codi);
			$sql="{call nota_padr_upd(?,?)}";
			sqlsrv_query($conn, $sql, $params); 	
			$i++;
		}
	}
?>
