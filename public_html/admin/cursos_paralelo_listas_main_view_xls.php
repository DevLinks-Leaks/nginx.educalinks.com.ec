<?php
	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('../framework/PHPExcel/Classes/PHPExcel.php');
	include ('script_cursos.php'); 
	
	//Creando documento de excel
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
	->setCreator(para_sist(2))
	->setLastModifiedBy(para_sist(2))
	->setTitle("Listado de estudiantes")
	->setSubject("Listado de estudiantes")
	->setDescription("Listado de estudiantes de todo el periodo ".$_SESSION['peri_deta']);
	
	$all='UNA';$peri_codi=0;
	
	if(isset($_GET['peri_codi'])){
		 $peri_codi=$_GET['peri_codi'];
		 $all='YES';
	}
	
	
	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
  	
	while (($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) or  ($all=='UNA'))  
	{ 
		if ($all=='UNA'){ 
			$all='OFF';
			if(isset($_GET['curs_para_codi'])){
				$curs_para_codi=$_GET['curs_para_codi'];
			}
			if(isset($_POST['curs_para_codi'])){
				$curs_para_codi=$_POST['curs_para_codi'];
			}
			 
		}else {
			$curs_para_codi=$row_curs_peri_view['curs_para_codi'];
		}
	

		$params = array($curs_para_codi);
		$sql="{call alum_curs_para_list(?)}";
		$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
		
		$params = array($curs_para_codi);
		$sql="{call curs_peri_info(?)}";
		$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
		$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(3))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(5))->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(6))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(7))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(8))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(9))->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(10))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(11))->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(12))->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(13))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(14))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(15))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(16))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(17))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(18))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(19))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(20))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(21))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(22))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(23))->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(24))->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(25))->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(26))->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(27))->setWidth(40);
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, 'Nº');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, 'CÓDIGO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, 'APELLIDOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, 1, 'NOMBRES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, 1, 'CURSO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, 1, 'PARALELO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, 1, 'CORREO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, 1, 'TELF. 1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 1, 'TELF. 2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, 1, 'DIRECCION');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, 1, 'PAIS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, 1, 'NACIONALIDAD');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 1, 'REPRESENTANTE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 1, 'FECHA NCTO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 1, 'CÉDULA ESTUDIANTE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, 1, 'USUARIO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16, 1, 'CONDICIONADO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(17, 1, 'FECHA MATR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(18, 1, 'MATRÍCULA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(19, 1, 'FOLIO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(20, 1, 'ESTADO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(21, 1, 'FECHA RETIRO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(22, 1, 'CELULAR REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(23, 1, 'TELF. REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(24, 1, 'CORREO REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(25, 1, 'DIRECCIÓN REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(26, 1, 'CARGO REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(27, 1, 'CÉDULA REPR.');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(28, 1, 'DISCAPACIDAD');

		while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) 
		{ 
			$cc +=1;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $cc+1, $cc);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $cc+1, $row_alum_curs_para_view["alum_codi"]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $cc+1, $row_alum_curs_para_view["alum_apel"]);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $cc+1, $row_alum_curs_para_view["alum_nomb"]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $cc+1, $row_curs_peri_info['curs_deta']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $cc+1, $row_curs_peri_info['para_deta']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $cc+1, $row_alum_curs_para_view['alum_mail']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $cc+1, $row_alum_curs_para_view['alum_celu']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $cc+1, $row_alum_curs_para_view['alum_telf']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $cc+1, $row_alum_curs_para_view['alum_domi']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $cc+1, $row_alum_curs_para_view['alum_pais']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $cc+1, $row_alum_curs_para_view['alum_nacionalidad']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $cc+1, $row_alum_curs_para_view['representante']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, $cc+1, $row_alum_curs_para_view['alum_fech_naci']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, $cc+1, $row_alum_curs_para_view['alum_cedu']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, $cc+1, $row_alum_curs_para_view['alum_usua']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16, $cc+1, $row_alum_curs_para_view['alum_condicionado']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(17, $cc+1, $row_alum_curs_para_view['alum_curs_para_fech']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(18, $cc+1, $row_alum_curs_para_view['alum_curs_para_matri']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(19, $cc+1, $row_alum_curs_para_view['alum_curs_para_folio']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(20, $cc+1, $row_alum_curs_para_view['alum_curs_para_estado']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(21, $cc+1, $row_alum_curs_para_view['alum_curs_para_fech_retiro']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(22, $cc+1, $row_alum_curs_para_view['repr_celular']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(23, $cc+1, $row_alum_curs_para_view['repr_telf']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(24, $cc+1, $row_alum_curs_para_view['repr_email']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(25, $cc+1, $row_alum_curs_para_view['repr_domi']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(26, $cc+1, $row_alum_curs_para_view['repr_cargo']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(27, $cc+1, $row_alum_curs_para_view['repr_cedula']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(28, $cc+1, $row_alum_curs_para_view['alum_discapacidad']);
			}
		 }
		 //Filtros
		 //Por curso y paralelo
		 $objPHPExcel->getActiveSheet()->setAutoFilter('E1:F'.$cc);
		 
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