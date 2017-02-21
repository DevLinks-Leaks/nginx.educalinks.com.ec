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
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objReader -> setReadDataOnly(true);
				$objPHPExcel = $objReader->load($target_path);
				$objPHPExcel->setActiveSheetIndex(0);		
				$filas = $objPHPExcel->getActiveSheet()->getHighestRow();
				$columnas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
				
				if ($_POST['tabla']=='alumnos')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						$sql="{call migracion_alumnos_xls(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							//echo "Ha ocurrido un error en la base de datos.";
							//exit ();
							die(print_r(sqlsrv_errors(),true));
						}
					}
				}
	
				if ($_POST['tabla']=='materias')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						$params[]=$_SESSION['peri_codi'];
						$sql="{call migracion_materias_xls(?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
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
				
				if ($_POST['tabla']=='representantes')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						$sql="{call migracion_representantes_xls(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				
				if ($_POST['tabla']=='alumnos_cursos_paralelos')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						$params[]=$_SESSION['peri_codi'];
						$sql="{call migracion_matriculas_xls(?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='sucursal')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_sucursal_xls(?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='puntoVenta')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_puntoVenta_xls(?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='categoria')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_categoria_xls(?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='producto')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_producto_xls(?,?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='precio')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_precio_xls(?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='formaPago')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_formaPago_xls(?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='deuda')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_deuda_xls(?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='detalleFactura')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_detalleFactura_xls(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='cabeceraFactura')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_cabeceraFactura_xls(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='cabeceraPago')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_cabeceraPago_xls(?,?,?,?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='detallePago')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_detallePago_xls(?,?,?,?,?,?,?)}";
						$importa_add = sqlsrv_query($conn, $sql, $params);
						if ($importa_add===false)
						{
							echo "Ha ocurrido un error en la base de datos.";
							exit ();
						}
					}
				}
				if ($_POST['tabla']=='deudaAfectada')
				{
					for ($i=2; $i<=$filas; $i++)
					{
						$params = array();
						for ($j=0; $j<$columnas; $j++)
						{
							$params[]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
						}
						
						$sql="{call migracion_deudaAfectada_xls(?,?,?,?,?,?)}";
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
				echo "<img src='../imagenes/butones/x_roja.png'/>";
			}
		}
	}