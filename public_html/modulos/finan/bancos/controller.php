<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $banco = get_mainObject('Bancos');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $banco_data = get_frontData();    
    $permiso = get_mainObject('General');

	if (!isset($_POST['busq'])){$banco_data['busq'] = "";}else{$banco_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $banco->set($banco_data);
            break;		
        case GET:
			$banco->get($banco_data['banc_codigo']);
            $data = array(
                'banc_codigo'=>$banco_data['banc_codigo'],
				'banc_nombre'=>$banco->banc_nombre
              );
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $banco->delete($banco_data['banc_codigo']);
            $data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			$banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_result($data);
            break;
        case EDIT:
            $banco->edit($banco_data);
            break;
		case GET_ALL:
            $banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DATA:
            $banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;

                $permiso->permiso_activo($_SESSION['usua_codigo'], 188);
				if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
					$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }

				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
			
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$banco->get_all($banco_data['busq']);
                if(count($banco->rows)>0){
					global $diccionario;
					$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' data-placement='left'>&nbsp;</span>",
                                      "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
       								    "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
                }else{
                    $data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
                }
				
            retornar_vista($event, $data);
			break;
    }
}

handler();
?>