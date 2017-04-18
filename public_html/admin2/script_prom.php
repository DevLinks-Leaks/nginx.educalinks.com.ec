<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'upd':

		$prom_codi=$_POST['prom_codi'];	
		$curs_codi=$_POST['curs_codi'];	 
		$prom_valu=$_POST['prom_valu'];
		$params = array($prom_codi,$curs_codi,$prom_valu,$_SESSION['peri_codi']);
		$sql="{call prom_upd(?,?,?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al actualizar promoción.' ));
		}else{

			$result= json_encode(array ('state'=>'success',
					'result'=>'Promoción actualizada con éxito.' ));
		} 

		echo $result;
	break;

}
?>