<div id="frm_generaDeudasLote" class="form-medium" >
	<div class="form-group">
        <label for="cursos">Periodo:</label>
        {combo_periodo}
    </div>
	<div class="form-group">
		<label for="cursos">Curso:</label>
		<div id="resultadoCursos" >
			{combo_curso}
		</div>
	</div> 
	<div class="form-group">
		<label for="alumnos">Alumnos:</label>
		<div id="resultadoAlumnos" >
			{combo_alumnos}
		</div>
	</div> 
	<span id='span_tiene_todos' name='span_tiene_todos' style='color:green;font-size:small;'></span>
	<br>
	<br>
    <div class="form-group">
		<form id="frm_generaDeudasLotefrm" name="frm_generaDeudasLotefrm" method="post" action="" enctype="multipart/form-data">
			{deudas_checklist}
		</form>
    </div>
    <div class="progress">
		<div id="prog_bar_deudas" class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width:2em; width:0%;">
			0%
		</div>
    </div>
    <div id="div_deudas_resultado">
    </div>
</div>