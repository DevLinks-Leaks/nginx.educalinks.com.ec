<?php
	session_start();
	if ($_FILES['file']['error'])
	{
		echo "Hay un error";
	}
	else
	{
		$target_path = "../importacion_datos/uploads/".$_SESSION['directorio']."/";
		$target_path = $target_path . basename( $_FILES['file']['name']);
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) 
		{ 
			echo "Ha ocurrido un error, trate de nuevo!";
		}
		
		if (file_exists($target_path))
		{
			try
			{
				require_once ('../framework/PHPExcel/Classes/PHPExcel/IOFactory.php');
				require_once ('../framework/dbconf.php');
				if( strtoupper(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION)) == 'XLS' )
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
				if( strtoupper(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION)) == 'XLSX' )
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				
				$objReader -> setReadDataOnly(true);
				$objPHPExcel = $objReader->load($target_path);
				$objPHPExcel->setActiveSheetIndex(0);		
				$filas = $objPHPExcel->getActiveSheet()->getHighestRow();
				$columnas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
				
				if ($_POST['tabla']=='alumnos')
				{
					// for ($i=2; $i<=$filas; $i++)
					// {
					// 	$params = array();
					// 	for ($j=0; $j<$columnas; $j++)
					// 	{
					// 		$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
					// 	}
					// 	$sql="{call migracion_alumnos_xls(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
					// 	$importa_add = sqlsrv_query($conn, $sql, $params);
					// 	if ($importa_add===false)
					// 	{
					// 		//echo "Ha ocurrido un error en la base de datos.";
					// 		//exit ();
					// 		die(print_r(sqlsrv_errors(),true));
					// 	}
					// }
					$xml_alumno = new DOMDocument("1.0","UTF-8");
					$root_alumno = $xml_alumno->createElement("root");
					for ($i=2; $i<=$filas; $i++)
					{
						$alumno = $xml_alumno->createElement("alumno");
						
						$alumno->setAttribute('alum_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
						$alumno->setAttribute('alum_nomb',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue());
						$alumno->setAttribute('alum_apel',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue());
						$alumno->setAttribute('alum_cedu',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
						$alumno->setAttribute('alum_tipo_iden',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
						$alumno->setAttribute('alum_fech_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue());
						$alumno->setAttribute('alum_genero',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
						$alumno->setAttribute('alum_pais',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
						$alumno->setAttribute('alum_prov_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
						$alumno->setAttribute('alum_ciud_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $i)->getValue());
						$alumno->setAttribute('alum_parr_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $i)->getValue());
						$alumno->setAttribute('alum_sect_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $i)->getValue());
						$alumno->setAttribute('alum_nacionalidad',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $i)->getValue());
						$alumno->setAttribute('alum_mail',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $i)->getValue());
						$alumno->setAttribute('alum_celu',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $i)->getValue());
						$alumno->setAttribute('alum_domi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $i)->getValue());
						$alumno->setAttribute('alum_telf',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $i)->getValue());
						$alumno->setAttribute('alum_ciud',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $i)->getValue());
						$alumno->setAttribute('alum_parroquia',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $i)->getValue());
						$alumno->setAttribute('idreligion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, $i)->getValue());
						$alumno->setAttribute('alum_vive_con',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, $i)->getValue());
						$alumno->setAttribute('idparentescovivecon',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21, $i)->getValue());
						$alumno->setAttribute('idestadocivilpadres',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(22, $i)->getValue());
						$alumno->setAttribute('alum_movilizacion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(23, $i)->getValue());
						$alumno->setAttribute('alum_tiene_discapacidad',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(24, $i)->getValue());
						$alumno->setAttribute('alum_discapacidad',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(25, $i)->getValue());
						$alumno->setAttribute('alum_activ_deportiva',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(26, $i)->getValue());
						$alumno->setAttribute('alum_activ_artistica',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(27, $i)->getValue());
						$alumno->setAttribute('alum_enfermedades',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(28, $i)->getValue());
						$alumno->setAttribute('alum_tipo_sangre',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(29, $i)->getValue());
						$alumno->setAttribute('alum_ex_plantel',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(30, $i)->getValue());
						$alumno->setAttribute('alum_ex_plantel_dire',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(31, $i)->getValue());
						$alumno->setAttribute('alum_motivo_cambio',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(32, $i)->getValue());
						$alumno->setAttribute('alum_condicionado',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(33, $i)->getValue());
						$alumno->setAttribute('alum_motivo_condicion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(34, $i)->getValue());
						$alumno->setAttribute('alum_ultimo_anio',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(35, $i)->getValue());
						$alumno->setAttribute('alum_conducta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(36, $i)->getValue());
						$alumno->setAttribute('alum_pers_emerg',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(37, $i)->getValue());
						$alumno->setAttribute('alum_parentesco_emerg',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(38, $i)->getValue());
						$alumno->setAttribute('alum_telf_emerg',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(39, $i)->getValue());
						$root_alumno->appendChild($alumno);
					}
					$xml_alumno->appendChild($root_alumno);

					$xml=$xml_alumno->saveXML();
					$xml = str_replace('UTF-8', 'ISO-8859-1',$xml );

					$params = array($xml,$_SESSION['peri_codi']);
					$sql="{call migracion_alumnos_xls(?,?)}";
					$migracion_alumnos_xls = sqlsrv_query($conn, $sql, $params);
					if ($migracion_alumnos_xls===false)
					{
						//echo "Ha ocurrido un error en la base de datos.";
						//exit ();
						$result= json_encode(array ('state'=>'error',
							'result'=>'Error al realizar la importación.' ));
						// die(print_r(sqlsrv_errors(),true));
					}else{
						//registrar_auditoria (315, '');
						$result= json_encode(array ('state'=>'success',
							'result'=>'Importación realizada con éxito.' ));
					}
				}
	
				
				if ($_POST['tabla']=='representantes')
				{
					// for ($i=2; $i<=$filas; $i++)
					// {
					// 	$params = array();
					// 	for ($j=0; $j<$columnas; $j++)
					// 	{
					// 		$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
					// 	}
					// 	$sql="{call migracion_representantes_xls(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
					// 	$importa_add = sqlsrv_query($conn, $sql, $params);
					// 	if ($importa_add===false)
					// 	{
					// 		echo "Ha ocurrido un error en la base de datos.";
					// 		exit ();
					// 	}
					// }
					$xml_representante = new DOMDocument("1.0","UTF-8");
					$root_representante = $xml_representante->createElement("root");
					for ($i=2; $i<=$filas; $i++)
					{
						$representante = $xml_representante->createElement("representante");
						
						$representante->setAttribute('repr_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
						$representante->setAttribute('repr_cedula',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue());
						$representante->setAttribute('repr_tipoidfactura',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue());
						$representante->setAttribute('repr_nomb',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
						$representante->setAttribute('repr_apel',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
						$representante->setAttribute('repr_email',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue());
						$representante->setAttribute('repr_telf',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
						$representante->setAttribute('repr_celular',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
						$representante->setAttribute('repr_domi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
						$representante->setAttribute('idestadocivil',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $i)->getValue());
						$representante->setAttribute('repr_fech_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $i)->getValue());
						$representante->setAttribute('repr_pais_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $i)->getValue());
						$representante->setAttribute('repr_prov_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $i)->getValue());
						$representante->setAttribute('repr_ciud_naci',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $i)->getValue());
						$representante->setAttribute('repr_nacionalidad',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $i)->getValue());
						$representante->setAttribute('repr_profesion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $i)->getValue());
						$representante->setAttribute('repr_lugar_trabajo',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $i)->getValue());
						$representante->setAttribute('repr_direc_trabajo',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $i)->getValue());
						$representante->setAttribute('repr_telf_trab',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $i)->getValue());
						$representante->setAttribute('repr_cargo',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, $i)->getValue());
						$representante->setAttribute('idreligion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, $i)->getValue());
						$representante->setAttribute('repr_estudios',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21, $i)->getValue());
						$representante->setAttribute('repr_institucion',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(22, $i)->getValue());
						$representante->setAttribute('repr_fech_promoc',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(23, $i)->getValue());
						$representante->setAttribute('repr_ex_alum',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(24, $i)->getValue());
						$representante->setAttribute('repr_motivo_representa',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(25, $i)->getValue());
						$representante->setAttribute('repr_escolaborador',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(26, $i)->getValue());
						$root_representante->appendChild($representante);
					}
					$xml_representante->appendChild($root_representante);

					$xml=$xml_representante->saveXML();
					$xml = str_replace('UTF-8', 'ISO-8859-1',$xml );

					$params = array($xml);
					$sql="{call migracion_representantes_xls(?)}";
					$migracion_representantes_xls = sqlsrv_query($conn, $sql, $params);
					if ($migracion_representantes_xls===false)
					{
						//echo "Ha ocurrido un error en la base de datos.";
						//exit ();
						$result= json_encode(array ('state'=>'error',
							'result'=>'Error al realizar la importación.' ));
						// die(print_r(sqlsrv_errors(),true));
					}else{
						//registrar_auditoria (315, '');
						$result= json_encode(array ('state'=>'success',
							'result'=>'Importación realizada con éxito.' ));
					}
				}
				
				if ($_POST['tabla']=='alum_repr')
				{
					$xml_alum_repr = new DOMDocument("1.0","UTF-8");
					$root_alum_repr = $xml_alum_repr->createElement("root");
					for ($i=2; $i<=$filas; $i++)
					{
						$alum_repr = $xml_alum_repr->createElement("alum_repr");
						
						$alum_repr->setAttribute('alum_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
						$alum_repr->setAttribute('repr_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue());
						$alum_repr->setAttribute('repre_alum_fact',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue());
						$alum_repr->setAttribute('repre_alum_princ',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
						$alum_repr->setAttribute('idparentesco',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
						$root_alum_repr->appendChild($alum_repr);
					}
					$xml_alum_repr->appendChild($root_alum_repr);
					$xml=$xml_alum_repr->saveXML();
					$xml = str_replace('UTF-8', 'ISO-8859-1',$xml );

					$params = array($xml);
					$sql="{call migracion_alum_repr_xls(?)}";
					$migracion_alum_repr_xls = sqlsrv_query($conn, $sql, $params);
					if ($migracion_alum_reprs_xls===false)
					{
						//echo "Ha ocurrido un error en la base de datos.";
						//exit ();
						$result= json_encode(array ('state'=>'error',
							'result'=>'Error al realizar la importación.' ));
						// die(print_r(sqlsrv_errors(),true));
					}else{
						//registrar_auditoria (315, '');
						$result= json_encode(array ('state'=>'success',
							'result'=>'Importación realizada con éxito.' ));
					}
				}

				if ($_POST['tabla']=='profesores')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						$sql="{call migracion_profesores_xls(?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
					
				echo "<img src='../imagenes/butones/green_check.png'/>";
			}
			catch (Exception $e)
			{
				echo "<img src='../imagenes/butones/x_roja.png'/>".$e;
			}
		}
	}
?>