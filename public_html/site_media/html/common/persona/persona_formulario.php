<!-- Modal Enviar-->
<div class="modal fade" id="modal_enviar_solicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="myModalLabel">Enviar solicitud</h4>
			</div>
			<div class="modal-body">
				<div id="modal_enviar_solicitud_body" class='grid'>
					<div class='row'>
						<div class="col-sm-12">
							<div class='alert alert-info fade in' style='font-size:small;'>
								<table width='100%'>
									<tr class='row'><td style='vertical-align:top' colspan='2'><b>Datos generales de su solicitud</b></td></tr>
									<tr class='row'><td style='vertical-align:top' colspan='2'><hr style="padding:3px;margin:0px;"></td></tr>
									<tr class='row'><td style='vertical-align:top'><b>ID. Solicitud: </b></td><td><label id='send_id' name='send_id'></label></td></tr>
									<tr class='row'><td style='vertical-align:top'><b>Estado actual: </b></td><td><label id='send_ea' name='send_ea'></label></td></tr>
									<tr class='row'><td style='vertical-align:top'><b>Documentos requeridos: </b></td><td><label id='send_dr' name='send_dr'></label></td></tr>
									<tr class='row'><td style='vertical-align:top'><b>Documentos subidos: </b></td><td><label id='send_ds' name='send_ds'></label></td></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" 
					onclick="js_enviarSolicitud_enviar_followed('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
					<i class="fa fa-send"></i>&nbsp;Enviar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Enviar-->
<!-- Modal datos representante-->
<div class="modal fade" id="modal_add_repr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#modal_add_repr').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario de datos representante</h4>
      </div>
      <div class="modal-body" id="modal_add_repr_body">
		...
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- Modal datos representante-->
<form id="formulario_preadmision" name="formulario_preadmision" 
	  onsubmit="return validaAdd('resultado','{ruta_html_admisiones}/enviarSolicitud/controller.php')" novalidate>
	<input name="event"				id="evento"				type="hidden" value="subir_archivo"/>
	<input name="hd_id_solicitud" 	id="hd_id_solicitud"	type="hidden" value="{id_solicitud}"/>
	<input name="hd_per_codi" 		id="hd_per_codi"		type="hidden" value="{per_codi}"/>
	<input name="hd_soli_estado" 	id="hd_soli_estado"		type="hidden" value="{soli_estado}"/>
	<input name="hd_num_doc" 		id="hd_num_doc"			type="hidden" value="{num_docu}"/>
	<input name="hd_where_from" 	id="hd_where_from"		type="hidden" value="{where_from}"/>
