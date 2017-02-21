<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../../finan/categorias/model.php');
require_once('../../finan/nivelEconomico/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/items/model.php');

function handler() {
	$precio 		= get_mainObject('Item');
	$precio_valor 	= get_mainObject('Precio');
	$permiso 		= get_mainObject('General');
	$nivelEconomico = get_mainObject('NivelEconomico');
	$grupEcon 		= get_mainObject('GrupoEconomico');
	$categoria 		= get_mainObject('Categoria');
	$item 			= get_mainObject('Item');
	$event 			= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data 		= get_frontData();
	
	if (!isset($_POST['codigoProducto'])){$user_data['codigoProducto'] = "-1";}else{$user_data['codigoProducto'] =$_POST['codigoProducto'];}
	if (!isset($_POST['tabla'])){$tabla = "precio_table";}else{$tabla =$_POST['tabla'];}

    switch ($event){
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
            $categoria->get_selectFormat_all("");
            $categorias = $categoria->rows;
            global $diccionario;
            $permiso->permiso_activo($_SESSION['usua_codigo'], 144);
            if ($permiso->rows[0]['veri']==1)
            {	$data['disabled_agregar_precio']="";
				$opciones["Eliminar"] = "<span onclick='js_precios_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/precios/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Quitar precio' data-placement='left'></span>";
            } 
            else
            {	$data['disabled_agregar_precio']="disabled='disabled'";
				$opciones["Eliminar"]="";
            }
            $data = array('{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $categorias,
                                                       "options"   => array("name"		=>"codigoCategoria_busq",
                                                                            "id"		=>"codigoCategoria_busq",
                                                                            "required"	=>"required",
																			"class"		=>"form-control",
                                                                            "onChange"	=>"cargaProductos('resultadoProducto','".$diccionario['rutas_head']['ruta_html_finan']."/precios/controller.php');
																							busca('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/precios/controller.php');"),
                                                       "selected"  => 0),
                           '{combo_producto}' => array("elemento"  => "combo", 
                                                       "datos"     => array(0 => array(	0 => '', 
                                                                                        1 => '- Seleccione producto -',
                                                                                        3 => ''), 
                                                                            1=> array()),
                                                       "options"   => array("name"		=>"codigoProducto_busq",
                                                                            "id"		=>"codigoProducto_busq",
                                                                            "required"	=>"required",
																			"class"		=>"form-control",
                                                                            "onChange"	=>"busca('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/precios/controller.php')"),
                                                       "selected"  => 0)
                          );
            $precio_valor->producto = $user_data['codigoProducto'];
            $precio_valor->get_all();
            $data['{tabla}'] = array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>$tabla,
                                      "datos"=>$precio_valor->rows,
                                      "encabezado" => array("Ref.",
														    "Grupo Económico",
                                                            "Nivel Económico",
                                                            "P.V.P.",
                                                            "Fecha ingreso",
															""),
                                      "options"=>array($opciones),
                                      "campo"=>"codigo");            
            if(count($precio_valor->rows)>0){
                $data['mensaje'] = "Listado de precios";
            }else{
                $data['mensaje'] = $precio->mensaje.$precio_valor->ErrorToString();
            }
      			retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_PRODUCTO:
            $precio->getProductos_selectFormat($user_data['codigoCategoria']);
            global $diccionario;
            $data['{combo}'] = array("elemento"  => "combo", 
                                     "datos"     => $precio->rows,
                                     "options"   => array("name"=>"codigoProducto_busq",
                                                          "id"=>"codigoProducto_busq",
                                                          "required"=>"required",
                                                          "class"=>"form-control",
                                                          "onChange"=>"busca('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/precios/controller.php')"),
                                     "selected"  => 0);
            retornar_result($data);
            break;
        case GET_ALL_DATA:
            $precio_valor->producto = $user_data['codigoProducto'];
            $precio_valor->get_all();
			
            global $diccionario;
            $permiso->permiso_activo($_SESSION['usua_codigo'], 144);
            if ($permiso->rows[0]['veri']==1)
            {	$opciones["Eliminar"] = "<span onclick='js_precios_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/precios/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Quitar precio' data-placement='left'></span>";
            } 
            else
            {	$opciones["Eliminar"]="";
            }
			
            $data['{tabla}'] = array("elemento"=>"tabla",
                                     "clase"=>"table table-bordered table-hover",
                                     "id"=>$tabla,
                                     "datos"=>$precio_valor->rows,
                                     "encabezado" => array("Ref.",
														   "Grupo Económico",
                                                           "Nivel Económico",
                                                           "P.V.P.",
                                                           "Fecha ingreso",
														   ""),
                                     "options"=>array($opciones),
                                     "campo"=>"codigo");
            retornar_result($data);
            break;
        case VIEW_SET:
            $attrGrupoEconomico = array("name"=>"grupoEconomico_add","id"=>"grupoEconomico_add","class"=>"form-control");
            $attrNivelEconomico = array("name"=>"nivel_economico_add","id"=>"nivel_economico_add","class"=>"form-control");

            $nivelEconomico->get_niveles_economicos();
            $grupEcon->getCategorias_selectFormat_with_all();

            $item->get($user_data['codigoProducto']);
            if($item->precioGeneral == 1)
			{	$attrGrupoEconomico["disabled"] = 'true';
				$attrNivelEconomico["disabled"] = 'true';
            }
            $data = array('prec_productoCodigo' => $user_data['codigoProducto'],
                          'prec_productoNombre' => $user_data['nombreProducto'],
                          '{combo_grupoEconomico}' => array("elemento"  => "combo", 
                                                            "datos"     => $grupEcon->rows,
                                                            "options"   => $attrGrupoEconomico, 
                                                            "selected"  => 0),
                          '{combo_nivel_economico}' =>  array ("elemento"    => "combo",
                                                                "datos"     => $nivelEconomico->rows,
                                                                "options"   => $attrNivelEconomico, 
                                                                "selected"  =>  0)
                          );
			//$data["precio_general"] = $item->rows[0]['precioGeneral'];
			$data["precio_general"] = $item->precioGeneral;
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			switch($user_data['casos']){
				case "caso grupoeco":
					$resultado = $precio_valor->setLoteCategoriagrupoecon($user_data);
					break;
				case "caso niveleco":
					$resultado = $precio_valor->setLoteCategorianivelecon($user_data);
					break;
				case "caso gruponivel":
					$resultado = $precio_valor->setLoteCategorianivelgrupo($user_data);				
					break;
				case "caso individual":
					$resultado = $precio_valor->set($user_data);
					break;
				default:
					break;
			}
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
		case DELETE:
            //$user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			$resultado = $precio->delete($user_data['codigo']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
        default:
        	break;
    }
}
handler();
?>