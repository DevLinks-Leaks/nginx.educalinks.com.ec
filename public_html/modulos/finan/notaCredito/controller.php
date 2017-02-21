<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once '../../../includes/finan/proc_comp_elec.php';
require_once('../../../core/modelHTML.php');
require_once('../facturas/model.php');

function handler() {
	require('../../../core/rutas.php');
	//$cobro = get_mainObject('Cobro');
	$permiso = get_mainObject('General');
	$clientes = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, GET_CLIENT, VIEW_ADD_NC_VALUE), VIEW_GET_ALL);
	$user_data = get_frontData();

	switch ($event) {
	    case VIEW_GET_ALL:
    	  #  Presenta la pagina inicial
        global $diccionario;
        if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
        $permiso->permiso_activo($_SESSION['usua_codigo'], 134);
        if ($permiso->rows[0]['veri']==1)
        {   $data['disabled_confirmar_nota_credito']="";
        } 
        else
        {   $data['disabled_confirmar_nota_credito']="disabled='disabled'";
        }
        $data['prefijoSucursal'] = '00';
        $data['prefijoPuntoVenta'] = '00';
      
        $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                  "clase"=>"table table-striped table-bordered",
                                                  "id"=>'deudasPendiente_table',
                                                  "datos"=>array(),
                                                  "encabezado" => array("Ref.",
                                                                        "No. FAC",
                                                                        "Valor Total",
																		"T. N/C",
                                                                        "Vence",
                                                                        "Opciones"),
                                                  "options"=>array(),
                                                  "campo"=>"",
                                                  "anidada"=>false);

        $data['{tabla_detalleFactura}'] = array("elemento"=>"tabla",
                                                "clase"=>"table table-striped table-hover",
                                                "id"=>"detalleFactura_table",
                                                "datos"=>array(),
                                                "encabezado" => array("Categoria",
                                                                      "Producto",
                                                                      "Precio",
                                                                      "Cantidad",
                                                                      "Descuento",
                                                                      "IVA",
                                                                      "Subtotal",
                                                                      "Valor a\nreducir"),
                                                                      "options"=>array(),
                                                                      "campo"=>"codigo");

        $data['{tabla_detalleNotaCredito}'] = array("elemento"=>"tabla",
                                                    "clase"=>"table table-striped table-hover",
                                                    "id"=>"detalleNotaCredito_table",
                                                    "datos"=>array(),
                                                    "encabezado" => array("Codigo\nProducto",
                                                                          "Producto",
                                                                          "Descripción",
                                                                          "Valor Bruto",
                                                                          "Descuento",
                                                                          "IVA",
                                                                          "Total",
                                                                          "Opciones"),
                                                                          "options"=>array(),
                                                                          "campo"=>"codigo");

		    $data["mensaje"] = "";
			$data['opciones_cliente']= " ";
			if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0){
				$data['disabled_caja']="disabled='disabled'";
				$data['mensaje'] = "Caja de hoy: cerrada/o mantiene caja abierta de días atrás.";
				retornar_vista(VIEW_CAJA_CERRADA, $data);
			}else{
				$data['disabled_caja']="";
				retornar_vista(VIEW_GET_ALL, $data);
			}
      	break;
	
      case VIEW_GET_CLIENT:
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
        //$clientes = new notaCredito();
        $clientes->get_clientes($user_data);
        $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                "clase" => "table table-striped table-hover",  
                                                "id"=> "clientes_table",  
                                                "datos"     => $clientes->rows,
                                                "encabezado" => array("Codigo",
                                                                      "Identificacion",
                                                                      "Nombres"),
                                                "options"   => array(),
                                                "campo"  => ""));
        retornar_result($datas);
        break;
      case GET_DEUDAS_PENDIENTES:
        # Consulta las deudas de un cliente especifico
        global $diccionario;
		$opciones = array("Seleccionar" => "<span onclick='seleccionarDeuda(".'"{codigo}"'.",".'"resultadoDetalleFactura"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/notaCredito/controller.php"'.")' class='glyphicon glyphicon-circle-arrow-down cursorlink' aria-hidden='true' id='{codigo}_seleccionar' onmouseover='$(".'"#{codigo}_seleccionar"'.").tooltip(".'"show"'.")' title='Seleccionar'>&nbsp;</span>");
        
        $notaCredito = new notaCredito();
        $notaCredito->codigoAlumno = $user_data['codigoCliente'];
        $notaCredito->get_facturas_pagadas();

        $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                  "clase"=>"table table-striped table-bordered",
                                                  "id"=>'deudasPendiente_table',
                                                  "datos"=>$notaCredito->rows,
                                                  "encabezado" => array("Ref.",
                                                                        "No. FAC",
                                                                        "Valor Total",
																		"T. N/C",
                                                                        "Vence",
                                                                        "Opciones"),
                                                  "options"=>array($opciones),
                                                  "campo"=>"cabeFact_codigo",
                                                  "anidada"=>false);
        retornar_result($data);
        break;
      case GET_FACTURA:
        global $diccionario;

        $factura = new factura();
        $resultado = $factura->getSingleFactura($user_data["codigoFactura"], $user_data["tipo_persona"]);

        $data["cabecera"]["codigoFactura"] = $resultado[0]["codigoReferencial"];
        $data["cabecera"]["prefijoSucursal"] = $resultado[0]["prefijoSucursal"];
        $data["cabecera"]["prefijoPuntoVenta"] = $resultado[0]["prefijoPuntoVenta"];
        $data["cabecera"]["secuencialComprobante"] = $resultado[0]["secuencialComprobante"];
        $data["cabecera"]["totalAbonado"] = $resultado[0]["totalAbonado"];
        $data["cabecera"]["totalPendiente"] = $resultado[0]["totalPendiente"];
        $data["cabecera"]["totalNotaCredito"] = $resultado[0]["totalNotaCredito"];
		$data["cabecera"]["totalSinImpuestos"] = $resultado[0]["totalSinImpuestos"];
        $data["cabecera"]["totalNeto"] = $resultado[0]["totalImporte"];
        $data["cabecera"]["nombreTitular"] = $resultado[0]["razonSocialComprador"];
        $data["cabecera"]["tipoIdentificacionTitular"] = $resultado[0]["tipoIdentificacionComprador"];
        $data["cabecera"]["identificacionTitular"] = $resultado[0]["identificacionComprador"];
        $data["cabecera"]["emailTitular"] = $resultado[0]["emailTitular"];
        $data["cabecera"]["direccionTitular"] = $resultado[0]["direccionTitular"];
        $data["cabecera"]["telefonoTitular"] = $resultado[0]["telefonoTitular"];

        $encabezadoTabla = array("Cód.\nProducto","Producto","Precio","Cantidad","Descuento","IVA","Subtotal", "N/C", "Reducir");
        $datosTabla = array();
        foreach ($resultado as $registro) {
          $datosTabla[] = array("codigoPrincipalProducto"=>$registro["codigoPrincipalProducto"], 
                                "descripcionProducto"=>$registro["descripcionProducto"], 
                                "precioUnitario"=>$registro["precioUnitario"], 
                                "cantidad"=>$registro["cantidad"], 
                                "descuentoDetalle"=>$registro["descuentoDetalle"], 
                                "totalIVADetalle"=>$registro["totalIVADetalle"], 
                                "totalNetoDetalle"=>$registro["totalNetoDetalle"],
                                "totalNCNetoDetalle"=>$registro["totalNCDetalle"],
                                "campoAccion"=>"<span data-idDetalle='".$registro["secuenciaDetalle"]."' onclick='mostrarReduccionDetalleDeuda(".'"'.$registro["secuenciaDetalle"].'"'.",".'"modal_addValorNC_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/notaCredito/controller.php"'.")' class='glyphicon glyphicon-minus cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_addValorNC' id='".$registro["secuenciaDetalle"]."_reducirDetalle' onmouseover='$(".'"#'.$registro["secuenciaDetalle"].'_reducirDetalle"'.").tooltip(".'"show"'.")' title='Reducir'>&nbsp;</span>"
                                );
                                //"campoAccion"=>"<input type='text' value='' placeholder='valor a reducir' data-idDetalle='".$registro["secuenciaDetalle"]."' onkeypress='return ((validaNumeros(event, this) && validaDesbordamientoNC(event, this))? true : false);' />");
        }
        $datosTabla[] = array("codigoPrincipalProducto"=>null, "descripcionProducto"=>null, "precioUnitario"=>null, "cantidad"=>null, "descuentoDetalle"=>null, "totalIVADetalle"=>null, "totalNetoDetalle"=>null, "campoAccion"=>null);
        $tablaDetalle = HTML::table($datosTabla, $encabezadoTabla, "detalleFactura_table", "table table-striped table-hover", array(), "codigoPrincipalProducto", false);
        $data["detalle"] = $tablaDetalle;

        echo json_encode($data);
        break;
      case SET_NOTA_CREDITO:
        $notaCredito = new notaCredito();
        $datosNotaCredito = array();
        $datosNotaCredito = json_decode($user_data["datosNotaCredito"]);

        $totalIVA = 0; $totalDescuento = 0; $totalBruto = 0; $totalNeto = 0;
        foreach ($datosNotaCredito->detalle as $detalle) {
            $totalBruto += $detalle->valorBruto; 
            $totalDescuento += $detalle->valorDescuento;
            $totalIVA += $detalle->valorIVA; 
            $totalNeto += $detalle->valorNeto;
        }

        $lineaDetalle = 0;        
        $esquemaXML = '<?xml version="1.0" encoding="iso-8859-1"?>';
        $esquemaXML .= '<notaCredito>';
        $esquemaXML .=  '<cabecera ';
		
        $esquemaXML .=    'alumno="'.$datosNotaCredito->cabecera->codigoAlumno.'" ';
        $esquemaXML .=    'tipoIdentificacionTitular="'.trim($datosNotaCredito->cabecera->tipoIdentificacionTitular).'" ';
        $esquemaXML .=    'numeroIdentificacionTitular="'.trim($datosNotaCredito->cabecera->numeroIdentificacionTitular).'" ';
        $esquemaXML .=    'nombresTitular="'.$datosNotaCredito->cabecera->nombreTitular.'" ';
        $esquemaXML .=    'emailTitular="'.$datosNotaCredito->cabecera->emailTitular.'" ';
        $esquemaXML .=    'direccionTitular="'.trim($datosNotaCredito->cabecera->direccionTitular).'" ';
        $esquemaXML .=    'telefonoTitular="'.$datosNotaCredito->cabecera->telefonoTitular.'" ';
        
        $esquemaXML .=    'codigoFactura="'.$datosNotaCredito->cabecera->codigoFactura.'" ';

        $esquemaXML .=    'totalBruto="'.number_format($totalBruto, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalDescuento="'.number_format($totalDescuento, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalIVA="'.number_format($totalIVA, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalNeto="'.number_format($datosNotaCredito->cabecera->total, 2, '.',',' ).'" ';

        $esquemaXML .=    'usuario="'.$_SESSION['usua_codigo'].'" ';
        $esquemaXML .=    'codigoPeriodo="'.$_SESSION['peri_codi'].'" ';
        $esquemaXML .=  '/>';
        $esquemaXML .=  '<detalles>';
        foreach ($datosNotaCredito->detalle as $detalle) {
          $lineaDetalle += 1;
          $esquemaXML .=  '<linea ';
          $esquemaXML .=    'secuenciaNotaCredito="'.$lineaDetalle.'" ';
          $esquemaXML .=    'secuenciaFactura="'.$detalle->secuenciaDetalle.'" ';
          $esquemaXML .=    'codigoProducto="'.$detalle->codigoProducto.'" ';
          $esquemaXML .=    'descripcion="'.$detalle->descripcion.'" ';
          $esquemaXML .=    'valorBruto="'.number_format($detalle->valorBruto, 2, '.',',' ).'" '; 
          $esquemaXML .=    'valorDescuento="'.number_format($detalle->valorDescuento, 2, '.',',' ).'" ';
          $esquemaXML .=    'valorIVA="'.number_format($detalle->valorIVA, 2, '.',',' ).'" '; 
          $esquemaXML .=    'valorNeto="'.number_format($detalle->valorNeto, 2, '.',',' ).'" ';
          $esquemaXML .=  '/>';
        }
        $esquemaXML .=  '</detalles>';
        $esquemaXML .= '</notaCredito>';

        $codigoNC = $notaCredito->setNotaCredito($esquemaXML);
        $mensajeIngresoNC = $notaCredito->mensaje.($notaCredito->codigo <= 0 ? $notaCredito->ErrorToString() : '');
        $documento = "";

        if($codigoNC>0){
          $documento = HTML::a('../../documento/imprimir/notaCredito/'.$codigoNC, 'NOTA DE CRÉDITO # '.$codigoNC, array('target'=>'_blank'));
        }

        $data = array('tipo_mensaje' => ($codigoNC > 0 ? 'alert-success' : 'alert-warning'),
                      'mensaje' => $mensajeIngresoNC,
                      'notaCreditoDocumento' => $documento,
                      'resultado' => ($codigoNC > 0 ? 'OK' : 'FAIL'),
					  'codigoNC' => $codigoNC
                     );
		
        retornar_formulario(VIEW_RESULT_NOTA_CREDITO, $data);
        break;
	case SEND_NOTA_CREDITO_SRI:
	
		//codigo para nota de credito electronica
		# =======================================================================
		# GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS
		# =======================================================================
		$comprobantes = array();
		$comprobantes[0]['codigoNC']=$user_data['codigoNC'];
		$respuesta = generaDocumentoElectronico($comprobantes,$_SESSION['llaveactiva'],$_SESSION['passllaveactiva'],$_SESSION['rutallave']);
		$documentosElectronicos = array();
		foreach ($respuesta as $doc => $resp) {
			$documentosElectronicos[] = HTML::a('#','Nota de cr&eacute;dito # '.$resp['codigoNC']).'<br>'.
													'<br><b>Estado:</b> <i><small>'.$resp['estado'].'.</small></i><br>'.
													$resp['mensajes']['mensaje'];
													
			//$documentosElectronicos[] = HTML::a('#','N/C. # '.$resp['codigoNC'].' Estado: '.$resp['estado'].' Mensaje: '.$resp['mensajes']['mensaje']);
			$notaCreditoElec= new notaCredito();
			$notaCreditoElec->updNotaCreditoEstadoElec($resp['estado'],$resp['claveAcceso'],$resp['numeroAutorizacion'],$resp['codigoNC'],$resp['ambiente'],$resp['tipoEmision']);
		}
		$data = array('tipo_mensaje' => ('alert-success'),
					  '{listEBills}' => array("elemento"  => "lista",
											  "datos"     => $documentosElectronicos,
											  "options"   => array("name" => "listDocumentosElectronicos",
																   "id" => "listDocumentosElectronicos",
																   "class" => "form-control")
											 )
					 );

		retornar_formulario(VIEW_RESULT_NOTA_CREDITO_ELEC, $data);
		# =======================================================================
		# / GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS /
		# =======================================================================
		break;
      case VIEW_ADD_NC_VALUE:
        $data["secuenciaDetalleFactura"] = $user_data["secuenciaDetalleFactura"];
        $data["codigoProducto"] = $user_data["codigoProducto"];
        $data["nombreProducto"] = $user_data["nombreProducto"];
        $data["descuento"] = $user_data["descuento"];
        $data["iva"] = $user_data["iva"];
        $data["valorBruto"] = $user_data["valorBruto"];
        $data["valorNeto"] = $user_data["valorNeto"];
        $data["valorNC"] = $user_data["valorNC"];

        
        retornar_formulario(VIEW_ADD_NC_VALUE, $data);
        break;
      default:
      	break;
  }
} // Fin de la funcion handler
function generaDocumentoElectronico($comprobantes = array(),$ruta,$clave,$dirllave){
	
	$respuestaElectronica = array();
	foreach ($comprobantes as $documento) {
		
		//echo $documento['codigoNC'];
		$notaCreditoInfo = new notaCredito();
		$notaCreditoInfo->getNotacreditoTrama($documento['codigoNC']);
		$notaCreditoResul = array();
		$notaCreditoResul = $notaCreditoInfo->rows;
		$notaCreditoCabe = array();
		$notaCreditoCabe=$notaCreditoResul[0];
		
		$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
		$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
		$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
		
		$configAplicacion = new configAplicacion();
		    $configAplicacion->dirFirma = $dirllave.$ruta;
			//$configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinksprod/finan/includes/gustavo_alfonso_decker_zambrano.p12";
            $configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];
            $configAplicacion->passFirma = $clave;
		//$configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinksprod/finan/documentos/autorizados";
		$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;		
		if($notaCreditoCabe['emailComprador'] != ''){
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
		if($notaCreditoCabe['emailComprador'] != ''){
			$notaCredito->configCorreo =  $configCorreo;
		}
		$notaCredito->ambiente = $ambiente; //[1,Prueba][2,Produccion] 
		$notaCredito->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
		$notaCredito->razonSocial = $notaCreditoCabe['razonSocial']; //[Razon Social]
		$notaCredito->nombreComercial = $notaCreditoCabe['nombreComercial'];  //[Nombre Comercial, si hay]*
		$notaCredito->ruc = $notaCreditoCabe['ruc']; //[Ruc]
		$notaCredito->codDoc = "04"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
		$notaCredito->establecimiento = $notaCreditoCabe['establecimiento']; //[pto de emision ] **
		$notaCredito->ptoEmision = $notaCreditoCabe['ptoEmision']; // [Numero Establecimiento SRI]
		$notaCredito->secuencial = $notaCreditoCabe['secuencial']; // [Secuencia desde 1 (9)]
		$notaCredito->fechaEmision = $notaCreditoCabe['fechaEmision']; //[Fecha (dd/mm/yyyy)]
		$notaCredito->dirMatriz = $notaCreditoCabe['dirMatriz']; //[Direccion de la Matriz ->SRI]
		$notaCredito->dirEstablecimiento = $notaCreditoCabe['dirEstablecimiento']; //[Direccion de Establecimiento ->SRI]
		//$notaCredito->contribuyenteEspecial = "5368"; //[Ver SRI]
		$notaCredito->obligadoContabilidad = "SI"; // [SI]
		switch(rtrim(ltrim($notaCreditoCabe['tipoIdentificacionComprador']))){
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
		
		foreach($notaCreditoResul as $notaCreditoDeta){
			if($notaCreditoDeta['valorDetaIVA']>0){
				$baseimponible12=$baseimponible12+$notaCreditoDeta['baseImponible'];
				$iva12=$iva12+$notaCreditoDeta['valorDetaIVA'];
			}else{
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
	   
		if($notaCreditoCabe['emailComprador'] != ''){
		  $campoAdicional = new campoAdicional();
		  $campoAdicional->nombre = "Email";
		  $campoAdicional->valor = $notaCreditoCabe['emailComprador'];
		  $camposAdicionales[1] = $campoAdicional;
		}else{
			$campoAdicional = new campoAdicional();
			$campoAdicional->nombre = "Telefono";
			$campoAdicional->valor = $notaCreditoCabe['telefonoTitular'];
			$camposAdicionales[1] = $campoAdicional;
		}
		
		$notaCredito->infoAdicional = $camposAdicionales;

		if($tipoEmision==2){//procesa comprobante por contingencia
			$procesarComprobante = new procesarComprobanteClaveContingencia();
			$procesarComprobante->comprobante = $notaCredito;
			$procesarComprobante->claveContingencia="";//si reenvio la factura la reenvio en mismo tipo de emision y la misma clave de contingencia.
			$res = $procesarComprobanteElectronico->procesarComprobanteClaveContingencia($procesarComprobante);
		}if($tipoEmision==1){//procesa comprobante normalmente
			$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $notaCredito;
			$procesarComprobante->envioSRI = false;  //nuevo campo, 2015-11-09.
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
		
		if($res->return->estadoComprobante == "FIRMADO")
		{	$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $notaCredito;
			$procesarComprobante->envioSRI = true;
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}

		$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
		if ($mensaje=='') $mensaje='-n/a-';
		$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
		if ($informacionAdicional=='') $informacionAdicional='-n/a-';
		$numAutorizacion = (($res->return->numeroAutorizacion=='')? '-n/a-' : $res->return->numeroAutorizacion);
		
		$respuestaElectronica[$documento['codigoDocumento']] = array(
			"estado" => $res->return->estadoComprobante,
			"ambiente" => $ambiente, //[1,Prueba][2,Produccion]
			"tipoEmision" => $tipoEmision, //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
			"codigoNC" =>$documento['codigoNC'],
			"claveAcceso" => $res->return->claveAcceso,
			"numeroAutorizacion" => $numAutorizacion ,
			"mensajes" => array("identificador" => $res->return->mensajes->identificador,
									  "mensaje" => "<b>Mensaje:</b> <i><small>".$mensaje.".</small></i><br>".
												   "<b>Información adicional</b>: <i><small>".$informacionAdicional.".</small></i><br>")
		);
		return $respuestaElectronica;
		//var_dump($respuestaElectronica);
		
	}
}
handler();