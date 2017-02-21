<div class="modal fade" id="modal_show_datos_laborales" tabindex="-1" role="dialog" aria-labelledby="modal_show_datos_laborales" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_show_datos_laborales">Datos laborales de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_show_datos_laborales_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
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
				<button type="button" class="btn btn-success" data-dismiss="modal" 
						onclick="js_persona_add_datos_laborales_followed('{div_show_result}')"><span class='fa fa-plus'></span>&nbsp;Agregar</button>
			</div>
		</div>
	</div>
</div>
