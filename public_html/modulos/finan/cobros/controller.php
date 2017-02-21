<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once '/../../../includes/finan/proc_comp_elec.php';
require_once('view.php');
require_once('../../../core/modelHTML.php');
require_once('../facturas/model.php');
require_once('../notaCredito/model.php');
require_once('../bancos/model.php');
require_once('../tarjetasCredito/model.php');
require_once('../pagos/model.php');
require_once('../contabilidad/model.php');
require_once('../../../Framework/funciones.php');

function handler()
{
	require('../../../core/rutas.php');
	$clientes 	= get_mainObject('General');
	$prontopago = get_mainObject('General');
	$cobro 		= get_mainObject('Cobro');
	$saldo 		= get_mainObject('Cobro');
	$cheques	= get_mainObject('Cobro');
	$event 		= get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, VIEW_SET_CLIENT, VIEW_GET_PRODUCT, VIEW_PRINT_FACT, GET_CLIENT,GET_DEUDAS_VENC_ANT), VIEW_GET_ALL);
	$user_data 	= get_frontData();
	$tarjCredito= get_mainObject('tarjCredito');
	$banco		= get_mainObject('Bancos');
	$pago		= get_mainObject('Pagos');
	$anioPeriodo= get_mainObject('Contabilidad');
	$curso		= get_mainObject('Contabilidad');
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "deudasPendiente_table";}else{$tabla =$_POST['tabla'];}
	
    switch ($event)
	{	case VIEW_COBRAR:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			$prontopago->get_prontopago();
			$pp=$general->prontopago;
			$data['hd_prontopago']=$pp;
      		$opciones = array("Seleccionar" => "<div style='text-align:center;'><span style='color:#668DE5;' onclick='validaFechaVencimiento(".'"{codigo}"'.",".'"resultadoPendientesCobro"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-circle-arrow-down cursorlink' aria-hidden='true'     id='{codigo}_seleccionar' onmouseover='$(".'"#{codigo}_seleccionar"'.").tooltip(".'"show"'.")' title='Seleccionar' data-placement='left'></span></div>");
                              //"MostrarDetalle" => "<span style='color:#668DE5;' onclick='mostrarDetalleDeuda(".'"{codigo}"'.",".'"modal_showDetails_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-eye-open cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_showDetails' id='{codigo}_mostrarDetalle' onmouseover='$(".'"#{codigo}_mostrarDetalle"'.").tooltip(".'"show"'.")' title='Mostrar detalle' data-placement='left'></span>&nbsp;&nbsp;&nbsp;",
                              //"MostrarPagos" => "<span style='color:#FFDC89;' onclick='mostrarPagosDeuda(".'"{codigo}"'.",".'"modal_showPayments_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-folder-open cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_showPayments' id='{codigo}_mostrarPago' onmouseover='$(".'"#{codigo}_mostrarPago"'.").tooltip(".'"show"'.")' title='Mostrar pagos' data-placement='left'></span></div>");
            $cobro->codigoCliente = $user_data['codigoCliente'];
			$cobro->tipo_persona = $user_data['tipo_persona'];
            $cobro->get_deudas();
            $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                      "clase"=>"table table-striped table-bordered",
                                                      "id"=>'deudasPendiente_table',
                                                      "datos"=>$cobro->rows,
                                                      "encabezado" => array("Código",
                                                                            "Deuda",
                                                                            "T. Inicial",
																			"Pronto Pago",
																			"Descuento",
                                                                            "I.V.A.",
                                                                            "Abono",
																			"T. N/C",
                                                                            "Pendiente",
                                                                            "Vence",
                                                                            "Opciones"),
                                                      "options"=>array($opciones),
                                                      "campo"=>"codigoDeuda",
                                                      "anidada"=>false);
			if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0)
			{   $data['disabled_caja']="disabled='disabled'";
				$data['mensaje'] = "Caja de hoy: cerrada/o mantiene caja abierta de días atrás.";
				retornar_vista(VIEW_CAJA_CERRADA, $data);
			}
			else
			{   $data['disabled_caja']="";
				//$data['mensaje'] = var_dump($_POST['nombresClientes']);
				retornar_vista(VIEW_GET_ALL, $data);
			}
		case VIEW_GET_ALL:
          #  Presenta la pagina inicial
		  /*if (!isset($user_data['cc']))
		  {
			$data['mensaje'] = "Comes here!.. and their code is: none.";
		  }
		  else
		  {
			  $data['mensaje'] = "Comes here!.. and their code is: ".$user_data['cc'].".";
			  $user_data['ni'];
			  $user_data['nc'];
		  }*/
			  
			global $diccionario;
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			$prontopago->get_prontopago();
			$pp=$general->prontopago;
			$data['hd_prontopago']=$pp;
      		$data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla",
                                                    "clase"=>"table table-striped table-bordered",
                                                    "id"=>'deudasPendiente_table',
                                                    "datos"=>array(),
                                                    "encabezado" => array(  "Código",
                                                                            "Deuda",
                                                                            "T. Inicial",
																			"Pronto Pago",
																			"Descuento",
                                                                            "I.V.A.",
                                                                            "Abono",
																			"T. N/C",
                                                                            "Pendiente",
                                                                            "Vence",
                                                                            "Opciones"),
                                                    "options"=>array(),
                                                    "campo"=>"",
                                                    "anidada"=>false);

			$data['{tabla_deudasSeleccionadas}'] = array("elemento"=>"tabla",
                                                       "clase"=>"table table-striped table-bordered",
                                                       "id"=>'deudasSeleccionadas_table',
                                                       "datos"=>array(),
                                                       "encabezado" => array(//"Secuencia",
                                                                             "Deuda",
                                                                             "Total",
                                                                             "Abono",
                                                                             "Remover"),
                                                       "options"=>array(),
                                                       "campo"=>"",
                                                       "anidada"=>false);

			$data['{tabla_pagos}'] = array("elemento"=>"tabla",
                                                       "clase"=>"table table-striped table-bordered",
                                                       "id"=>'pagos_table',
                                                       "datos"=>array(),
                                                       "encabezado" => array(//"Secuencia",
                                                                             "Forma de pago",
                                                                             "Total",
                                                                             "Editar",
                                                                             "Remover"),
                                                       "options"=>array(),
                                                       "campo"=>"",
                                                       "anidada"=>false);
			$data['opciones_cliente']= " ";
			
			if($_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0){
				$data['disabled_caja']="disabled='disabled'";
				$data['mensaje'] = "Caja de hoy: cerrada/o mantiene caja abierta de días atrás.";
				retornar_vista(VIEW_CAJA_CERRADA, $data);
			}else{
				$data['disabled_caja']="";
				//$data['mensaje'] = var_dump($_POST['nombresClientes']);
				retornar_vista(VIEW_GET_ALL, $data);
			}
            break;
        case VIEW_GET_CLIENT:
            # Presenta el modal de Busqueda del cliente
            $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-bordered",
                                                    "id"=> "clientes_table",  
                                                    "datos"     => array(),
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_formulario(VIEW_GET_CLIENT, $data);
            break;
		case GET_DEUDAS_VENC_ANT:
			global $diccionario;
			$cobro->get_deudasAnterioresVencidas($user_data['cabFact_codigo']);
			$json_deudas_vencidas=array();
			
			foreach($cobro->rows as $campo=>$valor){
				$json_deudas_vencidas[$campo]=$valor;
			}
			echo json_encode ($json_deudas_vencidas);
			break;
        case GET_CLIENT:
            # Consulta los clientes a traves de los filtros (nombres e identificacion) y devuelve la tabla con los resultados
            $clientes->get_clientes($user_data);
            $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-bordered",
                                                    "id"=> "clientes_table",  
                                                    "datos"     => $clientes->rows,
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_result($data);
            break;
		case MARCAR_PAGADO_CERO:
            $resultado = $cobro->deuda_marcar_pagado_cero( $user_data['deud_codigo'] );
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result( $data );
			break;
        case GET_DEUDAS:
            # Consulta las deudas de un cliente especifico
            global $diccionario;
			$opciones = array("Seleccionar" => "<div style='text-align:center;'><span style='color:#668DE5;' onclick='validaFechaVencimiento(".'"{codigo}"'.",".'"resultadoPendientesCobro"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-circle-arrow-down cursorlink' aria-hidden='true'     id='{codigo}_seleccionar' onmouseover='$(".'"#{codigo}_seleccionar"'.").tooltip(".'"show"'.")' title='Seleccionar' data-placement='left'></span></div>");
                              //"MostrarDetalle" => "<span style='color:#668DE5;' onclick='mostrarDetalleDeuda(".'"{codigo}"'.",".'"modal_showDetails_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-eye-open cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_showDetails' id='{codigo}_mostrarDetalle' onmouseover='$(".'"#{codigo}_mostrarDetalle"'.").tooltip(".'"show"'.")' title='Mostrar detalle' data-placement='left'></span>&nbsp;&nbsp;&nbsp;",
                              //"MostrarPagos" => "<span style='color:#FFDC89;' onclick='mostrarPagosDeuda(".'"{codigo}"'.",".'"modal_showPayments_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobros/controller.php"'.")' class=' glyphicon glyphicon-folder-open cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_showPayments' id='{codigo}_mostrarPago' onmouseover='$(".'"#{codigo}_mostrarPago"'.").tooltip(".'"show"'.")' title='Mostrar pagos' data-placement='left'></span></div>");
            $cobro->codigoCliente = $user_data['codigoCliente'];
			$cobro->tipo_persona = $user_data['tipo_persona'];
            $cobro->get_deudas();
            $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_deudas",
                                                      "clase"=>"table table-striped table-bordered",
                                                      "id"=>'deudasPendiente_table',
                                                      "datos"=>$cobro->rows,
                                                      "encabezado" => array("Código",
                                                                            "Deuda",
                                                                            "T. Inicial",
																			"Pronto Pago",
																			"Descuento",
                                                                            "I.V.A.",
                                                                            "Abono",
																			"T. N/C",
                                                                            "Pendiente",
                                                                            "Vence",
                                                                            "Seleccionar"),
                                                      "options"=>array($opciones),
                                                      "campo"=>"codigoDeuda",
                                                      "anidada"=>false);
			retornar_result($data);
            break;
        case VIEW_DETAILS_DEBT:
            $cobro->get_deudaDetails($user_data['codigoDeuda']);
            $data = array('{tablaDetalleDeudas}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-bordered",
                                                    "id"=> "deudasTable",  
                                                    "datos"     => $cobro->rows,
                                                    "encabezado" => array("Tipo Doc.",
                                                                          "Orden",
                                                                          "Item",
                                                                          "Precio",
                                                                          "Cantidad",
                                                                          "Descuento",
                                                                          "IVA",
                                                                          "Subtotal",
                                                                          "Estado"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_formulario(VIEW_DETAILS_DEBT, $data);
            break;
        case VIEW_DETAILS_PAYMENT:
            $cobro->get_pagosDeudaDetails($user_data['codigoDeuda']);
            $data = array('{tablaDetallePagosDeuda}' => array("elemento"  => "tabla",
                                                              "clase" => "table table-striped table-bordered",
                                                              "id"=> "pagosDetalleTable",  
                                                              "datos"     => $cobro->rows,
                                                              "encabezado" => array("Codigo Pago",
                                                                                    "Fecha",
                                                                                    "Total"),
                                                              "options"   => array(),
                                                              "campo"  => ""));
            retornar_formulario(VIEW_DETAILS_PAYMENT, $data);
            break;
        case VIEW_GET_PAYMENT_WAY:
            # Presenta el modal de Busqueda del cliente
            global $diccionario;
            $pago->get_formaPagoSelectFormat();
            $data = array('{combo_formaPago}' => array("elemento"  => "combo",
                                                       "datos"     => $pago->rows,
                                                       "options"   => array("name" => "formaPago_asign",
																			"id" => "formaPago_asign",
																			"required" => "required",
																			"class" => "form-control",
																			"onchange" => "carga_formularioMetadata('resultadoMetadata','".$diccionario['rutas_head']['ruta_html_finan']."/cobros/controller.php')",
																			"title"=> 'Elija',
																			"onmouseover"=> "$(this).tooltip(\"show\")",
																			"onfocus"=> "$(this).tooltip(\"show\")",
																			"data-placement"=>"right"),
                                                       "selected"  => 0),
                          'formulario_metadata' => '<div id="frm_pagoNones" class="form-horizontal" >
                                                      <div class="alert alert-info">
                                                        Seleccione una forma de pago para contirnuar...
                                                      </div>
                                                    </div>'
                          );

            retornar_formulario(VIEW_GET_PAYMENT_WAY, $data);
            break;
        case GET_METADATA_FORM:
		 $cobro->get_saldoafavor( $user_data['codigoCliente'], $user_data['tipo_persona'] );
            $data = array();
            switch (trim($user_data['formaPago']))
			{
				case 'EFECTIVO':
					if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
					{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
					}
					else
					{	retornar_formulario(VIEW_SET_CASH, $data);
					}
					break;
				case 'SALDOS A FAVOR':
					$data = array( 'saldo'=>$cobro->rows[0]['saldo']);
					retornar_formulario(VIEW_SET_SALDOAFAVOR, $data);
					break;
				case 'CHEQUE':
					if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
					{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
					}
					else
					{	$cheques->codigoCliente = $user_data['codigoCliente'];
						$cheques->get_chequesprotestados();
						$banco->get_bancoSelectFormat();
						$data = array( 'contadorcheques'=>$cheques->rows[0]['chequesprotestados'],											
									'{comboBanco}' => array("elemento"  => "combo",
									"datos"     => $banco->rows,
									"options"   => array(	"name" => "banco",
															"id" => "banco",
															"required" => "required",
															"class" => "form-control",
															"title"=> 'Elija&nbsp;un&nbsp;banco',
															"onmouseover"=> "$(this).tooltip('show')",
															"data-placement"=>"right"),
									"selected"  => 0) 
												);
						if($cheques->rows[0]['chequesprotestados']<1)
						{	retornar_formulario(VIEW_SET_CHEK, $data);
						}
						else
						{	retornar_formulario(VIEW_SET_CHEK_ALERT, $data);	
						}
					}
					break;            
				case 'TARJETA DE CREDITO':
				if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
				{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
				}
				else
				{	$tarjCredito->get_tarjetasCreditoSelectFormat();
					$data = array('{comboTarjetaCredito}' => array("elemento"  => "combo",
																   "datos"     => $tarjCredito->rows,
																   "options"   => array("name" => "tarjetaCredito",
																						"id" => "tarjetaCredito",
																						"required" => "required",
																						"class" => "form-control",
																						"title"=> 'Elija&nbsp;una&nbsp;tarjeta&nbsp;de&nbsp;cr&eacute;dito',
																						"onmouseover"=> "$(this).tooltip(\"show\")",
																						"onfocus"=> "$(this).tooltip(\"show\")",
																						"data-placement"=>"right"),
																   "selected"  => 0) 
								);
					retornar_formulario(VIEW_SET_CREDITCARD, $data);
				}
                break;
				case 'TRANSFERENCIA':
					if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
					{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
					}
					else
					{	$banco->get_bancoSelectFormat();
						$bancos = $banco->rows;
						$cobro->get_cuentasBancariasSelectFormat();
						$cuentasbancariasDestino = $cobro->rows;
						$data = array('{comboBanco}' => array("elemento"  => "combo",
															  "datos"     => $bancos,
															  "options"   => array( "name" => "banco",
																				    "id" => "banco",
																				    "required" => "required",
																					"class" => "form-control",
																					"title"=> 'Elija&nbsp;un&nbsp;banco',
																					"onmouseover"=> "$(this).tooltip(\"show\")",
																					"onfocus"=> "$(this).tooltip(\"show\")",
																					"data-placement"=>"right"),
															  "selected"  => 0),
									  '{comboCuentasDestino}' => array("elemento"  => "combo",
																	   "datos"     => $cuentasbancariasDestino,
																	   "options"   => array("name" => "cuentaDestino",
																							"id" => "cuentaDestino",
																							"required" => "required",
																							"class" => "form-control",
																							"title"=> 'Elija&nbsp;una&nbsp;cuenta&nbsp;de&nbsp;destino',
																							"onmouseover"=> "$(this).tooltip(\"show\")",
																							"onfocus"=> "$(this).tooltip(\"show\")",
																							"data-placement"=>"right"),
																	   "selected"  => 0) 
													);
						retornar_formulario(VIEW_SET_TX, $data);
					}
					break;
				case 'DEPOSITO':
					if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
					{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
					}
					else
					{	$banco->get_bancoSelectFormat();
						$bancos = $banco->rows;
						$cobro->get_cuentasBancariasSelectFormat();
						$cuentasbancariasDestino = $cobro->rows;
						$data = array('{comboBanco}' => array("elemento"  => "combo",
															  "datos"     => $bancos,
															  "options"   => array("name" => "banco",
																				   "id" => "banco",
																				   "required" => "required",
																				   "class" => "form-control",
																					"title"=> 'Elija&nbsp;un&nbsp;banco',
																					"onmouseover"=> "$(this).tooltip(\"show\")",
																					"onfocus"=> "$(this).tooltip(\"show\")",
																					"data-placement"=>"right"),
															  "selected"  => 0),
									  '{comboCuentasDestino}' => array("elemento"  => "combo",
																	   "datos"     => $cuentasbancariasDestino,
																	   "options"   => array("name" => "cuentaDestino",
																							"id" => "cuentaDestino",
																							"required" => "required",
																							"class" => "form-control",
																							"title"=> 'Elija&nbsp;una&nbsp;cuenta&nbsp;de&nbsp;destino',
																							"onmouseover"=> "$(this).tooltip(\"show\")",
																							"onfocus"=> "$(this).tooltip(\"show\")",
																							"data-placement"=>"right"),
																	   "selected"  => 0) 
													);
						retornar_formulario(VIEW_SET_ESCROW, $data);
					}
					break;
				case 'DOCUMENTO INTERNO':
					if( ( $cobro->rows[0]['saldo']!='0.00' ) && ( $cobro->rows[0]['saldo']!='' ) )
					{	retornar_formulario(VIEW_SET_MENSAJESALDOAFAVOR, $data);
					}
					else
					{	retornar_formulario(VIEW_SET_DOCINT, $data);
					}
					break;
				default:
					retornar_formulario(VIEW_NO_PAYMENT_WAY, $data);
					break;
            }
            break;
        case VIEW_EDIT_PAYMENT_WAY:
            $metadatos = json_decode($user_data['metadato'], true);
            switch (trim($metadatos['formaPago'])) {
              case 'EFECTIVO':
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'], 
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'efec_monto' => $metadatos['monto'],
                              'efec_observacion' => $metadatos['observacion']);
                retornar_formulario(VIEW_EDIT_CASH, $data);
                break;
              case 'CHEQUE':
                $banco->get_bancoSelectFormat();
                $bancos = $banco->rows;
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'],
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'cheq_numeroCheque' => $metadatos['numeroCheque'],
                              'cheq_numeroCuenta' => $metadatos['numeroCuenta'],
                              'cheq_nombreTitular' => $metadatos['titular'],
                              'cheq_nombreGirador' => $metadatos['girador'],
                              'cheq_fechaDeposito' => $metadatos['fechaDeposito'],
                              'cheq_monto' => $metadatos['monto'],
                              'cheq_observacion' => $metadatos['observacion'],
                              '{comboBanco}' => array("elemento"  => "combo",
                                                      "datos"     => $bancos,
                                                      "options"   => array("name" => "banco",
                                                                           "id" => "banco",
																		   "class" => "form-control",
                                                                           "required" => "required"),
                                                      "selected"  => $metadatos['banco'])
                              );
                retornar_formulario(VIEW_EDIT_CHEK, $data);
                break;
              case 'TARJETA CREDITO':
                $tarjCredito->get_tarjetasCreditoSelectFormat();
                $tarjetasCredito = $tarjCredito->rows;
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'],
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'tc_titular' => $metadatos['titular'],
                              'tc_numero' => $metadatos['numero'],
                              'tc_lote' => $metadatos['lote'],
                              'tc_referencia' => $metadatos['referencia'],
                              'tc_monto' => $metadatos['monto'],
							  //'tc_fechaCaducidad' => $metadatos['fechaCaducidad'],
                              'tc_observacion' => $metadatos['observacion'],
                              '{comboTarjetaCredito}' => array("elemento"  => "combo",
                                                               "datos"     => $tarjetasCredito,
                                                               "options"   => array("name" => "tarjetaCredito",
                                                                                    "id" => "tarjetaCredito",
                                                                                    "required" => "required",
																					"class" => "form-control",
																					"title"=> 'Elija&nbsp;una&nbsp;tarjeta&nbsp;de&nbsp;cr&eacute;dito',
																					"onmouseover"=> "$(this).tooltip(\"show\")",
																					"onfocus"=> "$(this).tooltip(\"show\")",
																					"data-placement"=>"right"),
                                                               "selected"  => $metadatos['tarjetaCredito'])
                              );
				if( $metadatos['red_de_pago'] == "D" )
					$data['TC_RP_selected_D'] = ' selected = "selected" ';
				if( $metadatos['red_de_pago'] == "M" )
					$data['TC_RP_selected_M'] = ' selected = "selected" ';
                retornar_formulario(VIEW_EDIT_CREDITCARD, $data);
                break;
              case 'DEPOSITO':
                $banco->get_bancoSelectFormat();
                $bancos = $banco->rows;
                $cobro->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $cobro->rows;
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'],
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'depo_numeroCuentaOrigen' => $metadatos['numeroCuentaOrigen'],
                              'depo_referencia' => $metadatos['referencia'],
                              'depo_fechaTransaccion' => $metadatos['fechaTransaccion'],
                              'depo_monto' => $metadatos['monto'],
                              'depo_observacion' => $metadatos['observacion'],
                              '{comboBanco}' => array("elemento"  => "combo",
                                                      "datos"     => $bancos,
                                                      "options"   => array( "name" => "banco",
                                                                            "id" => "banco",
                                                                            "required" => "required",
																			"class" => "form-control",
																			"title"=> 'Elija&nbsp;un&nbsp;banco&nbsp;de&nbsp;origen',
																			"onmouseover"=> "$(this).tooltip(\"show\")",
																			"onfocus"=> "$(this).tooltip(\"show\")",
																			"data-placement"=>"right"),
                                                      "selected"  => $metadatos['banco']),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required",
																					"class" => "form-control",
																					"title"=> 'Elija&nbsp;una&nbsp;cuenta&nbsp;de&nbsp;destino',
																					"onmouseover"=> "$(this).tooltip(\"show\")",
																					"onfocus"=> "$(this).tooltip(\"show\")",
																					"data-placement"=>"right"),
                                                               "selected"  => $metadatos['numeroCuentaDestino']) 
                              );
                retornar_formulario(VIEW_EDIT_ESCROW, $data);
                break;
              case 'TRANSFERENCIA':
                $banco->get_bancoSelectFormat();
                $bancos = $banco->rows;
                $cobro->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $cobro->rows;
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'],
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'tx_numeroCuentaOrigen' => $metadatos['numeroCuentaOrigen'],
                              'tx_referencia' => $metadatos['referencia'],
                              'tx_fechaTransaccion' => $metadatos['fechaTransaccion'],
                              'tx_monto' => $metadatos['monto'],
                              'tx_observacion' => $metadatos['observacion'],
                              '{comboBanco}' => array("elemento"  => "combo",
                                                      "datos"     => $bancos,
                                                      "options"   => array("name" => "banco",
                                                                           "id" => "banco",
                                                                           "required" => "required",
																		   "class" => "form-control",
																			"title"=> 'Elija&nbsp;un&nbsp;banco',
																			"onmouseover"=> "$(this).tooltip(\"show\")",
																			"onfocus"=> "$(this).tooltip(\"show\")",
																			"data-placement"=>"right"),
                                                      "selected"  => $metadatos['banco']),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required",
																					"class" => "form-control",
																					"title"=> 'Elija&nbsp;una&nbsp;cuenta&nbsp;de&nbsp;destino',
																					"onmouseover"=> "$(this).tooltip(\"show\")",
																					"onfocus"=> "$(this).tooltip(\"show\")",
																					"data-placement"=>"right"),
                                                               "selected"  => $metadatos['numeroCuentaDestino']) 
                              );
                retornar_formulario(VIEW_EDIT_TX, $data);
                break;
			  case 'DOCUMENTO INTERNO':
                $data = array('codigoFormaPago'		=> $metadatos['codigoFormaPago'], 
                              'nombreFormaPago' 	=> $metadatos['formaPago'],
                              'idPago' 				=> $user_data['idPago'],
                              'doc_int_monto' 		=> $metadatos['monto'],
                              'doc_int_detalle' 	=> $metadatos['detalle'],
                              'doc_int_observacion' => $metadatos['observacion']);
				retornar_formulario(VIEW_EDIT_DOCINT, $data);
				default:
					# code...
                break;
            }
            $data = array();
            break;
        case VIEW_RESULT_PAYMENT:
            $datosPago = array();
			
            $datosPago = json_decode($user_data['datosPago'], true);

            $lineaDetalle = 0;
            $esquemaXML = '<?xml version="1.0" encoding="iso-8859-1"?>';
            $esquemaXML .= '<cobro>';
            $esquemaXML .=  '<cabecera ';
            $esquemaXML .=    'cliente="'.$datosPago['cabecera']['codigoCliente'].'" ';
			
			$esquemaXML .=    'TP="'.$datosPago['cabecera']['tipoPersona'].'" ';
            $esquemaXML .=    'montoTotal="'.$datosPago['cabecera']['total'].'" ';
            $esquemaXML .=    'usuario="'.$_SESSION['usua_codigo'].'" ';
            $esquemaXML .=    'puntoVenta="'.$_SESSION['puntVent_codigo'].'" ';
            $esquemaXML .=  "/>";
            $esquemaXML .=  '<detalles>';
            foreach ($datosPago['detalle'] as $detalle)
			{
				$lineaDetalle += 1;
				$esquemaXML .=  '<linea ';
				$esquemaXML .=    'secuencia="'.$lineaDetalle.'" ';
				$esquemaXML .=    'formaPago="'.$detalle['formaPago'].'" ';
				$esquemaXML .=    'codigoFormaPago="'.$detalle['codigoFormaPago'].'" ';
				$esquemaXML .=    'monto="'.$detalle['monto'].'" ';
				$esquemaXML .=  '>';
				$metadato = $detalle['metadato'];
				$esquemaXML .=  '<metadato linea="'.$lineaDetalle.'" ';
				switch ($detalle['formaPago'])
				{
					case 'EFECTIVO':
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
						break;
					case 'DEPOSITO':
						$esquemaXML .=    'banco="'.$metadato['banco'].'" ';    
						$esquemaXML .=    'numeroCuentaOrigen="'.$metadato['numeroCuentaOrigen'].'" ';    
						$esquemaXML .=    'numeroCuentaDestino="'.$metadato['numeroCuentaDestino'].'" ';    
						$esquemaXML .=    'referencia="'.$metadato['referencia'].'" ';    
						$esquemaXML .=    'fechaTransaccion="'.$metadato['fechaTransaccion'].'" ';    
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
						break;
					case 'CHEQUE':
						$esquemaXML .=    'banco="'.$metadato['banco'].'" ';   
						$esquemaXML .=    'numeroCheque="'.$metadato['numeroCheque'].'" ';   
						$esquemaXML .=    'numeroCuenta="'.$metadato['numeroCuenta'].'" ';   
						$esquemaXML .=    'girador="'.$metadato['girador'].'" ';   
						$esquemaXML .=    'titular="'.$metadato['titular'].'" ';   
						$esquemaXML .=    'fechaDeposito="'.$metadato['fechaDeposito'].'" ';   
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
						break;
					case 'TARJETA CREDITO':
						$esquemaXML .=    'tarjetaCredito="'.$metadato['tarjetaCredito'].'" ';
						$esquemaXML .=    'numero="'.$metadato['numero'].'" ';
						$esquemaXML .=    'titular="'.$metadato['titular'].'" ';
						$esquemaXML .=    'lote="'.$metadato['lote'].'" ';
						$esquemaXML .=    'referencia="'.$metadato['referencia'].'" ';
						//$esquemaXML .=    'fechaCaducidad="'.$metadato['fechaCaducidad'].'" ';
						$esquemaXML .=    'red_de_pago="'.$metadato['red_de_pago'].'" ';
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';
						break;
					case 'SALDOS FAVOR':
						break;
					case 'TRANSFERENCIA':
						$esquemaXML .=    'banco="'.$metadato['banco'].'" ';    
						$esquemaXML .=    'numeroCuentaOrigen="'.$metadato['numeroCuentaOrigen'].'" ';    
						$esquemaXML .=    'numeroCuentaDestino="'.$metadato['numeroCuentaDestino'].'" ';    
						$esquemaXML .=    'referencia="'.$metadato['referencia'].'" ';    
						$esquemaXML .=    'fechaTransaccion="'.$metadato['fechaTransaccion'].'" ';  
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
						break;
					case 'DOCUMENTO INTERNO':
						$esquemaXML .=    'detalle="'.$metadato['detalle'].'" ';
						$esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';
						break;
				}
				$esquemaXML .=  ' />';
				$esquemaXML .=  ' </linea>';
            }
            $esquemaXML .=  "</detalles>";

            $lineaDetalle = 0;
            $esquemaXML .=  '<deudasAfectadas>';
            foreach ($datosPago['deudasAfectadas'] as $deuda)
			{
				$lineaDetalle += 1;
				$esquemaXML .=  '<linea ';
				$esquemaXML .=    'secuencia="'.$lineaDetalle.'" ';
				$esquemaXML .=    'codigoDeuda="'.$deuda['codigoDeuda'].'" ';
				$esquemaXML .=    'monto="'.$deuda['abono'].'" ';
				$esquemaXML .=    'prontopago="'.$deuda['prontopago'].'" ';
				$esquemaXML .=  ' />';
            }
            $esquemaXML .=  "</deudasAfectadas>";
            $esquemaXML .= "</cobro>";
			
            $cobro->setPago( $esquemaXML, $user_data['valor'] );
			$codigoPago = $cobro->codigoPago;
			$pago_seteado = $cobro->rows;
            $mensajeIngresoPago = $cobro->mensaje.( $codigoPago <= 0 ? $cobro->ErrorToString() : '' );
				
            # =======================================================================
            # GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS (HTML, PDF, NO AUTORIZADOS)
            # =======================================================================
			
			$documentos = array();
			$docFac = array();
			//$comprobantes = array();
			if($codigoPago>0)
			{	//$comprobantes = $cobro->get_documentosGenerados($codigoPago);
				$documentos[] = "PAGO #".$codigoPago." ".HTML::a('../documento/imprimir/pago/'.$codigoPago, 'HTML', array('target'=>'_blank')). " - <a id='aPagoPdf' href='../PDF/imprimir/pago/".$codigoPago."' target='_blank'>PDF</a>";
				foreach ($pago_seteado as $documento)
				{	if( !empty( $documento ) )
					{   if( $documento['deudaEstado'] == 'P')
						{   $documentos[] = HTML::a('../documento/imprimir/'.(trim($documento['tipoDocumento']) == 'FAC'? 'factura' : 'notaDebito').'/'.	
							$documento['codigoDocumento'], (trim($documento['tipoDocumento']) == 'FAC'? 'FACTURA' : 'NOTA DÉBITO').' #'.
							$documento['codigoDocumento'], array('target'=>'_blank'));	
							$docFac[] = $documento['codigoDocumento'];
						}
					}
				}
            }
            $data = array('tipo_mensaje' => ($codigoPago > 0 ? 'alert-success' : 'alert-warning'),
                          'mensaje' => $mensajeIngresoPago,
                          '{headlistBills}' => array("elemento"  => "lista",
                                                 "datos"     => ($codigoPago > 0 ? '¡&Eacute;xito!' : '¡Error!'),
                                                 "options"   => array("name" 	=> "listDocumentos",
                                                                      "id" 		=> "listDocumentos",
                                                                      "class" 	=> "form-control")
                                                 ),
						  '{listBills}' => array("elemento"  => "lista",
                                                 "datos"     => $documentos,
                                                 "options"   => array("name" 	=> "listDocumentos",
                                                                      "id" 		=> "listDocumentos",
                                                                      "class"	=> "form-control")
                                                 ),
						  'codigopago' 	=> $codigoPago,
                          'resultado' 	=> ($codigoPago > 0 ? 'OK' : 'FAIL')
                         );
			if( count( $docFac ) > 1 )
                $data['codigoFC'] = "";
			else if( count( $docFac ) == 1 )

                $data['codigoFC'] = $docFac[0];
			else if( count( $docFac ) <= 0 )
                $data['codigoFC'] = "no tiene";
            retornar_formulario(VIEW_RESULT_PAYMENT, $data);
            break;
		case SEND_FACTURA_SRI:
		
			//codigo para nota de credito electronica
			# =======================================================================
			# GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS
			# =======================================================================
		
			$comprobantes = array();
			$comprobantes[0]['codigoFC']=$user_data['codigoFC'];
         
			if($user_data['cheque']!=1 )
			{	$envio_sri = para_sist(507);
				if( $envio_sri == 'S' )
				{   $respuesta = generaDocumentoElectronico($comprobantes,$_SESSION['llaveactiva'],$_SESSION['passllaveactiva'],$_SESSION['rutallave']);
					$documentosElectronicos = array();
					foreach ($respuesta as $doc => $resp)
					{	$documentosElectronicos[] = HTML::a($resp['mail'],
															'Factura Electr&oacute;nica # '.$resp['codigoFC']).'<br>'.
															'<br><b>Estado:</b> <i><small>'.$resp['estado'].'.</small></i><br>'.
															$resp['mensajes']['mensaje'];
					}
					$data = array('tipo_mensaje' => ('alert-success'),
								  '{listEBills}' => array("elemento"  => "lista",
															  "datos"     => $documentosElectronicos,
															  "options"   => array("name" => "listDocumentosElectronicos",
																				   "id" => "listDocumentosElectronicos",
																				   "class" => "form-control")
															 )
								 );
				}
				else
				{   $data[ 'listEBills' ] ='<div class="callout callout-info">
								<h4><strong><li class="fa fa-exclamation"></li> Factura generada</strong></h4>
								Su factura ha sido enviada a la bandeja de <a href=\'../gestionFacturas/\'> gestión facturas</a>, '.
								'para su posterior envío al sistema de Comprobantes electrónicos del SRI.
							</div>';
				}
			}
			retornar_formulario(VIEW_RESULT_PAYMENT_ELEC, $data);
			# =======================================================================
			# / GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS /
			# =======================================================================
			break;
		case PRINTREPVISOR:
			echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$cobranza_data['url'].'"></iframe>
				</div>';
			break;
		case PRINT_PDF_PAGO:
			global $diccionario;
			$codigoPago=0;
			if (isset($_POST['codigoPago']))
			{	$codigoPago = $_POST['codigoPago'];
			}
			var_dump($codigoPago);
			$cobro = new Cobro();
			$datosPago = $cobro->get_infoPago($user_data['codigo']);
			$deudasAfectadas = $cobro->get_deudasAfectadas($user_data['codigo']);
			$detallePagos = $cobro->get_detallePagos($user_data['codigo']);
		
			$tabla_deudasAfectadas.="
				<table id='deudasAfectadasTable' border='1'>".
					"<thead>".
						"<th style='text-align:center'>Cod. Deuda</th>".
						"<th style='text-align:center'>Tipo</th>".
						"<th style='text-align:center'>Total deuda</th>".
						"<th style='text-align:center'>Total descto.</th>".
						"<th style='text-align:center'>Estado</th>".
					"</thead>".
					"<tbody>";
					
			foreach($deudasAfectadas->rows as $rows)
			{	$tabla_deudasAfectadas.="<tr>";
				foreach($rows as $colums)
				{
					$tabla_deudasAfectadas.="<td>".$colums."</td>";
				}
				$tabla_deudasAfectadas.="</tr>";
			}
			$tabla_deudasAfectadas.="
					</tbody>
				</table>";
				
			$tabla_detallePagos.="
				<table id='deudasAfectadasTable' border='1'>
					<thead>
						<th style='text-align:center'>Forma de Pago</th>".
						"<th style='text-align:center'>Total</th>".
					"</thead>
					<tbody>";
					
			foreach($detallePagos->rows as $rows)
			{	$tabla_detallePagos.="<tr>";
				foreach($rows as $colums)
				{
					$tabla_detallePagos.="<td>".$colums."</td>";
				}
				$tabla_detallePagos.="</tr>";
			}
			$tabla_detallePagos.="
					</tbody>
				</table>";
			
			generar_pago_PDF($diccionario['rutas_head']['ruta_main'].$_SESSION['print_dir_logo_cliente'], $datosPago[0]['codigoCliente'], 
							$datosPago[0]['nombresCliente'], $datosPago[0]['identificacionCliente'], $datosPago[0]['codigoPago'],
							$datosPago[0]['fechaEmision'], $datosPago[0]['usuario'], $tabla_deudasAfectadas, $tabla_detallePagos);
			
			break;
        case VIEW_BILL:
            // EVENTO QUE CONSULTA EL DOCUMENTO Y LO PRESENTA
            switch ($user_data['tipo'])
			{
				case 'factura':
					global $diccionario;
					$factura = new Factura();
					$total_0 = $subtotal_0 = 0; $subtotal_12 = 0; $totalDescuento = 0; $totalDescuentoConIVA = 0; $totalNeto = 0;

					$datosFactura = $factura->getSingleHeader($user_data['codigo']);
					$detalleFactura = $factura->getDetails($user_data['codigo']);

					foreach ($detalleFactura as $detalle)
					{	if( $detalle['ivaDetalle'] > 0 )
						{	$subtotal_12 += $detalle['brutoDetalle'];
							$totalDescuentoConIVA += $detalle['descuentoDetalle'];
							$total_0 += $detalle['netoDetalle'];
						}
						else
						{	$subtotal_0 += $detalle['brutoDetalle'];
							$total_0 += $detalle['netoDetalle'];
						}
						$totalDescuento += $detalle['descuentoDetalle'];
					}
					$totalNeto = $total_0;

					$data = array("subtitulo"=>"Factura",
								  "proyecto"=>$diccionario['rutas_head']['proyecto'],
								  "ruta_logoEmpresa"=>$diccionario['rutas_head']['ruta_main'].$_SESSION['print_dir_logo_cliente'],
								  "nombreComercial_empresa"=>$datosFactura[0]['nombreComercial'],
								  "direccion_matrizEmpresa"=>$datosFactura[0]['direccionMatriz'],
								  "direccion_sucursalEmpresa"=>$datosFactura[0]['direccionSucursal'],
								  "no_contribuyenteEspecial"=>$_SESSION['contribuyente_especial'],
								  "contabilidad_obligada"=>"NO HAY",
								  "ruc_empresa"=>$datosFactura[0]['ruc'],
								  "prefijo_sucursal"=>$datosFactura[0]['prefijoSucursal'],
								  "prefijo_puntoVenta"=>$datosFactura[0]['prefijoPuntoVenta'],
								  "secuencia_factura"=>$datosFactura[0]['secuenciaFactura'],
								  "numero_autorizacion"=>$datosFactura[0]['autorizacion'],
								  "fechaHora_autorizacion"=>$datosFactura[0]['fechaAutorizacion'],
								  "ambiente_emision"=>$datosFactura[0]['tipoEmision'],
								  "tipo_emision"=>$datosFactura[0]['tipoAmbiente'],
								  "clave_acceso"=>$datosFactura[0]['claveAcceso'],
								  "nombres_titular"=>$datosFactura[0]['nombresTitular'],
								  "identificacion_titular"=>$datosFactura[0]['identificacionTitular'],
								  "fecha_emision"=>$datosFactura[0]['fechaEmision'],
								  "guia_remision"=>"",
								  "nombre_cliente"=>$datosFactura[0]['nombresCliente'],
								  "telefono_cliente"=>$datosFactura[0]['telefonoTitular'],
								  "direccion_cliente"=>$datosFactura[0]['direccionTitular'],
								  "email_cliente"=>$datosFactura[0]['emailTitular'],
								  "{tabla_detalleFactura}"=> array("elemento"  => "tablaSencilla",
																   "datos"     => $detalleFactura,
																   "encabezado" => array("Cod. </br>Principal",
																						 "Cant.",
																						 "Descripción",
																						 "Precio </br>Producto",
																						 "Total  </br>Bruto",
																						 "Descuento",
																						 "IVA",
																						 "ICE",
																						 "Total  </br>Neto"),
																   "atributos"   => array("border"=>"1", "id"=>"detalleTable")),
								  "subtotal_12"=>'$ '.number_format($subtotal_12, 2, '.', ','),
								  "subtotal_0"=>'$ '.number_format($subtotal_0, 2, '.', ','),
								  "subtotal_noObjetoIVA"=>"$ 00.00",
								  "subtotal_exentoIVA"=>"$ 00.00",
								  "subtotal_sinImpuestos"=>'$ '.number_format(($subtotal_0 + $subtotal_12), 2, '.', ','),
								  "total_descuento"=>'$ '.number_format($totalDescuento, 2, '.', ','),
								  "total_ice"=>"$ 00.00",
								  "total_iva"=>'$ '.$datosFactura[0]['totalIVA'],
								  "irbpnr"=>"$ 00.00",
								  "propina"=> "$ 00.00",
								  "total_neto"=>'$ '. number_format($totalNeto, 2, '.', ',')
								  );
					
					retornar_pagina(PRINT_BILL, $data);   
					break;
				case 'pago':
					global $diccionario;
					$cobro = new Cobro();
					$datosPago = $cobro->get_infoPago($user_data['codigo']);
					$deudasAfectadas = $cobro->get_deudasAfectadas($user_data['codigo']);
					$detallePagos = $cobro->get_detallePagos($user_data['codigo']);
					$dp=array();
					$i=0;
					foreach ($detallePagos as $rows)
					{
						$dp[$i][0]=$rows['formaPago'];
						$dp[$i][1]=$rows['totalPago'];
						$i++;
					}
					$data = array("subtitulo"=>"Pago",
								  "proyecto"=>$diccionario['rutas_head']['proyecto'],
								  'total'=> "$ ".number_format($datosPago[0]['total'], 2, '.', ','),
								  "codigoCliente"=> $datosPago[0]['codigoCliente'],
								  "ruta_logoEmpresa"=> $diccionario['rutas_head']['ruta_main'].$_SESSION['print_dir_logo_cliente'],
								  "nombresCliente"=> $datosPago[0]['nombresCliente'],
								  "identificacionCliente"=> $datosPago[0]['identificacionCliente'],
								  "codigoPago"=> $datosPago[0]['codigoPago'],
								  "fechaEmision"=> $datosPago[0]['fechaEmision'],
								  "nombreUsuario"=> $datosPago[0]['usuario'],
								  "{tabla_deudasAfectadas}"=> array("elemento"  => "tablaSencilla", 
																   "datos"     => $deudasAfectadas,
																   "encabezado" => array("Cod. Deuda",
																						 "Tipo",
																						 "Total deuda",
																						 "Total Dscto.",
																						 "Descripción",
																						 "Estado"),
																   "atributos" => array("border"=>"1","id"=>"deudasAfectadasTable")),
								  "{tabla_detallePagos}"=> array("elemento"  => "tablaSencilla", 
																 "datos"     => $dp,
																 "encabezado"=> array("Forma de Pago",
																					   "Monto"),
																 "atributos" => array("border"=>"1","id"=> "pagosTable"))
								  );

					retornar_pagina(PRINT_PAYMENT, $data);
					break;
				case 'notaCredito':
					global $diccionario;
					$notaCredito = new notaCredito();
					$subtotal_0 = 0; $subtotal_12 = 0; $totalIVA = 0; $totalDescuento = 0; $totalDescuentoConIVA = 0; $totalNeto = 0;

					$datosNotaCredito = $notaCredito->getSingleHeader($user_data['codigo']);
					$detalleNotaCredito = $notaCredito->getDetails($user_data['codigo']);

					foreach ($detalleNotaCredito as $detalle)
					{	if($detalle['ivaDetalle'] > 0)
						{	$subtotal_12 += $detalle['brutoDetalle'];
							$totalDescuentoConIVA += $detalle['descuentoDetalle'];
							$totalIVA += $detalle['ivaDetalle'];
						}
						else
						{	$subtotal_0 += $detalle['brutoDetalle'];
						}
						$totalDescuento += $detalle['descuentoDetalle'];
					}
					$totalNeto = $datosNotaCredito[0]['totalNeto'];

					$data = array("subtitulo"=>"Nota de crédito",
								  "proyecto"=>$diccionario['rutas_head']['proyecto'],
								  "ruta_logoEmpresa"=> $diccionario['rutas_head']['ruta_main'].$_SESSION['print_dir_logo_cliente'],
								  "nombreComercial_empresa"=>$datosNotaCredito[0]['nombreComercial'],
								  "direccion_matrizEmpresa"=>$datosNotaCredito[0]['direccionMatriz'],
								  "direccion_sucursalEmpresa"=>$datosNotaCredito[0]['direccionSucursal'],
								  "no_contribuyenteEspecial"=>$_SESSION['contribuyente_especial'],
								  "contabilidad_obligada"=>"NO HAY",
								  "ruc_empresa"=>$datosNotaCredito[0]['ruc'],
								  "prefijo_sucursal"=>$datosNotaCredito[0]['prefijoSucursal'],
								  "prefijo_puntoVenta"=>$datosNotaCredito[0]['prefijoPuntoVenta'],
								  "secuencia_factura"=>$datosNotaCredito[0]['secuenciaFactura'],
								  "numero_autorizacion"=>$datosNotaCredito[0]['autorizacion'],
								  "fechaHora_autorizacion"=>$datosNotaCredito[0]['fechaAutorizacion'],
								  "ambiente_emision"=>$datosNotaCredito[0]['tipoEmision'],
								  "tipo_emision"=>$datosNotaCredito[0]['tipoAmbiente'],
								  "clave_acceso"=>$datosNotaCredito[0]['claveAcceso'],
								  "nombres_titular"=>$datosNotaCredito[0]['nombresTitular'],
								  "identificacion_titular"=>$datosNotaCredito[0]['identificacionTitular'],
								  "fecha_emision"=>$datosNotaCredito[0]['fechaEmision'],
								  "doc_modifica"=>$datosNotaCredito[0]['codigoFactura'],
								  "nombre_cliente"=>$datosNotaCredito[0]['nombresCliente'],
								  "telefono_cliente"=>$datosNotaCredito[0]['telefonoTitular'],
								  "direccion_cliente"=>$datosNotaCredito[0]['direccionTitular'],
								  "email_cliente"=>$datosNotaCredito[0]['emailTitular'],
								  "{tabla_detalleFactura}"=> array("elemento"  => "tablaSencilla",
																   "datos"     => $detalleNotaCredito,
																   "encabezado" => array("Cod. </br>Principal",
																						 "Cant.",
																						 "Descripción",
																						 "Precio </br>Unitario",
																						 "Descuento",
																						 "IVA",
																						 "Precio Total"),
																   "atributos"   => array("border"=>"1", "id"=>"detalleTable")),
								  "subtotal_12"=>'$ '.number_format($subtotal_12, 2, '.', ','),
								  "subtotal_0"=>'$ '.number_format($totalNeto, 2, '.', ','),
								  "subtotal_noObjetoIVA"=>"$ 00.00",
								  "subtotal_exentoIVA"=>"$ 00.00",
								  "subtotal_sinImpuestos"=>'$ '.number_format(($totalNeto), 2, '.', ','),
								  "total_descuento"=>'$ '.number_format($totalDescuento, 2, '.', ','),
								  "total_ice"=>"$ 00.00",
								  "total_iva"=>'$ '.number_format($totalIVA, 2, '.', ','),
								  "irbpnr"=>"$ 00.00",
								  "propina"=> "$ 00.00",
								  "total_neto"=>'$ '. number_format($totalNeto, 2, '.', ',')
								  );
					retornar_pagina(PRINT_NOTA_CREDITO, $data); 
					break;
				
				default:
					break;
            }
            break;
		# =======================================================================
			# /Migracion Contifico /
			# =======================================================================
			case MIGRARFACTURAS:
			
			//migrar deuda
			$anioPeriodo->get_deudas_individualmigracion($banco_data['codigodeuda']);
			$datos1 =array();
			$datos2 =array();
			$datos['id']=$anioPeriodo->rows[0]['idcontifico'];
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
			$curso->getdetallefactura($anioPeriodo->rows[0]['descripcion']);
		
			for($a=0;$a<=count($curso->rows)-2;$a++){
				$datos['detalles']=array(array('producto_id'=>$curso->rows[$a]['id_contifico'],'cantidad'=>$curso->rows[$a]['cantidad'],'precio'=>$curso->rows[$a]['precio'],'porcentaje_iva'=>$curso->rows[$a]['iva'],'porcentaje_descuento'=>$curso->rows[$a]['descuento'],'base_cero'=>$curso->rows[$a]['basecero'],'base_gravable'=>$curso->rows[$a]['basegravable'],'base_no_gravable'=>$curso->rows[$a]['basenogravable']));
			}
			
		
			
		    $data['datosdoc'] = $datos;
			$jsondeudas= json_encode($data['datosdoc']);
			
			//migrar pago
			
			$alumnos->getdetallepago($banco_data['codigodeuda'],$banco_data['codigofactura']);
			$codigocontifico=  $alumnos->rows[0]['codigodeuda'];
			for($b=0;$b<=count($alumnos->rows)-2;$b++){
				$datos=(array('forma_cobro'=>$alumnos->rows[$b]['formapago'],'monto'=>$alumnos->rows[$b]['monto'],'numero_cheque'=>$alumnos->rows[$b]['chequenumero'],'tipo_ping'=>$alumnos->rows[$b]['tipoping']));
			}
		    $data['datosdoc'] = $datos;
			$jsondeudas= json_encode($data['datosdoc']);
			
			
			
			$data = array('cantidaddeudas' => count($data['datosdoc']),'deudas'=> $jsondeudas,'codigodeuda'=> $datos['descripcion']);		
        default:
        	break;
    }
}

