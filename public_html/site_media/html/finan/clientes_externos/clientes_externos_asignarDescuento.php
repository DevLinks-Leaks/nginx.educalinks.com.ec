<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Asignaci&oacute;n de descuento</h4>
</div>
<div class="modal-body">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab1" aria-controls="Reporte Deudores" role="tab" data-toggle="tab">Nueva asignación</a></li>
			<li role="presentation"><a href="#tab2" aria-controls="Reporte Deudores - Resumen" role="tab" data-toggle="tab">Descuentos asignadas</a></li>
			<li role="presentation"><a href="#tab3" aria-controls="Reporte Deudores - Mensual" role="tab" data-toggle="tab">Descuentos inactivados</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tab1">
				<br>
				<div class="form-horizontal">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="nombres" class='control-label'><b>C&oacute;digo</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" readonly class="form-control" name="codigo" id="codigo" placeholder="codigo" value="{clie_codigo}" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="nombres" class='control-label'><b>Cliente</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" readonly class="form-control" name="nombres" id="nombres" 
									placeholder="Ingrese los nombres" value="{clie_nombres} {clie_apellidos}" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="nombres" class='control-label'><b>Descuento</b></label>
							<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
								<a tabindex="0" data-toggle="popover" title="<a href='../tipo_descuento/' target='_blank'>Descuentos</a>" data-content="<div style='font-size:x-small'>Si este campo sale en blanco, es probable que haga falta crear descuentos en el sistema. Por favor, ir a la página de <a href='../tipo_descuento/' target='_blank'>tipos de descuentos</a>.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
							</div>
						</div>
						<div class="col-sm-9">
							{combo_descto}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="porcentaje_descto" class='control-label'><b>Porcentaje Sugerido</b></label>
						</div>
						<div class="col-sm-9">
							<div id='div_porcentaje_descto' name='div_porcentaje_descto'>
								<div class="input-group"
											data-placement="right"
											title='Ej.: 10%.'
											onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control" name="porcentaje_descto" id="porcentaje_descto"
											onkeypress="return spacebar_retorna_cero(event,this);" 
											pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01"
											maxlength="15" placeholder="00.00" required='required'>
									<span class="input-group-addon" id="basic-addon">%</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="diasvalidez" class='control-label'><b>Días de validez</b></label>
							<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
								<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>Es el tiempo en el que el descuento es válido, a partir del día de inicio de cobro de una deuda.</div>" data-placement='top'><span class='fa fa-info-circle'></span></a>
							</div>
							<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
								<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>Deje el número de días en '0' para que el sistema reconozca que el descuento no tiene límite en el número de días de validez.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
							</div>
						</div>
						<div class="col-sm-9">
							<div id='div_diasvalidez' name='div_diasvalidez'>
								<div class="input-group">
									<input type="text" class="form-control" name="diasvalidez" id="diasvalidez" placeholder="0" required='required'>
									<span class="input-group-addon" id="basic-addon">días</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="tab2">
				<div class="row">
					<div class="col-sm-12">
						<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>
							{tabla_descuentos}
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="tab3">
				<div class="row">
					<div class="col-sm-12">
						<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>
							{tabla_descuentos_inactivos}
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	<button type="button" class="btn btn-success" 
		onclick="js_clientes_save_asign('{clie_codigo}','modal_asign_body','{ruta_html_finan}/clientes_externos/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
</div>