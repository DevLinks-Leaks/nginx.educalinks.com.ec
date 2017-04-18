 
<?php  

	session_start();
	include ('../framework/dbconf.php');  
	include ('../framework/funciones.php');  
	
	 if(isset($_POST['nota_perm_add'])){
		if($_POST['nota_perm_add']=='Y'){
			 
			include ('../framework/dbconf.php');
			
			 
			$opcion=$_POST['opcion'];
			$vari_codi=$_POST['vari_codi'];
			$peri_dist_codi=$_POST['peri_dist_codi'];
			$nota_peri_fec_ini=$_POST['nota_peri_fec_ini'];
			$nota_peri_fec_fin=$_POST['nota_peri_fec_fin'];
			$usua_codi=$_POST['usua_codi'];
			
			$params = array($opcion,$vari_codi,$peri_dist_codi,$nota_peri_fec_ini,$nota_peri_fec_fin,$usua_codi);
			$sql="{call nota_perm_add_NEW(?,?,?,?,?,?)}";
			$para_upd = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($para_upd);	
			
			//Para auditoría
			$detalle="Código periodo distribución: ".$peri_dist_codi;
			$detalle.=" Fecha inicio: ".$nota_peri_fec_ini;
			$detalle.=" Fecha fin: ".$nota_peri_fec_fin;
			$detalle.=" Usuario: ".$usua_codi;
			registrar_auditoria(15, $detalle);
		 
		}
	}

 
?>

 
  