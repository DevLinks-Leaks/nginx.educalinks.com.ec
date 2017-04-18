<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
 

	if(isset($_POST['add_nota']))
	{
		
		$col=$_POST['col'];
		$fil=$_POST['fil'];
		
		$i=1;
		while ($i<=$col)
		{
			$j=0;
			while ($j<=$fil)
			{
				$alum_curs_para_mate_codi=$_POST['alum_curs_para_mate_codi_'.$i.'_'.$j];
				$nota=$_POST['nota_'.$i.'_'.$j];
				$peri_dist_codi=$_POST['peri_dist_codi_'.$i.'_'.$j];
				
				
				$params = array($alum_curs_para_mate_codi,$nota,$peri_dist_codi,'A',$_SESSION['usua_codi']);
				$sql="{call nota_add(?,?,?,?,?)}";
				$nota_add = sqlsrv_query($conn, $sql, $params);  
					
				// EXECUCION SI TIENE GRUPO LA MATERIA DE ACTUALIZAR
				$params = array($alum_curs_para_mate_codi,$peri_dist_codi);
				$sql="{call nota_padr_upd(?,?)}";
				sqlsrv_query($conn, $sql, $params); 
				
				$j++;
			}
			$i++;
		}
		 
	}
	
 
	 	
?>
