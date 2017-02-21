<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../rep_facturas/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $reporte = get_mainObject('Rep_facturas');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $user_data = get_frontData();    
    $permiso = get_mainObject('General');
	$periodos= get_mainObject('General');
	$usuariosFinancieros = get_mainObject('General');//
	$reporte_aux= get_mainObject('General');
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case PRINTREPVISOR:
			$caja_cier_codigo = $user_data["codigo"];
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$user_data['url'].'"></iframe>
					
				  </div>';
			
			break;
		case PRINTREP_CIERRES:
			header("Content-type:application/pdf");
          	header("Content-Disposition:attachment;filename='CierreCaja.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de facturas emitidas");
			$pdf->SetSubject("Reporte de facturas emitidas");
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetMargins( 0, 10, 0 );
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetAutoPageBreak( TRUE, 0 );
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$caja_cier_codigo = $user_data["codigo"];
			$fecha_ini=$user_data["fecha_ini"];
			$fecha_fin=$user_data["fecha_fin"];
			$reporte->get_caja_cierre_items($caja_cier_codigo, $fecha_ini, $fecha_fin);
			$tranx = $reporte->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$item_actual="";
			$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
			$meses_h = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$fecha_h = explode('-',$tranx[0]['cabePago_fecha']);
			$fecha_h_result = $meses_h[(int)$fecha_h[1]-1].' '.$fecha_h[2].', '.$fecha_h[0];
			
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h2>Reporte de Facturas emitidas - Por Curso</h2></td>';
			$html .='<td align="right"><h3>Fecha impresión: '.$fecha_h_result.'. Usuario: '.$tranx[0]['usua_codi'].'</h3></td></tr></table>';
			$html .='<table border="0" cellspacing="0" cellpadding="0">';
			$cabePago_total_gene=0;
			$detaFact_totalNeto_gene=0;
			$detaFact_totalDescuento_gene=0;
			$detaFact_totalIVA_gene=0;
			$detaFact_totalICE_gene=0;
			for($i=0;$i<count($reporte->rows)-1;$i++){
				if($item_actual!=$tranx[$i]['curso']){
					if($i!=0){
						$html.='<tr><td colspan="14"><hr/></td></tr>';
						$html.='<tr>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;"><b>Total</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalNeto,2).'</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($deud_totalProntopago,2).'</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalDescuento,2).'</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalICE,2).'</b> </td>
							<td align="right" style="font-size:small;"><b>$'.number_format($cabePago_total,2).'</b> </td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="14">&nbsp;</td>
						</tr>';
					}
					$html.='<tr>
						<th align="left"   	style="font-size:8;width:9%">'.$tranx[$i]['curso'].'</th>
						<th align="center" 	style="font-size:small;width:19%">Cliente/Alumno</th>
						<th align="center" 	style="font-size:small;width:5%">Fact. ref.</th>
						<th align="right"  	style="font-size:small;width:5%">Pagos ref.</th>
						<th align="right" 	style="font-size:small;width:5%">Total Bruto</th>
						<th align="right" 	style="font-size:x-small;width:5%">(-)Pronto p.</th>
						<th align="right" 	style="font-size:small;width:5%">(-)Dscto.</th>
						<th align="right" 	style="font-size:small;width:5%">I.V.A.</th>
						<th align="right" 	style="font-size:small;width:5%">I.C.E.</th>
						<th align="right" 	style="font-size:small;width:5%">Total Neto</th>
						<th align="right" 	style="font-size:x-small;width:17%">Tipo descuento</th>
						<th align="right" 	style="font-size:small;width:7%">Fecha</th>
						<th align="right" 	style="font-size:small;width:8%">Cajero</th>
					</tr>
					<tr>
					<td colspan="14"><hr/></td>
					</tr>';
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalCE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$detaFact_totalDescuento=0;
				}
				$fecha = explode('-',$tranx[$i]['cabePago_fecha']);
				$fecha_result = $meses[(int)$fecha[1]-1].' '.$fecha[2].', '.$fecha[0];
				$pagos = str_replace('Pagos: ','',$tranx[$i]['cabePago_codigo']);
				$tipo_dcto = str_replace('Descuento ','Dscto. ',$tranx[$i]['detaFact_desc_descripcion']);
				$html.='<tr>
				<td style="font-size:small;">'.$tranx[$i]['prod_nombre'].' </td>
				<td align="center" 	style="font-size:x-small;">'.$tranx[$i]['alum_codi'].' - '.$tranx[$i]['alum_nombre'].' </td>
				<td align="center" 	style="font-size:small;">'.$tranx[$i]['deud_codigoDocumento'].' </td>
				<td align="right"	style="font-size:small;">'.$pagos.' </td>
				<td align="right" 	style="font-size:small;">$'.$tranx[$i]['detaFact_totalbruto'].' </td>
				<td align="right" 	style="font-size:small;">$'.number_format((float)$tranx[$i]['deud_totalProntopago'],2,'.','').'</td>
				<td align="right" 	style="font-size:small;">$'.$tranx[$i]['detaFact_totalDescuento'].' </td>
				<td align="right" 	style="font-size:small;">$'.$tranx[$i]['detaFact_totalIVA'].'</td>
				<td align="right" 	style="font-size:small;">$'.$tranx[$i]['detaFact_totalICE'].'</td>
				<td align="right" 	style="font-size:small;">$'.$tranx[$i]['cabePago_total'].' </td>
				<td align="right" 	style="font-size:small;">'.$tipo_dcto.'</td>
				<td align="right" 	style="font-size:small;">'.$fecha_result.'</td>
				<td align="right" 	style="font-size:small;">'.$tranx[$i]['usua_codi'].' </td>
				</tr>';
				$item_actual=$tranx[$i]['curso'];
				$cabePago_total=$cabePago_total+$tranx[$i]['cabePago_total'];
				$detaFact_totalIVA=$detaFact_totalIVA+$tranx[$i]['detaFact_totalIVA'];
				$detaFact_totalICE=$detaFact_totalICE+$tranx[$i]['detaFact_totalICE'];
				$detaFact_totalNeto=$detaFact_totalNeto+$tranx[$i]['detaFact_totalbruto'];
				$deud_totalProntopago=$deud_totalProntopago+$tranx[$i]['deud_totalProntopago'];
				$detaFact_totalDescuento=$detaFact_totalDescuento+$tranx[$i]['detaFact_totalDescuento'];
				if($i==count($reporte->rows)-2){
					$html.='<tr><td colspan="13"><hr/></td></tr>';
					$html.='<tr>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;"><b>Total</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalNeto,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($deud_totalProntopago,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalDescuento,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalICE,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($cabePago_total,2).'</b> </td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					</tr>
					<tr>
					<td colspan="14">&nbsp;</td>
					</tr>';
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalICE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					$html.='<tr>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;"><b>Total Diario</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalNeto_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($deud_totalProntopago_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalDescuento_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalICE,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($cabePago_total_gene,2).'</b> </td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					</tr>
					<tr>
					<td colspan="14">&nbsp;</td>
					</tr>';
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$deud_totalProntopago=0;
					$detaFact_totalDescuento=0;
				}
			}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('CierreCaja.pdf', 'I');
			
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			global $diccionario;
			$usuariosFinancieros->get_all_financial_users(1,'CAJA','A');
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
            $data=array('txt_fecha_ini'=>$today->format('d/m/Y'),
						'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
						'{combo_cajas}' => array("elemento"  => "combo", 
                                                 "datos"     => $usuariosFinancieros->rows, 
                                                 "options"   => array("name"=>"caja","id"=>"caja","required"=>"required",
												 "class"=>"form-control",
                                                 "onChange"=>""),
												 "selected"  => 0));
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case PRINTREP_CIERRES_XLS:
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Reporte de facturas emitidas")
			->setSubject("Reporte de facturas emitidas")
			->setDescription("Reporte de facturas emitidas");
			
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
			$item_actual="";
			$caja_cier_codigo = $user_data["caja"];
			$fecha_ini=$user_data["txt_fecha_ini"];
			$fecha_fin=$user_data["txt_fecha_fin"];
			
			$reporte->get_caja_cierre_items($caja_cier_codigo, $fecha_ini, $fecha_fin);
			$tranx = $reporte->rows;
			
			$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
			$meses_h = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$fecha_h = explode('-',$tranx[0]['cabePago_fecha']);
			$fecha_h_result = $meses_h[(int)$fecha_h[1]-1].' '.$fecha_h[2].', '.$fecha_h[0];
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, 'Reporte de Facturas Emitidas' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '. $fecha_h_result .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, "" );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			$cabePago_total_gene=0;
			$detaFact_totalNeto_gene=0;
			$detaFact_totalDescuento_gene=0;
			$detaFact_totalIVA_gene=0;
			$detaFact_totalICE_gene=0;
			for($i=0;$i<count($reporte->rows)-1;$i++)
			{   if($item_actual!=$tranx[$i]['curso'])
				{   if($i!=0)
					{   //Subtotal suborden
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "Total" );
						
						//4-9
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total,2) );
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':M'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila = $i_deta_fila + 1;
					}
					if( $user_data['tipo_reporte'] == 'completo' )
					{   $cabeceras =$tranx[$i]['curso'].',Cliente/Alumno,Fact. ref.,Pagos ref.,Total Bruto,(-)Pronto p.,(-)Dscto.,I.V.A.,I.C.E.,Total Neto,Tipo descuento,Fecha,Cajero';
					}
					$cabecera = explode( ",", $cabeceras );
					$i_cabe=0;//Contador de cabeceras
					$column = 'A';
					foreach($cabecera as $head)
					{	if( !empty( $head ) )
						{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe = $i_cabe+1;
							$column++;
						}
					}
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':M'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalCE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$detaFact_totalDescuento=0;
				}
				$fecha = explode('-',$tranx[$i]['cabePago_fecha']);
				$fecha_result = $meses[(int)$fecha[1]-1].' '.$fecha[2].', '.$fecha[0];
				$pagos = str_replace('Pagos: ','',$tranx[$i]['cabePago_codigo']);
				$tipo_dcto = str_replace('Descuento ','Dscto. ',$tranx[$i]['detaFact_desc_descripcion']);
				
				//Prod nombre
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $tranx[$i]['prod_nombre'] );
				
				//Alumno nombre y codigo
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, $tranx[$i]['alum_codi'].' - '.$tranx[$i]['alum_nombre'] );
				
				//código factura
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, $tranx[$i]['deud_codigoDocumento'] );
				
				//Pagos
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, $pagos );
				
				//4-9
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalbruto'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format((float)$tranx[$i]['deud_totalProntopago'],2,'.','') );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalDescuento'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalIVA'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalICE'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($tranx[$i]['cabePago_total'],2) );
				
				//10 Tipo de descuento
				$tipo_dcto = str_replace('<b>', '', $tipo_dcto );
				$tipo_dcto = str_replace('</b>', '', $tipo_dcto );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(10, $i_deta_fila, $tipo_dcto );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(11, $i_deta_fila, $fecha_result );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(12, $i_deta_fila, $tranx[$i]['usua_codi'] );
								
				$i_deta_fila = $i_deta_fila + 1;
				
				$item_actual=$tranx[$i]['curso'];
				$cabePago_total=$cabePago_total+$tranx[$i]['cabePago_total'];
				$detaFact_totalIVA=$detaFact_totalIVA+$tranx[$i]['detaFact_totalIVA'];
				$detaFact_totalICE=$detaFact_totalICE+$tranx[$i]['detaFact_totalICE'];
				$detaFact_totalNeto=$detaFact_totalNeto+$tranx[$i]['detaFact_totalbruto'];
				$deud_totalProntopago=$deud_totalProntopago+$tranx[$i]['deud_totalProntopago'];
				$detaFact_totalDescuento=$detaFact_totalDescuento+$tranx[$i]['detaFact_totalDescuento'];
				if($i==count($reporte->rows)-2){
					//Subtotal suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "Total" );
					
					//4-9
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total,2) );
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':M'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalICE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					//Subtotal suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "Total Diario" );
					
					//4-9
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA_gene,2) ); //aqui puede haber error, probar.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE_gene,2) ); //aqui puede haber error, probar.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total_gene,2) );
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':M'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$deud_totalProntopago=0;
					$detaFact_totalDescuento=0;
				}
			}
			
			foreach(range('A','M') as $columnID)
			{   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Reporte de facturas emitidas');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_facturas_emitidas.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
        	break;
    }
}

handler();
?>