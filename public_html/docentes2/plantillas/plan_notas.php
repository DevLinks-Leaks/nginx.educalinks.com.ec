<?php
require_once ('../../framework/dbconf.php');
require_once ('../../framework/funciones.php');
require_once ('../../framework/PHPExcel/Classes/PHPExcel.php');
/*Recuperando variables GET*/
if (isset($_GET['curs_para_mate_prof_codi']))
	$curs_para_mate_prof_codi = $_GET['curs_para_mate_prof_codi'];
else
	$curs_para_mate_prof_codi = "";

if (isset($_GET['peri_dist_codi']))
	$peri_dist_codi = $_GET['peri_dist_codi'];
else
	$peri_dist_codi = "";

$nombre_excel = "";

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
->setCreator("Redlinks")
->setTitle("Plantilla de notas")
->setSubject("Plantilla de notas")
->setDescription("Plantilla de notas");
	
/*Estilos*/	
$etiquetas = array('font' => array('color' => array('rgb'=>'000000'),'size' => 11,'bold' => true,'name' => 'Calibri'));
$somb_tabla_header =  array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '6495ED')));
$somb_tabla_body =  array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'E6E6FA')));
$bordes = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$izquierda = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));

/*Estilos por default*/
$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($izquierda);
$objPHPExcel->getActiveSheet()->setTitle("Notas");

/*Cabecera*/
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PLANTILLA DE INGRESO DE CALIFICACIONES');
$objPHPExcel->getActiveSheet()->getStyle('A1:A8')->applyFromArray($etiquetas);
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'UNIDAD');
$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'PROFESOR');
$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'ASIGNATURA');
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'CURSO/PAR.');
$objPHPExcel->getActiveSheet()->SetCellValue('A8', 'CODALUM');
$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($somb_tabla_header);
$objPHPExcel->getActiveSheet()->SetCellValue('B8', 'ALUMNOS');
$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($somb_tabla_header);
$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($etiquetas);
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'NUM. ALUM.');
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'NUM. INGR.');
$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'COD. UNID.');
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'PROF. MAT.');
$objPHPExcel->getActiveSheet()->getStyle('C2:C5')->applyFromArray($etiquetas);
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'MAT. PRINC.');
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'TIPO MAT.');
$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'N. REF. CAB.');
$objPHPExcel->getActiveSheet()->getStyle('F2:F4')->applyFromArray($etiquetas);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

/*Cabecera de plantilla*/
$sql	= "{call plan_notas_cab(?,?)}";
$params = array ($curs_para_mate_prof_codi,$peri_dist_codi);
$stmt 	= sqlsrv_query($conn,$sql,$params);
$row 	= sqlsrv_fetch_array($stmt);
$nota_refe_cab_tipo = $row['nota_refe_cab_tipo'];
$nota_refe_cab_codi = $row['nota_refe_cab_codi'];
$objPHPExcel->getActiveSheet()->SetCellValue('B2', $row['peri_dist_deta'].'/'.$row['peri_dist_padr_deta']);
$objPHPExcel->getActiveSheet()->SetCellValue('B3', $row['prof_apel'].' '.$row['prof_nomb']);
$objPHPExcel->getActiveSheet()->SetCellValue('B4', $row['mate_deta']);
$objPHPExcel->getActiveSheet()->SetCellValue('B5', $row['curs_deta'].' "'.$row['para_deta'].'"');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'NUM. ALUM.');
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'NUM. INGR.');
$objPHPExcel->getActiveSheet()->SetCellValue('D4', $peri_dist_codi);
$objPHPExcel->getActiveSheet()->SetCellValue('D5', $curs_para_mate_prof_codi);
$objPHPExcel->getActiveSheet()->SetCellValue('G2', $row['mate_padr']);
$objPHPExcel->getActiveSheet()->SetCellValue('G3', $nota_refe_cab_tipo);
$objPHPExcel->getActiveSheet()->SetCellValue('G4', $nota_refe_cab_codi);
$nombre_excel = substr($row['curs_deta'],0,5).'-'.
				substr($row['para_deta'],0,5).'-'.
				substr($row['mate_deta'],0,10).'-'.
				substr($row['peri_dist_deta'],0,12).'-'.
				substr($row['peri_dist_padr_deta'],0,15);
