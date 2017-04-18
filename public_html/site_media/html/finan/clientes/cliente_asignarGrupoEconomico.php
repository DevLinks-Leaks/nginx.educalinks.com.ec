<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Modificar Grupo Económico del estudiante</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-6">
			<input type="hidden" class="form-control" name="codigoGrupoEconomico" id="codigoGrupoEconomico" value="{codigoGrupoEconomico}" required="required">
			<input type="hidden" class="form-control" name="codigoEstudiante" id="codigoEstudiante" value="{codigoEstudiante}" required="required">
			<label for="nombreGrupoEconomico" class='control-label'><b>Grupo econ&oacute;mico actual del estudiante</b></label>
			<input type="text" readonly class="form-control" name="nombreGrupoEconomico" id="nombreGrupoEconomico" value="{nombreGrupoEconomico}" required="required">
		</div>
	</div>
	<br>
	<div {display_cmb_grupoEconomico} class="row">
		<div class="col-sm-6">
			<label for="combo_grupoEconomico" class='control-label'><b>Seleccione nuevo grupo econ&oacute;mico</b></label>
			{combo_grupoEconomicos}
		</div>
	</div>
	<div {display_ingreso_familiar} class="row">
		<div class="col-sm-6">
			<label for="txt_ge_ingresoFamiliar" class='control-label'><b>Ingreso financiero mensual familiar</b></label>
			<input type="text" class="form-control" name="txt_ge_ingresoFamiliar" id="txt_ge_ingresoFamiliar" value="{txt_ge_ingresoFamiliar}" required="required">
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	<button type="button" class="btn btn-success" data-dismiss="modal" 
			onclick="asign_grupoEconomico('resultado','{ruta_html_finan}/clientes/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
</div>
