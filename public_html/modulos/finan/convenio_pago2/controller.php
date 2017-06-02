<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/items/model.php');
require_once('../../finan/facturas/model.php');
require_once('../../finan/convenio_pago2/model.php');
require_once('constants.php');
require_once('view.php');

function handler() {
	session_start();
    require('../../../core/rutas.php');
    $factura 		= get_mainObject('Factura');
    $convenio_pago 	= get_mainObject('convenioPago');
    $permiso 		= get_mainObject('General');
	$item 			= get_mainObject('Item');
	$periodo 		= get_mainObject('Periodo');
	$grupEcon 		= get_mainObject('GrupoEconomico');
    $event 			= get_actualEvents(array(VIEW_GET_ALL, GET_PENDING_BILLS, SEND_TO_SRI, RESEND_TO_SRI,VIEW_QUERY_BANCOS), VIEW_GET_ALL);
    $user_data 		= get_frontData();
	
	global $diccionario;
	
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event) {
		case VIEW_BADGE_CP:
			$factura->get_menu_count_facturasPendienteConvenioPago();
			if(count($factura->rows)-1>0)
			{	if($factura->rows[0]['facturas_pendientes']>0) print $factura->rows[0]['facturas_pendientes'];
			}
			break;
		case GET:
			$factura->getSingleFactura($user_data['codigofactura'],$user_data['tipo_persona']);
			$selected = array();
			
			if ($factura->rows[0]["tipoIdentificacionComprador"] == "CI" )
			{ 	$selected[0]= "selected";
			}
			else if ($factura->rows[0]["tipoIdentificacionComprador"] == "RUC" )
			{ 	$selected[1]= "selected";
			}
			else if ($factura->rows[0]["tipoIdentificacionComprador"] == "PAS" )
			{ 	$selected[2]= "selected";
			}
			else if ($factura->rows[0]["tipoIdentificacionComprador"] == "CF" )
			{ 	$selected[3]= "selected";
			}
			else if ($factura->rows[0]["tipoIdentificacionComprador"] == "IDE" )
			{ 	$selected[4]= "selected";
			}
			else if ($factura->rows[0]["tipoIdentificacionComprador"] == "PLC" )
			{ 	$selected[5]= "selected";
			}
			else
			{ 	$selected= "";
			}
			
			$data =	array(	"combo" => $select='<select  id="tipo_iden" name="tipo_iden" class="form-control">
													<option '.$selected[0].' value="1">Cédula</option>
													<option '.$selected[1].' value="2">RUC</option>
													<option '.$selected[2].' value="3">Pasaporte</option>
													<option '.$selected[3].' value="4">Consumidor final</option>
													<option '.$selected[4].' value="5">Exterior</option>
													<option '.$selected[5].' value="6">Placa</option>
												</select>',
							"codigo"	=> $user_data['codigofactura'],
							"id"		=> $factura->rows[0]['repr_cedula'],
							"factura"	=> ''.$factura->rows[0]['prefijoSucursal'].'-'.$factura->rows[0]['prefijoPuntoVenta'].'-'.$factura->rows[0]['secuencialComprobante'],
							"repr_nomb"	=> $factura->rows[0]['repr_nomb'],
							"repr_apel"	=> $factura->rows[0]['repr_apel'],
							"repr_domi"	=> $factura->rows[0]['repr_domi'],
							"repr_email"=> $factura->rows[0]['repr_email'],
							"repr_telf"	=> $factura->rows[0]['repr_telf'],
							"tipoIdTitular"	=> $factura->rows[0]['tipoIdentificacionComprador'],
							"idTitular"		=> $factura->rows[0]['identificacionComprador'],
							"nombreTitular"	=> $factura->rows[0]['razonSocialComprador'],
							"dirTitular"	=> $factura->rows[0]['direccionTitular'],
							"emailTitular"	=> $factura->rows[0]['emailTitular'],
							"codigoAlumno"	=> $factura->rows[0]['codigoAlumno']
	 						);
			if ( $user_data['tipo_persona']!= '1' )
				$data['disable_reg_titular'] = " disabled='disabled' ";
			else
				$data['disable_reg_titular'] = "";
			retornar_formulario(VIEW_EDITAR, $data);
			break;
		case EDIT:
			$resultado = $factura->edit($user_data);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
        case VIEW_GET_ALL:
            #  Presenta la pagina inicial
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
            $factura->get_facturas('','','','','','','','','','','','','PC',0,0,'-1','0','-1','-1',NULL,NULL,'','',1);
            $data['mensaje'] = "Facturas por autorizar, autorizadas, DNA, etc.";
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-placeholder='- Seleccione producto -' style='width:320px;'>";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$data['cmb_producto'] = $select;
			$periodo->get_all_selectFormat();
			$data['{cmb_periodo}'] = array("elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos", "class"=>"form-control input-sm",
																 "onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => 0);
			$grupEcon->getCategorias_selectFormat_with_all('');
			$data['{cmb_grupoEconomico}'] = array("elemento"  => "combo", 
											"datos"     => $grupEcon->rows, 
                                            "options"   => array("name"=>"cmb_grupoEconomico","id"=>"cmb_grupoEconomico", "class"=>"form-control input-sm"),
											"selected"  => 0);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{cmb_nivelEconomico}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control input-sm",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
			$data['{cmb_curso}']=array("elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case PRINT_EXCEL_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			if(!isset($user_data['cmb_estadoElectronico']))
				$estadoElectronico = '';
			else 
				$estadoElectronico = $user_data['cmb_estadoElectronico'];
			if(!isset($user_data['txt_fecha_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['txt_fecha_ini'];
			
			if(!isset($user_data['txt_fecha_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['txt_fecha_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['txt_id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['txt_id_titular'];
			if(!isset($user_data['txt_cod_cliente']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['txt_cod_cliente'];
			if(!isset($user_data['txt_nom_cliente']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['txt_nom_cliente'];
			if(!isset($user_data['txt_nom_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['txt_nom_titular'];
			if(!isset($user_data['txt_ptoVenta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['txt_ptoVenta'];
			if(!isset($user_data['txt_sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['txt_sucursal'];
			if(!isset($user_data['txt_ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['txt_ref_factura'];
			if(!isset($user_data['cmb_producto']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $user_data['cmb_producto']  as $producto )
				{	if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['cmb_estado']))
				$estado = '';
			else 
				$estado = $user_data['cmb_estado'];
			if(!isset($user_data['txt_tneto_ini']))
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['txt_tneto_ini'];
			if(!isset($user_data['txt_tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['txt_tneto_fin'];
			
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema")
			->setSubject("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema")
			->setDescription("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			//CONTENIDO DEL ARCHIVO
			//IMPRIMIENDO CABECERAS
			$styleEncabezado = array(
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'font' => array('color' => array('rgb'=>'FFFFFF'),
									'size' => 11,
									'name' => 'Helvetica'),
					'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => '3C8DBC'))
				);
			if( $user_data['tipo_reporte'] == 'completo' )
			{   $cabeceras ='Factura ref.,Número de factura,Producto,Tipo Id,Id del titular,Titular,email titular,Número de autorización,'.
							'Clave de acceso,Fecha de autorización,Numero secuencial,Total bruto,Total descuento,Total I.V.A.,Total I.C.E.,Total neto,Total abonado,Alumno/Cliente ref. interna,'.
							'Alumno/Cliente nombre,Alumno/Cliente cedula,Alumno/Cliente fecha nacimiento,Fecha creacion DNA/Fecha de pago,Fecha de creación de deuda,Estado electrónico,Curso';
			}
			if( $user_data['tipo_reporte'] == 'mini' )
			{   $cabeceras ='Factura ref.,Titular,Id del titular,Sucursal,Punto de venta,Número secuencial,Total neto,Cliente ref. interna,Cliente nombre,Fecha de emisión,estado electrónico';
			}
			
			$cabecera = explode( ",", $cabeceras );
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	if(!empty( $head ) )
				{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $head);
					$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(30);
					$i_cabe=$i_cabe+1;
					$column++;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->applyFromArray( $styleEncabezado );
			$factura = new Factura();
			if( $user_data['tipo_reporte'] == 'completo' )
			{   $factura->get_facturas_to_excel($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
											$estado, $tneto_ini, $tneto_fin,
											$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
											$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'],
											$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'], 1 );
			}
			if( $user_data['tipo_reporte'] == 'mini' )
			{   $factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
										$estado, $tneto_ini, $tneto_fin,
										$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
										$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'],
										$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'], 1 );
			}
            $facturas=$factura->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ($facturas as $registro)
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, $valor);
					$i_deta_col=$i_deta_col+1;
				}
				$i_deta_fila=$i_deta_fila+1;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Bandeja de facturas');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_gestion_facturas.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case GET_ALL_DATA:
            global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			if(!isset($user_data['estadoElectronico']))
				$estadoElectronico = '';
			else 
				$estadoElectronico = $user_data['estadoElectronico'];
			if(!isset($user_data['fechavenc_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['fechavenc_ini'];
			
			if(!isset($user_data['fechavenc_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['fechavenc_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['id_titular'];
			if(!isset($user_data['cod_estudiante']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['cod_estudiante'];
			if(!isset($user_data['nombre_estudiante']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['nombre_estudiante'];
			if(!isset($user_data['nombre_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['nombre_titular'];
			if(!isset($user_data['ptvo_venta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['ptvo_venta'];
			if(!isset($user_data['sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['sucursal'];
			if(!isset($user_data['ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['ref_factura'];
			if(!isset($user_data['prod_codigo']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$productos = json_decode($user_data['prod_codigo'], true);
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $productos as $producto )
				{   if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['estado']))
				$estado = 'PC';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['tneto_ini']))
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['tneto_ini'];
			if(!isset($user_data['tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['tneto_fin'];
			
			$factura = new Factura();
			$factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin,
									$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
									$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'],
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin'], 1);
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso, $estado);
			retornar_result($data);
            break;
		case GET_QUERY_BANCOS:
			$factura->get_query_bancos('BANCO','9','10');
            $data['{querybanco1}'] = array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>'tbl_querybanco1',
                                      "datos"=>$factura->rows,
                                      "encabezado" => array("valor factura",
                                                            "banco",
                                                            "tipo cuenta",
                                                            "cuenta",
															"tipo id",
															"id",
															"cliente",
															"alumno"),
                                      "options"=>array(),
                                      "campo"=>"id");
			$factura2 = new Factura();
			$factura2->get_query_bancos('TARJETA','9','10');
			$data['{querybanco2}'] = array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>'tbl_querybanco2',
                                      "datos"=>$factura2->rows,
                                      "encabezado" => array("valor factura",
                                                            "Tarjeta",
															"F. vencimiento tarjeta",
                                                            "cuenta",
															"tipo id",
															"id",
															"cliente",
															"alumno"),
                                      "options"=>array(),
                                      "campo"=>"id");
			retornar_formulario(VIEW_QUERY_BANCOS,$data);
            break;
        case GET_PENDING_BILLS:
            global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			if(!isset($user_data['estadoElectronico']))
				$estadoElectronico = '';
			else 
				$estadoElectronico = $user_data['estadoElectronico'];
			if(!isset($user_data['fechavenc_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['fechavenc_ini'];
			
			if(!isset($user_data['fechavenc_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['fechavenc_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['id_titular'];
			if(!isset($user_data['cod_estudiante']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['cod_estudiante'];
			if(!isset($user_data['nombre_estudiante']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['nombre_estudiante'];
			if(!isset($user_data['nombre_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['nombre_titular'];
			if(!isset($user_data['ptvo_venta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['ptvo_venta'];
			if(!isset($user_data['sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['sucursal'];
			if(!isset($user_data['ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['ref_factura'];
			if(!isset($user_data['prod_codigo']))
				$prod_codigo = '';
			else
			{   $true=0;
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $user_data['prod_codigo']  as $producto )
				{   if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['estado']))
				$estado = 'PC';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['tneto_ini']))
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['tneto_ini'];
			if(!isset($user_data['tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['tneto_fin'];
			$factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin,
									$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
									$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'],
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin'], 1);
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
            retornar_result($data);
            break;
		case GET_PENDING_BILLS_CODI_JSON:
			global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			if(!isset($user_data['estadoElectronico']))
				$estadoElectronico = '';
			else 
				$estadoElectronico = $user_data['estadoElectronico'];
			if(!isset($user_data['fechavenc_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['fechavenc_ini'];
			
			if(!isset($user_data['fechavenc_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['fechavenc_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['id_titular'];
			if(!isset($user_data['cod_estudiante']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['cod_estudiante'];
			if(!isset($user_data['nombre_estudiante']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['nombre_estudiante'];
			if(!isset($user_data['nombre_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['nombre_titular'];
			if(!isset($user_data['ptvo_venta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['ptvo_venta'];
			if(!isset($user_data['sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['sucursal'];
			if(!isset($user_data['ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['ref_factura'];
			if(!isset($user_data['prod_codigo']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$productos = json_decode($user_data['prod_codigo'], true);
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $productos as $producto )
				{   if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['estado']))
				$estado = 'PC';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['tneto_ini']))
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['tneto_ini'];
			if(!isset($user_data['tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['tneto_fin'];
			
			$factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin,
									$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
									$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'],
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin'], 1);
			for($i=0; $i<count($factura->rows)-1; $i++) 
			{	if( !empty ( $factura->rows[$i]['codigoFactura'] ) )
					$data[]=$factura->rows[$i]['codigoFactura'];
			}
			echo json_encode($data, true);
		break;
        case SET_PAGO:
			$convenio_pago->set_convenioPago_pago( $user_data['codigoDocumento'] );
			$cp_ans = '';
			if ( !empty( $convenio_pago->rows[0]['cabePago_codigo'] ) )
			{   $cp_ans.= '<div class="callout callout-success">
								<h4><strong><li class="fa fa-exclamation"></li> Convenio de Pago</strong></h4>
								Pago realizado exitosamente
								<br>
								Pago no. '.$convenio_pago->rows[0]['cabePago_codigo'].' [<a id="aPagoPdf" href="../PDF/imprimir/pago/'.$convenio_pago->rows[0]['cabePago_codigo'].'" target="_blank">PDF</a> - <a id="aPagoPdf" href="../documento/imprimir/pago/'.$convenio_pago->rows[0]['cabePago_codigo'].'" target="_blank">HTML</a>]
							</div>';
			}else
			{   $cp_ans.= '<div class="callout callout-danger">
								<h4><strong><li class="fa fa-exclamation"></li> Convenio de Pago</strong></h4>
								Hubo un problema al tratar de procesar esta solicitud. Por favor, inténtelo nuevamente.
							</div>';
			}
			$data['mensaje'] = $convenio_pago->mensaje;
			$data['mensaje'] = $cp_ans;
			echo json_encode( $data,true );
            break;
		case SEND_DEUDA_CP_ALL:
			global $diccionario;
			if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
			{   $data['estado'] = 'NOCAJA';
			}
			else
			{   $convenio_pago = new convenioPago();
				$convenio_pago->set_convenioPago_pago( $user_data['codigoFactura'] );
				
				$data['estado'] = $convenio_pago->estado;
				$data['detalle']= 'Convenio con código documento no. ' . $user_data['codigoFactura'] . ' pagado exitosamente. Movido a bandeja de Gestión Facturas para envío al SRI.';
			}
			echo json_encode($data, true);
		break;
        default:
            echo "Resultado desconocido";
            break;
    }
}
handler();
function tablaFactura($tabla, $factura, $permiso, $estadoFac = 'P')
{	global $diccionario;
	
	if( $estadoFac == '' )
		$estadoFac = 'P';
	
	$permiso1 = $permiso2= false;
	$permiso->permiso_activo($_SESSION['usua_codigo'], 183);
	if ($permiso->rows[0]['veri']==1)
	{	$permiso1=true;
	}
	$permiso->permiso_activo($_SESSION['usua_codigo'], 184);
	if ($permiso->rows[0]['veri']==1)
	{	$permiso2=true;
	}
	$opciones="";
	$construct_table="
				<br>
				<table class='table table-bordered table-hover' id='".$tabla."'>
					<thead><tr id='tr_row_head' name='tr_row_head'>
						<th id='select_deud_codigo_box' name='select_deud_codigo_box'>
							<div style='font-size:x-small;text-align:center;' >
								<input style='display:none;' type='checkbox' id='ckb_codigoDocumento_head' name='ckb_codigoDocumento_head' onClick='js_convenio_pago_select_all(this)'></input>
							</div>
						</th>
						<th style='font-size:small;text-align:center;'>Ref.</th>
						<th style='font-size:small;text-align:center;'>T. Neto</th>
						<th style='font-size:small;text-align:center;'>C&oacute;digo</th>
						<th style='font-size:small;text-align:center;'>Estudiante</th>
						<th style='font-size:small;text-align:center;'>F. Emisión</th>
						<th style='font-size:small;text-align:center;'>Estado</th>";
	if ($permiso1==true)
	{	$construct_table.= "<th style='font-size:small;text-align:center;'>Pagar</th>";
	}
	$construct_table.= "</tr></thead>";
	$body="<tbody>";
	$c=0;
	$aux=0;
	$archivo= $archivoPDF = $archivoXML = $codigo = $cedula = "";
	foreach($factura->rows as $row)
	{	$aux++;
	}
	foreach($factura->rows as $row)
	{	if($c<($aux-1))
		{	$body.="<tr id='tr_row_".$c."'><td id='td_select_".$c."' name='td_select_".$c."' align='center'><div style='font-size:x-small;'>".
						"<input type='checkbox' id='ckb_codigoDocumento' name='ckb_codigoDocumento[]' value='{codigoDocumento}'
							onclick='js_convenio_pago_select_check_ind (this, ".$c.")'></input>".
						"</div></td>";
			$x=0;
			$datos="";
			foreach($row as $column)
			{	if($x==1)
				{	$datos.="<div style=\"text-align:left;\">".
								"<table><tr><td style=\"vertical-align:top;\"><b>Titular:&nbsp;</b></td><td>". $column."</td></tr>";
				}
				elseif($x==2)
				{	$datos.="<tr><td><b>C&eacute;dula:&nbsp;</b></td><td>". $column."</td></tr>";
					$cedula = $column;
				}
				elseif($x==3)
				{	$archivo = $column;
				}
				elseif($x==4)
				{	$archivo.= "-" . $column;
				}
				elseif($x==5)
				{	$archivo.= "-" . $column;
					$datos.="<tr><td><b>Factura:&nbsp;</b></td><td>". $archivo."</td></tr></table></div>";
				}
				elseif($x==6)
				{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
				}
				elseif($x==11)
				{	//: do nothing
				}
				else
				{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
						$body = str_replace('{codigoDocumento}',$codigo,$body);
					}
				}
				$x++;
			}
			$spanReen="<div align='center' style='display:inline-block;'><span onclick='js_convenio_pago_pagar(".'"'.$codigo.'"'.",".'"modal_send_body"'.")' class='btn_opc_lista_reenviar fa fa-handshake-o cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_send' id='".$codigo."_pagar' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Pagar deuda y generar factura'></span></div>";
			if ($permiso1==true)
			{	$body.= "<td style='text-align:center'>".$spanReen."</td>";
			}
		}
		$body.="</tr>";
		$c++;
	}
	$construct_table.=$body;
	$construct_table.="</tbody></table>";
	return $construct_table;
}