<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('constants.php');
require_once('../../finan/cobros/model.php');
require_once('view.php');
require_once('../../../core/modelHTML.php');

function handler() {
  
  require('../../../core/rutas.php');
  $cobro = get_mainObject('Cobro');
  $event = get_actualEvents(array(VIEW_GET_ALL, VIEW_GET_CLIENT, VIEW_SET_CLIENT, VIEW_GET_PRODUCT, VIEW_PRINT_FACT, GET_CLIENT,GET_DEUDAS_VENC_ANT), VIEW_GET_ALL);
  $user_data = get_frontData();
  
  if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
  if (!isset($_POST['tabla'])){$tabla = "deudasPendiente_table";}else{$tabla =$_POST['tabla'];}
  
    switch ($event) {
		case VIEW_BILL:
            // EVENTO QUE CONSULTA EL DOCUMENTO Y LO PRESENTA
            switch ($user_data['tipo']) 
			{	case 'pago':
					$codigoPago = $user_data['codigo'];
					$cobro = new Cobro();
					$datosPago = $cobro->get_infoPago($codigoPago);
					generar_pago_PDF($_SESSION['print_dir_logo_cliente'],$datosPago[0]['codigoCliente'],$datosPago[0]['nombresCliente'],', '.$datosPago[0]['curso'],
										$datosPago[0]['identificacionCliente'], $datosPago[0]['codigoPago'], "$ ".
										number_format($datosPago[0]['total'], 2, '.', ','),
										$datosPago[0]['fechaEmision'], $datosPago[0]['usuario']);

					retornar_pagina(PRINT_PAYMENT, $data);
					break;
				default:
					break;
            }
            break;
        default :
        	break;
    }
}


