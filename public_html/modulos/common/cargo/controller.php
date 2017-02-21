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
	{	case GET_COMBO:
            $cargo = new Cargo();
			$cargo->get_Cargo_SelectFormat( -1, $user_data['dept_codi'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$cargo->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=> ""),
															"selected"  => 	0);
			retornar_result($data);
            break;
		case GET:
            $cargo = new Cargo();
			$cargo->get( $user_data['cargo_codi'], $user_data['dept_codi'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$cargo->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=> ""),
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