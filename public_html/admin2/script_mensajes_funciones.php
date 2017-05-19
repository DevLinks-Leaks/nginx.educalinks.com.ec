<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){ $opc = $_POST['opc']; }else{ $opc = ""; }
switch($opc){
	case 'delete_all':
		$op = $_POST['op'];
		
		if( $op == 2 )
			$mens_who = 'P';
		if( $op == 3 )
			$mens_who='D';
		
		$mensajes = array();
		$mensajes = json_decode( $_POST['mensajes'], true );
		
		foreach ( $mensajes as $mensaje )
			$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.=  '<root>';
            $xml.=   '<mensaje ';
			$xml.=     'mens_codi="'.   $mensaje.'" ';
            $xml.=   " />";
			$xml.=   " </root>";
			
		$params = array( $xml, $mens_who );
		$sql="{call mens_xml_del(?,?)}";
		if (sqlsrv_query($conn, $sql, $params))
			print '¡Exito! Mensajes seleccionados eliminados.';
		else
			print '¡Error! No se pudo completar la solicitud. Vuelva a intentarlo en unos minutos';
		
		
	break;
	default:
	break;
}