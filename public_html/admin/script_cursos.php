<?php

	function curs_para_mate_add($curs_para_codi,$mate_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_codi,$mate_codi);
			$sql="{call curs_para_mate_add(?,?)}";
			$curs_para_mate_add = sqlsrv_query($conn, $sql, $params);  
			if ($curs_para_mate_del===false)
			{
				die(print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Curso paralelo código: ".$curs_para_codi;
				$detalle.= " Materia código: ".$mate_codi;
				registrar_auditoria (46, $detalle);
			}			 
	}

	function curs_para_mate_del($curs_para_mate_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi);
			$sql="{call curs_para_mate_del(?)}";
			$curs_para_mate_del = sqlsrv_query($conn, $sql, $params);  
			if ($curs_para_mate_del===false)
			{
				die(print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Curso paralelo materia: ".$curs_para_mate_codi;
				registrar_auditoria (45, $detalle);
			}
	}
	
	function curs_para_mate_prof_del($curs_para_mate_prof_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_prof_codi);
			$sql="{call curs_para_mate_prof_del(?)}";
			$curs_para_mate_prof_del = sqlsrv_query($conn, $sql, $params);  
			if ($curs_para_mate_prof_del===false)
			{
				die(print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Curso paralelo materia profesor: ".$curs_para_mate_prof_codi;
				registrar_auditoria (45, $detalle);
			}
	}
	
	function alum_curs_para_add($curs_para_codi,$alum_codi){
			include ('../framework/dbconf.php');
			$params = array($curs_para_codi,$alum_codi);
			$sql="{call alum_curs_para_add(?,?)}";
			$alum_curs_para_add = sqlsrv_query($conn, $sql, $params);  	 
	}
	

	function curs_para_mate_upd($curs_para_mate_codi,$curs_para_mate_prof_codi,$prof_codi,$aula_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_prof_codi,$curs_para_mate_codi,$prof_codi,$aula_codi);
			$sql="{call curs_para_mate_prof_add(?,?,?,?)}";
			$curs_para_mate_upd = sqlsrv_query($conn, $sql, $params);
			if ($curs_para_mate_upd===false)
			{
				die(print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Profesor código: ".$prof_codi;
				$detalle.= " Aula código: ".$aula_codi;
				$detalle.= " Curso paralelo materia: ".$curs_para_mate_codi;
				registrar_auditoria (44, $detalle);
			}
	}
	
	
	//ORDEN DE LA MATERIA EN LIBRETA
	function curs_para_mate_up($curs_para_mate_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi);
			$sql="{call curs_para_mate_up(?)}";
			sqlsrv_query($conn, $sql, $params);  
	}	
	
	function curs_para_mate_down($curs_para_mate_codi){
		
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi);
			$sql="{call curs_para_mate_down(?)}";
			sqlsrv_query($conn, $sql, $params);  
	}
	
	//ELIMINACIÓN DE ALUMNO CURSO PARALELO MATERIA
	function alum_curs_para_mate_del_ii($alum_curs_para_mate_codi){
		
			include ('../framework/dbconf.php');
			$params = array($alum_curs_para_mate_codi);
			$sql="{call alum_curs_para_mate_del(?)}";
			$alum_curs_para_mate_del = sqlsrv_query($conn, $sql, $params); 
			if ($alum_curs_para_mate_del===false)
			{
				die(print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Profesor código: ".$prof_codi;
				$detalle.= " Aula código: ".$aula_codi;
				$detalle.= " Curso paralelo materia: ".$curs_para_mate_codi;
				registrar_auditoria (47, $detalle);
			}
	}
	
	//AÑADIR CURSO PARALELO MATERIA A UN ALUMNO
	function alum_curs_para_mate_add_ii($alum_curs_para_codi, $curs_para_mate_codi, $alum_codi){
		
			include ('../framework/dbconf.php');
			$params = array($alum_curs_para_codi, $curs_para_mate_codi, $alum_codi);
			$sql="{call alum_curs_para_mate_add(?,?,?)}";
			$alum_curs_para_mate_add = sqlsrv_query($conn, $sql, $params);  
	}
	
	function curs_para_cupo_edit($curs_para_codi, $cupo){
			include ('../framework/dbconf.php');
			$params = array($curs_para_codi, $cupo);
			$sql="{call curs_para_cupo_upd(?,?)}";
			$curs_para_cupo_edit = sqlsrv_query($conn, $sql, $params); 
			var_dump ($curs_para_cupo_edit);
	}
	
	function copy_curs_mate($curs_origen, $curs_destino){
			include ('../framework/dbconf.php');
			$params = array($curs_origen, $curs_destino);
			$sql="{call copy_curs_mate(?,?)}";
			$curs_para_copy_mate = sqlsrv_query($conn, $sql, $params); 
	}
	
	//ELIMINAR NOTAS DE UN CURSO PARALELO ESPECÍFICO
	function notas_elim_peri_dist($curs_para_codi, $peri_dist_codi, $clie_codi, $clave)
	{
			include ('../framework/dbconf.php');
			$respuesta=0;
			$params = array(
							array($curs_para_codi, SQLSRV_PARAM_IN), 
							array($peri_dist_codi, SQLSRV_PARAM_IN), 
							array($clie_codi, SQLSRV_PARAM_IN), 
							array($clave, SQLSRV_PARAM_IN), 
							array($respuesta, SQLSRV_PARAM_OUT)
							);
			$sql="{call notas_peri_dist_del(?,?,?,?,?)}";
			$notas_del = sqlsrv_query($conn, $sql, $params); 
			if ($notas_del===false)
			{
				echo "Error in executing statement.";
				die(print_r(sqlsrv_errors(), true));
			}
			echo $respuesta;
	}
	
	//ELIMINAR NOTAS DE TODOS LOS CURSOS PARALELOS
	function notas_elim_peri_dist_all($peri_dist_codi, $clie_codi, $clave)
	{
			include ('../framework/dbconf.php');
			$respuesta=0;
			$params = array(
							array($peri_dist_codi, SQLSRV_PARAM_IN), 
							array($clie_codi, SQLSRV_PARAM_IN), 
							array($clave, SQLSRV_PARAM_IN), 
							array($respuesta, SQLSRV_PARAM_OUT)
							);
			$sql="{call notas_peri_dist_del_all(?,?,?,?)}";
			$notas_del = sqlsrv_query($conn, $sql, $params); 
			if ($notas_del===false)
			{
				echo "Error in executing statement.";
				die(print_r(sqlsrv_errors(), true));
			}
			echo $respuesta;
	}
	
	//Asignar un modelo de calificación
	function curs_para_mate_mode_upd($curs_para_mate_codi, $nota_refe_cab_codi)
	{
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi, $nota_refe_cab_codi);
			$sql="{call curs_para_mate_mode_upd(?,?)}";
			sqlsrv_query($conn, $sql, $params);  
	}	
	
	//Asignar tutor a un curso paralelo
	function curs_para_mate_tutor_add($curs_para_mate_prof_codi)
	{
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_prof_codi);
			$sql="{call curs_para_tutor_add(?)}";
			sqlsrv_query($conn, $sql, $params);  
	}	
	
	//Asignar Agenda a un curso paralelo
	function curs_para_mate_agen($curs_para_mate_codi, $tiene_agenda)
	{
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi, $tiene_agenda);
			$sql="{call curs_para_mate_agen(?,?)}";
			sqlsrv_query($conn, $sql, $params);  
	}
	function curs_para_mate_promoc($curs_para_mate_codi, $mostrar_materia)
	{
			include ('../framework/dbconf.php');
			$params = array($curs_para_mate_codi, $mostrar_materia);
			$sql="{call curs_para_mate_promoc(?,?)}";
			sqlsrv_query($conn, $sql, $params);  
	}
	
?>