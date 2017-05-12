<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=4;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php 
						session_start();	 
						include ('../framework/dbconf.php');
						
						$peri_dist_codi=$_POST['peri_dist_codi'];
						$curs_para_mate_prof_codi = $_POST['curs_para_mate_prof_codi'];
						$nota_perm_codi = $_POST['nota_perm_codi'];
						$opc = $_POST['opc'];
					
						/*Datos del profesor, curso y asignatura*/
						$params = array($curs_para_mate_prof_codi);
						$sql="{call curs_para_mate_prof_info(?)}";
						$curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params); 
						$row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);		 
						/*Datos de la unidad a ingresar*/
						$params = array($peri_dist_codi);
						$sql="{call peri_dist_info(?)}";
						$peri_dist_info = sqlsrv_query($conn, $sql, $params); 
						$row_peri_dist_info= sqlsrv_fetch_array($peri_dist_info);		 
					?>
					<h1>Ingreso de notas</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-briefcase"></i></a></li>
						<li class="active">Ingreso de notas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<script src="js/notasv2.js"></script>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div  id="notas_view">
									<?
									switch ($opc)
									{	case 'upload_view':
									?>
									<form id="upload_view" action="" enctype="multipart/form-data" method="POST"  onsubmit="return upload_excel();">
										<table class="table table-striped table-bordered">
											<tr>
												<td>Cód. permiso:</td>
												<td><?= $nota_perm_codi;?></td>
											</tr>
											<tr>
												<td width="20%">Curso:</td>
												<td><?= $row_curs_para_mate_prof_info['curs_deta'];?></td>
											</tr>
											<tr>
												<td width="20%">Paralelo:</td>
												<td><?= $row_curs_para_mate_prof_info['para_deta'];?></td>
											</tr>
											<tr>
												<td>Asignatura:</td>
												<td><?= $row_curs_para_mate_prof_info['mate_deta'];?></td>
											</tr>
											<tr>
												<td>Profesor:</td>
												<td><?= $row_curs_para_mate_prof_info['prof_nomb'].' '.
														$row_curs_para_mate_prof_info['prof_apel'];?></td>
											</tr>
											<tr>
												<td>Unidad:</td>
												<td><?= $row_peri_dist_info['peri_dist_deta'].' / '.
														$row_peri_dist_info['peri_dist_deta_padr'];?></td>
											</tr>
											<tr>
												<td>Descargar Plantilla:</td>
												<td><a href="plantillas/plan_notas.php?peri_dist_codi=<?=$peri_dist_codi?>&curs_para_mate_prof_codi=<?=$curs_para_mate_prof_codi?>">Descargar</a></td>
											</tr>
											<tr>
												<td>Seleccionar Plantilla:</td>
												<td><input id="file_notas" name="file_notas" type="file" accept=".xlsx"/></td>
											</tr>
											<tr>
												<td>Subir Archivo:</td>
												<td>
													<button class="btn btn-success">
														<span class="fa fa-file-excel-o"></span> Subir Excel
													</button>
												</td>
											</tr>
										</table>
										<input 
											id="curs_para_mate_prof_codi" 
											type="hidden" 
											name="curs_para_mate_prof_codi" 
											value="<?= $row_curs_para_mate_prof_info['curs_para_mate_prof_codi'];?>" />
										<input 
											id="curs_para_mate_codi" 
											type="hidden" 
											name="curs_para_mate_codi" 
											value="<?= $row_curs_para_mate_prof_info['curs_para_mate_codi'];?>" />
										<input 
											id="peri_dist_codi" 
											type="hidden" 
											name="peri_dist_codi" 
											value="<?= $row_peri_dist_info['peri_dist_codi'];?>" />
										<input
											id="nota_perm_codi"
											type="hidden"
											name="nota_perm_codi"
											value="<?=$nota_perm_codi?>"
										<input id="label" type="hidden" name="label" value="VISUALIZACIÓN DE NOTAS" />
										<input id="icon" type="hidden" name="icon" value="icon-eye icon" />
										<input id="opc" type="hidden" name="opc" value="upload_file" />
									</form>
									<?
										break;
										case 'upload_file':
										/*Código del periodo distribución*/
										if (isset($_POST['peri_dist_codi']))
											$peri_dist_codi = $_POST['peri_dist_codi'];
										else
											$peri_dist_codi = 0;
										/*Código del curso paralelo materia profesor*/
										if (isset($_POST['curs_para_mate_prof_codi']))
											$curs_para_mate_prof_codi = $_POST['curs_para_mate_prof_codi'];
										else
											$curs_para_mate_prof_codi = 0;
										/*Código del curso paralelo materia profesor*/
										if (isset($_POST['curs_para_mate_codi']))
											$curs_para_mate_codi = $_POST['curs_para_mate_codi'];
										else
											$curs_para_mate_codi = 0;
										/*Código de nota permiso*/
										if (isset($_POST['nota_perm_codi']))
										{	$nota_perm_codi = $_POST['nota_perm_codi'];
										}
										else
										{	$nota_perm_codi = 0;
										}
										/*Crear directorio donde serán almacenados los excel y xml de notas*/
										if (!file_exists($_SESSION['ruta_notas']))
										{	mkdir($_SESSION['ruta_notas'], 0777, true);
										}
										/*Cargar el archivo al servidor*/
										if ($_FILES['file_notas']['error'])
										{	echo "Hay un error";
										}
										else
										{	
											$target_path = $_SESSION['ruta_notas'];
											$date = date("Ymd_His");
											//echo $date;
											//$strdate = $date->format('Ymd H:i:s');
											//echo $strdate;
											$path_auditoria = $curs_para_mate_prof_codi . "_" . $peri_dist_codi."_". $date .".xlsx"; 
											$target_path = $target_path . $curs_para_mate_prof_codi . "_" . $peri_dist_codi."_". $date .".xlsx"; 
											if(!move_uploaded_file($_FILES['file_notas']['tmp_name'], $target_path)) 
											{	echo "Ha ocurrido un error, trate de nuevo!";
											}
											else
											{	/*Cargar archivo en memoria*/
												if (file_exists($target_path) and mime_content_type_2($target_path)=="application/vnd.ms-excel")
												{	try
													{	require_once ('../framework/PHPExcel/Classes/PHPExcel/IOFactory.php');
														$inputFiletype = PHPExcel_IOFactory::identify($target_path);
														$objReader = PHPExcel_IOFactory::createReader($inputFiletype);
														$objReader -> setReadDataOnly(true);
														$objPHPExcel = $objReader->load($target_path);
														$objPHPExcel->setActiveSheetIndex(0);
														$num_alums	= $objPHPExcel->getActiveSheet()->getCell("D2")->getValue();
														$num_ingr	= $objPHPExcel->getActiveSheet()->getCell("D3")->getValue();
														$mate_tipo	= $objPHPExcel->getActiveSheet()->getCell("G3")->getValue();
														$nota_refe_cab_cod	= $objPHPExcel->getActiveSheet()->getCell("G4")->getValue();
														$peri_dist_codi_xls	= $objPHPExcel->getActiveSheet()->getCell("D4")->getValue();
														$curs_para_mate_prof_codi_xls	= $objPHPExcel->getActiveSheet()->getCell("D5")->getValue();
														if ($curs_para_mate_prof_codi_xls!=$curs_para_mate_prof_codi or $peri_dist_codi_xls!=$peri_dist_codi)
														{	echo "<p><h4>¡Asegúrese de que el archivo seleccionado sea de la materia y del parcial/examen correcto!</h4></p>";
															echo "<form method='POST'>";
															echo "<input type='hidden' id='curs_para_mate_prof_codi' name='curs_para_mate_prof_codi' value='".$curs_para_mate_prof_codi."'/>";
															echo "<input type='hidden' id='peri_dist_codi' name='peri_dist_codi' value='".$peri_dist_codi."'/>";
															echo "<input type='hidden' id='nota_perm_codi' name='nota_perm_codi' value='".$nota_perm_codi."'/>";
															echo "<input type='hidden' id='opc' name='opc' value='upload_view'/>";
															echo "<input type='submit' value='Reintentar' />";
															echo "</form>";
															exit ();
														}
														$es_hija	= ($objPHPExcel->getActiveSheet()->getCell("G2")->getValue()>0?1:0);
														$fil_inicial = 9;
														$col_inicial = 2;
														$ancho_notas = 13;
														$ancho_nombres = 100-($ancho_notas*$num_ingr)+10;
														/*Inicio de XML*/
														$xml = new DOMDocument("1.0","UTF-8");
														/*Curso*/
														$curso = $xml->createElement("curso");
														$curso->setAttribute("cpmp",$curs_para_mate_prof_codi);
														$curso->setAttribute("pm",$objPHPExcel->getActiveSheet()->getCell("D4")->getValue());
														$curso->setAttribute("mp",$objPHPExcel->getActiveSheet()->getCell("G2")->getValue());
														$curso->setAttribute("mt",$objPHPExcel->getActiveSheet()->getCell("G3")->getValue());
														$curso->setAttribute("u",$_SESSION["usua_codi"]);
														/*LLeno el arreglo de las equivalencias cualitativas*/
														$arr_nota_cual = array ();
														if ($mate_tipo<>'C')
														{	$sql	= "{call nota_peri_cual_tipo_view_NEW(?)}";
															$params = array ($nota_refe_cab_cod);
															$stmt 	= sqlsrv_query($conn,$sql,$params);	
															while ($arr_nota_cual[] = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC));
														}
														/*Fin*/
														for ($i=$fil_inicial;$i<($num_alums+$fil_inicial);$i++)
														{	/*Alumno*/
															$alumno = $xml->createElement("al");
															$alumno->setAttribute("a",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
															for ($j=$col_inicial;$j<($num_ingr+$col_inicial);$j++)
															{	/*Notas*/
																$nota = $xml->createElement("n");
																$string = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, 8)->getValue();
																$pos_1 = strpos($string,"(");
																$pos_2 = strpos($string,")");
																$peri_dist_nota = substr($string,($pos_1+1),($pos_2-($pos_1+1)));
																$nota->setAttribute("pn",$peri_dist_nota);
																$valor_nota = trim(str_replace(",",".",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue()));

																$nota_in = ($valor_nota==""?0:$valor_nota);
																if ($mate_tipo<>"C")
																{	
																	
																	if($nota_in=='0'){
																		$nota_in=0.0000;
																	}else{
																		$index		= multidimensional_search($arr_nota_cual, array('nota_peri_cual_refe'=>$nota_in));
																		$nota_in	= $arr_nota_cual[$index]["nota_peri_cual_fin"];
																	}
																}
																
																$nota->setAttribute("c",$nota_in);
																if($valor_nota!='')
																	$alumno->appendChild($nota);
															}
														$curso->appendChild($alumno);
														}
														$xml->appendChild($curso);
														/*Guardo las notas en la BD*/
														try
														{	$params = array($xml->saveXML());
															$sql	= "{call notas_xml_add_v2_mejorada (?)}";
															$stmt 	= sqlsrv_query($conn,$sql,$params);
															if ($stmt === false)
															{	echo "Las notas no pudieron ser ingresadas a la base de datos";
																die( print_r( sqlsrv_errors(), true));
															}
															else
															{	$params = array($peri_dist_codi,$curs_para_mate_codi);
																$sql="{call peri_dist_padr_view_in(?,?)}";
																$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params);
																
																$params = array($curs_para_mate_prof_codi,$peri_dist_codi);
																$sql="{call curs_para_nota_peri_dist_view_prof_in(?,?)}";
																$curs_para_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params);
																$row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view);
																
																$params = array($curs_para_mate_codi);
																$sql="{call curs_para_mate_info_NEW(?)}";
																$curs_peri_info = sqlsrv_query($conn, $sql, $params);
																$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
																
																$CC_COLUM=$row_curs_para_nota_peri_dist_view['CC_COLUM'];
																sqlsrv_next_result($curs_para_nota_peri_dist_view);
																$cc = 0;
																$CC_COLUM_index=0;
																
																$tbl_notas='
																	<div class="alert alert-warning alert-dismissible">
																		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
																		<h4><i class="icon fa fa-warning"></i> ¡Advertencia!</h4>
																		Para completar el proceso de subida de notas, <b>dar clíc en guardar</b>.
																	</div>
																			<table class="table table-striped table-bordered">';
																$tbl_notas.="<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>";
																$tbl_notas.="<tr>";
																$tbl_notas.='<th style="text-align:center;">N°</th>';
																$tbl_notas.='<th style="text-align:center;">ALUMNOS</th>';
																
																/*Cabecera de notas*/
																while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))
																{	$cc +=1;
																	$tbl_notas.='<th style="text-align:center;">'.$row_peri_dist_padr_view['peri_dist_abre'].'</th>';
																}
																$tbl_notas.="</tr>";
																$tbl_notas.='</thead>';
																$tbl_notas.='<tbody>';
																$cc =0;
																
																/*Detalle de notas*/
																while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view))
																{	$cc +=1;
																	$tbl_notas.='<tr>';
																	$tbl_notas.='<td style="text-align:center;"> '.$cc.'</td>';
																	$tbl_notas.='<td style="text-align:left;"> '.$row_curs_para_nota_peri_dist_view['alum_codi']." - ".$row_curs_para_nota_peri_dist_view['alum_apel']." ".$row_curs_para_nota_peri_dist_view['alum_nomb']."</td>";
																	$CC_COLUM_index =0;
																	while($CC_COLUM_index < $CC_COLUM )
																	{	if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
																		{	
																			$nota_cero = truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10])<=0 ? 'background-color: red !important;color: white;' : '';
																			$tbl_notas.='<td style="text-align:center;'.$nota_cero.'">'.truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10])."</td>";
																		}
																		else
																		{	$tbl_notas.='<td style="text-align:center;">'.nota_peri_cual_cons ($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_cod'],$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]).'</td>';
																		}
																		$CC_COLUM_index+=1;
																	}
																	$tbl_notas.="</tr>";
																}
																$tbl_notas.='</tbody>';
																$tbl_notas.="</table>";
																echo $tbl_notas;
															?>
																<div style="width:95%; height:90; text-align:right; clear: both">
																	<script type="text/javascript" src="js/actualizar_prom.js?<?=$rand;?>"></script>
																	<button 
																		id="btn_actualizar"
																		class="btn btn-success" 
																		style="margin: 40px 10px; width: 20%;" 
																		data-toggle="modal" 
																		data-loading-text="Guardando..."
																		data-target="#ModalProgActualizacion" 
																		onclick="actualizarProm('<?= $path_auditoria?>',<?= $nota_perm_codi?>,<?= $curs_para_mate_prof_codi?>,<?= $peri_dist_codi ?>,<?= $es_hija ?>,'Iniciando proceso de actualización de notas...',1);">
																		<span class='fa fa-floppy-o'></span> Guardar
																	</button>
																</div>
															<?
															}
														}
														catch (Exception $e)
														{	echo "error";
															echo $e->getMessage();
														}
													}
													catch (Exception $e)
													{
													?>
													<p><h4>Hay un error en el archivo.</h4></p>
													<?
													}
												}
												else
												{
												?>
													<p><h4>El archivo no existe o no es el tipo de archivo correcto.</h4></p>
												<?
												}
											}
										}
										break;
										case 'update_scores':
										echo "Por favor actualice las notas principales";
										?>
										<form id="update_main_subject" action="" enctype="multipart/form-data" method="POST">
											<button class="btn btn-primary" style="margin: 40px 10px; width: 15%;">Actualizar Mat. Principal</button>
											<input id="label" type="hidden" name="label" value="ACTUALIZACIÓN DE PROMEDIOS" />
											<input id="icon" type="hidden" name="icon" value="icon-eye icon" />
											<input id="opc" type="hidden" name="opc" value="update_main_subject" />
										</form>
										<?
										break;
										case 'update_main_subject':
										echo "Las notas han sido actualizadas exitosamente";
										?>
										<button onclick="window.location.href='notasv2.php';">Regresar</button>
										<?
										break;
									}
									function multidimensional_search($parents, $searched) {
									  if (empty($searched) || empty($parents)) {
										return false;
									  }

									  foreach ($parents as $key => $value) {
										$exists = true;
										foreach ($searched as $skey => $svalue) {
										  $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
										}
										if($exists){ return $key; }
									  }

									  return false;
									} 
									?>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<?
			function mime_content_type_2($filename)
			{   $mime_types = array(

					'txt' => 'text/plain',
					'htm' => 'text/html',
					'html' => 'text/html',
					'php' => 'text/html',
					'css' => 'text/css',
					'js' => 'application/javascript',
					'json' => 'application/json',
					'xml' => 'application/xml',
					'swf' => 'application/x-shockwave-flash',
					'flv' => 'video/x-flv',

					// images
					'png' => 'image/png',
					'jpe' => 'image/jpeg',
					'jpeg' => 'image/jpeg',
					'jpg' => 'image/jpeg',
					'gif' => 'image/gif',
					'bmp' => 'image/bmp',
					'ico' => 'image/vnd.microsoft.icon',
					'tiff' => 'image/tiff',
					'tif' => 'image/tiff',
					'svg' => 'image/svg+xml',
					'svgz' => 'image/svg+xml',

					// archives
					'zip' => 'application/zip',
					'rar' => 'application/x-rar-compressed',
					'exe' => 'application/x-msdownload',
					'msi' => 'application/x-msdownload',
					'cab' => 'application/vnd.ms-cab-compressed',

					// audio/video
					'mp3' => 'audio/mpeg',
					'qt' => 'video/quicktime',
					'mov' => 'video/quicktime',

					// adobe
					'pdf' => 'application/pdf',
					'psd' => 'image/vnd.adobe.photoshop',
					'ai' => 'application/postscript',
					'eps' => 'application/postscript',
					'ps' => 'application/postscript',

					// ms office
					'doc' => 'application/msword',
					'rtf' => 'application/rtf',
					'xls' => 'application/vnd.ms-excel',
					'xlsx' => 'application/vnd.ms-excel',
					'ppt' => 'application/vnd.ms-powerpoint',

					// open office
					'odt' => 'application/vnd.oasis.opendocument.text',
					'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
				);
				$temp = explode('.',$filename);
				$ext = strtolower(array_pop($temp));
				if (array_key_exists($ext, $mime_types)) {
					return $mime_types[$ext];
				}
				elseif (function_exists('finfo_open')) {
					$finfo = finfo_open(FILEINFO_MIME);
					$mimetype = finfo_file($finfo, $filename);
					finfo_close($finfo);
					return $mimetype;
				}
				else {
					return 'application/octet-stream';
				}
			}
		?>
		<script type="text/javascript" language="javascript">
			function ejecutar_submit(frm)
			{   document.getElementById(frm).submit();
			}
		</script>
	</body>
</html>
<div
	class="modal fade" 
	id="ModalProgActualizacion" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Progreso de actualización</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id=""> 
					<table id="tabla_info" border="1" width="100%" style="margin-bottom:20px">
						<tr>
							<td width="75%" style="background-color: #b3e6ff">Unidad</td>
							<td width="25%" style="background-color: #b3e6ff">Estado</td>
						</tr>
					</table>
					<div id="btnActualizarAgrupadas">
					</div>
					<div>
					</div>
					<div class="form_element">&nbsp;</div>   
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal">
						Cerrar
				</button>
			</div>
		</div>
	</div>
</div>