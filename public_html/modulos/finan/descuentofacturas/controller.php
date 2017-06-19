<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../clientes/model.php');
require_once('../puntos_emision/model.php');
require_once('../../../core/modelHTML.php');



function handler()
{   require('../../../core/rutas.php');
	$descuentofacturas 	= get_mainObject('Descuentofacturas');
	$user_data 			= get_frontData();
	$pto_emision 		= get_mainObject('PtoEmision');
    $sucursales 		= get_mainObject('PtoEmision');
	$cliente 			= get_mainObject('Cliente');
	$cliente_descuentos	= get_mainObject('Cliente');
	
	$event 			= get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, VIEW_SET_CLIENT, VIEW_GET_PRODUCT, VIEW_PRINT_FACT, GET_CLIENT,GET_DEUDAS_VENC_ANT), VIEW_GET_ALL);
    
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "deudasPendiente_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case VIEW_GET_ALL:
			#  Presenta la pagina inicial
			global $diccionario;
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
        
      		$data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_anidada",
                                                    "clase"=>"table table-striped table-bordered",
                                                    "id"=>'deudasPendiente_table',
                                                    "datos"=>array(),
                                                    "encabezado" => array(  "Código",
                                                                            "Deuda",																			
                                                                            "Inicial",
																			"Dscto.",
																			"Prontopago",
                                                                            "I.V.A.",
                                                                            "Abonado",
                                                                            "Pdte.",
                                                                            "Vencimiento",
																			"Opciones"),
                                                    "options"=>array(  ),
                                                    "campo"=>"",
                                                    "anidada"=>false);
			$data['opciones_cliente']= " ";
			retornar_vista(VIEW_GET_ALL, $data);
            break;
        case LOAD_DETA_DEUD_INFO:
            $descuentofacturas->get_all_deud_deta_info($user_data['deud_codigo']);
            $data['{tabla_deuda_info}'] = array("elemento" 	=>"tabla",
												"clase"		=>"table table-striped table-bordered",
												"id"		=>"sub_deudas_".$user_data['deud_codigo'],
												"datos"		=>$descuentofacturas->rows,
												"encabezado"=>array("Producto",
																	"Prec. Unit.",
																	"Cantidad",
																	"Inicial",
																	"Dscto.",
																	"I.V.A.",
																	"T. Neto"));
            retornar_result($data);
            break;
        case GET_DEUDAS:
            # Consulta las deudas de un cliente especifico
            global $diccionario;
			
			//$opciones = array("Seleccionar" => "<span onclick='js_descuentofactura_carga_asignacion(".'"{codigo}"'.",".'"modal_asign_body_descuentofactura"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/descuentofacturas/controller.php"'.")' class='btn_opc_lista_credit_card glyphicon glyphicon-credit-card cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign_descuentofactura'  id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar Descuentos' data-placement='left'></span>");
            $opciones['Seleccionar'] = "<button type='button' class='btn btn-default' 
											onclick='js_descuentofactura_carga_asignacion(\"{codigo}\",\"resultado\",\"".$diccionario['rutas_head']['ruta_html_finan']."/descuentofacturas/controller.php\")'
											id='{codigo}_asignar'><span class='btn_opc_lista_credit_card fa fa-edit'></span></button>";
			
            $descuentofacturas->codigoCliente = $user_data['codigoCliente'];
			$descuentofacturas->tipo_persona = $user_data['tipo_persona'];
            $descuentofacturas->get_deudas();
            $data['{tabla_deudasPendientes}'] = array("elemento"=>"tabla_anidada",
                                                      "clase"=>"table table-striped table-bordered",
                                                      "id"=>'deudasPendiente_table',
                                                      "datos"=>$descuentofacturas->rows,
                                                      "encabezado" => array("Código",
                                                                            "Deuda",																			
                                                                            "Inicial",
																			"Dscto.",
																			"Prontopago",
                                                                            "I.V.A.",
                                                                            "Abonado",
                                                                            "Pdte.",
                                                                            "Vencimiento",
																			"Editar"),
                                                      "options"=>array( $opciones ),
                                                      "campo"=>"codigoDeuda");
            retornar_result($data);
            break;
        case VIEW_GET_CLIENT:
            # Presenta el modal de Busqueda del cliente
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
		case DELETE:
            $descuentofacturas->delete($user_data['codigo']);
            break;
		case GET_DEUDAS_VENC_ANT:
			global $diccionario;
			$descuentofacturas->get_deudasAnterioresVencidas($user_data['cabFact_codigo']);
			$json_deudas_vencidas=array();
			
			foreach($descuentofacturas->rows as $campo=>$valor){
				$json_deudas_vencidas[$campo]=$valor;
			}
			echo json_encode ($json_deudas_vencidas);
			//var_dump($descuentofacturas->rows);
			break;
        case GET_CLIENT:
            # Consulta los clientes a traves de los filtros (nombres e identificacion) y devuelve la tabla con los resultados
            $descuentofacturas->get_clientes($user_data);
            $data = array('{tablaCliente}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-hover",  
                                                    "id"=> "clientes_table",  
                                                    "datos"     => $descuentofacturas->rows,
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_result($data);
            break;
		case VIEW_SET_DISCOUNT:
		  	 global $diccionario;
            $cliente->getDscto_selectFormat('zzz');
            $dscto = $cliente->rows;
			
			/*TABLA DETALLE FACTURA*/
			
			$deudaConfigInfo = new Descuentofacturas();
			$deudaConfigInfo->getFacturaConfigInfo( $user_data['codigofactura'] );
			
			$deudaConfigInfo_detalle = new Descuentofacturas();
			$deudaConfigInfo_detalle->getFacturaConfigInfo_detalle( $user_data['codigofactura'] );
			$tabla_detalle ="<table class='table table-striped table-hover' id='tabla_detalleFactura_config' name='tabla_detalleFactura_config'>
						<thead>
						<tr><th style='text-align:center;'>Sec.</th>
							<th style='text-align:center;'>Detalle</th>
							<th style='text-align:center;'>Aplica prontopago</th>
							<th style='text-align:center;'>Aplica dscto.</th>
							<th style='text-align:center;'>Rep. liquidez</th>
							<th style='text-align:center;'>IVA</th>
							<!--<th style='text-align:center;'>ICE</th>-->
							<th style='text-align:center;'>% IVA</th>
							<!--<th style='text-align:center;'>% ICE</th>-->
						</tr>
						</thead>";
			$tabla_detalle.="<tbody>";
			
			$total_numero_detalle = 0;
			foreach( $deudaConfigInfo_detalle->rows as $rows )
			{   if ( !empty ($rows) )
				{	$tabla_detalle.="
						<tr>
							<td style='text-align:center;'>".$rows['detafact_secuencia']."</td>
							<td style='text-align:center;' data-codigo='".$rows['prod_codigo']."'>".$rows['producto']."</td>
							<td style='text-align:center;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_pp_".$rows['detafact_secuencia']."' name='ckb_pp_".$rows['detafact_secuencia']."' ".
							( $rows['prod_prontopago'] == 0 ? '' : 'checked' )."></td>
							<td style='text-align:center;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_des_".$rows['detafact_secuencia']."' name='ckb_des_".$rows['detafact_secuencia']."' ".
							( $rows['prod_descuento'] == 0 ? '' : 'checked' )."></td>
							<td style='text-align:center;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_liq_".$rows['detafact_secuencia']."' name='ckb_liq_".$rows['detafact_secuencia']."' ".
							( $rows['prod_liquidez'] == 0 ? '' : 'checked' )."></td>
							<td style='text-align:center;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_aIVA_".$rows['detafact_secuencia']."' name='ckb_aIVA_".$rows['detafact_secuencia']."' ".
							( $rows['prod_aplicaIVA'] == 0 ? '' : 'checked' ).">
							<span style='display:none;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_aICE_".$rows['detafact_secuencia']."' name='ckb_aICE_".$rows['detafact_secuencia']."' ".
							( $rows['prod_aplicaICE'] == 0 ? '' : 'checked' )."></span></td>
							<td style='text-align:center;'><input class='form-control input-sm' type='text' id='txt_per_IVA_".$rows['detafact_secuencia']."' name='txt_per_IVA_".$rows['detafact_secuencia']."' value='".
							(empty( $rows['prod_perIVA'] ) ? '0.00' : $rows['prod_perIVA'] )."'>
							<input class='form-control input-sm' type='hidden' disabled = 'disabled' id='txt_per_ICE_".$rows['detafact_secuencia']."' name='txt_per_ICE_".$rows['detafact_secuencia']."' value='".
							(empty( $rows['prod_perICE'] ) ? '0.00' : $rows['prod_perICE'] )."'></td>
							<!--<td style='text-align:center;'>".( $rows['prod_prontopago'] == 0 ? '' : 'checked' )."</td>-->";
					$tabla_detalle.="</tr>";
					$total_numero_detalle++;
				}
			}
			$tabla_detalle.="</tbody></table>";
			
            /*TABLA DESCUENTOS ASIGNADOS*/
			
			$descuentofacturas->getDescuentos_factura($user_data['codigofactura']);
			
			$tabla ="<table class='table table-striped table-hover' id='tabla_descuentos_cliente' name='tabla_descuentos_cliente'>
						<thead>
						<tr><th style='text-align:center;'>Descuento</th>
							<th style='text-align:center;'>%</th>
							<th style='text-align:center;'>Días validez</th>
							<th style='text-align:center;'>Descuento aplica prontopago</th>
							<th style='text-align:center;'>Acción</th>
						</tr>
						</thead>";
			$tabla.="<tbody>";
			$total_descuentos = 0;
			$general_check = 1;
			foreach( $descuentofacturas->rows as $rows )
			{   if ( !empty ($rows) )
				{	if ( $rows['desc_aplicaprontopago'] == 0)
						$general_check = 0;
					
					$tabla.="
						<tr>
							<td style='text-align:center;' data-codigo='".$rows['desc_codigo']."' data-estado='active'>".$rows['desc_descripcion']."</td>
							<td style='text-align:center;'><input class='form-control input-sm' type='text' id='txt_desc_per_".$rows['detafact_desc_codigo']."' name='txt_desc_per_".$rows['detafact_desc_codigo']."' value='".
							$rows['desc_porcentaje']."'></td>
							<td style='text-align:center;'><input class='form-control input-sm' type='text' id='txt_desc_dias_".$rows['detafact_desc_codigo']."' name='txt_desc_dias_".$rows['detafact_desc_codigo']."' value='".
							( $rows['desc_dias_validez'] == 1000 ? '0' : $rows['desc_dias_validez'] )."'></td>
							<td style='text-align:center;'><input type='checkbox' onclick='js_descuentofactura_check_pvfalse();' id='ckb_dapp_".$rows['detafact_desc_codigo']."' name='ckb_dapp_".$rows['detafact_desc_codigo']."' ".
							( $rows['desc_aplicaprontopago'] == 0 ? '' : 'checked' )."></td>
							<td style='text-align:center;'>
								<span onclick='js_descuentofactura_del_descuento_asignado(\"".$rows['desc_codigo']."\")' 
									class='btn_opc_lista_eliminar fa fa-times-circle-o cursorlink' 
									aria-hidden='true' onmouseover='$(this).tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span></td>";
					$tabla.="</tr>";
					$total_descuentos++;
				}
			}
			$tabla_previsualizacion.="
					<table class='table table-striped table-hover' id='tbl_previsualizacion' name='tbl_previsualizacion'>
						<thead>
						<tr><th style='text-align:center;'>Detalle</th>
							<th style='text-align:center;'>T. Bruto</th>
							<th style='text-align:center;'>T. Descuento</th>
							<th style='text-align:center;'>T. Prontopago</th>
							<th style='text-align:center;'>T. IVA</th>
							<th style='text-align:center;'>T. Neto</th>
						</tr>
						</thead>
						<tbody>
							<tr><td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>";
			
            $cliente->get( $user_data['codigo'], $user_data['tipo_persona'] );
		    
			$sucursales->get_all_sucursales_withPrefix( );
			$sucu_combo ='<select class="form-control input-sm" id="pto_sucursal" name="pto_sucursal">';
			foreach ($sucursales->rows as $sucursal)
			{   if( !empty( $sucursal ) )
					$sucu_combo.="<option data-sucu_codigo='".$sucursal[0]."' value='".$sucursal[2]."'>".$sucursal[1]."</option>";
			}
			$sucu_combo.="</select>";
            $data = array('{combo_descto}'    => array("elemento"  => "combo", 
                                                       "datos"     => $dscto, 
                                                       "options"   => array("name"=>"codigo_descto",
                                                                            "id"=>"codigo_descto",
                                                                            "required"=>"required",
																			"class"=>"form-control",
                                                                            "onChange"=>"js_descuentofactura_carga_porcentaje(this.value,'div_descuentoInfo','".$diccionario['rutas_head']['ruta_html_finan']."/descuentofacturas/controller.php')"),
                                                       "selected"  => 0),
                          'clie_codigo'        		=> $user_data['codigo'],
                          'clie_nombres'       		=> $cliente->nombres,
                          'clie_apellidos'     		=> $cliente->apellidos,
						  "tipo_descuento"	   		=> $descuentofacturas->rows[0]['deud_metodo_desc'],
						  "txt_fecha_ini"			=> $deudaConfigInfo->rows[0]['deud_fechaInicioCobro'],
						  "txt_fecha_fin"			=> $deudaConfigInfo->rows[0]['deud_fechaVencimiento'],
						  "dias_prontopago"			=> $deudaConfigInfo->rows[0]['deud_diasProntoPago'],
						  "txt_num_sucursal"		=> $deudaConfigInfo->rows[0]['cabefact_prefijoSucursal'],
						  "txt_num_ptoVenta"		=> $deudaConfigInfo->rows[0]['cabefact_prefijoPuntoVenta'],
						  "puntVent_codigo"			=> $deudaConfigInfo->rows[0]['puntVent_codigo'],
						  "sucursal_codigo"			=> $deudaConfigInfo->rows[0]['sucursal_codigo'],
						  "txt_num_factura"			=> $deudaConfigInfo->rows[0]['cabefact_numeroFactura'],
                          "tabla_descuentos"   		=> $tabla,
						  "tabla_detalleFactura"	=> $tabla_detalle,
						  "check_aplica_prontopago" => ( $general_check == 1 ? ' checked="checked" ': '' ) ,
						  "hd_t_ini_dsctos" 		=> $total_descuentos,
						  "hd_t_num_detalle" 		=> $total_numero_detalle,
						  "tabla_previsualizacion" 	=> $tabla_previsualizacion,
						  'combo_sucursal' 			=> $sucu_combo
                          );
			$metodo_desc = $deudaConfigInfo->rows[0]['deud_metodo_desc'];
			
			if ($metodo_desc == 'desc_sumado' )
				$data['desc_sumado']= ' selected="selected" ';
			else
				$data['desc_sobre']= ' selected="selected" ';
			
			if( $deudaConfigInfo->rows[0]['cabefact_impresa'] == 0 )
			{	$data['ckb_genera_factura'] = ' checked ';
				$data['disabled_txt_num_factura'] = '';
			}
			else
			{	$data['ckb_genera_factura'] = '';
				$data['disabled_txt_num_factura'] = ' disabled="disabled" ';
			}
			
			if( $deudaConfigInfo->rows[0]['deud_convenioPago'] == 1 )
				$data['ckb_convenioPago'] = ' SI';
			else
				$data['ckb_convenioPago'] = ' NO';
			
            retornar_formulario(VIEW_SET_DISCOUNT, $data);
            break;
		case GET_PTOVENTAS:
			$pto_emision->get_all_ptosVentas_withPrefix( $user_data['sucursal'] );
			
			$ptva_combo ='<select class="form-control input-sm" id="cmb_ptoVenta" name="cmb_ptoVenta">';
			foreach ($pto_emision->rows as $ptos)
			{   if( !empty( $ptos ) )
					$ptva_combo.="<option data-puntvent_codigo='".$ptos[0]."' value='".$ptos[1]."'>".$ptos[1]."</option>";
			}
			$ptva_combo.="</select>";
			echo $ptva_combo;
			break;
		case GET_NUMEROSFACTURAS:
			$numeroFactura = new PtoEmision();
			$numeroFactura->get_all_numeros_factura( $user_data['puntoVenta'] );
			$nF_combo ='<select class="form-control input-sm" id="cmb_numeroFactura" name="cmb_numeroFactura">';
			foreach ($numeroFactura->rows as $nf)
			{   if( !empty( $nf ) )
					$nF_combo.="<option value='".$nf[0]."'>".$nf[0]."</option>";
			}
			$nF_combo.="</select>";
			echo $nF_combo;
			break;
        case GET_PORCENTAJE:
            $cliente->getPorcentaje($user_data['desc_codigo']);
            
			$data['porcentaje_sugerido'] = 
					'<div class="form-group">
						<div class="col-md-4">
							Porcentaje dscto.
						</div>
						<div class="col-md-4">
							 <div class="input-group">
								<div id="div_porcentaje_descto"><input type="text" class="form-control input-sm" name="porcentaje_descto" id="porcentaje_descto" 
									placeholder="0.00" required="required" value="'.( $cliente->desc_porcentaje != '' ? $cliente->desc_porcentaje : '0.00' ).'"></div>
									<span class="input-group-addon" id="basic-addon">%</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4"> 
							<label for="diasvalidez" class="control-label"><b>Días de validez</b></label>
							<div id="EducaLinksHelperCliente" style="display:inline;font-size:small;text-align:left;vertical-align:middle;">
								<a tabindex="0" data-toggle="popover" data-content="<div style=\'font-size:x-small\'>Es el tiempo en el que el descuento es válido, a partir del día de inicio de cobro de una deuda.</div>" data-placement="top"><span class="fa fa-info-circle"></span></a>
							</div>
							<div id="EducaLinksHelperCliente" style="display:inline;font-size:small;text-align:left;vertical-align:middle;">
								<a tabindex="0" data-toggle="popover" data-content="<div style=\'font-size:x-small\'>Deje el número de días en \'0\' para que el sistema reconozca que el descuento no tiene límite en el número de días de validez.</div>" data-placement="bottom"><span class="fa fa-info-circle"></span></a>
							</div>
						</div>
						<div class="col-md-4"> 
							<input type="text" class="form-control input-sm" id="diasvalidez" name="diasvalidez" value="0">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12"> 
							<label for="aplicaprontopago_add" class="checkbox-inline">
								<input type="checkbox" id="ckb_prontopago" name="ckb_prontopago" '.( $cliente->aplicaprontopago == 'SI' ? 'checked' : '' ).'/>
								Aplica Prontopago
							</label>
						</div>
					</div>';
			retornar_result($data);
			break;
		case GET_PREVISUALIZACION:
			$datosFactura = array();
			$datosFactura = json_decode( $user_data['deuda_xml'], true );
			
			$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.=  '<fc>';
            $xml.=   '<cb ';
			$xml.=     'cd="'.   $datosFactura['cabecera']['codigoDeuda'].'" ';
			$xml.=     'md="'.   $datosFactura['cabecera']['md'].'" '; //método de descuento
            $xml.=     'cl="'.   $datosFactura['cabecera']['codigoCliente'].'" ';
			$xml.=     'tp="'.   $datosFactura['cabecera']['tipoPersona'].'" ';
            $xml.=     'fIni="'. $datosFactura['cabecera']['fechaInicio_cobro'].'" ';
            $xml.=     'fFin="'. $datosFactura['cabecera']['fechaVencimiento'].'" ';
			$xml.=     'diap="'. $datosFactura['cabecera']['dias_prontopago'].'" ';
			$xml.=     'gfce="'. $datosFactura['cabecera']['generaFactura'].'" '; //Generar Factura comprobante electrónico
			$xml.=     'sucu="'. $datosFactura['cabecera']['sucursal'].'" ';
			$xml.=     'ptoV="'. $datosFactura['cabecera']['ptoVenta'].'" ';
			$xml.=     'ptoVc="'.$datosFactura['cabecera']['puntVent_codigo'].'" ';
			$xml.=     'nFCT="'. $datosFactura['cabecera']['numeroFactura'].'" ';
            $xml.=   " />";
			
            $xml.=  '<dt>';
            foreach ( $datosFactura['detalle'] as $detalle )
			{   $xml.=  '<l ';
				$xml.=  ' sec="'. $detalle['detaFact_sec'] . '" ';
				$xml.=  ' cp="'.  $detalle['codigoProducto'] . '" ';
				$xml.=  ' aPP="'. $detalle['aplica_pp'] . '" ';
				$xml.=  ' aD="'.  $detalle['aplica_dscto'] . '" ';
				$xml.=  ' rL="'.  $detalle['rep_liquidez'] . '" ';
				$xml.=  ' aIVA="'.$detalle['aplica_IVA'] . '" ';
				$xml.=  ' aICE="'.$detalle['aplica_ICE'] . '" ';
				$xml.=  ' pIVA="'.$detalle['per_IVA'] . '" ';
				$xml.=  ' pICE="'.$detalle['per_ICE'] . '" ';
            	$xml.=  ' />';
            }
            $xml .=  "</dt>";
			
			$xml.=  '<des>';
            foreach ( $datosFactura['descuento'] as $descuento )
			{   $xml.=  '<l ';
				$xml.=  ' cod="'.$descuento['codigo_descto'] . '" ';
				$xml.=  ' per="'.$descuento['percent'] . '" ';
				$xml.=  ' dv="'. $descuento['diasvalidez'] . '" ';
				$xml.=  ' aPP="'.$descuento['aplica_pp'] . '" ';
            	$xml.=  ' />';
            }
            $xml .=  "</des>";
            $xml .= "</fc>";
			
			$descuentofacturas->get_previsualizacion( $xml, $user_data['como_si_fuera'] );
			
			$tbl_previsualizacion ="<table class='table table-striped table-hover' id='tbl_previsualizacion' name='tbl_previsualizacion'>
						<thead>
						<tr><th style='text-align:center;'>Código</th>
							<th style='text-align:center;'>Deuda</th>
							<th style='text-align:center;'>Inicial</th>
							<th style='text-align:center;'>Dscto.</th>
							<th style='text-align:center;'>Prontopago</th>
							<th style='text-align:center;'>I.V.A.</th>
							<th style='text-align:center;'>Abonado</th>
							<th style='text-align:center;'>N/C</th>
							<th style='text-align:center;'>Pdte.</th>
							<th style='text-align:center;'>F. Vence</th>
						</tr>
						</thead>";
			$tbl_previsualizacion.="<tbody>";
			
			$total_numero_detalle = 0;
			foreach( $descuentofacturas->rows as $rows )
			{   if ( !empty ($rows) )
				{	$tbl_previsualizacion.="<tr>";
					foreach( $rows as $column )
					{   $tbl_previsualizacion.="<td style='text-align:center;'>".$column."</td>";
					}	
					$tbl_previsualizacion.="</tr>";
				}
			}
			$tbl_previsualizacion.="</tbody></table>";
			$data['mensaje'] = $descuentofacturas->mensaje;
			$data['tbl_previsualizacion'] = $tbl_previsualizacion;
			echo json_encode($data, true);
			break;
		case SET_CHANGES:
			$datosFactura = array();
			$datosFactura = json_decode( $user_data['deuda_xml'], true );
			
			$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.=  '<fc>';
            $xml.=   '<cb ';
			$xml.=     'cd="'.   $datosFactura['cabecera']['codigoDeuda'].'" ';
			$xml.=     'md="'.   $datosFactura['cabecera']['md'].'" '; //método de descuento
            $xml.=     'cl="'.   $datosFactura['cabecera']['codigoCliente'].'" ';
			$xml.=     'tp="'.   $datosFactura['cabecera']['tipoPersona'].'" ';
            $xml.=     'fIni="'. $datosFactura['cabecera']['fechaInicio_cobro'].'" ';
            $xml.=     'fFin="'. $datosFactura['cabecera']['fechaVencimiento'].'" ';
			$xml.=     'diap="'. $datosFactura['cabecera']['dias_prontopago'].'" ';
			$xml.=     'gfce="'. $datosFactura['cabecera']['generaFactura'].'" '; //Generar Factura comprobante electrónico
			$xml.=     'sucu="'. $datosFactura['cabecera']['sucursal'].'" ';
			$xml.=     'ptoV="'. $datosFactura['cabecera']['ptoVenta'].'" ';
			$xml.=     'ptoVc="'.$datosFactura['cabecera']['puntVent_codigo'].'" ';
			$xml.=     'nFCT="'. $datosFactura['cabecera']['numeroFactura'].'" ';
            $xml.=   " />";
			
            $xml.=  '<dt>';
            foreach ( $datosFactura['detalle'] as $detalle )
			{   $xml.=  '<l ';
				$xml.=  ' sec="'. $detalle['detaFact_sec'] . '" ';
				$xml.=  ' cp="'.  $detalle['codigoProducto'] . '" ';
				$xml.=  ' aPP="'. $detalle['aplica_pp'] . '" ';
				$xml.=  ' aD="'.  $detalle['aplica_dscto'] . '" ';
				$xml.=  ' rL="'.  $detalle['rep_liquidez'] . '" ';
				$xml.=  ' aIVA="'.$detalle['aplica_IVA'] . '" ';
				$xml.=  ' aICE="'.$detalle['aplica_ICE'] . '" ';
				$xml.=  ' pIVA="'.$detalle['per_IVA'] . '" ';
				$xml.=  ' pICE="'.$detalle['per_ICE'] . '" ';
            	$xml.=  ' />';
            }
            $xml .=  "</dt>";
			
			$xml.=  '<des>';
            foreach ( $datosFactura['descuento'] as $descuento )
			{   $xml.=  '<l ';
				$xml.=  ' cod="'.$descuento['codigo_descto'] . '" ';
				$xml.=  ' per="'.$descuento['percent'] . '" ';
				$xml.=  ' dv="'. $descuento['diasvalidez'] . '" ';
				$xml.=  ' aPP="'.$descuento['aplica_pp'] . '" ';
            	$xml.=  ' />';
            }
            $xml .=  "</des>";
            $xml .= "</fc>";
			
			$descuentofacturas->set_changes( $xml );
			echo $descuentofacturas->mensaje;
            break;
        case VIEW_DETAILS_DEBT:
            $descuentofacturas->get_deudaDetails($user_data['codigoDeuda']);
            $data = array('{tablaDetalleDeudas}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-hover",  
                                                    "id"=> "deudasTable",  
                                                    "datos"     => $descuentofacturas->rows,
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
            $descuentofacturas->get_pagosDeudaDetails($user_data['codigoDeuda']);
            $data = array('{tablaDetallePagosDeuda}' => array("elemento"  => "tabla",
                                                              "clase" => "table table-striped table-hover",  
                                                              "id"=> "pagosDetalleTable",  
                                                              "datos"     => $descuentofacturas->rows,
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
            $descuentofacturas->get_formaPagoSelectFormat();
            $data = array('{combo_formaPago}' => array("elemento"  => "combo",
                                                       "datos"     => $descuentofacturas->rows,
                                                       "options"   => array("name" 		=> "formaPago_asign",
																			"id" 		=> "formaPago_asign",
																			"required" 	=> "required",
																			"onchange" 	=> "carga_formularioMetadata('resultadoMetadata','".$diccionario['rutas_head']['ruta_html_finan']."/cobros/controller.php')"),
                                                       "selected"  => 0),
                          'formulario_metadata' => '<div id="frm_pagoNones" class="form-horizontal" >
                                                      <div class="alert alert-info">
                                                        Seleccione la forma de pago para contirnuar ...
                                                      </div>
                                                    </div>'
                          );

            retornar_formulario(VIEW_GET_PAYMENT_WAY, $data);
            break;
        case GET_METADATA_FORM:
            $data = array();
            switch (trim($user_data['formaPago']))
			{   case 'EFECTIVO':
					retornar_formulario(VIEW_SET_CASH, $data);
					break;
				case 'CHEQUE':
					$descuentofacturas->get_bancoSelectFormat();
					$data = array('{comboBanco}' => array("elemento"  => "combo",
														  "datos"     => $descuentofacturas->rows,
														  "options"   => array( "name" 		=> "banco",
																				"id" 		=> "banco",
																				"required" 	=> "required"),
														  "selected"  => 0) 
                                            );
                retornar_formulario(VIEW_SET_CHEK, $data);
                break;
              case 'TARJETA DE CREDITO':
                $descuentofacturas->get_tarjetasCreditoSelectFormat();
                $data = array('{comboTarjetaCredito}' => array("elemento"  => "combo",
                                                               "datos"     => $descuentofacturas->rows,
                                                               "options"   => array("name" => "tarjetaCredito",
                                                                                    "id" => "tarjetaCredito",
                                                                                    "required" => "required"),
                                                               "selected"  => 0) 
                                            );
                retornar_formulario(VIEW_SET_CREDITCARD, $data);
                break;
              case 'TRANSFERENCIA':
                $descuentofacturas->get_bancoSelectFormat();
                $bancos = $descuentofacturas->rows;
                $descuentofacturas->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $descuentofacturas->rows;
                $data = array('{comboBanco}' => array("elemento"  => "combo",
                                                      "datos"     => $bancos,
                                                      "options"   => array("name" => "banco",
                                                                           "id" => "banco",
                                                                           "required" => "required"),
                                                      "selected"  => 0),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required"),
                                                               "selected"  => 0) 
                                            );
                retornar_formulario(VIEW_SET_TX, $data);
                break;
              case 'DEPOSITO':
                $descuentofacturas->get_bancoSelectFormat();
                $bancos = $descuentofacturas->rows;
                $descuentofacturas->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $descuentofacturas->rows;
                $data = array('{comboBanco}' => array("elemento"  => "combo",
                                                      "datos"     => $bancos,
                                                      "options"   => array("name" => "banco",
                                                                           "id" => "banco",
                                                                           "required" => "required"),
                                                      "selected"  => 0),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required"),
                                                               "selected"  => 0) 
                                            );
                retornar_formulario(VIEW_SET_ESCROW, $data);
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
                $descuentofacturas->get_bancoSelectFormat();
                $bancos = $descuentofacturas->rows;
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
                                                                           "required" => "required"),
                                                      "selected"  => $metadatos['banco'])
                              );
                retornar_formulario(VIEW_EDIT_CHEK, $data);
                break;
              case 'TARJETA CREDITO':
                $descuentofacturas->get_tarjetasCreditoSelectFormat();
                $tarjetasCredito = $descuentofacturas->rows;
                $data = array('codigoFormaPago' => $metadatos['codigoFormaPago'],
                              'nombreFormaPago' => $metadatos['formaPago'],
                              'idPago' => $user_data['idPago'],
                              'tc_titular' => $metadatos['titular'],
                              'tc_numero' => $metadatos['numero'],
                              'tc_lote' => $metadatos['lote'],
                              'tc_referencia' => $metadatos['referencia'],
                              'tc_monto' => $metadatos['monto'],
                              'tc_observacion' => $metadatos['observacion'],
                              '{comboTarjetaCredito}' => array("elemento"  => "combo",
                                                               "datos"     => $tarjetasCredito,
                                                               "options"   => array("name" => "tarjetaCredito",
                                                                                    "id" => "tarjetaCredito",
                                                                                    "required" => "required"),
                                                               "selected"  => $metadatos['tarjetaCredito'])
                              );
                retornar_formulario(VIEW_EDIT_CREDITCARD, $data);
                break;
              case 'DEPOSITO':
                $descuentofacturas->get_bancoSelectFormat();
                $bancos = $descuentofacturas->rows;
                $descuentofacturas->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $descuentofacturas->rows;
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
                                                      "options"   => array("name" => "banco",
                                                                           "id" => "banco",
                                                                           "required" => "required"),
                                                      "selected"  => $metadatos['banco']),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required"),
                                                               "selected"  => $metadatos['numeroCuentaDestino']) 
                              );
                retornar_formulario(VIEW_EDIT_ESCROW, $data);
                break;
              case 'TRANSFERENCIA':
                $descuentofacturas->get_bancoSelectFormat();
                $bancos = $descuentofacturas->rows;
                $descuentofacturas->get_cuentasBancariasSelectFormat();
                $cuentasbancariasDestino = $descuentofacturas->rows;
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
                                                                           "required" => "required"),
                                                      "selected"  => $metadatos['banco']),
                              '{comboCuentasDestino}' => array("elemento"  => "combo",
                                                               "datos"     => $cuentasbancariasDestino,
                                                               "options"   => array("name" => "cuentaDestino",
                                                                                    "id" => "cuentaDestino",
                                                                                    "required" => "required"),
                                                               "selected"  => $metadatos['numeroCuentaDestino']) 
                              );
                retornar_formulario(VIEW_EDIT_TX, $data);
                break;
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
            $esquemaXML .=    'montoTotal="'.$datosPago['cabecera']['total'].'" ';
            $esquemaXML .=    'usuario="'.$_SESSION['usua_codigo'].'" ';
            $esquemaXML .=    'puntoVenta="'.$_SESSION['puntVent_codigo'].'" ';
            //$esquemaXML .=    'puntoVenta="'.$_SESSION['puntVent_codigo'].'" ';
            $esquemaXML .=  "/>";
            $esquemaXML .=  '<detalles>';
            foreach ($datosPago['detalle'] as $detalle) {
              $lineaDetalle += 1;
              $esquemaXML .=  '<linea ';
              $esquemaXML .=    'secuencia="'.$lineaDetalle.'" ';
              $esquemaXML .=    'formaPago="'.$detalle['formaPago'].'" ';
              $esquemaXML .=    'codigoFormaPago="'.$detalle['codigoFormaPago'].'" ';
              $esquemaXML .=    'monto="'.$detalle['monto'].'" ';
              $esquemaXML .=  '>';
              $metadato = $detalle['metadato'];
              $esquemaXML .=  '<metadato linea="'.$lineaDetalle.'" ';
              switch ($detalle['formaPago']) {
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
                  $esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
                  break;
                case 'TRANSFERENCIA':
                  $esquemaXML .=    'banco="'.$metadato['banco'].'" ';    
                  $esquemaXML .=    'numeroCuentaOrigen="'.$metadato['numeroCuentaOrigen'].'" ';    
                  $esquemaXML .=    'numeroCuentaDestino="'.$metadato['numeroCuentaDestino'].'" ';    
                  $esquemaXML .=    'referencia="'.$metadato['referencia'].'" ';    
                  $esquemaXML .=    'fechaTransaccion="'.$metadato['fechaTransaccion'].'" ';  
                  $esquemaXML .=    'observacion="'.$metadato['observacion'].'" ';    
                  break;
              }
              $esquemaXML .=  ' />';
              $esquemaXML .=  ' </linea>';
            }
            $esquemaXML .=  "</detalles>";

            $lineaDetalle = 0;
            $esquemaXML .=  '<deudasAfectadas>';
            foreach ($datosPago['deudasAfectadas'] as $deuda) {
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
			//echo $esquemaXML;
            $codigoPago = $descuentofacturas->setPago( $esquemaXML );
            $mensajeIngresoPago = $descuentofacturas->mensaje.($descuentofacturas->codigoPago <= 0 ? $descuentofacturas->ErrorToString() : '');


            $documentos = array();
            $comprobantes = array();
            if($codigoPago>0){
              $comprobantes = $descuentofacturas->get_documentosGenerados($codigoPago);
              $documentos[] = HTML::a('../documento/imprimir/pago/'.$codigoPago, 'PAGO # '.$codigoPago, array('target'=>'_blank'));
              foreach ($comprobantes as $documento) {
                $documentos[] = HTML::a('../documento/imprimir/'.(trim($documento['tipoDocumento']) == 'FAC'? 'factura' : 'notaDebito').'/'.$documento['codigoDocumento'], (trim($documento['tipoDocumento']) == 'FAC'? 'FACTURA' : 'NOTA DÉBITO').' # '.$documento['codigoDocumento'], array('target'=>'_blank'));
              }  
            }

            # =======================================================================
            # GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS
            # =======================================================================
            $respuesta = generaDocumentoElectronico($comprobantes);
            $documentosElectronicos = array();
            foreach ($respuesta as $doc => $resp) {
                $documentosElectronicos[] = HTML::a('#','Fact. # '.$doc.' Estado: '.$resp['estado'].' Mensaje: '.$resp['mensajes']['mensaje']);
            }
            # =======================================================================
            # / GENERACIÓN DE DOCUMENTOS ELECTRÓNICOS /
            # =======================================================================
            
            /*$data = array('tipo_mensaje' => ($codigoPago > 0 ? 'alert-success' : 'alert-warning'),
                          'mensaje' => $mensajeIngresoPago,
                          '{listBills}' => array("elemento"  => "lista",
                                                 "datos"     => $documentos,
                                                 "options"   => array("name" => "listDocumentos",
                                                                      "id" => "listDocumentos",
                                                                      "class" => "form-control")
                                                 ),
                          'resultado' => ($codigoPago > 0 ? 'OK' : 'FAIL')
                         );*/

            $data = array('tipo_mensaje' => ($codigoPago > 0 ? 'alert-success' : 'alert-warning'),
                          'mensaje' => $mensajeIngresoPago,
                          '{listBills}' => array("elemento"  => "lista",
                                                 "datos"     => $documentos,
                                                 "options"   => array("name" => "listDocumentos",
                                                                      "id" => "listDocumentos",
                                                                      "class" => "form-control")
                                                 ),
                          '{listEBills}' => array("elemento"  => "lista",
                                                  "datos"     => $documentosElectronicos,
                                                  "options"   => array("name" => "listDocumentosElectronicos",
                                                                       "id" => "listDocumentosElectronicos",
                                                                       "class" => "form-control")
                                                 ),
                          'resultado' => ($codigoPago > 0 ? 'OK' : 'FAIL')
                         );

            retornar_formulario(VIEW_RESULT_PAYMENT, $data);
            break;
        case VIEW_BILL:
            // EVENTO QUE CONSULTA EL DOCUMENTO Y LO PRESENTA
            switch ($user_data['tipo']) {
              case 'factura':
                $factura = new Factura();
                $subtotal_0 = 0; $subtotal_12 = 0; $totalIVA = 0; $totalDescuento = 0; $totalDescuentoConIVA = 0; $totalNeto = 0;

                $datosFactura = $factura->getSingleHeader($user_data['codigo']);
                $detalleFactura = $factura->getDetails($user_data['codigo']);

                foreach ($detalleFactura as $detalle) {
                  if($detalle['ivaDetalle'] > 0){
                    $subtotal_12 += $detalle['brutoDetalle'];
                    $totalDescuentoConIVA += $detalle['descuentoDetalle'];
                  }else{
                    $subtotal_0 += $detalle['brutoDetalle'];
                  }
                  $totalDescuento += $detalle['descuentoDetalle'];
                }
                $totalIVA = ($subtotal_12 - $totalDescuentoConIVA) * 0.12;
                $totalNeto = (($subtotal_0 + $subtotal_12) - $totalDescuento) + $totalIVA;

                $data = array("subtitulo"=>"Factura",
                              "ruta_logoEmpresa"=>"",
                              "nombreComercial_empresa"=>$datosFactura[0]['nombreComercial'],
                              "direccion_matrizEmpresa"=>$datosFactura[0]['direccionMatriz'],
                              "direccion_sucursalEmpresa"=>$datosFactura[0]['direccionSucursal'],
                              "no_contribuyenteEspecial"=>"NO HAY",
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
                                                                                     "Precio </br>Unitario",
                                                                                     "Descuento",
                                                                                     "IVA",
                                                                                     "Precio Total"),
                                                               "atributos"   => array("border"=>"1", "id"=>"detalleTable")),
                              "subtotal_12"=>'$ '.number_format($subtotal_12, 2, '.', ','),
                              "subtotal_0"=>'$ '.number_format($subtotal_0, 2, '.', ','),
                              "subtotal_noObjetoIVA"=>"$ 00.00",
                              "subtotal_exentoIVA"=>"$ 00.00",
                              "subtotal_sinImpuestos"=>'$ '.number_format(($subtotal_0 + $subtotal_12), 2, '.', ','),
                              "total_descuento"=>'$ '.number_format($totalDescuento, 2, '.', ','),
                              "total_ice"=>"$ 00.00",
                              "total_iva"=>'$ '.number_format($totalIVA, 2, '.', ','),
                              "irbpnr"=>"$ 00.00",
                              "propina"=> "$ 00.00",
                              "total_neto"=>'$ '. number_format($totalNeto, 2, '.', ',')
                              );
                
                retornar_pagina(PRINT_BILL, $data);   
                break;
              case 'pago':
                $descuentofacturas = new Cobro();
                $datosPago = $descuentofacturas->get_infoPago($user_data['codigo']);
                $deudasAfectadas = $descuentofacturas->get_deudasAfectadas($user_data['codigo']);
                $detallePagos = $descuentofacturas->get_detallePagos($user_data['codigo']);

                $data = array('total'=> "$ ".number_format($datosPago[0]['total'], 2, '.', ','),
                              "codigoCliente"=> $datosPago[0]['codigoCliente'],
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
                                                                                     "Total Abonado"),
                                                               "atributos" => array("border"=>"1","id"=>"deudasAfectadasTable")),
                              "{tabla_detallePagos}"=> array("elemento"  => "tabla",
                                                             "clase" => "",  
                                                             "id"=> "pagosTable",  
                                                             "datos"     => $detallePagos,
                                                             "encabezado" => array("Forma de Pago",
                                                                                   "Total"),
                                                             "options"   => array(),
                                                             "campo"  => "")
                              );

                retornar_pagina(PRINT_PAYMENT, $data);
                break;
              case 'notaCredito':
                $notaCredito = new notaCredito();
                $subtotal_0 = 0; $subtotal_12 = 0; $totalIVA = 0; $totalDescuento = 0; $totalDescuentoConIVA = 0; $totalNeto = 0;

                $datosNotaCredito = $notaCredito->getSingleHeader($user_data['codigo']);
                $detalleNotaCredito = $notaCredito->getDetails($user_data['codigo']);

                foreach ($detalleNotaCredito as $detalle) {
                  if($detalle['ivaDetalle'] > 0){
                    $subtotal_12 += $detalle['brutoDetalle'];
                    $totalDescuentoConIVA += $detalle['descuentoDetalle'];
                  }else{
                    $subtotal_0 += $detalle['brutoDetalle'];
                  }
                  $totalDescuento += $detalle['descuentoDetalle'];
                }
                $totalIVA = ($subtotal_12 - $totalDescuentoConIVA) * 0.12;
                $totalNeto = (($subtotal_0 + $subtotal_12) - $totalDescuento) + $totalIVA;

                $data = array("subtitulo"=>"Nota de crédito",
                              "ruta_logoEmpresa"=>"",
                              "nombreComercial_empresa"=>$datosNotaCredito[0]['nombreComercial'],
                              "direccion_matrizEmpresa"=>$datosNotaCredito[0]['direccionMatriz'],
                              "direccion_sucursalEmpresa"=>$datosNotaCredito[0]['direccionSucursal'],
                              "no_contribuyenteEspecial"=>"NO HAY",
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
                              "subtotal_0"=>'$ '.number_format($subtotal_0, 2, '.', ','),
                              "subtotal_noObjetoIVA"=>"$ 00.00",
                              "subtotal_exentoIVA"=>"$ 00.00",
                              "subtotal_sinImpuestos"=>'$ '.number_format(($subtotal_0 + $subtotal_12), 2, '.', ','),
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
          break;
        default :
			echo "Resultado desconocido";
        	break;
    }
}


