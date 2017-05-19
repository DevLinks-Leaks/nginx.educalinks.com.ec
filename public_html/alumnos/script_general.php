<?php
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'visi_usua_add':
		
		$sql	= "{call visi_usua_add(?,?,?,?)}";
		$params	= array($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO_CODI'],$_POST['codi'],$_POST['tipo']);
		$stmt_al	= sqlsrv_query($conn,$sql,$params);
		if ($stmt_al===false){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al completar la visualización.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
						'result'=>'Visualización realizada con éxito.' ));
		}
		echo $result;
	break;
}
?>