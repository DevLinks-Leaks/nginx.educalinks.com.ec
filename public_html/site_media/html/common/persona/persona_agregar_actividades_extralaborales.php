<div class="modal fade" id="modal_show_act_ext" tabindex="-1" role="dialog" aria-labelledby="modal_show_act_ext" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_show_act_ext">Actividad extralaboral de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_show_act_ext_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label name="{per}_act_ext_nombre_lbl" id="{per}_act_ext_nombre_lbl">
								Descripción de la actividad
							</label>
							<input name="{per}_act_ext_nombre" id="{per}_act_ext_nombre"  type="text" class="form-control" value="{per_act_ext_nombre}" 
								placeholder="Nombre o descripción de actividad" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-info"
					onclick="js_persona_set_act_ext('{div_show_result}', 
							'{per_act_ext_codi}',
							'{per_codi}',
							document.getElementById('{per}_act_ext_nombre'),
							'{per}' )"><span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
