<div class="modal fade" id="modal_vacuna" tabindex="-1" role="dialog" aria-labelledby="modal_vacuna" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_vacuna">Vacunas de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_vacuna_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_vac_nombre' name='{per}_lbl_vac_nombre'>Vacuna</label>
							<div id="div_cmb_vac_nombre" name="div_cmb_vac_nombre">{cmb_vacuna_nombre}</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_vac_fecha' name='{per}_lbl_vac_fecha'>Fecha aplicaci&oacute;n</label>
							<input type="text" class='form-control' id="{per}_vac_fecha" name="{per}_vac_fecha" value='{per_vac_fecha}' />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_vac_desc' name='{per}_lbl_vac_desc'>Observaciones de vacuna</label>
							<input type="text" class='form-control' id="{per}_vac_desc" name="{per}_vac_desc" value='{per_vac_desc}' />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-warning" 
						onclick="js_ficha_set_vacuna('{div_show_result}','{fmex_codi}',
									document.getElementById('cmb_vac_{per}'),
									document.getElementById('{per}_vac_fecha'),
									document.getElementById('{per}_vac_desc'),'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
