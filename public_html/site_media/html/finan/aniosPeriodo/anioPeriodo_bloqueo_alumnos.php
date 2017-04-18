<div id="frm_generaDeudasLote" class="form-horizontal" >
	<div class="form-group">
        <div class="col-sm-2">
			<label for="cursos">Periodo:</label>
		</div>
		<div class="col-sm-10">
			{combo_periodo}
		</div>
    </div>
	<div class="form-group">
		<div class="col-sm-2">
			<label for="cursos">Curso:</label>
		</div>
		<div class="col-sm-10">
			<div id="resultadoCursos" >
				{combo_curso}
			</div>
		</div>
	</div> 
	<div class="form-group">
		<div class="col-sm-2">
			<label for="alumnos">Alumnos:</label>
		</div>
		<div class="col-sm-10">
			<div id="resultadoAlumnos" >
				{combo_alumnos}
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2">
			<label for="alumnos">Motivo:</label>
		</div>
		<div class="col-sm-10">
			{combo_motivo}
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2">
			<label for="cursos">Opción a bloquear:</label>
		</div>
		<div class="col-sm-10">
			{combo_opcion_a_bloquear}
		</div>
	</div> 
	<div class="form-group">
		<div class="col-sm-12">
			<span id='span_tiene_todos' name='span_tiene_todos' style='color:green;font-size:small;'></span>
		</div>
	</div>
	<br>
    <div class="form-group">
		<div class="col-sm-12">
			<button id="btn_bloqueo_alumnos" type="button" class="btn btn-default" onclick="js_aniosPeriodo_bloquear('div_lista_bloqueados','{ruta_html_finan}/aniosPeriodo/controller.php')">
					<span style="color:red;" class='fa fa-ban'></span>&nbsp;Bloquear</button>
		</div>
    </div>
    <div class="form-group">
		<div class="col-sm-12">
			<div id="div_lista_bloqueados">
				{tbl_listado_bloqueo_alumnos}
			</div>
		</div>
    </div>
</div>