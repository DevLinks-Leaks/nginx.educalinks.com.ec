<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{   require( '../../../core/rutas.php' );
    $event = get_actualEvents( array( VIEW_GET_ALL, VIEW_SET ), VIEW_GET_ALL );
    $user_data = get_frontData();
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    switch ($event)
	{   case VIEW_SET:
            $data['mensaje'] = "Registro nuevo de paciente";
			retornar_vista( VIEW_SET, $data );
            break;
        case VIEW_GET_ALL:
            #  Presenta la pagina inicial
            global $diccionario;
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			retornar_vista( VIEW_GET_ALL, $data );
            break;
        default:
            break;
    }
}
handler();