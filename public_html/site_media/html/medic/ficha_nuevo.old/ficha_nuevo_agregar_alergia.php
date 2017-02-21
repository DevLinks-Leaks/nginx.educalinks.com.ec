<div class="modal fade" id="modal_alergia" tabindex="-1" role="dialog" aria-labelledby="modal_alergia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_alergia">Alergias de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_alergia_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label>Tipo de alergia</label>
							{cmb_alergia_tipo}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_ale_nombre' name='{per}_lbl_ale_nombre'>Alergia</label>
							<div id="div_cmb_ale_nombre" name="div_cmb_ale_nombre">{cmb_alergia_nombre}</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_ale_reaccion' name='{per}_lbl_ale_reaccion'>Descripción de reacción</label>
							<input type="text" class='form-control' id="{per}_ale_reaccion" name="{per}_ale_reaccion" value='{per_ale_reaccion}' />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-danger" 
						onclick="js_ficha_set_alergia('{div_show_result}','{fmex_codi}',
									document.getElementById('cmb_ale_{per}'),
									document.getElementById('{per}_ale_reaccion'),'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
