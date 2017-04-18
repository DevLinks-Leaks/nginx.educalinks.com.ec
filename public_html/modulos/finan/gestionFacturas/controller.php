<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/items/model.php');
require_once('../../finan/facturas/model.php');
require_once('constants.php');
require_once('view.php');
require_once '../../../includes/finan/proc_comp_elec.php';

function handler() {
	session_start();
    require('../../../core/rutas.php');
    $factura 		= get_mainObject('Factura');
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
		case VIEW_BADGE_FACT:
			$factura->get_menu_count_facturasPendienteToSRI();
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
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
            $factura->get_facturas();
            $data['mensaje'] = "Facturas por autorizar, autorizadas, DNA, etc.";
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
											$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'] );
			}
			if( $user_data['tipo_reporte'] == 'mini' )
			{   $factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
										$estado, $tneto_ini, $tneto_fin,
										$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
										$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'],
										$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'] );
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
				$estado = '';
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
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin']);
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
				$estado = '';
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
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin']);
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
            retornar_result($data);
            break;
		case SEND_TO_SRI_ALL:
			global $diccionario;
			if ( ( $user_data['estado'] == 'PC' ) || ( $user_data['estado'] == 'PV' ) )
			{	if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
				{   $data['estado'] = 'NOCAJA';
				}
				else
				{   $data = enviar_factura_al_SRI(	$user_data['codigoFactura'], 'por lote',$ruta_documentosAutorizados,
													true, $user_data['estado']);
				}
			}
			if ( ( $user_data['estado'] == 'P' ) || ( $user_data['estado'] == '' ) )
			{   $data = enviar_factura_al_SRI(	$user_data['codigoFactura'], 'por lote',$ruta_documentosAutorizados,
													true, $user_data['estado']);
			}
			echo json_encode($data, true);
			break;
		case AUTORIZAR_TO_SRI_ALL:
			global $diccionario;
			if ( ( $user_data['estado'] == 'PC' ) || ( $user_data['estado'] == 'PV' ) )
			{	if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
				{   $data['estado'] = 'NOCAJA';
				}
				else
				{   $data = autorizar_factura_al_SRI(	$user_data['codigoFactura'],'por lote',$ruta_documentosAutorizados,
														$user_data['estado']);
				}
			}
			if ( ( $user_data['estado'] == 'P' ) || ( $user_data['estado'] == '' ) )
			{   $data = autorizar_factura_al_SRI(	$user_data['codigoFactura'], 'por lote',$ruta_documentosAutorizados,
													$user_data['estado']);
			}
			echo json_encode($data, true);
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
				$estado = '';
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
									$user_data['fechaAut_ini'],$user_data['fechaAut_fin']);
			for($i=0; $i<count($factura->rows)-1; $i++) 
			{	if( !empty ( $factura->rows[$i]['codigoFactura'] ) )
					$data[]=$factura->rows[$i]['codigoFactura'];
			}
			echo json_encode($data, true);
		break;
        case SEND_TO_SRI:
			if ( ( $user_data['estadoFac'] == 'PC' ) || ( $user_data['estadoFac'] == 'PV' ) )
			{	if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
				{   $data[ 'listEBills' ] ='<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li> Envío de factura sin pago</strong></h4>
							Usuario debe estar a <b>asignado a una caja</b> y/o'.
							' estar trabajando con una <b>caja abierta</b> para poder realizar esta operación.
						</div>';
					retornar_formulario(VIEW_RESULT_SRI, $data);
				}
				else
				{   $data = enviar_factura_al_SRI(	$user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados,
													$user_data['enviar'], $user_data['estadoFac']);
					retornar_formulario(VIEW_RESULT_SRI, $data);
				}
			}
			if ( ( $user_data['estadoFac'] == 'P' ) || ( $user_data['estadoFac'] == '' ) )
			{   $data = enviar_factura_al_SRI(	$user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados,
												$user_data['enviar'], $user_data['estadoFac']);
				retornar_formulario(VIEW_RESULT_SRI, $data);
			}
            break;
        case RESEND_TO_SRI:
			if ( ( $user_data['estadoFac'] == 'PC' ) || ( $user_data['estadoFac'] == 'PV' ) )
			{	if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
				{   $data[ 'listEBills' ] ='<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li> Envío de factura sin pago</strong></h4>
							Usuario debe estar a <b>asignado a una caja</b> y/o'.
							' estar trabajando con una <b>caja abierta</b> para poder realizar esta operación.
						</div>';
					retornar_formulario(VIEW_RESULT_SRI, $data);
				}
				else
				{   $data = autorizar_factura_al_SRI(	$user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados,
														$user_data['estadoFac']);
					retornar_formulario(VIEW_RESULT_SRI, $data);
				}
			}
			if ( ( $user_data['estadoFac'] == 'P' ) || ( $user_data['estadoFac'] == '' ) )
			{   $data = autorizar_factura_al_SRI(	$user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados,
													$user_data['estadoFac']);
				retornar_formulario(VIEW_RESULT_SRI, $data);
			}
            break;
        default:
            echo "Resultado desconocido";
            break;
    }
}
handler();
function enviar_factura_al_SRI($codigo, $cuantas,$ruta_documentosAutorizados, $enviar, $estadoFac = 'P' )
{   session_start();
	
	if( $estadoFac == '' )
		$estadoFac = 'P';
	
	$facturaBD = new Factura(); 
	$detalleFact = array();
	$cabeceraFactura = array();
	// Consulta de la factura generada
	if ( $estadoFac == 'P' )
		$detalleFact = $facturaBD->get_facturaToFormatXML( $codigo );
	if ( ( $estadoFac == 'PC' ) || ( $estadoFac == 'PV' ) )
		$detalleFact = $facturaBD->get_facturaToFormatXMLandUpdateValues( $codigo, $_SESSION['puntVent_codigo'] );
	$cabeceraFactura = $detalleFact[0];
	$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
	$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema



	// Acumulo del detalle de la factura los valores CON  iva y los valores SIN iva para el detalle del impuesto posterior
	$baseImponibleConIVA = 0;   $baseImponibleSinIVA = 0;
	foreach ($detalleFact as $registro)
	{	if($registro["totalIVADetalle"]>0)
		{	$baseImponibleConIVA += $registro["precioTotalSinImpuesto"];
		}else
		{	$baseImponibleSinIVA += $registro["precioTotalSinImpuesto"];
		}
	}
	
	// Validación del tipo de identificación del comprador
	$tipoIdentificacionComprador = "";
	if( trim($cabeceraFactura['tipoIdentificacionComprador'])=="PAS" ){
		$tipoIdentificacionComprador = "06";
	}elseif ( trim($cabeceraFactura['tipoIdentificacionComprador'])=="CF" ){
		$tipoIdentificacionComprador = "07";
	}elseif ( trim($cabeceraFactura['tipoIdentificacionComprador'])=="IDE" ){
		$tipoIdentificacionComprador = "08";
	}elseif ( trim($cabeceraFactura['tipoIdentificacionComprador'])=="PLC" ){
		$tipoIdentificacionComprador = "09";
	}elseif ( trim($cabeceraFactura['tipoIdentificacionComprador'])=="CI" ){
		$tipoIdentificacionComprador = "05";
	}else{
		$tipoIdentificacionComprador = "04";
	}

	// 1.- Creo el objeto que interactua con el servicio web
	$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
	// 2.- Configuración de variables del sistema de facturación electrónica
	$configAplicacion = new configAplicacion();
	$configAplicacion->dirFirma = $_SESSION['rutallave'].$_SESSION['llaveactiva'];
	//$configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinksprod/finan/includes/gustavo_alfonso_decker_zambrano.p12";
	$configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];
	$configAplicacion->passFirma = $_SESSION['passllaveactiva'];
	// $configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinksprod/finan/documentos/autorizados";
	$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;
	if($cabeceraFactura['emailTitular'] != '')
	{	$configCorreo = new configCorreo();
		$configCorreo->correoAsunto = "Notificación de documento electrónico generado";
		$configCorreo->correoHost = "smtp.gmail.com";
		$configCorreo->correoPass = "Redlinks12345";
		$configCorreo->correoPort = "587";
		$configCorreo->correoRemitente = "facturaelectronica.redlinks@gmail.com";
		$configCorreo->sslHabilitado = true;
	}

	// 3.- Cabecera de la factura
	$factura = new facturaSRI();
	$factura->configAplicacion =  $configAplicacion;
	if($cabeceraFactura['emailTitular'] != '')
	{	$factura->configCorreo =  $configCorreo;
	}
	$factura->ambiente = $ambiente; //[1,Prueba][2,Produccion]
	$factura->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
	$factura->razonSocial = $cabeceraFactura['razonSocial']; //[Razon Social]
	if($cabeceraFactura['nombreComercial']!= ""){ $factura->nombreComercial = $cabeceraFactura['nombreComercial']; }  //[Nombre Comercial, si hay]*
	$factura->ruc = $cabeceraFactura['ruc']; //[Ruc]
	$factura->codDoc = "01"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
	$factura->establecimiento = $cabeceraFactura['prefijoSucursal']; // [Numero Establecimiento SRI]
	$factura->ptoEmision = $cabeceraFactura['prefijoPuntoVenta']; //[pto de emision ] **
	$factura->secuencial = $cabeceraFactura['secuencialComprobante']; // [Secuencia desde 1 (9)]
	$factura->fechaEmision = $cabeceraFactura['fechaEmision']; //[Fecha (dd/mm/yyyy)]
	$factura->dirMatriz = $cabeceraFactura['direccionMatriz']; //[Direccion de la Matriz ->SRI]
	$factura->dirEstablecimiento = $cabeceraFactura['direccionEstablecimiento']; //[Direccion de Establecimiento ->SRI]
	$factura->contribuyenteEspecial = $_SESSION['contribuyente_especial']; //[Ver SRI]
	$factura->obligadoContabilidad = "SI"; // [SI]
	$factura->tipoIdentificacionComprador = $tipoIdentificacionComprador; //Info comprador [04, RUC][05,Cedula][06, Pasaporte][07, Consumidor final][08, Exterior][09, Placa]
	$factura->razonSocialComprador = $cabeceraFactura['razonSocialComprador']; //Razon social o nombres y apellidos comprador
	$factura->identificacionComprador = $cabeceraFactura['identificacionComprador']; // Identificacion Comprador
	$factura->totalSinImpuestos =  number_format(($baseImponibleSinIVA+$baseImponibleConIVA),2,'.','');//number_format($cabeceraFactura['totalSinImpuestos'],2,'.',''); // Total sin aplicar impuestos
	$factura->totalDescuento = number_format($cabeceraFactura['totalDescuento'],2,'.',''); // Total Dtos
	// 4.- Impuestos de la cabecera
	$impuestosCabecera = array();
	// 4.1.- Acumulado del IVA 12%
	if($baseImponibleConIVA > 0)
	{	$totalIVA12 = new totalImpuesto();
		$totalIVA12->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
		$totalIVA12->codigoPorcentaje = "3"; // IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
		$totalIVA12->baseImponible = number_format($baseImponibleConIVA, 2, '.', ''); // Suma de los impuesto del mismo cod y % (0.00)
		$totalIVA12->valor = number_format($cabeceraFactura['totalIVA'], 2, '.', ''); // Suma de los impuesto del mismo cod y % aplicado el % (0.00)
		$impuestosCabecera[] = $totalIVA12;
	}
	// 4.2.- Acumulado del IVA 0%
	if($baseImponibleSinIVA > 0)
	{	$totalIVA0 = new totalImpuesto();
		$totalIVA0->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
		$totalIVA0->codigoPorcentaje = "0"; // IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
		$totalIVA0->baseImponible = number_format($baseImponibleSinIVA, 2, '.', ''); // Suma de los impuesto del mismo cod y % (0.00)
		$totalIVA0->valor = number_format(0, 2, '.', ''); // Suma de los impuesto del mismo cod y % aplicado el % (0.00)
		$impuestosCabecera[] = $totalIVA0;
	}
	// 5.- Totales de la cabecera
	$factura->totalConImpuesto = $impuestosCabecera; //Agrega el impuesto a la factura
	$factura->propina = "0.00"; // Propina
	$factura->importeTotal = number_format($cabeceraFactura['totalImporte'],2,'.',''); // Total de Productos + impuestos
	$factura->moneda = "DOLAR";
	
	// 5.5.- Forma de pago
	$pagos = array();
	
	// Consulta de las formas de pago de la factura 
	$pagosBD = $facturaBD->get_facturaToFormatXML_pagos( $codigo );
	$formaPago_aux = 0;
	
	foreach ($pagosBD as $formaPago)
	{   $pago = new pago();
		$pago->formaPago = $formaPago['formaPago'];
		$pago->total = $formaPago['pagoTotal'];
		$pagos [] = $pago;
		$formaPago_aux++;
	}
	if ($formaPago_aux == 0 )
	{   $pago = new pago();
		$pago->formaPago = 20;
		$pago->total = number_format( $cabeceraFactura['totalImporte'], 2, '.', '' );
		$pagos [] = $pago;
	}
	$factura->pagos = $pagos;
	
	// 6.- Detalle de la factura
	$detalle = array();
	foreach ($detalleFact as $linea)
	{	$detalleFactura = new detalleFactura();
		$detalleFactura->codigoPrincipal = $linea['codigoPrincipalProducto']; // Codigo del Producto
		//$detalleFactura->codigoAuxiliar = "1334D56789-A"; // Opcional
		$detalleFactura->descripcion = $linea['descripcionProducto']; // Nombre del producto
		$detalleFactura->cantidad = number_format($linea['cantidad'], 2, '.', ''); // Cantidad
		$detalleFactura->precioUnitario = number_format($linea['precioUnitario'], 2, '.', ''); // Valor unitario
		$detalleFactura->descuento = number_format($linea['descuentoDetalle'], 2, '.', ''); // Descuento u
		$detalleFactura->precioTotalSinImpuesto = number_format($linea['precioTotalSinImpuesto'], 2, '.', ''); // Valor sin impuesto

		// 6.1.- Impuesto del detalle
		$impuestoDetalle = array();
		$impuesto = new impuesto(); // Impuesto del detalle
		$impuesto->codigo = "2";
		$impuesto->codigoPorcentaje = ($linea['totalIVADetalle']>0? "3" : "0" );
		$impuesto->tarifa = ($linea['totalIVADetalle']>0? "14" : "0" );
		$impuesto->baseImponible = number_format($linea['precioTotalSinImpuesto'], 2, '.', '');
		$impuesto->valor = number_format($linea['totalIVADetalle'], 2, '.', '');
		$impuestoDetalle[] = $impuesto;
		// Agrego el impuesto al detalle
		$detalleFactura->impuestos = $impuestoDetalle;
		// Agrego el detalle
		$detalle[] = $detalleFactura;
	}
	// Agrego los detalles a la factura
	$factura->detalles = $detalle;
	$camposAdicionales = array();
	// 7.- Campos adicionales de la factura
	if ( $cabeceraFactura['nombresAlumno'] != '' )
	{   $campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "alumno";
		$campoAdicional->valor = "Codigo: ".$cabeceraFactura['codigoAlumno']." Nombres: ".$cabeceraFactura['nombresAlumno'];
		$camposAdicionales[] = $campoAdicional;
	}
	if($cabeceraFactura['emailTitular'] != '')
	{	$campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "Email";
		$campoAdicional->valor = $cabeceraFactura['emailTitular'];
		$camposAdicionales[] = $campoAdicional;
	}
	else
	{	$campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "Telefono";
		$campoAdicional->valor = $cabeceraFactura['telefonoTitular'];
		$camposAdicionales[] = $campoAdicional;
	}
	if ( $cabeceraFactura['nombresAlumno'] != '' )
	{   $campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "Matricula";
		$campoAdicional->valor = $cabeceraFactura['registro'];
		$camposAdicionales[] = $campoAdicional;
	}
	$factura->infoAdicional = $camposAdicionales;
	$procesarComprobante = new procesarComprobante();
	$procesarComprobante->comprobante = $factura;
	$procesarComprobante->envioSRI = false; //nuevo campo, 2015-11-09.
	$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
	
	if($enviar == true)
	{   if($res->return->estadoComprobante == "FIRMADO")
		{	$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $factura;
			$procesarComprobante->envioSRI = true;
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
	}
	// Actualizo el estado en el comprobante
	$fact = new Factura();
	if($enviar == true)
	{	$fact->set_estadoElectronico($codigo, $res->return->estadoComprobante, $res->return->numeroAutorizacion, $res->return->claveAcceso, $tipoEmision, $ambiente);
	}
	$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
	if ($mensaje=='') $mensaje='-n/a-';
	$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
	if ($informacionAdicional=='') $informacionAdicional='-n/a-';
	$numAutorizacion = (($res->return->numeroAutorizacion=='')? '-n/a-' : $res->return->numeroAutorizacion);
	$documentosElectronicos[] = HTML::a('../../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/FAC'.$cabeceraFactura['prefijoSucursal'].'-'.$cabeceraFactura['prefijoPuntoVenta'].'-'.str_pad($cabeceraFactura['secuencialComprobante'], 9, "0", STR_PAD_LEFT).'.pdf',
										'Factura Electr&oacute;nica # '.$codigo).'<br>'.
										'<br><b>Datos del comprobante</b><br>'.
										'<br><table><tr><td width="25%" align="left"><b><small>Clave de Acceso:</b></td><td valign="top"><i><small>'.$res->return->claveAcceso.'</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>No. de autorización:</b></td><td valign="top"><small>'.$numAutorizacion.'</small></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Estado:</small></b></td><td valign="top"><i><small>'.$res->return->estadoComprobante.'.</small></i></td></tr>'.
										'<tr><td colspan="2"><hr/></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Mensaje:</small></b></td><td valign="top"><i><small>'.$mensaje.'.</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Información adicional:</small></b></td><td valign="top"><i><small>'.$informacionAdicional.'.</small></i></td></tr>'.
										'</table>';
	if( $cuantas == 'por lote' )
	{	$data['estado'] = $res->return->estadoComprobante;
		$data['detalle']=array(	"elemento"  => "lista",
								"datos"     => $documentosElectronicos,
								"options"   => array("name" => "listDocumentosElectronicos",
													   "id" => "listDocumentosElectronicos",
													"class" => "form-control"));
		return $data;
	}elseif($cuantas=='solo una')
	{	$data = array('{listEBills}' => array(	"elemento"  => "lista",
											"datos"     => $documentosElectronicos,
											"options"   => array("name" => "listDocumentosElectronicos",
																   "id" => "listDocumentosElectronicos",
																"class" => "form-control")
										 )
				 );
		return $data;
	}
}

