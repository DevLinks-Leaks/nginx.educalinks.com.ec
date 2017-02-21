<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	$cierre_caja = get_mainObject('CajaCierre');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
	$reporte_aux= get_mainObject('General');
  if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
  if (!isset($_POST['tabla'])){$tabla = "cajas_table";}else{$tabla =$_POST['tabla'];}

    switch ($event) {
    	  case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $cierre_caja->get_all_cajas();
      		if(count($cierre_caja->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 169);
				if ($permiso->rows[0]['veri']==1)
				{
					$opciones["Opciones"].= "<span onclick='carga_reports_item(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cierre_caja/controller.php","print_item"'.")' class='btn_opc_lista_print glyphicon glyphicon-print cursorlink' data-toggle='modal' data-target='#modal_edit' aria-hidden='true' id='{codigo}_print'onmouseover='$(".'"#{codigo}_print"'.").tooltip(".'"show"'.")' title='Imprimir reportes de caja' data-placement='left'></span>";
				}
				else
				{
					$opciones["Opciones"].="";
				}
				$data['{tabla}']= array("elemento"=>"tabla",
									  "clase"=>"table table-bordered table-hover",
									  "id"=>$tabla,
									  "datos"=>$cierre_caja->rows,
									  "encabezado" => array(
															"<div align='center' style='font-size:12px;'>Código</div>",
															"<div align='center' style='font-size:12px;'>Apertura</div>",
															"<div align='center' style='font-size:12px;'>Usuario</div>",
															"<div align='center' style='font-size:12px;'>Fecha Apertura</div>",
															"<div align='center' style='font-size:12px;'>Fecha Cierre</div>",
															"<div align='center' style='font-size:12px;'>Estado</div>",
															"<div align='center' style='font-size:12px;'>Recaudación</div>",
															"<div align='center' style='font-size:12px;'>Reportes</div>"),
															"options"=>array($opciones),
															"campo"=>"caja_cier_codigo");
				$data['mensaje'] = "Historial de cajas";
      		}else{
      			$data = array('mensaje'=>$cierre_caja->mensaje.$cierre_caja->ErrorToString());
      		}
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $cierre_caja->get_all_cajas($user_data['busq']);
            if(count($cierre_caja->rows)>0){
                global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 169);
				$opciones["Opciones"].= "<div align='center'>";
				if ($permiso->rows[0]['veri']==1)
				{
					$opciones["Opciones"].= "<span onclick='carga_reports_item(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cierre_caja/controller.php","print_item"'.")' class='btn_opc_lista_print glyphicon glyphicon-print cursorlink' data-toggle='modal' data-target='#modal_edit' aria-hidden='true' id='{codigo}_print'onmouseover='$(".'"#{codigo}_print"'.").tooltip(".'"show"'.")' title='Imprimir reportes de caja' data-placement='left'></span>";
				}
				else
				{
					$opciones["Opciones"].="";
				}
				$opciones["Opciones"].= "</div>";
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$cierre_caja->rows,
                                        "encabezado" => array(
															"<div align='center' style='font-size:12px;'>Código</div>",
															"<div align='center' style='font-size:12px;'>Apertura</div>",
															"<div align='center' style='font-size:12px;'>Usuario</div>",
															"<div align='center' style='font-size:12px;'>Fecha Apertura</div>",
															"<div align='center' style='font-size:12px;'>Fecha Cierre</div>",
															"<div align='center' style='font-size:12px;'>Estado</div>",
															"<div align='center' style='font-size:12px;'>Recaudación</div>",
															"<div align='center' style='font-size:12px;'>Reportes</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"caja_cier_codigo");
            }
            retornar_result($data);
            break;
		case PRINTREP_ITEM:
			header("Content-type:application/pdf");
          	header("Content-Disposition:attachment;filename='CierreCaja.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Cierre de Caja - Items");
			$pdf->SetSubject("Cierre de Caja");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$caja_cier_codigo = $user_data["codigo"];
			$hoy = getdate();

			$cierre_caja->get_caja_cierre_items($caja_cier_codigo);
			$tranx = $cierre_caja->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$item_actual="";
			$meses_h = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$fecha_h = explode('-',$tranx[0]['cabePago_fecha']);
			$fecha_h_result = $meses_h[(int)$fecha_h[1]-1].' '.$fecha_h[2].', '.$fecha_h[0];
			
			$html .= '<h2>Reporte de Cierre de Caja - Items</h2>';
			$html .= '<h4>Usuario de caja: '.$tranx[0]['usua_codi'].'</h4>';
			$html .= '<h4>Fecha de apertura caja: '.$fecha_h_result.'</h4>';
			$html .= '<h5>Fecha de impresi&oacute;n de: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. '.date('H:i').'. Usuario: '.$_SESSION['usua_codi'].'.</h5> ';

			$html .= '<table border="0" cellspacing="0" cellpadding="0">';
			$cabePago_total_gene=0;
			$detaFact_totalbruto_gene=0;
			$detaFact_totalDescuento_gene=0;
			$detaFact_totalIVA_gene=0;
			$detaFact_totalICE_gene=0;
			for($i=0;$i<count($cierre_caja->rows)-1;$i++){
				if($item_actual!=$tranx[$i]['cate_nombre']){
					if($i!=0){
						$html.='<tr><td colspan="8"><hr/></td></tr>';
						$html.='<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Total</b> </td>
							<td align="right"><b>$'.number_format($detaFact_totalbruto,2).'</b> </td>
							<td align="right"><b>$'.number_format($cabePago_total,2).'</b> </td>
							<td align="right"><b>$'.number_format($detaFact_totalDescuento,2).'</b> </td>
							<td align="right"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
							<td align="right"><b>$'.number_format($detaFact_totalICE,2).'</b> </td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">&nbsp;</td>
						</tr>';
					}
					$html.='<tr>
						<th align="left" style="width:13%">'.$tranx[$i]['cate_nombre'].'</th>
						<th align="center" style="width:13%">Cliente/Alumno</th>
						<th align="center" style="width:7%">Factura ref. int.</th>
						<th align="right" style="width:15%">Pago ref. int.</th>
						<th align="right" style="width:7%">Valor</th>
						<th align="right" style="width:7%">I.V.A.</th>
						<th align="right" style="width:7%">I.C.E.</th>
						<th align="right" style="width:7%">Cobrado</th>
						<th align="right" style="width:7%">Dscto.</th>
						<th align="right" style="width:17%">Fecha</th>
					</tr>
					<tr>
					<td colspan="8"><hr/></td>
					</tr>';
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalbruto_gene=$detaFact_totalbruto_gene+$detaFact_totalbruto;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalCE;
					
					$cabePago_total=0;
					$detaFact_totalbruto=0;
					$detaFact_totalDescuento=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
				}
				$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
				$fecha = explode('-',$tranx[$i]['cabePago_fecha']);
				$fecha_result = $meses[(int)$fecha[1]-1].' '.$fecha[2].', '.$fecha[0];
				$prod_nombre = str_replace('Certificado de Conducta','Cert. Conducta',rtrim($tranx[$i]['prod_nombre']));
				$pagos = str_replace('Pagos: ','',$tranx[$i]['cabePago_codigo']);
				
				$html.='<tr>
				<td>'.$prod_nombre.' </td>
				<td align="center">'.$tranx[$i]['alum_codi'].' - '.$tranx[$i]['alum_nombre'].' </td>
				<td align="center">'.$tranx[$i]['deud_codigoDocumento'].' </td>
				<td align="right">'.$pagos.' </td>
				<td align="right">$'.$tranx[$i]['detaFact_totalbruto'].' </td>
				<td align="right">$'.$tranx[$i]['cabePago_total'].' </td>
				<td align="right">$'.$tranx[$i]['detaFact_totalDescuento'].'</td>
				<td align="right">$'.$tranx[$i]['detaFact_totalIVA'].'</td>
				<td align="right">$'.$tranx[$i]['detaFact_totalICE'].'</td>
				<td align="right">'.$fecha_result.'</td>
				</tr>';
				$item_actual=$tranx[$i]['cate_nombre'];
				$cabePago_total=$cabePago_total+$tranx[$i]['cabePago_total'];
				$detaFact_totalbruto=$detaFact_totalbruto+$tranx[$i]['detaFact_totalbruto'];
				$detaFact_totalDescuento=$detaFact_totalDescuento+$tranx[$i]['detaFact_totalDescuento'];
				$detaFact_totalIVA=$detaFact_totalIVA+$tranx[$i]['detaFact_totalIVA'];
				$detaFact_totalICE=$detaFact_totalICE+$tranx[$i]['detaFact_totalICE'];
				if($i==count($cierre_caja->rows)-2){
					$html.='<tr><td colspan="8"><hr/></td></tr>';
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalbruto,2).'</b> </td>
					<td align="right"><b>$'.number_format($cabePago_total,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalDescuento,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalICE,2).'</b> </td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8">&nbsp;</td>
					</tr>';
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalbruto_gene=$detaFact_totalbruto_gene+$detaFact_totalbruto;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalICE;
					
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Diario</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalbruto_gene,2).'</b> </td>
					<td align="right"><b>$'.number_format($cabePago_total_gene,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalDescuento_gene,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalIVA_gene,2).'</b> </td>
					<td align="right"><b>$'.number_format($detaFact_totalICE_gene,2).'</b> </td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8">&nbsp;</td>
					</tr>';
					
					$cabePago_total=0;
					$detaFact_totalbruto=0;
					$detaFact_totalDescuento=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
				}
			}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('CierreCaja.pdf', 'I');
			
			break;
		case PRINTREP_FP:
			header("Content-type:application/pdf");
          	header("Content-Disposition:attachment;filename='CierreCaja.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Cierre de Caja - Forma de Pagos");
			$pdf->SetSubject("Cierre de Caja");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$caja_cier_codigo = $user_data["codigo"];
			$hoy = getdate();

			$cierre_caja->get_caja_cierre_fp($caja_cier_codigo);
			$tranx = $cierre_caja->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$item_actual="";
			
			$html .= '<h2>Reporte de Cierre de Caja - Formas de Pago: '.$tranx[0]['cabePago_fecha'].'</h2>';
			$html .= '<h4>Usuario de caja: '.$tranx[0]['usua_codi'].'</h4>';
			$html .= '<h4>Fecha de apertura caja: '.$fecha_h_result.'</h4>';
			$html .= '<h5>Fecha de impresi&oacute;n de: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. '.date('H:i').'. Usuario: '.$_SESSION['usua_codi'].'.</h5> ';
			
			$html .= '<table border="0" cellspacing="0" cellpadding="0">';
			$detaPago_total_gene=0;
			for($i=0;$i<count($cierre_caja->rows)-1;$i++){
				if($item_actual!=$tranx[$i]['formPago_nombre']){
					if($i!=0){
						$html.='<tr><td colspan="6"><hr/></td></tr>';
						$html.='<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Total</b> </td>
							<td align="right"><b>$'.number_format($detaPago_total,2).'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="6">&nbsp;</td>
						</tr>';
					}
					$html.='<tr>
						<th style="width:13%">'.$tranx[$i]['formPago_nombre'].'</th>
						<th style="width:13%">Alumno</th>
						<th style="width:10%">Ref. Int.</th>
						<th style="width:10%" align="right">Valor</th>
						<th style="width:19%" align="center">Fecha</th>
						<th style="width:35%" align="right">Descripción</th>
					</tr>
					<tr>
					<td colspan="6"><hr/></td>
					</tr>';
					$detaPago_total_gene=$detaPago_total_gene+$detaPago_total;
					
					$detaPago_total=0;
				}
				$html.='<tr>
				<td>&nbsp;</td>
				<td>'.$tranx[$i]['alum_codi'].' </td>
				<td>'.$tranx[$i]['deud_codigoDocumento'].' </td>
				<td align="right">$'.$tranx[$i]['detaPago_total'].' </td>
				<td align="right">'.$tranx[$i]['detaPago_fechaCreacion'].' </td>
				<td align="right">'.$tranx[$i]['observacion'].' </td>
				</tr>';
				$item_actual=$tranx[$i]['formPago_nombre'];
				$detaPago_total=$detaPago_total+$tranx[$i]['detaPago_total'];
				
				if($i==count($cierre_caja->rows)-2){
					$html.='<tr><td colspan="6"><hr/></td></tr>';
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total</b> </td>
					<td align="right"><b>$'.number_format($detaPago_total,2).'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="6">&nbsp;</td>
					</tr>';
					$detaPago_total_gene=$detaPago_total_gene+$detaPago_total;
					
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Diario</b> </td>
					<td align="right"><b>$'.number_format($detaPago_total_gene,2).'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="6">&nbsp;</td>
					</tr>';
					
					$cabePago_total=0;
					$detaFact_totalbruto=0;
					$detaFact_totalDescuento=0;
				}
			}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('CierreCaja.pdf', 'I');
			
			break;
		case PRINTREP_NOTACREDITO:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reporte_notaCredito.pdf'"); //considerar... USUARIO, ALUMNO si tiene esa opcion...
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Nota de Cr&eacute;dito");
			$pdf->SetSubject("Reporte de Nota de Cr&eacute;dito");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			//$caja_cier_codigo = $user_data["codigo"];
			$cierre_caja->get_caja_cierre_nc($user_data['codigo'],'%',date('d/m/Y'),date('d/m/Y'));
			$fila = $cierre_caja->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$html .= '<h2>Reporte de Nota de Cr&eacute;dito</h2> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h3>Reporte de Nota de Cr&eacute;dito</h3></td>';
			$html .='<td align="right">'.$reporte_aux->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$saldo_total=0;
			$html .= "<tr><td colspan=\"5\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Codigo</strong></font></td>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Factura</strong></font></td>";
			$html .= "<td align=\"center\" width='15%'><font size=\"10\"><strong>Total Neto Factura</strong></font></td>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Total Nota de Cr&eacute;dito</strong></font></td>";
			$html .= "<td align=\"center\" width='25%'><font size=\"10\"><strong>Fecha Emisi&oacute;n</strong></font></td>";
			$html .= "</tr>";

			$usuario='';
			$alumno='';
			$cedula='';
			$total1=0;
			$total2=0;
			for($i=0;$i<count($fila)-1;$i++)
			{	$col=0;
				$usuario_actual="";
				foreach($fila[$i] as $valor)
				{	
					if($col==1)
					{	$usuario_actual=$valor;
						if($valor!=$usuario)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"5\"><font size=\"12\"><b>Cajero:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$usuario=$valor;
						}
					}
					if($col==3)
					{	if($valor!=$alumno)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr height='100px'><td colspan=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=\"11\"><b>Cliente:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$alumno=$valor;
						}
					}
					if($col==4)
					{	if($valor!=$cedula)
						{	$html .= "<tr height='100px'><td colspan=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=\"9\"><b>Ced. representante:</b> ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$cedula=$valor;
						}
					}
					if($col==5)
					{	$html .= "<tr><td align=\"center\"><font >".$valor."</font></td>";
					}
					if($col==6)
					{	$html .= "<td align=\"center\"><font>".$valor."</font></td>";
					}
					if($col==7)
					{	$html .= "<td align=\"right\"><font>$".number_format($valor,2,'.',',')."</font></td>";
						$total1 = $total1 + $valor;
					}
					if($col==9)
					{	$html .= "<td align=\"right\"><font>$".number_format($valor,2,'.',',')."</font></td>";
						$total2 = $total2 + $valor;
					}
					if($col==10)
					{	$html .= "<td align=\"center\"><font>".$valor."</font></td>";
					}
					$col++;
				}
				$html .= "</tr>";
			}
			$html .= "<tr><td colspan=\"5\"><br></td></tr>";
			$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
			$html .= "<tr><td align=\"left\" valign=\"middle\">
								<font size=\"10\"><b>Total Facturas: </b></font></td><td></td>
							<td align=\"right\" valign=\"middle\"><b>$".number_format($total1,2,'.',',')."</b></td><td></td><td></td></tr>";
			$html .= "<tr><td align=\"left\" valign=\"middle\">
								<font size=\"9\"><b>Total Notas de Cr&eacute;itos: </b></font></td><td></td><td></td>
							<td align=\"right\" valign=\"middle\"><b>$".number_format($total2,2,'.',',')."</b></td><td></td></tr>";
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_notaCredito.pdf', 'I');
			break;
		case PRINTREPVISOR:
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-item" src="'.$user_data['url'].'"></iframe>
				  </div>';
			break;  
        default :
        	break;
    }
}

handler();
?>