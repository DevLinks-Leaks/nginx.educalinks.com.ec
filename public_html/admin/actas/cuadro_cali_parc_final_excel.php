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
	
	//Variables globales
	$curso_descr = $periodo_descrp = "";
	$largo_head=0;
	$materias_cuantitativas_count=0;
	$ancho_para_firmas=47;//se dividirá por el numero de subcolumnas.
	$cont_retirados=0;
	
	//Estilo para los bordes de cada celda y las letras
	$styleArray = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => 10,
		'name' => 'Arial'
            )
	);
	$styleArrayFirmas = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => 10,
		'name' => 'Arial'
            )
	);
	$styleArrayPromedioRendimiento = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'FF0000'),
                'size' => 10,
		'name' => 'Arial'
            )
	);
	$styleArrayRojo = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'0000FF'),
                'size' => 10,
				'bold' => true,
		'name' => 'Arial'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFF')
            )
	);
	$styleArrayBuenaNota = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'0000FF'),
                'size' => 10,
				'bold' => true,
		'name' => 'Arial'
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
                'size' => 10,
		'name' => 'Arial'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF80')
            )
	);
	$styleArrayFont = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => 10,
		'name' => 'Arial'
            )
	);
	$styleArrayFontEncabezado = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => 10,
                'bold' => true,
		'name' => 'Arial'
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
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
	
	$objPHPExcel->getActiveSheet()->
		getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	//Horizontal
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	
	//Márgenes
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.35);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.35);
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
	$sql="{call acta_nota_curs_final (?,?)}";
	$params = array($curs_para_codi, $peri_dist_codi);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{   echo "Error in executing statement .\n";
		exit ();
	}
	
	if (sqlsrv_has_rows($stmt))
	{   
		//Columnas y filas
		$row=array();
		$i=0;
		while ($row = sqlsrv_fetch_array($stmt))
		{	//if($row['peri_dist_nota_tipo']!='EQ')
			//{	
				$aux_col[$i][0] = $row['curs_para_mate_codi'];
				$aux_col[$i][1] = $row['mate_deta'];
				$aux_col[$i][2] = $row['mate_tipo'];
				$aux_col[$i][3] = $row['mate_padr'];
				$aux_col[$i][4] = $row['mate_orde'];
				$aux_col[$i][5] = $row['nota_refe_cab_codi'];

				// $aux_sub_col[$i][0] = $row['peri_dist_codi'];
				// $aux_sub_col[$i][1] = $row['peri_dist_deta'];
				
				$aux_fil[$i][0] = $row['alum_codi'];
				$aux_fil[$i][1] = $row['alum_apel'];
				$aux_fil[$i][2] = $row['alum_nomb'];
				$aux_fil[$i][3] = $row['alum_est_det'];
				$aux_fil[$i][4] = $row['num_mate'];
				$aux_fil[$i][5] = $row['alum_apel'].' '.$row['alum_nomb'];

				$datos[]=$row;
				$i++;
			//}
		}
		
		//Columnas finales
		$columnas = arrayUnique ($aux_col);
		
		foreach ($columnas as $key => $row) 
		{	$aux[$key] = $row[4];//se guarda en el arreglo auxiliar sólo la columna por la que quieres ordenar.
		}
		$array_rend=array();
		//Consulta cabeceras
		$params = array($curs_para_codi,$peri_dist_codi);
		$sql="{call alum_nota_libreta_modelos(?,?)}";
		$alum_nota_libreta_modelos = sqlsrv_query($conn, $sql, $params);
		while($row_alum_nota_libreta_modelos= sqlsrv_fetch_array($alum_nota_libreta_modelos)){
			
			$array_temp=array();
			$array=array();

			$params = array($peri_dist_codi, $row_alum_nota_libreta_modelos['nota_refe_cab_cod']);
			$sql="{call alum_nota_libreta_cabecera(?,?)}";
			$alum_nota_libreta_cabecera = sqlsrv_query($conn, $sql, $params);
			$k=0;
			while($row_alum_nota_libreta_cabecera= sqlsrv_fetch_array($alum_nota_libreta_cabecera)){
				$array_temp[$k][0] = $row_alum_nota_libreta_cabecera['peri_dist_codi'];
				$array_temp[$k][1] = $row_alum_nota_libreta_cabecera['peri_dist_deta'];
				$array_temp[$k][2] = $row_alum_nota_libreta_cabecera['peri_dist_nota_tipo'];
				$k++;
				if($row_alum_nota_libreta_cabecera['peri_dist_nota_tipo']=='PM'){
					$array_rend[0][0] = $row_alum_nota_libreta_cabecera['peri_dist_codi'];
					$array_rend[0][1] = $row_alum_nota_libreta_cabecera['peri_dist_deta'];
					$array_rend[0][2] = $row_alum_nota_libreta_cabecera['peri_dist_nota_tipo'];
				}

			}
			$array = arrayUnique ($array_temp);
			$modelos[$row_alum_nota_libreta_modelos['nota_refe_cab_cod']]=$array;
				
		}
		
		//Consulta cabeceras
		$params = array($peri_dist_codi, 'C');
		$sql="{call peri_dist_padr_libr_view(?,?)}";
		$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params);
		$k=0;
		while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)){
			$aux_sub_col[$k][0] = $row_peri_dist_padr_view['peri_dist_codi'];
			$aux_sub_col[$k][1] = $row_peri_dist_padr_view['peri_dist_deta'];
			$aux_sub_col[$k][2] = $row_peri_dist_padr_view['peri_dist_nota_tipo'];
			$k++;
		}

		//Subcolumnas finales
		$subcolumnas =arrayUnique ($array_rend);
		
		//ancho de subcolumnas, en base al valor de la variable global.
		$ancho_para_rend=($ancho_para_firmas/count($subcolumnas));
		if ($ancho_para_rend < 2)
			$ancho_para_rend = 2;
		
		//Filas finales
		$filas = arrayUnique ($aux_fil);
		
		usort($filas, function($a, $b) {
		    return strcmp($a[5], $b[5]);
		});

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
		
		//Creando archivo de Excel
		///////////////////////////////////////////////////////////////////////////////////////
		//ENCABEZADO
		///////////////////////////////////////////////////////////////////////////////////////
		//Nombre de la Institución
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 2, mb_strtoupper(para_sist(36),'UTF-8') . ' '.pasarMayusculas(para_sist(3)));
		$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArrayFontEncabezado);
		//$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setIndent(1);
		//Periodo distribución
		$periodo_descrp=$cab_row['nivel_1'].', '.$cab_row['nivel_2'];
		//$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 3, 'CUADRO DE CALIFICACIONES FINALES ');
		$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($styleArrayFontEncabezado);
		//$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setIndent(1);
		//Año lectivo
		//$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 4, pasarMayusculas(show_this_phrase(20000005)) . ' '.$_SESSION['peri_deta']);
		$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->applyFromArray($styleArrayFontEncabezado);
		//$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setIndent(1);
					
		// Setea altura de fila 1,2,3, es decir, del encabezado.
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(15);
					
		$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(15);
					
		//Datos del curso
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'5:'.PHPExcel_Cell::stringFromColumnIndex(1).'5');
		$objPHPExcel->getActiveSheet()->getStyle("A5")->getAlignment()->setWrapText(true);
		$curso_descr=$row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' PARALELO: "'.$row_curs_info['para_deta'].'"';
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 5, pasarMayusculas($curso_descr));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->applyFromArray($styleArrayFont);

		//Datos del curso
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 6, 'Tutor: '.pasarMayusculas($row_curs_info['tutor']));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'6')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'6')->applyFromArray($styleArrayFont);
		
		///////////////////////////////////////////////////////////////////////////////////////
		//Matriz de calificaciones
		///////////////////////////////////////////////////////////////////////////////////////
		//Número
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 7,'No.');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(5);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8')->applyFromArray($styleArray);
		
		//Nombre
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 7,pasarMayusculas(show_this(10000015)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(58.85);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8')->applyFromArray($styleArray);

		//Rubros
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(40);
		///////////////////////////////////////////////////////////////////////////////////////
		//PRIMERO MATERIAS, tomando en cuenta un mergeCell de count($subcolumnas).
		///////////////////////////////////////////////////////////////////////////////////////
		$w=2;
		//...Luego, las otras materias del quimestre.
		for ($i=0;$i<count($columnas);$i++)
		{	if ($columnas[$i][1]!='COMPORTAMIENTO')
			{	//nota_refe_cab_codi $columnas[$i][5]
				$temp=$columnas[$i][5];
				$count=count($modelos[$temp]);
				$ancho_para_firmas_var=($ancho_para_firmas/$count);
				if ($ancho_para_firmas_var < 2)
					$ancho_para_firmas_var = 2;
				genera_detalle($objPHPExcel, $w, 7, $columnas[$i][1], $count,$styleArray);
				listado_rotar_texto_celda($objPHPExcel, $w, 7, 0);
				setear_ancho_subcolumnas($objPHPExcel, $w, $count, $ancho_para_firmas_var);
				$w+=$count;
				if ($columnas[$i][2]=='C' and $columnas[$i][3]==-1)
				{	$materias_cuantitativas_count++;
				}
			}
		}
		//Pone en primer lugar COMPORTAMIENTO...
		for ($i=0;$i<count($columnas);$i++)
		{	if ($columnas[$i][1]=='COMPORTAMIENTO')
		{	$temp=$columnas[$i][5];
			$count=count($modelos[$temp]);
			$ancho_para_firmas_var=($ancho_para_firmas/$count);
			if ($ancho_para_firmas_var < 2)
				$ancho_para_firmas_var = 2;
			genera_detalle($objPHPExcel, $w, 7, $columnas[$i][1], $count,$styleArray);
		listado_rotar_texto_celda($objPHPExcel, $w, 7, 0);
		setear_ancho_subcolumnas($objPHPExcel, $w, $count, $ancho_para_firmas_var);
		$w+=$count;
		if ($columnas[$i][2]=='C' and $columnas[$i][3]==-1)
		{	$materias_cuantitativas_count++;
		}
		}
		}
		//PROMEDIO RENDIMIENTO
		genera_detalle($objPHPExcel, $w, 7, pasarMayusculas(show_this_phrase(20000014)),2,$styleArrayPromedioRendimiento);
		listado_rotar_texto_celda($objPHPExcel, $w, 7, 0);
		// setear_ancho_subcolumnas($objPHPExcel, $w, count($subcolumnas), $ancho_para_rend);
		//Define largo de la cabecera, después de dar primera vuelta a la primera línea de los rubros.
		$largo_head=$w+count($subcolumnas)-1;
		///////////////////////////////////////////////////////////////////////////////////////
		//SEGUNDO, SUBDETALLE: parcial 1, 2, 3, 4, o quimestre 1, quimestre 2, promedio. segun sea el periodo seleccionado.
		///////////////////////////////////////////////////////////////////////////////////////
		$w=2;
		for ($i=0;$i<count($columnas);$i++)
		{	$temp=$columnas[$i][5];
			foreach ($modelos[$temp] as $subcol)
			{	if ($columnas[$i][1]!='COMPORTAMIENTO')
				{	listado($objPHPExcel, $w, 8, $subcol[1], $styleArray, true, true);
					listado_rotar_texto_celda($objPHPExcel, $w, 8, 90);
					$w++;
				}
			}
		}
		//Pone en primer lugar COMPORTAMIENTO...
		for ($i=0;$i<count($columnas);$i++)
		{	$temp=$columnas[$i][5];
			foreach ($modelos[$temp] as $subcol)
		{	if ($columnas[$i][1]=='COMPORTAMIENTO')
		{	listado($objPHPExcel, $w, 8, $subcol[1], $styleArray, true, true);
		listado_rotar_texto_celda($objPHPExcel, $w, 8, 90);
		$w++;
		}
		}
		}
		//PROMEDIO RENDIMIENTO, SUBDETALLE.
		foreach ($subcolumnas as $subcol)
		{	
			if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA')
			if ($columnas[$i][1]!='COMPORTAMIENTO')
			{	
				genera_detalle($objPHPExcel, $w, 8, $subcol[1],2,$styleArray);
				// listado($objPHPExcel, $w, 8, $subcol[1], $styleArray, true, true);
				listado_rotar_texto_celda($objPHPExcel, $w, 8, 90);
				$w++;
			}
		}
		///////////////////////////////////////////////////////////////////////////////////////
		//LISTADO DE ESTUDIANTES Y NOTAS
		///////////////////////////////////////////////////////////////////////////////////////
		$acum_rendimiento=0;
		$p_r_total_flag=array();
		//PRIMERO NO., LUEGO ESTUDIANTE...
		for ($i=0;$i<count($filas);$i++) 
		{	$asterisco="";
			$retirado_switch=false;
			if ($filas[$i][3]=='RETIRADO') 
			{	$cont_retirados++;
				$asterisco = "*";
				$retirado_switch = true;
			}
			$w=0;
			$p_r_total_flag[$i]=0;
			//listado($objPHPExcel, $w, $i+9, $i+1, $styleArray, true, false);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, $i+1);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->applyFromArray($styleArray);
			$w++;
			listado($objPHPExcel, $w, $i+9, $asterisco . rtrim($filas[$i][1]).' '.rtrim($filas[$i][2]), $styleArray, false, false);
			//...LUEGO INICIO DE NOTAS
			//LAS DEMAS MATERIAS

			$promedio_rendimiento=array();
            for ($j=0;$j<count($columnas);$j++) 
            {	$aux=0;
            	$temp=$columnas[$j][5];
				// $count=count($modelos[$temp]);
				// $ancho_para_firmas_var=($ancho_para_firmas/$count);
				// if ($ancho_para_firmas_var < 2)
				// 	$ancho_para_firmas_var = 2;
				foreach ($modelos[$temp] as $subcol)
				{	
					$params = array($columnas[$j][0]);
					$sql="{call curs_para_mate_info(?)}";
					$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
					$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
					if ($columnas[$j][1]!='COMPORTAMIENTO')
					{	$w++;
						$nota=buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
						//Si la calificación es numérica
						if ($columnas[$j][2]=='C')
						{	if ($nota < 7)
							{	
								if($subcol[0]==$peri_dist_codi)
								{
									$p_r_total_flag[$i]++;
								}
								listado($objPHPExcel, $w, $i+9, $nota, $styleArrayRojo, true, false);
							}else
							{	listado($objPHPExcel, $w, $i+9, $nota, $styleArray, true, false);
							}
							if ($columnas[$j][3]==-1 and ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA') and $subcol[2]=='PM')
							{   
								
								$promedio_rendimiento[$j][$aux]=truncar($nota);
								$aux++;
							}
						}
						//Si la calificación es cualitativa
						else
						{	if ($nota==0)
							{	listado($objPHPExcel, $w, $i+9, '--', $styleArraySinNota, true, false);
							}
							else
							{	$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota);
								listado($objPHPExcel, $w, $i+9, str_replace(array("+","-"),array("",""),$nota_prom_quali), $styleArray, true, false);
							}
						}
					}
                }
            }
            //COMPORTAMIENTO
            for ($j=0;$j<count($columnas);$j++)
            {	$temp=$columnas[$j][5];
            	foreach ($modelos[$temp] as $subcol)
            	{	$params = array($columnas[$j][0]);
            		$sql="{call curs_para_mate_info(?)}";
					$curs_peri_info = sqlsrv_query($conn, $sql, $params);
					$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
					if ($columnas[$j][1]=='COMPORTAMIENTO')
					{	$w++;
    					$nota=buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
						if ($columnas[$j][2]=='C')
    					{	listado($objPHPExcel, $w, $i+9, $nota, $styleArray, true, false);
    					}
    					else
    					{	if ($nota==0)
        					{	listado($objPHPExcel, $w, $i+9, '--', $styleArray, true, false);
    						}
        					else
        					{	$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota);
							listado($objPHPExcel, $w, $i+9, $nota_prom_quali, $styleArray, true, false);
        					}
    					}
					}
				}
			}
			//PROMEDIO RENDIMIENTO
			$p_r_total=array();
			$x=$y=0;
			for ($y=0;$y<count($columnas);$y++)
			{	
				$x=0;
				foreach ($subcolumnas as $subcol)
				{
					if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA'  and $subcol[2]=='PM')
					{
					$p_r_total[$x]=$p_r_total[$x]+truncar($promedio_rendimiento[$y][$x]);
					$x++;
					}
				}
			}
			$z=0;
			foreach ($subcolumnas as $subcol)
			{	
				if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA'  and $subcol[2]=='PM')
				{
				$p_r_total[$z]=truncar(truncar($p_r_total[$z])/$filas[$i][4]);
				$z++;
				}
			}
			$aux=0;
			foreach ($p_r_total as $notaRP)
			{	$w++;
				if ($notaRP < 7)
				{	genera_detalle($objPHPExcel, $w, $i+9, ($notaRP),2,$styleArrayRojo);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getNumberFormat()->setFormatCode('0.00');
					// listado($objPHPExcel, $w, $i+9, ($notaRP), $styleArrayRojo, true, false);
				}else
				{	
					if ( $p_r_total_flag[$i] > 0 and $aux >= $z-1 ){
						genera_detalle($objPHPExcel, $w, $i+9, ($notaRP),2,$styleArrayRojo);
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getNumberFormat()->setFormatCode('0.00');
						// listado($objPHPExcel, $w, $i+9, ($notaRP), $styleArrayRojo, true, false);
					}
					else{
						genera_detalle($objPHPExcel, $w, $i+9, ($notaRP),2,$styleArray);
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getNumberFormat()->setFormatCode('0.00');
					}
						// listado($objPHPExcel, $w, $i+9, ($notaRP), $styleArray, true, false);
				}
				$aux++;
			}
		}
		///////////////////////////////
		//PROMEDIO GLOBAL
		///////////////////////////////
		$w=0;
		//listado($objPHPExcel, $w, ($i+9), '', $styleArray, false, false);
		$w++;
		//listado($objPHPExcel, $w, ($i+9), PrimeraMayuscula(show_this_phrase(20000008)), $styleArray, true, true);
		//LAS DEMAS MATERIAS (IMPRIME EN BLANCO SI NO ES 'C')
		$promedio_rendimiento_global=array();
		/*for ($j=0;$j<count($columnas);$j++) 
		{	$aux=0;
			foreach ($subcolumnas as $subcol)
			{	//Datos de la materia
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
						{	$cont_alumnos++;
							$acum_global=$acum_global+buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
						}
					}
					$prom_global=$acum_global/$cont_alumnos;
					//Si la calificación es numérica
					if ($columnas[$j][2]=='C')
					{	if ($prom_global >= 8)
						{	listado($objPHPExcel, $w, $i+9, truncar($prom_global), $styleArrayBuenaNota, true, true);
						}else
						{	listado($objPHPExcel, $w, $i+9, truncar($prom_global), $styleArray, true, true);
						}
						listado_rotar_texto_celda($objPHPExcel,$w, $i+9,90);
						if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA')
						{
							$promedio_rendimiento_global[$j][$aux]=$prom_global;
							$aux++;
						}
					}
					//Si la calificación es cualitativa
					else
					{	if ($prom_global==0)
						{	listado($objPHPExcel, $w, $i+9, '--', $styleArray, true, true);
						}
						else
						{	$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$prom_global);
							//listado($objPHPExcel, $w, $i+9, $nota_prom_quali, $styleArray, true, true);
							listado($objPHPExcel, $w, $i+9, '--', $styleArray, true, true);
						}
					}
				}
			}
		}
		//COMPORTAMIENTO (IMPRIME EN BLANCO)
		for ($j=0;$j<count($columnas);$j++)
		{	foreach ($subcolumnas as $subcol)
		{	//Datos de la materia
			$params = array($columnas[$j][0]);
			$sql="{call curs_para_mate_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params);
						$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
						if ($columnas[$j][1]=='COMPORTAMIENTO')
				{	$w++;
						$acum_global=0;
						$prom_global=0;
						for ($i=0;$i<count($filas);$i++)
						{	$acum_global=$acum_global+buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
					}
								$prom_global=$acum_global/count($filas);
								//Si la calificación es numérica
						if ($columnas[$j][2]=='C')
						{	if ($prom_global >= 8)
						{	listado($objPHPExcel, $w, $i+9, truncar($prom_global), $styleArrayBuenaNota, true, true);
						}else
						{	listado($objPHPExcel, $w, $i+9, truncar($prom_global), $styleArray, true, true);
						}
						listado_rotar_texto_celda($objPHPExcel,$w, $i+9,90);
						$promedio_rendimiento_global[$j][$aux]=$prom_global;
						$aux++;
			}
			//Si la calificación es cualitativa
						else
						{	if ($prom_global==0)
						{	listado($objPHPExcel, $w, $i+9, '--', $styleArray, true, true);
						}
						else
						{	$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$prom_global);
						//listado($objPHPExcel, $w, $i+9, $nota_prom_quali, $styleArray, true, true);
						listado($objPHPExcel, $w, $i+9, '--', $styleArray, true, true);
						}
						}
						}
						}
						}
		//PROMEDIO RENDIMIENTO GLOBAL
		$p_r_g_total=array();
		$x=$y=0;
		for ($y=0;$y<count($columnas);$y++)
		{	$x=0;
				foreach ($subcolumnas as $subcol)
				{
					if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA')
					{
					$p_r_g_total[$x]=$p_r_g_total[$x]+$promedio_rendimiento_global[$y][$x];
					$x++;
					}
			}
		}
		$z=0;
			foreach ($subcolumnas as $subcol)
				{	
					if ($subcol[1]!='EX. SUPLETORIO' and $subcol[1]!='EX. REMEDIAL' and $subcol[1]!='MEJORAMIENTO' and $subcol[1]!='EX. GRACIA')
					{
					$p_r_g_total[$z]=$p_r_g_total[$z]/$materias_cuantitativas_count;
					$z++;
					}
			}
		foreach ($p_r_g_total as $notaRP)
		{	$w++;
			if ($notaRP > 8)
			{	listado($objPHPExcel, $w, $i+9, truncar($notaRP), $styleArrayBuenaNota, true, true);
			}else
			{	listado($objPHPExcel, $w, $i+9, truncar($notaRP), $styleArray, true, true);
			}
			listado_rotar_texto_celda($objPHPExcel,$w, $i+9,90);
		}*/
		listado_setear_altura_fila($objPHPExcel, $i+9, 35);
		///////////////////////////////
		//FIRMAS
		///////////////////////////////
		//Para que no se salte la línea de promedios globales que por el momento se la va a quitar
		$i=$i-1;
		
		$w=0;
		if( $_SESSION['directorio']!='delfos' and $_SESSION['directorio']!='delfosvesp'){
			listado($objPHPExcel, $w, ($i+10), '', $styleArray, false, false);
			$w++;
			listado($objPHPExcel, $w, ($i+10), 'FIRMAS', $styleArray, true, true);
			$w++;
			//...Luego, las otras materias del quimestre.
			for ($j=0;$j<count($columnas);$j++)
			{	if ($columnas[$j][1]!='COMPORTAMIENTO')
				{	$temp=$columnas[$j][5];
					$count=count($modelos[$temp]);
					
					$curs_para_mate_codi=$columnas[$j][0];
					$params = array($curs_para_mate_codi);
					$sql="{call prof_curs_para_mate_cons (?)}";
					$dat_profesor = sqlsrv_query($conn, $sql, $params);  
					$prof_row=sqlsrv_fetch_array($dat_profesor);
					$profesor=rtrim($prof_row['prof_apel']).' '.rtrim($prof_row['prof_nomb']);
					genera_detalle($objPHPExcel, $w, ($i+10), $profesor, $count ,$styleArrayFirmas);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+10))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
					$w+=$count;
				}
			}
			for ($j=0;$j<count($columnas);$j++)
			{	if ($columnas[$j][1]=='COMPORTAMIENTO')
			{	$temp=$columnas[$j][5];
				$count=count($modelos[$temp]);
				$curs_para_mate_codi=$columnas[$j][0];
				$params = array($curs_para_mate_codi);
				$sql="{call prof_curs_para_mate_cons (?)}";
						$dat_profesor = sqlsrv_query($conn, $sql, $params);
				$prof_row=sqlsrv_fetch_array($dat_profesor);
				$profesor=rtrim($prof_row['prof_apel']).' '.rtrim($prof_row['prof_nomb']);
				genera_detalle($objPHPExcel, $w, ($i+10), $profesor, $count,$styleArrayFirmas);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+10))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
				$w+=$count;
			}
			}
			//BLOQUE EN BLANCO
			genera_detalle($objPHPExcel, $w, ($i+10), '',2,$styleArrayPromedioRendimiento);
		}
		listado_setear_altura_fila($objPHPExcel, ($i+10), 60);
		///////////////////////////////
		//SEÑAL DE ALUMNOS RETIRADOS
		///////////////////////////////
		$i+=2;
		if($cont_retirados>0)
		{
			listado($objPHPExcel, 1, ($i+10), "* " . show_this_phrase(20000007), $styleArrayFont, false, false);
			$i++;
			listado($objPHPExcel, 1, ($i+10), "*** " . show_this_phrase(20000003), $styleArrayFont, false, false);
			$i+=2;
		}
		///////////////////////////////
		//FECHA Y USUARIO QUE GENERA EL REPORTE AL FINAL DEL DOCUMENTO
		///////////////////////////////
		listado($objPHPExcel, 1, ($i+10), get_fecha_ciudad($current_language), $styleArrayFont, false, true);
		$i++;
		listado($objPHPExcel, 1, ($i+10), PrimeraMayuscula(show_this(10000001)) . ': ' . $_SESSION['usua_codi'], $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+13), "______________________________", $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+14), para_sist(5), $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+15), para_sist(33), $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+20), "______________________________", $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+21), para_sist(6), $styleArrayFont, false, true);
		listado($objPHPExcel, 1, ($i+22), para_sist(34), $styleArrayFont, false, true);

		//Logotipo del ministerio
		$maxWidth = 100;
		$maxHeight = 50;
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		$objDrawing->setName("Logo Ministerio");
		$objDrawing->setDescription("Logo Ministerio");
		$objDrawing->setPath('../'.$_SESSION['ruta_foto_logo_index']);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight($maxHeight);
		$offsetX =$maxWidth - $objDrawing->getWidth();
		if($offsetX<0)
			$offsetX=0;
		$objDrawing->setOffsetX($offsetX);
	}
	else
	{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, show_this_phrase(20000004));
	}
	/*Fin*/
	//////////////////////////////////////////////////////////////////////
	//ULTIMAS CARACTERISTICAS A SETEAR PARA EL DOCUMENTO EXCEL A GENERAR
	//////////////////////////////////////////////////////////////////////
	//Largo del encabezado, se calculA sólo despues de saber el numero de columnas que conforman los rubros.
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'1:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'1');
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'2:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'2');
	$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'3:'.PHPExcel_Cell::stringFromColumnIndex($largo_head).'3');
	
	// Setea altura de fila 7 y fila 8.
	listado_setear_altura_fila($objPHPExcel, 7, 40);
	listado_setear_altura_fila($objPHPExcel, 8, 85);
				
	// Renombrar Hoja de excel
	$objPHPExcel->getActiveSheet()->setTitle('Cuadro final');
	
	//Oculta lineas no sombreadas
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	
	//Inmmovilizar paneles
	$objPHPExcel->getActiveSheet()->freezePane("C7");
	
	//Repetir Columnas a la izquierda
	$objPHPExcel->getActiveSheet()->getPageSetup()->setColumnsToRepeatAtLeftByStartAndEnd("A", "B");
	
	// Establecer seguridad para que no se pueda manipular el excel.
	//$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setPassword('Educ@link5');
	
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.show_this_phrase(20000002).' '.  $periodo_descrp. ' '.pasarMayusculas($curso_descr).'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
	//////////////////////////////////////////
	//FUNCIONES VARIAS
	//////////////////////////////////////////
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
	function setear_ancho_subcolumnas($objPHPExcel, $columna, $subcolumnas_count, $ancho)
	{	for($c=0;$c<$subcolumnas_count;$c++)
		{	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($columna+$c))->setWidth($ancho);
		}
	}
	//////////////////////////////////////////
	//FUNCIONES PARA FORMATEAR CELDAS PHPEXCEL
	//////////////////////////////////////////
	function genera_detalle($objPHPExcel, $columna, $fila, $detalle, $subcolumnas_count, $styleArray)
	{	//genera detalle, con combinado determinado por el numero de subcolumnas que tenga cada detalle.
		$objPHPExcel->getActiveSheet()->mergeCells(cellsToMergeByColsRow($columna, $columna+$subcolumnas_count-1, ($fila)));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($columna, $fila, $detalle);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getFont($columna)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(cellsToMergeByColsRow($columna, $columna+$subcolumnas_count-1, ($fila)))->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle(cellsToMergeByColsRow($columna, $columna+$subcolumnas_count-1, ($fila)))->applyFromArray($styleArray);
	}
	function listado($objPHPExcel, $columna, $fila, $detalle, $styleArray, $centrado, $negrita)
	{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($columna, $fila, (($detalle=="0" || $detalle=="")?"--":$detalle));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getNumberFormat()->setFormatCode('0.00');
		if($centrado==true)
		{
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		if($negrita==true)
		{
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getFont($columna)->setBold(true);
		}
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->applyFromArray($styleArray);
	}
	function listado_aplicar_estilo($objPHPExcel, $columna, $fila, $styleArray)
	{	//aplica estilo a celda ya creada.
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->applyFromArray($styleArray);
	}
	function listado_rotar_texto_celda($objPHPExcel, $columna, $fila, $grados)
	{	$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($columna).($fila))->getAlignment()->setTextRotation($grados);
	}
	function listado_setear_altura_fila($objPHPExcel, $fila, $altura)
	{	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight($altura);
	}
?>