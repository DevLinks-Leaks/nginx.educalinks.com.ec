<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$cate_deta=$_POST['cate_deta'];	 
		$params = array($cate_deta);
		$sql="{call lib_cate_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar categoría.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Categoría agregada con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar categoría.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$cate_codi=$_POST['cate_codi'];
		$cate_deta=$_POST['cate_deta'];	 
		$params = array($cate_codi,$cate_deta);
		$sql="{call lib_cate_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar categoría.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Categoría editada con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$cate_codi=$_POST['cate_codi']; 
		$params = array($cate_codi);
		$sql="{call lib_cate_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar categoría.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Categoría eliminada con éxito.' ));
		} 

		echo $result;
	break;

}
?>