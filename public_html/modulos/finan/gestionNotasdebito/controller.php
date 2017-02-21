<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('constants.php');
require_once '../../../includes/finan/proc_comp_elec.php';
require_once('../../finan/notaDebito/model.php');
require_once('../../finan/items/model.php');
require_once('view.php');

function handler() {
    require('../../../core/rutas.php');
    $factura = get_mainObject('notaDebito');
    $permiso = get_mainObject('General');
	$item = get_mainObject('Item');
    $event = get_actualEvents(array(VIEW_GET_ALL, GET_PENDING_BILLS, SEND_TO_SRI, RESEND_TO_SRI), VIEW_GET_ALL);
    $user_data = get_frontData();

    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event) {
		case VIEW_BADGE_NOTADEBITOS:
			$factura->get_menu_count_notasDebitoPendienteToSRI();
			if(count($factura->rows)-1>0)
			{	if($factura->rows[0]['notasDebito_pendientes']>0) print $factura->rows[0]['notasDebito_pendientes'];
			}
			break;
		case GET:
			$factura->getSingleNotaDebito($user_data['codigofactura']);
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
													<option '.$selected[0].' value="CI">Cédula</option>
													<option '.$selected[1].' value="RUC">RUC</option>
													<option '.$selected[2].' value="PAS">Pasaporte</option>
													<option '.$selected[3].' value="CF">Consumidor final</option>
													<option '.$selected[4].' value="IDE">Exterior</option>
													<option '.$selected[5].' value="PLC">Placa</option>
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
            $factura->get_notasDebito();
			$item->get_item_selectFormat('');
            $data['mensaje'] = "Notas de d&eacute;bito pendientes de envío al SRI";
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
			$data['{cmb_producto}'] = array("elemento"  => "combo", 
											"datos"     => $item->rows, 
                                            "options"   => array("name"=>"cmb_producto","id"=>"cmb_producto", "disabled"=>"disabled", "class"=>"form-control"),
											"selected"  => 0);
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DATA:
            #  CASE QUE SE CARGA AL INICIO DE LA PAGINA
            global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'ND';
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
				$prod_codigo = $user_data['prod_codigo'];
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
			
			$factura = new notaDebito();
			$factura->get_notasDebito( $estadoElectronico, $fechavenc_ini, $fechavenc_fin,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $ref_factura,
										$estado, $tneto_ini, $tneto_fin);
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
			retornar_result($data);
            break;
        case GET_PENDING_BILLS:
            $factura->get_notasDebito();
			$data['tabla'] = tablaFactura($tabla, $factura, $permiso);
            retornar_result($data);
            break;
        case SEND_TO_SRI:
			$data = enviar_nd_al_SRI($user_data['codigoDocumento'],'solo una', $ruta_documentosAutorizados, $user_data['enviar']);
            retornar_formulario(VIEW_RESULT_SRI, $data);
            break;
        case RESEND_TO_SRI:
			$data = autorizar_nd_al_SRI($user_data['codigoDocumento'], 'solo una',$ruta_documentosAutorizados);
            retornar_formulario(VIEW_RESULT_SRI, $data);
            break;
        default:
            //echo "Entro al default";
            break;
    }
}

handler();

