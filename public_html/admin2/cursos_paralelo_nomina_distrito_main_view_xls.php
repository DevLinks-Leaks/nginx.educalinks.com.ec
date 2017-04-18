<?php
	session_start();
	require_once ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
	require_once ('../framework/PHPExcel/Classes/PHPExcel.php');
	require_once ('script_cursos.php'); 
	require_once ('actas/funciones.php');
	
	//Creando documento de excel
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
	//->setCreator(para_sist(2))
	//->setLastModifiedBy(para_sist(2))
	->setTitle("Nómina de estudiantes")
	->setSubject("Nómina de estudiantes")
	->setDescription("Nómina de estudiantes de todo el periodo ".$_SESSION['peri_deta']);
	
	$all='UNA';$peri_codi=0;
	
	if(isset($_GET['peri_codi'])){
		 $peri_codi=$_GET['peri_codi'];
		 $all='YES';
	}
	
	
	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
  	$sheet=0;
	$orden=0;
	
	//Estilo para centrar texto en excel
	$centrar = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
	
	//Estilo para alinear a la izquierda en excel
	$izquierda = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        )
    );
	
	//Estilo para configurar como títulos en excel
	$titulos = array(
				'font'  => array(
					'bold'  => true,
					'size'  => 15,
				));

	//Estilo para poner negrita
	$negrita = array(
				'font'  => array(
					'bold'  => true,
				));
	
	// Tamaño máximo del logotipo
	$maxWidth = 150;
	$maxHeight = 75;
	
	//Setear la fecha para idioma español
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	
	//Guardando la fecha de hoy
	$fecha_hoy=strftime("%d de %B de %Y");
	
	while (($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) or  ($all=='UNA'))  
	{ 
		if ($all=='UNA')
		{ 
			$all='OFF';
			if(isset($_GET['curs_para_codi']))
			{
				$curs_para_codi=$_GET['curs_para_codi'];
			}
			if(isset($_POST['curs_para_codi']))
			{
				$curs_para_codi=$_POST['curs_para_codi'];
			}
			 
		}
		else 
		{
			$curs_para_codi=$row_curs_peri_view['curs_para_codi'];
		}
		
		$activar_retirados = para_sist(301);

		if($activar_retirados=='1'){
			$params = array($curs_para_codi);
			$sql="{call alum_curs_para_view_ret(?)}";
			$alum_curs_para_view = sqlsrv_query($conn, $sql, $params); 
		}else{
			$params = array($curs_para_codi);
			$sql="{call alum_curs_para_view(?)}";
			$alum_curs_para_view = sqlsrv_query($conn, $sql, $params); 
		}
		 
		
		$params = array($curs_para_codi);
		$sql="{call curs_peri_info(?)}";
		$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
		$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
		
		//Para no añadir la primera hoja, ya que viene por defecto. Sino siempre
		//va a haber una hoja que sobre
		if ($sheet>0)
			$objPHPExcel->createSheet($sheet);
		
		//Escala de impresión 75%
		$objPHPExcel->setActiveSheetIndex($sheet)->getPageSetup()->setScale(75);
		
		//Orientación de la hoja vertical
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getPageSetup()
					->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		
		//Alineando el texto por columnas y por celdas
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(0))
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'4')
					->applyFromArray($izquierda);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')
					->applyFromArray($izquierda);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).'4')
					->applyFromArray($izquierda);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'1')
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'2')
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'3')
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(2))
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(3))
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(4))
					->applyFromArray($centrar);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(5))
					->applyFromArray($centrar);
		
		//Definiendo ancho de las columnas
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))
					->setWidth(15);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))
					->setWidth(45);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))
					->setWidth(5);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(3))
					->setWidth(15);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4))
					->setWidth(15);
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(5))
					->setWidth(20);
		
		//Poniendo títulos del informe
		$objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(1, 1, para_sist(36).' '.para_sist(3));
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle('B1')
					->applyFromArray($titulos);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(1, 2, 'NÓMINA DE ESTUDIANTES MATRICULADOS');
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle('B2')
					->applyFromArray($titulos);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(1, 3, 'AÑO LECTIVO '.$_SESSION['peri_deta']);
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle('B3')
					->applyFromArray($titulos);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(0, 4, 'SECCIÓN: ');
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(1, 4, $row_curs_peri_info['nive_deta']);
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A4')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(4, 4, 'FECHA: ');
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(5, 4, $fecha_hoy);
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('E4')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(0, 5, $row_curs_peri_info['curs_deta'].' '
												.$row_curs_peri_info['nive_deta'].' PARALELO: '
												.$row_curs_peri_info['para_deta']);
		
		//Añadiendo logotipo del Ministerio de Educación
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex($sheet));
		$objDrawing->setName("Logo Ministerio");
		$objDrawing->setDescription("Logo Ministerio");
		$objDrawing->setPath($_SESSION['ruta_foto_logo_minis']);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setHeight($maxHeight);
		// This is the "magic" formula
		$offsetX =$maxWidth - $objDrawing->getWidth();
		$objDrawing->setOffsetX($offsetX);
		
		//Añadiendo cabeceras del detalle
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(0, 7, 'Nº');
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A7')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(1, 7, 'NOMBRE');
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('B7')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(3, 7, 'Nº MATRÍCULA');
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('D7')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(4, 7, 'Nº FOLIO');
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('E7')->applyFromArray($negrita);
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValueByColumnAndRow(5, 7, 'FECHA MATRÍCULA');
		$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('F7')->applyFromArray($negrita);
		
		//Añadiendo título a cada hoja
		$objPHPExcel->setActiveSheetIndex($sheet)->setTitle(substr($row_curs_peri_info['curs_deta'],0,15).' '.substr($row_curs_peri_info['para_deta'],0,5));
		
		//Comienzo en 6, porque la cabecera me ocupa 6 filas
		$cc = 6; 
		while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) 
		{ 
			$cc +=1;
			//Contador para el folio del estudiante
			$orden++;
			if($activar_retirados=='1'){
				if($row_alum_curs_para_view["estado_alumno"]=='R'){
					$styleArray = array(
					    'font'  => array(
					        'color' => array('rgb' => 'FF0000'),
					    ));

					$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow(0, $cc+1, $orden);
					
					//Formato de 4 dígitos
					$objPHPExcel->setActiveSheetIndex($sheet)
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($cc+1))
								->getNumberFormat()
								->setFormatCode('0000');


					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(1, $cc+1, utf8_decode(utf8_encode(rtrim($row_alum_curs_para_view["alum_apel"])
								.' '.rtrim($row_alum_curs_para_view["alum_nomb"]))));
								
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(3, $cc+1, $row_alum_curs_para_view["folio"]);

					//Formato de 4 dígitos
					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(3).($cc+1))
								->getNumberFormat()->setFormatCode('0000');

					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow(4, $cc+1, $row_alum_curs_para_view["folio"]);
					
					//Formato de 4 dígitos
					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($cc+1))
								->getNumberFormat()->setFormatCode('0000');
							
					/*$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(5, $cc+1, strftime("%d de %B de %Y", 
								strtotime($row_alum_curs_para_view["alum_curs_para_fech"])));*/
								
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(5, $cc+1, $row_alum_curs_para_view["alum_curs_para_fech"]);

					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($cc+1).':'.PHPExcel_Cell::stringFromColumnIndex(5).($cc+1))
								->applyFromArray($styleArray);
				}else{
					$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow(0, $cc+1, $orden);
				
					//Formato de 4 dígitos
					$objPHPExcel->setActiveSheetIndex($sheet)
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($cc+1))
								->getNumberFormat()
								->setFormatCode('0000');
					
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(1, $cc+1, utf8_decode(utf8_encode(rtrim($row_alum_curs_para_view["alum_apel"])
								.' '.rtrim($row_alum_curs_para_view["alum_nomb"]))));
								
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(3, $cc+1, $row_alum_curs_para_view["folio"]);

					//Formato de 4 dígitos
					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(3).($cc+1))
								->getNumberFormat()->setFormatCode('0000');
								
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow(4, $cc+1, $row_alum_curs_para_view["folio"]);
					
					//Formato de 4 dígitos
					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($cc+1))
								->getNumberFormat()->setFormatCode('0000');
							
					/*$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(5, $cc+1, strftime("%d de %B de %Y", 
								strtotime($row_alum_curs_para_view["alum_curs_para_fech"])));*/
								
					$objPHPExcel->setActiveSheetIndex($sheet)
								->setCellValueByColumnAndRow
								(5, $cc+1, $row_alum_curs_para_view["alum_curs_para_fech"]);
				}
			}else{
				$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow(0, $cc+1, $orden);
				
				//Formato de 4 dígitos
				$objPHPExcel->setActiveSheetIndex($sheet)
							->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($cc+1))
							->getNumberFormat()
							->setFormatCode('0000');
				
				$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow
							(1, $cc+1, utf8_decode(utf8_encode(rtrim($row_alum_curs_para_view["alum_apel"])
							.' '.rtrim($row_alum_curs_para_view["alum_nomb"]))));
							
				$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow
							(3, $cc+1, $row_alum_curs_para_view["folio"]);

				//Formato de 4 dígitos
					$objPHPExcel->getActiveSheet()
								->getStyle(PHPExcel_Cell::stringFromColumnIndex(3).($cc+1))
								->getNumberFormat()->setFormatCode('0000');
							
				$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow(4, $cc+1, $row_alum_curs_para_view["folio"]);
				
				//Formato de 4 dígitos
				$objPHPExcel->getActiveSheet()
							->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($cc+1))
							->getNumberFormat()->setFormatCode('0000');
						
				/*$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow
							(5, $cc+1, strftime("%d de %B de %Y", 
							strtotime($row_alum_curs_para_view["alum_curs_para_fech"])));*/
							
				$objPHPExcel->setActiveSheetIndex($sheet)
							->setCellValueByColumnAndRow
							(5, $cc+1, $row_alum_curs_para_view["alum_curs_para_fech"]);
			}
					
		}
		
		//Espacio para firma del rector/a
		
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(1, $cc+7, para_sist(5));
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(1, $cc+8,  para_sist(33));
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($cc+7))
					->applyFromArray($centrar);
		
		$objPHPExcel->setActiveSheetIndex($sheet)
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($cc+8))
					->applyFromArray($centrar);
		
		//Línea para firmar		
		$objPHPExcel->getActiveSheet()
					->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($cc+7))
					->getBorders()
					->getTop()
					->applyFromArray(
									 array(
										 'style' => PHPExcel_Style_Border::BORDER_THIN,
										 'color' => array(
											 'rgb' => '000000'
										 )
									 )
									);
		
		//Firma para el secretario/a
		$objPHPExcel->getActiveSheet()
					->mergeCells('D'.($cc+7).':F'.($cc+7));
					
		$objPHPExcel->getActiveSheet()
					->mergeCells('D'.($cc+8).':F'.($cc+8));
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(3, $cc+7, para_sist(6));
					
		$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValueByColumnAndRow(3, $cc+8,  para_sist(34));
				
		$objPHPExcel->getActiveSheet()
					->getStyle(cellsToMergeByColsRow(3, 5, $cc+7))
					->getBorders()
					->getTop()
					->applyFromArray(
									 array(
										 'style' => PHPExcel_Style_Border::BORDER_THIN,
										 'color' => array(
											 'rgb' => '000000'
										 )
									 )
									);
		
		$sheet++;
	}
	
	//Función para hacer combinación de celdas
	function cellsToMergeByColsRow($start = NULL, $end = NULL, $row = NULL)
	{
    	$merge = 'A1:A1';
		if($start>=0 && $end>=0 && $row>0)
		{
			$start = PHPExcel_Cell::stringFromColumnIndex($start);
			$end = PHPExcel_Cell::stringFromColumnIndex($end);
			$merge = "$start{$row}:$end{$row}";
	
		}
		return $merge;
	}
	
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Nomina_Distrito_General.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;