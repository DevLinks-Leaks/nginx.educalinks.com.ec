<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $sucursal = get_mainObject('Sucursal');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $sucu_data = get_frontData();    
    $permiso = get_mainObject('General');

	if (!isset($_POST['busq'])){$sucu_data['busq'] = "";}else{$sucu_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "sucu_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{   case SET:
            $resultado = $sucursal->set($sucu_data);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
        case GET:
			$sucursal->get($sucu_data['sucu_codigo']);
            $data = array(
                'sucu_codigo'=>$sucu_data['sucu_codigo'],
				'sucu_descripcion'=>$sucursal->sucu_descripcion,
                'sucu_direccion'=>$sucursal->sucu_direccion,
				'sucu_prefijo'=>$sucursal->sucu_prefijo,
                'sucu_estado'=>$sucursal->sucu_estado);
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $resultado = $sucursal->delete($sucu_data['sucu_codigo']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
        case EDIT:
            $resultado = $sucursal->edit($sucu_data);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
		case GET_ALL:
            $sucursal->get_all($sucu_data['busq']);
			if(count($sucursal->rows)>0)
			{   global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 108);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.");' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {   $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 109);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")'  title='Eliminar'>&nbsp;</span>";
                }
                else
                {   $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 107);
                if ($permiso->rows[0]['veri']==1)
                {   $data['disabled_agregar_sucursal']="";
                } 
                else
                {   $data['disabled_agregar_sucursal']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$sucursal->rows,
                                        "encabezado" => array("Código de Sucursal","Descripción","Dirección","Prefijo","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"sucu_codigo");
			}
			else
			{   $data = array('mensaje'=>$sucursal->mensaje.$sucursal->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DATA:
            $sucursal->get_all($sucu_data['busq']);
			if(count($sucursal->rows)>0)
			{   global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 108);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.");' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {   $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 109);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")'  title='Eliminar'>&nbsp;</span>";
                }
                else
                {   $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 107);
                if ($permiso->rows[0]['veri']==1)
                {   $data['disabled_agregar_sucursal']="";
                } 
                else
                {   $data['disabled_agregar_sucursal']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$sucursal->rows,
                                        "encabezado" => array("Código de Sucursal","Descripción","Dirección","Prefijo","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"sucu_codigo");
			}
			else
			{   $data = array('mensaje'=>$sucursal->mensaje.$sucursal->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $sucursal->get_all($sucu_data['busq']);
			if(count($sucursal->rows)>0)
			{   global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 108);
				if ($permiso->rows[0]['veri']==1)
                {   $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.");' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {   $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 109);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")'  title='Eliminar'>&nbsp;</span>";
                }
                else
                {   $opciones["Eliminar"]="";
                }

                $permiso->permiso_activo($_SESSION['usua_codigo'], 107);
                if ($permiso->rows[0]['veri']==1)
                {   $data['disabled_agregar_sucursal']="";
                } 
                else
                {   $data['disabled_agregar_sucursal']="disabled='disabled'";
                }

				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$sucursal->rows,
                                        "encabezado" => array("Código de Sucursal","Descripción","Dirección","Prefijo","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"sucu_codigo");
			}
			else
			{   $data = array('mensaje'=>$sucursal->mensaje.$sucursal->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$sucursal->get_all($sucu_data['busq']);
			if(count($sucursal->rows)>0)
			{	global $diccionario;
				$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.");' title='Editar' data-placement='left'>&nbsp;</span>",
                                      "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/sucursales/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")'  title='Eliminar'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$sucursal->rows,
                                        "encabezado" => array("Código de Sucursal","Descripción","Dirección","Prefijo","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"sucu_codigo");
			}
			else
			{   $data = array('mensaje'=>$sucursal->mensaje.$sucursal->ErrorToString());
			}
            retornar_vista($event, $data);
			break;
    }
}
handler();
?>