<!--<input name="hd_num_doc_up" 	id="hd_num_doc_up"		type="hidden" value="{num_docu_up}"/> -->
		<!-- "hd_where_from" indicia si es consulta de una bandeja administrativa, o de una solicitud web. -->
		<!-- "hd_num_doc_up" carga junto a los documentos. -->
	<div id="div_formulario_solicitud_inside">
		<div class="row">
			<div class="col-md-12">
				<!-- Custom Tabs (Pulled to the right) -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li id='li_5' {list_enviar_display}><a href="#"><i class="fa fa-send"></i><span class="hidden-xs hidden-sm"> ENVIAR SOLICITUD</span></a></li>
						<li id='li_4'><a href="#" onclick="return js_docAdmin_get_documentos_periodo_actual('div_documentos_admisiones', '{ruta_html_admisiones}/documentos_admision/controller.php');"><i class="fa fa-file"></i><span class="hidden-xs hidden-sm"> DOCUMENTOS</span></a></li>
						<li id='li_3'><a href="#" onclick="return js_representantes_get_representantes(document.getElementById('hd_per_codi').value, 'div_representantes_principales', '{ruta_html_common}/representantes/controller.php', 'off');"><i class="fa fa-black-tie"></i><span class="hidden-xs hidden-sm"> REPR. PRINCIPALES</span></a></li>
						<li id='li_2'><a href="#"><i class="fa fa-group"></i><span class="hidden-xs hidden-sm"> REPRESENTANTE</span></a></li>
						<li id='li_1' class="active"><a href="#" ><i class="fa fa-user"></i><span class="hidden-xs hidden-sm"> DATOS PERSONALES DEL POSTULANTE</span></a></li>
						<li class="pull-left header"><i class="fa fa-th"></i> Formulario de solicitud</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<h4 class="box-title"><span class="hidden-xs">FORMULARIO DE PREADMISIÓN</span> -PARTE 1- DATOS PERSONALES DEL POSTULANTE</h4>
							<table cellspacing="0" cellpadding="0" class="table table-condensed table-responsive table-bordered">  
								<tbody>
									<tr class='row'>
										<td colspan="17">
											<a class="btn btn-app" 
												onclick="js_enviarSolicitud_guarda_formulario('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
												<i class="fa fa-save"></i> Guardar
											</a>
											<a id="btn_tab_1_back" name="btn_tab_1_back" disabled='disabled' readonly='readonly' class="btn btn-app">
												<i class="fa fa-arrow-circle-o-left"></i> Atrás
											</a>
											<a id="btn_tab_1_next" name="btn_tab_1_next" href="#tab_2" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_1').removeClass('active');
														 $('#li_2').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');">
												<i class="fa fa-arrow-circle-o-right"></i> Siguiente
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="grid">
								<div class="panel box box-success">
									<div class="box-header with-border">
										<h4 class="box-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapsePostulante">
											DATOS DEL POSTULANTE
											</a>
										</h4>
									</div>
									<div id="collapsePostulante" class="panel-collapse collapse in">
										<div id="div_per_postulante" name="div_per_postulante" class="box-body">
											<div class='grid'>  
												<div> 
													<div class='row'>
														<div class="col-sm-6">
															{cmb_per_tipo_identificacion}
														</div>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="per_numero_identificacion" id="per_numero_identificacion"  required="required" value="{per_numero_identificacion}"
																	placeholder="No. de identificaci&oacute;n" pattern="[a-zA-Z0-9]+"
																	maxlength="20" />
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<input name="" id="per_nomb"  type="per_nomb" class="form-control" value="{per_nomb}" placeholder="Nombre" 
																pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
														</div>
														<div class="col-sm-6"><input name="" id="per_nomb_seg"  type="per_nomb_seg" class="form-control" value="{per_nomb_seg}" placeholder="Segundo nombre" 
																pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/></div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<input name="per_apel" id="per_apel"  type="text" class="form-control" value="{per_apel}" placeholder="Apellido paterno" 
																pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
														</div>
														<div class="col-sm-6">
															<input name="per_apel_mat" id="per_apel_mat"  type="text" class="form-control" value="{per_apel_mat}" placeholder="Apellido materno" 
																pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<input type="radio" id="per_rdb_genero" name="per_rdb_genero" value="M" {per_genero_m}> Masculino 
															<input type="radio" id="per_rdb_genero" name="per_rdb_genero" value="F" {per_genero_f}> Femenino
														</div>
														<div class="col-sm-6">
															<input name="per_email_personal" id="per_email_personal"  type="text" class="form-control" 
																value="{per_email_personal}" 
																pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
																maxlength="200"placeholder="Correo electrónico personal"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<label>DIRECCIÓN Y TELÉFONO DE DOMICILIO</label>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-7">
															<input name="per_dir" id="per_dir" type="text" class="form-control" value="{per_dir}" placeholder="Dirección" maxlength="150"/>
														</div>
														<div class="col-sm-5">
															<input name="per_telf" id="per_telf" type="text" class="form-control" value="{per_telf}" placeholder="Teléfono"
																pattern='[0-9]+' maxlength="25"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<label>FECHA Y LUGAR DE NACIMIENTO</label>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-2">
															<label>Fecha de nacimiento </label>
															<input name="per_fecha_nac" id="per_fecha_nac" type="date" value="{per_fecha_nac}" class="form-control"/>
														</div>
														<div class="col-sm-4">
															<label>Pais</label>
															{cmb_pais_per_lugar_nac}
														</div>
														<div class="col-sm-3">
															<label>Provincia/Estado</label>
															<div id='div_provincia_per_lugar_nac' name='div_provincia_per_lugar_nac'>{cmb_provincia_per_lugar_nac}</div>
														</div>
														<div class="col-sm-3">
															<label>Ciudad</label>
															<div id='div_ciudad_per_lugar_nac' name='div_ciudad_per_lugar_nac'>{cmb_ciudad_per_lugar_nac}</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<label>CURSO AL QUE APLICA</label>
															{cmb_curso_aplica}
														</div>
														<div class="col-sm-6">
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<label>COLEGIO DE PROCEDENCIA (Seleccione la ciudad para ver el colegio) </label>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-5">
															<label>Pais</label>
															{cmb_pais_colegio_anterior}
														</div>
														<div class="col-sm-6">
															<label>Provincia/Estado</label>
															<div id='div_provincia_colegio_anterior' name='div_provincia_colegio_anterior'>{cmb_provincia_colegio_anterior}</div>
														</div>
														<div class="col-sm-6">
															<label>Ciudad</label>
															<div id='div_ciudad_colegio_anterior' name='div_ciudad_colegio_anterior'>{cmb_ciudad_colegio_anterior}</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<label>Colegio</label>
															<div id='div_colegio_anterior' name='div_colegio_anterior'>{cmb_colegio_anterior}</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-4">
															<div class="checkbox">
																<label>
																	<input type="checkbox" id="ckb_colegio_no_encontrado" name="ckb_colegio_no_encontrado"
																		onchange="js_enviarSolicitud_colegio_no_encontrado(this.checked);" {checked_colegio_no_encontrado}>
																		¡No encontré mi colegio!
																</label>
															</div>
														</div>
														<div class="col-sm-8">
															<input style='display:block' name="per_col_anterior" id="per_col_anterior" {per_col_anterior_disabled} type="text" class="form-control" value="{per_col_anterior}" 
																placeholder="Escriba el nombre del colegio de procedencia aqu&iacute;"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<input name="per_col_anterior_dir" id="per_col_anterior_dir"  type="text" class="form-control" value="{per_col_anterior_dir}" 
																placeholder="Dirección del Colegio de Procedencia (opcional)"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<textarea id='per_num_hermanos' name='per_num_hermanos' class="form-control" 
																placeholder="N° DE HERMANOS (Indicar edad y actividades/estudios que realizan)">{per_num_hermanos}</textarea>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<p>&nbsp;</p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<div class="checkbox">
																<label>
																	<input type="checkbox" id="ckb_tiene_hermanos_en_colegio" name="ckb_tiene_hermanos_en_colegio"
																		onchange="js_enviarSolicitud_tiene_hermanos_en_colegio(this.checked);" {checked_tiene_hermanos_en_colegio}>
																		¿Tiene el postulante hermanos (medio hermano, hermanastro) en el Colegio Americano?
																</label>
															</div>
														</div>
														<div class="col-sm-6">
															<p><textarea id='per_tiene_hermanos_en_colegio' name='per_tiene_hermanos_en_colegio' class="form-control" 
																style='display:block;' {per_hermanos_cole_disabled} placeholder="Nombre de los hermanos que estudian en la Institución">{per_tiene_hermanos_en_colegio}</textarea></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<input name="per_con_quien_vive" id="per_con_quien_vive"  type="text" class="form-control" value="{per_con_quien_vive}" placeholder="¿Con quién vive el aspirante?"/>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-6">
															<div class="checkbox">
																<label>
																	<input type="checkbox" id="ckb_preadmision_anterior" name="ckb_preadmision_anterior"
																		onchange="js_enviarSolicitud_preadmision_anterior(this.checked);" {checked_relizo_proceso_previamente}>
																		¿El aspirante realizó proceso de pre-admisión anteriormente?
																</label>
															</div>
														</div>
														<div class="col-sm-6">
															{cmb_per_preadmision_anterior}
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<div class="checkbox">
																<label>
																	<input type="checkbox" id="ckb_matriculado_anteriormente" name="ckb_matriculado_anteriormente"
																		onchange="" {checked_ha_sido_alumno_antes}>
																		¿El aspirante ha sido alumno del Colegio Americano antes?
																</label>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12">
															<label>Vivienda y tiempo de residencia (Si es menos de un año, seleccione '0')</label>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-4">
															<select class="form-control" id='per_vive_casa' name='per_vive_casa'>
																<option {per_vive_casa_propia} value="PROPIA">Casa propia</option>
																<option {per_vive_casa_alquilada} value="ALQUILADA">Casa alquilada</option>
																<option {per_vive_casa_otros} value="OTROS">Otros</option>
															</select> 
														</div>
														<div class="col-sm-8">
															<input name="per_tiempo_residencia" id="per_tiempo_residencia"  
																type="number" class="form-control" value="{per_tiempo_residencia}" min='0'
																placeholder="Tiempo de residencia (años)"/></div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<br>
														</div>
													</div>
													<div class='row'>
														<div class="col-sm-12"><label>¿Cómo se enteró que el Colegio Americano había iniciado el proceso de pre-admisión? </label>
														<textarea id='per_como_se_entero' name='per_como_se_entero' class="form-control" 
															placeholder="Indique como se enteró del proceso de pre-admisión del Colegio Americano">{per_como_se_entero}</textarea> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="grid">
									<div class="row">
										<div class="col-md-12" style='text-align:center;'>
											<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 pull-left">
											<a class="btn btn-app"
												onclick="js_enviarSolicitud_guarda_formulario('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
												<i class="fa fa-save"></i> Guardar
											</a>
											<a id="btn_tab_1_back_button" name="btn_tab_1_back_button" disabled='disabled' readonly='readonly' class="btn btn-app">
												<i class="fa fa-arrow-circle-o-left"></i> Atrás
											</a>
											<a id="btn_tab_1_next_button" name="btn_tab_1_next_button" href="#tab_2" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_1').removeClass('active');
														 $('#li_2').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');">
												<i class="fa fa-arrow-circle-o-right"></i> Siguiente
											</a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<h4 class="box-title">FORMULARIO DE PREADMISIÓN </span>-PARTE 2- DATOS DEL REPRESENTANTE/GUARDI&Aacute;N</h4>
							<table cellspacing="0" cellpadding="0" class="table table-condensed table-responsive table-bordered">  
								<tbody>
									<tr class='row'>
										<td colspan="17">
											<a class="btn btn-app"
													onclick="js_enviarSolicitud_guarda_formulario('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
												<i class="fa fa-save"></i> Guardar
											</a>
											<!--<a class="btn btn-app">
												<i class="fa fa-eraser"></i> Borrar
											</a>-->
											<a id="btn_tab_2_back" name="btn_tab_2_back" href="#tab_1" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_2').removeClass('active');
														 $('#li_1').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');">
												<i class="fa fa-arrow-circle-o-left"></i> Atrás
											</a>
											<a id="btn_tab_2_next" name="btn_tab_2_next" href="#tab_3" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_2').removeClass('active');
														 $('#li_3').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');
														 js_representantes_get_representantes(document.getElementById('hd_per_codi').value, 'div_representantes_principales', '{ruta_html_common}/representantes/controller.php', 'off');">
												<i class="fa fa-arrow-circle-o-right"></i> Siguiente
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="grid">
								<div class="box-body">
									<!-- si se buscar poder 'mantener abierto' los tres acordiones al mismo tiempo, quitar el box-body y el box-group. -->
									<div class="box-group" id="accordion">
										<!-- se añade la clase 'panel' para que bootstrap.js lo detecte -->
										<div class="panel box box-primary">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													DATOS DEL PADRE
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in">
												<div id="div_repr_padre" name="div_repr_padre" class="box-body">
													<input type="hidden" name="repr1_codi" id="repr1_codi" value="{repr1_codi}" />
													<input type="hidden" name="repr1_empr_codi" id="repr1_empr_codi" value="{repr1_empr_codi}" />
													<input type="hidden" name="repr1_per_empr_codi" id="repr1_per_empr_codi" value="{repr1_per_empr_codi}" />
													<div class='grid'>
														<div>
															<div class='row'>
																<div class="col-sm-6">
																	{cmb_repr1_tipo_identificacion}
																</div>
																<div class="col-sm-6">
																	<input type="text" class="form-control" name="repr1_numero_identificacion" id="repr1_numero_identificacion"  required="required" value="{repr1_numero_identificacion}"
																			placeholder="No. de identificaci&oacute;n" pattern="[a-zA-Z0-9]+"
																			maxlength="20" />
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-6">
																	<input name="repr1_nomb" id="repr1_nomb"  type="text" class="form-control" value="{repr1_nomb}" placeholder="Nombre" 
																		pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
																</div>
																<div class="col-sm-6"><input name="repr1_nomb_seg" id="repr1_nomb_seg"  type="text" class="form-control" value="{repr1_nomb_seg}" placeholder="Segundo nombre" 
																		pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/></div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-6">
																	<input name="repr1_apel" id="repr1_apel"  type="text" class="form-control" value="{repr1_apel}" placeholder="Apellido paterno" 
																		pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
																</div>
																<div class="col-sm-6">
																	<input name="repr1_apel_mat" id="repr1_apel_mat"  type="text" class="form-control" value="{repr1_apel_mat}" placeholder="Apellido materno" 
																		pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<label>DIRECCIÓN Y TELÉFONO DE DOMICILIO </label>
																	<div class="checkbox" style='display:inline;'>
																		<label>
																			<input type="checkbox" id="ckb_repr1_per_dir_igual" name="ckb_repr1_per_dir_igual"
																				onchange="js_enviarSolicitud_direccion_igual_a_postulante(this);">
																				(Hacer clic aquí si es igual al del postulante)
																		</label>
																	</div>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-7">
																	<input name="repr1_dir" id="repr1_dir" type="text" class="form-control" value="{repr1_dir}" placeholder="Dirección" maxlength="150"/>
																</div>
																<div class="col-sm-5">
																	<input name="repr1_telf" id="repr1_telf" type="text" class="form-control" value="{repr1_telf}" placeholder="Teléfono"
																		pattern='[0-9]+' maxlength="25"/>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-7"></div>
																<div class="col-sm-5">
																	<input name="repr1_email_personal" id="repr1_email_personal"  type="text" class="form-control" value="{repr1_email_personal}" 
																		pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
																		maxlength="200"placeholder="Correo electrónico personal"/>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<label>FECHA Y LUGAR DE NACIMIENTO</label>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-2">
																	<label>Fecha de nacimiento </label>
																	<input name="repr1_fecha_nac" id="repr1_fecha_nac"  type="date" class="form-control" value="{repr1_fecha_nac}" placeholder="Fec. Nacimiento"/>
																</div>
																<div class="col-sm-4">
																	<label>Pais</label>
																	{cmb_pais_repr1_lugar_nac}
																</div>
																<div class="col-sm-3">
																	<label>Provincia/Estado</label>
																	<div id='div_provincia_repr1_lugar_nac' name='div_provincia_repr1_lugar_nac'>{cmb_provincia_repr1_lugar_nac}</div>
																</div>
																<div class="col-sm-3">
																	<label>Ciudad</label>
																	<div id='div_ciudad_repr1_lugar_nac' name='div_ciudad_repr1_lugar_nac'>{cmb_ciudad_repr1_lugar_nac}</div>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-5"><label>Estado civil</label>{cmb_estado_civil_repr1}</div>
																<div class="col-sm-7"><label>Título</label>{cmb_profesion_repr1}</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<label>DATOS LABORALES</label>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-7"><input name="repr1_empr_nomb" id="repr1_empr_nomb"  type="text" class="form-control" value="{repr1_empr_nomb}" placeholder="Empresa donde Trabaja (Razón Social)"/></div>
																<div class="col-sm-5"><input name="repr1_empr_ruc" id="repr1_empr_ruc"
																	type="text" class="form-control" value="{repr1_empr_ruc}"  
																	maxlength='13' 
																	placeholder="RUC" pattern="[0-9]*"/></div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12"><input name="repr1_empr_dir" id="repr1_empr_dir"  type="text" class="form-control" value="{repr1_empr_dir}" placeholder="Dirección de la Empresa"/></div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12"><input name="repr1_empr_cargo" id="repr1_empr_cargo"  type="text" class="form-control" value="{repr1_empr_cargo}" placeholder="Cargo que desempeña"/></div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-4">
																	<div class="input-group">
																		<span class="input-group-addon">$</span>
																		<input name="repr1_empr_ingreso_mensual" id="repr1_empr_ingreso_mensual"  type="number" min="0" class="form-control" 
																			value="{repr1_empr_ingreso_mensual}" placeholder="Ingreso mensual"/>
																	</div>
																</div>
																<div class="col-sm-4">
																	<input name="repr1_empr_telf" id="repr1_empr_telf"  type="text" class="form-control" value="{repr1_empr_telf}" 
																		placeholder="Teléfono"/>
																</div>
																<div class="col-sm-4">
																	<input name="repr1_empr_mail" id="repr1_empr_mail"  type="text" class="form-control" value="{repr1_empr_mail}" 
																		pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
																		maxlength="200"placeholder="Correo electrónico empresa"/>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-6">
																	<div class="checkbox" style='display:inline;'>
																		<label>
																			<input type="checkbox" id="ckb_repr1_es_exalumno" name="ckb_repr1_es_exalumno"
																				onchange="js_enviarSolicitud_es_exalumno(this);" {repr1_es_exalumno_check}>
																				¿Es ex-Alumno?
																		</label>
																	</div>
																</div>
																<div class="col-sm-6">
																	{repr1_cmb_es_exalumno}
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<br>
																</div>
															</div>
															<div class='row'>
																<div class="col-sm-12">
																	<div class="input-group" id="div_repr1_es_extrabajador" name="div_repr1_es_extrabajador" >
																		<span class="input-group-addon">
																			<input type="checkbox" id='ckb_repr1_es_extrabajador' name='ckb_repr1_es_extrabajador' 
																				onclick='js_enviarSolicitud_es_extrabajador(this);' 
																				{repr1_es_exworker_check}/>
																		</span>
																		<span class="input-group-addon">
																			<span style="text-align:left;font-size:small;font-weight:bold;">¿Ha trabajado antes en la institución?</span>
																		</span>				
																		<span class="input-group-addon">
																			<small>Inicio</small></span>
																		<input type="date" class="form-control" name="repr1_es_extrabajador_fecha_ini" id="repr1_es_extrabajador_fecha_ini" 
																			value="{repr1_es_extrabajador_fecha_ini}" placeholder="dd/mm/yyyy" required="required" {repr1_exworker_fini_disabled}>
																	
																		<span class="input-group-addon">
																			<small>Fin</small></span>
																		<input type="date" class="form-control" name="repr1_es_extrabajador_fecha_fin" id="repr1_es_extrabajador_fecha_fin" 
																			value="{repr1_es_extrabajador_fecha_fin}" placeholder="dd/mm/yyyy" required="required" {repr1_exworker_ffin_disabled}>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<div class="panel box box-warning">
										<div class="box-header with-border">
											<h4 class="box-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
												DATOS DE LA MADRE
												</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div id="div_repr_madre" name="div_repr_madre"  class="box-body">
												<input type="hidden" name="repr2_codi" id="repr2_codi" value="{repr2_codi}" />
												<input type="hidden" name="repr2_empr_codi" id="repr2_empr_codi" value="{repr2_empr_codi}" />
												<input type="hidden" name="repr2_per_empr_codi" id="repr2_per_empr_codi" value="{repr2_per_empr_codi}" />
												<div class='grid'>  
													<div>
														<div class='row'>
															<div class="col-sm-6">
																{cmb_repr2_tipo_identificacion}
															</div>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="repr2_numero_identificacion" id="repr2_numero_identificacion"  required="required" value="{repr2_numero_identificacion}"
																		placeholder="No. de identificaci&oacute;n" pattern="[a-zA-Z0-9]+"
																		maxlength="20" />
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-6">
																<input name="repr2_nomb" id="repr2_nomb"  type="text" class="form-control" value="{repr2_nomb}" placeholder="Nombre" 
																	pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
															</div>
															<div class="col-sm-6"><input name="repr2_nomb_seg" id="repr2_nomb_seg"  type="text" class="form-control" value="{repr2_nomb_seg}" placeholder="Segundo nombre" 
																	pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/></div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-6">
																<input name="repr2_apel" id="repr2_apel"  type="text" class="form-control" value="{repr2_apel}" placeholder="Apellido paterno" 
																	pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
															</div>
															<div class="col-sm-6">
																<input name="repr2_apel_mat" id="repr2_apel_mat"  type="text" class="form-control" value="{repr2_apel_mat}" placeholder="Apellido materno" 
																	pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<label>DIRECCIÓN Y TELÉFONO DE DOMICILIO </label>
																<div class="checkbox" style='display:inline;'>
																	<label>
																		<input type="checkbox" id="ckb_repr2_per_dir_igual" name="ckb_repr2_per_dir_igual"
																			onchange="js_enviarSolicitud_direccion_igual_a_postulante(this);">
																			(Hacer clic aquí si es igual al del postulante)
																	</label>
																</div>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-7">
																<input name="repr2_dir" id="repr2_dir" type="text" class="form-control" value="{repr2_dir}" placeholder="Dirección" maxlength="150"/>
															</div>
															<div class="col-sm-5">
																<input name="repr2_telf" id="repr2_telf" type="text" class="form-control" value="{repr2_telf}" placeholder="Teléfono"
																	pattern='[0-9]+' maxlength="25"/>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-7"></div>
															<div class="col-sm-5">
																<input name="repr2_email_personal" id="repr2_email_personal"  type="text" class="form-control" value="{repr2_email_personal}" 
																	pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
																	maxlength="200"placeholder="Correo electrónico personal"/>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<label>FECHA Y LUGAR DE NACIMIENTO</label>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-2">
																<label>Fecha de nacimiento </label>
																<input name="repr2_fecha_nac" id="repr2_fecha_nac"  type="date" class="form-control" value="{repr2_fecha_nac}" placeholder="Fec. Nacimiento"/>
															</div>
															<div class="col-sm-4">
																<label>Pais</label>
																{cmb_pais_repr2_lugar_nac}
															</div>
															<div class="col-sm-3">
																<label>Provincia/Estado</label>
																<div id='div_provincia_repr2_lugar_nac' name='div_provincia_repr2_lugar_nac'>{cmb_provincia_repr2_lugar_nac}</div>
															</div>
															<div class="col-sm-3">
																<label>Ciudad</label>
																<div id='div_ciudad_repr2_lugar_nac' name='div_ciudad_repr2_lugar_nac'>{cmb_ciudad_repr2_lugar_nac}</div>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-5"><label>Estado civil</label>{cmb_estado_civil_repr2}</div>
															<div class="col-sm-7"><label>Título</label>{cmb_profesion_repr2}</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<label>DATOS LABORALES</label>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-7"><input name="repr2_empr_nomb" id="repr2_empr_nomb"  type="text" class="form-control" value="{repr2_empr_nomb}" placeholder="Empresa donde Trabaja (Razón Social)"/></div>
															<div class="col-sm-5"><input name="repr2_empr_ruc" id="repr2_empr_ruc"  type="text" class="form-control" value="{repr2_empr_ruc}" maxlength='13' placeholder="RUC" pattern="[0-9]*"/></div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12"><input name="repr2_empr_dir" id="repr2_empr_dir"  type="text" class="form-control" value="{repr2_empr_dir}" placeholder="Dirección de la Empresa"/></div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12"><input name="repr2_empr_cargo" id="repr2_empr_cargo"  type="text" class="form-control" value="{repr2_empr_cargo}" placeholder="Cargo que desempeña"/></div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-4">
																<div class="input-group">
																	<span class="input-group-addon">$</span>
																	<input name="repr2_empr_ingreso_mensual" id="repr2_empr_ingreso_mensual"  type="number" min="0" class="form-control" 
																		value="{repr2_empr_ingreso_mensual}" placeholder="Ingreso mensual"/>
																</div>
															</div>
															<div class="col-sm-4">
																<input name="repr2_empr_telf" id="repr2_empr_telf"  type="text" class="form-control" value="{repr2_empr_telf}" 
																	placeholder="Teléfono"/>
															</div>
															<div class="col-sm-4">
																<input name="repr2_empr_mail" id="repr2_empr_mail"  type="text" class="form-control" value="{repr2_empr_mail}" 
																	pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
																	maxlength="200"placeholder="Correo electrónico empresa"/>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-6">
																<div class="checkbox" style='display:inline;'>
																	<label>
																		<input type="checkbox" id="ckb_repr2_es_exalumno" name="ckb_repr2_es_exalumno"
																			onchange="js_enviarSolicitud_es_exalumno(this);" {repr2_es_exalumno_check}>
																			¿Es ex-Alumno?
																	</label>
																</div>
															</div>
															<div class="col-sm-6">
																{repr2_cmb_es_exalumno}
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<br>
															</div>
														</div>
														<div class='row'>
															<div class="col-sm-12">
																<div class="input-group" id="div_repr2_es_extrabajador" name="div_repr2_es_extrabajador" >
																	<span class="input-group-addon">
																		<input type="checkbox" id='ckb_repr2_es_extrabajador' name='ckb_repr2_es_extrabajador' 
																			onclick='js_enviarSolicitud_es_extrabajador(this);' 
																			{repr2_es_exworker_check}/>
																	</span>
																	<span class="input-group-addon">
																		<span style="text-align:left;font-size:small;font-weight:bold;">¿Ha trabajado antes en el Colegio Americano?</span>
																	</span>				
																	<span class="input-group-addon">
																		<small>Inicio</small></span>
																	<input type="date" class="form-control" name="repr2_es_extrabajador_fecha_ini" id="repr2_es_extrabajador_fecha_ini" 
																		value="{repr2_es_extrabajador_fecha_ini}" placeholder="dd/mm/yyyy" required="required" {repr2_exworker_fini_disabled}>
																
																	<span class="input-group-addon">
																		<small>Fin</small></span>
																	<input type="date" class="form-control" name="repr2_es_extrabajador_fecha_fin" id="repr2_es_extrabajador_fecha_fin" 
																		value="{repr2_es_extrabajador_fecha_fin}" placeholder="dd/mm/yyyy" required="required" {repr2_exworker_ffin_disabled}>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel box box-danger">
										<div class="box-header with-border">
											<h4 class="box-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
													AGREGAR REPRESENTANTE/FAMILIAR
												</a>
											</h4>
										</div>
										<div id="collapseFive" class="panel-collapse collapse">
											<div class="box-body">
												<div class="grid">
													<div class="row">
														<div class="col-sm-2">
															Si desea que el <b>Representante econ&oacute;mico o académico</b> sea otro que no sea padre o madre, 
															debe ingresar los datos también.
														</div>
														<div class="col-sm-4">
															<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add_repr' 
																onclick="js_enviarSolicitud_add_repr('{ruta_html_admisiones}/enviarSolicitud/controller.php')">
																<i class='fa fa-user'></i>&nbsp;<i class='fa fa-plus'></i></button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_3">
							<h4 class="box-title">REPR. PRINCIPALES</h4>
							<table cellspacing="0" cellpadding="0" class="table table-condensed table-responsive table-bordered">  
								<tbody>
									<tr class='row'>
										<td colspan="17">
											<a class="btn btn-app" disabled="disabled"
													onclick="">
													<i class="fa fa-save"></i> Guardar
											</a>
											<a id="btn_tab_3_back" name="btn_tab_3_back" href="#tab_2" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_3').removeClass('active');
														 $('#li_2').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');">
												<i class="fa fa-arrow-circle-o-left"></i> Atrás
											</a>
											<a id="btn_tab_3_next" name="btn_tab_3_next" href="#tab_4" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_3').removeClass('active');
														 $('#li_4').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');
														 js_docAdmin_get_documentos_periodo_actual('div_documentos_admisiones', '{ruta_html_admisiones}/documentos_admision/controller.php', document.getElementById('hd_where_from').value);">
												<i class="fa fa-arrow-circle-o-right"></i> Siguiente
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div id='div_representantes_principales' name='div_representantes_principales'></div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_4">
							<h4 class="box-title">DOCUMENTOS</h4>
							<table cellspacing="0" cellpadding="0" class="table table-condensed table-responsive table-bordered">  
								<tbody>
									<tr class='row'>
										<td colspan="17">
											<a class="btn btn-app" disabled="disabled"
													onclick="">
													<i class="fa fa-save"></i> Guardar
											</a>
											<a id="btn_tab_4_back" name="btn_tab_4_back" href="#tab_3" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_4').removeClass('active');
														 $('#li_3').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');
														 js_representantes_get_representantes(document.getElementById('hd_per_codi').value, 'div_representantes_principales', '{ruta_html_common}/representantes/controller.php', 'off');">
												<i class="fa fa-arrow-circle-o-left"></i> Atrás
											</a>
											<a id="btn_tab_4_next" name="btn_tab_4_next" href="#tab_5" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_4').removeClass('active');
														 $('#li_5').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');" {btn_tab_4_next_display}>
												<i class="fa fa-arrow-circle-o-right"></i> Siguiente
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div id='div_documentos_admisiones' name='div_documentos_admisiones'>
								{documentos_admisiones}
							</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_5">
							<h4 class="box-title">ENVIAR SOLICITUD</h4>
							<table cellspacing="0" cellpadding="0" class="table table-condensed table-responsive table-bordered">  
								<tbody>
									<tr class='row'>
										<td colspan="17">
											<a class="btn btn-app" disabled="disabled"
													onclick="js_enviarSolicitud_guarda_formulario('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
												<i class="fa fa-save"></i>&nbsp;Guardar
											</a>
											<a id="btn_tab_5_back" name="btn_tab_5_back" href="#tab_4" data-toggle="tab" class="btn btn-app"
												onclick="$('#li_5').removeClass('active');
														 $('#li_4').addClass('active');
														 $('html, body').animate({ scrollTop: 0 }, 'fast');
														 js_docAdmin_get_documentos_periodo_actual('div_documentos_admisiones', '{ruta_html_admisiones}/documentos_admision/controller.php', document.getElementById('hd_where_from').value);">
												<i class="fa fa-arrow-circle-o-left"></i>&nbsp;Atrás
											</a>
											<a class="btn btn-app"  disabled='disabled'>
												<i class="fa fa-arrow-circle-o-right"></i>&nbsp;Siguiente
											</a>
											<a id="btn_tab_5_enviar_solicitud" name="btn_tab_5_enviar_solicitud" class="btn btn-app" 
												onclick="js_enviarSolicitud_enviar('{ruta_html_admisiones}/enviarSolicitud/controller.php');">
												<i class="fa fa-send"></i>&nbsp;Enviar solicitud
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div id='div_enviar_solicitud' name='div_enviar_solicitud'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-6">
											Está a punto de enviar la solicitud para iniciar el <b>proceso de preselección</b> 
											en el Colegio Moderna de Guayaquil. Si está listo, haga click en el botón de <b>Enviar solicitud</b> para finalizar.
										</div>
										<div class="col-sm-6">
											
										</div>
									</div>
								</div>
							</div>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
		</div> <!-- /.row -->
	</div>
</form>