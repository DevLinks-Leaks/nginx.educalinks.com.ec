<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	$event 			= get_actualEvents(array(GET, GET_COMBO), GET);
    $user_data 		= get_frontData();
    switch ($event)
	{	case GET_TIPO_COMBO:
            $protex = new Elemento_protex();
			$protex->get_tipo_SelectFormat( -1 );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$protex->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>"js_elemento_protex_cargaElemento_SelectFormat('".$user_data['div_followed']."','".$user_data['combo_nombre_followed']."',this.value);"),
															"selected"  => 	0);
			retornar_result($data);
            break;
		case GET_SUBTIPO_COMBO:
            $protex = new Elemento_protex();
			$protex->get_subtipo_SelectFormat( -1, $user_data['tipo_codi'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$protex->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>""),
															"selected"  => 	0);
			retornar_result($data);
            break;
        default :
			echo "default";
        	break;
    }
}

handler();
?>