<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="modal_crm_head"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;Acercamiento de '{clie_nombres}'</h4>
</div>
<div class="modal-body">
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#datos" aria-controls="datos" role="tab" data-toggle="tab">Datos</a></li>
			<li role="presentation"><a href="#datos2" aria-controls="dato2" role="tab" data-toggle="tab">Representante económico</a></li>
			<li role="presentation"><a href="#datos3" aria-controls="datos3" role="tab" data-toggle="tab">Representante académico</a></li>
			<li role="presentation"><a href="#acercamientos" aria-controls="acercamientos" role="tab" data-toggle="tab">Acercamientos</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="datos">
				<div>&nbsp;</div>
				<div class="row">
							<label for="clie_nombres" class="col-xs-2">Nombre</label>
							<div class="col-xs-10">
							<input  type="hidden" class="form-control" name="clie_codigo" 	id="clie_codigo" 	value="{clie_codigo}" >
							<input  type="hidden" class="form-control" name="tipo_persona"	id="tipo_persona" 	value="{tipo_persona}">
							<input  type="text" class="form-control" name="clie_nombres" id="clie_nombres" value="{clie_nombres}" required="required" readonly="readonly">
							</div>
				</div>
				<div class="row">
					<br>
				</div>
				<div class="row">
						<label for="clie_telefono" class="col-xs-2">Teléfono</label>
						<div class="col-xs-4">
						<input type="text" class="form-control" name="clie_telefono" id="clie_telefono" value="{clie_telefono}" required="required">
						</div>
						<label for="clie_correoElectronico" class="col-xs-2">Correo Electrónico</label>
						<div class="col-xs-4">
						<input type="email" class="form-control" name="clie_correoElectronico" id="clie_correoElectronico" 
							value="{clie_correoElectronico}" >
						</div>
				</div>
				<div class="row">
					<br>
				</div>
				<div class="row">
					<label for="clie_direccion" class="col-xs-2">Dirección</label>
						<div class="col-xs-10">
						<input type="text" class="form-control" name="clie_direccion" id="clie_direccion" value="{clie_direccion}" required="required">
						</div>
				</div>
				<div class="row">
					<br>
				</div>
				<div class="row">
					<label for="combo_resultado" class="col-xs-2">Resultado</label>
						<div class="col-xs-4">
							{combo_resultado}
						</div>
						<label for="acerca_fecha_seguimiento" class="col-xs-2">F. Seguimiento</label>
						<div class="col-xs-4">
							<input type="text" name="acerca_fecha_seguimiento" id="acerca_fecha_seguimiento" value="{acerca_fecha_seguimiento}"
								class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
						</div>
				</div>
				<div class="row">
					<br>
				</div>
				<div class="row">
						<label for="combo_detalle_resultado" class="col-xs-2">Detalle</label>
						<div class="col-xs-4">
						<div id="deta_crm_resul_div">{combo_detalle_resultado}</div>
						</div>
						<label for="deud_totalPendiente" class="col-xs-2">Deuda actual</label>
						<div class="col-xs-4">
						<input type="text" class="form-control" name="txt_deud_totalPendiente" id="txt_deud_totalPendiente" value="{txt_deud_totalPendiente}" required="required" readonly="readonly">
						<input type="hidden" class="form-control" name="deud_totalPendiente" id="deud_totalPendiente" value="{deud_totalPendiente}" required="required" readonly="readonly">
						</div>
				</div>
				<div class="row">
					<br>
				</div>
				<div class="row">
					<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{clie_codigo}" required="required">
				</div>
				<div class="row">
					<label for="observacion_resultado" class="col-xs-2">Observaciones</label>
					<div class="col-xs-10">
					<textarea class="form-control" rows="3" name="observacion_resultado" id="observacion_resultado" value="" placeholder="Observación a la respuesta del cliente" required="required"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-4">
							<br>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="datos2">
				<br>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="num_cedula" class="control-label"><b>Tipo identificaci&oacute;n</b></label>
							{combo_acad}
						</div>
						<div class="col-sm-6">
							<label for="repr_cedula_acad" class="control-label"><b>No. identificaci&oacute;n</b></label>
							<input type="text" class="form-control" name="repr_cedula_acad" id="repr_cedula_acad"  required="required" value="{repr_cedula_acad}"
									pattern="[a-zA-Z0-9]+"
									maxlength="20" disabled="disabled"/>
						</div>					
					</div> 
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="repr_nomb_acad" class="control-label"><b>Nombres</b></label>
							<input type="text" class="form-control" name="repr_nomb_acad" id="repr_nomb_acad"  required="required" value="{repr_nomb_acad}"
									pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
									maxlength="60" disabled="disabled"/>
							<span class="help-block with-errors"></span>
						</div>
						<div class="col-sm-6">
							<label for="repr_apel_acad" class="control-label"><b>Apellidos</b></label>
							<input type="text" class="form-control" name="repr_apel_acad" id="repr_apel_acad"  required="required" value="{repr_apel_acad}"
									pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
									maxlength="60" disabled="disabled"/>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12">
							<label for="repr_domi_acad" class="control-label"><b>Direcci&oacute;n</b></label>
							<input type="text" class="form-control" name="repr_domi_acad" id="repr_domi_acad"  required="required" value="{repr_domi_acad}"
									maxlength="150" />
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="repr_email_acad" class="control-label"><b>e-mail</b></label>
							<input type="text" class="form-control" name="repr_email_acad" id="repr_email_acad"  required="required" value="{repr_email_acad}"
									pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
									maxlength="200"/>
							<span class="help-block with-errors"></span>
						</div>
						<div class="col-sm-6">
							<label for="repr_telf_acad" class="control-label"><b>Telf. convencional</b></label>
							<input type="text" class="form-control" name="repr_telf_acad" id="repr_telf_acad"  required="required" value="{repr_telf_acad}"
									pattern='[0-9]+' maxlength="25"/>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<!--<div class="row" >
					<div class="form-group">
						<div class="col-sm-12">
						<table width='100%'>
							<tr><td style='vertical-align:top'><input type="checkbox" class="checkbox" name="ckb_docPendientes" id="ckb_docPendientes" > </td>
								<td style='vertical-align:middle'>
									<label for="fechaFin_mod">¿Actualizar datos del titular en todos los documentos legales por Autorizar?
										<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;font-style: italic;text-align:left;vertical-align:middle;'>
											<a href='#' onmouseover='$(this).tooltip("show")' data-placement='right'
											title="Si le da clic a esta opci&oacute;n, todos los documentos generados hasta ahora se ver&aacute;n afectados por el mismo cambio que realice en este momento." data-placement='bottom'>(?)</a>
										</div>
									</label>
								</td>
							</tr>
						</table>
						<br>
						</div>
					</div>
				</div>-->
			</div>
			<div role="tabpanel" class="tab-pane fade" id="datos3">
				<br>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="repr_cedula" class="control-label"><b>Tipo identificaci&oacute;n</b></label>
							{combo}
						</div>
						<div class="col-sm-6">
							<label for="repr_cedula" class="control-label"><b>No. identificaci&oacute;n</b></label>
							<input type="text" class="form-control" name="repr_cedula" id="repr_cedula"  required="required" value="{repr_cedula}"
									pattern="[a-zA-Z0-9]+"
									maxlength="20" disabled="disabled"/>
						</div>					
					</div> 
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="repr_nomb" class="control-label"><b>Nombres</b></label>
							<input type="text" class="form-control" name="repr_nomb" id="repr_nomb"  required="required" value="{repr_nomb}"
									pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
									maxlength="60" disabled="disabled"/>
							<span class="help-block with-errors"></span>
						</div>
						<div class="col-sm-6">
							<label for="repr_apel" class="control-label"><b>Apellidos</b></label>
							<input type="text" class="form-control" name="repr_apel" id="repr_apel"  required="required" value="{repr_apel}"
									pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
									maxlength="60" disabled="disabled"/>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12">
							<label for="repr_domi" class="control-label"><b>Direcci&oacute;n</b></label>
							<input type="text" class="form-control" name="repr_domi" id="repr_domi"  required="required" value="{repr_domi}"
									maxlength="150" />
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-6">
							<label for="repr_email" class="control-label"><b>e-mail</b></label>
							<input type="text" class="form-control" name="repr_email" id="repr_email"  required="required" value="{repr_email}"
									pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
									maxlength="200"/>
							<span class="help-block with-errors"></span>
						</div>
						<div class="col-sm-6">
							<label for="repr_telf" class="control-label"><b>Telf. convencional</b></label>
							<input type="text" class="form-control" name="repr_telf" id="repr_telf"  required="required" value="{repr_telf}"
									pattern='[0-9]+' maxlength="25"/>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="acercamientos">
				<div class="form-horizontal">
					<div class="form-group">
						<div class="col-sm-12">
							{tabla_acercamientos_ant}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="js_cobranza_save_acerca(document.getElementById('clie_codigo').value,'resultado','{ruta_html_finan}/cobranza/controller.php')">Guardar acercamiento</button>
</div>