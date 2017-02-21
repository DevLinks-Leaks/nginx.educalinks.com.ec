<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$proc_deta=$_POST['proc_deta'];	 
		$params = array($proc_deta);
		$sql="{call lib_proc_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la procedencia.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Procedencia agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la procedencia.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$proc_codi=$_POST['proc_codi'];
		$proc_deta=$_POST['proc_deta'];	 
		$params = array($proc_codi,$proc_deta);
		$sql="{call lib_proc_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el procedencia.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Procedencia editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$proc_codi=$_POST['proc_codi']; 
		$params = array($proc_codi);
		$sql="{call lib_proc_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el procedencia.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Procedencia eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>