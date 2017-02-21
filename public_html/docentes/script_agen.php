<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc']))
{
	$opc=$_POST['opc'];
}
else
{
	$opc="";
}
switch($opc)
{
	case 'agen_add':
		$params_form = array($_POST['curs_para_mate_prof_codi'],
							$_POST['agen_titu'],
							$_POST['agen_deta'],
							$_POST['agen_fech_fin'],
							$_POST['agen_fech_ini']);
		$sql_form="{call agen_add(?,?,?,?,?)}";
		$stmp_form = sqlsrv_query($conn, $sql_form, $params_form);	
		if( $conn === false)
		{
			echo "Error in connection.\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$veri=lastId($stmp_form);
		
		$params = array($_POST['curs_para_mate_prof_codi']);
		$sql="{call curs_para_mate_prof_info(?)}";
		$curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);

		//Para auditoría
		$detalle="Curso paralelo : ".$row_curs_para_mate_prof_info['curs_deta'].' "'.$row_curs_para_mate_prof_info['para_deta'].'"';
		$detalle.=" Nivel : ".$row_curs_para_mate_prof_info['nive_deta'];
		$detalle.=" Materia : ".$row_curs_para_mate_prof_info['mate_deta'];
		$detalle.=" Agenda título: ".$_POST['agen_titu'];
		$detalle.=" Agenda detalle: ".$_POST['agen_deta'];
		$detalle.=" Agenda fecha inicio: ".$_POST['agen_fech_ini'];
		$detalle.=" Agenda fecha inicio: ".$_POST['agen_fech_fin'];
		registrar_auditoria (38, $detalle);
		
		if ($veri>0)
		{
			echo "OK";
		}
		else
		{
			echo "KO";
		}
	break;
	case 'agen_view':
		include ('agenda_main_view.php');
	break;
	
	case 'agen_del':
		$params_form = array($_POST['agen_codi']);
		$sql_form="{call agen_del(?)}";
		sqlsrv_query($conn, $sql_form, $params_form);	
				
		echo "OK";
		
	break;
}
?>