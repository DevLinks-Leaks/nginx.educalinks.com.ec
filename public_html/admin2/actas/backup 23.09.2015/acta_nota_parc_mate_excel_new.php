<?
	//Importando librerías necesarias
	require_once ('funciones.php');
	require_once ('../../framework/dbconf.php');	
	require_once ('../../framework/funciones.php');	
	require_once ('../../framework/PHPExcel/Classes/PHPExcel.php');	
	
	//Iniciando sesión
	session_start();
	
	//Obteniendo parámetros
	$curs_para_codi=$_GET['curs_para_codi'];
	$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
	//Estilo para los bordes de cada celda
	$styleArray = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  )
	);
	
	//Archivo de Excel
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
	->setCreator(para_sist(2))
	->setLastModifiedBy(para_sist(2))
	->setTitle("Acta de calificaciones")
	->setSubject("Acta de calificaciones")
	->setDescription("Acta de calificaciones por parcial y materia.");
	
	//Escala de impresión
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(58);
	
	//Horizontal
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	
	//Márgenes
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
	
	$una=true;
	if ($curs_para_mate_codi==-1)
	{
		$una=false;
		$curs_para_codi_aux=$curs_para_codi;
	}
	else
	{
		$curs_para_codi_aux=-1;
	}
		
	//Consulta de calificaciones
	$sql="{call curs_peri_mate_view (?)}";
	$params = array($curs_para_codi_aux);
	$stmt_all = sqlsrv_query($conn, $sql, $params);
	
	while (($row_all=sqlsrv_fetch_array($stmt_all)) or ($una))
	{
		if ($una)
			$una=false;
		else
			$curs_para_mate_codi=$row_all['curs_para_mate_codi'];
	
	
		//Consulta de calificaciones
		$sql="{call acta_nota_parc_mate (?,?)}";
		$params = array($curs_para_mate_codi, $peri_dist_codi);
		$stmt = sqlsrv_query($conn, $sql, $params);
	
		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			exit ();
		}
		
		if (sqlsrv_has_rows($stmt))
		{
	
		
		//Columnas y filas
		$row=array();
		unset($datos);
		unset($aux_col);
		unset($aux_fil);
		$i=0;
		while ($row = sqlsrv_fetch_array($stmt))
		{
			$aux_col[$i][0] = $row['peri_dist_codi'];
			//$aux_col[$i][1] = $row['peri_dist_deta'];
			$aux_col[$i][1] = $row['peri_dist_abre'];
			$aux_col[$i][2] = $row['nota_final'];
			$aux_fil[$i][0] = $row['alum_curs_para_mate_codi'];
			$aux_fil[$i][1] = $row['alum_apel'];
			$aux_fil[$i][2] = $row['alum_nomb'];
			$datos[]=$row;
			$i++;
		}
		
		//Columnas finales
		$columnas = arrayUnique ($aux_col);
		
		//Filas finales
		$filas = arrayUnique ($aux_fil);
		
		//Quimestre y Parcial
		$params = array($peri_dist_codi);
		$sql="{call peri_dist_peri_codi (?)}";
		$cab_view = sqlsrv_query($conn, $sql, $params);  
		$cab_row=sqlsrv_fetch_array($cab_view);
		
		//Datos del profesor
		$params = array($curs_para_mate_codi);
		$sql="{call prof_curs_para_mate_cons (?)}";
		$dat_profesor = sqlsrv_query($conn, $sql, $params);  
		$prof_row=sqlsrv_fetch_array($dat_profesor);
		
		//Datos de la materia
		$params = array($curs_para_mate_codi);
		$sql="{call curs_para_mate_info(?)}";
		$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
		$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
		
		//Datos del curso
		$params = array($curs_para_codi);
		$sql="{call curs_para_info(?)}";
		$curs_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_info = sqlsrv_fetch_array($curs_info);
		
		//Tabla de notas cualitativas
		$params = array($row_curs_peri_info['nota_refe_cab_tipo'], $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
		//Creando archivo de Excel
		//Nombre de la Institución
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, 'UNIDAD EDUCATIVA '.para_sist(3));
		
		//Periodo distribución
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:Q2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 2, 'ACTA DE CALIFICACIONES DEL '.$cab_row['nivel_1'].' DEL '.$cab_row['nivel_2']);
		
		//Año lectivo
		$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A3:Q3');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 3, 'AÑO LECTIVO '.$_SESSION['peri_deta']);
		
		//Nivel
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 4, 'NIVEL: '.$row_curs_info['nive_deta']);
		
		//Curso
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 5, $row_curs_peri_info['curs_deta'].' '.$row_curs_peri_info['para_deta']);
		
		//Asignatura
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 6, 'ASIGNATURA: '.$row_curs_peri_info['mate_deta']);
		
		//Fecha
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, 4, 'Fecha: '.date("d/m/y"));
		
		//Profesor
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, 6, 'Profesor: '.$prof_row["prof_nomb"]." ".$prof_row["prof_apel"]);
		
		//Matriz de calificaciones
		//Número
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 7,'#');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(5);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8')->applyFromArray($styleArray);
		
		//Nombre
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 7,'Nombres');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(30);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8')->applyFromArray($styleArray);
		
		//Rubros
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(50);
		$w=0;
		for ($i=0;$i<count($columnas);$i++)
        {
			$w+=2;
			$objPHPExcel->getActiveSheet()->mergeCells(cellsToMergeByColsRow($w, $w+1, 7));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, $columnas[$i][1]);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(cellsToMergeByColsRow($w, $w+1, 7))->applyFromArray($styleArray);
        }
		
		//Nota del Parcial
		$w+=2;
		$objPHPExcel->getActiveSheet()->mergeCells(cellsToMergeByColsRow($w, $w+1, 7));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, 'NOTA DEL PARCIAL');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(cellsToMergeByColsRow($w, $w+1, 7))->applyFromArray($styleArray);
	
		//Faltas injustificadas
		$w+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, 'FALTAS INJUSTIFICADAS');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(25);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
		
		//Recomendaciones
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, 'RECOMENDACIONES');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(25);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
	
		//Plan de mejoramiento
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, 'PLAN DE MEJORAMIENTO');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(25);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
		
		//Cualitativa - Numérico
		$w=0;
		for ($i=0;$i<count($columnas);$i++)
		{
			$w+=2;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 8, 'C');
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, 8, 'N');
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->applyFromArray($styleArray);
		} 
		$w+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 8, 'C');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, 8, 'N');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->applyFromArray($styleArray);
    
	
		/*Inicio*/
		$sum_curso=0;
		$prom_curso=0;
		$cont_alumnos=0;
	 	unset($notas_prom);
         for ($i=0;$i<count($filas);$i++) 
         {
		 	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i+9, $i+1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $i+9, $filas[$i][1].' '.$filas[$i][2]);
            //Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+9))->applyFromArray($styleArray);

			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+9))->applyFromArray($styleArray);

            $acum_parcial=0;
            $cont_parcial=0;
			$w=0;
            for ($j=0;$j<count($columnas);$j++) 
            {
				$w+=2;
				$nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_curs_para_mate_codi', 'peri_dist_codi');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, $i+9, ($row_curs_peri_info['nota_refe_cab_tipo']=='C'?number_format($nota,2,'.',','):'-'));
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$cont_parcial++;
				$acum_parcial=$acum_parcial+$nota;

				//Bordes
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->applyFromArray($styleArray);

				//Bordes
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->applyFromArray($styleArray);
            }
			$nota_final=$acum_parcial/$cont_parcial;
			$w+=2;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, $i+9, ($row_curs_peri_info['nota_refe_cab_tipo']=='C'?number_format($nota_final,2,'.',','):'-'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota_final));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->applyFromArray($styleArray);

			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->applyFromArray($styleArray);
			
			//Faltas injustificadas
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+2).($i+9))->applyFromArray($styleArray);
			
			//Recomendaciones
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+3).($i+9))->applyFromArray($styleArray);
			
			//Plan mejoramiento
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+4).($i+9))->applyFromArray($styleArray);
			
			$cont_alumnos++;
			$sum_curso=$sum_curso+$nota_final;
			$notas_prom[]=$nota_final;
         }
         $prom_curso=$sum_curso/$cont_alumnos;
		 //El promedio del curso solo se presenta si es una materia cuantitativa
		 if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
		 {
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w-3, $i+9, 'PROMEDIO DEL CURSO:');
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, $i+9, number_format(round($prom_curso,2),2,'.',','));
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$prom_curso));
			 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		 }
		 
		 //Cuadro de resumen
		 $objPHPExcel->getActiveSheet()->mergeCells('A'.($i+11).':B'.($i+11));
		 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, ($i+11), 'CUALITATIVA');
		 //Bordes
		 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(1).($i+11))->applyFromArray($styleArray);
		 
		 $objPHPExcel->getActiveSheet()->mergeCells('C'.($i+11).':D'.($i+11));
		 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, ($i+11), 'CUANTITATIVA');
		  //Bordes
		 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(2).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(3).($i+11))->applyFromArray($styleArray);
		 
		 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, ($i+11), 'ABRE.');
		  //Bordes
		 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($i+11))->applyFromArray($styleArray);
		 
		 $objPHPExcel->getActiveSheet()->mergeCells('F'.($i+11).':G'.($i+11));
		 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, ($i+11), 'Nº ESTUDIANTES');
		 //Bordes
		 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(5).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(6).($i+11))->applyFromArray($styleArray);
		 
		 $objPHPExcel->getActiveSheet()->mergeCells('H'.($i+11).':I'.($i+11));
		 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, ($i+11), 'PORCENTAJE');
		 //BORDES
		 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(6).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(8).($i+11))->applyFromArray($styleArray);

		while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) 
		{ 
			$i++;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.($i+11).':B'.($i+11));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, ($i+11), $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']);
			//BORDES
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(1).($i+11))->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->mergeCells('C'.($i+11).':D'.($i+11));
			//El rango de calificación solo se muestra si la materia es cuantitativa
			if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, ($i+11), number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], 2, '.', '').' - '.(number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'], 2, '.', '')));
			//BORDES
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(2).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(3).($i+11))->applyFromArray($styleArray);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, ($i+11), $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']);
			//BORDES
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($i+11))->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->mergeCells('F'.($i+11).':G'.($i+11));
		 	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, ($i+11), contar_notas_num($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']));
			//BORDES
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(5).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(6).($i+11))->applyFromArray($styleArray);
			
			$objPHPExcel->getActiveSheet()->mergeCells('H'.($i+11).':I'.($i+11));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, ($i+11), number_format(contar_notas_porc($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']),2, '.', '').' %');
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(7).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(8).($i+11))->applyFromArray($styleArray);
			
      	}
		}
		else
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, 'No hay notas ingresadas para esta materia');
		}
		 
		/*Fin*/
		
		// Renombrar Hoja
		$objPHPExcel->getActiveSheet()->setTitle('Acta parcial');
	
		// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
		$objPHPExcel->setActiveSheetIndex(0);
	
		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="acta.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
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