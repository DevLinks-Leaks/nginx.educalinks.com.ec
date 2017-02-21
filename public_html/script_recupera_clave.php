<?php
session_start();
include ('framework/dbconf.php');
include ('framework/funciones.php');
if(isset($_POST['usua'])){$usua=$_POST['usua'];}else{$usua="";}

$params_permi=array($usua);
$sql_permi="{call usua_vali_username(?)}";
$permi = sqlsrv_query($conn, $sql_permi, $params_permi); 
$row_permi = sqlsrv_fetch_array($permi);
if($row_permi['usua_pass']!=""){
	$mensaje="<p>Contrase&ntilde;a: ".$row_permi['usua_pass']."</p>";
	$mensaje1="";
	$mensaje2="";
	$mensaje3="";
	$email_destino=$row_permi['usua_mail'];
	envio_correo($mensaje,$mensaje1,$mensaje2,$mensaje3,$email_destino);
	$_SESSION['erro2']="Su contrase&ntilde;a ha sido enviada al email que estaba registrado.";
	header('Location: recupera_clave.php');
}else{
	$_SESSION['erro2']="El usuario no existe en la base de datos";
	header('Location: recupera_clave.php');
}
?>