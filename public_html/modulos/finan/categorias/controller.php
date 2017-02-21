<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	$categoria = get_mainObject('Categoria');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "categoria_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{	case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $categoria->get_all($user_data['busq']);
      		if(count($categoria->rows)>0)
			{	global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 137);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/categorias/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'></span>&nbsp;";
				}
				else
				{	$opciones["Editar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 138);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/categorias/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				}
				else
				{	$opciones["Eliminar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 185);
				if ($permiso->rows[0]['veri']==1)
				{	$data['disabled_agregar_categoria']="";
				} 
				else
				{	$data['disabled_agregar_categoria']="disabled='disabled'";
				}             
      				$data['{tabla}']= array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>$tabla,
                                      "datos"=>$categoria->rows,
                                      "encabezado" => array("Codigo",
                                                            "Nombre",
                                              				"Descripcion",
                                                            "Categoria Padre",
                                                            "Tipo Matr&iacute;cula",
                                                            ""),
                                                            "options"=>array($opciones),
                                                            "campo"=>"codigo");
				$data['mensaje'] = "Listado de categorias:";
      		}
			else
			{	$data = array('mensaje'=>$categoria->mensaje.$categoria->ErrorToString());
      		}
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $categoria->get_all($user_data['busq']);
            if(count($categoria->rows)>0)
			{	global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 137);
				if ($permiso->rows[0]['veri']==1)
                {	$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/categorias/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {	$opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 138);
                if ($permiso->rows[0]['veri']==1)
                {	$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/categorias/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
                }
                else
                {	$opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 185);
                if ($permiso->rows[0]['veri']==1)
                {	$data['disabled_agregar_categoria']="";
                } 
                else
                {	$data['disabled_agregar_categoria']="disabled='disabled'";
                } 
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$categoria->rows,
                                        "encabezado" => array("Codigo",
                                                              "Nombre",
                                                              "Descripcion",
                                                              "Categoria Padre",
                                                              "Tipo Matr&iacute;cula",
                                                              ""),
                                        "options"=>array($opciones),
                                        "campo"=>"codigo");
            }
            retornar_result($data);
            break;
        case VIEW_SET:
            $categoria->get_selectFormat("");
            $data = array('{combo_categoriaPadre}' => array("elemento"  => "combo", 
                                                            "datos"     => $categoria->rows,
                                                            "options"   => array("name"=>"categoriaPadre_add","id"=>"categoriaPadre_add","class"=>"form-control","required"=>"required"),
                                                            "selected"  => '-1' ));
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			$resultado = $categoria->set($user_data);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;  
        case GET:
            $categoria->get_selectFormat("");
            $categoriasPadres = $categoria->rows;
            $categoria->get($user_data['codigo']);

            $data = array('cate_codigo'=>$user_data['codigo'],
                          'cate_nombre'=>$categoria->nombre,
                          'cate_descripcion'=>$categoria->descripcion,
						  'ckb_tipoMatricula_mod_checked'=> ( $categoria->tipoMatricula > 0 ? ' checked="checked" ' : '' ) ,
                          '{combo_categoriaPadre}' => array("elemento"  => "combo", 
                                                            "datos"     => $categoriasPadres,
                                                            "options"   => array("name"=>"categoriaPadre_mod","id"=>"categoriaPadre_mod","class"=>"form-control","required"=>"required"),
                                                            "selected"  => $categoria->categoriaPadre));
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
			$resultado = $categoria->delete($user_data['codigo']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
        case EDIT:
			$resultado = $categoria->edit($user_data);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
          break;
        default :
        	break;
    }
}

handler();
?>