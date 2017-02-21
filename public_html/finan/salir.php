<?php
	session_start();
	
	include ('../framework/funciones.php');
	session_activa();
	
	//Para auditoría
	$ua = getBrowser();
	$detalle="Ip: ".$_SERVER['REMOTE_ADDR'];
	$detalle.=" Navegador: ".$ua['name'];
	$detalle.=" Versión: ".$ua['version'];
	$detalle.=" Plataforma: ".$ua['platform'];
	registrar_auditoria (2, $detalle);
	
	session_unset();
	session_destroy();
	$server=$_SERVER['SERVER_NAME'];
	echo "http://".$server."/index.php";
	header("Location:http://".$server."/index.php");
?> 
