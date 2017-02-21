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
            $dept = new Departamento();
			$dept->get_Dept_SelectFormat( -1, $user_data['area_codi'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$dept->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>"js_cargo_cargaCargo_SelectFormat('".$user_data['div_followed']."','".$user_data['combo_nombre_followed']."',this.value);"),
															"selected"  => 	0);
			retornar_result($data);
            break;
		case GET:
            $dept = new Departamento();
			$dept->get( $user_data['dept_codi'], $user_data['area_codi'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$dept->rows, 
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