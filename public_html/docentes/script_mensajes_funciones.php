<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){ $opc = $_POST['opc']; }else{ $opc = ""; }
switch($opc){
	case 'delete_all':
		$op = '';
		
		if( $_POST['op']== 2 )
			$op = 'D';
		if( $_POST['op']== 3 )
			$op = 'P';
		
		$mensajes = array();
		$mensajes = json_decode( $_POST['mensajes'], true );
		
		$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xml.=  '<root>';
		foreach ( $mensajes as $mensaje )
        {	$xml.=   '<mensaje mens_codi="' . $mensaje . '"/>';
		}
		$xml.=   " </root>";
			
		$params = array( $xml, $op );
		$sql="{call mens_xml_del(?,?)}";
		if (sqlsrv_query($conn, $sql, $params))
			print '¡Exito! Mensajes seleccionados eliminados.';
		else
			print '¡Error! No se pudo completar la solicitud. Vuelva a intentarlo en unos minutos';
		
	break;
	default:
	break;
}