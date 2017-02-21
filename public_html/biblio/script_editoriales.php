<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$edit_deta=$_POST['edit_deta'];	 
		$params = array($edit_deta);
		$sql="{call lib_edit_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la editorial.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Editorial agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la editorial.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$edit_codi=$_POST['edit_codi'];
		$edit_deta=$_POST['edit_deta'];	 
		$params = array($edit_codi,$edit_deta);
		$sql="{call lib_edit_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el editorial.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Editorial editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$edit_codi=$_POST['edit_codi']; 
		$params = array($edit_codi);
		$sql="{call lib_edit_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el editorial.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Editorial eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>