/*
 * Realiza la generación de las facturas electrónicas a través del web service
 */
function generaDocumentoElectronico($comprobantes = array(),$ruta,$clave,$dirllave)
{   $respuestaElectronica = array();
	
	foreach ($comprobantes as $documento)
	{
		$facturaBD = new Factura(); $detalleFact = array(); $cabeceraFactura = array();
			
		// Consulta de la factura generada
		$detalleFact = $facturaBD->get_facturaToFormatXML($documento['codigoFC']);
		$cabeceraFactura = $detalleFact[0];
		
		$ambiente = $_SESSION['ambiente']; //[1,Prueba][2,Produccion]
		$tipoEmision = "1"; //[1,Emision Normal][2,Emision Por Indisponibilidad del sistema

		// Acumulo del detalle de la factura los valores CON  iva y los valores SIN iva para el detalle del impuesto posterior
		$baseImponibleConIVA = 0;   $baseImponibleSinIVA = 0;
		foreach ($detalleFact as $registro) {
			if($registro["totalIVADetalle"]>0){
				$baseImponibleConIVA += $registro["precioTotalSinImpuesto"];
			}else{
				$baseImponibleSinIVA += $registro["precioTotalSinImpuesto"];
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
		$ruta_completa=$dirllave.$ruta;
		if(file_exists($ruta_completa)){$existeruta="OK";}else{$existeruta="KO".$ruta_completa;}
		
		// 1.- Creo el objeto que interactua con el servicio web
		$procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
		// 2.- Configuración de variables del sistema de facturación electrónica
		$configAplicacion = new configAplicacion();
		$configAplicacion->dirFirma = $dirllave.$ruta;
		//$configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinksprod/finan/includes/gustavo_alfonso_decker_zambrano.p12";
		$configAplicacion->dirLogo = $_SESSION['dir_logo_cliente'];
		$configAplicacion->passFirma = $clave;
		//$configAplicacion->passFirma = "Gustavo123";
		//$configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinksprod/finan/documentos/autorizados";
		$configAplicacion->dirAutorizados = $ruta_documentosAutorizados;
		if($cabeceraFactura['emailTitular'] != '')
		{   $configCorreo = new configCorreo();
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
		if($cabeceraFactura['emailTitular'] != ''){
			$factura->configCorreo =  $configCorreo;
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
		if($baseImponibleConIVA > 0){
			$totalIVA12 = new totalImpuesto();
			$totalIVA12->codigo = "2"; // [2, IVA][3,ICE][5, IRBPNR]
			$totalIVA12->codigoPorcentaje = "2"; // IVA -> [0, 0%][2, 12%][6, No objeto de impuesto][7, Exento de IVA] ICE->[Tabla 19]
			$totalIVA12->baseImponible = number_format($baseImponibleConIVA, 2, '.', ''); // Suma de los impuesto del mismo cod y % (0.00)
			$totalIVA12->valor = number_format($cabeceraFactura['totalIVA'], 2, '.', ''); // Suma de los impuesto del mismo cod y % aplicado el % (0.00)
			$impuestosCabecera[] = $totalIVA12;
		}
		// 4.2.- Acumulado del IVA 0%
		if($baseImponibleSinIVA > 0){
			$totalIVA0 = new totalImpuesto();
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
		
		// Forma de pago
		$pagos = array();
			
		// Consulta de las formas de pago de la factura 
		$pagosBD = $facturaBD->get_facturaToFormatXML_pagos( $documento['codigoFC'] );
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
		foreach ($detalleFact as $linea) {
			$detalleFactura = new detalleFactura();
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
			$impuesto->codigoPorcentaje = ($linea['totalIVADetalle']>0? "2" : "0" );
			$impuesto->tarifa = ($linea['totalIVADetalle']>0? "12" : "0" );
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
		if( $tipoEmision == 2 )
		{	//procesa comprobante por contingencia
			$procesarComprobante = new procesarComprobanteClaveContingencia();
			$procesarComprobante->comprobante = $factura;
			$procesarComprobante->claveContingencia="";//si reenvio la factura la reenvio en mismo tipo de emision y la misma clave de contingencia.
			$res = $procesarComprobanteElectronico->procesarComprobanteClaveContingencia($procesarComprobante);
		}
		if( $tipoEmision == 1 )
		{	//procesa comprobante normalmente
			$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $factura;
			$procesarComprobante->envioSRI = false; //nuevo campo, 2015-11-09.
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
		if($res->return->estadoComprobante == "FIRMADO")
		{	$procesarComprobante = new procesarComprobante();
			$procesarComprobante->comprobante = $factura;
			$procesarComprobante->envioSRI = true;
			$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
		}
		$mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
		if ($mensaje=='') $mensaje='<i>-n/a-</i>';
		$informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
		if ($informacionAdicional=='') $informacionAdicional='<i>-n/a-</i>';
		/*
		$cabeceraFactura['identificacionComprador'];
		$cabeceraFactura['prefijoSucursal'];
		$cabeceraFactura['prefijoPuntoVenta'];
		$cabeceraFactura['secuencialComprobante'];
		*/
		$respuestaElectronica[$documento['codigoDocumento']] = array("estado" => $res->return->estadoComprobante,
																	 "mail" => '../documentos/autorizados/'.$_SESSION['directorio'].'/'.$cabeceraFactura['identificacionComprador'].'/FAC'.$cabeceraFactura['prefijoSucursal'].'-'.$cabeceraFactura['prefijoPuntoVenta'].'-'.str_pad($cabeceraFactura['secuencialComprobante'], 9, "0", STR_PAD_LEFT).'.pdf',
																	 "codigoFC" => $documento['codigoFC'],
																	 "claveAcceso" => $res->return->claveAcceso,
																	 "numeroAutorizacion" => $res->return->numeroAutorizacion,
																	 "mensajes" => array("identificador" => $res->return->mensajes->identificador,
																						 "mensaje" => 	'<b>Mensaje:</b> <i><small>'.$mensaje.'.</small></i><br>'.
																										'<b>Información adicional</b>: <i><small>'.$informacionAdicional.'.</small></i><br>'
																	)
		);
		
		$fact = new Factura();
		$fact->set_estadoElectronico($documento['codigoFC'], $res->return->estadoComprobante, $res->return->numeroAutorizacion, $res->return->claveAcceso, $tipoEmision, $ambiente);
    }
    return $respuestaElectronica;
}
function generar_pago_PDF($ruta_logo, $codCliente, $nombresCliente, $idCliente, $codigoPago, $total,
							$fechaEmision, $nombreUsuario)
{   $datosInst = new General();
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='Pago no. ".$codigoPago." de ".$nombresCliente.".pdf'");
	$width=200;
	$height=600;
	$pagelayout = array($width, $height); //  or array($, $width) 
	
	$pdf = new MYPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
	//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
	$pdf->SetCreator("Redlinks");
	$pdf->SetAuthor("Redlinks");
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->SetFont('Helvetica', '', 10, '', 'false');
	$pdf->SetMargins(5, 5, 5, true);
	$pdf->AddPage('P', $pagelayout);//P:Portrait, L=Landscape
	//$pdf->SetXY(110, 200);
	//$pdf->Image($ruta_logo, '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
	$datosInst->getDatosInstitucion_info();
	$html .= '
	<div id="contenedor">
		<br>
		<br>
		<table>
			<tr><td align="center" width="175px"><strong>'.$datosInst->rows[0]['empr_razonSocial'].'</strong></td></tr>
			<tr><td align="center" width="175px" style="font-size:small;"><strong>RUC:</strong> '.$datosInst->rows[0]['empr_ruc'].'</td></tr>
			<tr><td align="center" width="175px" style="font-size:small;"><strong>Dirección:</strong> '.$datosInst->rows[0]['empr_direccionMatriz'].'</td></tr>
			<tr><td align="center" width="175px" style="font-size:small;"><strong>Telf.:</strong> '.$datosInst->rows[0]['empr_contactoTelefono'].'</td></tr>
		</table>
		<br>
		<br>
		<table border="0">
			<tr>
				<td width="75px"><b></b></td>
				<td width="100px" align="right"></td>
			</tr>
			<tr><td colspan="2" align="center">{numeroFactura}</td></tr>
			<tr><td colspan="2" align="left"></td></tr>
			<tr>
				<td width="75px"><b>Fecha: </b></td>
				<td width="100px" align="right">'.$fechaEmision.'</td>
			</tr>
			<tr>
				<td width="75px"><b>Total: </b></td>
				<td width="100px" align="right"><b>'.$total.'</b></td>
			</tr>
		</table>
		<br>
		<table border="0">
			<tr>
				<td colspan="2"><strong>Datos alumno</strong></td>
			</tr>
			<tr>
				<td width="175px" coslpan="2">'.$nombresCliente.'</td>
			</tr>
			<tr>
				<td width="75px">Alumno: </td>
				<td width="100px" align="right">'.$codCliente.'</td>
			</tr>
			<tr>
				<td width="75px">Identidad: </td>
				<td align="right" width="100px">'.$idCliente.'</td>
			</tr>
		</table>';
		/*<br>
		<br>
		<table border="0">
			<tr>
				<td colspan="2">***Información del pago***</td>
			</tr>
			<tr>
				<td width="75px">Código: </td>
				<td width="100px" align="right">'.$codigoPago.'</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td align="right">'.$fechaEmision.'</td>
			</tr>
			<tr>
				<td>Cajero: </td>
				<td align="right">'.$nombreUsuario.'</td>
			</tr>
		</table>';*/
	$cobro = new Cobro();
	$deudasAfectadas = $cobro->get_deudasAfectadas($codigoPago);
	$detallePagos = $cobro->get_detallePagos($codigoPago);

	$html.='
		<br>
		<br>
		<table border="0">';
	foreach($deudasAfectadas as $rows)
	{	$html.='
			<!--<tr><td colspan="2" align="left" style="font-size:small;">'.$rows['tipoDeuda'].' (ref. interna) </td></tr>
			<tr><td colspan="2" align="left" style="font-size:small;">Deuda #: '.$rows['codigoDeuda'].' (ref. interna) </td></tr>-->
			<tr><td align="left" width="75px">T. deuda: </td><td align="right">$'.$rows['totalDeuda'].'</td></tr>
			<tr><td align="left">Abono: </td><td align="right">$'.$rows['valorAbonado'].'</td></tr>';
		$html.='<tr><td align="center"></td><td></td></tr>';
	}
	$html.="
		</table>";
		
	$html.='
		<br>
		<br>
		<table  border="0">
			<tr>
				<td align="left" colspan="2" width="175px">Formas de Pago</td>
			</tr>';
	$total_fp = 0;
	foreach($detallePagos as $rows)
	{	$factura = $rows['codigoDocumento'];
		$subtotal = ltrim( $rows['totalPago'] , "$" );
		$html.='<tr><td align="left"  style="font-size:small;">'.$rows['formaPago'].'</td>';
		$html.='<td align="right"  style="font-size:small;">'.$rows['totalPago'].'</td></tr>';
		$total_fp = $total_fp + $subtotal;
	}
	$html.="<tr><td align=\"left\" >Total</td>";
	$html.="<td align=\"right\" >$".$subtotal."</td></tr>";
	$html.="
		</table>";
	$html.="
	</div>";
	$html = str_replace('{numeroFactura}', $factura, $html);
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Output('Pago no. '.$codigoPago.' de '.$nombresCliente.'.pdf', 'I');
}
handler();
?>