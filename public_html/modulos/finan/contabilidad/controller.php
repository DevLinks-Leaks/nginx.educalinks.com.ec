<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../categorias/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	$curso= get_mainObject('Contabilidad');
	$alumnos= get_mainObject('Contabilidad');
	$fecha=get_mainObject('Contabilidad');
    $conta = get_mainObject('Contabilidad');
	$prod = get_mainObject('Contabilidad');
	$categoria = get_mainObject('Categoria');
	$categoria_VGA = get_mainObject('Contabilidad');
	$caja = get_mainObject('Contabilidad');
	$cajaupd = get_mainObject('Contabilidad');
	$detpago = get_mainObject('Contabilidad');
	$detfact = get_mainObject('Contabilidad');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $user_data = get_frontData();    
    $permiso = get_mainObject('General');

	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "tablapagos";}else{$tabla=$_POST['tabla'];}
	
    switch ($event)
	{   case VIEW_BADGE_DEUDAS:
			$conta->get_menu_count_deudasPendienteToCONTIFICO();
			if(count($conta->rows)-1>0)
			{	if($conta->rows[0]['deudas_pendientes']>0) print $conta->rows[0]['deudas_pendientes'];
			}
			break;
		case VIEW_BADGE_PAGOS:
			$conta->get_menu_count_pagosPendienteToCONTIFICO();
			if(count($conta->rows)-1>0)
			{	if($conta->rows[0]['pagos_pendientes']>0) print $conta->rows[0]['pagos_pendientes'];
			}
			break;	
		case SETPRODUCTOS:
			$contifico=array();
			$contifico=json_decode($user_data['prodcontifico_codigo'], true);
            $conta->updproducto($user_data['codigo_productos'],$contifico['id']);
            break;	
		case UPDPRODUCTOS:
			$conta->updproducto($user_data['codigo_productos'],$user_data['prodcontifico_codigo']);
            break;
		case UPDATE_DNAS:
			$conta->get_paidDNAs_contificoindividual( $user_data['anio'], $user_data['mes'] );
			global $diccionario;
			$opciones["Migrar"] = "<span onclick='js_contabilidad_updfacturasindividuales(".'"{codigo}"'.",".'"modal_upd_dnas_confirmacion_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_upd_dnas_confirmacion' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title='Migrar'>&nbsp;</span>";

			$data = array('mes_paid_dnas' => $user_data['mes']);
			
			$data['{tablapaiddnas}'] =array("elemento"	=>"tabla",
											"clase"		=>"table table-bordered table-hover",
											"id"		=>"tablapaiddnas",
											"datos"		=> $conta->rows,
											"encabezado"=>array("Codigo Deuda",
																"Cliente",
																"Producto",
																"Valor Deuda",
																"Estado",
																"Opciones"),
											"options"	=>array($opciones),
											"campo"		=>"deudacodigo");
			
			retornar_formulario( VIEW_GET_PAID_DNAS, $data );
			break;
		case MIGRAR:
			$conta->get_deudas_contificoindividual( $user_data['anio'], $user_data['mes'] );
			global $diccionario;
			$opciones["Migrar"] = "<span onclick='js_contabilidad_migrarfacturasindividuales(".'"{codigo}"'.",".'"modal_pagosconfirmacion_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.",".'this'.");' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_pagosconfirmacion' id='{codigo}' onmouseover='$(this).tooltip(".'"show"'.")' title='Migrar'>&nbsp;</span>";
			$data = array('mes' => $user_data['mes']);
			$data['{tabladeudasmigrar}'] =array("elemento"=>"tabla",
												"clase"=>"table table-bordered table-hover",
												"id"=>"tablapagomigrar",
												"datos"=> $conta->rows,
												"encabezado" => array("Ref. Pago/sec.",
																	  "Ref. Factura",
																	  "Cliente",
																	  "Producto",
																	  "T. Pago",
																	   "Estado",
																	  "Opciones"),
												"options"=>array($opciones),
												"campo"=>"pagocodigo");
			retornar_formulario(VIEW_GET_DEUDAS, $data);
            break;
		case MIGRARFACTURASINDIVIDUALES:
	        $datos1 =array();
			$datos2 =array();
	        //$curso->getdetallefactura($conta->rows[0]['descripcion'],$user_data['codigofactura']);
			$alumnos->getdetallepago($user_data['codigodeuda'],$user_data['codigofactura']);
			$codigocontifico=  $alumnos->rows[0]['codigodeuda'];
			for($b=0;$b<=count($alumnos->rows)-2;$b++){
				$datos=(array('forma_cobro'=>$alumnos->rows[$b]['formapago'],'monto'=>$alumnos->rows[$b]['monto'],'numero_cheque'=>$alumnos->rows[$b]['chequenumero'],'tipo_ping'=>$alumnos->rows[$b]['tipoping']));
			}
		    $data['datosdoc'] = $datos;
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'codigodeuda'=> $user_data['codigodeuda'],'contificoid'=> $codigocontifico);
			retornar_formulario(VIEW_MIGRACIONINDIVIDUAL, $data);
            break;
		case MIGRARFACTURASINDIVIDUALESACT:
			$conta->get_deudas_individualmigracion($user_data['codigodeuda']);
			$datos1 =array();
			$datos2 =array();
			$datos['id']=$conta->rows[0]['idcontifico'];
			$datos['pos']=$conta->rows[0]['apitoken'];
			
			$datos['fecha_emision']=$conta->rows[0]['fechacreacion'];
			$datos['tipo_documento']=$conta->rows[0]['tipodocumento'];
			$datos['documento']=$conta->rows[0]['id'];
		
			$datos['estado']=$conta->rows[0]['estado'];
			$datos['autorizacion']=$conta->rows[0]['numautorizacion'];
			$datos['caja_id']='null';
			$datos['cliente']=array('ruc'=>$conta->rows[0]['ruc'],'cedula'=>$conta->rows[0]['cedula'],'razon_social'=>$conta->rows[0]['razonsocial'],'telefonos'=>$conta->rows[0]['telefono'],'direccion'=>$conta->rows[0]['direccion'],'tipo'=>$conta->rows[0]['tipo'],'email'=>$conta->rows[0]['email'],'es_extranjero'=>$conta->rows[0]['esextranjero']);
			$datos['vendedor']=array('ruc'=>$conta->rows[0]['rucvendedor'],'cedula'=>$conta->rows[0]['cedulavendedor'],'razon_social'=>$conta->rows[0]['razonsocialvendedor'],'telefonos'=>$conta->rows[0]['telefonovendedor'],'direccion'=>$conta->rows[0]['direccionvendedor'],'tipo'=>$conta->rows[0]['tipovendedor'],'email'=>$conta->rows[0]['emailvendedor'],'es_extranjero'=>$conta->rows[0]['extranjerovendedor']);
			$datos['descripcion']=$conta->rows[0]['descripcion'];
			$datos['subtotal_0']=$conta->rows[0]['subtotal0'];
			$datos['subtotal_12']=$conta->rows[0]['subtotaliva'];
			$datos['iva']=$conta->rows[0]['iva'];
			$datos['servicio']=$conta->rows[0]['servicio'];
			$datos['total']=$conta->rows[0]['total'];
			$datos['adicional1']=$conta->rows[0]['adicional1'];
			$datos['adicional2']=$conta->rows[0]['adicional2'];
			$curso->getdetallefactura($conta->rows[0]['descripcion']);
			$alumnos->getdetallepago($conta->rows[0]['descripcion']);
			
			$aux_det = 0;
			foreach ( $curso->rows as $detalle_rows )
			{   if( !empty( $detalle_rows ) )
				{   $datos['detalles'][$aux_det] = array('producto_id'=>$detalle_rows['id_contifico'],'cantidad'=>$detalle_rows['cantidad'],'precio'=>$detalle_rows['precio'],'porcentaje_iva'=>$detalle_rows['iva'],'porcentaje_descuento'=>$detalle_rows['descuento'],'base_cero'=>$detalle_rows['basecero'],'base_gravable'=>$detalle_rows['basegravable'],'base_no_gravable'=>$detalle_rows['basenogravable']);	
					$aux_det++;
				}
			}
			
			for($b=0;$b<=count($alumnos->rows)-2;$b++){
				$datos['cobros']=array(array('forma_cobro'=>$alumnos->rows[$b]['formapago'],'monto'=>$alumnos->rows[$b]['monto'],'numero_cheque'=>$alumnos->rows[$b]['chequenumero'],'tipo_ping'=>$alumnos->rows[$b]['tipoping']));
			}
			//var_dump($conta->rows[0]['id']);
		    $data['datosdoc'] = $datos;
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'codigodeuda'=> $datos['descripcion']);
			retornar_formulario(VIEW_MIGRACIONINDIVIDUAL, $data);
            break;
		case MIGRARFACTURAS:
			$alumnos->getdetallepagolote($user_data['mes'],$user_data['anio']);
			$datos1 =array();
			$datos2 =array();
			for($i=0;$i<=count($alumnos->rows)-2;$i++){	
				$datos1[$i]= $alumnos->rows[$i]['codigodeuda'];
				$datos2[$i]= $alumnos->rows[$i]['codigopago'];
				$datos=(array('forma_cobro'=>$alumnos->rows[$i]['formapago'],'monto'=>$alumnos->rows[$i]['monto'],'numero_cheque'=>$alumnos->rows[$i]['chequenumero'],'tipo_ping'=>$alumnos->rows[$i]['tipoping']));
				$data['datosdoc'][$i] = $datos;
            } 
			$jsondeudasid= json_encode($datos1);
			$jsondeudasidpago= json_encode($datos2);
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'idpago'=> $jsondeudasid,'idpagocodigo'=> $jsondeudasidpago);
			retornar_formulario(VIEW_MIGRARDEUDAS, $data);
            break;
		case MIGRARFACTURASACT:
		    $conta->getfacturacontifico( $user_data['peri_codi'], $user_data['mes'] );
		    $datos1 =array();
			$datos2 =array();
			for($i=0;$i<=count($conta->rows)-2;$i++){	
				$datos1[$i]=$conta->rows[$i]['idcontifico'];
				$datos['id']=$conta->rows[$i]['idcontifico'];
				$datos['pos']=$conta->rows[$i]['apitoken'];
				$datos['fecha_emision']=$conta->rows[$i]['fechacreacion'];
				$datos['tipo_documento']=$conta->rows[$i]['tipodocumento'];
				$datos['documento']=$conta->rows[$i]['id'];
			
				$datos['estado']=$conta->rows[$i]['estado'];
				$datos['autorizacion']=$conta->rows[0]['numautorizacion'];
				$datos['caja_id']='null';
				$datos['cliente']=array('ruc'=>$conta->rows[$i]['ruc'],'cedula'=>$conta->rows[$i]['cedula'],'razon_social'=>$conta->rows[$i]['razonsocial'],'telefonos'=>$conta->rows[$i]['telefono'],'direccion'=>$conta->rows[$i]['direccion'],'tipo'=>$conta->rows[$i]['tipo'],'email'=>$conta->rows[$i]['email'],'es_extranjero'=>$conta->rows[$i]['esextranjero']);
				$datos['vendedor']=array('ruc'=>$conta->rows[$i]['rucvendedor'],'cedula'=>$conta->rows[$i]['cedulavendedor'],'razon_social'=>$conta->rows[$i]['razonsocialvendedor'],'telefonos'=>$conta->rows[$i]['telefonovendedor'],'direccion'=>$conta->rows[$i]['direccionvendedor'],'tipo'=>$conta->rows[$i]['tipovendedor'],'email'=>$conta->rows[$i]['emailvendedor'],'es_extranjero'=>$conta->rows[$i]['extranjerovendedor']);
				$datos['descripcion']=$conta->rows[$i]['descripcion'];
				$datos['subtotal_0']=$conta->rows[$i]['subtotal0'];
				$datos['subtotal_12']=$conta->rows[$i]['subtotaliva'];
				$datos['iva']=$conta->rows[$i]['iva'];
				$datos['servicio']=$conta->rows[$i]['servicio'];
				$datos['total']=$conta->rows[$i]['total'];
				$datos['adicional1']=$conta->rows[$i]['adicional1'];
				$datos['adicional2']=$conta->rows[$i]['adicional2'];
				
				$curso->getdetallefactura($conta->rows[$i]['descripcion']);
				//$alumnos->getdetallepago($conta->rows[$i]['descripcion']);
			
				$aux_det = 0;
				foreach ( $curso->rows as $detalle_rows )
				{   if( !empty( $detalle_rows ) )
					{   $datos['detalles'][$aux_det] = array('producto_id'=>$detalle_rows['id_contifico'],'cantidad'=>$detalle_rows['cantidad'],'precio'=>$detalle_rows['precio'],'porcentaje_iva'=>$detalle_rows['iva'],'porcentaje_descuento'=>$detalle_rows['descuento'],'base_cero'=>$detalle_rows['basecero'],'base_gravable'=>$detalle_rows['basegravable'],'base_no_gravable'=>$detalle_rows['basenogravable']);	
						$aux_det++;
					}
				}
				$data['datosdoc'][$i] = $datos;
            }
			$jsondeudasid= json_encode($datos1);
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'idpago'=> $jsondeudasid);
			retornar_formulario(VIEW_ACTUALIZARFACTURAS, $data);
            break;
		case RESULTADO:
			$data = array('correctos' => $user_data['contadorcorrectos'],'errores' => $user_data['contadorerror'],'errfactura' => $user_data['contadorerrfact']);
			retornar_formulario(VIEW_RESULTADO, $data);
		     break;	
        case RESULTADOACT:
			$data = array('correctos' => $user_data['contadorcorrectos'],'errores' => $user_data['contadorerror'],'errfactura' => $user_data['contadorerrfact']);
			retornar_formulario(VIEW_RESULTADOACT, $data);
		break;			
		case UPDDEUDA:
			$contifico =array();
			$contifico=json_decode($user_data['doccontifico_codigo'], true);
			$conta->upddeudacontifico($user_data['codigo_documento'],$user_data['doccontifico_codigo'],$user_data['estado']);
			break;	
		case UPDFACTURAS:
			$contifico =array();
			$contifico=json_decode($user_data['doccontifico_codigo'], true);
			$conta->updfacturacontifico($user_data['codigo_documento']);
		break;	
		case ADD:
			$conta->getproducto($user_data['prod_codigo']);
			$datosprod =array();
			$datosprod['nombre']=$conta->rows[0]['nombre'];
			$datosprod['codigo']=$conta->rows[0]['codigo'];
			$datosprod['codigo_barra']=$conta->rows[0]['codigo_barra'];
			$datosprod['porcentaje_iva']=$conta->rows[0]['porcentaje_iva'];
			$datosprod['categoria_id']=$conta->rows[0]['categoria_id'];
			$datosprod['minimo']=$conta->rows[0]['minimo'];
			$datosprod['pvp2']=$conta->rows[0]['pvp2'];
			$datosprod['pvp3']=$conta->rows[0]['pvp3'];
			$datosprod['pvp1']=$conta->rows[0]['pvp1'];
			$datosprod['pvp_manual']=$conta->rows[0]['pvp_manual'];
			$datosprod['descripcion']=$conta->rows[0]['descripcion'];
			$datosprod['estado']=$conta->rows[0]['estado'];
			$data['datosprod'] = json_encode($datosprod);
			retornar_result($data);
            break;
		 case MATCHCATEGORIAS:
		 $data['codigo']=$user_data['categoriacodigo'];
			retornar_formulario(VIEW_SETCATEGORIAS, $data);
            break;
        case EDIT:
            $banco->edit($user_data);
            break;
		case SAVECONTIFICO:
		$conta->savecontifico($user_data['codigo_categoria'],$user_data['catecontifico_codigo']);
		
		break;
			case SAVEPRODUCTOS:
		$conta->updproducto($user_data['codigo_categoria'],$user_data['catecontifico_codigo']);
		
		break;
		case GET_ALL_DATA:
			$conta->get_allcontifico('');
			global $diccionario;
			$opcionescat["match"] = "<span onclick='categorias(".'"{codigo}"'.",".'"modal_matchcategorias_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_matchcategorias'>&nbsp;</span>";
			$data['{tabla_categoria}']= array("elemento"=>"tabla",
											  "clase"=>"table table-bordered table-hover",
											  "id"=>"tablacategoria",
											  "datos"=>$conta->rows,
											  "encabezado" => array("Codigo",
																	"Nombre",
                                                                    "Descripcion",
																	"Categoria Padre",
																	"Categoria Contifico",
																	"Opciones"),
																	"options"=>array($opcionescat),
                                                                    "campo"=>"codigo");
            retornar_result($data);
            break;
		case GET_ALL_DATA_PRODUCTO:
			$prod->get_allproductos('');
            global $diccionario;
            $opcionesprod["match"] = "<span onclick='productos(".'"{codigo}"'.",".'"modal_matchproductos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_matchproductos'>&nbsp;</span>";
            $opcionesprod["agregar"] = "<span onclick='addproductos(".'"{codigo}"'.",".'"modal_matchproductos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_agregar glyphicon glyphicon-plus cursorlink' aria-hidden='true' >&nbsp;</span>";
            $data['{tabla_productos}']= array("elemento"=>"tabla",
											  "clase"=>"table table-bordered table-hover",
											  "id"=>"tablaproductos",
											  "datos"=>$prod->rows,
											  "encabezado" => array("Codigo",
																	"Nombre",
                                              					    "Descripcion",
																	"Categoria Padre",
																	"Categoria Contifico",
																	"Opciones"),
																	"options"=>array($opcionesprod),
																	"campo"=>"codigo");
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			$prod->get_allproductos("");
			$mydate=getdate(date("U"));
            $conta->get_all($mydate[year]);
			$categoria->get_allcontifico("");
			global $diccionario;
			$opcionescat["match"] = "<span  onclick='categorias(".'"{codigo}"'.",".'"modal_matchcategorias_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_matchcategorias' 		id='".'"#{codigo}"'."_match_cat' onmouseover='$(this).tooltip(".'"show"'.")'  title='Igualar categor&iacute;a' data-placement='left'>&nbsp;</span>";
			$opcionesprod["match"] = "<span  onclick='productos(".'"{codigo}"'.",".'"modal_matchproductos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_matchproductos' 			id='".'"#{codigo}"'."_match_prod' onmouseover='$(this).tooltip(".'"show"'.")' title='Igualar producto' data-placement='left'>&nbsp;</span>";
			$opcionesprod["agregar"] = "<span  onclick='addproductos(".'"{codigo}"'.",".'"modal_matchproductos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_agregar glyphicon glyphicon-plus cursorlink' aria-hidden='true' onmouseover='$(this).tooltip(".'"show"'.")' 	id='".'"#{codigo}"'."_add_prod' title='Agregar producto'></span>";
			
			$data['{tabla_categoria}']= array("elemento"=>"tabla",
								  "clase"=>"table table-bordered table-hover",
								  "id"=>"tablacategoria",
								  "datos"=>$categoria->rows,
								  "encabezado" => array("Codigo",
														"Nombre",
														"Descripcion",
														"Categoria Padre",
														"Categoria Contifico",
														"Opciones"),
														"options"=>array($opcionescat),
														"campo"=>"codigo");
			$data['{tabla_productos}']= array("elemento"=>"tabla",
								  "clase"=>"table table-bordered table-hover",
								  "id"=>"tablaproductos",
								  "datos"=>$prod->rows,
								  "encabezado" => array("Codigo",
														"Nombre",
														"Descripcion",
														"Categoria Padre",
														"Producto Contifico",
														"Opciones"),
														"options"=>array($opcionesprod),
														"campo"=>"codigo");
			$data['apikey'] = $_SESSION['apikey'];
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DEUDA:
			$conta->get_all($user_data['anio']);
			global $diccionario;
			$opcionesdeudas["Migrar"] = "<span onclick='js_contabilidad_migrar(".'"{codigo}"'.",".'"modal_pagos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title='Migrar pagos'>&nbsp;</span>";

				$data['{tabla_pagos}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>"tablapagos",
                                        "datos"=>$conta->rows,
                                        "encabezado" => array("Mes",
                                                          "Mes de Vencimiento",
                                                          "Pagos por Migrar",
                                                          "Valor Pagos",
                                                          "Opciones"),
                                        "options"=>array($opcionesdeudas),
                                        "campo"=>"mes");
            retornar_result($data);
            break;
		case GET_ALL_PAID_DNAS:
			$conta->get_all_paid_dnas($user_data['anio']);
			global $diccionario;
			$opcionesdeudas["Migrar"] = "<span onclick='js_contabilidad_actualizar_DNAs(".'"{codigo}"'.",".'"modal_actualizar_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_actualizar' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title=\"Actualizar DNA's\">&nbsp;</span>";

				$data['{tabla_paidDNAs}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>"tabla_paidDNAs_main",
                                        "datos"=>$conta->rows,
                                        "encabezado" => array("Mes",
                                                          "Mes de Vencimiento",
                                                          "DNA's por actualizar",
                                                          "Valor Factura",
                                                          "Opciones"),
                                        "options"=>array($opcionesdeudas),
                                        "campo"=>"mes");
            retornar_result($data);
			break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
			break;
		case COMBOCATEGORIAS:
	       $categorias = json_decode($user_data['categorias'], true);
				 $data['cate_codigo']=$user_data['codigocategoria'];
			for($i=0;$i<=count($categorias);$i++)
			{
				
					
					$combocat[$i][0]=$categorias[$i]['id'];
					$combocat[$i][1]=$categorias[$i]['nombre'];
				
			}
		
			$data['{combo_categorias}'] = array("elemento"  => "combo", 
												"datos"     => $combocat, 
                                                "options"   => array("name"=>"categorias",
																	 "id"=>"categorias",
																	 "required"=>"required", 
																	 "class"=>"form-control", 
																	 "class"=>"form-control",
                                                "onChange"=>""),
												"selected"  => 0);
            retornar_formulario(VIEW_SETCATEGORIAS, $data);
			break;
		case COMBOPRODUCTOS:
	       $productos = json_decode($user_data['productos'], true);
			$data['prod_codigo']=$user_data['codigoproducto'];
			for($i=0;$i<=count($productos);$i++)
			{   $comboprod[$i][0]=$productos[$i]['id'];
				$comboprod[$i][1]=$productos[$i]['nombre'];
			}
			$data['{combo_productos}'] =array("elemento"  => "combo", 
											  "datos"     => $comboprod, 
											  "options"   => array("name"=>"productos",
																   "id"=>"productos",
																   "required"=>"required",
																   "class"=>"form-control",
											  "onChange"=>""),
											  "selected"  => 0);
            retornar_formulario(VIEW_SETPRODUCTOS, $data);
			break;
		case VIEW_SETCATEGORIAS:
            retornar_formulario(VIEW_SETCATEGORIAS, $data);
        	break;
    }
}
function migrar_caja($json)
{   header('Content-Type: text/html; charset=utf-8');
    require_once('/../../includes/nusoap/lib/nusoap.php');
    $repr_codi = 1105;
    $cliente = new nusoap_client('https://contifico.com/sistema/api/caja/');  
	$error = $cliente->getError();
	if ($error)
	{   echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}
	$result = $cliente->call('Agregar',$json);
	if ($cliente->fault)
	{   echo "<h2>Fault</h2><pre>";
		print_r($result);
		echo "</pre>";
	}
	else
	{   $error = $cliente->getError();
		if ($error) 
		{   echo "<h2>Error</h2><pre>" . $error . "</pre>";
		}
		else
		{   echo "<h2>Resultado</h2><pre>";
			print_r($result);
			echo "</pre>";
		}
	}
	return $result;
}
handler();

?>