function enviar_nd_al_SRI($codigo, $cuantas, $ruta_documentosAutorizados, $enviar)
{
	$notaCreditoInfo = new notaCredito();
	$notaCreditoInfo->getNotacreditoTrama($codigo);
	$notaCreditoResul = array();
	$notaCreditoResul = $notaCreditoInfo->rows;
	$notaCreditoCabe = array();
	$notaCreditoCabe=$notaCreditoResul[0];
	
	$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
	$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
	$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
	
	$configAplicacion = new configAplicacion();
	$configAplicacion->dirFirma = $_SESSION['rutallave'].$_SESSION['llaveactiva'];
	$configAplicacion->passFirma = $_SESSION['passllaveactiva'];
	$configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];
	
	//$configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinks_development/finan/documentos/autorizados";
	$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;		
	if($notaCreditoCabe['emailComprador'] != '')
	{
		$configCorreo = new configCorreo();
		$configCorreo->correoAsunto = "Notificación de documento electrónico generado";
		$configCorreo->correoHost = "smtp.gmail.com";
		$configCorreo->correoPass = "Redlinks12345";
		$configCorreo->correoPort = "587";
		$configCorreo->correoRemitente = "facturaelectronica.redlinks@gmail.com";
		$configCorreo->sslHabilitado = true;
	}
	
	$notaCredito = new notaCreditoSRI();
	$notaCredito->configAplicacion =  $configAplicacion;
	if($notaCreditoCabe['emailComprador'] != '')
	{
		$notaCredito->configCorreo =  $configCorreo;
	}
	$notaCredito->ambiente = $ambiente; //[1,Prueba][2,Produccion] 
	$notaCredito->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
	$notaCredito->razonSocial = $notaCreditoCabe['razonSocial']; //[Razon Social]
	$notaCredito->nombreComercial = $notaCreditoCabe['nombreComercial'];  //[Nombre Comercial, si hay]*
	$notaCredito->ruc = $notaCreditoCabe['ruc']; //[Ruc]
	$notaCredito->codDoc = "05"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
	$notaCredito->establecimiento = $notaCreditoCabe['establecimiento']; //[pto de emision ] **
	$notaCredito->ptoEmision = $notaCreditoCabe['ptoEmision']; // [Numero Establecimiento SRI]
	$notaCredito->secuencial = $notaCreditoCabe['secuencial']; // [Secuencia desde 1 (9)]
	$notaCredito->fechaEmision = $notaCreditoCabe['fechaEmision']; //[Fecha (dd/mm/yyyy)]
	$notaCredito->dirMatriz = $notaCreditoCabe['dirMatriz']; //[Direccion de la Matriz ->SRI]
	$notaCredito->dirEstablecimiento = $notaCreditoCabe['dirEstablecimiento']; //[Direccion de Establecimiento ->SRI]
	//$notaCredito->contribuyenteEspecial = "5368"; //[Ver SRI]
	$notaCredito->obligadoContabilidad = "SI"; // [SI]
	switch(rtrim(ltrim($notaCreditoCabe['tipoIdentificacionComprador'])))
	{
		case "CI":
			$tipoIdentificacionComprador="05";
		break;
		case "RUC":
			$tipoIdentificacionComprador="04";
		break;
		case "PAS":
			$tipoIdentificacionComprador="06";
		break;
		default:
			$tipoIdentificacionComprador="05";
		break;
	}

	$notaCredito->tipoIdentificacionComprador = $tipoIdentificacionComprador; //Info comprador [04, RUC][05,Cedula][06, Pasaporte][07, Consumidor final][08, Exterior][09, Placa]
	$notaCredito->razonSocialComprador = $notaCreditoCabe['razonSocialComprador']; //Razon social o nombres y apellidos comprador
	$notaCredito->identificacionComprador = $notaCreditoCabe['identificacionComprador']; // Identificacion Comprador
	$notaCredito->codDocModificado = "01";
	$notaCredito->numDocModificado = $notaCreditoCabe['numDocModificado'];
	$notaCredito->fechaEmisionDocSustento = $notaCreditoCabe['fechaEmisionDocSustento'];
	$notaCredito->totalSinImpuestos = $notaCreditoCabe['totalSinImpuestos'];
	$notaCredito->valorModificacion = $notaCreditoCabe['valorModificacion'];
	$notaCredito->moneda = "DOLAR";
	
	$baseimponible12=0;
	$iva12=0;
	$baseimponible0=0;
	$iva0=0;
	$detalleNC = array();
	
	foreach($notaCreditoResul as $notaCreditoDeta)
	{
		if($notaCreditoDeta['valorDetaIVA']>0)
		{
			$baseimponible12=$baseimponible12+$notaCreditoDeta['baseImponible'];
			$iva12=$iva12+$notaCreditoDeta['valorDetaIVA'];
		}else
		{
			$baseimponible0=$baseimponible0+$notaCreditoDeta['baseImponible'];
			$iva0=$iva0+$notaCreditoDeta['valorDetaIVA'];
		}
		
		$detalle = new detalleNotaCredito();
		$detalle->cantidad = $notaCreditoDeta['cantidad'];
		$detalle->codigoAdicional = $notaCreditoDeta['codigoAdicional'];
		$detalle->codigoInterno = " ".$notaCreditoDeta['codigoInterno'];
		$detalle->descripcion = " ".$notaCreditoDeta['descripcion'];
		$detalle->descuento = $notaCreditoDeta['descuento'];
		
		$detalle->precioUnitario = $notaCreditoDeta['precioUnitario'];
		$detalle->precioTotalSinImpuesto = $notaCreditoDeta['precioTotalSinImpuesto'];
		
		$impuestoDetalle = array();
		$impuesto = new impuesto(); // Impuesto del detalle
		$impuesto->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
		$impuesto->codigoPorcentaje = ($notaCreditoDeta['valorDetaIVA']>0?"2":"0");// IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
		$impuesto->tarifa = ($notaCreditoDeta['valorDetaIVA']>0?"12":"0");
		$impuesto->baseImponible = ($notaCreditoDeta['valorDetaIVA']>0?$baseimponible12:$baseimponible0);//suma de los totalesnetos(sinimpuesto) que tienen iva
		$impuesto->valor = ($notaCreditoDeta['valorDetaIVA']>0?$iva12:$iva0);//number_format($notaCreditoDeta['valorDetaIVA'],2);
		$impuestoDetalle[] = $impuesto;
		$detalle->impuestos = $impuestoDetalle;
					
		$detalleNC[]=$detalle;
	}
	$detalleNCnull=array_pop($detalleNC);
	$totalFinalImpuesto=array();
	$totalImpuesto = new totalImpuesto();
	$totalImpuesto->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
	$totalImpuesto->codigoPorcentaje = "2"; // IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
	$totalImpuesto->baseImponible = number_format($baseimponible12,2); // Suma de los impuesto del mismo cod y % (0.00)
	$totalImpuesto->valor = number_format($iva12,2); // Suma de los impuesto del mismo cod y % aplicado el % (0.00)
	$totalFinalImpuesto[]=$totalImpuesto;
	
	$totalImpuesto = new totalImpuesto();
	$totalImpuesto->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
	$totalImpuesto->codigoPorcentaje = "0"; // IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
	$totalImpuesto->baseImponible = number_format($baseimponible0,2); // Suma de los impuesto del mismo cod y % (0.00)
	$totalImpuesto->valor = number_format($iva0,2); // Suma de los impuesto del mismo cod y % aplicado el % (0.00)
	
	$totalFinalImpuesto[]=$totalImpuesto;
	
	$notaCredito->totalConImpuesto = $totalFinalImpuesto;
	
	
	
	$notaCredito->detalles = $detalleNC;
	$notaCredito->motivo = "ANULACION";
	
	$camposAdicionales = array();

	$campoAdicional = new campoAdicional();
	$campoAdicional->nombre = "alumno";
	$campoAdicional->valor = "Codigo: ".$notaCreditoCabe['codigoAlumno']." Nombres: ".$notaCreditoCabe['nombresAlumno'];
	$camposAdicionales[0] = $campoAdicional;
   
	if($notaCreditoCabe['emailComprador'] != '')
	{
		$campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "Email";
		$campoAdicional->valor = $notaCreditoCabe['emailComprador'];
		$camposAdicionales[1] = $campoAdicional;
	}else
	{
		$campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "Telefono";
		$campoAdicional->valor = $notaCreditoCabe['telefonoTitular'];
		$camposAdicionales[1] = $campoAdicional;
	}
	
	$notaCredito->infoAdicional = $camposAdicionales;

	if($tipoEmision==2)
	{//procesa comprobante por contingencia
		$procesarComprobante = new procesarComprobanteClaveContingencia();
		$procesarComprobante->comprobante = $notaCredito;
		$procesarComprobante->claveContingencia="";//si reenvio la factura la reenvio en mismo tipo de emision y la misma clave de contingencia.
		$res = $procesarComprobanteElectronico->procesarComprobanteClaveContingencia($procesarComprobante);
	}
	if($tipoEmision==1)
	{//procesa comprobante normalmente
		$procesarComprobante = new procesarComprobante();
		$procesarComprobante->comprobante = $notaCredito;
		$procesarComprobante->envioSRI = false;
		$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
	}
	if($enviar == true)
	{   if($res->return->estadoComprobante == "FIRMADO")
		{	$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $notaCredito;
			$procesarComprobante->envioSRI = true;
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
	}
	
	$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
	if ($mensaje=='') $mensaje='-n/a-';
	$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
	if ($informacionAdicional=='') $informacionAdicional='-n/a-';
	$numAutorizacion = (($res->return->numeroAutorizacion=='')? '-n/a-' : $res->return->numeroAutorizacion);
	if($enviar == true)
	{	$notaCreditoInfo->updNotaCreditoEstadoElec($res->return->estadoComprobante,$res->return->claveAcceso,$res->return->numeroAutorizacion,$codigo,$ambiente,$tipoEmision);
	}

	$documentosElectronicos[] = HTML::a('../documentos/autorizados/'.$_SESSION['directorio'].'/'.$notaCreditoCabe['identificacionComprador'].'/ND'.$notaCreditoCabe['establecimiento'].'-'.$notaCreditoCabe['ptoEmision'].'-'.str_pad($notaCreditoCabe['secuencial'], 9, "0", STR_PAD_LEFT).'.pdf',
										'Nota de cr&eacute;dito # '.$codigo).'<br>'.
										'<br><b>Datos del comprobante</b><br>'.
										'<br><table><tr><td width="25%" align="left"><b><small>Clave de Acceso:</b></td><td valign="top"><i><small>'.$res->return->claveAcceso.'</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>No. de autorización:</b></td><td valign="top"><small>'.$numAutorizacion.'</small></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Estado:</small></b></td><td valign="top"><i><small>'.$res->return->estadoComprobante.'.</small></i></td></tr>'.
										'<tr><td colspan="2"><hr/></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Mensaje:</small></b></td><td valign="top"><i><small>'.$mensaje.'.</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Información adicional:</small></b></td><td valign="top"><i><small>'.$informacionAdicional.'.</small></i></td></tr>'.
										'</table>';
	$data = array('tipo_mensaje' => ('alert-success'),
				  '{listEBills}' => array("elemento"  => "lista",
										  "datos"     => $documentosElectronicos,
										  "options"   => array("name" => "listDocumentosElectronicos",
															   "id" => "listDocumentosElectronicos",
															   "class" => "form-control")
										 )
				 );
	if($cuantas=='por lote')
	{	return $res->return->estadoComprobante;
	}
	elseif($cuantas=='solo una')
	{	return $data;
	}
}
function autorizar_nd_al_SRI($codigo, $cuantas, $ruta_documentosAutorizados)
{
	$notaCreditoBD = new notaCredito(); $detalleFact = array(); $cabeceraFactura = array();
	// Consulta de la factura generada
	$detalleFact = $notaCreditoBD->getNotacreditoTrama($codigo);
	$cabeceraFactura = $detalleFact[0];
	
	$notacredito_estado = new notaCredito();
	$estadoProcesandose='PROCESANDOSE';
	$notacredito_estado->set_estadoElectronico_estado($codigo, $estadoProcesandose);
	
	$ambiente = "1"; //[1,Prueba][2,Produccion]
	$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema

	// 1.- Creo el objeto que interactua con el servicio web
	$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
	// 2.- Configuración de variables del sistema de facturación electrónica
	$configAplicacion = new configAplicacion();
    $configAplicacion->dirFirma = $_SESSION['rutallave'].$_SESSION['llaveactiva'];
	//$configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinks_development/finan/includes/gustavo_alfonso_decker_zambrano.p12";
	$configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];
	$configAplicacion->passFirma = $_SESSION['passllaveactiva'];
	// $configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinks_development/finan/documentos/autorizados";
	$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;
	
	if($cabeceraFactura['emailTitular'] != '')
	{
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
	$comprobantesPendientes->codDoc = "05"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
	$comprobantesPendientes->configAplicacion =  $configAplicacion;
	//if($cabeceraFactura['emailTitular'] != ''){
	$comprobantesPendientes->configCorreo =  $configCorreo;
	//}
	$comprobantesPendientes->establecimiento = $cabeceraFactura['establecimiento']; // [Numero Establecimiento SRI]
	$comprobantesPendientes->fechaEmision = $cabeceraFactura['fechaEmision'];
	$comprobantesPendientes->ptoEmision = $cabeceraFactura['ptoEmision']; //[pto de emision ] **
	$comprobantesPendientes->ruc = $cabeceraFactura['ruc']; //[Ruc]
	$comprobantesPendientes->secuencial = $cabeceraFactura['secuencial']; // [Secuencia desde 1 (9)]
	$comprobantesPendientes->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema

	$procesarComprobante = new procesarComprobantePendiente();
	$procesarComprobante->comprobantePendiente = $comprobantesPendientes;
	$res = $procesarComprobanteElectronico->procesarComprobantePendiente($procesarComprobante);

	// Actualizo el estado en el comprobante
	$notaCreditoInfo = new notaCredito();
	$notaCreditoInfo->updNotaCreditoEstadoElec($res->return->estadoComprobante, $res->return->claveAcceso,$res->return->numeroAutorizacion,$codigo,$ambiente,$tipoEmision);

	$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
	if($mensaje=='') $mensaje='-n/a-';
	$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
	if ($informacionAdicional=='') $informacionAdicional='-n/a-';
	$numAutorizacion = (($res->return->numeroAutorizacion=='')? '-n/a-' : $res->return->numeroAutorizacion);
	$documentosElectronicos[] = HTML::a('../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/ND'.$cabeceraFactura['establecimiento'].'-'.$cabeceraFactura['ptoEmision'].'-'.str_pad($cabeceraFactura['secuencial'], 9, "0", STR_PAD_LEFT).'.pdf',
										'Nota de cr&eacute;dito # '.$codigo).'<br>'.
										'<br><b>Datos del comprobante</b><br>'.
										'<br><table><tr><td width="25%" align="left"><b><small>Clave de Acceso:</b></td><td valign="top"><i><small>'.$res->return->claveAcceso.'</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>No. de autorización:</b></td><td valign="top"><small>'.$numAutorizacion.'</small></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Estado:</small></b></td><td valign="top"><i><small>'.$res->return->estadoComprobante.'.</small></i></td></tr>'.
										'<tr><td colspan="2"><hr/></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Mensaje:</small></b></td><td valign="top"><i><small>'.$mensaje.'.</small></i></td></tr>'.
										'<tr><td align="left" valign="top"><b><small>Información adicional:</small></b></td><td valign="top"><i><small>'.$informacionAdicional.'.</small></i></td></tr>'.
										'</table>';

	$data = array('{listEBills}' => array(
										"elemento"  => "lista",
										"datos"     => $documentosElectronicos,
										"options"   => array("name" => "listDocumentosElectronicos",
															 "id" => "listDocumentosElectronicos",
															 "class" => "form-control")
									)
	);
	if($cuantas=='por lote')
	{	return $res->return->estadoComprobante;
	}elseif($cuantas=='solo una')
	{	return $data;
	}
}
function tablaFactura($tabla, $factura, $permiso)
{	global $diccionario;
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
					<thead><tr>
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
		{	$body.="<tr>";
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
					$datos.="<tr><td><b>Nota de cr&eacute;dito:&nbsp;</b></td><td>". $archivo."</td></tr></table></div>";
				}
				elseif($x==6)
				{	$onclick=" onclick='editar(".'"'.$codigo.'"'.",".'"'.$row['codigoAlumno'].'"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionNotasdebito/controller.php"'.",".'"'.$diccionario['rutas_head']['ruta_html_common'].'/representantes/controller.php"'.",true)' ";
					$spanEdit="<div align='center' style='display:inline-block;'><span ".$onclick." class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'   id='".$codigo."_editar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='top' title='Editar datos del titular.'></span></div>";
					$var_tooltip="<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='glyphicon glyphicon-search'></span></span>";
					$body.= "<td style='font-size:small;'>";
					
					if ($permiso2==true)
					{	$body.= $spanEdit;
					}
					$body.= "&nbsp;"."<a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/notaDebito/".$codigo."' target='_blank'>".$var_tooltip."</a>";
					$body.="</td>";
					$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
				}
				else
				{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
			$spanFirmar="<div align='center' style='display:inline-block;'><span   onclick='envio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionNotasdebito/controller.php"'.", 0)'    class='fa fa-pencil-square-o cursorlink'  aria-hidden='true' data-toggle='modal' data-target='#modal_send'   id='".$codigo."_firmar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Generar y firmar documento.'></span></div>";
			$spanAuto="<div align='center' style='display:inline-block;'><span   onclick='envio_factura(".'"'.$codigo.'"'.",".'"modal_send_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionNotasdebito/controller.php"'.", 1)'    class='btn_opc_lista_subir_SRI cursorlink'  aria-hidden='true' data-toggle='modal' data-target='#modal_send'   id='".$codigo."_enviar'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Enviar factura a autorizar al SRI.'></span></div>";
			$spanReen="<div align='center' style='display:inline-block;'><span onclick='reenvio_factura(".'"'.$codigo.'"'.",".'"modal_resend_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gestionNotasdebito/controller.php"'.")'  class='btn_opc_lista_reenviar glyphicon glyphicon-repeat cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_resend' id='".$codigo."_reenviar' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Reintentar autorizaci&oacute;n de factura.'></span></div>";
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