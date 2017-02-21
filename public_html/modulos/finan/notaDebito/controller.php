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
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, GET_CLIENT, VIEW_ADD_ND_VALUE), VIEW_GET_ALL);
	$user_data = get_frontData();

	switch ($event) {
	    case VIEW_GET_ALL:
    	  #  Presenta la pagina inicial
        global $diccionario;
        if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
        $permiso->permiso_activo($_SESSION['usua_codigo'], 134);
        if ($permiso->rows[0]['veri']==1)
        {
          $data['disabled_confirmar_nota_debito']="";
        } 
        else
        {
          $data['disabled_confirmar_nota_debito']="disabled='disabled'";
        }
        $tipoIdentificacion = array(0 => array(0=>'CI', 1=>'CEDULA'),
                                      1 => array(0=>'RUC', 1=>'RUC'),
                                      2 => array());    

        $data['{combo_tipoIdentificacion}'] = array("elemento"  => "combo", 
                                                    "datos"     => $tipoIdentificacion,
                                                    "options"   => array("name"=>"tipoIdentificacionTitular",
																		"id"=>"tipoIdentificacionTitular",
																		"required"=>"required",
																		"class"=>"form-control",
																		"style"=>"width:100%;"),
                                                    "selected"  => 0);
        $data['prefijoSucursal'] = '00';
        $data['prefijoPuntoVenta'] = '00';
      
        $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                  "clase"=>"table table-striped table-bordered",
                                                  "id"=>'deudasPendiente_table',
                                                  "datos"=>array(),
                                                  "encabezado" => array("Ref.",
                                                                        "No. FAC",
                                                                        "Valor Total",
																		"T. N/D",
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

        $data['{tabla_detalleNotaDebito}'] = array("elemento"=>"tabla",
                                                    "clase"=>"table table-striped table-hover",
                                                    "id"=>"detalleNotaDebito_table",
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
		    retornar_vista(VIEW_GET_ALL, $data);
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
        //$clientes = new notaDebito();
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
        retornar_result($data);
        break;
      case GET_DEUDAS_PENDIENTES:
        # Consulta las deudas de un cliente especifico
        global $diccionario;
		$opciones = array("Seleccionar" => "<span onclick='seleccionarDeuda(".'"{codigo}"'.",".'"resultadoDetalleFactura"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/notaDebito/controller.php"'.")' class='glyphicon glyphicon-circle-arrow-down cursorlink' aria-hidden='true' id='{codigo}_seleccionar' onmouseover='$(".'"#{codigo}_seleccionar"'.").tooltip(".'"show"'.")' title='Seleccionar'>&nbsp;</span>");
        
        $notaDebito = new notaDebito();
        $notaDebito->codigoAlumno = $user_data['codigoCliente'];
        $notaDebito->get_facturas_pagadas();

        $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                  "clase"=>"table table-striped table-bordered",
                                                  "id"=>'deudasPendiente_table',
                                                  "datos"=>$notaDebito->rows,
                                                  "encabezado" => array("Ref.",
                                                                        "No. FAC",
                                                                        "Valor Total",
																		"T. N/D",
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
        $resultado = $factura->getSingleFactura($user_data["codigoFactura"]);

        $data["cabecera"]["codigoFactura"] = $resultado[0]["codigoReferencial"];
        $data["cabecera"]["prefijoSucursal"] = $resultado[0]["prefijoSucursal"];
        $data["cabecera"]["prefijoPuntoVenta"] = $resultado[0]["prefijoPuntoVenta"];
        $data["cabecera"]["secuencialComprobante"] = $resultado[0]["secuencialComprobante"];
        $data["cabecera"]["totalAbonado"] = $resultado[0]["totalAbonado"];
        $data["cabecera"]["totalPendiente"] = $resultado[0]["totalPendiente"];
        $data["cabecera"]["totalNotaDebito"] = $resultado[0]["totalNotaDebito"];
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
                                "totalNDNetoDetalle"=>$registro["totalNDDetalle"],
                                "campoAccion"=>"<span data-idDetalle='".$registro["secuenciaDetalle"]."' onclick='mostrarReduccionDetalleDeuda(".'"'.$registro["secuenciaDetalle"].'"'.",".'"modal_addValorND_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/notaDebito/controller.php"'.")' class='fa fa-plus cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_addValorND' id='".$registro["secuenciaDetalle"]."_reducirDetalle' onmouseover='$(".'"#'.$registro["secuenciaDetalle"].'_reducirDetalle"'.").tooltip(".'"show"'.")' title='Reducir'>&nbsp;</span>"
                                );
                                //"campoAccion"=>"<input type='text' value='' placeholder='valor a reducir' data-idDetalle='".$registro["secuenciaDetalle"]."' onkeypress='return ((validaNumeros(event, this) && validaDesbordamientoND(event, this))? true : false);' />");
        }
        $datosTabla[] = array("codigoPrincipalProducto"=>null, "descripcionProducto"=>null, "precioUnitario"=>null, "cantidad"=>null, "descuentoDetalle"=>null, "totalIVADetalle"=>null, "totalNetoDetalle"=>null, "campoAccion"=>null);
        $tablaDetalle = HTML::table($datosTabla, $encabezadoTabla, "detalleFactura_table", "table table-striped table-hover", array(), "codigoPrincipalProducto", false);
        $data["detalle"] = $tablaDetalle;

        echo json_encode($data);
        break;
      case SET_NOTA_DEBITO:
        $notaDebito = new notaDebito();
        $datosNotaDebito = array();
        $datosNotaDebito = json_decode($user_data["datosNotaDebito"]);

        $totalIVA = 0; $totalDescuento = 0; $totalBruto = 0; $totalNeto = 0;
        foreach ($datosNotaDebito->detalle as $detalle) {
            $totalBruto += $detalle->valorBruto; 
            $totalDescuento += $detalle->valorDescuento;
            $totalIVA += $detalle->valorIVA; 
            $totalNeto += $detalle->valorNeto;
        }

        $lineaDetalle = 0;        
        $esquemaXML = '<?xml version="1.0" encoding="iso-8859-1"?>';
        $esquemaXML .= '<notaDebito>';
        $esquemaXML .=  '<cabecera ';
		
        $esquemaXML .=    'alumno="'.$datosNotaDebito->cabecera->codigoAlumno.'" ';
        $esquemaXML .=    'tipoIdentificacionTitular="'.trim($datosNotaDebito->cabecera->tipoIdentificacionTitular).'" ';
        $esquemaXML .=    'numeroIdentificacionTitular="'.$datosNotaDebito->cabecera->numeroIdentificacionTitular.'" ';
        $esquemaXML .=    'nombresTitular="'.$datosNotaDebito->cabecera->nombreTitular.'" ';
        $esquemaXML .=    'emailTitular="'.$datosNotaDebito->cabecera->emailTitular.'" ';
        $esquemaXML .=    'direccionTitular="'.$datosNotaDebito->cabecera->direccionTitular.'" ';
        $esquemaXML .=    'telefonoTitular="'.$datosNotaDebito->cabecera->telefonoTitular.'" ';
        
        $esquemaXML .=    'codigoFactura="'.$datosNotaDebito->cabecera->codigoFactura.'" ';

        $esquemaXML .=    'totalBruto="'.number_format($totalBruto, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalDescuento="'.number_format($totalDescuento, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalIVA="'.number_format($totalIVA, 2, '.',',' ).'" '; 
        $esquemaXML .=    'totalNeto="'.number_format($datosNotaDebito->cabecera->total, 2, '.',',' ).'" ';

        $esquemaXML .=    'usuario="'.$_SESSION['usua_codigo'].'" ';
        $esquemaXML .=    'codigoPeriodo="'.$_SESSION['peri_codi'].'" ';
        $esquemaXML .=  '/>';
        $esquemaXML .=  '<detalles>';
        foreach ($datosNotaDebito->detalle as $detalle) {
          $lineaDetalle += 1;
          $esquemaXML .=  '<linea ';
          $esquemaXML .=    'secuenciaNotaDebito="'.$lineaDetalle.'" ';
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
        $esquemaXML .= '</notaDebito>';

        $codigoND = $notaDebito->setNotaDebito($esquemaXML);
        $mensajeIngresoND = $notaDebito->mensaje.($notaDebito->codigo <= 0 ? $notaDebito->ErrorToString() : '');
        $documento = "";

        if($codigoND>0){
          $documento = HTML::a('../documento/imprimir/notaDebito/'.$codigoND, 'NOTA DE DÉBITO # '.$codigoND, array('target'=>'_blank'));
        }

        $data = array('tipo_mensaje' => ($codigoND > 0 ? 'alert-success' : 'alert-warning'),
                      'mensaje' => $mensajeIngresoND,
                      'notaDebitoDocumento' => $documento,
                      'resultado' => ($codigoND > 0 ? 'OK' : 'FAIL'),
					  'codigoND' => $codigoND
                     );
		
        retornar_formulario(VIEW_RESULT_NOTA_DEBITO, $data);
        break;
	case SEND_NOTA_DEBITO_SRI:
	
		//codigo para nota de debito electronica
		# =======================================================================
		# GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS
		# =======================================================================
		$comprobantes = array();
		$comprobantes[0]['codigoND']=$user_data['codigoND'];
		$respuesta = generaDocumentoElectronico($comprobantes,$_SESSION['llaveactiva'],$_SESSION['passllaveactiva'],$_SESSION['rutallave']);
		$documentosElectronicos = array();
		foreach ($respuesta as $doc => $resp) {
			$documentosElectronicos[] = HTML::a('#','Nota de d&eacute;bito # '.$resp['codigoND']).'<br>'.
													'<br><b>Estado:</b> <i><small>'.$resp['estado'].'.</small></i><br>'.
													$resp['mensajes']['mensaje'];
													
			//$documentosElectronicos[] = HTML::a('#','N/D. # '.$resp['codigoND'].' Estado: '.$resp['estado'].' Mensaje: '.$resp['mensajes']['mensaje']);
			$notaDebitoElec= new notaDebito();
			$notaDebitoElec->updNotaDebitoEstadoElec($resp['estado'],$resp['claveAcceso'],$resp['numeroAutorizacion'],$resp['codigoND'],$resp['ambiente'],$resp['tipoEmision']);
		}
		$data = array('tipo_mensaje' => ('alert-success'),
					  '{listEBills}' => array("elemento"  => "lista",
											  "datos"     => $documentosElectronicos,
											  "options"   => array("name" => "listDocumentosElectronicos",
																   "id" => "listDocumentosElectronicos",
																   "class" => "form-control")
											 )
					 );

		retornar_formulario(VIEW_RESULT_NOTA_DEBITO_ELEC, $data);
		# =======================================================================
		# / GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS /
		# =======================================================================
		break;
      case VIEW_ADD_ND_VALUE:
        $data["secuenciaDetalleFactura"] = $user_data["secuenciaDetalleFactura"];
        $data["codigoProducto"] = $user_data["codigoProducto"];
        $data["nombreProducto"] = $user_data["nombreProducto"];
        $data["descuento"] = $user_data["descuento"];
        $data["iva"] = $user_data["iva"];
        $data["valorBruto"] = $user_data["valorBruto"];
        $data["valorNeto"] = $user_data["valorNeto"];
        $data["valorND"] = $user_data["valorND"];

        
        retornar_formulario(VIEW_ADD_ND_VALUE, $data);
        break;
      default:
      	break;
  }
} // Fin de la funcion handler
function generaDocumentoElectronico($comprobantes = array(),$ruta,$clave,$dirllave){
	global $diccionario;
	$respuestaElectronica = array();
	foreach ($comprobantes as $documento) {
		
		//echo $documento['codigoND'];
		$notaDebitoInfo = new notaDebito();
		$notaDebitoInfo->getNotadebitoTrama($documento['codigoND']);
		$notaDebitoResul = array();
		$notaDebitoResul = $notaDebitoInfo->rows;
		$notaDebitoCabe = array();
		$notaDebitoCabe=$notaDebitoResul[0];
		
		$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
		$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
		$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
		
		$configAplicacion = new configAplicacion();
		    $configAplicacion->dirFirma = $dirllave.$ruta;
			//$configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinksprod/finan/includes/gustavo_alfonso_decker_zambrano.p12";
            $configAplicacion->dirLogo = "includes/logos/clientes/liceopanamericano/logo_inicial.png";
            $configAplicacion->passFirma = $clave;
		//$configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinksprod/finan/documentos/autorizados";
		$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;		
		if($notaDebitoCabe['emailComprador'] != ''){
			$configCorreo = new configCorreo();
			$configCorreo->correoAsunto = "Notificación de documento electrónico generado";
			$configCorreo->correoHost = "smtp.gmail.com";
			$configCorreo->correoPass = "Redlinks12345";
			$configCorreo->correoPort = "587";
			$configCorreo->correoRemitente = "facturaelectronica.redlinks@gmail.com";
			$configCorreo->sslHabilitado = true;
		}
		
		$notaDebito = new notaDebitoSRI();
		$notaDebito->configAplicacion =  $configAplicacion;
		if($notaDebitoCabe['emailComprador'] != ''){
			$notaDebito->configCorreo =  $configCorreo;
		}
		$notaDebito->ambiente = $ambiente; //[1,Prueba][2,Produccion] 
		$notaDebito->tipoEmision = $tipoEmision; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema
		$notaDebito->razonSocial = $notaDebitoCabe['razonSocial']; //[Razon Social]
		$notaDebito->nombreComercial = $notaDebitoCabe['nombreComercial'];  //[Nombre Comercial, si hay]*
		$notaDebito->ruc = $notaDebitoCabe['ruc']; //[Ruc]
		$notaDebito->codDoc = "05"; //[01, Factura] [04, Nota Credito] [05, Nota Debito] [06, Guia Remision] [07, Guia de Retencion]
		$notaDebito->establecimiento = $notaDebitoCabe['establecimiento']; //[pto de emision ] **
		$notaDebito->ptoEmision = $notaDebitoCabe['ptoEmision']; // [Numero Establecimiento SRI]
		$notaDebito->secuencial = $notaDebitoCabe['secuencial']; // [Secuencia desde 1 (9)]
		$notaDebito->fechaEmision = $notaDebitoCabe['fechaEmision']; //[Fecha (dd/mm/yyyy)]
		$notaDebito->dirMatriz = $notaDebitoCabe['dirMatriz']; //[Direccion de la Matriz ->SRI]
		$notaDebito->dirEstablecimiento = $notaDebitoCabe['dirEstablecimiento']; //[Direccion de Establecimiento ->SRI]
		//$notaDebito->contribuyenteEspecial = "5368"; //[Ver SRI]
		$notaDebito->obligadoContabilidad = "SI"; // [SI]
		switch(rtrim(ltrim($notaDebitoCabe['tipoIdentificacionComprador']))){
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

		$notaDebito->tipoIdentificacionComprador = $tipoIdentificacionComprador; //Info comprador [04, RUC][05,Cedula][06, Pasaporte][07, Consumidor final][08, Exterior][09, Placa]
		$notaDebito->razonSocialComprador = $notaDebitoCabe['razonSocialComprador']; //Razon social o nombres y apellidos comprador
		$notaDebito->identificacionComprador = $notaDebitoCabe['identificacionComprador']; // Identificacion Comprador
		$notaDebito->codDocModificado = "01";
		$notaDebito->numDocModificado = $notaDebitoCabe['numDocModificado'];
		$notaDebito->fechaEmisionDocSustento = $notaDebitoCabe['fechaEmisionDocSustento'];
		$notaDebito->totalSinImpuestos = $notaDebitoCabe['totalSinImpuestos'];
		$notaDebito->valorModificacion = $notaDebitoCabe['valorModificacion'];
		$notaDebito->moneda = "DOLAR";
		
		$baseimponible12=0;
		$iva12=0;
		$baseimponible0=0;
		$iva0=0;
		$detalleND = array();
		
		foreach($notaDebitoResul as $notaDebitoDeta){
			if($notaDebitoDeta['valorDetaIVA']>0){
				$baseimponible12=$baseimponible12+$notaDebitoDeta['baseImponible'];
				$iva12=$iva12+$notaDebitoDeta['valorDetaIVA'];
			}else{
				$baseimponible0=$baseimponible0+$notaDebitoDeta['baseImponible'];
				$iva0=$iva0+$notaDebitoDeta['valorDetaIVA'];
			}
			
			$detalle = new detalleNotaDebito();
			$detalle->cantidad = $notaDebitoDeta['cantidad'];
			$detalle->codigoAdicional = $notaDebitoDeta['codigoAdicional'];
			$detalle->codigoInterno = " ".$notaDebitoDeta['codigoInterno'];
			$detalle->descripcion = " ".$notaDebitoDeta['descripcion'];
			$detalle->descuento = $notaDebitoDeta['descuento'];
			
			$detalle->precioUnitario = $notaDebitoDeta['precioUnitario'];
			$detalle->precioTotalSinImpuesto = $notaDebitoDeta['precioTotalSinImpuesto'];
			
			$impuestoDetalle = array();
			$impuesto = new impuesto(); // Impuesto del detalle
			$impuesto->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
			$impuesto->codigoPorcentaje = ($notaDebitoDeta['valorDetaIVA']>0?"2":"0");// IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
			$impuesto->tarifa = ($notaDebitoDeta['valorDetaIVA']>0?"12":"0");
			$impuesto->baseImponible = ($notaDebitoDeta['valorDetaIVA']>0?$baseimponible12:$baseimponible0);//suma de los totalesnetos(sinimpuesto) que tienen iva
			$impuesto->valor = ($notaDebitoDeta['valorDetaIVA']>0?$iva12:$iva0);//number_format($notaDebitoDeta['valorDetaIVA'],2);
			$impuestoDetalle[] = $impuesto;
			$detalle->impuestos = $impuestoDetalle;
						
			$detalleND[]=$detalle;
		}
		$detalleNDnull=array_pop($detalleND);
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
		
		$notaDebito->totalConImpuesto = $totalFinalImpuesto;
		
		
		
		$notaDebito->detalles = $detalleND;
		$notaDebito->motivo = "ANULACION";
		
		$camposAdicionales = array();

		$campoAdicional = new campoAdicional();
		$campoAdicional->nombre = "alumno";
		$campoAdicional->valor = "Codigo: ".$notaDebitoCabe['codigoAlumno']." Nombres: ".$notaDebitoCabe['nombresAlumno'];
		$camposAdicionales[0] = $campoAdicional;
	   
		if($notaDebitoCabe['emailComprador'] != ''){
		  $campoAdicional = new campoAdicional();
		  $campoAdicional->nombre = "Email";
		  $campoAdicional->valor = $notaDebitoCabe['emailComprador'];
		  $camposAdicionales[1] = $campoAdicional;
		}else{
			$campoAdicional = new campoAdicional();
			$campoAdicional->nombre = "Telefono";
			$campoAdicional->valor = $notaDebitoCabe['telefonoTitular'];
			$camposAdicionales[1] = $campoAdicional;
		}
		
		$notaDebito->infoAdicional = $camposAdicionales;

		if($tipoEmision==2){//procesa comprobante por contingencia
			$procesarComprobante = new procesarComprobanteClaveContingencia();
			$procesarComprobante->comprobante = $notaDebito;
			$procesarComprobante->claveContingencia="";//si reenvio la factura la reenvio en mismo tipo de emision y la misma clave de contingencia.
			$res = $procesarComprobanteElectronico->procesarComprobanteClaveContingencia($procesarComprobante);
		}if($tipoEmision==1){//procesa comprobante normalmente
			$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $notaDebito;
			$procesarComprobante->envioSRI = false;  //nuevo campo, 2015-11-09.
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
		
		if($res->return->estadoComprobante == "FIRMADO")
		{	$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $notaDebito;
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
			"codigoND" =>$documento['codigoND'],
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