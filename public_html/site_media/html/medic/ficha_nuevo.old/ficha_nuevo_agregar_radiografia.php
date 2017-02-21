<div class="modal fade" id="modal_radiografia" tabindex="-1" role="dialog" aria-labelledby="modal_radiografia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_radiografia">Radiograf&iacute;as de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_radiografia_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_rad_nombre_desc' name='{per}_lbl_rad_nombre_desc'>Nombre y/o descripci&oacute;n de la radiograf&iacute;a</label>
							<input type="text" class='form-control' id="{per}_rad_nombre_desc" name="{per}_rad_nombre_desc" value='{per_rad_nombre_desc}' />
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_rad_fecha' name='{per}_lbl_rad_fecha'>Fecha en la que se hizo el examen de radiograf&iacute;a</label>
							<input type="text" class='form-control' id="{per}_rad_fecha" name="{per}_rad_fecha" value='{per_rad_fecha}' />
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_rad_localizacion' name='{per}_lbl_rad_localizacion'>Lugar del cuerpo sobre el cual se hizo la radiograf&iacute;a</label>
							<input type="text" class='form-control' id="{per}_rad_localizacion" name="{per}_rad_localizacion" value='{per_rad_localizacion}' />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn bg-maroon" 
						onclick="js_ficha_set_radiografia('{div_show_result}','{fmex_codi}',
									document.getElementById('{per}_rad_nombre_desc'),
									document.getElementById('{per}_rad_fecha'),
									document.getElementById('{per}_rad_localizacion'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>