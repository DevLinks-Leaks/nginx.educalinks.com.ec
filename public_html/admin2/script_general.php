<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'validate_changelog_show':
		$json= json_decode($_POST['jsonC']);
		$xml = new DOMDocument("1.0","UTF-8");
		$root = $xml->createElement("root");
		foreach($json as $changelog){
			$chan = $xml->createElement("chan");			
			$chan->setAttribute("chan_codi",$changelog->chan_codi);
			$root->appendChild($chan);
		}
		$xml->appendChild($root);
		$params_validate = array($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO_CODI'],$xml->saveXML(),'C');
		$sql_validate="{call visi_usua_chan_add(?,?,?,?)}";
		$visi_usua_add = sqlsrv_query($conn, $sql_validate, $params_validate);
		if( $visi_usua_add === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al aplicar el estado.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
					'result'=>'Estado aplicado con éxito.' ));
		} 
		echo $result;
	
	break;
}
?>