<?php
include ('../framework/dbconf.php');
if(isset($_POST['opc']))
{	$opc=$_POST['opc'];
}
else
{	$opc="";
}
if (isset($_POST['curs_para_mate_prof_codi']))
{	$curs_para_mate_prof_codi = $_POST['curs_para_mate_prof_codi'];
}
else
{	$curs_para_mate_prof_codi = "";
}
if (isset($_POST['peri_dist_codi']))
{	$peri_dist_codi = $_POST['peri_dist_codi'];
}
else
{	$peri_dist_codi = "";
}
if (isset($_POST['es_hija']))
{	$es_hija = $_POST['es_hija'];
}
else
{	$es_hija = "";
}
if (isset($_POST['nota_perm_codi']))
{	$nota_perm_codi = $_POST['nota_perm_codi'];
}
else
{	$nota_perm_codi = "";
}
switch($opc)
{	/*Actualizar promedio de las asignaturas*/
	case 'actualizar_prom':
		$peri_dist_padr = 0; $peri_dist_padr_deta = "0";
		$sql	= "{call nota_refe_exec_v2 (?,?,?)}";
		$params	= array($curs_para_mate_prof_codi,$peri_dist_codi,$es_hija);
		$stmt	= sqlsrv_query($conn,$sql,$params);
		if ($stmt === false)
		{	 if(($errors = sqlsrv_errors())!= null)
			{	foreach ($errors as $error)
				{	$error_deta = "SQLSTATE: ".$error['SQLSTATE'];
					$error_deta.= " Código: ".$error['code'];
					$error_deta.= " Mensaje: ".$error['message'];
				}
				$result = array ("error"=>"si","mensaje"=>$error_deta);
			}
		}
		else
		{	
			include ('../framework/funciones.php');
			$row= sqlsrv_fetch_array($stmt);

			$sql	= "{call curs_para_mate_prof_info (?)}";
			$params	= array($curs_para_mate_prof_codi);
			$curs_para_mate_prof_info	= sqlsrv_query($conn,$sql,$params);
			$row_curs_para_mate_prof_info = sqlsrv_fetch_array($curs_para_mate_prof_info);
			//Auditoria
			$detalle.=" Curso: ".$row_curs_para_mate_prof_info['curs_deta'];
			$detalle.=" Paralelo: ".$row_curs_para_mate_prof_info['para_deta'];
			$detalle.=" Asignatura: ".$row_curs_para_mate_prof_info['mate_deta'];
			$detalle.=" Parcial: ".$row['peri_dist_padr_deta'];
			$detalle.=" Archivo Excel Notas: " . $_POST['path'];
			
			registrar_auditoria (58, $detalle);
			$result = array ("error"=>"no","mensaje"=>$row['peri_dist_padr_deta'],"peri_dist_codi"=>$row['peri_dist_padr']);
		}
		echo json_encode($result);
	break;
	case 'nota_perm_in':
		$sql	= "{call nota_perm_in (?)}";
		$params	= array($nota_perm_codi);
		$stmt	= sqlsrv_query($conn,$sql,$params);
		if ($stmt === false)
		{	if(($errors = sqlsrv_errors())!= null)
			{	foreach ($errors as $error)
				{	$error_deta = "SQLSTATE: ".$error['SQLSTATE'];
					$error_deta.= " Código: ".$error['code'];
					$error_deta.= " Mensaje: ".$error['message'];
				}
				$result = array ("error"=>"si","mensaje"=>$error_deta);
			}
		}
		else
		{	$result = array ("error"=>"no","mensaje"=>"Permiso desactivado.");
		}
	break;
}
?>