<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	if(isset($_POST['add_mate'])){
		if($_POST['add_mate']=='Y'){
			 
	 		$mate_deta=$_POST['mate_deta'];	 
			$params = array($mate_deta,$_SESSION['peri_codi']);
			$sql="{call mate_add(?,?)}";
			$mate_add = sqlsrv_query($conn, $sql, $params);  
			//$row_mate_add = sqlsrv_fetch_array($mate_add);
			
			//Para auditoría
			$detalle="Descripción: ".$_POST['mate_deta'];
			registrar_auditoria (23, $detalle);
			
		}
	}
	
							 
	if(isset($_POST['del_mate'])){
		if($_POST['del_mate']=='Y'){		
	 		$mate_codi=$_POST['mate_codi'];	 
			$params = array($mate_codi);
			$sql="{call mate_del(?)}";
			$mate_del = sqlsrv_query($conn, $sql, $params);  
			
			//Para auditoría
			$detalle="Código: ".$_POST['mate_codi'];
			registrar_auditoria (25, $detalle);

		}
	}	

	if(isset($_POST['upt_mate_codi'])){
		if($_POST['upt_mate_codi']=='Y'){	
			
			
	 		$peri_codi=$_POST['peri_codi'];	 
			$mate_codi=$_POST['mate_codi'];
			 
			$mate_deta=$_POST['mate_deta'];	 
			$mate_abre=$_POST['mate_abre'];
			$area_codi=(($_POST['area_codi']=='') ? null : $_POST['area_codi']);
			$mate_prom=$_POST['mate_prom'];	 
			$mate_padr=$_POST['mate_padr'];	 
			$mate_tipo=$_POST['mate_tipo'];	
			
			if($mate_codi==$mate_padr){
				echo 'No se puede agrupar una materia consigo misma';
			}else{
				$params = array($peri_codi,$mate_codi,$mate_deta,$mate_abre,$mate_prom,$mate_padr,$mate_tipo,$area_codi);
				$sql="{call mate_peri_upd(?,?,?,?,?,?,?,?)}";
				$mate_peri_upd = sqlsrv_query($conn, $sql, $params);  
				
				//Para auditoría
				$detalle="Código: ".$_POST['mate_codi'] . "Perido: ".$peri_codi ;
				registrar_auditoria (24, $detalle);

				echo 'OK';
			}

			
		}
	}	

?>