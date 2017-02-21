<?php
	if (isset($_POST["username"]))
		$username = $_POST["username"];
	else
		$username = "";
	
	if (isset($_POST["password"]))
		$password = $_POST["password"];
	else
		$password = "";
	
	if (isset($_POST["opcion"]))
		$opcion = $_POST["opcion"];
	else
		$opcion = "login";
	
	switch ($opcion)
	{
		case "login":
			require_once 'Representante.php';
			$obj = new Representante ();
			$obj->Login ($username, $password);
			echo json_encode($obj->resultado);
		break;
	}
?>