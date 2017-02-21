<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}

	$dir_path = "../importacion_datos/biblio/uploads/".$_SESSION['directorio']."/";
	$target_path = $dir_path . basename( $_FILES['file']['name']);
	if ($_FILES['file']['error'])
	{
		$result= json_encode(array ('state'=>'error',
						'result'=>'Error al subir archivo.' ));
	}else{
		$fileType = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
		if( $fileType != "xls" ) {
		    $result= json_encode(array ('state'=>'error',
						'result'=>'Favor ingresar el formato correcto de subida.'.$fileType ));
		}else{
			if(!mkdir($dir_path,0777,TRUE)){
				$result= json_encode(array ('state'=>'error',
						'result'=>"Ha ocurrido un error no existe directorio de subida de archivos, trate de nuevo!" ));
			}
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) 
			{ 
				$result= json_encode(array ('state'=>'error',
						'result'=>"Ha ocurrido un error, trate de nuevo!" ));
			}
			
			if (file_exists($target_path))
			{
				try
				{
					require_once ('../framework/PHPExcel/Classes/PHPExcel/IOFactory.php');
					require_once ('../framework/dbconf.php');
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objReader -> setReadDataOnly(true);
					$objPHPExcel = $objReader->load($target_path);
					$objPHPExcel->setActiveSheetIndex(0);		
					$filas = $objPHPExcel->getActiveSheet()->getHighestRow();
					$columnas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
					
					switch($opc){
						case 'auto':
							$xml_autor = new DOMDocument("1.0","UTF-8");
							$root_auto = $xml_autor->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$autor = $xml_autor->createElement("autor");
								
								$autor->setAttribute('auto_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$autor->setAttribute('auto_apel',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$autor->setAttribute('auto_nomb',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue()));
								$root_auto->appendChild($autor);
							}
							$xml_autor->appendChild($root_auto);


							$params = array($xml_autor->saveXML());
							$sql="{call lib_migracion_autores_xls(?)}";
							$migracion_autores_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_autores_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (315, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'cate':
							$xml_categoria = new DOMDocument("1.0","UTF-8");
							$root_cate = $xml_categoria->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$cate = $xml_categoria->createElement("cate");
								$cate->setAttribute('cate_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$cate->setAttribute('cate_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_cate->appendChild($cate);
							}
							$xml_categoria->appendChild($root_cate);


							$params = array($xml_categoria->saveXML());
							$sql="{call lib_migracion_categorias_xls(?)}";
							$migracion_categorias_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_categorias_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (316, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'desc':
							$xml_descriptor = new DOMDocument("1.0","UTF-8");
							$root_desc = $xml_descriptor->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$desc = $xml_descriptor->createElement("desc");
								$desc->setAttribute('desc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$desc->setAttribute('desc_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_desc->appendChild($desc);
							}
							$xml_descriptor->appendChild($root_desc);


							$params = array($xml_descriptor->saveXML());
							$sql="{call lib_migracion_descriptores_xls(?)}";
							$migracion_descriptores_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_descriptores_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (317, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'tipo':
							$xml_tipos = new DOMDocument("1.0","UTF-8");
							$root_tipo = $xml_tipos->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$tipo = $xml_tipos->createElement("tipo");
								$tipo->setAttribute('tipo_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$tipo->setAttribute('tipo_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_tipo->appendChild($tipo);
							}
							$xml_tipos->appendChild($root_tipo);


							$params = array($xml_tipos->saveXML());
							$sql="{call lib_migracion_tipos_xls(?)}";
							$migracion_tipos_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_tipos_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (318, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'cole':
							$xml_coleccion = new DOMDocument("1.0","UTF-8");
							$root_cole = $xml_coleccion->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$cole = $xml_coleccion->createElement("cole");
								$cole->setAttribute('cole_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$cole->setAttribute('cole_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_cole->appendChild($cole);
							}
							$xml_coleccion->appendChild($root_cole);


							$params = array($xml_coleccion->saveXML());
							$sql="{call lib_migracion_coleccion_xls(?)}";
							$migracion_coleccion_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_coleccion_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (319, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'edit':
							$xml_editorial = new DOMDocument("1.0","UTF-8");
							$root_edit = $xml_editorial->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$edit = $xml_editorial->createElement("edit");
								$edit->setAttribute('edit_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$edit->setAttribute('edit_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_edit->appendChild($edit);
							}
							$xml_editorial->appendChild($root_edit);


							$params = array($xml_editorial->saveXML());
							$sql="{call lib_migracion_editorial_xls(?)}";
							$migracion_editorial_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_editorial_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.'.print_r(sqlsrv_errors() )));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (320, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'proc':
							$xml_procedencia = new DOMDocument("1.0","UTF-8");
							$root_proc = $xml_procedencia->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$proc = $xml_procedencia->createElement("proc");
								$proc->setAttribute('proc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$proc->setAttribute('proc_deta',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$root_proc->appendChild($proc);
							}
							$xml_procedencia->appendChild($root_proc);

							$params = array($xml_procedencia->saveXML());
							$sql="{call lib_migracion_procedencia_xls(?)}";
							$migracion_procedencia_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_procedencia_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								registrar_auditoria (321, '');
								$result= json_encode(array ('state'=>'success',
									'result'=>'Importaci realizada con éxito.' ));
							}

						break;

						case 'recu_libr':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu");
								$recu->setAttribute('recu_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$recu->setAttribute('recu_titu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$recu->setAttribute('recu_isbn',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue()));
								$recu->setAttribute('recu_edit_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
								$recu->setAttribute('recu_cole_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
								$recu->setAttribute('recu_fech_publ',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue()));
								$recu->setAttribute('recu_cate_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
								$recu->setAttribute('recu_desc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
								$recu->setAttribute('recu_auto_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_recursos_libros_xls(?)}";
							$lib_migracion_recursos_libros_xls = sqlsrv_query($conn, $sql, $params);
							if ($lib_migracion_recursos_libros_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$row_lib_migracion_recursos_libros_xls = sqlsrv_fetch_array($lib_migracion_recursos_libros_xls);
								if($row_lib_migracion_recursos_libros_xls['error']==null){
									$detalle="Resultado: Exitoso";
									registrar_auditoria (310, $detalle);
									$result= json_encode(array ('state'=>'success',
									'result'=>'Importación realizada con éxito.' ));
								}else{
									$detalle="Resultado: Error";
									$detalle.=" Detalle_Error: ".$row_lib_migracion_recursos_libros_xls['error'];
									registrar_auditoria (310, $detalle);
									$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación. '.$row_lib_migracion_recursos_libros_xls['error'] ));
								}
							}

						break;

						case 'recu_revi':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu");
								$recu->setAttribute('recu_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$recu->setAttribute('recu_titu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$recu->setAttribute('recu_issn',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue()));
								$recu->setAttribute('recu_edit_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
								$recu->setAttribute('recu_cole_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
								$recu->setAttribute('recu_fech_publ',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue()));
								$recu->setAttribute('recu_cate_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
								$recu->setAttribute('recu_desc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
								$recu->setAttribute('recu_auto_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_recursos_revistas_xls(?)}";
							$lib_migracion_recursos_revistas_xls = sqlsrv_query($conn, $sql, $params);
							if ($lib_migracion_recursos_revistas_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$row_lib_migracion_recursos_revistas_xls = sqlsrv_fetch_array($lib_migracion_recursos_revistas_xls);
								if($row_lib_migracion_recursos_revistas_xls['error']==null){
									$detalle="Resultado: Exitoso";
									registrar_auditoria (311, $detalle);
									$result= json_encode(array ('state'=>'success',
									'result'=>'Importación realizada con éxito.' ));
								}else{
									$detalle="Resultado: Error";
									$detalle.=" Detalle_Error: ".$row_lib_migracion_recursos_revistas_xls['error'];
									registrar_auditoria (311, $detalle);
									$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación. '.$row_lib_migracion_recursos_revistas_xls['error'] ));
								}
							}

						break;

						case 'recu_vide':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu");
								$recu->setAttribute('recu_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$recu->setAttribute('recu_titu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$recu->setAttribute('recu_edit_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue());
								$recu->setAttribute('recu_cole_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
								$recu->setAttribute('recu_fech_publ',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue()));
								$recu->setAttribute('recu_cate_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue());
								$recu->setAttribute('recu_desc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
								$recu->setAttribute('recu_dire_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
								$recu->setAttribute('recu_acto_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
								$recu->setAttribute('recu_vide_dura',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $i)->getValue()));
								$recu->setAttribute('recu_vide_resu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $i)->getValue()));
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_recursos_videos_xls(?)}";
							$lib_migracion_recursos_videos_xls = sqlsrv_query($conn, $sql, $params);
							if ($lib_migracion_recursos_videos_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$row_lib_migracion_recursos_videos_xls = sqlsrv_fetch_array($lib_migracion_recursos_videos_xls);
								if($row_lib_migracion_recursos_videos_xls['error']==null){
									$detalle="Resultado: Exitoso";
									registrar_auditoria (312, $detalle);
									$result= json_encode(array ('state'=>'success',
									'result'=>'Importación realizada con éxito.' ));
								}else{
									$detalle="Resultado: Error";
									$detalle.=" Detalle_Error: ".$row_lib_migracion_recursos_videos_xls['error'];
									registrar_auditoria (312, $detalle);
									$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación. '.$row_lib_migracion_recursos_videos_xls['error'] ));
								}
							}

						break;

						case 'recu_otro':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu");
								$recu->setAttribute('recu_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$recu->setAttribute('recu_tipo_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue());
								$recu->setAttribute('recu_titu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue()));
								$recu->setAttribute('recu_edit_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
								$recu->setAttribute('recu_cole_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
								$recu->setAttribute('recu_fech_publ',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue()));
								$recu->setAttribute('recu_cate_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue());
								$recu->setAttribute('recu_desc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue());
								$recu->setAttribute('recu_auto_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getValue());
								$recu->setAttribute('recu_vide_resu',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $i)->getValue()));
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_recursos_otros_xls(?)}";
							$lib_migracion_recursos_otros_xls = sqlsrv_query($conn, $sql, $params);
							if ($lib_migracion_recursos_otros_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$row_lib_migracion_recursos_otros_xls = sqlsrv_fetch_array($lib_migracion_recursos_otros_xls);
								if($row_lib_migracion_recursos_otros_xls['error']==null){
									$detalle="Resultado: Exitoso";
									registrar_auditoria (313, $detalle);
									$result= json_encode(array ('state'=>'success',
									'result'=>'Importación realizada con éxito.' ));
								}else{
									$detalle="Resultado: Error";
									$detalle.=" Detalle_Error: ".$row_lib_migracion_recursos_otros_xls['error'];
									registrar_auditoria (313, $detalle);
									$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación. '.$row_lib_migracion_recursos_otros_xls['error'] ));
								}
							}

						break;

						case 'recu_item':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu_item");
								$recu->setAttribute('recu_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$recu->setAttribute('item_edic',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue()));
								$recu->setAttribute('item_fech_ing',utf8_encode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue()));
								$recu->setAttribute('item_prec',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
								$recu->setAttribute('item_proc_migr_codi',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue());
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_recursos_items_xls(?)}";
							$lib_migracion_recursos_items_xls = sqlsrv_query($conn, $sql, $params);
							if ($lib_migracion_recursos_items_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();

								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								// sqlsrv_fetch($lib_migracion_recursos_items_xls);
								// $stmt=sqlsrv_get_field($lib_migracion_recursos_items_xls,0);
								$row_lib_migracion_recursos_items_xls = sqlsrv_fetch_array($lib_migracion_recursos_items_xls);
								if($row_lib_migracion_recursos_items_xls['error']==null){
									/*Auditoria*/
									$detalle="Resultado: Exitoso";
									registrar_auditoria (314, $detalle);
									/*Auditoria FIN*/
									$result= json_encode(array ('state'=>'success',
									'result'=>'Importación realizada con éxito.' ));
								}else{
									$detalle="Resultado: Error";
									$detalle.=" Detalle_Error: ".$row_lib_migracion_recursos_items_xls['error'];
									registrar_auditoria (314, $detalle);
									$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación. '.$row_lib_migracion_recursos_items_xls['error'] ));
								}
							}

						break;
					}
					
				}
				catch (Exception $e)
				{
					$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
				}
			}
		
		}
	}

	echo $result;
?>