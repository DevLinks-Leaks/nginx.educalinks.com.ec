<?php
session_start();
require_once('/../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {   
    $rol_usuario = get_mainObject('RolesUsuario');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                                    VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                    VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $rol_user_data = get_frontData();

	if (!isset($_POST['busq'])){$rol_user_data['busq'] = "";}else{$rol_user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "rol_table";}else{$tabla =$_POST['tabla'];}

    switch ($event) {
        case SET:
            $rol_usuario->set($rol_user_data);
            break;		
        case GET:
            $rol_usuario->get($rol_user_data['rol_codigo']);
            $data = array(
                'rol_codigo'=>$rol_user_data['rol_codigo'],
				'rol_nombre'=>$rol_usuario->rol_nombre,
                'rol_descripcion'=>$rol_usuario->rol_descripcion,
                'rol_estado'=>$rol_usuario->rol_estado
            );
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $rol_usuario->delete($rol_user_data['rol_codigo']);
			
            $data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
			$rol_usuario->get_all($rol_user_data['busq']);
			if(count($rol_usuario->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$rol_usuario->rows,
                                        "encabezado" => array("Codigo","Nombre","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"rol_codigo");
			}else{
				$data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
			}
            retornar_result($data);
            break;
        case EDIT:
            $rol_usuario->edit($rol_user_data);
            break;
		case GET_ALL:
            $rol_usuario->get_all($rol_user_data['busq']);
			if(count($rol_usuario->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$rol_usuario->rows,
                                        "encabezado" => array("Codigo","Nombre","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"rol_codigo");
			}else{
				$data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DATA:
            $rol_usuario->get_all($rol_user_data['busq']);
			if(count($rol_usuario->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$rol_usuario->rows,
                                        "encabezado" => array("Codigo","Nombre","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"rol_codigo");
			}else{
				$data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $rol_usuario->get_all($rol_user_data['busq']);
			if(count($rol_usuario->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$rol_usuario->rows,
                                        "encabezado" => array("Codigo","Nombre","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"rol_codigo");
			}else{
				$data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$rol_usuario->get_all($rol_user_data['busq']);
                if(count($rol_usuario->rows)>0){
					global $diccionario;
					$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                      "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/roles_usuarios/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$rol_usuario->rows,
                                        "encabezado" => array("Codigo","Nombre","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"rol_codigo");
                }else{
                    $data = array('mensaje'=>$rol_usuario->mensaje.$rol_usuario->ErrorToString());
                }
				
            retornar_vista($event, $data);
    }
}

handler();
?>