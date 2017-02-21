<!-- Modal Asignar Fecha-->
<div class="modal fade" id="modal_asign_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Asignación de fecha</h4>
            </div>
			<div class="modal-body" >
				<div id="modal_asign_fecha_bandeja" name="modal_asign_fecha_bandeja">
				</div>
				<br>
				<div id="modal_asign_fecha_body" name="modal_asign_fecha_body" style='display:block'>
					<div class="grid" id='div_grid_modal_asign_fecha' name='div_grid_modal_asign_fecha'>
						<div class="row">
							<div class='col-sm-12'>
								<label>Asigne una fecha para los exámenes a rendir. Le podría ayudar como referencia en la fecha de exámen sobre qué estudiantes
									rendirán pruebas ese día.
								</label>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-3' style='text-align:right;'>
								<br>
								<input type="hidden" id="hd_fecha_soli_codi"    name="hd_fecha_soli_codi"   value="">
								<input type="hidden" id="hd_fecha_soli_estado"  name="hd_fecha_soli_estado" value="">
								<input type="hidden" id="hd_fecha_ruta_html"    name="hd_fecha_ruta_html"   value="">
								<input type="hidden" id="hd_fecha_next"    		name="hd_fecha_next"   		value="2">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_fecha_asign_1" class="control-label">Fecha de asignaci&oacute;n</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="date" id="txt_fecha_asign_1" class="form-control" name="txt_fecha_asign_1" value="">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-12'>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_fecha_asign_1" class="control-label">Aactividad/Examen</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="text" id="txt_fecha_actividad_1" 	class="form-control" name="txt_fecha_actividad_1" value="">
								<input type="hidden" id="hd_fecha_change_est_1" name="hd_fecha_change_est_1" value="0">
								<!-- Si es 1, actualiza a 'Fecha asignada' automáticamente. Mantener en cero, si se marca como tal desde otra opción.-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="modal_asign_fecha_footer" name="modal_asign_fecha_footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success"
					onclick="js_verSolicitud_asignar_fecha_followed(document.getElementById('hd_fecha_soli_codi').value,document.getElementById('hd_fecha_soli_estado').value,'modal_asign_fecha_bandeja', document.getElementById('hd_fecha_ruta_html').value);">
					<li class="fa fa-save" >&nbsp;</li>Asignar fecha</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Asignar Fecha-->
<!-- Modal Subir archivo-->
<div class="modal fade" id="modal_subir_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Síntesis académica</h4>
            </div>
			<div class="modal-body" >
				<div id="modal_subir_archivo_bandeja">
				</div>
				<br>
				<div id="modal_subir_archivo_body" style='display:block'>
					<div class="grid">
						<div class="row">
							<div class='col-sm-12'>
								<label>Adjunte el archivo de 'síntesis académica' del postulante que desea subir.
								</label>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-3' style='text-align:right;'>
								<br>
								<input type="hidden" id="hd_sint_soli_codi"	name="hd_sint_soli_codi"   	value="">
								<input type="hidden" id="hd_sint_num_soli"	name="hd_sint_num_soli" 	value="">
								<input type="hidden" id="hd_sint_ruta_html"	name="hd_sint_ruta_html"   	value="">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="ftu_sint_docu_file" class="control-label">Síntesis académica</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="file" name="ftu_sint_docu_file" id="ftu_sint_docu_file" required="required">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-12' style='text-align:left;'>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_sint_docu_desc" class="control-label">Desc. documento</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="text" class='form-control' name="txt_sint_docu_desc" id="txt_sint_docu_desc" required="required">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="modal_subir_archivo_footer" style='display:block'>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success"
					onclick="js_docAdmin_subir_sintesis(document.getElementById('hd_sint_soli_codi').value,document.getElementById('hd_sint_num_soli').value,'resultado', document.getElementById('hd_sint_ruta_html').value);">
					<li class="fa fa-upload" >&nbsp;</li>Subir síntesis</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Subir archivo-->
