	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Edición de Nota de Cr&eacute;dito '{factura}'</h4>
	</div>
	<div class="modal-body">
			<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#home" 
				onclick="editar('{codigo}','{codigoAlumno}','modal_edit_body','{ruta_html_finan}/gestionNotascredito/controller.php','{ruta_html_common}/representantes/controller.php',true)"
				aria-controls="home" role="tab" data-toggle="tab">Edición de datos</a></li>
			<li role="presentation"><a href="#Reasignar" aria-controls="Reasignar" role="tab" data-toggle="tab">Asignar representante</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				<br>
				<form id='frm_pago' name='frm_pago' onsubmit="return validaSave_edited('{ruta_html_finan}/gestionNotascredito/controller.php')" role="form" data-toggle="validator">
					<div class="row">
						<div class="form-group">
							<input type="hidden" id="factura_codigo" name="factura_codigo" value="{codigo}" />
							<input type="hidden" id="codigoAlumno" name="codigoAlumno" value="{codigoAlumno}" />
							<div class="col-sm-6">
								<div class='alert alert-info fade in'>
									<small>
										<table width='100%'>
											<tr><td style='vertical-align:top' colspan='2'><b>Datos del titular en la Nota de Cr&eacute;dito</b></td></tr>
											<tr><td style='vertical-align:top' colspan='2'><hr style="padding:3px;margin:0px;"></td></tr>
											<tr><td style='vertical-align:top'><b>Nombre: </b></td><td>{nombreTitular}</td></tr>
											<tr><td style='vertical-align:top'><b>Cédula: </b></td><td>{idTitular}</td></tr>
											<tr><td style='vertical-align:top'><b>Dirección: </b></td><td>{dirTitular}</td></tr>
											<tr><td style='vertical-align:top'><b>Email: </b></td><td>{emailTitular}</td></tr>
										</table>
									</small>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="form-group">
										<div class="col-sm-12">
											<label for="num_cedula" class="control-label"><b>Tipo identificaci&oacute;n</b></label>
											{combo}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-sm-12">
											<label for="num_cedula" class="control-label"><b>No. identificaci&oacute;n</b></label>
											<input type="text" class="form-control" name="num_cedula" id="num_cedula"  required="required" value="{id}"
													pattern="[a-zA-Z0-9]+"
													maxlength="20" />
										</div>
									</div>
								</div>
							</div>							
						</div> 
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-6">
								<label for="repr_nomb" class="control-label"><b>Nombres</b></label>
								<input type="text" class="form-control" name="repr_nomb" id="repr_nomb"  required="required" value="{repr_nomb}"
										pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
										maxlength="60" />
								<span class="help-block with-errors"></span>
							</div>
							<div class="col-sm-6">
								<label for="repr_apel" class="control-label"><b>Apellidos</b></label>
								<input type="text" class="form-control" name="repr_apel" id="repr_apel"  required="required" value="{repr_apel}"
										pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$"
										maxlength="60" />
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
					<div class="row" >
						<div class="form-group">
							<div class="col-sm-12">
							<table width='100%'>
								<tr><td style='vertical-align:top'><input {disable_reg_titular} type="checkbox" class="checkbox" name="ckb_datosPersonales" id="ckb_datosPersonales" checked='checked'> </td>
									<td style='vertical-align:middle'>
										<label for="fechaFin_mod">¿Guardar cambios en el registro de datos personales del titular?
											<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;font-style: italic;text-align:left;vertical-align:middle;'>
												<a href='#' onmouseover='$(this).tooltip("show")' data-placement='right'
												title="Deje esta opci&oacute;n en blanco en caso que desee que los cambios de los datos del titular sean v&aacute;lidos s&oacute;lo para &eacute;ste documento." data-placement='bottom'>(?)</a>
											</div>
										</label>
									</td>
								</tr>
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
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-4">
								<button type="submit" class="btn btn-primary">Guardar edici&oacute;n</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="Reasignar">
				<div id='div_asign_repr' name='div_asign_repr'>
					...
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
