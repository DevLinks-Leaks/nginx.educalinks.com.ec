<?php
	/*Para conexión a BD*/
	require_once ('../framework/dbconf.php');
	
	/*Si existe variable xml en GET*/
	if (isset($_POST['datos']))
	{
		$datos = array ();
		$datos = json_decode($_POST['datos'], true);
	}
	else
		exit ("error");
		
	/*Generando el XML*/
	$xml  = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xml .= '<ROOT>';
			$xml .= '<cambio curs_para_dest="'.$datos['cambio']['curs_para_dest'];
			$xml .= '" curs_para_orig="'.$datos['cambio']['curs_para_orig'].'" alum_codi="'.$datos['cambio']['alum_codi'].'">';
			foreach ($datos['cambio']['materias'] as $materia)
			{
				$xml .= '<materia';
				$xml .= ' curs_para_mate_prof_dest="'.$materia["curs_para_mate_prof_dest"];
				$xml .= '" curs_para_mate_dest="'.$materia["curs_para_mate_dest"];
				$xml .= '" curs_para_mate_orig="'.$materia["curs_para_mate_orig"];
				$xml .= '" />';
			}
			$xml .= '</cambio>';
		$xml .= '</ROOT>';
		
	/*Armando los prepared statements*/
	$params = array ($xml);
	$sql = "{call alum_curs_para_cambiar (?)}";
	$stmt = sqlsrv_query ($conn, $sql, $params);
	
	/*¿Se ejecutó correctamente el SP?*/
	if ($stmt===false)
	{
		exit ("error");
	}
	
	/*¿Hubo algún error?*/
	$resultado = sqlsrv_fetch_array ($stmt);
	if (!is_null($resultado["error_mensaje"]))
	{
		exit ("error");
	}
	/*Todo bien*/
	echo "exito";
?>