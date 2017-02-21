<?php
session_start();
session_start();
include("../../../framework/dbconf_main.php");
$params = array($domain);

$sql="{call dbo.clie_info_domain(?)}";
$resu_login = sqlsrv_query($conn, $sql, $params);  
$row = sqlsrv_fetch_array($resu_login);
$_SESSION['host']=$row['clie_instancia_db'];
$_SESSION['user']=$row['clie_user_db'];
$_SESSION['pass']=$row['clie_pass_db'];
$_SESSION['dbname']=$row['clie_base'];
$_SESSION['IN']= (isset($_SESSION['usua_codi']))?'OK':'KO';
$_SESSION['usua_codigo']=$_SESSION['usua_codi'];
$_SESSION['usua_codi']=$_SESSION['repr_codi'];
$_SESSION['usua_pass']=$_SESSION['usua_pass'];
$_SESSION['modulo']='alumnos';

require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../common/catalogo/model.php');
require_once('../../medic/alergia/model.php');
require_once('../../medic/vacuna/model.php');
require_once('../../medic/enfermedad/model.php');
require_once('../../medic/ex_lab_clinico/model.php');
require_once('../../medic/ficha_nuevo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('funciones.php');
function handler() {
	require('../../../core/rutas.php');
	
    if (!isset($_POST['event']))
	{	if(!isset($_GET['event']))
		{	$event = INDEX;
		}
		else
		{	$event =$_GET['event'];
		}
	}
	else
	{	$event =$_POST['event'];
	}
	if (!isset($_POST['tabla']))
	{	$tabla= "tabla_rptDeudores";
	}
	else
	{	$tabla=$_POST['tabla'];
	}
	 
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED,PRINTREP_DEUDORES,PRINTREPVISOR,VIEW_CONFIG_SIS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    $gene_data 		= helper_data();	//variables que llegan por post desde el javascript
	$user_data 		= get_frontData(); //variables que llegan por post desde el javascript
    $general 		= set_obj();
	$gene			= set_obj();
	$cursos 		= set_obj();
	$periodos 		= set_obj();
	$periodo 		= get_mainObject('Periodo');
	$pensiones 		= set_obj();
    $apikey 		= set_obj();
	$deuda 			= set_obj();
	$permiso 		= get_mainObject('General');
	$ficha_medica	= get_mainObject('Ficha_medica');
	
    switch ($event) 
	{	case MAIN:
			global $diccionario;
			$
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['apikey']=$apikey->rows[0]['apikey'];
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_red'];
			$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_red_small'];
			
			$_SESSION['dir_logo_redlinks_black']=$ruta_logo_redlinks_black;
			$_SESSION['dir_logo_redlinks_white']=$ruta_logo_redlinks_white;
			$_SESSION['dir_logo_links_md']=$ruta_logo_links_md;
			$_SESSION['dir_logo_links']=$ruta_logo_links;
			$_SESSION['print_dir_logo_educalinks']=$print_ruta_logo_educalinks;
			$_SESSION['print_dir_logo_educalinks_long_sm']=$print_ruta_logo_educalinks_long_small;
			$_SESSION['print_dir_logo_redlinks_black']=$print_ruta_logo_redlinks_black;
			$_SESSION['print_dir_logo_redlinks_white']=$print_ruta_logo_redlinks_white;
			$_SESSION['print_dir_logo_links_md']=$print_ruta_logo_links_md;
			$_SESSION['print_dir_logo_links']=$print_ruta_logo_links;
			$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
			$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
			switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "ecobabdemo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='ecobabdemo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "contifico.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='contifico.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "desarrollo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='desarrollo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
			}
			$data['usua_permiso']=$_SESSION['usua_permiso'];
			if( !isset( $user_data['fmex_codi'] ) ) 
			{   $data = constructor_formulario_med( $data, 'fmex', 'per', '', $user_data['per_codi'], $user_data['tipo_persona'] );
				$data['mensaje']="Formulario de Ficha médica";
				retornar_vista_general(VIEW_HOME, $data);
			}
			else
			{   $ficha_medica->get_ficha_medica( $user_data['fmex_codi'] );
				if( ( count( $ficha_medica->rows )-1 )>0 )
				{	$data = sub_constructor_formulario_med_load( $ficha_medica, '0', $data, 'fmex', 'per' );
					retornar_vista_general(VIEW_HOME, $data);
				}
				else
				{   echo "No se encontraron resultados";
				}
			}
        break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
		break;
    }
}

