 
<?php  

	session_start();
	include ('../framework/dbconf.php');  
	include ('../framework/funciones.php');  
	
	 if(isset($_POST['peri_acti_add'])){
		if($_POST['peri_acti_add']=='Y'){
			 
			include ('../framework/dbconf.php');
			
			 
			$peri_codi=$_POST['peri_codi'];
			$peri_fech_ini=$_POST['peri_fech_ini'];
			$peri_fech_fin=$_POST['peri_fech_fin'];
			$peri_etap_codi=$_POST['peri_etap_codi'];
			$peri_dist_codi=$_POST['peri_dist_codi'];
			$usua_codi=$_POST['usua_codi'];
			
			$params = array($peri_codi,$peri_fech_ini,$peri_fech_fin,$peri_etap_codi,$peri_dist_codi,$usua_codi);
			$sql="{call peri_acti_add(?,?,?,?,?,?)}";
			$peri_acti_add = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_acti_add);	
		 
		 	//Para auditoría
			$detalle="Código de periodo: ".$_POST['peri_codi'];
			$detalle.=" Fecha de inicio: ".$_POST['peri_fech_ini'];
			$detalle.=" Fecha de fin: ".$_POST['peri_fech_fin'];
			$detalle.=" Código de periodo etapa: ".$_POST['peri_etap_codi'];
			$detalle.=" Código de periodo distribución: ".$_POST['peri_dist_codi'];
			$detalle.=" Usuario: ".$_POST['usua_codi'];
			registrar_auditoria (35, $detalle);
		}
	}
	 if(isset($_POST['peri_acti_del'])){
		if($_POST['peri_acti_del']=='Y'){
			 
			include ('../framework/dbconf.php');
			
			 
			$peri_acti_codi=$_POST['peri_acti_codi'];			 
			$usua_codi=$_POST['usua_codi'];
			
			$params = array($peri_acti_codi);
			$sql="{call peri_acti_del(?)}";
			$peri_acti_add = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_acti_add);	
			
			//Para auditoría
			$detalle="Código de periodo activo: ".$_POST['peri_acti_codi'];
			registrar_auditoria (36, $detalle);
		 
		}
	}
 
?>

 
  