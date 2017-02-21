<?php
require_once ('../framework/dbconf.php');
require_once ('../framework/funciones.php');
require_once ('../framework/PHPExcel/Classes/PHPExcel.php');


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
			->setCreator("Redlinks")
			->setTitle("Archivo Importación Recursos Tipo Libros")
			->setSubject("Archivo Importación Recursos Tipo Libros")
			->setDescription("Archivo Importación Recursos Tipo Libros");
	
/*Estilos*/	
$etiquetas = array('font' => array('color' => array('rgb'=>'000000'),'size' => 11,'bold' => true,'name' => 'Calibri'));
$somb_tabla_header =  array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '6495ED')));
$somb_tabla_body =  array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'E6E6FA')));
$bordes = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$izquierda = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));

/*Estilos por default*/
$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($izquierda);
$objPHPExcel->getActiveSheet()->setTitle("Recursos Tipo Libro");

/*Cabecera*/
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($somb_tabla_header);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'TITULO');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ISBN');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'EDITORIAL');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'COLECCION');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'FECHA PUBLICACION');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CATEGORIAS');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'DESCRIPTORES');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'AUTOR');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);


$sql	= "{call lib_edit_view()}";
$params = array ();
$stmt 	= sqlsrv_query($conn,$sql,$params);	

while ($row = sqlsrv_fetch_array($stmt))
{
	$edit_deta[] = $row['edit_deta'];
}

$objValidation = $objPHPExcel->getActiveSheet()
							 ->getCell('C2:C50')
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
$edit_list = implode(", ",$edit_deta);
$objValidation->setFormula1('"'.$edit_list.'"');	

	
/*Bloqueo de celdas no editables*/
// $objPHPExcel->getActiveSheet()->getStyle('C9:'.PHPExcel_Cell::stringFromColumnIndex($num_in_notas+1).($num_alum+8))->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
// $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setPassword('Educ@link5');
// $objPHPExcel->getSecurity()->setLockWindows(true);
// $objPHPExcel->getSecurity()->setLockStructure(true);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=tmp_recursos_libros.xlsx');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>