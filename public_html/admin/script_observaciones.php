<?php
session_start();
$opcion = $_POST['opcion'];
$peri_dist_codi = $_POST['peri_dist_codi'];
$alum_codi = $_POST['alum_codi'];
$obse = $_POST['obse'];

switch ($opcion)
{
	case 'add':
		obse_add();
		break;
}

function obse_add ()
{
	require_once ('../framework/dbconf.php');
	$params = array ($GLOBALS['peri_dist_codi'], $GLOBALS['alum_codi'], $GLOBALS['obse']);
	$sql = "{call nota_obse_add (?,?,?)}";
	$stmt = sqlsrv_query ($conn, $sql, $params);
	if ($stmt === false)
	{
		die (print_r(sqlsrv_errors(), true));
	}
	{
		echo "Registro guardado";
	}
}
?>