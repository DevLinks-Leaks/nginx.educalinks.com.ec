<?php
    function get_database_params ()
	{
		require_once ('funciones.php');
		require_once ('dbconf_main.php');
		
		$domain = $_SERVER['HTTP_HOST'];
		$params = array($domain);
		$sql="{call clie_info_domain(?)}";
		$resu_login = sqlsrv_query($conn, $sql, $params);  
		$row = sqlsrv_fetch_array($resu_login);
		$_SESSION['host'] = $row['clie_instancia_db'];
		$_SESSION['user'] = $row['clie_user_db'];
		$_SESSION['pass'] = $row['clie_pass_db'];
		$_SESSION['db'] = $row['clie_base'];
		$_SESSION['dbname'] = $row['clie_base'];
		$_SESSION['codi'] = $row['clie_codi'];
		$_SESSION['directorio'] = $row['clie_carpeta'];
		$_SESSION['cliente'] = $row['clie_nomb'];
		$_SESSION['api_token'] = $row['api_token'];
		$_SESSION['protocol'] = $row['clie_protocol'];
		$_SESSION['session_timeout'] = $row['clie_session_timeout'];
		$_SESSION['clie_key'] = $row['clie_key'];
		$_SESSION['clie_iv'] = $row['clie_iv'];
		
		$_SESSION['secretario'] = get_parametro ($_SESSION['codi'], 3);
		$_SESSION['rector'] = get_parametro ($_SESSION['codi'], 2);
	}