<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../contabilidad/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	$anioPeriodo = get_mainObject('AnioPeriodo');
	$fecha=get_mainObject('Contabilidad');
	$permiso = get_mainObject('General');
	$curso = get_mainObject('AnioPeriodo');
	$periodo = get_mainObject('General');
	$alumnos = get_mainObject('AnioPeriodo');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
    $conta = get_mainObject('Contabilidad');
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "anioPeriodo_table";}else{$tabla =$_POST['tabla'];}

	switch ($event)
	{	case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}            
			global $diccionario;
			$anioPeriodo->anio = $_SESSION['peri_codi'];
			$anioPeriodo->get_detalle();
			$fecha->fechas();
			$mydate=getdate(date("U"));
			$periodo->get_all_periodos();
			$curso->get_deudas_contifico($mydate[year]);
			$data['{periodo_activo}']=array("elemento"=>"text_box",
											"valor" => $_SESSION['peri_deta'],
											"options"=>array("disabled"=>"false", "id"=>"periodo_activo","class"=>"form-control",
											"name"=>"periodo_activo")
										   );
		 
			 $data['{combo_anual_deudas}'] = array( "elemento"  => "combo", 
													"datos"     => $fecha->rows,
													"options"   => array( "name"	=> "cmb_periodo_anual_deudas",
																		  "id"		=> "cmb_periodo_anual_deudas",
																		  "class"	=> "form-control",
																		  "required"=> "required",
																		  "onchange"=> "js_aniosPeriodo_buscadeudas('resultadomigracion_deudas','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
													"selected"  => 0);
			$data['{combo_anual_pagos}'] = array("elemento" => "combo",
												 "datos"    =>$fecha->rows,
												 "options"  =>array("name"		=> "cmb_periodo_anual_pagos",
																	"id"		=> "cmb_periodo_anual_pagos",
																	"class"		=> "form-control",
																	"required"	=> "required",
																	"onchange" 	=> "js_contabilidad_buscapagos('resultadomigracion_pagos','".$diccionario['rutas_head']['ruta_html_finan']."/contabilidad/controller.php')"),
												 "selected"  => 0);
			$data['{combo_anual_pagos_update}'] = array("elemento"  =>"combo",
														"datos"     =>$fecha->rows,
														"options"   =>array("name"		=> "cmb_periodo_anual_update",
																			"id"		=> "cmb_periodo_anual_update",
																			"class"		=> "form-control",
																			"required"	=> "required",
																			"onchange"	=> "js_contabilidad_buscaDNAsPagados('resultadomigracion_paidDNAs','".$diccionario['rutas_head']['ruta_html_finan']."/contabilidad/controller.php')"),
														"selected"  => 0);
			$mydate=getdate(date("U"));
			$conta->get_all($mydate[year]);
			$opcionesdeudas["Migrar"] = "<span  onclick='js_contabilidad_migrar(".'"{codigo}"'.",".'"modal_pagos_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}' 	id='".'"#{codigo}"'."_migrar_deuda'  onmouseover='$(this).tooltip(".'"show"'.")' title='Migrar pagos'>&nbsp;</span>";
			$data['{tabla_pagos}'] = array( "elemento"	=>"tabla",
											"clase"		=>"table table-bordered table-hover",
											"id"		=>"tablapagos",
											"datos"		=>$conta->rows,
											"encabezado"=>array("Mes",
																"Mes de Vencimiento",
																"Pagos por Migrar",
																"Valor Pagos",
																"Opciones"),
											"options"	=>array($opcionesdeudas),
											"campo"		=>"mes");
			$data['periodo_codigo']=$_SESSION['peri_codi'];
			
			$conta->get_all_paid_dnas( $mydate[year] );
			$opcionespaiddnas["Migrar"] = "<span onclick='js_contabilidad_actualizar_DNAs(".'"{codigo}"'.",".'"modal_actualizar_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/contabilidad/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_actualizar' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title=\"Actualizar DNA's\">&nbsp;</span>";
			$data['{tabla_paidDNAs}']=array("elemento"	=>"tabla",
											"clase"		=>"table table-bordered table-hover",
											"id"		=>"tabla_paidDNAs_main",
											"datos"		=>$conta->rows,
											"encabezado"=> array(
															"Mes",
															"Mes de Vencimiento",
															"DNAs por Actualizar",
															"Valor Factura",
															"Opciones"),
											"options"=>array($opcionespaiddnas),
											"campo"=>"mes");
											
			$data['periodo_codigo']=$_SESSION['peri_codi'];
			
			$permiso->permiso_activo($_SESSION['usua_codigo'], 166);
			if ($permiso->rows[0]['veri']==1)
			{   $opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
			}
			else
			{   $opciones["Editar"] = "";
			}

			$permiso->permiso_activo($_SESSION['usua_codigo'], 167);
			if ($permiso->rows[0]['veri']==1)
			{   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
			}
			else
			{   $opciones["Eliminar"] = "";
			}

			$permiso->permiso_activo($_SESSION['usua_codigo'], 120);
			if ($permiso->rows[0]['veri']==1)
			{   $data['disabled_agregar_item']="";
			} 

			else
			{   $data['disabled_agregar_item']="disabled='disabled'";
			}

			$permiso->permiso_activo($_SESSION['usua_codigo'], 168);
			if ($permiso->rows[0]['veri']==1)
			{   $data['disabled_generar_deuda_lote']="";
			} 

			else
			{   $data['disabled_generar_deuda_lote']="disabled='disabled'";
			}
			$opcionesdeudas["Migrar"] = "<span onclick='js_aniosPeriodo_carga_deudas(".'"{codigo}"'.",".'"modal_deudas_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Migrar deuda'>&nbsp;</span>";
			$data['{tabla}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>$tabla,
                                    "datos"=> $anioPeriodo->rows,
                                    "encabezado" => array("Codigo Producto",
                                                          "Producto",
                                                          "Fecha Inicio cobro",
                                                          "Fecha Fin cobro",
                                                          "Días\nProntopago",
                                                          "Opciones"),
                                    "options"=>array($opciones),
                                    "campo"=>"codigoProducto");
			$data['{tabla_deuda}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>"tabladeuda",
                                    "datos"=> $curso->rows,
                                    "encabezado" => array("Mes",
                                                          "Mes de Vencimiento",
                                                          "Deudas por Migrar",
                                                          "Valor Deudas",
                                                          "Opciones"),
                                    "options"=>array($opcionesdeudas),
                                    "campo"=>"mes");
			$data['mensaje'] = "";
			$data['apikey'] = $_SESSION['apikey'];
			retornar_vista(VIEW_GET_ALL, $data);
			break;
		case GET_ALL_DATA:
            $anioPeriodo->anio = $_SESSION['peri_codi'];
            $anioPeriodo->get_detalle();

            global $diccionario;
            $permiso->permiso_activo($_SESSION['usua_codigo'], 166);
            if ($permiso->rows[0]['veri']==1)
            {   $opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
            }
            else
            {   $opciones["Editar"] = "";
            }
            $permiso->permiso_activo($_SESSION['usua_codigo'], 167);
            if ($permiso->rows[0]['veri']==1)
            {   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
            }
            else
            {   $opciones["Eliminar"] = "";
            }
            $permiso->permiso_activo($_SESSION['usua_codigo'], 120);
            if ($permiso->rows[0]['veri']==1)
            {   $data['disabled_agregar_item']="";
            } 
            else
            {   $data['disabled_agregar_item']="disabled='disabled'";
            }
            $permiso->permiso_activo($_SESSION['usua_codigo'], 168);
            if ($permiso->rows[0]['veri']==1)
            {   $data['disabled_generar_deuda_lote']="";
            } 
            else
            {   $data['disabled_generar_deuda_lote']="disabled='disabled'";
            }
            $data['{tabla}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>$tabla,
                                    "datos"=>$anioPeriodo->rows,
                                    "encabezado" => array("Codigo Producto",
                                                          "Producto",
                                                          "Fecha Inicio cobro",
                                                          "Fecha Fin cobro",
                                                          "Días\nProntopago",
                                                          "Opciones"),
                                    "options"=>array($opciones),
                                    "campo"=>"codigoProducto");

            retornar_result($data);
            break;
		case GET_ALL_DEUDA:
			$curso->get_deudas_contifico($user_data['anio']);
			global $diccionario;
			$opcionesdeudas["Migrar"] = "<span onclick='js_aniosPeriodo_carga_deudas(".'"{codigo}"'.",".'"modal_deudas_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Migrar deuda'>&nbsp;</span>";

			$data['{tabla_deuda}']= array("elemento"=>"tabla",
										"clase"=>"table table-bordered table-hover",
										"id"=>"tabladeuda",
										"datos"=> $curso->rows,
										"encabezado" => array("Mes",
															  "Mes de Vencimiento",
															  "Deudas",
															  "Valor Deudas",
															  "Opciones"),
										"options"=>array($opcionesdeudas),
										"campo"=>"mes");
            retornar_result($data);
            break;	
		case GET_CURSO:
			
            $curso->get_all_cursos($user_data['cod_peri']);
		
            global $diccionario;
            $data['{combo_curso}'] = array("elemento"  => "combo", 
                                                             "datos"     => $curso->rows,
                                                             "options"   => array("name"=>"curso",
                                                                                  "id"=>"curso",
                                                                                  "class"=>"form-control",
                                                                                  "required"=>"required",
															"onChange"=>"cargaAlumnos('resultadoAlumnos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
																				  
																				  
																				
                                                             "selected"  => 0);
            
			retornar_result($data);
			
            break;
		case DEUDA:
		
			$curso->get_deudas_contificoindividual($user_data['anio'],$user_data['mes']);

			global $diccionario;
			$opciones["Migrar"] = "<span onclick='js_aniosPeriodo_migrarfacturasindividuales(".'"{codigo}"'.",".'"modal_deudasconfirmacion_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudasconfirmacion' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title='Migrar'>&nbsp;</span>";

			
			$data = array('mes' => $user_data['mes']
							  );
			
			$data['{tabladeudasmigrar}'] =array("elemento"=>"tabla",
												"clase"=>"table table-bordered table-hover",
												"id"=>"tabladeudamigrar",
												"datos"=> $curso->rows,
												"encabezado" => array("Codigo Deuda",
																	  "Cliente",
																	  "Producto",
																	  "Valor Deuda",
																	   "Estado",
																	  "Opciones"),
												"options"=>array($opciones),
												"campo"=>"deudacodigo");
			retornar_formulario(VIEW_GET_DEUDAS, $data);
			break;
		case MIGRARFACTURAS:
			//migracion caja
			// migracion documentos
			$anioPeriodo->getfacturacontifico($user_data['mes'],$user_data['anio']);
			$datos1 =array();
			$datos2 =array();
			for($i=0;$i<=count($anioPeriodo->rows)-2;$i++){	
				$datos['pos']=$anioPeriodo->rows[$i]['apitoken'];
				$datos['fecha_emision']=$anioPeriodo->rows[$i]['fechacreacion'];
				$datos['tipo_documento']=$anioPeriodo->rows[$i]['tipodocumento'];
				$datos['documento']=$anioPeriodo->rows[$i]['id'];
			
				$datos['estado']=$anioPeriodo->rows[$i]['estado'];
				$datos['autorizacion']='';
				$datos['caja_id']='null';
				$datos['cliente']=array('ruc'=>$anioPeriodo->rows[$i]['ruc'],'cedula'=>$anioPeriodo->rows[$i]['cedula'],'razon_social'=>$anioPeriodo->rows[$i]['razonsocial'],'telefonos'=>$anioPeriodo->rows[$i]['telefono'],'direccion'=>$anioPeriodo->rows[$i]['direccion'],'tipo'=>$anioPeriodo->rows[$i]['tipo'],'email'=>$anioPeriodo->rows[$i]['email'],'es_extranjero'=>$anioPeriodo->rows[$i]['esextranjero']);
				$datos['vendedor']=array('ruc'=>$anioPeriodo->rows[$i]['rucvendedor'],'cedula'=>$anioPeriodo->rows[$i]['cedulavendedor'],'razon_social'=>$anioPeriodo->rows[$i]['razonsocialvendedor'],'telefonos'=>$anioPeriodo->rows[$i]['telefonovendedor'],'direccion'=>$anioPeriodo->rows[$i]['direccionvendedor'],'tipo'=>$anioPeriodo->rows[$i]['tipovendedor'],'email'=>$anioPeriodo->rows[$i]['emailvendedor'],'es_extranjero'=>$anioPeriodo->rows[$i]['extranjerovendedor']);
				$datos['descripcion']=$anioPeriodo->rows[$i]['descripcion'];
				$datos['subtotal_0']=$anioPeriodo->rows[$i]['subtotal0'];
				$datos['subtotal_12']=$anioPeriodo->rows[$i]['subtotaliva'];
				$datos['iva']=$anioPeriodo->rows[$i]['iva'];
				$datos['servicio']=$anioPeriodo->rows[$i]['servicio'];
				$datos['total']=$anioPeriodo->rows[$i]['total'];
				$datos['adicional1']=$anioPeriodo->rows[$i]['adicional1'];
				$datos['adicional2']=$anioPeriodo->rows[$i]['adicional2'];
				$curso->getdetallefactura($anioPeriodo->rows[$i]['id']);
				$alumnos->getdetallepago($anioPeriodo->rows[$i]['id']);
				
				for($a=0;$a<=count($curso->rows)-2;$a++){
					$datos['detalles']=array(array('producto_id'=>$curso->rows[$a]['id_contifico'],'cantidad'=>$curso->rows[$a]['cantidad'],'precio'=>$curso->rows[$a]['precio'],'porcentaje_iva'=>$curso->rows[$a]['iva'],'porcentaje_descuento'=>$curso->rows[$a]['descuento'],'base_cero'=>$curso->rows[$a]['basecero'],'base_gravable'=>$curso->rows[$a]['basegravable'],'base_no_gravable'=>$curso->rows[$a]['basenogravable']));
			
				}
				$data['datosdoc'][$i] = $datos;
            }
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas);
			retornar_formulario(VIEW_MIGRARDEUDAS, $data);
            break;
		case MIGRARFACTURASINDIVIDUALES:
			// migracion caja 
			// migracion documentos
			$anioPeriodo->get_deudas_individualmigracion($user_data['codigodeuda']);
			$datos1 =array();
			$datos2 =array();
			$datos['pos']=$anioPeriodo->rows[0]['apitoken'];
			$datos['fecha_emision']=$anioPeriodo->rows[0]['fechacreacion'];
			$datos['tipo_documento']=$anioPeriodo->rows[0]['tipodocumento'];
			$datos['documento']=$anioPeriodo->rows[0]['id'];
		
			$datos['estado']=$anioPeriodo->rows[0]['estado'];
			$datos['autorizacion']='';
			$datos['caja_id']='null';
			$datos['cliente']=array('ruc'=>$anioPeriodo->rows[0]['ruc'],'cedula'=>$anioPeriodo->rows[0]['cedula'],'razon_social'=>$anioPeriodo->rows[0]['razonsocial'],'telefonos'=>$anioPeriodo->rows[0]['telefono'],'direccion'=>$anioPeriodo->rows[0]['direccion'],'tipo'=>$anioPeriodo->rows[0]['tipo'],'email'=>$anioPeriodo->rows[0]['email'],'es_extranjero'=>$anioPeriodo->rows[0]['esextranjero']);
			$datos['vendedor']=array('ruc'=>$anioPeriodo->rows[0]['rucvendedor'],'cedula'=>$anioPeriodo->rows[0]['cedulavendedor'],'razon_social'=>$anioPeriodo->rows[0]['razonsocialvendedor'],'telefonos'=>$anioPeriodo->rows[0]['telefonovendedor'],'direccion'=>$anioPeriodo->rows[0]['direccionvendedor'],'tipo'=>$anioPeriodo->rows[0]['tipovendedor'],'email'=>$anioPeriodo->rows[0]['emailvendedor'],'es_extranjero'=>$anioPeriodo->rows[0]['extranjerovendedor']);
			$datos['descripcion']=$anioPeriodo->rows[0]['descripcion'];
			$datos['subtotal_0']=$anioPeriodo->rows[0]['subtotal0'];
			$datos['subtotal_12']=$anioPeriodo->rows[0]['subtotaliva'];
			$datos['iva']=$anioPeriodo->rows[0]['iva'];
			$datos['servicio']=$anioPeriodo->rows[0]['servicio'];
			$datos['total']=$anioPeriodo->rows[0]['total'];
			$datos['adicional1']=$anioPeriodo->rows[0]['adicional1'];
			$datos['adicional2']=$anioPeriodo->rows[0]['adicional2'];
			$curso->getdetallefactura($anioPeriodo->rows[0]['id']);
			$alumnos->getdetallepago($anioPeriodo->rows[0]['id']);
			
			for($a=0;$a<=count($curso->rows)-2;$a++){
				$datos['detalles']=array(array('producto_id'=>$curso->rows[$a]['id_contifico'],'cantidad'=>$curso->rows[$a]['cantidad'],'precio'=>$curso->rows[$a]['precio'],'porcentaje_iva'=>$curso->rows[$a]['iva'],'porcentaje_descuento'=>$curso->rows[$a]['descuento'],'base_cero'=>$curso->rows[$a]['basecero'],'base_gravable'=>$curso->rows[$a]['basegravable'],'base_no_gravable'=>$curso->rows[$a]['basenogravable']));
			}
			$data['datosdoc'] = $datos;
			$jsondeudas= json_encode($data['datosdoc']);
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'codigodeuda'=> $datos['documento']);
			retornar_formulario(VIEW_MIGRACIONINDIVIDUAL, $data);
            break;
		case UPDDEUDA:
			$contifico =array();
			$contifico=json_decode($user_data['doccontifico_codigo'], true);
            $anioPeriodo->upddeudacontifico($user_data['codigo_documento'],$contifico['id'],$user_data['estado']);
            break;	
		case RESULTADO:
			$data = array('correctos' => $user_data['contadorcorrectos'],'errores' => $user_data['contadorerror'],'errfactura' => $user_data['contadorerrfact']);
			retornar_formulario(VIEW_RESULTADO, $data);
            break;	
		case RESULTADOINDIVIDUAL:
			$data = array('correctos' => $user_data['contadorcorrectos'],'errores' => $user_data['contadorerror'],'errfactura' => $user_data['contadorerrfact']);
			retornar_formulario(VIEW_RESULTADO, $data);
            break;	
		case GET_ALUMNOS:
			$alumnos->get_all_alumnos($user_data['cod_curso']);
			$data['{combo_alumnos}'] = array("elemento"  => "combo", 
                                                            "datos"     => $alumnos->rows,
                                                            "options"   => array("name"=>"alumnos",
                                                                                 "id"=>"alumnos",
                                                                                 "class"=>"form-control",
                                                                                 "required"=>"required"),
															"selected"  => 0);
			retornar_result($data);
            break;
        case VIEW_SET:
            $anioPeriodo->getCategorias_selectFormat();
            global $diccionario;
            $data = array('{combo_categoria}' =>array("elemento"  => "combo", 
                                                      "datos"     => $anioPeriodo->rows,
                                                      "options"   => array("name"=>"codigoCategoria_add",
                                                                            "id"=>"codigoCategoria_add",
                                                                            "class"=>"form-control",
                                                                            "required"=>"required",
                                                                            "onChange"=>"cargaProductos('resultadoProducto','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
                                                      "selected"  => 0),
                          '{combo_producto}' => array("elemento"  => "combo", 
                                                      "datos"     => array(0 => array(0 => -1, 
                                                                                      1 => 'SELECCIONE...',
                                                                                      3 => ''), 
                                                                           1=> array()),
                                                      "options"   => array("name"=>"codigoProducto_add",
                                                                           "id"=>"codigoProducto_add",
                                                                           "class"=>"form-control",
                                                                           "class"=>"form-control",
                                                                           "required"=>"required"),
                                                      "selected"  => 0),
                          'aperiodo_anio' => $_SESSION['peri_deta'],
                          'aperiodo_codigo' => $_SESSION['peri_codi'],
                          '{periodo_activo_add}'
                          );
            retornar_formulario(VIEW_SET, $data);
            break;
        case GET_PRODUCTO:
            $anioPeriodo->getProductos_selectFormat($user_data['categoria']);
            global $diccionario;
            $data['{combo_producto}'] = array("elemento"  => "combo", 
                                                             "datos"     => $anioPeriodo->rows,
                                                             "options"   => array("name"=>"codigoProducto_add",
                                                                                  "id"=>"codigoProducto_add",
                                                                                  "class"=>"form-control",
                                                                                  "required"=>"required"),
                                                             "selected"  => 0);
            retornar_result($data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $anioPeriodo->set($user_data);
            break; 
		case GENERA_DEUDA:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			$user_data['peri_codi'] = $_SESSION['peri_codi'];
            $anioPeriodo->set_deudas_lote($user_data);
			retornar_mensaje($anioPeriodo->mensaje);
            break; 
		case GENERA_DEUDA_IND:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			$user_data['peri_codi'] = $_SESSION['peri_codi'];	
			$datosProductos = array();
            $datosProductos = json_decode($user_data['producto'], true);
			$xml_text='<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml_text.='<productos>';
			
			foreach($datosProductos as $valor)
			{	$xml_text.='<producto codigo="'.$valor.'"/>';
			}
			$xml_text.='</productos>';
			$user_data['xml']=$xml_text;

			switch($user_data['casos'])
			{	case alumno:	
					$anioPeriodo->set_deudas_lote_Alumnoind($user_data);
					break;
				case curso:	
					$anioPeriodo->set_deudas_cursolote_ind($user_data);
					break;
				case todos:
					$anioPeriodo->set_deudas_lote_ind($user_data);
				default:
					break;
			}
			retornar_mensaje($anioPeriodo->mensaje);
            break; 
		case VIEW_GENERA_DEUDAS:
			$anioPeriodo->get_deudas_anuales($_SESSION['peri_codi']);
			$periodo->get_all_periodos();	
            global $diccionario;
			$data = array(
            '{deudas_checklist}'=>array("elemento"=>'checkListBox',
										"datos"=>$anioPeriodo->rows,
										"campoVisualizacion" => "nombre",
										"campoValor" => "codigo",
										"valoresSeleccionados"=>array(),

										"funcion"=>""),
		    '{combo_periodo}' => array(	"elemento"  => "combo", 

										"datos"     => $periodo->rows, 
										"options"   => array("name"=>"periodos","id"=>"periodos",
                                                                            "class"=>"form-control","required"=>"required",
										"onChange"=>"cargaCursos('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => 0),
			'{combo_curso}' => array(	"elemento"  => "combo",
										"datos"     => array(0 => array(  0 => -1, 
																		  1 => 'TODOS...',
																		  3 => ''), 

															 1=> array()),
										"options"   => array("name"=>"curso","id"=>"curso",
                                                                            "class"=>"form-control","required"=>"required",
								 			 
										"onChange"=>"cargaAlumnos('resultadoAlumnos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => 0),
			'{combo_alumnos}' => array("elemento"  => "combo", 
									   "datos"     => array(0 => array( 0 => -1, 
																		1 => 'TODOS ..',
																		3 => ''),
															1=> array()),
									   "options"   => array("name"=>"alumnos","id"=>"alumnos",
                                                                            "class"=>"form-control","required"=>"required"),
									   "selected"  => 0)
			);
            retornar_formulario(VIEW_GENERA_DEUDAS, $data);
			break;
        case GET:
            $anioPeriodo->get($user_data['producto'], $user_data['anio']);
            $data = array('aperiodo_codigoProducto' => $user_data['producto'],
                          'aperiodo_nombreProducto'=> $anioPeriodo->nombreProducto,
                          'aperiodo_fechaInicio' => $anioPeriodo->fechaInicio,
                          'aperiodo_fechaFin'=> $anioPeriodo->fechaFin,
                          'aperiodo_codigoPeriodo'=>$anioPeriodo->anio,
                          'aperiodo_diasProntoPago'=>$anioPeriodo->diasProntoPago);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $anioPeriodo->delete($user_data['producto'], $user_data['anio']);
            break;
        case EDIT:
            $anioPeriodo->edit($user_data);
            break;
        case VIEW_SET_DEBTS_TO_ALL:
            $totalAlumnosGestionados = 0;
            $totalDeudasGeneradas = 0;
            $totalDeudasOmitidas = 0;
            $anioPeriodo->setDeudasLote($_SESSION["peri_codi"], $_SESSION["usua_codigo"]);
            if(count($anioPeriodo->rows) > 0)
			{	$totalAlumnosGestionados = $anioPeriodo->totalAlumnosGestionados;
				$totalDeudasGeneradas = $anioPeriodo->totalDeudasGeneradas;
				$totalDeudasOmitidas = $anioPeriodo->totalDeudasOmitidas;
            }
            break;
        default :
        	break;
    }
}
handler();
?>