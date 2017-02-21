<div class="modal fade" id="modal_proteccion_especial" tabindex="-1" role="dialog" aria-labelledby="modal_proteccion_especial" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_proteccion_especial">Elemento de protección de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_proteccion_especial_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label>Tipo de elemento</label>
							{cmb_protex_esp_tipo}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label id='{per}_lbl_protex_esp_nombre'l name='{per}_lbl_protex_esp_nombre'>Elemento</label>
							<div id="div_cmb_protex_esp_nombre" name="div_cmb_protex_esp_nombre">{cmb_protex_esp_nombre}</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-warning" 
						onclick="js_persona_set_ele_protex('{div_show_result}','{per_codi}',document.getElementById('cmb_protex_esp_{per}'),'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