<!-- Modal Negar pase-->
<div class="modal fade" id="modal_procesar_pase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Procesando solicitud</h4>
            </div>
			<div class="modal-body" id="modal_procesar_pase_body">
				<input type="hidden" id="hd_procesar_pase_soli_codi" 	name="hd_procesar_pase_soli_codi" 		value="">
				<input type="hidden" id="hd_procesar_pase_per_codi" 	name="hd_procesar_pase_per_codi" 		value="">
				<input type="hidden" id="hd_procesar_pase_soli_estado"	name="hd_procesar_pase_soli_estado" 	value="">
				<input type="hidden" id="hd_procesar_pase_div"			name="hd_procesar_pase_div" 			value="resultado">
				<input type="hidden" id="hd_procesar_pase_ruta_html"	name="hd_procesar_pase_ruta_html"		value="">
                <div class="grid">
					<div class="row">
						<div class='col-sm-12'>
							Si desea, puede escribir una <b>observación</b> (opcional). El estudiante la podrá leer al ingresar al sistema de pre-admisiones, 
							y un correo electrónico le llegará al correo del representante académico.
							<br>
							<br>
							Si se está devolviendo la solicitud por falta de alguna información, por favor, indicar qué información le falta
							completar, o adjuntar, para que el postulante sepa
							el motivo específico de la negación de su solicitud.
							
						</div>
					</div>
					<div class="row">
						<div class='col-sm-12'>
							<br>
						</div>
					</div>
					<div class="row">
						<div class='col-sm-12'>
							<textarea rows="2" cols="80" maxlength="300" name="txt_procesar_pase_obs" id="txt_procesar_pase_obs"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="checkbox checkbox-info col-sm-12">
							<label for='ckb_gestionFactura_opc_adv'>
								<input type="checkbox" id='ckb_gestionFactura_opc_adv' name='ckb_gestionFactura_opc_adv'>
									<span style="text-align:left;font-size:small;font-weight:bold;">Enviar copia al correo del representante legal</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal"
					onclick="js_verSolicitud_procesar(document.getElementById('hd_procesar_pase_soli_codi').value,
														document.getElementById('hd_procesar_pase_per_codi').value,
														document.getElementById('hd_procesar_pase_soli_estado').value,
														document.getElementById('hd_procesar_pase_div').value,
														document.getElementById('hd_procesar_pase_ruta_html').value,
														document.getElementById('txt_procesar_pase_obs').value,
														document.getElementById('ckb_gestionFactura_opc_adv').checked );">
					<li class="fa fa-upload" >&nbsp;</li>Procesar solicitud</button>
            </div>
		</div>
	</div>
</div>
<!-- /. Modal Negar pase-->
<!-- Modal Cambiar estado solicitud-->
<div class="modal fade" id="modal_cambiar_estado" tabindex="-1" role="dialog" aria-labelledby="modal_cambiar_estado" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cambio de estado de solicitud no. "<span id="span_mce_soli_codi"></span>"</h4>
            </div>
			<div class="modal-body" id="modal_cambiar_estado_body">
				<input type="hidden" id="hd_mce_soli_codi"	name="hd_mce_soli_codi" value="">
				<div class="form-horizontal">
					<div class="form-group">
						<label class='col-sm-4 control-label' style="text-align:right;">
							Estado anterior:
						</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control input-sm' id="txt_mce_estado_anterior" name="txt_mce_estado_anterior" disabled='disabled' readonly='readonly'/>
						</div>
					</div>
					<div class="form-group">
						<label class='col-sm-4 control-label' style="text-align:right;">
							Nuevo estado:
						</label>
						<div class='col-sm-6'>
							<select id='cmb_mce_estado_nuevo' name='cmb_mce_estado_nuevo' class='form-control input-sm'>
								<option value="GUARDADA">GUARDADA</option>
								<option value="ENVIADA">ENVIADA</option>
								<option value="DEVUELTA">DEVUELTA</option>
								<option value="PDTE. PAGO">PDTE. PAGO</option>
								<option value="NO INTERESADO">NO INTERESADO</option>
								<option value="PAGADA">PAGADA</option>
								<option value="FECHA ASIGNADA">FECHA ASIGNADA</option>
								<option value="EX. REPROBADO">EX. REPROBADO</option>
								<option value="EX. APROBADO">EX. APROBADO</option>
								<option value="APROBADO DIRECTORES">APROBADO DIRECTORES</option>
								<option value="ADMITIDO">ADMITIDO</option>
								<option value="INACTIVO">INACTIVO</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" onclick='js_verSolicitud_cambiar_estado_followed(
												document.getElementById("hd_mce_soli_codi").value,
												document.getElementById("cmb_mce_estado_nuevo").value,
												"resultado",
												document.getElementById("ruta_html_admisiones").value + "/verSolicitud/controller.php")' 
					class='btn btn-success'><li class="fa fa-save" ></li>&nbsp;Guardar cambios</button>
            </div>
		</div>
	</div>
