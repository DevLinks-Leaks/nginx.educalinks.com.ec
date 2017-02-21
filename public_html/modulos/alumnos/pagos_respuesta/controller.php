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
$_SESSION['usua_pass']=$_SESSION['usua_pass'];
$_SESSION['modulo']='alumnos';

require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../common/catalogo/model.php');
require_once('../../finan/clientes/model.php');
require_once('../../finan/pagos/model.php');
//require_once('../../finan/general/model.php');
	
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
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED, 	PRINTREP_DEUDORES, PRINTREPVISOR, 
						VIEW_CONFIG_SIS,GET_DEBT, VIEW_HOME, VIEW_DEBT, VIEW_DEBT_ANS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    //$gene_data 		= helper_data();	//variables que llegan por post desde el javascript
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
	$tablacliente 	= get_mainObject('Cliente');
	$pago 			= get_mainObject('Pagos');
	//echo "no locoxs asdadas";
    switch ($event) 
	{	case GET_DEBT_ANS:
			echo "si viene";
			//retornar_vista_general(VIEW_DEBT_ANS, $data);
			break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
			echo "Resultado desconocido";
		break;
    }
}

function set_obj() {
    $obj = new General();
    return $obj;
}

handler();

function get_client_ip()
{   $ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	
	if ( $ipaddress != 'UNKNOWN' )
	{   $ipq = explode ( '.', $ipaddress );
		$ipaddress = "";
		foreach ($ipq as $cuarteto)
		{   $ipaddress += ( str_repeat("0", 3 - strlen( $cuarteto ) ) ) . $cuarteto;
		}
	}
	return $ipaddress;
}
?>