<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<div class="modal fade" id="modal_nueva_persona" tabindex="-1" role="dialog" aria-labelledby="modal_nueva_persona" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_nueva_persona">Registro de nueva persona al sistema</h4>
			</div>
			<div class="modal-body" id="modal_nueva_persona_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label>Seleccione una categoría para la nueva persona a ingresar</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<ul style="list-style-type:none">
								<!--<li><input type="radio" id="rdb_tipo_persona" name="rdb_tipo_persona" value="0" > Sin especificar<br></li>
								<li><input type="radio" id="rdb_tipo_persona" name="rdb_tipo_persona" value="1" > Alumno<br></li>
								<li><input type="radio" id="rdb_tipo_persona" name="rdb_tipo_persona" value="2" > Representante<br></li>-->
								<li><input type="radio" id="rdb_tipo_persona" name="rdb_tipo_persona" value="3" > Empleado<br></li>
								<li><input type="radio" id="rdb_tipo_persona" name="rdb_tipo_persona" value="4" > Cliente externo<br></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" 
					onclick="js_paciente_select_user('span_button_save_person', $('#rdb_tipo_persona:checked').val(), 'paciente' )">
					<span class='fa fa-plus'></span>&nbsp;Nuevo
				</button>
			</div>
		</div>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<div class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-6 col-xs-12" style="text-align:left;">
					<button type="button" class="btn btn-primary" 
							onclick="$('#modal_nueva_persona').modal('show');">
							<span class='fa fa-plus'></span>&nbsp;Nuevo</button>
					<button type="button" class="btn btn-warning" 
							onclick="js_persona_select_user_searchlist('span_button_save_person', 'div_modal_seleccionar_persona_lista', 'div_paciente_setear_formulario', 'paciente')">
							<span class='fa fa-folder'></span>&nbsp;Abrir</button>
					<span id='span_button_save_person' name='span_button_save_person'></span>
				</div>
			</div>
		</div>
	</div>
	<div class="box-body" id="div_paciente_setear_formulario">
		<div style='text-align:center;'><span class='fa fa-user'></span></div>
	</div>
</div>