</div>
<!-- /. Modal Cambiar estado solicitud -->
<!-- Modal Formulario PDF-->
<div class="modal fade" id="modal_formulario_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Procesando solicitud</h4>
            </div>
			<div class="modal-body" id="modal_formulario_pdf_body">
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
		</div>
	</div>
</div>
<!-- /.  Modal Formulario PDF
<form id="file_form" action="../../admisiones/verSolicitud/" enctype="multipart/form-data" method="post" target="_blank">
	-->
<form id="file_form" action="{ruta_html_admisiones}/verSolicitud/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' id='hd_main_soli_estado' name='hd_main_soli_estado' value="{soli_estado}"/>
	<input type='hidden' name="event" id="evento" value="print_excel"/>
	<div class='row'>
		<div class='col-md-12'>
			<div class='panel panel-info'>
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="form-horizontal" role="form">
						<div class="form-group">	
							<div class='col-md-4 col-sm-12'>
								<button type="button" class="btn btn-success fa fa-file-excel-o " title="Exportar bandeja general" onmouseover="$(this).tooltip('show');"
										onclick="js_verSolicitud_consulta_general_xls('file_form');">
								</button>
								<button type="button" class="btn btn-danger fa fa-file-excel-o" title="Exportar reporte de documentos pendientes" onmouseover="$(this).tooltip('show');"
										onclick="js_verSolicitud_consulta_docu_pdtes_xls('file_form');">
								</button>
								<button type='button' class='btn btn-primary fa fa-search' id='btn_selectTipoDocAut' name='btn_selectTipoDocAut' 
										onclick="js_verSolicitud_buscar_todos( 'get_all', 'resultado', '{ruta_html_admisiones}/verSolicitud/controller.php',
												document.getElementById('hd_main_soli_estado').value,
												document.getElementById('txt_s_fecha_ini').value,
												document.getElementById('txt_s_fecha_fin').value,
												document.getElementById('txt_s_id_solicitud').value,
												document.getElementById('cmb_s_curso_aplica').value,
												document.getElementById('txt_s_id_repr').value,
												document.getElementById('txt_s_num_intentos').value,
												'',
												'',
												'');">
								</button>
							</div>
							<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de emisión, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='js_verSolicitud_check_fecha();'>
									</span>
									<span class="input-group-addon">
										<span style="text-align:left;font-size:small;font-weight:bold;">F. registro</span>
									</span>				
									<span class="input-group-addon">
										<small>Inicio</small></span>
									<input type="text" class="form-control input-sm" name="txt_s_fecha_ini" id="txt_s_fecha_ini" 
										 data-mask required="required" disabled>
									<span class="input-group-addon">
										<small>Fin</small></span>
									<input type="text" class="form-control input-sm" name="txt_s_fecha_fin" id="txt_s_fecha_fin" 
										 data-mask required="required" disabled>
								</div>
							</div>
							<div class="checkbox checkbox-info col-sm-2">
								<label for='ckb_opc_adv'>
									<input type="checkbox" id='ckb_verSolicitud_opc_adv' name='ckb_verSolicitud_opc_adv' onclick='js_verSolicitud_check_opc_avanzadas();'>
										<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
								</label>
							</div>
						</div>
						<!-- COLLAPSE -->
						<div id='div_verSolicitud_opc_adv' name='div_verSolicitud_opc_adv' class='collapse' >
							<!-- <hr> -->
							<div class='form-group'>
								<label class="col-md-2 col-sm-3 control-label" style='text-align: right;'>Id. Solicitud:</label>
								<div class="col-md-4 col-sm-5"
										data-placement="bottom"
										title='C&oacute;digo del representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_s_id_solicitud" id="txt_s_id_solicitud" >
								</div>
								<!--<div class="col-md-2 col-sm-3">
									<div class="checkbox custom-checkbox custom-checkbox-primary">
										<input id="id_anulado" name="anulado" type="checkbox" onclick="js_verSolicitud_check_fecha();">
										<label class="control_label_contif" for="id_anulado"><b>&nbsp;Avanzada</b></label>  
									</div>
								</div>-->
							</div>
							<div class='form-group'>
								<label class='col-md-2 col-sm-3 control-label' for='txt_nom_cliente' style='text-align: right;'>Curso al que aplica:</label>
								<div class="col-md-4 col-sm-5">
									{cmb_s_curso_aplica}
								</div>
							</div>
							<div class='form-group'>
								<label class='col-md-2 col-sm-3 control-label' for='txt_nom_cliente' style='text-align: right;'>Id. Repr. Académico</label>
								<div class="col-md-4 col-sm-5"
										data-placement="bottom"
										title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_s_id_repr" id="txt_s_id_repr" >
								</div><!-- 
								<div class="col-sm-2" style="text-align:left;">
									<label class='control-label' for='txt_s_nom_repr'><span style="font-size:small;font-weight:bold;">Nombre Repr. Académico</span></label>
								</div>
								<div class="col-sm-3"
										data-placement="bottom"
										title='Nombre del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_s_nom_repr" id="txt_s_nom_repr" >
								</div> -->
							</div>
							<div class='form-group'>
								<label class='col-md-2 col-sm-3 control-label' for='txt_nom_cliente' style='text-align: right;'>Numero intentos</label>
								<div class="col-md-4 col-sm-5"
										data-placement="bottom"
										title='Número de veces que ha vuelto a intenter la admisión luego de reprobar.'
										onmouseover='$(this).tooltip("show")'>
									<input type="number" step=1 min=0 class="form-control input-sm" name="txt_s_num_intentos" id="txt_s_num_intentos" >
								</div>
							</div>
							<!-- 
							<div class='row'>
								<div class="col-sm-2" style="text-align:left;">
									<br>
								</div>
							</div>
							<div class='row'>
								<div class="col-sm-2" style="text-align:left;">
									<label class='control-label' for='txt_s_id_postulante'><span style="font-size:small;font-weight:bold;">Id. postulante</span></label>
								</div>
								<div class="col-sm-3"
										data-placement="bottom"
										title='C&oacute;digo del representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_s_id_postulante" id="txt_s_id_postulante" >
								</div>
								<div class="col-sm-2" style="text-align:left;">
									<label class='control-label' for='txt_s_nom_postulante'><span style="font-size:small;font-weight:bold;">Nombre postulante</span></label>
								</div>
								<div class="col-sm-3"
										data-placement="bottom"
										title='Nombre del cliente representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_s_nom_postulante" id="txt_s_nom_postulante" >
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-xs-12'>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						<div id="div_btn_back" name="div_btn_back" style="display:none;">
							<button type="button" class="btn btn-warning" 
								onclick="js_verSolicitud_buscar_todos( 'get_all', 'resultado', '{ruta_html_admisiones}/verSolicitud/controller.php',
													 document.getElementById('hd_main_soli_estado').value, '', '', '', '', '', '', '', '', '' );
										 document.getElementById('div_btn_back').style.display = 'none';"><li class="fa fa-angle-left"></li>&nbsp;Volver a bandeja</button>
						</div>
					</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div id="resultado">
						{tabla}
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</form>