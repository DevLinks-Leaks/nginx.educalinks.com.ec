<div class="modal fade" id="modal_enfermedad" tabindex="-1" role="dialog" aria-labelledby="modal_enfermedad" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_enfermedad">Enfermedades de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_enfermedad_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_enf_nombre' name='{per}_lbl_enf_nombre'>Enfermedad</label>
							<div class="form-group" id="div_cmb_enf_nombre" name="div_cmb_enf_nombre">{cmb_enfermedad_nombre}</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="checkbox">
								<label><input type="checkbox" name="{per}_enf_tiene" id="{per}_enf_tiene" {per_enf_tiene}>
									Tiene
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="checkbox">
								<label><input type="checkbox" name="{per}_enf_tuvo" id="{per}_enf_tuvo" {per_enf_tuvo}>
									Tuvo
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="checkbox">
								<label><input type="checkbox" name="{per}_enf_tratamiento" id="{per}_enf_tratamiento" {per_enf_tratamiento}>
									Tratamiento
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div id='div_enf_parentesco' name='div_enf_parentesco'{display_div_enf_parentesco}>
							<div class="col-sm-12">
								<label class="control-label" id='{per}_lbl_enf_parentesco' name='{per}_lbl_enf_parentesco'>Parentesco</label>
								<div id="div_cmb_enf_parentesco" name="div_cmb_enf_parentesco">{cmb_enfermedad_parentesco}</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" {display_div_enf_parentesco}>
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_vac_desc' name='{per}_lbl_vac_desc'>Observaciones de la enfermad</label>
							<input type="text" class='form-control' id="{per}_enf_desc_tratamiento" 
								name="{per}_enf_desc_tratamiento" value='{per_enf_desc_tratamiento}' />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-info" 
						onclick="js_ficha_set_enfermedad('{div_show_result}','{fmex_codi}',
									document.getElementById('cmb_enf_{per}'),
									document.getElementById('{per}_enf_tiene'),
									document.getElementById('{per}_enf_tuvo'),
									document.getElementById('cmb_enf_parentesco_{per}'),
									document.getElementById('{per}_enf_tratamiento'),
									document.getElementById('{per}_enf_desc_tratamiento'),
									'{titular}',
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>