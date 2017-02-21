<?php
	//Importando librerías necesarias
	require_once ('funciones.php');
	require_once ('../../framework/dbconf.php');	
	require_once ('../../framework/funciones.php');
	require_once ('../../framework/lenguaje.php');
	require_once ('../../framework/PHPExcel/Classes/PHPExcel.php');
	
	//Iniciando sesión
	session_start();
	$current_language=current_language();
	
	//Obteniendo parámetros
	if(isset($_GET['curs_para_codi']))
		$curs_para_codi=test_input($_GET['curs_para_codi']);
	if(isset($_GET['curs_para_mate_codi']))
		$curs_para_mate_codi=test_input($_GET['curs_para_mate_codi']);
	if(isset($_GET['peri_dist_codi']))
		$peri_dist_codi=test_input($_GET['peri_dist_codi']);
	if(isset($_GET['report_logo']))
		$report_logo=test_input($_GET['report_logo']);
	if(isset($_GET['font_size']))
		$font_size=test_input($_GET['font_size']);
	if(isset($_GET['font_type']))
		$font_type=test_input($_GET['font_type']);
	if(isset($_GET['report_logo_minis']))
		$report_logo_minis=test_input($_GET['report_logo_minis']);
	if(isset($_GET['pu']))
		$print_user=test_input($_GET['pu']);
	if(isset($_GET['pfd']))
		$print_full_date=test_input($_GET['pfd']);
	//Variables globales
	$curso_descr = $periodo_descrp = "";
	$largo_head=0;
	$cont_retirados=0;
	$count_estudiantes_global=0;
	//Estilo para los bordes de cada celda y las letras
	$styleArray = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            )
	);
	$styleArrayTableHead = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FDE9D9')
            )
	);
	$styleArrayRojo = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'FF0000'),
                'size' => $font_size,
				'bold' => true,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '01FFFF')
            )
	);
    $styleArraySinNota = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF80')
            )
	);
	$styleArrayFont = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            )
	);
	$styleArrayFontEncabezado = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size+4,
                'bold' => true,
		'name' => $font_type
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
        //Si se le envia -1 en el codigo de la materia, imprime todas las materias.
        //Eso seria util para los reportes de sabanas de cursos que piden a posterioridad.
        //por ahora, el desarrollo de esta pagina esta enfocado en la impresion de una sola materia.
	if ($curs_para_mate_codi==-1)
	{   $una=false;
            $curs_para_codi_aux=$curs_para_codi;
	}
	else
	{   $curs_para_codi_aux=-1;
	}
	
	//Consulta de calificaciones
	$sql="{call acta_nota_curs (?,?)}";
	$params = array($curs_para_codi, $peri_dist_codi);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{   echo "Error in executing statement .\n";
		exit ();
	}
	
	if (sqlsrv_has_rows($stmt))
	{   //Columnas y filas
		$row=array();
		$i=0;
		while ($row = sqlsrv_fetch_array($stmt))
		{
			$aux_col[$i][0] = $row['curs_para_mate_codi'];
			$aux_col[$i][1] = $row['mate_deta'];//Encabezado
			$aux_col[$i][2] = $row['mate_tipo'];
			$aux_col[$i][3] = $row['mate_padr'];
			$aux_col[$i][4] = $row['mate_orde'];
			$aux_fil[$i][0] = $row['alum_codi'];
			$aux_fil[$i][1] = $row['alum_apel'];
			$aux_fil[$i][2] = $row['alum_nomb'];
			$aux_fil[$i][3] = $row['alum_est_det'];
			$datos[]=$row;
			$i++;
		}
		
		//Columnas finales
		$columnas = arrayUnique ($aux_col);
		
		foreach ($columnas as $key => $row) 
		{
			$aux[$key] = $row[4];//se guarda en el arreglo auxiliar sólo la columna por la que quieres ordenar.
		}
		array_multisort($aux, SORT_ASC, $columnas);
		
		//Filas finales
		$filas = arrayUnique ($aux_fil);
		
		//Quimestre y Parcial
		$params = array($peri_dist_codi);
		$sql="{call peri_dist_peri_codi (?)}";
		$cab_view = sqlsrv_query($conn, $sql, $params);  
		$cab_row=sqlsrv_fetch_array($cab_view);
		
		//Datos del curso
		$params = array($curs_para_codi);
		$sql="{call curs_para_info(?)}";
		$curs_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_info = sqlsrv_fetch_array($curs_info);
		
		//Tipos de falta
		$params=array();
		$sql="{call falt_tipo_view()}";
		$falt_view = sqlsrv_query($conn, $sql, $params);
		
		//Creando archivo de Excel
		//Nombre de la Institución
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, pasarMayusculas(show_this_phrase(20000006)) . ' '.para_sist(3));
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($styleArrayFontEncabezado);
		//Periodo distribución
		$periodo_descrp=$cab_row['nivel_1'].', '.$cab_row['nivel_2'];
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$objPHPExcel->getActiveSheet()->mergeCells('A2:S2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 2, pasarMayusculas(show_this_phrase(20000002)) . '. '.$periodo_descrp);
		$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArrayFontEncabezado);
		//Año lectivo
		$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$objPHPExcel->getActiveSheet()->mergeCells('A3:S3');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 3, pasarMayusculas(show_this_phrase(20000005)) . ' '.$_SESSION['peri_deta']);
		$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($styleArrayFontEncabezado);
					
		// Setea altura de fila 1,2,3, es decir, del encabezado.
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
					
		$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
					
		//Datos del curso
		$curso_descr=$row_curs_info['nive_deta'].'. '.$row_curs_info['curs_deta'].', '. pasarMayusculas(show_this(10000014)) .': '.$row_curs_info['para_deta'];
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 5, pasarMayusculas($curso_descr));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->applyFromArray($styleArrayFont);

		//Tutor
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 6, 'Tutor: '.pasarMayusculas($row_curs_info['tutor']));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'6')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'6')->applyFromArray($styleArrayFont);
		//////////////////////////////////////////////
		//Matriz de calificaciones
		//////////////////////////////////////////////
		//Número
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 7,'No.');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(5);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getFont($w)->setBold(true);
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->applyFromArray($styleArrayTableHead);
		
		//Nombre
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 7,pasarMayusculas(show_this(10000015)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(58.85);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getFont(1)->setBold(true);
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->applyFromArray($styleArrayTableHead);

		//Rubros
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(120);
		
		$w=1;
		///////////////////////////////////////////////////////////
		//MATRIZ
		//Pone en primer lugar COMPORTAMIENTO...
		///////////////////////////////////////////////////////////
		for ($i=0;$i<count($columnas);$i++)
		{
			if ($columnas[$i][1]=='COMPORTAMIENTO')
			{
				$w++;
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, $columnas[$i][1]);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(5);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
				//Bordes
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->applyFromArray($styleArrayTableHead);
			}
		}
		//...Luego, las otras materias del quimestre.
		for ($i=0;$i<count($columnas);$i++)
		{
			if ($columnas[$i][1]!='COMPORTAMIENTO')
			{
				$w++;
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, $columnas[$i][1]);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(5);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
				//Bordes
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->applyFromArray($styleArrayTableHead);
			}
			
		}
		//PROMEDIO
		$w++;
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, pasarMayusculas(show_this(10000012)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(5);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->applyFromArray($styleArrayTableHead);

		//Tipos de faltas
		while ($falt_view_row=sqlsrv_fetch_array($falt_view))
		{
			$w++;
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, $falt_view_row['falt_tipo_deta']);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(9);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->applyFromArray($styleArrayTableHead);
		}
		$largo_head=$w;
		//Acumulador para el promedio de rendimiento
        $acum_rendimiento=0;
        //Recorre cada estudiante
		for ($i=0;$i<count($filas);$i++) 
		{
			$asterisco="";
			$retirado_switch=false;
			if ($filas[$i][3]=='RETIRADO') 
			{	$cont_retirados++;
				$asterisco = "*";
				$retirado_switch = true;
			}
			//Numero y Nombre de estudiante
			$cont_materias=0;
			$acum_materias=0;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i+8, $i+1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $i+8, $asterisco . rtrim($filas[$i][1]).' '.rtrim($filas[$i][2]));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+8))->applyFromArray($styleArray);
			//Bordes
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->applyFromArray($styleArrayFont);
			
			//Primero, notas de comportamiento
			$w=1;
			for ($j=0;$j<count($columnas);$j++) 
            {	//Datos de la materia
				$params = array($columnas[$j][0]);
				$sql="{call curs_para_mate_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
			
				if ($columnas[$j][1]=='COMPORTAMIENTO')
                {	$w++;
                    $nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
                }
            }
			//Luego, Las siguientes materias.
			for ($j=0;$j<count($columnas);$j++) 
            {	//Datos de la materia
				$params = array($columnas[$j][0]);
				$sql="{call curs_para_mate_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
				if ($columnas[$j][1]!='COMPORTAMIENTO')
                {	$w++;
                    $nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
					//Si la calificación es numérica
                    if ($columnas[$j][2]=='C')
                    {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, number_format($nota,2,'.',','));
						//Pinta la celda si es una nota menor a siete.
						if ($nota < 7)
						{
							$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArrayRojo);
						}else
						{
							$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
						}
						//Para sacar el promedio de las materias principales
						if ($columnas[$j][3]==-1)
						{
							$cont_materias++;
							$acum_materias=$acum_materias+$nota;
						}
                    }
					//Si la calificación es cualitativa
                    else
                    {
                        if ($nota==0)
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '--');
							$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArraySinNota);
							//nota amarilla
                        }
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota));
							$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
                        }
						
					}
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
            }
			//NOTAS DE PROMEDIO
			$w++;
			$nota_rendimiento=$acum_materias/$cont_materias;
			if($retirado_switch==false)
			{	$count_estudiantes_global++;
				$acum_rendimiento=$acum_rendimiento+$nota_rendimiento;
			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, number_format($nota_rendimiento,2,'.',','));
			//Pinta la celda si es una nota menor a siete.
			if ($nota_rendimiento < 7)
			{
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArrayRojo);
			}else
			{
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
			}
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			//FALTAS
			$params=array();
			$sql="{call falt_tipo_view()}";
			$falt_view = sqlsrv_query($conn, $sql, $params);
			while ($falt_view_row=sqlsrv_fetch_array($falt_view))
			{
				$w++;
				//Consulta las faltas
				$params=array($_SESSION['peri_codi'], $peri_dist_codi, $curs_para_codi,$filas[$i][0],$falt_view_row['falt_tipo_codi']);
				$sql="{call falt_tipo_alum_view(?,?,?,?,?)}";
				$falt_alum_view = sqlsrv_query($conn, $sql, $params);
				$falt_alum_view_row=sqlsrv_fetch_array($falt_alum_view);
				//Imprime las faltas
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, $falt_alum_view_row['num_faltas']);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
		}
		//NOTAS PROMEDIO GLOBAL
		$w=0;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, show_this_phrase(20000008));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
		
		for ($j=0;$j<count($columnas);$j++) 
		{
			//Datos de la materia
			$params = array($columnas[$j][0]);
			$sql="{call curs_para_mate_info(?)}";
			$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
			$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
			if ($columnas[$j][1]=='COMPORTAMIENTO')
			{	$w++;
				$acum_global=0;
				$prom_global=0;
				$cont_alumnos=0;
				for ($i=0;$i<count($filas);$i++)
				{	if($filas[$i][3]!='RETIRADO')
					{	$acum_global=$acum_global+buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
						$cont_alumnos++;
					}
				}
				$prom_global=$acum_global/$cont_alumnos;
				if ($columnas[$j][2]=='C')
				{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, number_format($prom_global,2,'.',','));
					//Pinta la celda si es una nota menor a siete.
					if ($prom_global < 7)
					{
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArrayRojo);
					}else
					{
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
					}
				}
				else
				{
					if ($prom_global==0)
					{
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '--');
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArraySinNota);
						//nota amarilla
					}
					else
					{
						//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$prom_global));
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '--');
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
					}
				}
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getFont($w)->setBold(true);
			}
		}
		for ($j=0;$j<count($columnas);$j++) 
		{
			//Datos de la materia
			$params = array($columnas[$j][0]);
			$sql="{call curs_para_mate_info(?)}";
			$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
			$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
			
			if ($columnas[$j][1]!='COMPORTAMIENTO')
			{	$w++;
				$acum_global=0;
				$prom_global=0;
				$cont_alumnos=0;
				for ($i=0;$i<count($filas);$i++)
				{	if($filas[$i][3]!='RETIRADO')
					{	$nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
						if ($nota!=0)
						{	$cont_alumnos++;
							$acum_global=$acum_global+$nota;
						}
					}
				}
				$prom_global=$acum_global/$cont_alumnos;
                if ($columnas[$j][2]=='C')
                {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, number_format($prom_global,2,'.',','));
					//Pinta la celda si es una nota menor a siete.
					if ($prom_global < 7)
					{
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArrayRojo);
					}else
					{
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
					}
				}
				else
				{
					if ($prom_global==0)
					{
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '--');
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArraySinNota);
						//nota amarilla
					}
					else
					{
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, '--');
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
					}
				}
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getFont($w)->setBold(true);
			}
		}
		//PROMEDIOS ACUMULADOS
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, number_format($acum_rendimiento/$count_estudiantes_global,2,'.',','));
		//Pinta la celda si es una nota menor a siete.
		if (($acum_rendimiento/$count_estudiantes_global) < 7)
		{
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArrayRojo);
		}else
		{
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
		}
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getFont($w)->setBold(true);
		
		//FALTAS
		$params=array();
		$sql="{call falt_tipo_view()}";
		$falt_view = sqlsrv_query($conn, $sql, $params);
		while ($falt_view_row=sqlsrv_fetch_array($falt_view))
		{	$w++;
			//Para sumar las faltas
			$acum_faltas=0;
			for ($i=0;$i<count($filas);$i++)
			{	if($filas[$i][3]!='RETIRADO')
				{	//Consulta las faltas sólo si no está retirado el estudiante.
					$params=array($_SESSION['peri_codi'], $peri_dist_codi, $curs_para_codi,$filas[$i][0],$falt_view_row['falt_tipo_codi']);
					$sql="{call falt_tipo_alum_view(?,?,?,?,?)}";
					$falt_alum_view = sqlsrv_query($conn, $sql, $params);
					$falt_alum_view_row=sqlsrv_fetch_array($falt_alum_view);
					$acum_faltas=$acum_faltas+$falt_alum_view_row['num_faltas'];
				}
			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+8, $acum_faltas);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+8))->getFont($w)->setBold(true);
		}
		$i+=2;
		//SEÑAL DE RETIRADO
		if($cont_retirados>0)
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, ($i+8), "* ". show_this_phrase(20000007));
			$i++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, ($i+8), "* " . show_this_phrase(20000003));
			$i+=2;
		}
		///////////////////////////////
		//FECHA Y USUARIO QUE GENERA EL REPORTE AL FINAL DEL DOCUMENTO
		///////////////////////////////
		if($print_full_date=='true')
		{	//Fecha
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, ($i+8), PrimeraMayuscula(show_this(10000003)) . ': ' . get_fecha_ciudad($current_language,'true','true'));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->applyFromArray($styleArrayFont);
		}
		else
		{	//Fecha
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, ($i+8), PrimeraMayuscula(show_this(10000003)) . ': ' . get_fecha_ciudad($current_language));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->applyFromArray($styleArrayFont);
		}
		$i++;
		
		if(!isset($_SESSION['usua_codi']))
		{	$usuario=$_SESSION['prof_usua'];
		}else
		{	$usuario=$_SESSION['usua_codi'];
		}
		
		if($print_user=='true')
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, ($i+8), PrimeraMayuscula(show_this(10000001)) . ': ' . $usuario);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+8))->applyFromArray($styleArrayFont);
		}
		//Logotipo del instituto
		if($report_logo=='true')
		{	$maxWidth = 150;
			$maxHeight = 75;
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
			$objDrawing->setName("Logo Ministerio");
			$objDrawing->setDescription("Logo Ministerio");
			$objDrawing->setPath('../'.$_SESSION['ruta_foto_logo_web']);
			$objDrawing->setCoordinates('A1');
			$objDrawing->setHeight($maxHeight);
			$offsetX =$maxWidth - $objDrawing->getWidth();
			$objDrawing->setOffsetX($offsetX);
		}
		if($report_logo_minis=='true')
		{
			$maxWidth = 100;
			$maxHeight = 75;
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
			$objDrawing->setName("Logo Ministerio");
			$objDrawing->setDescription("Logo Ministerio");
			$objDrawing->setPath('../'.$_SESSION['ruta_foto_logo_minis_long']);
			$objDrawing->setCoordinates('B1');
			$objDrawing->setHeight($maxHeight);
			//$objDrawing->setWidth($maxWidth);
			$offsetX = $first_logo_w;
			$objDrawing->setOffsetX($offsetX);	
		}
	}
	else
	{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, show_this_phrase(20000004));
	}
	/*Fin*/
	//Largo del encabezado, se calculo sólo despues de saber el numero de columnas que conforman los rubros.
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'1:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'1');
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'2:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'2');
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'3:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'3');
	
	// Setea altura de fila 7.
	$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(180);
				
	// Renombrar Hoja
	$objPHPExcel->getActiveSheet()->setTitle('Cuadro quimestral');
	
	//Oculta lineas no sombreadas
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	
	// Establecer seguridad para que no se pueda manipular el excel.
	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setPassword('Educ@link5');
	
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.show_this_phrase(20000002).' '. $periodo_descrp. ' '.pasarMayusculas($curso_descr).'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;

	function cellsToMergeByColsRow($start = NULL, $end = NULL, $row = NULL)
	{   $merge = 'A1:A1';
            if($start>=0 && $end>=0 && $row>0)
            {
                $start = PHPExcel_Cell::stringFromColumnIndex($start);
                $end = PHPExcel_Cell::stringFromColumnIndex($end);
                $merge = "$start{$row}:$end{$row}";
            }
            return $merge;
	}
?>