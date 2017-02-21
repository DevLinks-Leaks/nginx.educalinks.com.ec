<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$tipo_deta=$_POST['tipo_deta'];	 
		$params = array($tipo_deta);
		$sql="{call lib_tipo_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el tipo.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Tipo agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el tipo.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$tipo_codi=$_POST['tipo_codi'];
		$tipo_deta=$_POST['tipo_deta'];	 
		$params = array($tipo_codi,$tipo_deta);
		$sql="{call lib_tipo_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el tipo.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Tipo editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$tipo_codi=$_POST['tipo_codi']; 
		$params = array($tipo_codi);
		$sql="{call lib_tipo_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el tipo.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Tipo eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>