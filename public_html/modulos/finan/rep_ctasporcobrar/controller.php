<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/items/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/rep_ctasporcobrar/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    $reporte 			= get_mainObject('Rep_ctasporcobrar');
    $user_data 			= get_frontData();    
    $permiso 			= get_mainObject('General');
	$item 				= get_mainObject('Item');
	$periodo 			= get_mainObject('Periodo');
	$usuariosFinancieros= get_mainObject('General');
	$reporte_aux		= get_mainObject('General');
	$event 				= get_actualEvents(array(PRINTREPVISOR, PRINTREP_CIERRES, PRINTREP_CIERRES_XLS, VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{
        case PRINTREPVISOR:
			$caja_cier_codigo = $user_data["codigo"];
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$user_data['url'].'"></iframe>
					
				  </div>';
			break;
		case PRINTREP_CIERRES:
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reportedeudores_cierre_cuentas_por_cobrar.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Cierre de Cuentas por Cobrar");
			//$pdf->SetSubject("Reporte de Cierre de Cuentas por Cobrar - Curso (detallado)");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$titulo = $subtitulo = "";
			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			$productos = explode(',', $user_data['productos'] );
			foreach ( $productos as $producto )
			{	if( !empty($producto) && $producto !='null' )

					$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";
			$reporte->get_all_deudores_cierre_cuentas_por_cobrar( 	$user_data['curs_codi'], 
																	$user_data['nivelEcon_codi'],
																	$user_data['peri_codi'],
																	$user_data['fechacorte_fin'], 
																	$xml_productos );
			$titulo='<h2>Reporte de Cierre de Cuentas por Cobrar</h2>';
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			
			$tranx = $reporte->rows;
			$html .= $titulo;
			$html .= $subtitulo;
			$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
			if(strlen($user_data['fechavenc_fin'])>0) $ffin = $user_data['fechacorte_fin']; else $ffin = $hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'];
			$html .= '<h5>Fecha de cierre: '.$ffin.'. (pagos recibidos y deudas generadas hasta la fecha)</h5>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			
			for($i=0;$i<count($tranx)-1;$i++)
			{	if($curso!=$tranx[$i][10])
				{	$k=0;
					$l=0;
					$sumatotal_per_recaudado=0;
					$sumatotal=0;
					$sumatotalrecaudado=0;
					$sumatotaldescuentos=0;
					$sumatotaliva=0;
					$sumatotalneto=0;
					$sumatotalporrecaudar=0;
					$sumatotalnc=0;
					$total=0;
					$totalrecaudado=0;
					$totaldescuentos=0;
					$totaliva=0;
					$totalneto=0;
					$totalnc=0;
					$totalporrecaudar=0;
					$curso=$tranx[$i][10];
					$html .="
					<tr ><td height=\"25\" colspan=\"6\" ><font size=\"14\"><strong>".$curso."</strong></font></td></tr>
					<tr><td colspan=\"11\"><hr/></td></tr>";
				}
				if($grupo!=$tranx[$i][0])
				{	$k=0;
					$sumatotal_per_recaudado=0;
					$total_per_recaudado=0;
					$sumatotal=0;
					$sumatotalrecaudado=0;
					$sumatotaldescuentos=0;
					$sumatotaliva=0;
					$sumatotalneto=0;
					$sumatotalporrecaudar=0;
					$sumatotalnc=0;
					$grupo=$tranx[$i][0];
					$curso=$tranx[$i][10];
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"9\"><strong>".$grupo."</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>F. creación</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. Bruto</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. Dscto.</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. I.V.A.</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. Neto</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. Abonado</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. N/C</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>T. Pendiente</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>% Pdte.</strong></font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\"><strong>Teléfono</strong></font></td>";
					$html .= "</tr>";
					$l++;
				}
				$html .= "<tr>";	
					$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">".$tranx[$i][2]."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][6],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][7],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][8],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">$".number_format($tranx[$i][9],2,'.',',')."</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%</font></td>";
					$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"7\">".$tranx[$i][11]."</font></td>";
					
					$sumatotal				=$sumatotal				+ $tranx[$i][3];
					$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
					$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
					$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
					$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
					$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
					$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
				$html .= "</tr>";
				$k++;
				if($grupo!=$tranx[$i+1][0])
				{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
					$total				= $total			+ $sumatotal;
					$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
					$totaliva			= $totaliva			+ $sumatotaliva;
					$totalneto			= $totalneto		+ $sumatotalneto;
					$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
					$totalnc			= $totalnc			+ $sumatotalnc;
					$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
					$html .="
					<tr >
						<td><font size=\"8\" ><strong>Subtotal de ".$k." deuda(s):</strong></font> </td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"7\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
					</tr>";
				}
				if($curso!=$tranx[$i+1][10])
				{   $finaltotal				= $finaltotal			+ $total;
					$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
					$finaltotaliva			= $finaltotaliva		+ $totaliva;
					$finaltotalneto			= $finaltotalneto		+ $totalneto;
					$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
					$finaltotalnc			= $finaltotalnc			+ $totalnc;
					$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
					$html .="
					<tr >
						<td ><font size=\"7\" ><strong>Total (".$curso."):</strong></font> </td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($total,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totaliva,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totalneto,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totalnc,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($totalporrecaudar,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%</strong></font></td>
					</tr>";
				}
			}
			$html .="
					<tr >
						<td ><font size=\"9\" ><strong>Total de ".$l." alumno(s) y ".$i." deuda(s):</strong></font> </td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotal,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotaliva,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotalneto,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotalnc,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\" ><font size=\"7\"><strong>".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%</strong></font></td>
					</tr>";
			$html .= "<tr >
						<td colspan=\"2\"><font size=\"9\" ><strong>Total por Cobrar:</strong></font></td>
						<td align=\"right\" height=\"30\" colspan=\"7\" ><font size=\"8\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
						<td></td></tr>";
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportedeudores_cierre_cuentas_por_cobrar.pdf', 'I');
			break;
		case PRINTREP_CIERRES_XLS:
			$hoy = getdate();
			if(strlen($user_data['fechavenc_fin'])>0) $ffin = $user_data['fechacorte_fin']; else $ffin = $hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'];
			
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator('Redlinks')
			->setLastModifiedBy('Redlinks')
			->setTitle("Cierre de Cuentas por Cobrar")
			->setSubject("Cierre de Cuentas por Cobrar")
			->setDescription("Cierra de CC, ".$ffin.".");
			
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
			
			$styleTitulo = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'000000'),
								'size' => 14,
								'bold' => true,
								'name' => 'Helvetica')
			);
			$styleEncabezado = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 11,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '5A8FDC'))
			);
			$styleCabeceras = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('size' => 9,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'E1EAF8'))
			);
			$styleTotalFinal = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 12,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '20529b'))
			);
			
			$titulo = $subtitulo = "";
			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			$productos = explode(',', $user_data['productos'] );
			foreach ( $productos as $producto )
			{	if( !empty($producto) && $producto !='null' )

					$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";
			$reporte->get_all_deudores_cierre_cuentas_por_cobrar( 	$user_data['curs_codi'], 
																	$user_data['nivelEcon_codi'],
																	$user_data['peri_codi'],
																	$user_data['fechacorte_fin'], 
																	$xml_productos );
			$tranx = $reporte->rows;
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, 'Reporte de Cierre de Cuentas por Cobrar' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, 'Fecha de cierre: '.$ffin.'. (pagos recibidos y deudas generadas hasta la fecha)' );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$cabeceras ='F. creación,T. Bruto,T. Dscto.,T. I.V.A.,T. Neto,T. Abonado,T. N/C,T. Pendiente,% Pdte.,Teléfono';
			$cabecera = explode( ",", $cabeceras );
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			/*
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}*/
			
			//INICIO DEL CUERPO DE EXCEL
			
			$tranx = $reporte->rows;
			
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			
			for($i=0;$i<count($tranx)-1;$i++)
			{	if($curso!=$tranx[$i][10])
				{	$k=0;
					$l=0;
					$sumatotal_per_recaudado=0;
					$sumatotal=0;
					$sumatotalrecaudado=0;
					$sumatotaldescuentos=0;
					$sumatotaliva=0;
					$sumatotalneto=0;
					$sumatotalporrecaudar=0;
					$sumatotalnc=0;
					$total=0;
					$totalrecaudado=0;
					$totaldescuentos=0;
					$totaliva=0;
					$totalneto=0;
					$totalnc=0;
					$totalporrecaudar=0;
					$curso=$tranx[$i][10];
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$curso."");
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
			
					$i_deta_fila=$i_deta_fila+1;
				}
				if($grupo!=$tranx[$i][0])
				{	$k=0;
					$sumatotal_per_recaudado=0;
					$total_per_recaudado=0;
					$sumatotal=0;
					$sumatotalrecaudado=0;
					$sumatotaldescuentos=0;
					$sumatotaliva=0;
					$sumatotalneto=0;
					$sumatotalporrecaudar=0;
					$sumatotalnc=0;
					$grupo=$tranx[$i][0];
					$curso=$tranx[$i][10];
					
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$i_cabe=1;//Contador de cabeceras
					$column = 'B';
					
					foreach($cabecera as $head)
					{	if( !empty( $head ) )
						{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
						}
					}
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					//$i_deta_col=$i_deta_col+1;
					$i_deta_fila=$i_deta_fila+1;
					$l++;
				}
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$tranx[$i][1]."" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Fecha creación deuda
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "".$tranx[$i][2]."" );
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				for( $aux=2; $aux<=8; $aux++ )
				{   //Valores monetarios
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $aux, $i_deta_fila, "$".number_format($tranx[$i][($aux+1)],2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				}
				//% Pdte.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%" );
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Teléfono
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "".$tranx[$i][11]."" );
				$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
					
				$sumatotal				=$sumatotal				+ $tranx[$i][3];
				$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
				$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
				$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
				$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
				$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
				$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
				
				$i_deta_fila=$i_deta_fila+1;
				$k++;
				if($grupo!=$tranx[$i+1][0])
				{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
					$total				= $total			+ $sumatotal;
					$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
					$totaliva			= $totaliva			+ $sumatotaliva;
					$totalneto			= $totalneto		+ $sumatotalneto;
					$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
					$totalnc			= $totalnc			+ $sumatotalnc;
					$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
					
					
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal de ".$k." deuda(s):" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Fecha creación deuda
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Valores monetarios
					
					//1
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//2
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//3
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//4
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//5
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//6
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//7
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//. Valores monetarios
					
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Teléfono
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
					$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila=$i_deta_fila+1;
				}
				if($curso!=$tranx[$i+1][10])
				{   $finaltotal				= $finaltotal			+ $total;
					$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
					$finaltotaliva			= $finaltotaliva		+ $totaliva;
					$finaltotalneto			= $finaltotalneto		+ $totalneto;
					$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
					$finaltotalnc			= $finaltotalnc			+ $totalnc;
					$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
					
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total (".$curso."):" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Fecha creación deuda
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Valores monetarios
					
					//1
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($total,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//2
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($totaldescuentos,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//3
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($totaliva,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//4
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($totalneto,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//5
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($totalrecaudado,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//6
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($totalnc,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					//7
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($totalporrecaudar,2,'.',',')."" );
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//. Valores monetarios
					
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Teléfono
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
					$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
					$i_deta_fila=$i_deta_fila+1;
				}
			}
			
			//Nombre alumno
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total de ".$l." alumno(s) y ".$i." deuda(s):" );
			$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			//Fecha creación deuda
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
			$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			//Valores monetarios
			
			//1
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($finaltotal,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//2
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($finaltotaldescuentos,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//3
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($finaltotaliva,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//4
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($finaltotalneto,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//5
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($finaltotalrecaudado,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//6
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalnc,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			//7
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',')."" );
			$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			//. Valores monetarios
			
			//% Pdte.
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%" );
			$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			//Teléfono
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
			$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
			$i_deta_fila=$i_deta_fila+1;
			
			//Nombre alumno
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total por Cobrar:" );
			$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			//Total Por Cobrar $X
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',') );
			$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			
			$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
			$i_deta_fila=$i_deta_fila+1;
			
			$objPHPExcel->getActiveSheet()->setTitle('Cierre de Cuentas por Cobrar');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_cierre_cc.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case PRINTREP_DEUDORES_REPT_XLS:
			$hoy = getdate();
			if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
			if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
			
			$titulo = $subtitulo = "";
			switch($user_data['quienes'])
			{	case 'P':
					$subtitulo='Deudas pagadas';
				break;
				case 'PC':
					$subtitulo='Deudas por cobrar';
				case 'T':
					$subtitulo='Todas las deudas (Pagadas/Por cobrar/Anuladas)';
				break;					
			}
			
			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			$productos = explode(',', $user_data['productos'] );
			foreach ( $productos as $producto )
			{	if( !empty($producto) && $producto !='null' )
					$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";
			
			switch($user_data['eventox'])
			{	case 'print_deudores_curso':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_curso( $user_data['curs_codi'], 
																				$user_data['nivelEcon_codi'],
																				$user_data['peri_codi'],
																				$user_data['fechacorte_fin'], 
																				$xml_productos );
					$tranx = $reporte->rows;
					$titulo='Reporte de Cierre de Cuentas por Cobrar - Curso';
				break;
				case 'print_deudores_curso_detalle':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar(   $user_data['curs_codi'], 
																			$user_data['nivelEcon_codi'],
																			$user_data['peri_codi'],
																			$user_data['fechacorte_fin'], 
																			$xml_productos );
					$tranx = $reporte->rows;
					$titulo='Reporte de Cierre de Cuentas por Cobrar - Curso (detallado)';
				break;
				case 'print_deudores_mensual':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_producto( 	$user_data['curs_codi'], 
																					$user_data['nivelEcon_codi'],
																					$user_data['peri_codi'],
																					$user_data['fechacorte_fin'], 
																					$xml_productos );
					$tranx = $reporte->rows;
					$titulo='Reporte de Cierre de Cuentas por Cobrar - Por Producto';
				break;
				case 'print_deudores_resumen':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_resumen( 	$user_data['curs_codi'], 
																					$user_data['nivelEcon_codi'],
																					$user_data['peri_codi'],
																					$user_data['fechacorte_fin'], 
																					$xml_productos );
					$tranx = $reporte->rows;
					$titulo='Reporte de Cierre de Cuentas por Cobrar - Resumen';
				break;
			}
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator('Redlinks')
			->setLastModifiedBy('Redlinks')
			->setTitle($titulo)
			->setSubject($titulo)
			->setDescription("Fecha de vencimiento del: ".$fini.", hasta el: ".$ffin.".");
			
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
			
			$styleTitulo = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'000000'),
								'size' => 14,
								'bold' => true,
								'name' => 'Helvetica')
			);
			$styleEncabezado = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 11,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '5A8FDC'))
			);
			$styleCabeceras = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('size' => 9,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'E1EAF8'))
			);
			$styleTotalFinal = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 12,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '20529b'))
			);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, $titulo );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, "Fecha de vencimiento del: ".$fini.", hasta el: ".$ffin.". ".$subtitulo );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			if( $user_data['eventox'] == 'print_deudores_curso_detalle' )
			{	
				$cabeceras ='F. creación,T. Bruto,T. Dscto.,T. I.V.A.,T. Neto,T. Abonado,T. N/C,T. Pendiente,% Pdte.,Teléfono';
				$cabecera = explode( ",", $cabeceras );
				
				for($i=0;$i<count($tranx)-1;$i++)
				{	if($curso!=$tranx[$i][10])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][10];
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$curso."");
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
				
						$i_deta_fila=$i_deta_fila+1;
					}
					if($grupo!=$tranx[$i][0])
					{	$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][10];
						
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$i_cabe=1;//Contador de cabeceras
						$column = 'B';
						
						foreach($cabecera as $head)
						{	if( !empty( $head ) )
							{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$i_cabe=$i_cabe+1;
								$column++;
							}
						}
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						$l++;
					}
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$tranx[$i][1]."" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Fecha creación deuda
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "".$tranx[$i][2]."" );
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					for( $aux=2; $aux<=8; $aux++ )
					{   //Valores monetarios
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $aux, $i_deta_fila, "$".number_format($tranx[$i][($aux+1)],2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					}
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Teléfono
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "".$tranx[$i][11]."" );
					$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
						
					$sumatotal				=$sumatotal				+ $tranx[$i][3];
					$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
					$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
					$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
					$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
					$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
					$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
					
					$i_deta_fila=$i_deta_fila+1;
					$k++;
					if($grupo!=$tranx[$i+1][0])
					{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
						$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
						
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal de ".$k." deuda(s):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Fecha creación deuda
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Teléfono
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
					}
					if($curso!=$tranx[$i+1][10])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total (".$curso."):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Fecha creación deuda
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($total,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($totaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($totaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($totalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($totalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($totalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($totalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Teléfono
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$i_deta_fila=$i_deta_fila+1;
					}
				}
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total de ".$l." alumno(s) y ".$i." deuda(s):" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Fecha creación deuda
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Valores monetarios
				
				//1
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($finaltotal,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//2
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($finaltotaldescuentos,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//3
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($finaltotaliva,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//4
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($finaltotalneto,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//5
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($finaltotalrecaudado,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//6
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalnc,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//7
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//. Valores monetarios
				
				//% Pdte.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%" );
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Teléfono
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
				$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total por Cobrar:" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Total Por Cobrar $X
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',') );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				$objPHPExcel->getActiveSheet()->setTitle('Cierre de Cuentas por Cobrar');
				$objPHPExcel->setActiveSheetIndex(0);
			}
			else
			{   $cabeceras ='T. Bruto,T. Dscto.,T. I.V.A.,T. Neto,T. Abonado,T. N/C,T. Pendiente,% Pdte.';
				$cabecera = explode( ",", $cabeceras );
				
				for($i=0;$i<count($tranx)-1;$i++)
				{	if($curso!=$tranx[$i][9])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][9];
						
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$curso."");
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
				
						$i_deta_fila=$i_deta_fila+1;
						$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][9];
						
						$detalle_header = $grupo;
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$i_cabe=1;//Contador de cabeceras
						$column = 'B';
						
						foreach($cabecera as $head)
						{	if( !empty( $head ) )
							{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$i_cabe=$i_cabe+1;
								$column++;
							}
						}
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
					}else
					{   if($grupo!=$tranx[$i][0])
						{	$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							
							$detalle_header = $grupo;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$i_cabe=1;//Contador de cabeceras
							$column = 'B';
							
							foreach($cabecera as $head)
							{	if( !empty( $head ) )
								{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
									$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
									$i_cabe=$i_cabe+1;
									$column++;
								}
							}
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleCabeceras );
							$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
							
							$i_deta_fila=$i_deta_fila+1;
						}
					}
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$tranx[$i][1]."" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					for( $aux=1; $aux<=7; $aux++ )
					{   //Valores monetarios
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $aux, $i_deta_fila, "$".number_format($tranx[$i][($aux+1)],2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					}
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($tranx[$i][8]*100)/$tranx[$i][5],2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$sumatotal				=$sumatotal				+ $tranx[$i][2];
					$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][3];
					$sumatotaliva			=$sumatotaliva			+ $tranx[$i][4];
					$sumatotalneto			=$sumatotalneto			+ $tranx[$i][5];
					$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][6];
					$sumatotalnc			=$sumatotalnc			+ $tranx[$i][7];
					$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][8];
					
					$i_deta_fila=$i_deta_fila+1;
					
					$k++;
					$l++;
					if($grupo!=$tranx[$i+1][0] )
					{	$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
													
						if ( $user_data['eventox'] == 'print_deudores_curso' || $user_data['eventox'] == 'print_deudores_mensual_detalle' )
						{	if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
							else
								$detalle_subtotal="Subtotal (1 alumnos):";
						}
						else
						{   if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." cursos):";
							else
								$detalle_subtotal="Subtotal (1 curso):";
						}
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_subtotal );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
						$i_deta_fila=$i_deta_fila+1;
					}
					else
					{   if ( ( $user_data['eventox'] == 'print_deudores_mensual_detalle' ) && ( $curso!=$tranx[$i+1][9] ) )
						{	$total				= $total			+ $sumatotal;
							$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
							$totaliva			= $totaliva			+ $sumatotaliva;
							$totalneto			= $totalneto		+ $sumatotalneto;
							$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
							$totalnc			= $totalnc			+ $sumatotalnc;
							$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
							
							if ($k>1)
									$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
								else
									$detalle_subtotal="Subtotal (1 alumnos):";
							//Nombre alumno
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_subtotal );
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							//Valores monetarios
							
							//1
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//2
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//3
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//4
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//5
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//6
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//7
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
							//. Valores monetarios
							
							//% Pdte.
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
							$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
							$i_deta_fila=$i_deta_fila+1;
						}
					}
					if($curso!=$tranx[$i+1][9])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total (".$curso."):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($total,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($totaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($totaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($totalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($totalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($totalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($totalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
						$i_deta_fila=$i_deta_fila+1;
					}
				}
				if ( $user_data['eventox'] == 'print_deudores_curso')
				{	if ($i>1)
						$detalle_total="Total (de entre ".$i." alumnos):";
					else
						$detalle_total="Total (1 alumnos):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual_detalle' )
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." deudas):";
					else
						$detalle_total="Total (1 deuda):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual' )
				{   if ($l>1)
						$detalle_total="Total (de entre ".$l." productos):";
					else
						$detalle_total="Total (1 producto):";
				}
				else
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." cursos):";
					else
						$detalle_total="Total (1 curso):";
				}
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_total );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Valores monetarios
				
				//1
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($finaltotal,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//2
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($finaltotaldescuentos,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//3
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($finaltotaliva,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//4
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($finaltotalneto,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//5
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($finaltotalrecaudado,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//6
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($finaltotalnc,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//7
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//. Valores monetarios
				
				//% Pdte.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%" );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total por Cobrar:" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Total Por Cobrar $X
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',') );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				$objPHPExcel->getActiveSheet()->setTitle('Cierre de Cuentas por Cobrar');
				$objPHPExcel->setActiveSheetIndex(0);
			}
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Reporte_cierre_CC.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case PRINTREP_DEUDORES_REPT:
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reportedeudoresresumen.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Cierre de Cuentas por Cobrar - Curso (detallado)");
			$pdf->SetSubject("Reporte de Cierre de Cuentas por Cobrar - Curso (detallado)");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$titulo = $subtitulo = "";
			switch($user_data['quienes'])
			{	case 'P':
					$subtitulo='<h3>Deudas pagadas</h3> ';
				break;
				case 'PC':
					$subtitulo='<h3>Deudas por cobrar</h3> ';
				case 'T':
					$subtitulo='<h3>Todas las deudas (Pagadas/Por cobrar/Anuladas)</h3>';
				break;					
			}
			$titulo = $subtitulo = "";
			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			$productos = explode(',', $user_data['productos'] );
			foreach ( $productos as $producto )
			{	if( !empty($producto) && $producto !='null' )
					$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";
			switch($user_data['eventox'])
			{	case 'print_deudores_curso':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_curso( $user_data['curs_codi'], 
																				$user_data['nivelEcon_codi'],
																				$user_data['peri_codi'],
																				$user_data['fechacorte_fin'], 
																				$xml_productos );
					$titulo='<h2>Reporte de Cierre de Cuentas por Cobrar - Curso</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_curso_detalle':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar( 	$user_data['curs_codi'], 
																			$user_data['nivelEcon_codi'],
																			$user_data['peri_codi'],
																			$user_data['fechacorte_fin'], 
																			$xml_productos );
					$titulo='<h2>Reporte de Cierre de Cuentas por Cobrar - Curso (detallado)</h2>';
					$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_mensual':
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_producto( 	$user_data['curs_codi'], 
																					$user_data['nivelEcon_codi'],
																					$user_data['peri_codi'],
																					$user_data['fechacorte_fin'], 
																					$xml_productos );
					$titulo='<h2>Reporte de Cierre de Cuentas por Cobrar - Por Producto</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_resumen':
					
					$reporte->get_all_deudores_cierre_cuentas_por_cobrar_resumen( 	$user_data['curs_codi'], 
																					$user_data['nivelEcon_codi'],
																					$user_data['peri_codi'],
																					$user_data['fechacorte_fin'], 
																					$xml_productos );
					$titulo='<h2>Reporte de Cierre de Cuentas por Cobrar - Resumen</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
			}
			$tranx = $reporte->rows;;
			$html .= $titulo;
			$html .= $subtitulo;
			$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
			if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
			if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
			$html .= '<h5>Fecha de vencimiento del: '.$fini.', hasta el: '.$ffin.'.</h5>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$col=0;
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			if( $user_data['eventox'] == 'print_deudores_curso_detalle' )
			{
				for($i=0;$i<count($tranx)-1;$i++)
				{	$col=0;
					if($curso!=$tranx[$i][10])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][10];
						$html .="
						<tr ><td height=\"25\" colspan=\"6\" ><font size=\"14\"><strong>".$curso."</strong></font></td></tr>
						<tr><td colspan=\"11\"><hr/></td></tr>";
					}
					if($grupo!=$tranx[$i][0])
					{	$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][10];
						$html .= "<tr>";	
							$html .= "<td width=\"35%\"><font size=\"9\"><strong>".$grupo."</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>F. creación</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Abonado</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Pendiente</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>% Pdte.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>Teléfono</strong></font></td>";
						$html .= "</tr>";
						$l++;
					}
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".$tranx[$i][2]."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][6],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][7],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][8],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][9],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".$tranx[$i][11]."</font></td>";
						
						$sumatotal				=$sumatotal				+ $tranx[$i][3];
						$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
						$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
						$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
						$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
						$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
						$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
					$html .= "</tr>";
					$k++;
					if($grupo!=$tranx[$i+1][0])
					{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
						$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
						$html .="
						<tr >
							<td><font size=\"8\" ><strong>Subtotal de ".$k." deuda(s):</strong></font> </td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
						</tr>";
					}
					if($curso!=$tranx[$i+1][10])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						$html .="
						<tr >
							<td ><font size=\"5\" ><strong>Total (".$curso."):</strong></font> </td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($total,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%</strong></font></td>
						</tr>";
					}
				}
				$html .="
						<tr >
							<td ><font size=\"9\" ><strong>Total de ".$l." alumno(s) y ".$i." deuda(s):</strong></font> </td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%</strong></font></td>
						</tr>";
				$html .= "<tr >
							<td colspan=\"2\"><font size=\"9\" ><strong>Total por Cobrar:</strong></font></td>
							<td align=\"right\" height=\"30\" colspan=\"7\" ><font size=\"8\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td></td></tr>";
				$html .= "</table>";
			}
			else
			{   for($i=0;$i<count($tranx)-1;$i++)
				{	$col=0;
					if($curso!=$tranx[$i][9])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][9];
						$html .="<tr><td colspan=\"9\"></td></tr>
						<tr ><td height=\"25\" colspan=\"9\" ><font size=\"8\"><strong>".$curso."</strong></font></td></tr>
						<tr><td colspan=\"9\"><hr/></td></tr>";
						$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							/*if ($grupo==$curso)
								$detalle_header = $grupo;
							else
								$detalle_header = "";*/
							$detalle_header = $grupo;
							$html .= "<tr>";	
								$html .= "<td width=\"35%\"><font size=\"6\"><strong>".$detalle_header."</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Abono</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Pdte</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>% Pdte</strong></font></td>";
							$html .= "</tr>";
					}else
					{   if($grupo!=$tranx[$i][0])
						{	$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							/*if ($grupo==$curso)
								$detalle_header = $grupo;
							else
								$detalle_header = "";*/
							$detalle_header = $grupo;
							$html .= "<tr>";	
								$html .= "<td width=\"35%\"><font size=\"6\"><strong>".$detalle_header."</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Abono</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Pdte</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>% Pdte</strong></font></td>";
							$html .= "</tr>";
						}
					}
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"5\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][2],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][6],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][7],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][8],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">".number_format(($tranx[$i][8]*100)/$tranx[$i][5],2,'.',',')."%</font></td>";
						
						$sumatotal				=$sumatotal				+ $tranx[$i][2];
						$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][3];
						$sumatotaliva			=$sumatotaliva			+ $tranx[$i][4];
						$sumatotalneto			=$sumatotalneto			+ $tranx[$i][5];
						$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][6];
						$sumatotalnc			=$sumatotalnc			+ $tranx[$i][7];
						$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][8];
					$html .= "</tr>";
					
					$k++;
					$l++;
					if($grupo!=$tranx[$i+1][0] )
					{	$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
													
						if ( $user_data['eventox'] == 'print_deudores_curso' || $user_data['eventox'] == 'print_deudores_mensual_detalle' )
						{	if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
							else
								$detalle_subtotal="Subtotal (1 alumnos):";
						}
						else
						{   if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." cursos):";
							else
								$detalle_subtotal="Subtotal (1 curso):";
						}
						$html .="
						<tr >
							<td><font size=\"5\" ><strong>".$detalle_subtotal."</strong></font> </td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
						</tr>
						<tr><td colspan=\"9\"><hr/></td></tr>";
					}
					else
					{   if ( ( $user_data['eventox'] == 'print_deudores_mensual_detalle' ) && ( $curso!=$tranx[$i+1][9] ) )
						{	$total				= $total			+ $sumatotal;
							$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
							$totaliva			= $totaliva			+ $sumatotaliva;
							$totalneto			= $totalneto		+ $sumatotalneto;
							$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
							$totalnc			= $totalnc			+ $sumatotalnc;
							$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
							
							if ($k>1)
									$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
								else
									$detalle_subtotal="Subtotal (1 alumnos):";
								
							$html .="
							<tr >
								<td><font size=\"8\" ><strong>".$detalle_subtotal."</strong></font> </td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
							</tr>
							<tr><td colspan=\"9\"><hr/></td></tr>";
						}
					}
					if($curso!=$tranx[$i+1][9])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						/*if ( $grupo!=$curso )
						{*/   $html .="
							<tr >
								<td ><font size=\"5\" ><strong>Total (".$curso."):</strong></font> </td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($total,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaldescuentos,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaliva,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalneto,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalrecaudado,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalnc,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalporrecaudar,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%</strong></font></td>
							</tr>";
						/*}*/
					}
				}
				if ( $user_data['eventox'] == 'print_deudores_curso')
				{	if ($i>1)
						$detalle_total="Total (de entre ".$i." alumnos):";
					else
						$detalle_total="Total (1 alumnos):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual_detalle' )
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." deudas):";
					else
						$detalle_total="Total (1 deuda):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual' )
				{   if ($l>1)
						$detalle_total="Total (de entre ".$l." productos):";
					else
						$detalle_total="Total (1 producto):";
				}
				else
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." cursos):";
					else
						$detalle_total="Total (1 curso):";
				}
				$html .="
						<tr >
							<td ><font size=\"5\" ><strong>".$detalle_total."</strong></font> </td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>".number_format(($finaltotalporrecaudar*100)/$finaltotalneto ,2,'.',',')."%</strong></font></td>
						</tr>";
				$html .= "
						<tr >
							<td colspan=\"2\"><font size=\"5\" ><strong>Total por Cobrar:</strong></font></td>
							<td colspan=\"6\" align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td></td>
						</tr>";
				$html .= "</table>";
			}
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportedeudoresresumen_curso_detalle.pdf', 'I');
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			global $diccionario;
			$usuariosFinancieros->get_all_financial_users(1,'CAJA','A');
			$periodo->get_all_selectFormat();
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
            $data=array('txt_fecha_ini'=>$today->format('d/m/Y'),
						'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
						'{combo_cajas}' => array("elemento"  => "combo", 
                                                 "datos"     => $usuariosFinancieros->rows, 
                                                 "options"   => array("name"=>"caja","id"=>"caja","required"=>"required",
												 "class"=>"form-control",
                                                 "onChange"=>""),
												 "selected"  => 0),
						'{combo_periodo}' => array(	"elemento"  => "combo", 
													"datos"     => $periodo->rows, 
													"options"   => array("name"=>"periodos","id"=>"periodos","required"=>"required", "class"=>"form-control input-sm",
													"onChange"=>"cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
													"selected"  => $_SESSION['peri_codi'] ),
						'{combo_cursos}' => array("elemento"  => "combo", 
												  "datos"     => array(0 => array(0 => -1, 
																				  1 => '- Seleccione curso -',
																				  3 => ''), 
																	   1=> array()),
												  "options"   => array("name"=>"curso","id"=>"curso","required"=>"required", "class"=>"form-control input-sm",
												  "onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
												  "selected"  => -1)
						);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{combo_nivel}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control input-sm",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));

			
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto\" class='form-control input-sm' data-placeholder='- Seleccione producto -' >";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$data['cmb_producto'] = $select;
			retornar_vista(VIEW_GET_ALL, $data);
            break;
    }
}

handler();
?>