function autorizar_factura_al_SRI( $codigo, $cuantas, $ruta_documentosAutorizados, $estadoFac = 'P' )
{   session_start();
	$facturaBD = new Factura();
	$detalleFact = array();
	$cabeceraFactura = array();
	// Consulta de la factura generada
	if ( $estadoFac == 'P' )
		$detalleFact = $facturaBD->get_facturaToFormatXML( $codigo );
	if ( ( $estadoFac == 'PC' ) || ( $estadoFac == 'PV' ) )
		$detalleFact = $facturaBD->get_facturaToFormatXMLandUpdateValues( $codigo, $_SESSION['puntVent_codigo'] );
	$cabeceraFactura = $detalleFact[0];

	$fact_estado = new Factura();
	$estadoProcesandose='PROCESANDOSE';
	$fact_estado->set_estadoElectronico_estado($codigo, $estadoProcesandose);

	$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
	$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema

	// 1.- Creo el objeto que interactua con el servicio web
	$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
	// 2.- Configuración de variables del sistema de facturación electrónica
	$configAplicacion = new configAplicacion();
	$configAplicacion->dirFirma =  $_SESSION['rutallave'].$_SESSION['llaveactiva'];
	$configAplicacion->passFirma = $_SESSION['passllaveactiva'];
	$configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];

	// $configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinksprod/finan/documentos/autorizados";
	$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;
	if($cabeceraFactura['emailTitular'] != ''){
		$configCorreo = new configCorreo();
		$configCorreo->correoAsunto = "Notificación de documento electrónico generado";
		$configCorreo->correoHost = "smtp.gmail.com";
		$configCorreo->correoPass = "Redlinks12345";
		$configCorreo->correoPort = "587";
		$configCorreo->correoRemitente = "facturaelectronica.redlinks@gmail.com";
		$configCorreo->sslHabilitado = true;
	}
	
	$comprobantesPendientes = new comprobantePendiente();
	$comprobantesPendientes->ambiente = $ambiente; //[1,Prueba][2,Produccion]
	$comprobantesPendientes->codDoc = "01"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
	$comprobantesPendientes->configAplicacion =  $configAplicacion;
	//if($cabeceraFactura['emailTitular'] != ''){
	$comprobantesPendientes->configCorreo =  $configCorreo;
	//}
	$comprobantesPendientes->establecimiento = $cabeceraFactura['prefijoSucursal']; // [Numero Establecimiento SRI]
	$comprobantesPendientes->fechaEmision = $cabeceraFactura['fechaEmision'];
	$comprobantesPendientes->ptoEmision = $cabeceraFactura['prefijoPuntoVenta']; //[pto de emision ] **
	$comprobantesPendientes->ruc = $cabeceraFactura['ruc']; //[Ruc]
	$comprobantesPendientes->secuencial = $cabeceraFactura['secuencialComprobante']; // [Secuencia desde 1 (9)]
	$comprobantesPendientes->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema

	$procesarComprobante = new procesarComprobantePendiente();
	$procesarComprobante->comprobantePendiente = $comprobantesPendientes;
	$res = $procesarComprobanteElectronico->procesarComprobantePendiente($procesarComprobante);

	// Actualizo el estado en el comprobante
	$fact = new Factura();
	$fact->set_estadoElectronico($codigo, $res->return->estadoComprobante, $res->return->numeroAutorizacion, $res->return->claveAcceso, $tipoEmision, $ambiente);

	$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
	if($mensaje=='') $mensaje='-n/a-';
	$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
	if ($informacionAdicional=='') $informacionAdicional='-n/a-';
	$numAutorizacion = (($res->return->numeroAutorizacion=='')? '-n/a-' : $res->return->numeroAutorizacion);
	$documentosElectronicos[] = HTML::a('../../../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/FAC'.$cabeceraFactura['prefijoSucursal'].'-'.$cabeceraFactura['prefijoPuntoVenta'].'-'.str_pad($cabeceraFactura['secuencialComprobante'], 9, "0", STR_PAD_LEFT).'.pdf',
										'Factura Electr&oacute;nica # '.$codigo).'<br>'.										
										'<br><b>Datos del comprobante</b><br>'.
										'<br><table><tr><td width="25%" align="left"><b><small>Clave de Acceso:</b></td><td valign="top"><i><small>'.$res->return->claveAcceso.'</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>No. de autorización:</b></td><td valign="top"><small>'.$numAutorizacion.'</small></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Estado:</small></b></td><td valign="top"><i><small>'.$res->return->estadoComprobante.'.</small></i></td></tr>'.
										'<tr><td colspan="2"><hr/></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Mensaje:</small></b></td><td valign="top"><i><small>'.$mensaje.'.</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Información adicional:</small></b></td><td valign="top"><i><small>'.$informacionAdicional.'.</small></i></td></tr>'.
										'</table>';
	if( $cuantas == 'por lote' )
	{	$data['estado'] = $res->return->estadoComprobante;
		$data['detalle']=array( "elemento"  => "lista",
								"datos"     => $documentosElectronicos,
								"options"   => array("name" => "listDocumentosElectronicos",
													 "id" => "listDocumentosElectronicos",
													 "class" => "form-control"));
		return $data;
	}elseif($cuantas=='solo una')
	{	$data = array('{listEBills}' => array(
										"elemento"  => "lista",
										"datos"     => $documentosElectronicos,
										"options"   => array("name" => "listDocumentosElectronicos",
															 "id" => "listDocumentosElectronicos",
															 "class" => "form-control")
									));
		return $data;
	}
}
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
								<input style='display:none;' type='checkbox' id='ckb_codigoDocumento_head' name='ckb_codigoDocumento_head' onClick='js_gestionFactura_select_all(this)'></input>
							</div>
						</th>
						<th style='font-size:small;text-align:center;'>Ref.</th>
						<th style='font-size:small;text-align:center;'>Datos</th>
						<th style='font-size:small;text-align:center;'>T. Neto</th>
						<th style='font-size:small;text-align:center;'>C&oacute;digo</th>
						<th style='font-size:small;text-align:center;'>Estudiante</th>
						<th style='font-size:small;text-align:center;'>F. Emisión</th>
						<th style='font-size:small;text-align:center;'>Estado</th>";
	if ($permiso1==true)
	{	$construct_table.= "<th style='font-size:small;text-align:center;'>Firmar</th>";
		$construct_table.= "<th style='font-size:small;text-align:center;'>Enviar</th>";
	}
	if ($permiso2==true)
	{	$construct_table.= "<th style='font-size:small;text-align:center;'>Reenviar</th>";	
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
		{	$body.="<tr id='tr_row_{codigoDocumento}' name='tr_row_{codigoDocumento}'><td id='td_select_".$c."' name='td_select_".$c."' align='center'><div style='font-size:x-small;'>".
						"<input type='checkbox' id='ckb_codigoDocumento' name='ckb_codigoDocumento[]' value='{codigoDocumento}'
							onclick='js_gestionFactura_select_check_ind (this, ".$c.")'></input>".
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
				{	$onclick=" onclick='js_gestionFactura_editar(".'"'.$codigo.'"'.",".'"'.$row['codigoAlumno'].'"'.",".'"'.$row['es_alumno'].'"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.",".'"'.$diccionario['rutas_head']['ruta_html_common'].'/representantes/controller.php"'.",true)' ";
					$spanEdit="<div align='center' style='display:inline-block;'><span ".$onclick." class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'   id='".$codigo."_editar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='top' title='Editar datos del titular.'></span></div>";
					$var_tooltip="<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='glyphicon glyphicon-search'></span></span>";
					$body.= "<td style='font-size:small;'>";
					
					if ($permiso2==true)
					{	$body.= $spanEdit;
					}
					$body.= "&nbsp;"."<a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/factura/".$codigo."' target='_blank'>".$var_tooltip."</a>";
					$body.="</td>";
					$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
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
			$spanFirmar="<div align='center' style='display:inline-block;'><span   onclick='js_gestionFactura_envio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.", 0, \"".$estadoFac."\")'	class='fa fa-pencil-square-o cursorlink'  aria-hidden='true' data-toggle='modal' data-target='#modal_send'   id='".$codigo."_firmar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Generar y firmar documento.'></span></div>";
			if( ( $estadoFac == 'P' ) || ( $estadoFac == '' ) )
			{   $spanAuto="<div align='center' style='display:inline-block;'><span   onclick='js_gestionFactura_envio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.", 1, \"P\")'  class='btn_opc_lista_subir_SRI icon icon-sri cursorlink'  aria-hidden='true' data-toggle='modal' data-target='#modal_send'   id='".$codigo."_enviar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Enviar factura a autorizar al SRI.'></span></div>";
				$spanReen="<div align='center' style='display:inline-block;'><span onclick='js_gestionFactura_reenvio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.", \"P\")'  	class='btn_opc_lista_reenviar glyphicon glyphicon-repeat cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_send' id='".$codigo."_reenviar' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Reintentar autorizaci&oacute;n de factura.'></span></div>";
			}
			if( ( $estadoFac == 'PC' ) || ( $estadoFac == 'PV' ) )
			{ 	$spanAuto="<div align='center' style='display:inline-block;'><span   onclick='js_gestionFactura_envio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.", 1, \"".$estadoFac."\")' style='color:red' class='btn_opc_lista_subir_SRI icon icon-sri cursorlink'  aria-hidden='true' data-toggle='modal' data-target='#modal_send'   id='".$codigo."_enviar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Enviar factura a autorizar al SRI.'></span></div>";
				$spanReen="<div align='center' style='display:inline-block;'><span onclick='js_gestionFactura_reenvio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionFacturas/controller.php"'.", \"".$estadoFac."\")'    style='color:red' class='btn_opc_lista_reenviar glyphicon glyphicon-repeat cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_send' id='".$codigo."_reenviar' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Reintentar autorizaci&oacute;n de factura.'></span></div>";
			}
			if ($permiso1==true)
			{	$body.= "<td style='text-align:center'>".$spanFirmar."</td>";
				$body.= "<td style='text-align:center'>".$spanAuto."</td>";
			}
			if ($permiso2==true)
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