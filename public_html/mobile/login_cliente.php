<?php
	//echo (json_encode(app_login ($_POST["opcion"], $_POST["opcion"])));
	
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
		$opcion = "";
	
	switch ($opcion)
	{
		case "login":
			echo json_encode(app_login ($username, $password));
		break;
	}
	
	function app_login ($username, $password)
	{
		include('db_conf.php');
		$params = array($username,$password);	
		$sql="{call main_logi_ws(?,?)}";
		$stmt = sqlsrv_query($conn, $sql, $params);
		if ($stmt===false)
		{
			$raiz = array("exito"=>"KO","mensaje"=>"Error en la BD");
			return $raiz;
		}
		else
		{
			if (sqlsrv_has_rows($stmt))
			{
				$raiz = array("exito"=>"OK","mensaje"=>$username);
				return $raiz;
			}
			else
			{
				$raiz = array("exito"=>"KO","mensaje"=>"El usuario ".$username." no existe");
				return $raiz;
			}
		}
	}
?>