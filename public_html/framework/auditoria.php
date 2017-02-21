<?php
	session_start();	 
	include ('funciones.php'); 
	registrar_auditoria ($_POST['tipo_auditoria'], $_POST['detalle']);

?>
