<?php

	function admin_sesion($usua_codi){
		
			include ('../framework/dbconf.php');
			$params = array($usua_codi);
			$sql="{call usua_info(?)}";
			$usua_info = sqlsrv_query($conn, $sql, $params);  
			$row_usua_info = sqlsrv_fetch_array($usua_info);
			
					
			$_SESSION['usua_codi']=$row_usua_info['usua_codi'];
			$_SESSION['usua_nomb']=$row_usua_info['usua_nomb'];
			$_SESSION['usua_apel']=$row_usua_info['usua_apel'];
			$_SESSION['usua_pass']=$row_usua_info['usua_pass'];
			$_SESSION['usua_nombres']=$row_usua_info['usua_nomb'];
			$_SESSION['usua_apellidos']=$row_usua_info['usua_apel'];
			$_SESSION['usua_mail']=$row_usua_info['usua_mail'];	
			$_SESSION['rol_codi']=$row_usua_info['rol_codi'];	
			$_SESSION['usua_correoElectronico']=$row_usua_info['usua_mail'];
			$_SESSION['usua_codigoRol']=$row_usua_info['rol_codi'];
			$_SESSION['rol_finan']=$row_usua_info['rol_finan'];
			$_SESSION['rol_medico']=$row_usua_info['rol_medico'];
			$_SESSION['rol_biblio']=$row_usua_info['rol_biblio'];
			$_SESSION['rol_pagoweb']=$row_usua_info['rol_pagoweb'];
			
			$_SESSION['USUA_DE']  =$row_usua_info['usua_codi'];
			
	}


?>