<div class="modal fade" id="modal_datos_laborales" tabindex="-1" role="dialog" aria-labelledby="modal_datos_laborales" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_datos_laborales">Datos laborales de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_datos_laborales_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<input name="{per}_empr_codi" id="{per}_empr_codi"  type="hidden" class="form-control" value="{per_empr_codi}"/>
						<input name="{per}_per_empr_codi" id="{per}_per_empr_codi"  type="hidden" class="form-control" value="{per_per_empr_codi}"/>
						<div class="col-sm-8"><input name="{per}_empr_nomb" id="{per}_empr_nomb"  type="text" class="form-control" value="{per_empr_nomb}" 
							placeholder="Empresa donde Trabaja (Razón Social)" /></div>
						<div class="col-sm-4"><input name="{per}_empr_ruc" id="{per}_empr_ruc"  type="text" pattern="[0-9]*" class="form-control" 
							value="{per_empr_ruc}" maxlength='13' placeholder="RUC" /></div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12"><input name="{per}_empr_dir" id="{per}_empr_dir"  type="text" class="form-control" value="{per_empr_dir}" 
							placeholder="Dirección de la Empresa" /></div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12"><input name="{per}_empr_cargo" id="{per}_empr_cargo"  type="text" class="form-control" value="{per_empr_cargo}" placeholder="Cargo que desempeña"/></div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<input name="{per}_empr_telf" id="{per}_empr_telf"  type="text" class="form-control" value="{per_empr_telf}" 
								placeholder="Teléfono" />
						</div>
						<div class="col-sm-4">
							<input name="{per}_empr_mail" id="{per}_empr_mail"  type="text" class="form-control" value="{per_empr_mail}" 
								pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
								maxlength="200"placeholder="e-mail empresarial"/>
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
						onclick="js_persona_set_datos_laborales('{div_show_result}','{per_codi}',
									document.getElementById('{per}_empr_codi'),
									document.getElementById('{per}_per_empr_codi'),
									document.getElementById('{per}_empr_nomb'),
									document.getElementById('{per}_empr_ruc'),
									document.getElementById('{per}_empr_dir'),
									document.getElementById('{per}_empr_cargo'),
									document.getElementById('{per}_empr_telf'),
									document.getElementById('{per}_empr_mail'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
