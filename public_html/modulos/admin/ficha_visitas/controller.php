<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../medic/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../../finan/items/model.php');

function handler() {
    require('../../../core/rutas.php');
    $permiso = get_mainObject('General');
	$item = get_mainObject('Item');
	$pago = get_mainObject('Pagos');
    $event = get_actualEvents(array(VIEW_GET_ALL, GET_PENDING_BILLS, SEND_TO_SRI, RESEND_TO_SRI), VIEW_GET_ALL);
    $user_data = get_frontData();
	
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event) {
		case EDIT:
            $factura->edit($user_data);
            break;
        case VIEW_GET_ALL:
            #  Presenta la pagina inicial
            global $diccionario;
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			$item->get_item_selectFormat('');
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			$data['{cmb_producto}'] = array("elemento"  => "combo", 
											"datos"     => $item->rows, 
                                            "options"   => array("name"=>"cmb_producto",
																 "id"=>"cmb_producto",
																 "class"=>"form-control"),
											"selected"  => 0);
            $pago->get_formaPagoSelectFormat();
			$data['{cmb_forma_pago}']= array("elemento"  => "combo",
										    "datos"     => $pago->rows,
										    "options"   => array("name" => "cmb_forma_pago",
																 "id" => "cmb_forma_pago",
																 "class" => "form-control"),
										    "selected"  => 0);
			$data['tabla_pagos'] = "";
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_PAYMENTS:
            global $diccionario;
			$data['tabla_pagos'] = construct_table_pagos( $user_data );
            retornar_result($data);
            break;
		case REVERT_FACTURA:
			global $diccionario;
			$resultado = $pago->revertir_factura($user_data['codigoDocumento']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
        default:
            break;
    }
}
handler();
function construct_table_pagos($user_data)
{   global $diccionario;
	if(!isset($user_data['codigo_pago']))
		$codigo_pago = '';
	else 
		$codigo_pago = $user_data['codigo_pago'];
	if(!isset($user_data['forma_pago']))
		$forma_pago = '';
	else 
		$forma_pago = $user_data['forma_pago'];
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
	if(!isset($user_data['num_factura']))
		$num_factura = '';
	else 
		$num_factura = $user_data['num_factura'];
	if(!isset($user_data['prod_codigo']))
		$prod_codigo = '';
	else 
		$prod_codigo = $user_data['prod_codigo'];
	if(!isset($user_data['estado']))
		$estado = '';
	else 
		$estado = $user_data['estado'];
	if(!isset($user_data['tneto_ini']))
		$tpago_ini = 0;
	else 
		$tpago_ini = (float)$user_data['tneto_ini'];
	if(!isset($user_data['tneto_fin']))
		$tpago_fin = 0;
	else 
		$tpago_fin = (float)$user_data['tneto_fin'];
	$pago = new Pagos();
	$pago->get_PagosRealizados( $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $prod_codigo, 
										$estado, $tpago_ini, $tpago_fin);
	$construct_table="
				<table class='table table-bordered table-hover' id='pagosRealizados_table'>
					<thead><tr>".
			"<th style='font-size:small;text-align:center;'>Ref.</th>".
			"<th style='font-size:small;text-align:center;'>Datos</th>".
			"<th style='font-size:small;text-align:center;'>Total Pago</th>".
			"<th style='font-size:small;text-align:center;'>Forma de Pago</th>".
			"<th style='font-size:small;text-align:center;'>Cliente</th>".
			"<th style='font-size:small;text-align:center;'>Nombres cliente</th>".
			"<th style='font-size:small;text-align:center;'>Fecha pago</th>".
			"<th style='font-size:small;text-align:center;'>PDF</th>".
			"<th style='font-size:small;text-align:center;'>HTML</th>".
			"<th style='font-size:small;text-align:center;'>Revertir</th>
						</tr>
					</thead>";
	//}
	$body.="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoPDF = "";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	foreach($pago->rows as $row)
	{	$aux++;
	}
	foreach($pago->rows as $row)
	{	if($c<($aux-1))
		{	$body.="<tr>";
			$x=0;
			$datos="";
			foreach($row as $column)
			{	if($x==1)
				{	if($column=="")
						$column = "N/A";
					$datos.="<div style=\"text-align:left;\">".
								"<table><tr><td style=\"vertical-align:top;\"><b>Titular:&nbsp;</b></td><td>". $column."</td></tr>";
				}
				elseif($x==2)
				{	if($column=="")
						$column = "C.I.";
					$datos.="<tr><td><b>".$column.":&nbsp;</b></td><td>";
					$cedula = $column;
				}
				elseif($x==3)
				{	if($column=="")
						$column = "N/A";
					$datos.= $column."</td></tr>";
					$cedula = $column;
				}
				elseif($x==4)
				{	$datos.="<tr><td style=\"vertical-align:top;\"><b>D.A.:&nbsp;</b></td><td style=\"vertical-align:top;\">". $column."</td></tr></table></div>";
					$body.= "<td style='font-size:small;'>".
								"<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='glyphicon glyphicon-search'></span></span></td>";
				}
				else
				{	$body.="<td style='font-size:small;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
			$spanHTML="<span class='glyphicon glyphicon-print cursorlink' id='".$codigo."_ver_pago' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n grande.' data-placement='left'></span>";
			$spanPDF="<span class='glyphicon glyphicon-print cursorlink' id='".$codigo."_ver_pago_PDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n punto de venta.' data-placement='left'></span>";
			$spanRevertir="<div align='center' style='display:inline-block;'><span   onclick='js_Pago_revertir(".'"'.$codigo.'"'.",".'"modal_revert_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/pagos/controller.php"'.")'    class='btn_opc_lista_eliminar fa fa-history cursorlink'  aria-hidden='true' id='".$codigo."_revertir'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Revertir y borrar pago.'></span></div>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/PDF/imprimir/pago/".$codigo."' target='_blank'>".$spanPDF."</a></td>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/pago/".$codigo."' target='_blank'>".$spanHTML."</a></td>";
			$body.="<td style='text-align:center'>".$spanRevertir."</td>";
		}
		$body.="</tr>";
		$c++;
	}
	$body.="</tbody>";
	$construct_table.=$body;
	$construct_table.="</table>";
	return $construct_table;
}