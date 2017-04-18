<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	if(isset($_POST['add_area'])){
		if($_POST['add_area']=='Y'){
			 
	 		$area_deta=$_POST['area_deta'];	 
			$params = array($area_deta,$peri_codi);
			$sql="{call area_add(?,?)}";
			$area_add = sqlsrv_query($conn, $sql, $params);  
			//$row_mate_add = sqlsrv_fetch_array($mate_add);
			
			if( $area_add === false ){
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}else{
				sqlsrv_fetch($area_add);
				$result=sqlsrv_get_field($area_add,0);
				if($result>0)
				{
					echo 'OK';
					//Para auditoría
					//$detalle="Descripción: ".$_POST['area_deta'];
					//registrar_auditoria (23, $detalle);
				}
			} 

		}
	}
	
							 
	if(isset($_POST['del_area'])){
		if($_POST['del_area']=='Y'){		
	 		$area_codi=$_POST['area_codi'];	 
			$params = array($area_codi);
			$sql="{call area_del(?)}";
			$area_del = sqlsrv_query($conn, $sql, $params);  

			if( $area_del === false ){
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}else{

				echo 'OK';
				//Para auditoría
				//$detalle="Código: ".$_POST['area_codi'];
				//registrar_auditoria (25, $detalle);

			}

		}
	}	

	if(isset($_POST['upt_area'])){
		if($_POST['upt_area']=='Y'){	
			
			
	 		$area_codi=$_POST['area_codi'];	  
			$area_deta=$_POST['area_deta'];	 
			
			$params = array($area_codi,$area_deta,$peri_codi);
			$sql="{call area_upd(?,?,?)}";
			$area_upd = sqlsrv_query($conn, $sql, $params);  
			
			if( $area_upd === false ){
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}else{
				echo 'OK';
				//Para auditoría
				//$detalle="Código: ".$_POST['mate_codi'] . "Perido: ".$peri_codi ;
				//registrar_auditoria (24, $detalle);

			}
			
		}
	}	

?>