<div class="modal fade" id="modal_seleccionar_persona_lista" tabindex="-1" role="dialog" aria-labelledby="modal_seleccionar_persona_lista" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_seleccionar_persona_lista">Consulta de personas</h4>
			</div>
			<div class="modal-body" id="modal_seleccionar_persona_lista_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-horizontal">
								<div class="form-group">
									<div class="col-md-1 col-sm-3 hidden-sm" style='text-align:right'><label>Persona: </label></div>
									<div class="col-md-3 col-sm-12">
										<select id="cmb_per_consulta_tipo_persona" name="cmb_per_consulta_tipo_persona" class='form-control input-sm'>
											<!--<option value='0'>Sin especificar</option>-->
											<option value='1'>Alumno</option>
											<!--<option value='2'>Representante</option>-->
											<option value='3'>Empleado</option>
											<option value='4'>Cliente externo</option>
										</select>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="input-group">
											<input type="text" class="form-control input-sm" name="numeroIdentificacion_busq" id="numeroIdentificacion_busq" 
												placeholder="Código interno" required="required" />
												<span class="input-group-btn">
													<button type="button" class="btn btn-danger btn-sm" name="btn_busq" id="btn_busq" 
													onclick="js_persona_select_user_searchlist_search(document.getElementById('cmb_per_consulta_tipo_persona').value, 'numeroIdentificacion','resultadoBusqueda','{ruta_html_common}/persona/controller.php')" /><span class="fa fa-search"></span>&nbsp;</button>
												</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="input-group">
											<input type="text" class="form-control input-sm" name="nombre_busq" id="nombre_busq" 
												placeholder="Nombres y/o Apellidos" required="required" />
												<span class="input-group-btn">
													<button type="button" class="btn btn-primary btn-sm" name="btn_busq" id="btn_busq" 
													onclick="js_persona_select_user_searchlist_search(document.getElementById('cmb_per_consulta_tipo_persona').value, 'nombres','resultadoBusqueda','{ruta_html_common}/persona/controller.php')" /><span class="fa fa-search"></span>&nbsp;</button>
												</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div id="resultadoBusqueda" name="resultadoBusqueda" class="col-sm-12">
							{tablaPersona}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" 
						onclick="{js}('{div_buttons}','{div_show_result}', document.getElementById('cmb_per_consulta_tipo_persona').value )"><span class='fa fa-hand-o-up'></span>&nbsp;Seleccionar</button>
			</div>
		</div>
	</div>
</div>
