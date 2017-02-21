<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php
	//Set no cachinh
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
	session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
								 
	session_activa(2);
?> 
   
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Expires" content="0"> 
        <meta http-equiv="Pragma" content="no-cache">
		<title>Educalinks | <?= para_sist(2); ?></title> 
        
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <link href="../theme/css/base/bootstrap-combined.min.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/main.css" rel="stylesheet" type="text/css">
    	<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
        <link href="../framework/ckeditor/sample.css" rel="stylesheet">   
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
		<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
         
        <script src="../framework/funciones.js"></script>
	    <script src="../framework/funciones_mensajes.js"></script> 
    	<script src="../framework/ckeditor/ckeditor.js"></script>
        <script src="../theme/js/modernizr.custom.js"></script>
		<script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
        <script src="../theme/js/bootstrap.js"></script>
        <script src="../theme/js/moment.min.js"></script>
        <script src="js/posts.js"></script>
        <script src="js/agendas.js"></script>
    
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
        
        
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=4;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<div class="section_side" id="sidePanel">
            
            

       <section class="main">
        
        <div class="ingenium">
          <img src="../theme/images/logo_ingenium.png">
        </div>

        <div class="contenedor">
        <div class="logo"> 
          <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
        </div>
        <h5>Unidad Educativa</h5>
        <h4><?php echo para_sist(3); ?></h4>
        </div> 
      </section>
            	
			<? session_start();include ('../framework/dbconf.php');?>
            <ul class="menu_main">
                <li>
                    <a href="index.php"  <? if ($Menu==0) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="active"  alt="Ir al inicio"> 
                        <span class="icon-home icon"></span>
                        <div class="text"><h4>Inicio</h4></div>
                    </a>
                </li>
                
                <li>
                    <a href="agenda.php"  <?  if ($Menu==2) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las agendas">
                        <span class="icon-calendar icon"></span>
                        <div class="text"><h4>Agenda</h4></div>
                    </a>
                </li>
                
                <li>
                    <a href="clases.php"  <?  if ($Menu==3) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las clases">
                        <span class="icon-book icon"></span>
                        <div class="text"><h4>Clases</h4></div>
                    </a>
                </li>
                     
                
                <li>
                    <a href="notas.php"  <?  if ($Menu==4) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-briefcase icon"></span>
                        <div class="text"><h4>Notas</h4></div>
                    </a>
                </li>
                <?
                if ($_SESSION['es_tutor'])
				{
                ?>
                 <li>
                    <a href="tutor.php"  <?  if ($Menu==7) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-briefcase icon"></span>
                        <div class="text"><h4>Tutor</h4></div>
                    </a>
                </li>
                <?
				}
				?>
                <li>
                    <a href="hora_aten_repr_listas_main.php"  <?  if ($Menu==5) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-clock icon"></span>
                        <?php
                            $params = array($_SESSION['prof_codi']);
                            $sql="{call citas_prof_cont(?)}";
                            $citas_prof_info = sqlsrv_query($conn, $sql, $params);  
                            $row_citas_prof_info = sqlsrv_fetch_array($citas_prof_info);
                        ?>
                        <div class="text"><h4>Citas ( <?=$row_citas_prof_info['cant'];?> )</h4></div>
                    </a>
                </li>
                
                <li>
                    <a href="observaciones.php"  <?  if ($Menu==6) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-eye icon"></span>
                        <div class="text"><h4>Observaciones</h4></div>
                    </a>
                </li>
            
                
                <li>
                    <a href="../help/MANUAL_DOCENTE.pdf" target="_blank" class="section_califications link_menu" alt="Ver Calificaciones">
                        <span class="icon-signup  icon"></span>
                        <div class="text"><h4>Ayuda</h4></div> 
                    </a>
                </li>
              
            </ul>



			</div> 

			<div  id="mainPanel"  class="section_main">
            
            <div class="header">
                <a id="btn" href="#" > <span class=" icon-menu"> </span> Mostrar / Ocultar Menú</a> 


                <div class="userbar dropdown">

                 <ul>
                    <li class="userProfile">
                      <a class="profile" href="#" data-toggle="dropdown"  >
                        <?php
                        $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
                        $file_exi=$ruta;
                        if (file_exists($file_exi)) {
                            $pp=$file_exi;
                        } else {
                            $pp=$_SESSION['foto_default'];
                        }
                        ?>

                        <div class="photo">
                        <img src="<?php echo $pp;?>" style="height:60px; width:60px;" />

                       </div>
                       <div class="username">
                           <h5>Bienvenido,</h5>
                           <?= $_SESSION['prof_nomb']; ?> <?= $_SESSION['prof_apel']; ?> 
                       </div>

                   </a>
                   <ul class="dropdown-menu" role="menu" >
                     <li><a href="admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
                     <li><a href="admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
                     <li><a href="admin_info.php"> <span class="li_user">Ver Información</span></a></li>
                     <li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>
                 </ul>
             </li>

             <li class="userButtons">
               <ul>
                <li>

                 <div id="mens_alert" >
                     <?php include ('script_mens_view.php'); ?>
                 </div>



             </li>
         </ul>
     </li>
 </ul>

