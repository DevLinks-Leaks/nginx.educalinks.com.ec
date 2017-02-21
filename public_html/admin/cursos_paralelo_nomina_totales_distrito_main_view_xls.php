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
	->setCreator('hola')
	->setLastModifiedBy('hola')
	->setTitle("Nómina de estudiantes")
	->setSubject("Nómina de estudiantes")
	->setDescription("Nómina de estudiantes de todo el periodo ".$_SESSION['peri_deta']);
	
	$peri_codi=0;
	
	if(isset($_GET['peri_codi']))
	{
		 $peri_codi=$_GET['peri_codi'];
	}
	
	$params = array();
	$sql="{call nive_view()}";
	$nive_view = sqlsrv_query($conn, $sql, $params);
	
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
				
	//Fondo naranja
	$naranja = array(
				'fill'  => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color'  => array('rgb' => 'FFFF99'),
				));
				
	//Fondo celeste
	$celeste = array(
				'fill'  => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color'  => array('rgb' => '99CCFF'),
				));
				
	//Bordes
	$bordes = array(
	  'borders' => array(
		  'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
	  )
	);
	
	// Tamaño máximo del logotipo
	$maxWidth = 150;
	$maxHeight = 75;
	
	//Setear la fecha para idioma español
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	
	//Guardando la fecha de hoy
	$fecha_hoy=strftime("%d de %B de %Y");
		
	//Escala de impresión 75%
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(90);
	
	//Orientación de la hoja vertical
	$objPHPExcel->getActiveSheet()
				->getPageSetup()
				->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	
	$objPHPExcel->getActiveSheet()
				->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'1')
				->applyFromArray($centrar);
				
	$objPHPExcel->getActiveSheet()
				->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'2')
				->applyFromArray($centrar);
				
	$objPHPExcel->getActiveSheet()
				->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'3')
				->applyFromArray($centrar);
				
	$objPHPExcel->getActiveSheet()
				->getStyle(PHPExcel_Cell::stringFromColumnIndex(3))
				->applyFromArray($centrar);
				
	//Definiendo ancho de las columnas
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))
				->setWidth(45);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))
				->setWidth(20);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))
				->setWidth(20);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(3))
				->setWidth(15);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4))
				->setWidth(10);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(5))
				->setWidth(10);
				
	$objPHPExcel->getActiveSheet()
				->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(6))
				->setWidth(10);
	
	//Poniendo títulos del informe
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()
				->setCellValueByColumnAndRow(0, 1, para_sist(36).' '.para_sist(3));
	$objPHPExcel->getActiveSheet()
				->getStyle('A1')
				->applyFromArray($titulos);
	
	$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	$objPHPExcel->getActiveSheet()
				->setCellValueByColumnAndRow(0, 2, 'TOTAL DE ESTUDIANTES MATRICULADOS');
	$objPHPExcel->getActiveSheet()
				->getStyle('A2')
				->applyFromArray($titulos);
	
	$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
	$objPHPExcel->getActiveSheet()
				->setCellValueByColumnAndRow(0, 3, 'AÑO LECTIVO '.$_SESSION['peri_deta']);
	$objPHPExcel->getActiveSheet($sheet)
				->getStyle('A3')
				->applyFromArray($titulos);
				
	$objPHPExcel->getActiveSheet()
				->setCellValueByColumnAndRow(0, 5, 'Fecha: '.$fecha_hoy);
	$objPHPExcel->getActiveSheet($sheet)
				->getStyle('A5')
				->applyFromArray($negrita);
	
	//Añadiendo cabeceras del detalle
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, 'SECCIÓN');
	$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($centrar);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 7, 'ESPECIALIDAD');
	$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($centrar);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 7, 'CURSO');
	$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($centrar);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 7, 'PARALELO');
	$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($centrar);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 7, 'HOMBRES');
	$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($centrar);

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 7, 'MUJERES');
	$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($centrar);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 7, 'TOTAL');
	$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($negrita);
	$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($centrar);
	
	//Añadiendo título a cada hoja
	$objPHPExcel->getActiveSheet()->setTitle('Estudiantes Matriculados');
	
	$hombres=0;
	$mujeres=0;
	//Comienzo en 7, porque la cabecera me ocupa 6 filas
	$cc=7;
	while ($row_nive_view = sqlsrv_fetch_array($nive_view)) 
	{
		$flag=false;
		$params = array($row_nive_view['nive_codi'],$peri_codi);
		$sql="{call curs_para_nive_cons(?,?)}";
		$curs_para_nive_view = sqlsrv_query($conn, $sql, $params);
						
		$hombres_columna=0;
		$mujeres_columna=0;
		while ($row_curs_para_nive_view = sqlsrv_fetch_array($curs_para_nive_view)) 
		{ 
			$hombres_fila=0;
			$mujeres_fila=0;
			//Fila
			$cc++;
			if ($flag==false)
			{
				$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0, $cc, $row_nive_view['nive_deta']);
				$flag=true;
			}
			
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(2, $cc, $row_curs_para_nive_view['curs_deta']);
						
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3, $cc, $row_curs_para_nive_view['para_deta']);						
			
			//Consulto el total de hombres
			$params = array($row_curs_para_nive_view['curs_para_codi'],'H');
			$sql="{call alum_curs_para_count(?,?)}";
			$alum_curs_para_count_view = sqlsrv_query($conn, $sql, $params);
			$row_alum_curs_para_count_view = sqlsrv_fetch_array($alum_curs_para_count_view);
			$hombres_fila=$row_alum_curs_para_count_view['total'];
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(4, $cc, $hombres_fila);	
						
			//Consulto el total de mujeres
			$params = array($row_curs_para_nive_view['curs_para_codi'],'M');
			$sql="{call alum_curs_para_count(?,?)}";
			$alum_curs_para_count_view = sqlsrv_query($conn, $sql, $params);
			$row_alum_curs_para_count_view = sqlsrv_fetch_array($alum_curs_para_count_view);
			$mujeres_fila=$row_alum_curs_para_count_view['total'];
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(5, $cc, $mujeres_fila);
						
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(6, $cc, ($mujeres_fila+$hombres_fila));
						
			$hombres_columna+=$hombres_fila;
			$mujeres_columna+=$mujeres_fila;
		}
		
		if ($flag==true)
		{
			$cc++;
			$hombres+=$hombres_columna;
			$mujeres+=$mujeres_columna;
			
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3, $cc, 'Suman');
							
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(4, $cc, $hombres_columna);
							
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(5, $cc, $mujeres_columna);
					
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(6, $cc, ($mujeres_columna+$hombres_columna));
			
			$objPHPExcel->getActiveSheet($sheet)
						->getStyle('D'.$cc.':G'.$cc)
						->applyFromArray($naranja);
						
			$cc++;
		}
	}
		
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$cc.':C'.$cc);	
	$objPHPExcel->getActiveSheet()
					->setCellValueByColumnAndRow(0, $cc, 'TOTAL MATRICULADOS');
					
	$objPHPExcel->getActiveSheet()
					->setCellValueByColumnAndRow(4, $cc, $hombres);
					
	$objPHPExcel->getActiveSheet()
			->setCellValueByColumnAndRow(5, $cc, $mujeres);
			
	$objPHPExcel->getActiveSheet()
					->setCellValueByColumnAndRow(6, $cc, ($hombres+$mujeres));
					
	$objPHPExcel->getActiveSheet()
				->getStyle('A'.$cc.':G'.$cc)
				->applyFromArray($celeste);
				
	$objPHPExcel->getActiveSheet()
				->getStyle('A7'.':G'.$cc)
				->applyFromArray($bordes);
	
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