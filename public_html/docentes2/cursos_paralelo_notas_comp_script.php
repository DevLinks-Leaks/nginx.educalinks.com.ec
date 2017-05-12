<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if(isset($_POST['add_nota']))
	{
		$col=$_POST['col'];
		$fil=$_POST['fil'];
		$peri_dist_codi=$_POST['peri_dist_codi'];
		
		$i=1;
		while ($i<=$col)
		{
			$j=1;
			while ($j<=$fil)
			{
				$alum_curs_para_codi=$_POST['alum_curs_para_codi_'.$i.'_'.$j];
				$nota=$_POST['nota_'.$i.'_'.$j];
				$indi_parc_codi=$_POST['indi_parc_codi_'.$i.'_'.$j];
				$alum_codi=$_POST['alum_codi_'.$i.'_'.$j];
				$observacion=$_POST['observacion_'.$i.'_'.$j];
				
				
				$params = array($alum_curs_para_codi,$indi_parc_codi,$nota);
				$sql="{call nota_comp_add(?,?,?)}";
				$nota_add = sqlsrv_query($conn, $sql, $params);  
					
				// INGRESO DE OBSERVACIONES
				$params = array($peri_dist_codi, $alum_codi, $observacion);
				$sql="{call nota_obse_add(?,?,?)}";
				sqlsrv_query($conn, $sql, $params); 
				
				$j++;
			}
			$i++;
		}	 
	}
?>
