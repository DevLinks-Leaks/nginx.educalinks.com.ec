<div class="modal fade" id="modal_ex_lab_clinico" tabindex="-1" role="dialog" aria-labelledby="modal_ex_lab_clinico" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_ex_lab_clinico">Ex&aacute;menes de laboratorio cl&iacute;nico de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_ex_lab_clinico_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_lab_nombre' name='{per}_lbl_lab_nombre'>Examen cl&iacute;nico</label>
							<div id="div_cmb_lab_nombre" name="div_cmb_lab_nombre">{cmb_ex_lab_clinico_nombre}</div>
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_lab_fecha' name='{per}_lbl_lab_fecha'>Fecha en la que se hizo el examen cl&iacute;nico</label>
							<input type="text" class='form-control' id="{per}_lab_fecha" name="{per}_lab_fecha" value='{per_lab_fecha}' />
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_lab_resultado' name='{per}_lbl_lab_resultado'>Resultados del examen cl&iacute;nico</label>
							<input type="text" class='form-control' id="{per}_lab_resultado" name="{per}_lab_resultado" value='{per_lab_resultado}' />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn bg-olive" 
						onclick="js_ficha_set_ex_lab_clinico('{div_show_result}','{fmex_codi}',
									document.getElementById('cmb_lab_{per}'),
									document.getElementById('{per}_lab_resultado'),
									document.getElementById('{per}_lab_fecha'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>