</div>
</div>
				

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
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
        <div class="title">
            <h3>
				<?
				if (!isset($_POST['label']))
				{	print '<span class="icon-briefcase icon"></span>';
					print 'INGRESO DE NOTAS';
				}
				else
				{	print '<span class="'.$_POST['icon'].'"></span>';
					print $_POST['label'];
				}
				?>
            </h3>
        </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script src="js/notasv2.js">
                        </script>
                    	<div  id="notas_view">
						<?
						switch ($opc)
						{	case 'upload_view':
						?>
						<form id="upload_view" action="" enctype="multipart/form-data" method="POST"  onsubmit="return upload_excel();">
							<table class="table_striped">
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
										<button class="btn btn-primary">
											<span class="icon-file-excel icon"></span> Subir Excel
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
								$target_path = $target_path . $curs_para_mate_prof_codi . "_" . $peri_dist_codi . ".xlsx"; 
								if(!move_uploaded_file($_FILES['file_notas']['tmp_name'], $target_path)) 
								{	echo "Ha ocurrido un error, trate de nuevo!";
								}
								else
								{	/*Cargar archivo en memoria*/
									echo "1: ".file_exists($target_path);
									echo "2: ".mime_content_type($target_path);
									if (file_exists($target_path) and mime_content_type($target_path)=="application/vnd.ms-excel")
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
											if ($curs_para_mate_prof_codi_xls!=$curs_para_mate_prof_codi_xls or $peri_dist_codi_xls!=$peri_dist_codi)
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
													$valor_nota = str_replace(",",".",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue());
													$nota_in = ($valor_nota==""?0:$valor_nota);
													if ($mate_tipo<>"C")
													{	$index		= multidimensional_search($arr_nota_cual, array('nota_peri_cual_refe'=>$nota_in));
														$nota_in	= $arr_nota_cual[$index]["nota_peri_cual_fin"];
													}
													
													$nota->setAttribute("c",$nota_in);
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
													
													$tbl_notas='<table class="table_striped">';
													$tbl_notas.='<thead>';
													$tbl_notas.="<tr>";
													$tbl_notas.='<th>N°</th>';
													$tbl_notas.='<th>ALUMNOS</th>';
													
													/*Cabecera de notas*/
													while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))
													{	$cc +=1;
														$tbl_notas.='<th>'.$row_peri_dist_padr_view['peri_dist_abre'].'</th>';
													}
													$tbl_notas.="</tr>";
													$tbl_notas.='</thead>';
													$tbl_notas.='<tbody>';
													$cc =0;
													
													/*Detalle de notas*/
													while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view))
													{	$cc +=1;
														$tbl_notas.="<tr>";
														$tbl_notas.='<td> '.$cc.'</td>';
														$tbl_notas.='<td> '.$row_curs_para_nota_peri_dist_view['alum_codi']." - ".$row_curs_para_nota_peri_dist_view['alum_apel']." ".$row_curs_para_nota_peri_dist_view['alum_nomb']."</td>";
														$CC_COLUM_index =0;
														while($CC_COLUM_index < $CC_COLUM )
														{	if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
															{	$tbl_notas.='<td>'.truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10])."</td>";
															}
															else
															{	$tbl_notas.='<td>'.nota_peri_cual_cons ($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_cod'],$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]).'</td>';
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
														<script type="text/javascript" src="js/actualizar_prom.js"></script>
														<button 
															class="btn btn-primary" 
															style="margin: 40px 10px; width: 20%;" 
															data-toggle="modal" 
															data-target="#ModalProgActualizacion" 
															onclick="actualizarProm(<?= $nota_perm_codi?>,<?= $curs_para_mate_prof_codi?>,<?= $peri_dist_codi ?>,<?= $es_hija ?>,'Iniciando proceso de actualización de notas...',1);">
															Guardar
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
								<button class="btn btn-primary" style="margin: 40px 10px; width: 15%;">Guardar Mat. Principal</button>
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
					
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<script type="text/javascript" language="javascript">
function ejecutar_submit(frm){
	document.getElementById(frm).submit();
}
</script><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>