function generar_pago_PDF($ruta_logo, $codCliente, $nombresCliente, $cursoParalelo, $idCliente, $codigoPago, $total,
							$fechaEmision, $nombreUsuario)
{   global $diccionario;
	$datosInst = new General();
	if ( trim( $idCliente ) == "" )
		$idCliente = " - n/a - ";
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='Recibo de Pago #".$codigoPago." de ".$nombresCliente.".pdf'");
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
	$pdf->SetFont('Helvetica', '', 11, '', 'false');
	$pdf->SetMargins(5, 5, 5, true);
	$pdf->AddPage('P', $pagelayout);//P:Portrait, L=Landscape
	//$pdf->SetXY(110, 200);
	//$pdf->Image($ruta_logo, '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
	$datosInst->getDatosInstitucion_info();
	$titularFactura = "";
	$datosCliente = 0;
	if ($cursoParalelo != ", " )
	{   $titularFactura = "Datos representante económico";
		$datosCliente = 1;
	}
	else
	{	$titularFactura = "Datos del cliente";
	}
	$html .= '
	<div id="contenedor">
		<table>
			<tr><td align="center"><strong>'.$datosInst->rows[0]['empr_razonSocial'].'</strong></td></tr>
			<tr><td align="center" style="font-size:small;"><strong>RUC:</strong> '.$datosInst->rows[0]['empr_ruc'].'</td></tr>
			<tr><td align="center" style="font-size:small;"><strong>Dir.:</strong> '.$datosInst->rows[0]['empr_direccionMatriz'].'</td></tr>
			<tr><td align="center" style="font-size:small;"><strong>Telf.:</strong> '.$datosInst->rows[0]['empr_contactoTelefono'].'</td></tr>
		</table>
		<br>
		<br>
		<table border="0">
			<tr><td colspan="2" align="left"   style="font-size:small;">Recibo de pago #'.$codigoPago.'</td></tr>
			<tr><td colspan="2" align="right"  style="font-size:small;"></td></tr>
			<tr><td colspan="2" align="center" style="font-size:small;">DETALLE DE COMPRA SIN VALIDEZ TRIBUTARIA<br># FACTURA<br>{numeroFactura}</td></tr>
			<tr>
				<td style="font-size:small;"><b>Hora impresión: </b></td>
				<td align="right" style="font-size:small;">'.date("M j Y g:iA")/*("M j, Y, g:i a")*/.'</td>
			</tr>
			<tr>
				<td style="font-size:small;"><b>Usuario impr.: </b></td>
				<td align="right" style="font-size:small;">'.$_SESSION['usua_codi'].'</td>
			</tr>
			<tr>
				<td style="font-size:small;"><b>Fecha pago: </b></td>
				<td align="right" style="font-size:small;">'.$fechaEmision.'</td>
			</tr>
			<tr>
				<td style="font-size:small;"><b>Cajero: </b></td>
				<td align="right" style="font-size:small;">'.$nombreUsuario.'</td>
			</tr>
			<tr>
				<td style="font-size:small;"><b>Total: </b></td>
				<td align="right"><b>'.$total.'</b></td>
			</tr>
		</table>
		<br>
		<br>
		<table width="100%" border="0">
			<tr>
				<td colspan="2"><strong>'.$titularFactura.'</strong></td>
			</tr>
			<tr>
				<td colspan="2">{nombreTitular}</td>
			</tr>
			<tr>
				<td colspan="2">CI/RUC: {numeroTitular}</td>
			</tr>';
	if( $datosCliente == 1)
	{	$html .= '
			<tr>
				<td colspan="2"><strong>Datos del estudiante</strong></td>
			</tr>
			<tr>
				<td colspan="2">'.$nombresCliente.$cursoParalelo.'</td>
			</tr>
			<tr>
				<td>Código: </td>
				<td align="right">'.$codCliente.'</td>
			</tr>
			<tr>
				<td>CI/RUC: </td>
				<td align="right" >'.$idCliente.'</td>
			</tr>
		</table>';
	}
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
		<table border="0">';
	foreach( $deudasAfectadas as $rows )
	{	$html.='
			<tr><td align="center" colspan="2"></td></tr>
			<tr><td align="left" >Descripción: </td><td align="right">'.$rows['prod_nombre'].'</td></tr>
			<tr><td align="left">Valor: </td><td align="right">$'.$rows['valorPrecio'].'</td></tr>';
			if( $rows['valorDescuento'] > 0 )
				$html.='
			<tr><td align="left">(-) Descuento: </td><td align="right">$'.$rows['valorDescuento'].'</td></tr>';
	}
	$html.="
		</table>";
		
	$html.='
		---------------------------------------------------
		<br>
		<table  border="0">
			<tr>
				<td align="left" colspan="2"><b>Formas de Pago</b></td>
			</tr>';
	$total_fp = $subtotal = 0;
	$numeroTitular = "";
	$nombreTitular = "";
	$aux_estado = 0;
	foreach($detallePagos as $rows)
	{	$validacion = '';
		if ($deudasAfectadas[$aux_estado]['deud_estado'] == 'PV')
			$validacion = '- Cheque sujeto a verificación -';
		$factura = '<span style="font-size:small;">'.$rows['codigoDocumento'] . $validacion . '</span>';
		$subtotal = ltrim( $rows['totalPago'] , "$" );
		$html.='<tr><td align="left">'.$rows['formaPago'].'</td>';
		$html.='<td align="right">'.$rows['totalPago'].'</td></tr>';
		$total_fp = $total_fp + $subtotal;
		$numeroTitular = $rows['numeroTitular'];
		$nombreTitular = $rows['nombreTitular'];
		$aux_estado++;
	}
	$html.='<tr><td align="left" colspan="2">--------</td></tr>';
	$html.="<tr><td align=\"left\"><b>Total</b></td>";
	$html.="<td align=\"right\" ><b>$".number_format($total_fp,2)."</b></td></tr>";
	$html.="<tr><td colspan=\"2\" style=\"font-size:small;\" align=\"center\"><br><br>Puede revisar sus facturas en la sgte. dirección:<br>".$_SESSION['visor'];
	if ( $numeroTitular != "9999999999" )
		$html.="<br>Usuario y Contraseña: ".$numeroTitular;
	$html.="</td></tr>";
	$html.="
		</table>";
	$html.="
	</div>";
	$html = str_replace('{numeroFactura}', $factura, $html);
	$html = str_replace('{numeroTitular}', $numeroTitular, $html);
	$html = str_replace('{nombreTitular}', $nombreTitular, $html);
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Output('Pago no. '.$codigoPago.' de '.$nombresCliente.'.pdf', 'I');
}
handler();
?>