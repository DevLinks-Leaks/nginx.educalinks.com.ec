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
			$_SESSION['ruta_foto_alumno']="../fotos/".$_SESSION['directorio']."/alumnos/".$_SESSION['peri_codi']."/";
			 
			 /*Cargo las equivalencias cualitativas*/
			$sql	= "{call equi_cual_cons(?)}";
			$params	= array($_SESSION['peri_codi']);
			$stmt	= sqlsrv_query($conn,$sql,$params);
			while ($row_e = sqlsrv_fetch_array($stmt))
			{	$equi_cual[] = array("nota_refe_cab_codi"=>$row_e["nota_refe_cab_codi"],
									 "nota_refe_cab_tipo"=>$row_e["nota_refe_cab_tipo"],
									 "nota_peri_cual_refe"=>$row_e["nota_peri_cual_refe"],
									 "nota_peri_cual_deta"=>$row_e["nota_peri_cual_deta"],
									 "nota_peri_cual_deta_2"=>$row_e["nota_peri_cual_deta_2"],
									 "nota_peri_cual_ini"=>$row_e["nota_peri_cual_ini"],
									 "nota_peri_cual_fin"=>$row_e["nota_peri_cual_fin"]);
			}
			$_SESSION['equivalencias'] = $equi_cual;
			/*Fin*/
		 
		}
	}
?>