<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('../../finan/categorias/model.php');
require_once('../../finan/items/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	require('../../../core/rutas.php');
	$factura = get_mainObject('Factura');
	$categoria = get_mainObject('Categoria');
	$item = get_mainObject('Item');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, VIEW_SET_CLIENT, VIEW_GET_PRODUCT, VIEW_PRINT_FACT, GET_CLIENT), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "detalleFactura_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{	case VIEW_GET_ALL:
			#  Presenta la pagina inicial
			global $diccionario;
			    if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}

			$permiso->permiso_activo($_SESSION['usua_codigo'], 131);
			if ($permiso->rows[0]['veri']==1)
			{   $data['disabled_agregar_producto']="";
			} 
			else
			{   $data['disabled_agregar_producto']="disabled='disabled'";
			}
			$permiso->permiso_activo($_SESSION['usua_codigo'], 132);
			if ($permiso->rows[0]['veri']==1)
			{   $data['disabled_generar_deuda']="";
			} 
			else
			{   $data['disabled_generar_deuda']="disabled='disabled'";
			}
            
			$tipoIdentificacion = array(0 => array(0=>'CI', 1=>'Cedula'),
                                        1 => array(0=>'RUC', 1=>'RUC'),
									    2 => array(0=>'PLC', 1=>'Pasaporte'),
                                        3 => array());    
			
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			
			$data['{combo_tipoIdentificacion}'] = array(  "elemento"  => "combo", 
														  "datos"     => $tipoIdentificacion,
														  "options"   => array("name"=>"tipoIdentificacionTitular",
																				"id"=>"tipoIdentificacionTitular",
																				"required"=>"required",
																				"disabled"=>"disabled",
																				"class"=>"form-control",
																				"style"=>"width:100%;"),
														  "selected"  => 0);

			$factura->getPrefijos($_SESSION['usua_codigo']);
			$data['prefijoSucursal'] = ( count($factura->rows)>0 ? $factura->rows[0]['prefijoSucursal'] : '00' );
			$data['prefijoPuntoVenta'] = ( count($factura->rows)>0 ? $factura->rows[0]['prefijoPuntoVenta'] : '00' );
      		$data['{tabla}'] = array(  "elemento"=>"tabla",
									   "clase"=>"table table-striped table-hover table-bordered",
									   "id"=>$tabla,
									   "datos"=>array(),
									   "encabezado" => array("Categoria",
															 "Producto",
															 "<div style='text-align:right;'>Precio ($)</div>",
															 "Cantidad",
															 "<div style='text-align:right;'>Descuento ($)</div>",
															 "<div style='text-align:right;'>*IVA</div>",
															 "<div style='text-align:right;'>Subtotal ($)</div>",
															 "Remover"),
															 "options"=>array(),
															 "campo"=>"codigo");
            $data['mensaje'] = "";
			$data['opciones_cliente']= " ";
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case VIEW_GET_CLIENT:
            # Presenta el modal de Busqueda del cliente
            $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-hover",  
                                                    "id"=> "clientes_table",  
                                                    "datos"     => array(),
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_formulario(VIEW_GET_CLIENT, $data);
            break;
        case GET_CLIENT:
            # Consulta los clientes a traves de los filtros (nombres e identificacion) y devuelve la tabla con los resultados
            //$factura->get_clientes($user_data, $_SESSION['peri_codi']);
            $factura->get_clientes($user_data);
            $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-hover",  
                                                    "id"=> "clientes_table",  
                                                    "datos"     => $factura->rows,
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_result($data);
            break;
        case GET_ALUMNO_ADICIONAL:
            # Consulta los datos del titular de facturacion de un cliente especifico
            $factura->codigoCliente = $user_data['codigoCliente'];
            $factura->get_infoAdicionalAlumno($_SESSION['peri_codi']);
            array_pop($factura->rows);
            echo json_encode($factura->rows);
            break;
        case VIEW_GET_PRODUCT:
            # Muestra el formulario de consulta de un producto para agregarlo al detalle
            $categoria = new Categoria();
            $categoria->get_selectFormat();
            global $diccionario;
            $data = array('{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $categoria->rows,
                                                       "options"   => array("name"=>"codigoCategoria_busq",
                                                                            "id"=>"codigoCategoria_busq",
                                                                            "required"=>"required",
																			"class"=>"form-control",
                                                                            "onChange"=>"cargaProductos('resultadoProducto','".$diccionario['rutas_head']['ruta_html_finan']."/facturas/controller.php')"),
                                                       "selected"  => -1),
                          '{combo_producto}' => array("elemento"  => "combo", 
                                                       "datos"     => array(0 => array(0 => -1, 
                                                                                       1 => 'Seleccione...',
                                                                                       2 => ''), 
                                                                            1=> array()),
                                                       "options"   => array("name"=>"codigoProducto_busq",
                                                                            "id"=>"codigoProducto_busq",
                                                                            "required"=>"required",
																			"class"=>"form-control",
                                                                            "onChange"=>"js_facturas_buscaPrecio('".$diccionario['rutas_head']['ruta_html_finan']."/facturas/controller.php')"),
                                                       "selected"  => 0)
                          );

            retornar_formulario(VIEW_GET_PRODUCT, $data);
            break;
        case GET_PRODUCT:
            $item = new Item();
            $item->getProductos_selectFormat($user_data['codigoCategoria']);
            global $diccionario;
            $data['{combo}'] = array("elemento"  => "combo", 
                                     "datos"     => $item->rows,
                                     "options"   => array("name"=>"codigoProducto_busq",
                                                          "id"=>"codigoProducto_busq",
                                                          "required"=>"required",
														  "class"=>"form-control",
                                                          "onChange"=>"js_facturas_buscaPrecio('".$diccionario['rutas_head']['ruta_html_finan']."/facturas/controller.php')"),
                                     "selected"  => 0);
            retornar_result($data);
            break;
        case GET_PRICE:
            // Consulto el precio
            $precio = new Precio();
			
            $precio->getSinglePrice($user_data['codigoProducto'], ($user_data['codigoGrupoEconomico']!=""? $user_data['codigoGrupoEconomico'] : "-1"), ($user_data['codigoNivelEconomico']!="" ? $user_data['codigoNivelEconomico'] : "-1") );
            // Consulto el producto para ver si lleva o no IVA
           
		    $producto = new Item();
            $producto->get($user_data['codigoProducto']);
            array_pop($producto->rows);
			
            // Consulto el descuento
			$descuento_final = array();
            $cliente = new Cliente();
            $descuento = $cliente->getDescuento($user_data['codigoCliente'], $_SESSION['peri_codi']);
			//Si hay más de un descuento, considero si el sistema está configurado para calcular un descuento sobre otro descuento,
			//o si por cada descuento voy reduciendo el porcentaje respectivo.
            if ( count( $descuento ) > 1 )
			{   $metodo_descuento = new Factura();
				$md = $metodo_descuento->get_metodo_descuento_alumno();
				if ( $md == 'desc_sumado' )
				{   foreach ( $descuento as $desc_row )
					{   if( !empty( $desc_row ) || ( $desc_row != null ) )
							$descuento_final[0]['descuento'] = $descuento_final[0]['descuento'] + $desc_row['descuento'];
					}
				}
				else
				{   foreach ( $descuento as $desc_row )
					{   if( !empty( $desc_row ) || $desc_row != null )
						{   $descuento_final[]['descuento'] = $desc_row['descuento'];
						}
					}
				}
			}
			else
			{   if( !empty( $descuento->rows[0]["descuento"] ) )
					$descuento_final[0] = $descuento->rows[0]["descuento"];
			}
			//Consulto el porcentaje del IVA
            $iva = 0;
            $factura = new Factura();
            $iva = $factura->get_porcentajeIVA();
            
            $resultadoFinal = array('precio' 			=> $precio->rows[0]['precio'],
                                    'aplicaIVA' 		=> $producto->rows[0]['aplicaIVA'],
									'descuentoAsignado' => $descuento_final,
                                    'porcentajeIva' 	=> $iva,
									'metodo' 			=> $md,
									'descuento'			=> $producto->rows[0]['descuento']
                                    );
			
            echo json_encode($resultadoFinal);
            break;
		case GET_METODO_DESCUENTO:
			$metodo_descuento = new Factura();
			echo $metodo_descuento->get_metodo_descuento_alumno();
			break;
        case VIEW_EDIT_DETAIL:
            # Muestra el formulario de consulta de producto con la informacion de un detalle de la factura para su edicion
            //global $diccionario;
            $data = array(
                  'codigoCategoria_mod' => $user_data['codigoCategoria'],
                  'nombreCategoria_mod' => $user_data['nombreCategoria'],
                  'codigoProducto_mod' => $user_data['codigoProducto'],
                  'nombreProducto_mod' => $user_data['nombreProducto'],
                  'detalle_mod' => $user_data['idDetalle'],
                  'precio_mod' => $user_data['precio'],
                  'cantidad_mod' => $user_data['cantidad'],
                  'descuento_mod' => $user_data['descuento'],
                  'iva_mod' => $user_data['iva'],
                  'aplicaIVA_mod' => $user_data['aplicaIVA'],
                  'subtotal_mod' => $user_data['subtotal']
                          );

            retornar_formulario(VIEW_EDIT_DETAIL, $data);
            break;
        case SET_FACTURA:
            $datosFactura = array();
            $datosFactura = json_decode($user_data['datosFactura'], true);

            $lineaDetalle = 0;
            $esquemaXML = '<?xml version="1.0" encoding="iso-8859-1"?>';
            $esquemaXML .= '<fc>';
            $esquemaXML .=  '<cb ';
			$esquemaXML .=    'md="'.$datosFactura['cabecera']['md'].'" '; //método de descuento
            $esquemaXML .=    'cl="'.$datosFactura['cabecera']['codigoCliente'].'" ';
            $esquemaXML .=    'tid="'.$datosFactura['cabecera']['tipoIdentificacionTitular'].'" ';
            $esquemaXML .=    'id="'.$datosFactura['cabecera']['numeroIdentificacionTitular'].'" ';
            $esquemaXML .=    'nm="'.$datosFactura['cabecera']['nombresTitular'].'" ';
            $esquemaXML .=    'em="'.$datosFactura['cabecera']['emailTitular'].'" ';
            $esquemaXML .=    'tlf="'.$datosFactura['cabecera']['telefonoTitular'].'" ';
            $esquemaXML .=    'dr="'.$datosFactura['cabecera']['direccionTitular'].'" ';
            $esquemaXML .=    'tB="'.$datosFactura['cabecera']['totalBruto'].'" ';
            $esquemaXML .=    'tD="'.$datosFactura['cabecera']['totalDescuento'].'" ';
            $esquemaXML .=    'tIVA="'.$datosFactura['cabecera']['totalIVA'].'" ';
            $esquemaXML .=    'tICE="'.$datosFactura['cabecera']['totalICE'].'" ';
            $esquemaXML .=    'tN="'.$datosFactura['cabecera']['totalNeto'].'" ';
            $esquemaXML .=    'fIni="'.$datosFactura['cabecera']['fechaInicio_cobro'].'" ';
            $esquemaXML .=    'fFin="'.$datosFactura['cabecera']['fechaVencimiento'].'" ';
			$esquemaXML .=    'gfce="'.$datosFactura['cabecera']['generaFactura'].'" '; //Generar Factura comprobante electrónico
            $esquemaXML .=    'u="'.$_SESSION['usua_codigo'].'" ';
            $esquemaXML .=    'pV="'.$_SESSION['puntVent_codigo'].'" ';
            $esquemaXML .=    'peri="'.$_SESSION['peri_codi'].'" ';
            $esquemaXML .=  " />";
            $esquemaXML .=  '<dt>';
            foreach ($datosFactura['detalle'] as $detalle) {
				$detalle['totalNeto']=number_format(0,2);
				$detalle['totalNeto']= (number_format($detalle['cantidad'],2)*number_format($detalle['totalBruto'],2))-number_format($detalle['totalDescuento'],2);
				$lineaDetalle += 1;
				$esquemaXML .=  '<l ';
				$esquemaXML .=    's="'.$lineaDetalle.'" ';
				$esquemaXML .=    'i="'.$detalle['codigoProducto'].'" ';
				$esquemaXML .=    'p="'.$detalle['precio'].'" ';
				$esquemaXML .=    'c="'.$detalle['cantidad'].'" ';
				$esquemaXML .=    'sB="'.$detalle['totalBruto'].'" ';
				$esquemaXML .=    'sD="'.$detalle['totalDescuento'].'" ';
				$esquemaXML .=    'sIVA="'.$detalle['totalIVA'].'" ';
				$esquemaXML .=    'sICE="'.$detalle['totalICE'].'" ';
				$esquemaXML .=    'sN="'.$detalle['totalNeto'].'" ';
            	$esquemaXML .=  ' />';
            }
            $esquemaXML .=  "</dt>";
            $esquemaXML .= "</fc>";

            //var_dump($esquemaXML);

            $factura->set($esquemaXML);

            $data = array(
                  'tipo_mensaje' => ($factura->codigo > 0 ? 'alert-success' : 'alert-warning'),
                  'mensaje' => $factura->mensaje.($factura->codigo <= 0 ? $factura->ErrorToString() : ''),
                  'codigoFactura' => ($factura->codigo > 0 ? $factura->codigo : '0000'),
                  'numeroFactura' => '0000'
                         );
            retornar_formulario(VIEW_PRINT_FACT, $data);
            break;
        default :
        	break;
    }
}

handler();
?>