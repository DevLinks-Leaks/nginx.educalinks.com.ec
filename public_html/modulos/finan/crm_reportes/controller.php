<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $residencia = get_mainObject('ResidenciaTipos');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                                    VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                    VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $resi_data = get_frontData();

	if (!isset($_POST['busq'])){$resi_data['busq'] = "";}else{$resi_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "residencia_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $residencia->set($resi_data);
            break;		
        case GET:
			$residencia->get($resi_data['resi_tipo_codigo']);
            $data = array(
                'resi_tipo_codigo'=>$resi_data['resi_tipo_codigo'],
				'resi_tipo_nombre'=>$residencia->resi_tipo_nombre,
                'resi_tipo_descripcion'=>$residencia->resi_tipo_descripcion,
                'resi_tipo_estado'=>$residencia->resi_tipo_estado);
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $residencia->delete($resi_data['resi_tipo_codigo']);           
            break;
        case EDIT:
            $residencia->edit($resi_data);
            break;
		case GET_ALL_DATA:
            $residencia->get_all($resi_data['busq']);
			if(count($residencia->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$residencia->rows,
                                        "encabezado" => array("Código","Modelo","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"resi_tipo_codigo");
			}else{
				$data = array('mensaje'=>$residencia->mensaje.$residencia->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $residencia->get_all($resi_data['busq']);
			if(count($residencia->rows)>0){
				global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$residencia->rows,
                                        "encabezado" => array("Código","Modelo","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"resi_tipo_codigo");
				$data['mensaje'] = "Listado de Modelos de Villas:";
			}else{
				$data = array('mensaje'=>$residencia->mensaje.$residencia->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$residencia->get_all($resi_data['busq']);
                if(count($residencia->rows)>0){
					global $diccionario;
					$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/residencia_tipos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$residencia->rows,
                                        "encabezado" => array("Código","Modelo","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"resi_tipo_codigo");
                }else{
                    $data = array('mensaje'=>$residencia->mensaje.$residencia->ErrorToString());
                }
				
            retornar_vista($event, $data);
    }
}

handler();
?>