/*
 * Realiza la generación de las facturas electrónicas a través del web service
 */
function generaDocumentoElectronico($comprobantes = array()){
    
    $respuestaElectronica = array();

    
    foreach ($comprobantes as $documento) {
        if(trim($documento['tipoDocumento']) == "FAC"){
            $facturaBD = new Factura(); $detalleFact = array(); $cabeceraFactura = array();

            // Consulta de la factura generada
            $detalleFact = $facturaBD->get_facturaToFormatXML($documento['codigoDocumento']);
            $cabeceraFactura = $detalleFact[0];

            $ambiente = "1"; //[1,Prueba][2,Produccion]
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

            // 1.- Creo el objeto que interactua con el servicio web
            $procesarComprobanteElectronico = new ProcesarComprobanteElectronico();
            // 2.- Configuración de variables del sistema de facturación electrónica
            $configAplicacion = new configAplicacion();
            $configAplicacion->dirFirma = "C:/inetpub/wwwroot/educalinks_development/finan/includes/gustavo_alfonso_decker_zambrano.p12";
            $configAplicacion->dirLogo = "C:/inetpub/wwwroot/educalinks_development/finan/includes/LOGO_EDUCALINKS.png";
            $configAplicacion->passFirma = "Gustavo123";
            $configAplicacion->dirAutorizados = "C:/inetpub/wwwroot/educalinks_development/finan/documentos/autorizados";

            if($cabeceraFactura['emailTitular'] != ''){
                $configCorreo = new configCorreo();
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
            //$factura->contribuyenteEspecial = "5368"; //[Ver SRI]
            $factura->obligadoContabilidad = "SI"; // [SI]
            $factura->tipoIdentificacionComprador = $tipoIdentificacionComprador; //Info comprador [04, RUC][05,Cedula][06, Pasaporte][07, Consumidor final][08, Exterior][09, Placa]
            $factura->razonSocialComprador = $cabeceraFactura['razonSocialComprador']; //Razon social o nombres y apellidos comprador
            $factura->identificacionComprador = $cabeceraFactura['identificacionComprador']; // Identificacion Comprador
            $factura->totalSinImpuestos = number_format($cabeceraFactura['totalSinImpuestos'],2,'.',''); // Total sin aplicar impuestos
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
            $camposAdicionales = array();

            $campoAdicional = new campoAdicional();
            $campoAdicional->nombre = "alumno";
            $campoAdicional->valor = "Codigo: ".$cabeceraFactura['codigoAlumno']." Nombres: ".$cabeceraFactura['nombresAlumno'];
            $camposAdicionales[0] = $campoAdicional;
           
		    if($cabeceraFactura['emailTitular'] != ''){
              $campoAdicional = new campoAdicional();
              $campoAdicional->nombre = "Email";
              $campoAdicional->valor = $cabeceraFactura['emailTitular'];
              $camposAdicionales[1] = $campoAdicional;
            }else{
				$campoAdicional = new campoAdicional();
				$campoAdicional->nombre = "Telefono";
				$campoAdicional->valor = $cabeceraFactura['telefonoTitular'];
				$camposAdicionales[1] = $campoAdicional;
            }
            $campoAdicional = new campoAdicional();
            $campoAdicional->nombre = "Matricula";
            $campoAdicional->valor = $cabeceraFactura['registro'];
            $camposAdicionales[2] = $campoAdicional;
            $factura->infoAdicional = $camposAdicionales;

			if($tipoEmision==2){//procesa comprobante por contingencia
				$procesarComprobante = new procesarComprobanteClaveContingencia();
				$procesarComprobante->comprobante = $factura;
				$procesarComprobante->claveContingencia="";//si reenvio la factura la reenvio en mismo tipo de emision y la misma clave de contingencia.
				$res = $procesarComprobanteElectronico->procesarComprobanteClaveContingencia($procesarComprobante);
			}if($tipoEmision==1){//procesa comprobante normalmente
				$procesarComprobante = new procesarComprobante();
				$procesarComprobante->comprobante = $factura;
				$res = $procesarComprobanteElectronico->procesarComprobante($procesarComprobante);
			}

            

            $mensaje = (is_array($res->return->mensajes)? $res->return->mensajes[0]->mensaje : $res->return->mensajes->mensaje );
            $informacionAdicional = (is_array($res->return->mensajes)? $res->return->mensajes[0]->informacionAdicional : $res->return->mensajes->informacionAdicional );
            
            $respuestaElectronica[$documento['codigoDocumento']] = array("estado" => $res->return->estadoComprobante,
                "claveAcceso" => $res->return->claveAcceso,
                "numeroAutorizacion" => $res->return->numeroAutorizacion,
                "mensajes" => array("identificador" => $res->return->mensajes->identificador,
                "mensaje" => "Mensaje: ".$mensaje." Información adicional: ".$informacionAdicional
                )
            );
            // Actualizo el estado en el comprobante
            $fact = new Factura();
            $fact->set_estadoElectronico($documento['codigoDocumento'], $res->return->estadoComprobante, $res->return->numeroAutorizacion, $res->return->claveAcceso, $tipoEmision, $ambiente);
        }
    } // Fin del for de comprobantes
    

    return $respuestaElectronica;
} // Fin de la función
handler();
?>