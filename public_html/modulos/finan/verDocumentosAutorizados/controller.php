<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('constants.php');
require_once '../../../includes/finan/proc_comp_elec.php';
require_once('../../finan/facturas/model.php');
require_once('../../finan/notaCredito/model.php');
require_once('../../finan/notaDebito/model.php');
require_once('../../finan/items/model.php');
require_once('view.php');

function handler()
{	require('../../../core/rutas.php');
    $permiso 	= get_mainObject('General');
	$item 		= get_mainObject('Item');
	$periodo 	= get_mainObject('Periodo');
	$grupEcon 	= get_mainObject('GrupoEconomico');
    $event 		= get_actualEvents(array(VIEW_GET_ALL, RESEND_TO_SRI), VIEW_GET_ALL);
    $user_data 	= get_frontData();
	global $diccionario;
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event)
	{	case VIEW_GET_ALL:
            #  CASE QUE SE CARGA AL INICIO DE LA PAGINA
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
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
															"options"   => array("name"=>"cursos","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
			$data['mensaje'] = "Facturas y Notas de crédito";
			$data['tabla'] = "<div style='font-size:small;'>Haga clic en buscar para realizar una consulta.</div>";
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
				{   if( $producto!= '' )
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
			if($tipo_documento=='FAC')
			{	if( $user_data['tipo_reporte'] == 'completo' )
				{   $cabeceras ='Factura ref.,Número de factura,Producto,Tipo Id,Id del titular,Titular,email titular,Número de autorización,'.
								'Clave de acceso,Fecha de autorización,Numero secuencial,Total bruto,Total descuento,Total I.V.A.,Total I.C.E.,Total neto,Total abonado,Alumno/Cliente ref. interna,'.
								'Alumno/Cliente nombre,Alumno/Cliente cedula,Alumno/Cliente fecha nacimiento,Fecha creacion DNA/Fecha de pago,Fecha de creación de deuda,Estado electrónico,Curso';
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $cabeceras ='Factura ref.,Titular,Id del titular,Sucursal,Punto de venta,Número secuencial,Total neto,Cliente ref. interna,Cliente nombre,Fecha de emisión,estado electrónico';
				}
			}
			else if($tipo_documento=='NC')
			{	if( $user_data['tipo_reporte'] == 'completo' )
				{   $cabeceras ='N/C ref.,Número de Nota de crédito,Tipo Id,Id del titular,Titular,email titular,Número de autorización,'.
								'Clave de acceso,Fecha de autorización,Numero secuencial,Total bruto,Total descuento,Total I.V.A.,Total I.C.E.,Total neto,Total abonado,Alumno/Cliente ref. interna,'.
								'Alumno/Cliente nombre,Alumno/Cliente cedula,Alumno/Cliente fecha nacimiento,Fecha creación N/C,Fecha de pago,Fecha de creación de deuda,Estado electrónico,Curso';
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $cabeceras ='Nota de crédito ref.,Titular,Id del titular,Sucursal,Punto de venta,Número secuencial,Total neto,Cliente ref. interna,Cliente nombre,Fecha de emisión,estado electrónico';
				}
			}
			else if($tipo_documento=='ND')
			{	if( $user_data['tipo_reporte'] == 'completo' )
				{   $cabeceras ='Factura ref.,Número de factura,Producto,Tipo Id,Id del titular,Titular,email titular,Número de autorización,'.
								'Clave de acceso,Fecha de autorización,Numero secuencial,Total bruto,Total descuento,Total I.V.A.,Total I.C.E.,Total neto,Alumno/Cliente ref. interna,'.
								'Alumno/Cliente nombre,Alumno/Cliente cedula,Alumno/Cliente fecha nacimiento,Fecha de pago,Fecha de creación de deuda,Estado electrónico';
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $cabeceras ='Factura ref.,Titular,Id del titular,Sucursal,Punto de venta,Número secuencial,Total neto,Cliente ref. interna,Cliente nombre,Fecha de emisión,estado electrónico';
				}
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
			
			if($tipo_documento=='FAC')
			{	$factura = new Factura();
				if( $user_data['tipo_reporte'] == 'completo' )
				{   $factura->get_facturas_to_excel($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
													$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
													$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
													$estado, $tneto_ini, $tneto_fin,
													$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
													$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'] );
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $factura->get_facturas( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
											$estado, $tneto_ini, $tneto_fin,
											$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
											$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'] );
				}
			}
			else if($tipo_documento=='NC')
			{	$factura = new notaCredito();
				if( $user_data['tipo_reporte'] == 'completo' )
				{   $factura->get_notasCredito_excel(   $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
														$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
														$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
														$estado, $tneto_ini, $tneto_fin,
														$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
														$user_data['cursos'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'] );
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $factura->get_notasCredito( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
												$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
												$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
												$estado, $tneto_ini, $tneto_fin,
												$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
												$user_data['cursos'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'] );
				}
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
            #  CASE QUE SE CARGA AL INICIO DE LA PAGINA
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			if(!isset($user_data['estadoElectronico']))
			{   if( $user_data['ckb_opc_adv'] == '1' )
					$estadoElectronico = '';
				else
					$estadoElectronico = 'AUTORIZADO';
			}
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
				foreach ( $productos  as $producto )
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
			
			////////////////////////////////////
			if($tipo_documento=='FAC')
			{	$factura = new Factura();
				$factura->get_facturas($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
										$estado, $tneto_ini, $tneto_fin,
										$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
										$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'] );
				//$data['mensaje'] = "Bandeja de facturas autoziadas";
			}
			else if($tipo_documento=='NC')
			{	$factura = new notaCredito();
				$factura->get_notasCredito( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
											$estado, $tneto_ini, $tneto_fin,
											$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
											$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'] );
				//$data['mensaje'] = "Bandeja de notas de d&eacute;bito autoziadas";
			}
			else if($tipo_documento=='ND')
			{	$factura = new notaDebito();
				$factura->get_notasDebito($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, 
											$estado, $tneto_ini, $tneto_fin);
				//$data['mensaje'] = "Bandeja de notas de d&eacute;bito autoziadas";
			}
			$data['tabla'] = tablaFacturaAutorizada($tabla, $factura, $permiso, $tipo_documento);
			retornar_result($data);
            break;
        case RESEND_TO_SRI:
			require_once('../../../includes/common/phpmailer/class.phpmailer.php');
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			
			if($tipo_documento=='FAC')
			{	$facturaBD = new Factura(); $detalleFact = array(); $cabeceraFactura = array();
				$detalleFact = $facturaBD->get_facturaToFormatXML($user_data['codigoDocumento']);
				//$data = enviar_factura_al_SRI($user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados, false);
			}
			else if($tipo_documento=='NC')
			{	$notaCredito = new notaCredito(); $detalleFact = array(); $cabeceraFactura = array();
				$detalleFact = $notaCredito->getNotacreditoTrama($user_data['codigoDocumento']);
				//$data = enviar_nd_al_SRI($user_data['codigoDocumento'],'solo una', $ruta_documentosAutorizados, false);
			}
			else if($tipo_documento=='ND')
			{	$notaDebito = new notaDebito(); $detalleFact = array(); $cabeceraFactura = array();
				$detalleFact = $notaDebito->getNotadebitoTrama($user_data['codigoDocumento']);
				//$data = enviar_nc_al_SRI($user_data['codigoDocumento'],'solo una', $ruta_documentosAutorizados, false);
			}
            $cabeceraFactura = $detalleFact[0];
			$mail = new PHPMailer(true);                                  // the true param means it will throw exceptions on errors, which we need to catch
			$mail->isSMTP();                                              // telling the class to use SMTP transport
			$mail->Host = 'smtp.gmail.com';                               // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                                       // Enable SMTP authentication
			$mail->Username = 'facturaelectronica.redlinks@gmail.com';    // SMTP username
			$mail->Password = 'Redlinks12345';                            // SMTP password
			$mail->SMTPSecure = 'tls';                                    // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;      
		  
			$mail->AddReplyTo($_SESSION['correofacturas'], $_SESSION['name']);
			$mail->AddAddress($cabeceraFactura['emailTitular'],$cabeceraFactura['razonSocialComprador']);
			$mail->SetFrom('facturaelectronica.redlinks@gmail.com', 'Facturación Educalinks');
			//$mail->AddReplyTo('sistemas@redlinks.com.ec', 'Sistemas Redlinks');
			$mail->Subject = 'Envío de Factura Electrónica';
			$mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
			$body="<html><head><meta charset='UTF-8'><title></title></head><body>";
			$body .="<p>Estimado,</p>";
			$body .="<p>Se le ha adjuntado una factura electrónica a este correo.</p>";
			
			$body.="<p>Para acceder a revisar sus facturas anteriores <a href='".$_SESSION['visor']."'>Ingresar aqui</a></p></body></html>";
			$mail->MsgHTML($body);                                        // optional - MsgHTML will create an alternate automatically
			//$mail->AddAttachment('images/phpmailer.gif');               // attachment
			$mail->AddAttachment('../../../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/'.$tipo_documento.$cabeceraFactura['prefijoSucursal'].'-'.$cabeceraFactura['prefijoPuntoVenta'].'-'.str_pad($cabeceraFactura['secuencialComprobante'], 9, "0", STR_PAD_LEFT).'.pdf'); // attachment
			$mail->AddAttachment('../../../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/'.$tipo_documento.$cabeceraFactura['prefijoSucursal'].'-'.$cabeceraFactura['prefijoPuntoVenta'].'-'.str_pad($cabeceraFactura['secuencialComprobante'], 9, "0", STR_PAD_LEFT).'.xml');
			$mail->isHTML(true);                                          // Set email format to HTML
			$mail->CharSet = 'UTF-8';
			$mail->Send();

            retornar_formulario(VIEW_RESULT_SRI, $data);
            break;
        default:
            break;
    }
}
handler();
function tablaFacturaAutorizada($tabla, $factura, $permiso, $tipo_documento)
{	global $diccionario;
	$anidado = "";
	if ($tipo_documento=='FAC')
	{	$dir_tdoc_detail='factura';
		$anidado = "<th style=\"text-align:center;vertical-align:middle\"></th>";
	}
	else if ($tipo_documento=='NC')
	{	$dir_tdoc_detail='notaCredito';
	}
	else if ($tipo_documento=='ND')
	{	$dir_tdoc_detail='notaDebito';
	}
	$opciones="";
	$construct_table="
				<br>
				<table class='table table-bordered table-hover' id='".$tabla."'>
					<thead><tr>
						".$anidado."
						<th style='font-size:small;text-align:center;'>Ref.</th>
						<th style='font-size:small;text-align:center;'>Datos</th>
						<th style='font-size:small;text-align:center;'>T. Neto</th>
						<th style='font-size:small;text-align:center;'>C&oacute;digo</th>
						<th style='font-size:small;text-align:center;'>Estudiante</th>
						<th style='font-size:small;text-align:center;'>F. Emisión</th>
						<th style='font-size:small;text-align:center;'>Estado</th>
						<th style='font-size:small;text-align:center;'>Mail</th>
						<th style='font-size:small;text-align:center;'>XML</th>
						<th style='font-size:small;text-align:center;'>PDF</th>
						<th style='font-size:small;text-align:center;'>HTML</th>
					</tr></thead>";
	$body="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoPDF = "";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	foreach($factura->rows as $row)
	{	$aux++;
	}
	foreach($factura->rows as $row)
	{	if($c<($aux-1))
		{	$body.="<tr>";
			if ($tipo_documento=='FAC')
				$body.="<td class='details-control'><i style='color:green;' class='fa fa-plus-circle'></i></td>";
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
					$datos.="<tr><td><b>".$tipo_documento.":&nbsp;</b></td><td>". $archivo."</td></tr></table></div>";
				}
				elseif($x==6)
				{	$body.= "<td style='font-size:small;'>".
								"<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='glyphicon glyphicon-search'></span></span></td>";
					$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
				}
				elseif($x==11)
				{	//: do nothing
				}
				else
				{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
			$dir_archivos = $ruta_visor."/documentos/autorizados/".$_SESSION['directorio']."/".$cedula."/";
			$archivoPDF = $tipo_documento.$archivo .".PDF";
			$archivoXML = $tipo_documento.$archivo .".XML";
			$spanMail="<span class='glyphicon glyphicon-envelope cursorlink' id='".$codigo."_enviar_correo' 		 onmouseover='$(this).tooltip(".'"show"'.")' title='Enviar al e-mail del titular.' 	data-placement='left' onclick='reenvio_factura(".'"'.$codigo.'"'.",".'"modal_resend_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/VerDocumentosAutorizados/controller.php"'.")'  aria-hidden='true' data-toggle='modal' data-target='#modal_resend'></span>";
			$spanPDF= "<span class='glyphicon glyphicon-download cursorlink' id='".$row['codigoFactura']."_printPDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Descargar documento en PDF' 				data-placement='top'></span>";
			$spanXML= "<span class='glyphicon glyphicon-download cursorlink' id='".$row['codigoFactura']."_printXML' onmouseover='$(this).tooltip(".'"show"'.")' title='Descargar documento en XML' 				data-placement='bottom'></span>";
			$spanHTML="<span class='glyphicon glyphicon-print cursorlink'    id='".$codigo."_ver_factura' 			 onmouseover='$(this).tooltip(".'"show"'.")' title='Ver documento en HTML' 	  					data-placement='left'></span>";
			
			$body.="<td style='text-align:center'>".$spanMail."</td>";
			$body.="<td style='text-align:center'><a href=".$dir_archivos.$archivoXML." target='_blank'>".$spanXML."</a></td>";
			$body.="<td style='text-align:center'><a href=".$dir_archivos.$archivoPDF." target='_blank'>".$spanPDF."</a></td>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/".$dir_tdoc_detail."/".$codigo."' target='_blank'>".$spanHTML."</a></td>";
		}
		$body.="</tr>";
		$c++;
	}
	$construct_table.=$body;
	$construct_table.="</tbody></table>";
	return $construct_table;
}