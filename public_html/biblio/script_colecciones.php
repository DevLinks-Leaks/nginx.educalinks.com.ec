<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

		$cole_deta=$_POST['cole_deta'];	 
		$params = array($cole_deta);
		$sql="{call lib_cole_add(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la coleccion.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Colección agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la coleccion.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$cole_codi=$_POST['cole_codi'];
		$cole_deta=$_POST['cole_deta'];	 
		$params = array($cole_codi,$cole_deta);
		$sql="{call lib_cole_edit(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el coleccion.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Colección editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$cole_codi=$_POST['cole_codi']; 
		$params = array($cole_codi);
		$sql="{call lib_cole_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el coleccion.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Colección eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>