<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   $item = get_mainObject('Item');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "item_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $item->get_all($user_data['busq']);
      		if(count($item->rows)>0)
			{   global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 141);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/items/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				}
				else
				{	$opciones["Editar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 142);
				if ($permiso->rows[0]['veri']==1)
				{   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/items/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				}
				else
				{	$opciones["Eliminar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 140);
				if ($permiso->rows[0]['veri']==1)
				{	$data['disabled_agregar_item']="";
				} 
				else
				{	$data['disabled_agregar_item']="disabled='disabled'";
				}
				$data['{tabla}']=array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>$tabla,
                                      "datos"=>$item->rows,
                                      "encabezado" => array("Codigo",
                                                            "Nombre",
                                              				"Descripcion",
                                                            "Categoria",
                                                            "C. contable",
															"Desc",
                                                            "IVA",
                                                            "ICE",
                                                            "Precio general",
															"Rep. liquidez",
															"Prontopago",
                                                            "Opciones"),
                                      "options"=>array($opciones),
                                      "campo"=>"codigo");
				$data['mensaje'] = "Listado de items:";
      		}
			else
			{	$data = array('mensaje'=>$item->mensaje.$item->ErrorToString());
      		}
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $item->get_all($user_data['busq']);
            if(count($item->rows)>0)
			{   global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 141);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/items/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {	$opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 142);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/items/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
                }
                else
                {   $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 140);
                if ($permiso->rows[0]['veri']==1)
                {   $data['disabled_agregar_item']="";
                } 
                else
                {   $data['disabled_agregar_item']="disabled='disabled'";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$item->rows,
                                        "encabezado" => array("Codigo",
                                                            "Nombre",
                                              				"Descripcion",
                                                            "Categoria",
                                                            "C. contable",
															"Desc",
                                                            "IVA",
                                                            "ICE",
                                                            "Precio general",
															"Rep. liquidez",
															"Prontopago",
                                                            "Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"codigo");
            }
            retornar_result($data);
            break;
        case VIEW_SET:
            $item->getCategorias_selectFormat("");
            $data = array('{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $item->rows,
                                                       "options"   => array("name"=>"codigoCategoria_add","id"=>"codigoCategoria_add","class"=>"form-control","required"=>"required"),
                                                       "selected"  => 0));
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $item->set($user_data);
            break;  
        case GET:
            $item->getCategorias_selectFormat("");
            $categorias = $item->rows;
            $item->get($user_data['codigo']);

            $data = array('item_codigo'=>$user_data['codigo'],
                          'item_nombre'=>$item->nombre,
                          'item_descripcion'=>$item->descripcion,
                          'item_aplicaIVA'=> ($item->aplicaIVA == 1)? 'checked':'',
                          'item_aplicaICE'=> ($item->aplicaICE == 1)? 'checked':'',
                          'item_precioGeneral'=> ($item->precioGeneral == 1)? 'checked':'',
						  'item_descuento'=> ($item->descuento == 1)? 'checked':'',
						  'item_liquidez'=> ($item->liquidez == 1)? 'checked':'',
						  'item_prontopago'=> ($item->prontopago == 1)? 'checked':'',
                          'item_cuentaContable'=>$item->cuentaContable,
                          '{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $categorias,
                                                       "options"   => array("name"=>"codigoCategoria_mod","id"=>"codigoCategoria_mod","class"=>"form-control","required"=>"required"),
                                                       "selected"  => $item->categoria));
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $resultado = $item->delete($user_data['codigo']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result( $data );
			break;
        case EDIT:
            $resultado = $item->edit($user_data);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result( $data );
			break;
		case GET_SUBTIPO_COMBO:
            $item = new Item();
			$item->getProductos_selectFormat( $user_data['categoria'] );
            $data['{'.$user_data['combo_nombre'].'}']=array("elemento"  => 	"combo", 
															"datos"     => 	$item->rows, 
															"options"   => 	array(	"name"		=>$user_data['combo_nombre'],
																					"id"		=>$user_data['combo_nombre'],
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>""),
															"selected"  => 	0);
			retornar_result($data);
            break;
        default :
        	break;
    }
}
handler();
?>