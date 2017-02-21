<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$desc_deta=$_POST['desc_deta'];	 
		$params = array($desc_deta);
		$sql="{call lib_desc_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el descriptor.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Descriptor agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el descriptor.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$desc_codi=$_POST['desc_codi'];
		$desc_deta=$_POST['desc_deta'];	 
		$params = array($desc_codi,$desc_deta);
		$sql="{call lib_desc_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el descriptor.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Descriptor editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$desc_codi=$_POST['desc_codi']; 
		$params = array($desc_codi);
		$sql="{call lib_desc_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el descriptor.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Descriptor eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>