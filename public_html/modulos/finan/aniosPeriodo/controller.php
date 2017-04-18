<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../contabilidad/model.php');
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
			$curso->get_deudas_contifico($mydate[year]);
			$data['periodo_activo'] = $_SESSION['peri_deta'];
			$data['{combo_anual}'] = array("elemento"=> "combo", 
														"datos"     => $fecha->rows,
														"options"   => array( "name"=>"fecha",
																			  "id"=>"fecha",
																			  "class"=>"form-control",
																			  "required"=>"required",
																			  "onchange" => "js_aniosPeriodo_buscadeudas('resultadomigracion_deudas','"
																			  .$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
														"selected"  => 0);
			$data['periodo_codigo']=$_SESSION['peri_codi'];

			$permiso->permiso_activo($_SESSION['usua_codigo'], 166);
			if ($permiso->rows[0]['veri']==1)
			{   $opciones["Editar"] = "<span onclick='js_aniosPeriodo_carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit_item' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
			}
			else
			{   $opciones["Editar"] = "";
			}

			$permiso->permiso_activo($_SESSION['usua_codigo'], 167);
			if ($permiso->rows[0]['veri']==1)
			{   $opciones["Eliminar"] = "<span onclick='js_aniosPeriodo_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
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
			$opcionesdeudas["Migrar"] = "<span onclick='js_aniosPeriodo_carga_deudas(".'"{codigo}"'.",".'"modal_deudas_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_migrar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
			$data['{tabla}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>$tabla,
                                    "datos"=> $anioPeriodo->rows,
                                    "encabezado" => array("Ref.",
                                                          "Producto",
                                                          "Inicio cobro",
                                                          "Fin cobro",
                                                          "Prontopago",
                                                          "Opciones"),
                                    "options"=>array($opciones),
                                    "campo"=>"codigoProducto");
			$data['{tabla_deuda}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>"tabladeuda",
                                    "datos"=> $curso->rows,
                                    "encabezado" => array("Mes",
                                                          "Mes Vencimiento",
                                                          "Deudas por Migrar",
                                                          "Valor Deudas",
                                                          "Opciones"),
                                    "options"=>array($opcionesdeudas),
                                    "campo"=>"mes");
			$data['mensaje'] = "";

			retornar_vista(VIEW_GET_ALL, $data);
			break;
		case GET_ALL_DATA:
            $anioPeriodo->anio = $_SESSION['peri_codi'];
            $anioPeriodo->get_detalle();

            global $diccionario;
            $permiso->permiso_activo($_SESSION['usua_codigo'], 166);
            if ($permiso->rows[0]['veri']==1)
            {   $opciones["Editar"] = "<span onclick='js_aniosPeriodo_carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit_item' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
            }
            else
            {   $opciones["Editar"] = "";
            }
            $permiso->permiso_activo($_SESSION['usua_codigo'], 167);
            if ($permiso->rows[0]['veri']==1)
            {   $opciones["Eliminar"] = "<span onclick='js_aniosPeriodo_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
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
                                    "encabezado" => array("Ref.",
                                                          "Producto",
                                                          "Inicio cobro",
                                                          "Fin cobro",
                                                          "Prontopago",
                                                          "Opciones"),
                                    "options"=>array($opciones),
                                    "campo"=>"codigoProducto");

            retornar_result($data);
            break;
		case GET_ALL_DEUDA:
			$curso->get_deudas_contifico($user_data['anio']);
			global $diccionario;
			$opcionesdeudas["Migrar"] = "<span onclick='js_aniosPeriodo_carga_deudas(".'"{codigo}"'.",".'"modal_deudas_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='{codigo}_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Migrar'>&nbsp;</span>";

			$data['{tabla_deuda}']= array("elemento"=>"tabla",
										"clase"=>"table table-bordered table-hover",
										"id"=>"tabladeuda",
										"datos"=> $curso->rows,
										"encabezado" => array("Mes",
															  "Mes Vencimiento",
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
															"onChange"=>"js_aniosPeriodo_cargaAlumnos('resultadoAlumnos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
                                                             "selected"  => 0);
			retornar_result($data);
            break;
		case DEUDA:
			$curso->get_deudas_contificoindividual($user_data['anio'],$user_data['mes']);
			global $diccionario;
			$opciones["Migrar"] = "<span onclick='js_aniosPeriodo_migrarfacturasindividuales(".'"{codigo}"'.",".'"modal_deudasconfirmacion_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/aniosPeriodo/controller.php"'.")' class='btn_opc_lista_migrar glyphicon glyphicon-send cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudasconfirmacion' id='{codigo}' onmouseover='$(".'"#{codigo}"'.").tooltip(".'"show"'.")' title='Migrar'>&nbsp;</span>";
			
			$data = array('mes' => $user_data['mes']);
			
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
			for($i=0;$i<=count($anioPeriodo->rows)-2;$i++)
			{   $datos['pos']=$anioPeriodo->rows[$i]['apitoken'];
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
				//$alumnos->getdetallepago($anioPeriodo->rows[$i]['id']);
				$aux_det = 0;
				foreach ( $curso->rows as $detalle_rows )
				{   if( !empty( $detalle_rows ) )
					{   $datos['detalles'][$aux_det] = array('producto_id'=>$detalle_rows['id_contifico'],'cantidad'=>$detalle_rows['cantidad'],'precio'=>$detalle_rows['precio'],'porcentaje_iva'=>$detalle_rows['iva'],'porcentaje_descuento'=>$detalle_rows['descuento'],'base_cero'=>$detalle_rows['basecero'],'base_gravable'=>$detalle_rows['basegravable'],'base_no_gravable'=>$detalle_rows['basenogravable']);	
						$aux_det++;
					}
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
			//$alumnos->getdetallepago($anioPeriodo->rows[0]['id']);
			$aux_det = 0;
			foreach ( $curso->rows as $detalle_rows )
			{   if( !empty( $detalle_rows ) )
				{   $datos['detalles'][$aux_det] = array('producto_id'=>$detalle_rows['id_contifico'],'cantidad'=>$detalle_rows['cantidad'],'precio'=>$detalle_rows['precio'],'porcentaje_iva'=>$detalle_rows['iva'],'porcentaje_descuento'=>$detalle_rows['descuento'],'base_cero'=>$detalle_rows['basecero'],'base_gravable'=>$detalle_rows['basegravable'],'base_no_gravable'=>$detalle_rows['basenogravable']);	
					$aux_det++;
				}
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
                                                            "options"   => array("name"=>"alumnos[]",
                                                                                 "id"=>"alumnos",
                                                                                 "class"=>"form-control",
																				 "multiple"=>"multiple",
																				 "onchange"=>"js_aniosPeriodo_validaTodos()",
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
                                                                                      1 => ' - Seleccione producto -',
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
			$user_data['peri_codi'] = $user_data['peri_codi'];
            $anioPeriodo->set_deudas_lote($user_data);
			retornar_mensaje($anioPeriodo->mensaje);
            break; 
		case GENERA_DEUDA_IND:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
			$user_data['peri_codi'] = $user_data['peri_codi'];	
			$datosProductos = array();
            $datosProductos = json_decode($user_data['producto'], true);
			$xml_text='<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml_text.='<productos>';
			
			foreach($datosProductos as $valor)
			{	$xml_text.='<producto codigo="'.$valor.'"/>';
			}
			$xml_text.='</productos>';
			$user_data['xml']=$xml_text;
			
			$datosAlumnos = array();
			$datosAlumnos = json_decode($user_data['cod_alum'], true);
			$xml_textAlum='<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml_textAlum.='<alumnos>';
			
			foreach($datosAlumnos as $valor)
			{	$xml_textAlum.='<alumno codigo="'.$valor.'"/>';
			}
			$xml_textAlum.='</alumnos>';
			$user_data['xml_textAlum']=$xml_textAlum;
			
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
		case BLOQUEA_ALUMNO:
			$datosAlumnos = array();
			$datosAlumnos = json_decode($user_data['cod_alum'], true);
			$xml_textAlum='<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml_textAlum.='<alumnos>';
			
			foreach($datosAlumnos as $valor)
			{	$xml_textAlum.='<alumno codigo="'.$valor.'"/>';
			}
			$xml_textAlum.='</alumnos>';
			$user_data['xml_textAlum']=$xml_textAlum;
			
			$anioPeriodo->set_bloqueo_alumno($xml_textAlum, $user_data['motivo'], $user_data['opcion'], $user_data['peri_codi'] );
			
			$data['mensaje'] = $anioPeriodo->mensaje;
			
			$listado_alumnos = new AnioPeriodo();
			
			$listado_alumnos->get_bloqueo_alumno( $_SESSION['peri_codi'], 2, -1 );
			
			$tbl_listado_alumnos_bloq ="<table class='table table-striped table-hover' id='tbl_listado_alumnos_bloq' name='tbl_listado_alumnos_bloq'>
						<thead>
						<tr><th style='text-align:center;'>Ref.</th>
							<th style='text-align:center;'>Alumno</th>
							<th style='text-align:center;'>Opción bloqueada</th>
							<th style='text-align:center;'>Motivo</th>
							<th style='text-align:center;'>Opciones</th>
						</tr>
						</thead>";
			$tbl_listado_alumnos_bloq.="<tbody>";
			
			$total_numero_detalle = 0;
			foreach( $listado_alumnos->rows as $rows )
			{   if ( !empty ($rows) )
				{	$tbl_listado_alumnos_bloq.="<tr>";
					foreach( $rows as $column )
					{   $tbl_listado_alumnos_bloq.="<td style='text-align:center;'>".$column."</td>";
					}
					$opciones["Eliminar"] = "<span onclick='js_aniosPeriodo_del_bloqueo(".'"'.$rows['alum_moti_bloq_opci_codi'].'"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='".$rows['alum_moti_bloq_opci_codi']."_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
					$tbl_listado_alumnos_bloq.="<td style='text-align:center;'>". $opciones["Eliminar"] ."</td>";
					$tbl_listado_alumnos_bloq.="</tr>";
				}
			}
			$tbl_listado_alumnos_bloq.="</tbody></table>";
			$data['tbl_listado_bloqueo_alumnos'] = $tbl_listado_alumnos_bloq;
			echo json_encode($data, true);
			break;
		case DELETE_BLOQUEO_ALUMNO:
			$anioPeriodo->del_bloqueo_alumno( $user_data['alum_moti_bloq_opci_codi'] );
			
			$data['mensaje'] = $anioPeriodo->mensaje;
			
			$listado_alumnos = new AnioPeriodo();
			
			$listado_alumnos->get_bloqueo_alumno( $_SESSION['peri_codi'], 2, -1 );
			
			$tbl_listado_alumnos_bloq ="<table class='table table-striped table-hover' id='tbl_listado_alumnos_bloq' name='tbl_listado_alumnos_bloq'>
						<thead>
						<tr><th style='text-align:center;'>Ref.</th>
							<th style='text-align:center;'>Alumno</th>
							<th style='text-align:center;'>Opción bloqueada</th>
							<th style='text-align:center;'>Motivo</th>
							<th style='text-align:center;'>Opciones</th>
						</tr>
						</thead>";
			$tbl_listado_alumnos_bloq.="<tbody>";
			
			$total_numero_detalle = 0;
			foreach( $listado_alumnos->rows as $rows )
			{   if ( !empty ($rows) )
				{	$tbl_listado_alumnos_bloq.="<tr>";
					foreach( $rows as $column )
					{   $tbl_listado_alumnos_bloq.="<td style='text-align:center;'>".$column."</td>";
					}
					$opciones["Eliminar"] = "<span onclick='js_aniosPeriodo_del_bloqueo(".'"'.$rows['alum_moti_bloq_opci_codi'].'"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='".$rows['alum_moti_bloq_opci_codi']."_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
					$tbl_listado_alumnos_bloq.="<td style='text-align:center;'>". $opciones["Eliminar"] ."</td>";
					$tbl_listado_alumnos_bloq.="</tr>";
				}
			}
			$tbl_listado_alumnos_bloq.="</tbody></table>";
			$data['tbl_listado_bloqueo_alumnos'] = $tbl_listado_alumnos_bloq;
			echo json_encode($data, true);
			break;
		case VIEW_GENERA_DEUDAS:
			$anioPeriodo->get_deudas_anuales($_SESSION['peri_codi']);
			$curso->get_all_cursos( $_SESSION['peri_codi'] );
			$periodo->get_all_periodos();	
            global $diccionario;
			
			$i=0;
			$array1=array();
			foreach ($anioPeriodo->rows as $row)
			{   if( !empty( $row ) )
				{   $array1[]= '
						<div class="{columna}" style="text-align:left;">
							<label><input type="checkbox" id="check_'. $row['codigo'] .'" name="check_'. $row['codigo'] .'" value="'. $row['codigo'] .'">'.
							$row['nombre'] .'<div id="div_check_'. $row['codigo'] .'"></div></label>
						</div>';
					$i++;
				}
			}
			if( $i == 0)
				$array1[]= '<div class="col-sm-12">No hay productos/servicios seleccionados para la generación masiva de deudas.</div>';
			$construct_table = '
			<div class="contenedor">
				<div align="center">'.genera_div_grid_por_columnas($array1,  3).
				  '
				</div>
			</div>';
	
			$data = array(
            'deudas_checklist'=> $construct_table,
		    '{combo_periodo}' => array(	"elemento"  => "combo", 
										"datos"     => $periodo->rows, 
										"options"   =>array("name"		=>"periodos",
															"id"		=>"periodos",
                                                            "class"		=>"form-control",
															"required"	=>"required",
															"disabled"	=> "disabled",
															"onChange"	=>"js_aniosPeriodo_cargaCursos('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => $_SESSION['peri_codi']),
			'{combo_curso}' => array(	"elemento"  => "combo",
										"datos"     => $curso->rows,
										"options"   => array("name"		=>"curso",
															 "id"		=>"curso",
                                                             "class"	=>"form-control",
															 "required"	=>"required",
															 "onChange"	=>"js_aniosPeriodo_cargaAlumnos('resultadoAlumnos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => 0),
			'{combo_alumnos}' => array("elemento"  => "combo", 
									   "datos"     => array(0 => array( 0 => -1, 
																		1 => '- Todos -',
																		3 => ''),
															1=> array()),
									   "options"   => array("name"		=>"alumnos",
															"id"		=>"alumnos",
                                                            "class"		=>"form-control",
															"required"	=>"required"),
									   "selected"  => 0)
			);
            retornar_formulario(VIEW_GENERA_DEUDAS, $data);
			break;
		case VIEW_BLOQUEO_ALUMNOS:
			$anioPeriodo->get_alumnos_bloqueados($_SESSION['peri_codi']);
			$curso->get_all_cursos( $_SESSION['peri_codi'] );
			$periodo->get_all_periodos();
			$opciones_bloqueo = new AnioPeriodo( );
			$opciones_bloqueo -> get_opciones_a_bloquear ( );
			$motivo_bloqueo = new AnioPeriodo( );
			$motivo_bloqueo -> get_motivos_all ( );
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
										"options"   =>array("name"		=>"periodos",
															"id"		=>"periodos",
                                                            "class"		=>"form-control",
															"required"	=>"required",
															"disabled"	=> "disabled",
															"onChange"	=>"js_aniosPeriodo_cargaCursos('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => $_SESSION['peri_codi']),
			'{combo_curso}' => array(	"elemento"  => "combo",
										"datos"     => $curso->rows,
										"options"   => array("name"		=>"curso",
															 "id"		=>"curso",
                                                             "class"	=>"form-control",
															 "required"	=>"required",
															 "onChange"	=>"js_aniosPeriodo_cargaAlumnos('resultadoAlumnos','".$diccionario['rutas_head']['ruta_html_finan']."/aniosPeriodo/controller.php')"),
										"selected"  => 0),
			'{combo_alumnos}' => array("elemento"  => "combo", 
									   "datos"     => array(0 => array( 0 => -1, 
																		1 => '- Todos -',
																		3 => ''),
															1=> array()),
									   "options"   => array("name"		=>"alumnos",
															"id"		=>"alumnos",
                                                            "class"		=>"form-control",
															"required"	=>"required"),
									   "selected"  => 0),
		   '{combo_motivo}' =>  array(	"elemento"  => "combo",
										"datos"     => $motivo_bloqueo->rows,
										"options"   => array("name"		=>"cmb_motivo",
															 "id"		=>"cmb_motivo",
                                                             "class"	=>"form-control",
															 "required"	=>"required",
															),
										"selected"  => 0),
		   '{combo_opcion_a_bloquear}' =>  array(	"elemento"  => "combo",
										"datos"     => $opciones_bloqueo->rows,
										"options"   => array("name"		=>"cmb_opciones",
															 "id"		=>"cmb_opciones",
                                                             "class"	=>"form-control",
															 "required"	=>"required",
															 "disabled"	=>"disabled"
															),
										"selected"  => 2)
			);
			
			$listado_alumnos = new AnioPeriodo();
			
			$listado_alumnos->get_bloqueo_alumno( $_SESSION['peri_codi'], 2, -1 );
			
			$tbl_listado_alumnos_bloq ="<table class='table table-striped table-hover' id='tbl_listado_alumnos_bloq' name='tbl_listado_alumnos_bloq'>
						<thead>
						<tr><th style='text-align:center;'>Ref.</th>
							<th style='text-align:center;'>Alumno</th>
							<th style='text-align:center;'>Opción bloqueada</th>
							<th style='text-align:center;'>Motivo</th>
							<th style='text-align:center;'>Opciones</th>
						</tr>
						</thead>";
			$tbl_listado_alumnos_bloq.="<tbody>";
			
			$total_numero_detalle = 0;
			foreach( $listado_alumnos->rows as $rows )
			{   if ( !empty ($rows) )
				{	$tbl_listado_alumnos_bloq.="<tr>";
					foreach( $rows as $column )
					{   $tbl_listado_alumnos_bloq.="<td style='text-align:center;'>".$column."</td>";
					}
					$opciones["Eliminar"] = "<span onclick='js_aniosPeriodo_del_bloqueo(".'"'.$rows['alum_moti_bloq_opci_codi'].'"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_deudas' id='".$rows['alum_moti_bloq_opci_codi']."_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
					$tbl_listado_alumnos_bloq.="<td style='text-align:center;'>". $opciones["Eliminar"] ."</td>";
					$tbl_listado_alumnos_bloq.="</tr>";
				}
			}
			$tbl_listado_alumnos_bloq.="</tbody></table>";
			$data['tbl_listado_bloqueo_alumnos'] = $tbl_listado_alumnos_bloq;
            retornar_formulario(VIEW_BLOQUEO_ALUMNOS, $data);
			break;
        case GET:
            $anioPeriodo->get($user_data['producto'],  $user_data['anio']);
            $data = array('aperiodo_codigoProducto' => $user_data['producto'],
                          'aperiodo_nombreProducto'	=> $anioPeriodo->nombreProducto,
                          'aperiodo_fechaInicio' 	=> $anioPeriodo->fechaInicio,
                          'aperiodo_fechaFin'		=> $anioPeriodo->fechaFin,
                          'aperiodo_codigoPeriodo'	=> $anioPeriodo->anio,
                          'aperiodo_diasProntoPago'	=> $anioPeriodo->diasProntoPago);
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
			echo "Resultado desconocido";
        	break;
    }
}
function genera_div_grid_por_columnas( $array_con_div_col, $num_columnas = 3)
{	//Lo que hace esta función es 'construir' una tabla con 'X' columnas, dependiendo de la variable '$num_columnas', que por default es 2.
	//Si num_columnas es 2, devuelve una tabla con 2 columnas, etc.
	//Como se usa bootstrap, sólo puedo retornar 1,2,3,4,6,12 columnas que midan exactamente igual.
	if ( $num_columnas < 6 ) $num_columnas = 3;
	if ( $num_columnas >= 6 && $num_columnas < 10 ) $num_columnas = 6;
	if ( $num_columnas >= 9 && $num_columnas < 13 ) $num_columnas = 12;
	$col_md = ( 12 / $num_columnas );
	$aux = 0;
	$c = count($array_con_div_col);
	$body = "";
	$body.='<div class="row" style="text-align:left;">';
	while ($aux < $c)
	{	$body.= str_replace( '{columna}', 'col-md-'.$col_md, $array_con_div_col[$aux] );
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) $body.='</div><div class="row">';
	}
	$body.='</div>';
	
	$table= "<div class='grid'>";
	$table.= $body;
	$table.= "</div>";
	
	return $table;
}
handler();
?>