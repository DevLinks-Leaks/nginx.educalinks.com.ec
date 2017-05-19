<?php
	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('../framework/PHPExcel/Classes/PHPExcel.php');
	
	/*Estilos para las cabeceras*/
	$style_cabecera = array ('alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER),
							 'font'=>array('name'=>'Arial Narrow','bold'=>true,'color'=>array('rgb'=>'CCFFE5')),
							 'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'017EBA')),
							 'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'CCFFE5'))));
							 
	$style_detalle = array ('alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER),
							 'font'=>array('name'=>'Arial Narrow','color'=>array('rgb'=>'000000')));
	
	/*Creación del documento de excel*/
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
	->setCreator(para_sist(2))
	->setLastModifiedBy(para_sist(2))
	->setTitle("Listado de estudiantes")
	->setSubject("Listado de estudiantes")
	->setDescription("Estudiante del periodo ".$_SESSION['peri_deta']);
	
	if(isset($_SESSION['peri_codi']))
	{	$peri_codi=$_SESSION['peri_codi'];
	}
	$params	= array($peri_codi);
	$sql	= "{call alum_peri_view_all(?)}";
	$stmt	= sqlsrv_query($conn, $sql, $params);  
	$cc = 1; 
		
	/*Cabecera del reporte*/
	$objPHPExcel->getActiveSheet()->getStyle("A1:BP1")->applyFromArray($style_cabecera);
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
	$objPHPExcel->getActiveSheet()->getStyle("A2:BP2")->applyFromArray($style_cabecera);
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:T1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','ESTUDIANTE');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U1:AD1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1','MADRE');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AE1:AN1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1','PADRE');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AO1:AY1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1','REPRESENTANTE PRINCIPAL');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AZ1:BK1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ1','REPRESENTANTE FINANCIERO');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BL1:BP1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL1','INFORMACION EXTRA');
	/*Datos del estudiante*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 2, 'Nº');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(6);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, 'CÓDIGO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 2, 'CÉDULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(3))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, 2, 'FECHA NCTO.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(5))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, 2, 'CURSO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(6))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, 2, 'PARALELO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(7))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 2, 'GÉNERO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(8))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, 2, 'NACIONALIDAD');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(9))->setWidth(15);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, 2, 'CONDICIONADO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(10))->setWidth(15);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, 2, 'INCLUSIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(11))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 2, 'EST. CIVIL PADRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(12))->setWidth(25);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 2, 'TELÉFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(13))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 2, 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(14))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, 2, 'CIUDAD');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(15))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16, 2, 'PARROQUIA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(16))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(17, 2, 'DIRECCIÓN DOM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(17))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(18, 2, 'CONTACTO EMERGENCIA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(18))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(19, 2, 'TELF. EMERGENCIA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(19))->setWidth(20);
	
	/*Datos de la madre*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(20, 2, 'CÉDULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(20))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(21, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(21))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(22, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(22))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(23, 2, 'TELÉFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(23))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(24, 2, 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(24))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(25, 2, 'CORREO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(25))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(26, 2, 'DIRECCIÓN DOM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(26))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(27, 2, 'PROFESIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(27))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(28, 2, 'LUGAR DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(28))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(29, 2, 'TELÉFONO DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(29))->setWidth(40);


	/*Datos del padre*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(30, 2, 'CÉDULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(30))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(31, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(31))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(32, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(32))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(33, 2, 'TELÉFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(33))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(34, 2, 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(34))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(35, 2, 'CORREO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(35))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(36, 2, 'DIRECCIÓN DOM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(36))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(37, 2, 'PROFESIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(37))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(38, 2, 'LUGAR DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(38))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(39, 2, 'TELÉFONO DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(39))->setWidth(40);
	
	/*Datos de la representante principal*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(40, 2, 'PARENTESCO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(40))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(41, 2, 'CÉDULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(41))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(42, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(42))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(43, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(43))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(44, 2, 'TELÉFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(44))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(45, 2, 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(45))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(46, 2, 'CORREO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(46))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(47, 2, 'DIRECCIÓN DOM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(47))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(48, 2, 'PROFESIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(48))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(49, 2, 'LUGAR DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(49))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(50, 2, 'TELÉFONO DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(50))->setWidth(40);

	/*Datos del representante financiero*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(51, 2, 'PARENTESCO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(51))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(52, 2, 'CÉDULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(52))->setWidth(13);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(53, 2, 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(53))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(54, 2, 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(54))->setWidth(30);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(55, 2, 'TELÉFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(55))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(56, 2, 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(56))->setWidth(12);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(57, 2, 'CORREO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(57))->setWidth(20);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(58, 2, 'DIRECCIÓN DOM.');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(58))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(59, 2, 'PENSIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(59))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(60, 2, 'PROFESIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(60))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(61, 2, 'LUGAR DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(61))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(62, 2, 'TELÉFONO DE TRABAJO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(62))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(63, 2, 'ESTADO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(63))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(64, 2, 'PERIODO REGISTRO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(64))->setWidth(40);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(65, 2, 'FECHA DE MATRICULA');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(65))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(66, 2, 'ETNIA DEL ALUMNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(66))->setWidth(40);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(67, 2, 'GRUPO ECONÓMICO');
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(67))->setWidth(40);
	/*Detalle del reporte*/
	while ($row = sqlsrv_fetch_array($stmt))
	{	$objPHPExcel->getActiveSheet()->getStyle("A".($cc+2).":BN".($cc+2))->applyFromArray($style_detalle);
		/*Datos del estudiante*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $cc+2, $cc);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $cc+2, $row['alum_codi']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $cc+2, $row['alum_cedu']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $cc+2, $row['alum_apel']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $cc+2, $row['alum_nomb']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $cc+2, $row['alum_fech_naci']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $cc+2, $row['curs_deta']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $cc+2, $row['para_deta']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $cc+2, ($row['alum_genero']==1?'Hombre':'Mujer'));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $cc+2, $row['alum_nacionalidad']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $cc+2, ($row['alum_condicionado']==1?'Sí':'No'));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $cc+2, ($row['alum_discapacidad']==1?'Sí':'No'));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $cc+2, $row['alum_esta_civil_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, $cc+2, $row['alum_telf']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, $cc+2, $row['alum_celu']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, $cc+2, $row['alum_ciud']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16, $cc+2, $row['alum_parroquia']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(17, $cc+2, $row['alum_domi']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(18, $cc+2, $row['alum_pers_emerg']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(19, $cc+2, $row['alum_telf_emerg']);
		/*Datos de la madre*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(20, $cc+2, $row['repr_cedula_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(21, $cc+2, $row['repr_apel_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(22, $cc+2, $row['repr_nomb_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(23, $cc+2, $row['repr_telf_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(24, $cc+2, $row['repr_celular_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(25, $cc+2, $row['repr_email_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(26, $cc+2, $row['repr_domi_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(27, $cc+2, $row['repr_profesion_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(28, $cc+2, $row['repr_lugar_trabajo_madr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(29, $cc+2, $row['repr_telf_trab_madr']);
		/*Datos del padre*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(30, $cc+2, $row['repr_cedula_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(31, $cc+2, $row['repr_apel_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(32, $cc+2, $row['repr_nomb_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(33, $cc+2, $row['repr_telf_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(34, $cc+2, $row['repr_celular_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(35, $cc+2, $row['repr_email_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(36, $cc+2, $row['repr_domi_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(37, $cc+2, $row['repr_profesion_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(38, $cc+2, $row['repr_lugar_trabajo_padr']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(39, $cc+2, $row['repr_telf_trab_padr']);
		/*Datos del representante principal*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(40, $cc+2, $row['repr_parentesco']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(41, $cc+2, $row['repr_cedula_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(42, $cc+2, $row['repr_apel_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(43, $cc+2, $row['repr_nomb_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(44, $cc+2, $row['repr_telf_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(45, $cc+2, $row['repr_celular_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(46, $cc+2, $row['repr_email_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(47, $cc+2, $row['repr_domi_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(48, $cc+2, $row['repr_profesion_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(49, $cc+2, $row['repr_lugar_trabajo_princ']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(50, $cc+2, $row['repr_telf_trab_princ']);
		/*Datos del representante financiero*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(51, $cc+2, $row['repr_parentesco_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(52, $cc+2, $row['repr_cedula_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(53, $cc+2, $row['repr_apel_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(54, $cc+2, $row['repr_nomb_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(55, $cc+2, $row['repr_telf_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(56, $cc+2, $row['repr_celular_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(57, $cc+2, $row['repr_email_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(58, $cc+2, $row['repr_domi_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(59, $cc+2, $row['cabefact_totalNeto']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(60, $cc+2, $row['repr_profesion_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(61, $cc+2, $row['repr_lugar_trabajo_fina']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(62, $cc+2, $row['repr_telf_trab_fina']);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(63, $cc+2, $row['esta_deta']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(64, $cc+2, $row['alum_peri_regi']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(65, $cc+2, $row['acpe_fecha_reg']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(66, $cc+2, $row['alum_etnia']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(67, $cc+2, $row['alum_grupo_econ']);
		$cc++;
	}
	
	
	 //Filtros
	 //Por curso y paralelo
	 //$objPHPExcel->getActiveSheet()->setAutoFilter('E1:F'.$cc);
	 
	 // Renombrar Hoja
	 $objPHPExcel->getActiveSheet()->setTitle($_SESSION['peri_deta']);

	 // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	 $objPHPExcel->setActiveSheetIndex(0);

	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Nomina.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;