function set_obj() {
    $obj = new General();
    return $obj;
}
handler();
function set_ficha_medica( $user_data, $per )
{
	$ficha_medica = new Ficha_medica();
	$ficha_medica->set_ficha_medica(
		$user_data[ $per.'_fmex_codi'],					$user_data[ $per.'_per_codi'],				$user_data[ $per.'_tipo'],
		$user_data[ $per.'_rdb_tipo_ficha'],
		$user_data[ $per.'_rdb_tabaco'],				$user_data[ $per.'_rdb_alcohol'],			$user_data[ $per.'_rdb_drogas'],
		$user_data[ $per.'_con_fisica'],				$user_data[ $per.'_act_sicomotora'],		$user_data[ $per.'_deambulacion'],
		$user_data[ $per.'_exp_verbal'],				$user_data[ $per.'_estado_nutricional'],	$user_data[ $per.'_estatura'],
		$user_data[ $per.'_peso'],						$user_data[ $per.'_temp_bucal'],			$user_data[ $per.'_pulso'],
		$user_data[ $per.'_presion_arterial'],			$user_data[ $per.'_piel'],					$user_data[ $per.'_ganglios'],
		$user_data[ $per.'_cabeza'],					$user_data[ $per.'_cuello'],				$user_data[ $per.'_ojos'],
		$user_data[ $per.'_oidos'],						$user_data[ $per.'_boca'],					$user_data[ $per.'_nariz'],
		$user_data[ $per.'_dentadura'],					$user_data[ $per.'_garganta'],				$user_data[ $per.'_corazon'],
		$user_data[ $per.'_torax'],						$user_data[ $per.'_pulmones'],				$user_data[ $per.'_mamas'],
		$user_data[ $per.'_higado'],					$user_data[ $per.'_ves_biliar'],			$user_data[ $per.'_bazo'],
		$user_data[ $per.'_estomago'],					$user_data[ $per.'_intestinos'],			$user_data[ $per.'_apendice'],
		$user_data[ $per.'_ano'],
		$user_data[ $per.'_umbilical'],					$user_data[ $per.'_rurales'],				$user_data[ $per.'_inguinal_derecha'],
		$user_data[ $per.'_inguinal_izquierda'],		$user_data[ $per.'_deformaciones'],			$user_data[ $per.'_masas_musculares'],
		$user_data[ $per.'_movibilidad'],				$user_data[ $per.'_puntos_dolorosos'],		$user_data[ $per.'_tracto_urinario'],
		$user_data[ $per.'_espermaquia'],				$user_data[ $per.'_tracto_genital_masculino'],
		$user_data[ $per.'_tracto_genital_femenino'],
		$user_data[ $per.'_menstruacion'],				$user_data[ $per.'_menarquia'],				$user_data[ $per.'_menapmia'],
		$user_data[ $per.'_gesta'],						$user_data[ $per.'_partos'],				$user_data[ $per.'_aborto'],
		$user_data[ $per.'_cesarea'],					$user_data[ $per.'_superior_derecha'],		$user_data[ $per.'_superior_izquierda'],
		$user_data[ $per.'_inferior_derecha'],			$user_data[ $per.'_inferior_izquierda'],	$user_data[ $per.'_ojo_derecho'],
		$user_data[ $per.'_ojo_izquierdo'],				$user_data[ $per.'_oido_derecho'],			$user_data[ $per.'_oido_izquierdo'],
		$user_data[ $per.'_rdb_reflex_tendinosos'],		$user_data[ $per.'_rdb_reflex_pupilares'],	$user_data[ $per.'_marcha'],
		$user_data[ $per.'_sens_superficial'],			$user_data[ $per.'_profunda_romberg'],		$user_data[ $per.'_estado_mental'],
		$user_data[ $per.'_memoria'],					$user_data[ $per.'_irritabilidad'],			$user_data[ $per.'_depresion'],
		$user_data[ $per.'_aptitud_trabajo'],			$_SESSION['usua_codi'],						$_SERVER['REMOTE_ADDR'] );
	return $ficha_medica;
}
function sub_constructor_formulario_med_load( $ficha_medica, $c, $data, $per, $per_ctrl )
{   $data = constructor_formulario_med(
		$data, 														$per, 													$per_ctrl,
		$ficha_medica->rows[$c]['fmex_codi'],						$ficha_medica->rows[$c]['per_codi'],					$ficha_medica->rows[$c]['tipo_persona'],
		$ficha_medica->rows[$c]['fmex_tipo_ficha'],
		$ficha_medica->rows[$c]['fmex_tabaco'],						$ficha_medica->rows[$c]['fmex_alcohol'],				$ficha_medica->rows[$c]['fmex_drogas'],
		$ficha_medica->rows[$c]['fmex_con_fisica'],					$ficha_medica->rows[$c]['fmex_act_sicomotora'],			$ficha_medica->rows[$c]['fmex_deambulacion'],
		$ficha_medica->rows[$c]['fmex_exp_verbal'],					$ficha_medica->rows[$c]['fmex_estado_nutricional'],		$ficha_medica->rows[$c]['fmex_estatura'],
		$ficha_medica->rows[$c]['fmex_peso'],						$ficha_medica->rows[$c]['fmex_temp_bucal'],				$ficha_medica->rows[$c]['fmex_pulso'],
		$ficha_medica->rows[$c]['fmex_presion_arterial'],			$ficha_medica->rows[$c]['fmex_piel'],					$ficha_medica->rows[$c]['fmex_ganglios'],
		$ficha_medica->rows[$c]['fmex_cabeza'],						$ficha_medica->rows[$c]['fmex_cuello'],					$ficha_medica->rows[$c]['fmex_ojos'],
		$ficha_medica->rows[$c]['fmex_oidos'],						$ficha_medica->rows[$c]['fmex_boca'],					$ficha_medica->rows[$c]['fmex_nariz'],
		$ficha_medica->rows[$c]['fmex_dentadura'],					$ficha_medica->rows[$c]['fmex_garganta'],				$ficha_medica->rows[$c]['fmex_corazon'],
		$ficha_medica->rows[$c]['fmex_torax'],						$ficha_medica->rows[$c]['fmex_pulmones'],				$ficha_medica->rows[$c]['fmex_mamas'],
		$ficha_medica->rows[$c]['fmex_higado'],						$ficha_medica->rows[$c]['fmex_ves_biliar'],				$ficha_medica->rows[$c]['fmex_bazo'],
		$ficha_medica->rows[$c]['fmex_estomago'],					$ficha_medica->rows[$c]['fmex_intestinos'],				$ficha_medica->rows[$c]['fmex_apendice'],
		$ficha_medica->rows[$c]['fmex_ano'],
		$ficha_medica->rows[$c]['fmex_umbilical'],					$ficha_medica->rows[$c]['fmex_rurales'],				$ficha_medica->rows[$c]['fmex_inguinal_derecha'],
		$ficha_medica->rows[$c]['fmex_inguinal_izquierda'],			$ficha_medica->rows[$c]['fmex_deformaciones'],			$ficha_medica->rows[$c]['fmex_masas_musculares'],
		$ficha_medica->rows[$c]['fmex_movibilidad'],				$ficha_medica->rows[$c]['fmex_puntos_dolorosos'],		$ficha_medica->rows[$c]['fmex_tracto_urinario'],
		$ficha_medica->rows[$c]['fmex_espermaquia'],				$ficha_medica->rows[$c]['fmex_tracto_genital_masculino'],
		$ficha_medica->rows[$c]['fmex_tracto_genital_femenino'],
		$ficha_medica->rows[$c]['fmex_menstruacion'],				$ficha_medica->rows[$c]['fmex_menarquia'],				$ficha_medica->rows[$c]['fmex_menapmia'],
		$ficha_medica->rows[$c]['fmex_gesta'],						$ficha_medica->rows[$c]['fmex_partos'],					$ficha_medica->rows[$c]['fmex_aborto'],
		$ficha_medica->rows[$c]['fmex_cesarea'],					$ficha_medica->rows[$c]['fmex_superior_derecha'],		$ficha_medica->rows[$c]['fmex_superior_izquierda'],
		$ficha_medica->rows[$c]['fmex_inferior_derecha'],			$ficha_medica->rows[$c]['fmex_inferior_izquierda'],		$ficha_medica->rows[$c]['fmex_ojo_derecho'],
		$ficha_medica->rows[$c]['fmex_ojo_izquierdo'],				$ficha_medica->rows[$c]['fmex_oido_derecho'],			$ficha_medica->rows[$c]['fmex_oido_izquierdo'],
		$ficha_medica->rows[$c]['fmex_reflex_tendinosos'],			$ficha_medica->rows[$c]['fmex_reflex_pupilares'],		$ficha_medica->rows[$c]['fmex_marcha'],
		$ficha_medica->rows[$c]['fmex_sens_superficial'],			$ficha_medica->rows[$c]['fmex_profunda_romberg'],		$ficha_medica->rows[$c]['fmex_estado_mental'],			
		$ficha_medica->rows[$c]['fmex_memoria'],					$ficha_medica->rows[$c]['fmex_irritabilidad'],			$ficha_medica->rows[$c]['fmex_depresion'],
		$ficha_medica->rows[$c]['fmex_aptitud_trabajo']);		
	return $data;
}
function constructor_formulario_med( 
	$data, 						$per, 					$per_ctrl = "",
	
	$fmex_codi,					$per_codi,				$tipo_persona = 0,
	$tipo_ficha = "OCU",
	$tabaco,					$alcohol,				$drogas,
	$con_fisica,				$act_sicomotora,		$deambulacion,
	$exp_verbal,				$estado_nutricional,	$estatura=0,
	$peso=0,					$temp_bucal=0,			$pulso=0,
	$presion_arterial=0,		$piel,					$ganglios,
	$cabeza,					$cuello,				$ojos,
	$oidos,						$boca,					$nariz,
	$dentadura,					$garganta,				$corazon,
	$torax,						$pulmones,				$mamas,
	$higado,					$ves_biliar,			$bazo,
	$estomago,					$intestinos,			$apendice,
	$ano,
	$umbilical,					$rurales,				$inguinal_derecha,
	$inguinal_izquierda,		$deformaciones,			$masas_musculares,
	$movibilidad,				$puntos_dolorosos,		$tracto_urinario,
	$espermaquia,				$tracto_genital_masculino,
	$tracto_genital_femenino,
	$menstruacion,				$menarquia,				$menapmia,
	$gesta,						$partos,				$aborto,
	$cesarea,					$superior_derecha,		$superior_izquierda,
	$inferior_derecha,			$inferior_izquierda,	$ojo_derecho,
	$ojo_izquierdo,				$oido_derecho,			$oido_izquierdo,
	$reflex_tendinoso,			$reflex_pupilares,		$marcha,
	$sens_superficial,			$profunda_romberg,		$estado_mental,
	$memoria,					$irritabilidad,			$depresion,
	$aptitud_trabajo,			$usua_ingr,				$ip )
{	
	global $diccionario;
	
	if( $per_ctrl == "" ) $per_ctrl = $per;
	
	/*-------------------------------------------------------------------------------------
		VARIABLES (Están al inicio de ficha_nuevo_formulario_med.php)
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_fmex_codi'] = $fmex_codi;
	$data[ $per_ctrl.'_tipo'] = $tipo_persona;
	$data[ $per_ctrl.'_codi'] = $per_codi;
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS PERSONALES DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_con_fisica' ] = $con_fisica;
	$data[ $per_ctrl.'_act_sicomotora' ] = $act_sicomotora;
	$data[ $per_ctrl.'_deambulacion' ] = $deambulacion;
	$data[ $per_ctrl.'_exp_verbal' ] = $exp_verbal;
	$data[ $per_ctrl.'_estado_nutricional' ] = $estado_nutricional;
	$data[ $per_ctrl.'_estatura' ] = $estatura;
	$data[ $per_ctrl.'_peso' ] = $peso;
	$data[ $per_ctrl.'_temp_bucal' ] = $temp_bucal;
	$data[ $per_ctrl.'_pulso' ] = $pulso;
	$data[ $per_ctrl.'_presion_arterial' ] = $presion_arterial;
	
	$data[ $per_ctrl.'_piel' ] = $piel;
	$data[ $per_ctrl.'_ganglios' ] = $ganglios;
	$data[ $per_ctrl.'_cabeza' ] = $cabeza;
	$data[ $per_ctrl.'_cuello' ] = $cuello;
	$data[ $per_ctrl.'_ojos' ] = $ojos;
	$data[ $per_ctrl.'_oidos' ] = $oidos;
	$data[ $per_ctrl.'_boca' ] = $boca;
	$data[ $per_ctrl.'_nariz' ] = $nariz;
	$data[ $per_ctrl.'_dentadura' ] = $dentadura;
	$data[ $per_ctrl.'_garganta' ] = $garganta;
	
	$data[ $per_ctrl.'_corazon' ] = $corazon;
	$data[ $per_ctrl.'_torax' ] = $torax;
	$data[ $per_ctrl.'_pulmones' ] = $pulmones;
	$data[ $per_ctrl.'_mamas' ] = $mamas;
	$data[ $per_ctrl.'_higado' ] = $higado;
	$data[ $per_ctrl.'_ves_biliar' ] = $ves_biliar;
	$data[ $per_ctrl.'_bazo' ] = $bazo;
	$data[ $per_ctrl.'_estomago' ] = $estomago;
	$data[ $per_ctrl.'_intestinos' ] = $intestinos;
	$data[ $per_ctrl.'_apendice' ] = $apendice;
	$data[ $per_ctrl.'_ano' ] = $ano;
	
	
	$data[ $per_ctrl.'_umbilical' ] = $umbilical;
	$data[ $per_ctrl.'_rurales' ] = $rurales;
	$data[ $per_ctrl.'_inguinal_derecha' ] = $inguinal_derecha;
	$data[ $per_ctrl.'_inguinal_izquierda' ] = $inguinal_izquierda;
	$data[ $per_ctrl.'_deformaciones' ] = $deformaciones;
	$data[ $per_ctrl.'_masas_musculares' ] = $masas_musculares;
	$data[ $per_ctrl.'_movibilidad' ] = $movibilidad;
	$data[ $per_ctrl.'_puntos_dolorosos' ] = $puntos_dolorosos;
	$data[ $per_ctrl.'_tracto_urinario' ] = $tracto_urinario;
	
	$data[ $per_ctrl.'_espermaquia' ] = $espermaquia;
	$data[ $per_ctrl.'_tracto_genital_masculino' ] = $tracto_genital_masculino;
	$data[ $per_ctrl.'_tracto_genital_femenino' ] = $tracto_genital_femenino;
	$data[ $per_ctrl.'_menstruacion' ] = $menstruacion;
	$data[ $per_ctrl.'_menarquia' ] = $menarquia;
	$data[ $per_ctrl.'_menapmia' ] = $menapmia;
	$data[ $per_ctrl.'_gesta' ] = $gesta;
	$data[ $per_ctrl.'_partos' ] = $partos;
	$data[ $per_ctrl.'_aborto' ] = $aborto;
	$data[ $per_ctrl.'_cesarea' ] = $cesarea;
	
	$data[ $per_ctrl.'_superior_derecha' ] = $superior_derecha;
	$data[ $per_ctrl.'_superior_izquierda' ] = $superior_izquierda;
	$data[ $per_ctrl.'_inferior_derecha' ] = $inferior_derecha;
	$data[ $per_ctrl.'_inferior_izquierda' ] = $inferior_izquierda;
	$data[ $per_ctrl.'_ojo_derecho' ] = $ojo_derecho;
	$data[ $per_ctrl.'_ojo_izquierdo' ] = $ojo_izquierdo;
	$data[ $per_ctrl.'_oido_derecho' ] = $oido_derecho;
	$data[ $per_ctrl.'_oido_izquierdo' ] = $oido_izquierdo;
	
	$data[ $per_ctrl.'_marcha' ] = $marcha;
	$data[ $per_ctrl.'_sens_superficial' ] = $sens_superficial;
	$data[ $per_ctrl.'_profunda_romberg' ] = $profunda_romberg;
	$data[ $per_ctrl.'_estado_mental' ] = $estado_mental;
	$data[ $per_ctrl.'_memoria' ] = $memoria;
	$data[ $per_ctrl.'_irritabilidad' ] = $irritabilidad;
	$data[ $per_ctrl.'_depresion' ] = $depresion;
	
	$data[ $per_ctrl.'_aptitud_trabajo' ] = $aptitud_trabajo;
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS EN FORMATO RADIO BUTTON
	  -------------------------------------------------------------------------------------*/
	  
	if( $tabaco== 'S' )
	{   $data[ 'per_tabaco_si' ] = " checked ";
		$data[ 'per_tabaco_no' ] = " ";
	}
	else
	{   $data[ 'per_tabaco_si' ] = " ";
		$data[ 'per_tabaco_no' ] = " checked ";
	}
	if( $alcohol== 'S' )
	{   $data[ 'per_alcohol_si' ] = " checked ";
		$data[ 'per_alcohol_no' ] = " ";
	}
	else
	{   $data[ 'per_alcohol_si' ] = " ";
		$data[ 'per_alcohol_no' ] = " checked ";
	}
	if( $drogas == 'S' )
	{   $data[ 'per_drogas_si' ] = " checked ";
		$data[ 'per_drogas_no' ] = " ";
	}
	else
	{   $data[ 'per_drogas_si' ] = " ";
		$data[ 'per_drogas_no' ] = " checked ";
	}
	
	if( empty( $tipo_ficha ) )
	{   $data[ 'per_tipo_ficha_pre' ] = "";
		$data[ 'per_tipo_ficha_ocu' ] = " checked ";
		$data[ 'per_tipo_ficha_post' ] = "";
	}
	else
	{   if( $tipo_ficha == 'OTRO' )
			$data[ 'per_tipo_ficha_otro' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_otro' ] = " ";
		
		if( $tipo_ficha == 'PRE' )
			$data[ 'per_tipo_ficha_pre' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_pre' ] = " ";
		
		if( $tipo_ficha == 'OCU' )
			$data[ 'per_tipo_ficha_ocu' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_ocu' ] = " ";
		
		if( $tipo_ficha == 'POST' )
			$data[ 'per_tipo_ficha_post' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_post' ] = " ";
	}
	
	if( empty( $reflex_tendinoso ) )
		$data[ 'per_reflex_tendinoso_normal' ] = " checked ";
	else
	{   if( $reflex_tendinoso== 'A' )
			$data[ 'per_reflex_tendinoso_a' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_a' ] = " ";
		if( $reflex_tendinoso == 'HIPO' )
			$data[ 'per_reflex_tendinoso_hipo' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_hipo' ] = " ";
		if( $reflex_tendinoso == 'NORMAL' )
			$data[ 'per_reflex_tendinoso_normal' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_normal' ] = " ";
		if( $reflex_tendinoso == 'HIPER' )
			$data[ 'per_reflex_tendinoso_hiper' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_hiper' ] = " ";
		
	}
	
	if( empty( $reflex_pupilares ) )
		$data[ 'per_reflex_pupilares_normal' ] = " checked ";
	else
	{   if( $reflex_pupilares == 'A' )
			$data[ 'per_reflex_pupilares_a' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_a' ] = " ";
		if( $reflex_pupilares == 'HIPO' )
			$data[ 'per_reflex_pupilares_hipo' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_hipo' ] = " ";
		if( $reflex_pupilares == 'NORMAL' )
			$data[ 'per_reflex_pupilares_normal' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_normal' ] = " ";
		if( $reflex_pupilares == 'HIPER' )
			$data[ 'per_reflex_pupilares_hiper' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_hiper' ] = " ";
	}
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA NUEVA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$alergia = new Ficha_medica();
	$alergia->get_alergia( $fmex_codi );
	//QUEMADO DIV_SHOW_RESULT con div_tbl_alergia
	
		//FASE. Editar funciona. sólo es de editar el procedimiento para que actualice en vez de insertar un nuevo registro.
	/*$opciones["Editar"] = "<span onclick='js_ficha_add_alergia(\"div_tbl_alergia\",\"".$per.
										"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
										" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_alergia(\"div_tbl_alergia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_alergia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_alergia",
												"name"		=> $per."_tbl_alergia",
												"datos"     => $alergia->rows,
												"encabezado"=> array("Referencia",
																	  "Alergia",
																	  "Reacción",
																	  "Alergia Referencia",
																	  "Alergia Tipo",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_ale_codi");
	$vacuna = new Ficha_medica();
	$vacuna->get_vacuna( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_vacuna(\"div_tbl_vacuna\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_vacuna}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_vacuna",
												"name"		=> $per."_tbl_vacuna",
												"datos"     => $vacuna->rows,
												"encabezado"=> array("Referencia",
																	  "Vacuna",
																	  "Fecha",
																	  "Reacción",
																	  "Tipo",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_vac_codi");
	$enfermedad = new Ficha_medica();
	$enfermedad->get_enfermedad( $fmex_codi,'T' );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_enfermedad(\"div_tbl_enfermedad\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\",\"T\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_enfermedad}"]= array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_enfermedad",
													"name"		=> $per."_tbl_enfermedad",
													"datos"     => $enfermedad->rows,
													"encabezado"=> array( "Referencia",
																		  "Enfermedad",
																		  "Tiene",
																		  "Tuvo",
																		  "Tratamiento",
																		  "Descr. Tratamiento",
																		  "Enf. referencia",
																		  ""),
													"options"   => array( $opciones ),
													"campo"  	=> "fmex_enf_codi");
	$enfermedad = new Ficha_medica();
	$enfermedad->get_enfermedad( $fmex_codi,'F' );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_enfermedad(\"div_tbl_enfermedad_familia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\",\"F\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_enfermedad_familia}"]= array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_enfermedad_familia",
													"name"		=> $per."_tbl_enfermedad_familia",
													"datos"     => $enfermedad->rows,
													"encabezado"=> array( "Referencia",
																		  "Enfermedad",
																		  "Tiene",
																		  "Tuvo",
																		  "Tratamiento",
																		  "Parentesco",
																		  "Observaciones",
																		  "Enf. referencia",
																		  ""),
													"options"   => array( $opciones ),
													"campo"  	=> "fmex_enf_codi");
	$cirugia = new Ficha_medica();
	$cirugia->get_cirugia( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_cirugia(\"div_tbl_cirugia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_cirugia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_cirugia",
												"name"		=> $per."_tbl_cirugia",
												"datos"     => $cirugia->rows,
												"encabezado"=> array( "Referencia",
																	  "Cirugía",
																	  "Fecha",
																	  "Localización",
																	  "Extensión",
																	  "Propósito",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_cir_codi");
															
	$ex_lab_clinico = new Ficha_medica();
	$ex_lab_clinico->get_ex_lab_clinico( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_ex_lab_clinico(\"div_tbl_ex_lab_clinico\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_ex_lab_clinico}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_ex_lab_clinico",
												"name"		=> $per."_tbl_ex_lab_clinico",
												"datos"     => $ex_lab_clinico->rows,
												"encabezado"=> array("Referencia",
																	  "Examen",
																	  "Resultado",
																	  "Fecha",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_lab_codi");
	
	$radiografia = new Ficha_medica();
	$radiografia->get_radiografia( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_radiografia(\"div_tbl_radiografia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_radiografia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_radiografia",
												"name"		=> $per."_tbl_radiografia",
												"datos"     => $radiografia->rows,
												"encabezado"=> array("Referencia",
																	  "Radiografía",
																	  "Fecha de la radiografía",
																	  "Localización",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_rad_codi");
	$data['per'] = $per;
	return $data;
}
function constructor_alergia_per( $data, $per, $per_ctrl = "", $fmex_ale_codi, $ale_tipo="0", $ale_nombre="0", $ale_desc_reaccion )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE ALERGIA
	  -------------------------------------------------------------------------------------*/
	
	$alergia = new Alergia();
	$alergia->get_tipo_SelectFormat( -1 );
	$data['{cmb_alergia_tipo}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$alergia->rows, 
											"options"   => 	array(	"name"		=>"cmb_ale_tipo_".$per,
																	"id"		=>"cmb_ale_tipo_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>"js_alergia_cargaAlergia_SelectFormat('div_cmb_ale_nombre','cmb_ale_".$per."',this.value);"),
											"selected"  => 	$ale_tipo);
	$alergia2 = new Alergia();
	$alergia2->get_subtipo_SelectFormat( -1, $ale_tipo );
	$data['{cmb_alergia_nombre}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$alergia2->rows, 
											"options"   => 	array(	"name"		=>"cmb_ale_".$per,
																	"id"		=>"cmb_ale_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$ale_nombre);
	$data[ $per_ctrl.'_ale_reaccion']  = $ale_desc_reaccion;
	$data[ $per_ctrl.'_fmex_ale_codi'] = $fmex_ale_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_vacuna_per( $data, $per, $per_ctrl = "", $fmex_vac_codi, $vac_nombre="0", $vac_fecha='', $vac_desc )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE VACUNA
	  -------------------------------------------------------------------------------------*/

	$vacuna = new Vacuna();
	$vacuna->get_tipo_SelectFormat( -1 );
	$data['{cmb_vacuna_nombre}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$vacuna->rows, 
											"options"   => 	array(	"name"		=>"cmb_vac_".$per,
																	"id"		=>"cmb_vac_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$vac_nombre);
	$data[ $per_ctrl.'_vac_fecha']  = $vac_fecha;
	$data[ $per_ctrl.'_vac_desc']  = $vac_desc;
	$data[ $per_ctrl.'_fmex_vac_codi'] = $fmex_vac_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_enfermedad_per( $data, $titular = "T" , $per, $per_ctrl = "", $fmex_enf_codi, $enf_nombre="0",
									$enf_tiene="", $enf_tuvo="", $_enf_tratamiento="", $enf_desc_tratamiento="", $enf_parentesco="0" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE ENFERMEDAD
	  -------------------------------------------------------------------------------------*/
	
	$enfermedad = new Enfermedad();
	$enfermedad->get_tipo_SelectFormat( -1 );
	$data['{cmb_enfermedad_nombre}']=array( "elemento"  => 	"combo",
											"datos"     => 	$enfermedad->rows,
											"options"   => 	array(	"name"		=> "cmb_enf_".$per,
																	"id"		=> "cmb_enf_".$per,
																	"required"	=> "required",
																	"class"		=> "form-control",
																	"style"		=> "width: 100%;",
																	"onChange"	=> ""),
											"selected"  => 	$enf_nombre );
	$parentesco = new catalogo();
	$parentesco->get_all_sons( 2 );
	$data['{cmb_enfermedad_parentesco}']=array( "elemento"  => 	"combo",
												"datos"     => 	$parentesco->rows,
												"options"   => 	array(	"name"		=>"cmb_enf_parentesco_".$per,
																		"id"		=>"cmb_enf_parentesco_".$per,
																		"required"	=>"required",
																		"class"		=>'form-control input-sm',
																		"onChange"	=> $enf_parentesco ),
												"selected"  => 	0 );
	$data['titular'] = $titular;
	
	if ( $titular == 'F' ) 
		$data['display_div_enf_parentesco'] = " style='display:inline;' ";
	else
		$data['display_div_enf_parentesco'] = " style='display:none;' ";
	
	if( $enf_tiene == 'S' )
		$data[ $per_ctrl.'_enf_tiene']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tiene']  = "";
	
	if( $enf_tuvo == 'S' )
		$data[ $per_ctrl.'_enf_tuvo']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tuvo']  = "";
	
	if( $_enf_tratamiento == 'S' )
		$data[ $per_ctrl.'_enf_tratamiento']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tratamiento']  = "";
	
	$data[ $per_ctrl.'_enf_desc_tratamiento']  = $enf_desc_tratamiento;
	$data[ $per_ctrl.'_fmex_enf_codi'] = $fmex_enf_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_cirugia_per( $data, $per, $per_ctrl = "", $fmex_cir_codi, $cir_nombre_desc="",
									$cir_fecha="", $cir_localizacion="", $cir_extension="", $cir_proposito="" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE CIRUGIA
	  -------------------------------------------------------------------------------------*/
	
	if( $cir_localizacion == 'S' )
		$data[ $per_ctrl.'_cir_localizacion']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_localizacion']  = "";
	
	if( $cir_extension == 'S' )
		$data[ $per_ctrl.'_cir_extension']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_extension']  = "";
	
	if( $cir_proposito == 'S' )
		$data[ $per_ctrl.'_cir_proposito']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_proposito']  = "";
	
	$data[ $per_ctrl.'_cir_fecha']  = $cir_fecha;
	$data[ $per_ctrl.'_cir_nombre_desc'] = $cir_nombre_desc;
	$data[ $per_ctrl.'_fmex_cir_codi'] = $fmex_cir_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_radiografia_per( $data, $per, $per_ctrl = "", $fmex_rad_codi, $rad_nombre_desc="",
									$rad_fecha="", $rad_localizacion="")
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE RADIOGRAFÍA
	  -------------------------------------------------------------------------------------*/
	  
	$data[ $per_ctrl.'_rad_nombre_desc'] = $rad_nombre_desc;
	$data[ $per_ctrl.'_rad_fecha']  = $rad_fecha;
	$data[ $per_ctrl.'_rad_localizacion'] = $rad_localizacion;
	$data[ $per_ctrl.'_fmex_rad_codi'] = $fmex_rad_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_ex_lab_clinico_per( $data, $per, $per_ctrl = "", $fmex_lab_codi, $lab_codi="",
									$lab_resultado="", $lab_fecha="")
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE EXÁMENES DE LABORATORIOS CLÍNICOS
	  -------------------------------------------------------------------------------------*/
	$ex_lab_clinico = new Ex_Lab_Clinico();
	$ex_lab_clinico->get_tipo_SelectFormat( -1 );
	$data['{cmb_ex_lab_clinico_nombre}']=array( "elemento"  => 	"combo",
												"datos"     => 	$ex_lab_clinico->rows,
												"options"   => 	array(	"name"		=>"cmb_lab_".$per,
																		"id"		=>"cmb_lab_".$per,
																		"required"	=>"required",
																		"class"		=>"form-control",
																		"onChange"	=>""),
												"selected"  => 	$lab_codi);
	$data[ $per_ctrl.'_lab_fecha']  = $lab_fecha;
	$data[ $per_ctrl.'_lab_resultado'] = $lab_resultado;
	$data[ $per_ctrl.'_fmex_lab_codi'] = $fmex_lab_codi;
	$data['per'] = $per;
	return $data;
}

function helper_data() {
    $gene_data = array();
    if($_POST) {
        if(array_key_exists('usua_codigo', $_POST)) { 
            $gene_data['usua_codigo'] = $_POST['usua_codigo']; 
        }
		if(array_key_exists('usua_clave', $_POST)) { 
            $gene_data['usua_clave'] = $_POST['usua_clave']; 
        }
		if(array_key_exists('pass_new', $_POST)) { 
            $gene_data['pass_new'] = $_POST['pass_new']; 
        }
		if(array_key_exists('url', $_POST)) { 
            $gene_data['url'] = $_POST['url']; 
        }
		if(array_key_exists('fecha', $_POST)) { 
            $gene_data['fecha'] = $_POST['fecha']; 
        }
		if(array_key_exists('curso', $_POST)) { 
            $gene_data['curso'] = $_POST['curso']; 
        }
		if(array_key_exists('prontopago', $_POST)) { 
            $gene_data['prontopago'] = $_POST['prontopago']; 
        }
    } else if($_GET) {
        if(array_key_exists('usua_codigo', $_GET)) { 
            $gene_data['usua_codigo'] = $_GET['usua_codigo']; 
        }
		if(array_key_exists('usua_clave', $_GET)) { 
            $gene_data['usua_clave'] = $_GET['usua_clave']; 
        }
		if(array_key_exists('pass_new', $_GET)) { 
            $gene_data['pass_new'] = $_GET['pass_new']; 
        }
		if(array_key_exists('url', $_GET)) { 
            $gene_data['url'] = $_GET['url']; 
        }
		if(array_key_exists('fecha', $_GET)) { 
            $gene_data['fecha'] = $_GET['fecha']; 
        }
		if(array_key_exists('curso', $_GET)) { 
            $gene_data['curso'] = $_GET['curso']; 
        }
		if(array_key_exists('prontopago', $_GET)) { 
            $gene_data['prontopago'] = $_GET['prontopago']; 
        }
    }
    return $gene_data;
}
?>