/*Ingresos de notas*/
$sql	= "{call plan_notas_in_deta(?,?)}";
$params = array ($peri_dist_codi,$nota_refe_cab_codi);
$opt 	= array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt 	= sqlsrv_query($conn,$sql,$params,$opt);
$num_in_notas = sqlsrv_num_rows($stmt);
$objPHPExcel->getActiveSheet()->SetCellValue('D3', $num_in_notas);
$i=2; //Comienza en la columna C
while ($row = sqlsrv_fetch_array($stmt))
{	$objPHPExcel->getActiveSheet()->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($i).'8', 
												$row['peri_dist_abre'].' ('.$row['peri_dist_codi'].')');
	$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).'8')->applyFromArray($etiquetas);
	$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).'8')->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).'8')->applyFromArray($somb_tabla_header);
	$i++;//Siguiente columna
}
/*Nómina de estudiantes*/
$sql	= "{call plan_notas_alum_deta(?)}";
$params = array ($curs_para_mate_prof_codi);
$opt 	= array( "Scrollable" => "buffered" );
$stmt 	= sqlsrv_query($conn,$sql,$params,$opt);
$num_alum = sqlsrv_num_rows($stmt);
$objPHPExcel->getActiveSheet()->SetCellValue('D2', $num_alum);
$i=9; //Comienza en la fila 9
while ($row = sqlsrv_fetch_array($stmt))
{	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row['alum_curs_para_mate_codi']);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row['alum_apel'].' '.$row['alum_nomb']);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($bordes);
	$i++;//Siguiente fila
} 
/*En caso de ser numérica la nota*/
if ($nota_refe_cab_tipo=='C')
{	for ($fila=9;$fila<=($num_alum+8);$fila++)
	{	for ($col=2;$col<=($num_in_notas+1);$col++)
		{	$objValidation = $objPHPExcel->getActiveSheet()
										 ->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$fila)
										 ->getDataValidation();
			$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_DECIMAL );
			$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
			$objValidation->setAllowBlank(true);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setErrorTitle('Error');
			$objValidation->setError('Valor incorrecto');
			$objValidation->setPromptTitle('Valores permitidos');
			$objValidation->setPrompt('Solo valores entre 0 y 10.');
			$objValidation->setFormula1(0);
			$objValidation->setFormula2(10);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$fila)->applyFromArray($bordes);
		}
		if ($num_in_notas>1)
		{	$objPHPExcel->getActiveSheet()->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($col).$fila, '=TRUNC(SUM('.PHPExcel_Cell::stringFromColumnIndex(2).$fila.':'.PHPExcel_Cell::stringFromColumnIndex($num_in_notas+1).$fila.')/'.$num_in_notas.','.para_sist(41).')');
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$fila)->getNumberFormat()->setFormatCode('0.00');
		}
	}
	$objPHPExcel->getActiveSheet()->getStyle('C9:'.PHPExcel_Cell::stringFromColumnIndex($num_in_notas+1).($num_alum+8))->getNumberFormat()->setFormatCode('0.00');
}
else
{	$sql	= "{call nota_peri_cual_tipo_view_NEW(?)}";
	$params = array ($nota_refe_cab_codi);
	$stmt 	= sqlsrv_query($conn,$sql,$params);	
	$pos_notas_cual = $num_alum+8+3; //El 2 es para bajar dos posiciones
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$pos_notas_cual, 'EQ.');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$pos_notas_cual)->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$pos_notas_cual)->applyFromArray($somb_tabla_header);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$pos_notas_cual, 'DETALLE');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$pos_notas_cual)->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$pos_notas_cual)->applyFromArray($somb_tabla_header);
	while ($row = sqlsrv_fetch_array($stmt))
	{	$pos_notas_cual++;
		$notas_cual[] = $row['nota_peri_cual_refe'];
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$pos_notas_cual, $row['nota_peri_cual_refe']);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$pos_notas_cual)->applyFromArray($bordes);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$pos_notas_cual)->applyFromArray($somb_tabla_body);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$pos_notas_cual, $row['nota_peri_cual_deta']);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$pos_notas_cual)->applyFromArray($bordes);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$pos_notas_cual)->applyFromArray($somb_tabla_body);
	}
	for ($col=2;$col<=($num_in_notas+1);$col++)
	{	for ($fila=9;$fila<=($num_alum+8);$fila++)
		{	$objValidation = $objPHPExcel->getActiveSheet()
										 ->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$fila)
										 ->getDataValidation();
			$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
			$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
			$objValidation->setAllowBlank(false);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setShowDropDown(true);
			$objValidation->setErrorTitle('Error');
			$objValidation->setError('Valor no se encuentra en la lista.');
			$objValidation->setPromptTitle('Seleccionar');
			$objValidation->setPrompt('Por favor seleccione un valor de la lista');
			$notas_list = implode(", ",$notas_cual);
			$objValidation->setFormula1('"'.$notas_list.'"');
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$fila)->applyFromArray($bordes);
		}
	}
}	
	
/*Bloqueo de celdas no editables*/
$objPHPExcel->getActiveSheet()->getStyle('C9:'.PHPExcel_Cell::stringFromColumnIndex($num_in_notas+1).($num_alum+8))->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('Educ@link5');
$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombre_excel.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>