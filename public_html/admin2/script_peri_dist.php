 
<?php  

	session_start();
	include ('../framework/dbconf.php');  
	include ('../framework/funciones.php');  
	
	 if(isset($_POST['peri_dist_copy_all'])){
		if($_POST['peri_dist_copy_add']=='Y'){
			 
			$peri_codi=$_POST['peri_codi'];
			$peri_codi=$_POST['peri_codi_copy'];
			 
			$params = array($peri_codi,$peri_codi_copy);
			$sql="{call peri_acti_add(?,?)}";
			$peri_acti_add = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_acti_add);	
		 
		 
		}
	}
	 if(isset($_POST['peri_dist_copy_del'])){
		if($_POST['peri_dist_copy_del']=='Y'){
			 
			include ('../framework/dbconf.php');		
			 
			$peri_codi=$_POST['peri_codi'];			 
			 
			$params = array($peri_codi);
			$sql="{call peri_dist_del_all(?)}";
			$peri_dist_del_all = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_dist_del_all);	
			
		 
		 
		}
	}
	if(isset($_POST['peri_dist_codi_ADD'])){
		if($_POST['peri_dist_codi_ADD']=='Y'){
			
			 			
			$peri_dist_cab_codi=$_POST['peri_dist_cab_codi'];
			$peri_dist_deta=$_POST['peri_dist_deta'];
			$peri_dist_padr=$_POST['peri_dist_padr'];
			
			$peri_dist_nota_tipo=$_POST['peri_dist_nota_tipo'];
			$peri_dist_nive=$_POST['peri_dist_nive'];
			$peri_dist_abre=$_POST['peri_dist_abre'];
			
			$peri_dist_libt=$_POST['peri_dist_libt'];
			$nota_refe_cab_codi=$_POST['nota_refe_cab_codi'];
			
			echo $peri_dist_cab_codi,$peri_dist_deta,$peri_dist_padr,$peri_dist_nota_tipo,$peri_dist_nive,$peri_dist_abre,$peri_dist_libt,$nota_refe_cab_codi;
			
			 
			$params = array($peri_dist_cab_codi,$peri_dist_deta,$peri_dist_padr,$peri_dist_nota_tipo,$peri_dist_nive,$peri_dist_abre,$peri_dist_libt,$nota_refe_cab_codi);
			$sql="{call peri_dist_add(?,?,?,?,?,?,?,?)}";
			$peri_dist_add = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_dist_add);	
		 
		 
		}
	}
	if(isset($_POST['peri_dist_codi_DEL'])){
		if($_POST['peri_dist_codi_DEL']=='Y'){
			
			 			
			$peri_dist_codi=$_POST['peri_dist_codi'];
			
			 
			$params = array($peri_dist_codi);
			$sql="{call peri_dist_del(?)}";
			$peri_dist_del = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($peri_dist_del);	
		 
		 
		}
	}
 
 
 	if(isset($_POST['nota_refe_add'])){
		if($_POST['nota_refe_add']=='Y'){
			
			 	
			$peri_dist_codi=$_POST['peri_dist_codi'];
			$nota_refe_cab_codi=$_POST['nota_refe_cab_codi'];
			
			 
			$params = array($peri_dist_codi,$nota_refe_cab_codi);
			$sql="{call nota_refe_add(?,?)}";
			$nota_refe_add = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($nota_refe_add);	
		 
		 
		}
	}
 
	if(isset($_POST['nota_refe_upt_cc'])){
		if($_POST['nota_refe_upt_cc']=='Y'){
			
			$nota_refe_cod	=	$_POST['nota_refe_cod'];
			$nota_refe_cc  =	$_POST['nota_refe_cc'];	
			$nota_refe_1  =		$_POST['nota_refe_1'];
			$nota_refe_2  =		$_POST['nota_refe_2'];
			$nota_refe_num_dec  =		$_POST['nota_refe_num_dec'];
			$nota_refe_func_dec  =		$_POST['nota_refe_func_dec'];
			
			 
			$params = array($nota_refe_cod,$nota_refe_cc,$nota_refe_1,$nota_refe_2,$nota_refe_num_dec,$nota_refe_func_dec);
			$sql="{call nota_refe_upt_cc(?,?,?,?,?,?)}";
			$nota_refe_upt_cc = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($nota_refe_upt_cc);	
		 
		 
		}
	}
	
	if(isset($_POST['nota_refe_del'])){
		if($_POST['nota_refe_del']=='Y'){
			
			$nota_refe_cod	=	$_POST['nota_refe_cod'];
			 			 
			$params = array($nota_refe_cod);
			$sql="{call nota_refe_del(?)}";
			$nota_refe_del = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($nota_refe_del);	
		 
		 
		}
	}
	
		if(isset($_POST['nota_refe_pos'])){
		if($_POST['nota_refe_pos']=='Y'){
			
			$nota_refe_cod		=	$_POST['nota_refe_cod'];
			$nota_refe_opcion	=	$_POST['nota_refe_opcion'];
			 			 
			$params = array($nota_refe_cod,$nota_refe_opcion);
			$sql="{call nota_refe_pos(?,?)}";
			$nota_refe_pos = sqlsrv_query($conn, $sql, $params);  
			sqlsrv_fetch_array($nota_refe_pos);	
		 
		 
		}
	}

 ?> 
  