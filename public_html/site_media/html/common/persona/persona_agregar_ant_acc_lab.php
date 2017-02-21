<div class="modal fade" id="modal_acc_laborales" tabindex="-1" role="dialog" aria-labelledby="modal_acc_laborales" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_acc_laborales">Datos laborales de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_acc_laborales_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label id='{per}_lbl_inst_acc_fecha' name='{per}_lbl_inst_acc_fecha' class="control-label">Cargo/Empresa</label>
							{cmb_datos_laborales}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="control-label">Fecha del siniestro</label>
							<input name="{per}_inst_acc_fecha" id="{per}_inst_acc_fecha"  type="text" class="form-control" value="{per_inst_acc_fecha}"/>
						</div>
						<div class="col-sm-8">
							<label class="control-label">Causa</label>
							<input name="{per}_inst_acc_causa" id="{per}_inst_acc_causa" maxlength="250" type="text" class="form-control" value="{per_inst_acc_causa}"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Tipo de lesión</label>
							<input name="{per}_inst_acc_tipo_lesion" id="{per}_inst_acc_tipo_lesion" maxlength="250" type="text" class="form-control" value="{per_inst_acc_tipo_lesion}"/>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Parte afectada</label>
							<input name="{per}_inst_acc_parte_afectada" id="{per}_inst_acc_parte_afectada" maxlength="250" type="text" class="form-control" value="{per_inst_acc_parte_afectada}"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Incapacidad</label>
							<input name="{per}_inst_acc_incapacidad" id="{per}_inst_acc_incapacidad" maxlength="250" type="text" class="form-control" value="{per_inst_acc_incapacidad}"/>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Secuelas</label>
							<input name="{per}_inst_acc_secuelas" id="{per}_inst_acc_secuelas" maxlength="250" type="text" class="form-control" value="{per_inst_acc_secuelas}"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" 
						onclick="js_persona_set_acc_laborales('{div_show_result}','{per_codi}',
									document.getElementById('cmb_datos_laborales_acc_{per}'),
									document.getElementById('{per}_inst_acc_fecha'),
									document.getElementById('{per}_inst_acc_causa'),
									document.getElementById('{per}_inst_acc_tipo_lesion'),
									document.getElementById('{per}_inst_acc_parte_afectada'),
									document.getElementById('{per}_inst_acc_incapacidad'),
									document.getElementById('{per}_inst_acc_secuelas'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>