<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$auto_nomb=$_POST['auto_nomb'];	
		$auto_apel=$_POST['auto_apel'];	 
		$params = array($auto_nomb,$auto_apel);
		$sql="{call lib_auto_add(?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el autor.' ));
		}else{
			sqlsrv_fetch($result);
			$result=sqlsrv_get_field($result,0);
			if($result>0)
			{
				$result= json_encode(array ('state'=>'success',
						'result'=>'Autor agregado con éxito.' ));
			}else{
				$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el autor.' ));
			}
		} 

		echo $result;
	break;
	case 'edit':
		$auto_codi=$_POST['auto_codi'];
		$auto_nomb=$_POST['auto_nomb'];	
		$auto_apel=$_POST['auto_apel'];	 
		$params = array($auto_codi,$auto_nomb,$auto_apel);
		$sql="{call lib_auto_edit(?,?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el autor.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Autor editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$auto_codi=$_POST['auto_codi']; 
		$params = array($auto_codi);
		$sql="{call lib_auto_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el autor.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Autor eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>