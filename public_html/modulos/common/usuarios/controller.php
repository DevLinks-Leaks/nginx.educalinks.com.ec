<?php
session_start();
require_once('/../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler(){
    $usuario = get_mainObject('Usuario');
    $roles = get_mainObject('Usuario');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT,
                                    VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                    VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $user_data = get_frontData();

	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "user_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case SET:
            $usuario->set($user_data);
            break;		
        case GET:
			$para="";
			$roles->get_all_roles($para);
			$usuario->get($user_data['usua_codigo']);
            $data = array(
                'usua_codigo'=>$user_data['usua_codigo'],
				'usua_nombres'=>$usuario->usua_nombres,
                'usua_apellidos'=>$usuario->usua_apellidos,
				'usua_correoElectronico'=>$usuario->usua_correoElectronico,
                'usua_estado'=>$usuario->usua_estado,
				'usua_clave'=>$usuario->usua_clave,
				'usua_fechaNacimiento'=>$usuario->usua_fechaNacimiento,
				'usua_codigoRol'=>$usuario->usua_codigoRol,
				'{combo_rol}' => array("elemento"  => "combo", 
                                       "datos"     => $roles->rows, 
                                       "options"   => array("name"=>"rol","id"=>"rol","required"=>"required"),
									   "selected"  => $usuario->usua_codigoRol));
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $usuario->delete($user_data['usua_codigo']);
            $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
			$usuario->get_all($user_data['busq']);
			if(count($usuario->rows)>0)
			{   global $diccionario;
				$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla","clase"=>"table table-striped table-hover","id"=>$tabla,"datos"=>$usuario->rows,"encabezado" => array("Nombre de Usuario","Nombres","Apellidos","Correo Electronico","Rol","Opciones"),"options"=>array($opciones),"campo"=>"usua_codigo");
			}
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
			}
            retornar_result($data,'listar');
            break;
        case EDIT:
            $usuario->edit($user_data);
            break;
		case GET_ALL_DATA:
            $usuario->get_all($user_data['busq']);
			if(count($usuario->rows)>0)
			{   global $diccionario;
				$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla_resultado}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$usuario->rows,
                                        "encabezado" => array("Nombre de Usuario","Nombres","Apellidos","Correo Electronico","Rol","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"usua_codigo");
			}
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $usuario->get_all_tbl($user_data['busq']);
			if(count($usuario->rows)>0)
			{   global $diccionario;
				$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$usuario->rows,
                                        "encabezado" => array(	"Ref.",
																"Usuario",
																"Nombres",
																"Apellidos",
																"e-mail",
																"Rol",
																"Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"ID");
			}
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
			$para="";
			$usuario->get_all_roles($para);
			$data = array('{combo_rol}' => array("elemento"  => "combo", 
                                                "datos"     => $usuario->rows, 
                                                "options"   => array("name"=>"rol_add","id"=>"rol_add","required"=>"required"),
												"selected"  => 0));
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$usuario->get_all($user_data['busq']);
                if(count($usuario->rows)>0)
				{   global $diccionario;
					$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
					$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
					$data['{tabla}']= array("elemento"=>"tabla","clase"=>"table table-striped table-hover","id"=>$tabla,"datos"=>$usuario->rows,"encabezado" => array("Nombre de Usuario","Nombres","Apellidos","Correo Electronico","Rol","Opciones"),"options"=>array($opciones),"campo"=>"usua_codigo");
                }
				else
				{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
                }
            retornar_vista($event, $data);
    }
}

handler();
?>