<?php
		 
	// Actualizacion de Valores (Comportamiento)
	if($_POST['opc']=='upd')
	{		 
		include ('../framework/dbconf.php');
		$params = array($_POST['alum_codi'],$_POST['curs_para_codi'],$_POST['tiene_deuda']);
		$sql="{call alum_acti_desa_deuda_upd(?,?,?)}";
		$alum_deuda = sqlsrv_query($conn, $sql, $params);  
		if ($alum_deuda===false)
		{
			//echo "Ha ocurrido un error en la base de datos.";
			//exit ();
			$result= json_encode(array ('state'=>'error',
				'result'=>'Error al realizar la activación de bloqueo.',
				'console'=> sqlsrv_errors() ));
			// die(print_r(sqlsrv_errors(),true));
		}else{
			//registrar_auditoria (315, '');
			$result= json_encode(array ('state'=>'success',
				'result'=>'Actualización de bloqueo realizada con éxito.' ));
		}
		echo $result;
	}	
		
?>