<?php
	require_once ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
	require_once ('../framework/PHPExcel/Classes/PHPExcel.php');
	session_start();

	if (isset($_GET['curs_para_codi']))
	{	$curs_para_codi = $_GET['curs_para_codi'];
	}
	else
	{	$curs_para_codi = 0;
	}	
	if (isset($_GET['peri_dist_cab_codi']))
	{	$peri_dist_cab_codi = $_GET['peri_dist_cab_codi'];
	}
	else
	{	$peri_dist_cab_codi = 0;
	}
				
	//Creando documento de excel
	$objPHPExcel = new PHPExcel();
	//Escala de impresión 75%
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(90);
	//Orientación de la hoja vertical
	$objPHPExcel->getActiveSheet()
				->getPageSetup()
				->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	//Alineación izquierda default
	$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				
	/*Estilos y formatos*/
	//Negrita
	$negrita = array(
				'font'  => array(
					'bold'  => true,
				));
				
	//Cabecera
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'INFORME DE EXCELENCIA ACADÉMICA');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'CÓDIGO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'CURSO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, 'PARALELO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 2, 'PROM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 2, 'GRUPO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 2, 'COMPORTAMIENTO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->applyFromArray($negrita);
	//SP para consultar el listado
	$sql	= "{call exce_acad_view(?,?)}";
	$params	= array($peri_dist_cab_codi,$curs_para_codi);
	$stmt	= sqlsrv_query($conn,$sql,$params);
	$linea	= 3;
	while ($row = sqlsrv_fetch_array($stmt))
	{	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linea, $row["alum_codi"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linea, $row["curs_deta"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linea, $row["para_deta"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linea, $row["alum_apel"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linea, $row["alum_nomb"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linea, truncar($row["prom"]));
		$objPHPExcel->getActiveSheet()->getStyle('F'.$linea)->getNumberFormat()->setFormatCode('0.00'); 
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linea, $row["exce_acad_descripcion"]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linea, notas_prom_quali($_SESSION['peri_codi'],'D',$row["comp"]));
		//Siguiente línea
		$linea++;
	}
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Informe_Excelencia_Acad.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;