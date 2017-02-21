<div class="modal fade" id="modal_rie_laborales" tabindex="-1" role="dialog" aria-labelledby="modal_rie_laborales" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rie_laborales">Datos laborales de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_rie_laborales_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label id='{per}_lbl_inst_rie_fecha' name='{per}_lbl_inst_rie_fecha' class="control-label">Cargo/Empresa</label>
							{cmb_datos_laborales}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Riesgo físico</label>
							<input name="{per}_inst_risk_fisico" id="{per}_inst_risk_fisico" maxlength="250" type="text" class="form-control" value="{per_inst_risk_fisico}"/>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Riesgo físicomecánico</label>
							<input name="{per}_inst_risk_fisicomec" id="{per}_inst_risk_fisicomec" maxlength="250" type="text" class="form-control" value="{per_inst_risk_fisicomec}"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Riesgo químico</label>
							<input name="{per}_inst_risk_quimico" id="{per}_inst_risk_quimico" maxlength="250" type="text" class="form-control" value="{per_inst_risk_quimico}"/>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Riesgo biológico</label>
							<input name="{per}_inst_risk_biologico" id="{per}_inst_risk_biologico" maxlength="250" type="text" class="form-control" value="{per_inst_risk_biologico}"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Riesgo disergonómico</label>
							<input name="{per}_inst_risk_disergon" id="{per}_inst_risk_disergon" maxlength="250" type="text" class="form-control" value="{per_inst_risk_disergon}"/>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Riesgo psicosocial</label>
							<input name="{per}_inst_risk_psicosocial" id="{per}_inst_risk_psicosocial" maxlength="250" type="text" class="form-control" value="{per_inst_risk_psicosocial}"/>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" 
						onclick="js_persona_set_rie_laborales('{div_show_result}','{per_codi}',
									document.getElementById('cmb_datos_laborales_rie_{per}'),
									document.getElementById('{per}_inst_risk_fisico'),
									document.getElementById('{per}_inst_risk_fisicomec'),
									document.getElementById('{per}_inst_risk_quimico'),
									document.getElementById('{per}_inst_risk_biologico'),
									document.getElementById('{per}_inst_risk_disergon'),
									document.getElementById('{per}_inst_risk_psicosocial'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>