<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/items/model.php');
require_once('../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    $reportes 			= get_mainObject('Rep_antiquity');
    $user_data 			= get_frontData();    
    $permiso 			= get_mainObject('General');
	$item 				= get_mainObject('Item');
	$periodo 			= get_mainObject('Periodo');
	$usuariosFinancieros= get_mainObject('General');
	$pensiones			= get_mainObject('General');
	$event 				= get_actualEvents(array(PRINTREPVISOR, PRINTREP_CIERRES, PRINTREP_CIERRES_XLS, VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{
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
			$data['tabla'] = "<span style='font-size:small'>Haga clic en buscar para realizar una consulta.</span>";
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case PRINTREPVISOR:
			$caja_cier_codigo = $user_data["codigo"];
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$user_data['url'].'"></iframe>
					
				  </div>';
			break;
		case PRINTREP_DEUDORES_HTML: //IMPRIME EL REPORTE EN DATATABLE
			$hoy = getdate();
			
			if ( $user_data['peri_codi'] == "" )
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			
			$reportes->get_all_deudores($user_data['curs_codi'],	$user_data['nivelEcon_codi'],	$user_data['peri_codi'],
										$user_data['fechavenc_fin'] );
			
			$tranx = $reportes->rows;
			
			$html .='<table id="antiquity_table" name="antiquity_table" class="table table-striped table-bordered">';
			$html .='<thead><tr>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">Curso</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">Código</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;" >Alumno</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">Por vencer</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">30 días</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">60 días</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">90 días</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">120 días</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">> 120 días</th>';
			$html .='<th align="center" valign="center" style="font-size:x-small;">Total</th>';
			$html .='</tr></thead>';
			$html .='<tbody>';
			$col=0;
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			for($i=0;$i<count($tranx)-1;$i++)
			{	$html .= "<tr>";
				$col2=0;
				foreach ($tranx[$i] as $valor)
				{	$col2=$col2+1;
					if ($col2==3)
					{	$html .= '<td style="font-size:x-small;">'.$valor."</td>";
					}
					elseif( $col2==1 || $col2==2 )
					{	$html .= '<td align="center" style="font-size:x-small;">'.$valor."</td>";
						if ($col2==1)
							$cursoactual = $valor;
					}
					elseif($col2>3)
					{	if( is_numeric( $valor ) )
						{	$html .= '<td align="right" style="font-size:x-small;">$'.number_format($valor,2,'.',',').'</td>';
							$total_mensual[$col2] = $total_mensual[$col2] + $valor;
						}
						else
						{	$html .= '<td align="center" style="font-size:x-small;">'.$valor.'</td>';
							$total_mensual[$col2] = 0 ;
						}
					}
				}
				$html .= "</tr>";
			}
			//Total por mes
			$html .='<tr><td></td><td align="center" valign="center" style="font-size:x-small;">TOTAL DEUDA</td><td></td>';
			for($aux=4;$aux<($col2+1);$aux++)
			{	$html .= '<td align="right" valign="center" style="font-size:x-small;">$'.number_format($total_mensual[$aux],2,'.',',').'</td>';
			}
			$html .="</tr>";
			$html .='</tbody>';
			$html .= "</table>";
			echo $html;
			break;
		case PRINTREP_DEUDORES: //IMPRIME EL REPORTE EN PDF
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reporte_antiguedad.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de antigüedad de saldos");
			$pdf->SetSubject("Reporte de antigüedad de saldos");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			if ( $user_data['peri_codi'] == "" )
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			
			$reportes->get_all_deudores($user_data['curs_codi'],	$user_data['nivelEcon_codi'],	$user_data['peri_codi'],
										$user_data['fechavenc_fin'] );
			
			$tranx = $reportes->rows;
			
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			
			$html .= '<h2>Reporte de antigüedad de saldos</h2>';
			$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
			if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
			$html .= '<h5>Fecha de corte : '.$ffin.'.</h5>';
			$html .='<table cellspacing="0" cellpadding="1" border="1">';
			$col=0;
			$maxcol = 0;
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			for($i=0;$i<count($tranx)-1;$i++)
			{	$html .= "<tr>";
				$col2=0;
				foreach ($tranx[$i] as $valor)
				{	$col2=$col2+1;
					if ($col2==3)
					{	$html .= '<td colspan="2" style="font-size:x-small;">'.$valor."</td>";
					}
					elseif($col2==2)
					{	$html .= '<td colspan="1" align="center" style="font-size:x-small;">'.$valor."</td>";
					}
					elseif($col2>3)
					{	if( is_numeric( $valor ) )
						{	$html .= "<td align=\"right\" style=\"font-size:x-small;\">$".number_format($valor,2,'.',',')."</td>";
							$total_mensual[$col2] = $total_mensual[$col2] + $valor;
							$total_mensual_aux[$col2] = $total_mensual_aux[$col2] + $valor;
						}
						else
						{	$html .= "<td align=\"right\" style=\"font-size:x-small;\">".$valor."</td>";
							$total_mensual[$col2] = 0 ;
							$total_mensual_aux[$aux] = 0 ;
						}
					}
					else
					{	if($cursoactual!=$valor)
						{	if ( $i!=0 )
							{   $html .='<td></td><td colspan="2" align="left"><b><small>TOTAL PENSIONES '.$valor.'</small></b></td>';
								for($aux=4;$aux<($maxcol+1);$aux++)
								{	if ($total_mensual_aux[$aux] != 0 )
										$html .= '<td align="right" style="font-size:x-small;" ><b>$'.number_format($total_mensual_aux[$aux],2,'.',',').'</b></td>';
									else
										$html .= '<td align="right" style="font-size:x-small;" ><b>$0</b></td>';
								}
								$html .='</tr><tr>';
								$total_mensual_aux[$col2] = 0;
							}
							$contadorcabec= ( count($tranx[$i]) ); //Producto, prontopago, descuento, subtotal
							$html .= '<td style="font-size:12; "height="30" colspan="10"><b>'.$valor."</b></td></tr><tr>";
							$col=0;
							$html .='<td align="center" valign="center" style="font-size:x-small;">Código</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;" colspan="2">Alumno</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">Por vencer</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">30 días</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">60 días</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">90 días</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">120 días</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;">> 120 días</td>';
							$html .='<td align="center" valign="center" style="font-size:x-small;"><b>Total</b></td>';
							$html .='</tr>';
							$html .="<tr>";
							$cursoactual=$valor;
						}
					}
					$maxcol = $col2;
				}
				$html .= "</tr>";
			}
			//Total último mes
			$html .='<tr><td></td><td colspan="2" align="center"><b><small>TOTAL PENSIONES '.$cursoactual.'</small></b></td>';
			for($aux=4;$aux<($maxcol+1);$aux++)
			{	if ($total_mensual_aux[$aux] != 0 )
					$html .= "<td align=\"right\"><font size=\"8\"><b>$".number_format($total_mensual_aux[$aux],2,'.',',')."</b></font></td>";
				else
					$html .= "<td align=\"right\"><font size=\"8\">$0</font></td>";
			}
			$html .='</tr>';
			//Total por mes
			$html .='<tr><td></td><td colspan="2"></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
			$html .='<tr><td></td><td colspan="2" align="center"><b><small>TOTAL DEUDAS</small></b></td>';
			for($aux=4;$aux<($col2+1);$aux++)
			{	if ($total_mensual[$aux] != 0 )
					$html .= "<td align=\"right\"><font size=\"8\"><b>$".number_format($total_mensual[$aux],2,'.',',')."</b></font></td>";
				else
					$html .= "<td align=\"right\"><font size=\"8\"></font></td>";
			}
			
			$html .="</tr>";
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_antiguedad.pdf', 'I');
			break;
		case PRINTREP_DEUDORES_XLS: //IMPRIME EL REPORTE EN XLS
			$hoy = getdate();
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator('Redlinks')
			->setLastModifiedBy('Redlinks')
			->setTitle("Reporte de antigüedad de saldos")
			->setSubject("Reporte de antigüedad de saldos")
			->setDescription("Reporte de antigüedad de saldos");
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
			
			if ( $user_data['peri_codi'] == "" )
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			
			if(!isset($user_data['productos']))
				$prod_codigo = '';
			else
			{   $xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				$productos = explode(',', $user_data['productos'] );
				foreach ( $productos as $producto )
				{
					$xml_productos.='<producto id="'.$producto.'" />';
				}
				$xml_productos.="</productos>";
			}
			
			$reportes->get_all_deudores($user_data['curs_codi'],	$user_data['nivelEcon_codi'],	$user_data['peri_codi'],
										$user_data['fechavenc_fin'] );
			
			$tranx = $reportes->rows;
			
			if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, 'Reporte de antigüedad de saldos' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, 'Fecha de corte: '.$ffin.'.' );
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
			
			$column = 'A';
			$maxcolumn = '';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			$col=0;
			$maxcol = 0;
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			for($i=0;$i<count($tranx)-1;$i++)
			{	$col2=0;
				
				$i_cabe = 0;//Contador X
				$column = 'A';
					
				foreach ($tranx[$i] as $valor)
				{	$col2=$col2+1;
					if ($col2==3)
					{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $valor );
						$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
						$i_cabe=$i_cabe+1;
						$column++;
					}
					elseif($col2==2)
					{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $valor );
						$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
						$i_cabe=$i_cabe+1;
						$column++;
					}
					elseif($col2>3)
					{	if( is_numeric( $valor ) )
						{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "$".number_format($valor,2,'.',',') );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$total_mensual[$col2] = $total_mensual[$col2] + $valor;
							$total_mensual_aux[$col2] = $total_mensual_aux[$col2] + $valor;
						}
						else
						{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $valor );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$total_mensual[$col2] = 0 ;
							$total_mensual_aux[$col2] = 0;
						}
					}
					else
					{	if($cursoactual!=$valor)
						{	if ( $i!=0 )
							{   $i_cabe = 0;//Contador X
								$column = 'A';
								$column++;
								$i_cabe=$i_cabe+1;
								
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "TOTAL PENSIONES " . $cursoactual );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$objPHPExcel->getActiveSheet()->getStyle('A'.$i_deta_fila.':I'.$i_deta_fila)->getFont()->setBold( true );
								$i_cabe=$i_cabe+1;
								$column++;
								
								for($aux=4;$aux<($maxcol+1);$aux++)
								{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "$".$total_mensual_aux[$aux] );
									$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
									$total_mensual_aux[$aux] = 0;
									$i_cabe=$i_cabe+1;
									$column++;
								}
								$i_deta_fila = $i_deta_fila + 2;
							}
							$maxcolumn = $column++;
							$i_cabe = 0;//Contador X
							$column = 'A';
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $valor );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i_deta_fila.':I'.$i_deta_fila)->getFont()->setBold( true );
							$i_deta_fila=$i_deta_fila+1;
							
							$col = 0;
							$i_cabe = 0;//Contador X
							$column = 'A';
							
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "Código" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "Alumno" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "Por vencer" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "30 días" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "60 días" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "90 días" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "120 días" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "> 120 días" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$column++;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "Total" );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe=$i_cabe+1;
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i_deta_fila.':I'.$i_deta_fila)->getFont()->setBold( true );
							$i_deta_fila = $i_deta_fila + 1;
							$cursoactual=$valor;
							
							$i_cabe = 0;//Contador X
							$column = 'A';
						}
					}
					$maxcol = $col2;
				}
				$i_deta_fila = $i_deta_fila + 1;
			}
			///Total del último curso
			$i_cabe = 0;//Contador X
			$column = 'A';
			$column++;
			$i_cabe=$i_cabe+1;
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "TOTAL PENSIONES " . $cursoactual );
			$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
			$i_cabe=$i_cabe+1;
			$column++;
			
			for($aux=4;$aux<($col2+1);$aux++)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "$".number_format($total_mensual_aux[$aux],2,'.',',') );
				$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
				$i_cabe=$i_cabe+1;
				$column++;
			}
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i_deta_fila.':I'.$i_deta_fila)->getFont()->setBold( true );
			$i_deta_fila = $i_deta_fila + 2;
			
			//Total por mes
			
			$i_cabe = 0;//Contador X
			$column = 'A';
			$column++;
			$i_cabe=$i_cabe+1;
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "TOTAL DEUDA" );
			$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
			$i_cabe=$i_cabe+1;
			$column++;
			
			for($aux=4;$aux<($col2+1);$aux++)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, "$".number_format($total_mensual[$aux],2,'.',',') );
				$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
				$i_cabe=$i_cabe+1;
				$column++;
			}
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i_deta_fila.':I'.$i_deta_fila)->getFont()->setBold( true );
			$i_deta_fila = $i_deta_fila + 1;
			
			$objPHPExcel->getActiveSheet()->getStyle('C5:I'.$i_deta_fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$objPHPExcel->getActiveSheet()->getStyle('A5:A'.$i_deta_fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
			
			$objPHPExcel->getActiveSheet()->setTitle('Reporte de emisiones');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_antiguedad_saldos.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
    }
}

handler();
?>