<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="modal_crm_head">Acercamiento de '{clie_nombres}'</h4>
</div>
<div class="modal-body">
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#datos" aria-controls="datos" role="tab" data-toggle="tab">Datos</a></li>
		<li role="presentation"><a href="#acercamientos" aria-controls="acercamientos" role="tab" data-toggle="tab">Acercamientos</a></li>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="datos">
			<div>&nbsp;</div>
			  <div class="row">
						<label for="clie_nombres" class="col-xs-2">Nombre</label>
						<div class="col-xs-10">
						<input  type="hidden" class="form-control" name="clie_codigo" id="clie_codigo" value="{clie_codigo}" >
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
	<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_acerca(document.getElementById('clie_codigo').value,'resultado','{ruta_html_finan}/cobranza/controller.php')">Guardar Cambios</button>
</div>