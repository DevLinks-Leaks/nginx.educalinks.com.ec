<?php
	include 'Classes/Alumnos.php';
	
	if (isset($_POST["reprcodi"]))
		$reprcodi = $_POST["reprcodi"];
	else
		$reprcodi = "";
	
	if (isset($_POST["pericodi"]))
		$pericodi = $_POST["pericodi"];
	else
		$pericodi = "";
		
	if (isset($_POST["opcion"]))
		$opcion = $_POST["opcion"];
	else
		$opcion = "listar_alumnos";
	
	$alumnos = new Alumnos();	
	$alumnos->getCodigoAlumno($reprcodi,$pericodi);
	

	switch ($opcion)
	{
		case "listar_alumnos":
			
			$json_alumnos = array();
			foreach($alumnos->rows as $alumno){
				$json_alumnos[] = array("codigo"=>$alumno['alum_codi'],"nombre"=>$alumno['alum_nomb'],"apellido"=>$alumno['alum_apel']);
			}
			$array_alumnos = array ("result"=>$json_alumnos);
			echo json_encode($array_alumnos);
		break;
	}
?>