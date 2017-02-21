<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=102;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->	
						<div class="title">
							<h3><span class="icon-users icon"></span>Alumnos</h3>
						</div> 
						<div class="options" style="display: block; float: left; width: 100%; height: 50px;">
						<? if (permiso_activo(514)){?>
							<ul style="display: block; float: left;">
								<li>
									<a class="button_text" href="motivo_bloqueo_main.php" title="">
									<span class="icon-lock icon"></span> Motivos Bloqueos
									</a>
								</li>
							</ul>
						<?}?>
						</div>
						<div>
							<table border="0" width="100%" style="margin: 10px 0;background-color: #ffffff">
								<tr>
									<td width="10%" style="padding: 15px 0 0 5px;"><label>Código</label></td>
									<td width="40%" style="padding: 15px 0 0 0;"><label>Apellidos</label></td>
									<td width="40%" style="padding: 15px 0 0 0;"><label>Curso</label></td>
									<td width="10%" style="padding: 15px 0 0 0;"><label></label></td>
								</tr>
								<tr>
									<td width="10%" style="padding: 0 0 15px 5px;"><input id="alum_codi_in" maxlength="15" type="text" style="width:90%;background-color: #ffffff"/></td>
									<td width="40%" style="padding: 0 0 15px 0;"><input id="alum_apel_in" maxlength="50" type="text" style="width:90%;background-color: #ffffff"/></td>
									<td width="40%" style="padding: 0 0 15px 0;">
									<select id="curs_para_codi_in" style="width:90%;background-color: #ffffff"/>
									<option value="0">Todos</option>
									<?
									$sql	= "{call curs_para_view (?)}";
									$params	= array($_SESSION["peri_codi"]);
									$stmt	= sqlsrv_query($conn,$sql,$params);
									while ($row = sqlsrv_fetch_array($stmt))
									{
										?>
										<option value="<?= $row["curs_para_codi"]?>"><?= $row["curs_deta"]." (".$row["para_deta"].")"?></option>
										<?
									}
									?>
									</td>
									<td width="10%" style="padding: 0 0 15px 0;"><button class="btn-btn-primary" style="width:90%;" onclick="BuscarAlumnos(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value,document.getElementById('curs_para_codi_in').value);">Buscar</button></td>
								</tr>
							</table>
						</div>
						<!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
					
					<div id="alum_main">
					
					</div>	
					<div class="modal fade" 
						 id="ModalCambiarCurso" 
						 tabindex="-1" 
						 role="dialog" 
						 aria-labelledby="myModalLabel" 
						 aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Cambiar de Curso</h4>
								</div>
								<div class="modal-body">
									<div id="div_documentos">
										<div class="form_element">
											<table width="100%" cellspacing="0" cellpadding="0" border="0">
												<tr>
													<td width="25%" style="padding-top: 15px">
														<b>Estudiante:</b>
													</td>
													<td style="padding-top: 15px">
														<div id="estudiante_info"></div>
													</td>
												</tr>
												<tr>
													<td width="25%" style="padding-top: 15px">
														<b>Curso Actual:</b>
													</td>
													<td style="padding-top: 15px">
														<div id="curso_actual"></div>
													</td>
												</tr>
												<tr>
													<td width="25%" style="padding-top: 15px">
														<b>Cambiar a:</b>
													</td>
													<td style="padding-top: 15px">
														<?
														$sql	= "{call curs_para_view (?)}";
														$params	= array($_SESSION["peri_codi"]);
														$stmt	= sqlsrv_query($conn,$sql,$params);
														?>
														<select style="width:80%" id="cmb_curs_para">
														<?
														while ($row	= sqlsrv_fetch_array($stmt))
														{	
														?>
															<option value="<?= $row["curs_para_codi"]?>"><?= $row["curs_deta"]." / ".$row["para_deta"]?></option>
														<?
														}
														?>
														</select>
													</td>
												</tr>
											</table>
										</div>
										<div class="form_element">&nbsp;</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type='button' class='btn btn-success' onclick="alum_change_course(document.getElementById('cmb_curs_para').value,document.getElementById('alum_curs_para_codi').value)">Cambiar</button>
									<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" 
						 id="ModalDocumentos" 
						 tabindex="-1" 
						 role="dialog" 
						 aria-labelledby="myModalLabel" 
						 aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Documentos</h4>
								</div>
								<div class="modal-body">
									<div id="div_documentos">
										<div class="form_element">
											<table width="100%" cellspacing="0" cellpadding="0" border="0">
												<tr>
													<td width="75%" style="padding-top: 15px">
														Convenio de matrícula <b>(El alumno debe estar registrado en un curso)</b>
														<input type="hidden" id="alum_curs_para_codi" value="" />
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/contrato_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
															Descargar
														</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Pagaré <b>(El alumno debe estar registrado en un curso)</b>
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/pagare_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">Descargar</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Solicitud de matrícula <b>(El alumno debe estar registrado en un curso)</b>
														<input type="hidden" id="alum_codi" value="" />
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/soli_matr_<?= $_SESSION['directorio'] ?>_pdf.php?alum_codi='+document.getElementById('alum_codi').value,'_blank')">Descargar</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Ficha de datos <b>(El alumno debe estar registrado en un curso)</b>
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/ficha_estudiantil_pdf.php?alum_codi='+document.getElementById('alum_codi').value,'_blank')">Descargar</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Ficha de matrícula <b>(El alumno debe estar registrado en un curso)</b>
													</td>
													<td style="padding-top: 15px">
														<?php 
															if($_SESSION['directorio']=='liceopanamericano' or $_SESSION['directorio']=='liceopanamericanosur'){

														?>
														<a onclick="window.open('reportes_generales/ficha_matricula_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">Descargar</a>
														<?php 
														}else{
														?>
														<a onclick="window.open('reportes_generales/ficha_matricula_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">Descargar</a>
														<?php
															}
														?>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Carta de compromiso <b>(El alumno debe estar registrado en un curso)</b>
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/carta_compromiso_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">Descargar</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Autorización de fotos <b>(El alumno debe estar registrado en un curso)</b>
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/autorizacion_fotos_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">Descargar</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Compromiso de rendimiento académico <b>(El alumno debe estar registrado en un curso)</b>
														<input type="hidden" id="alum_curs_para_codi" value="" />
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/compromiso_rendimiento_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
															Descargar
														</a>
													</td>
												</tr>
												<tr>
													<td width="75%" style="padding-top: 15px">
														Compromiso de comportamiento <b>(El alumno debe estar registrado en un curso)</b>
														<input type="hidden" id="alum_curs_para_codi" value="" />
													</td>
													<td style="padding-top: 15px">
														<a onclick="window.open('reportes_generales/compromiso_comportamiento_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
															Descargar
														</a>
													</td>
												</tr>
											</table>
										</div>
										<div class="form_element">&nbsp;</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="ModalMatri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="ModalMatri_title">Estados de:</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_matri">
										<input type="hidden" id="alum_codi" name="alum_codi" value="">
										<input type="hidden" id="adm_est_alum_est_codi" name="adm_est_alum_est_codi" value="">
										<input type="hidden" id="adm_est_alum_est_det" name="adm_est_alum_est_det" value="">
										<input type="hidden" id="adm_est_curs_para_codi" name="adm_est_curs_para_codi" value="">
										<input type="hidden" id="adm_est_alum_curs_para_codi" name="adm_est_alum_curs_para_codi" value="">
										<table width='100%' align='center'>
											<tr>
												<td colspan='2' width='120px'>
													<div id='div_periodo_previo'>&nbsp;</div>
												</td>
											</tr>
											<tr>
												<td colspan='2' width='120px' height='40px' valign='bottom'><b>Datos del Per&iacute;odo activo</b>
												</td>
											</tr>
											<tr>
												<td width='120px' height='1px' colspan='2'>
													<div style='font-size:1px'>
														<hr style='height:1px; margin-top: 0.5em;' />
													</div>
												</td>
											</tr>
											<tr>
												<td width='120px'><?php echo show_this_phrase(20000005);?>:
												</td>
												<td>
													<?
														$sql_peri="{call peri_0()}";
														$peri_busq = sqlsrv_query($conn, $sql_peri);
													?>
													<select id="peri_0" name="peri_0" 
															onchange="document.getElementById('div_curs').innerHTML ='&nbsp;';
																	  document.getElementById('div_alumno_estado_periodo').innerHTML ='&nbsp;';
																	  load_ajax_si_valor_es_igual(document.getElementById('adm_est_alum_est_det').value, 'Matriculado Por Pagar', 'div_checks','alumno_estado_detalle.php','div_alumno_estado_periodo', 'alumnos_main_estado_combo.php',
																			'peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=' + document.getElementById('adm_est_alum_est_det').value + '&alum_codi=' + document.getElementById('alum_codi').value + '&peri_tipo=R');"
															disabled='disabled'
															class="select"
															style="background-color: #ededed">
													<? while($row_peri_bus= sqlsrv_fetch_array($peri_busq))
													{?>
														<option value="<?= $row_peri_bus['peri_codi'];?>" <? echo $_SESSION['peri_codi']==$row_peri_bus['peri_codi']? "selected":"";?>><?= $row_peri_bus['peri_deta'];?></option>
													<? 
													}?>
													</select>
												</td>
											</tr>
											<tr>
												<td width='120px' valign='top'><br/>
													<?php echo PrimeraMayuscula(lng_forms('current state'));?>:
												</td>
												<td><br/>
													<b><div id="div_adm_est_alum_curs_para_codi"></div></b>
													<div id="div_cambiar_estado"></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div id="div_alumno_estado_periodo"  style='width:100%'></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div id="div_curs" style='width:100%'></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div id="div_blacklist_view" style='width:100%'></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div id="div_bloqueos_view" style='width:100%'></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div id="div_checks"  style='width:100%'></div>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<div class='form_element' style='height:20px'></div>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div id='ModalMatri_footer' class="modal-footer">
									<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo PrimeraMayuscula(lng_options('close'));?></button>
								</div>
							</div>
						</div>
					</div>
					
					<div	class="modal fade" 
                            id="ModalAlumBloqAdd" 
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
									<h4 class="modal-title" id="myModalLabel">Bloqueo</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_docu_nuev"> 
										<table width="100%" style="margin-bottom:20px">
											<tr>
												<td width="30%">
													Motivo
												</td>
												<td style="margin-top:5px">
													<select id="cmb_motivos" style="width: 75%">
													<?
													$sql	= "{call moti_bloq_all()}";
													$params	= array();
													$stmt	= sqlsrv_query($conn,$sql,$params);
													if ($stmt === false)
													{	die(print_r(sqlsrv_errors(),true));
													}
													while ($row = sqlsrv_fetch_array($stmt))
													{	echo "<option value='".$row["moti_bloq_codi"]."'>".$row["moti_bloq_deta"]."</option>";
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td width="30%">
													Opción a bloquear
												</td>
												<td style="padding-top:5px">
													<select id="cmb_opciones" style="width: 75%">
													<?
													$sql	= "{call opci_all()}";
													$params	= array();
													$stmt	= sqlsrv_query($conn,$sql,$params);
													if ($stmt === false)
													{	die(print_r(sqlsrv_errors(),true));
													}
													while ($row = sqlsrv_fetch_array($stmt))
													{	echo "<option value='".$row["opci_codi"]."'>".$row["opci_deta"]."</option>";
													}
													?>
													</select>
													<input id="alum_bloq_codi" type="hidden" value="" />
												</td>
											</tr>
											<tr>
												<td width="30%">
												</td>
												<td style="padding-top:5px">
												<? if (permiso_activo(519)){?>
													<button class="btn" onclick="alum_bloq_moti_opci_add('div_bloqueos',document.getElementById('alum_bloq_codi').value,'alum_moti_bloq_opci_view')"><span class="icon-add icon"></span> Agregar</button>
												<?}?>
												</td>
											</tr>
										</table>
										<div id="div_bloqueos">
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
					<div	class="modal fade" 
                            id="ModalBlacklistAdd" 
                            tabindex="-1" 
                            role="dialog" 
                            aria-labelledby="myModalLabel" 
                            aria-hidden="true">
						<div class="modal-dialog">
							<div id="modal_main_blacklist" class="modal-content">
								
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
    
    <!-- Modal SELECCION DE PERIODO -->
    <div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
          </div>
          <div class="modal-body">
           
                <table>
                    <tr>
                        <td>PERIODOS</td>                        
                        
                    </tr>
                            
                     <? 	
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    
                     <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
                     <tr>    
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
                    </tr>
                    <?php  } ?>


                     
                   
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>