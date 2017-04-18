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
		<div class="col-sm-12">
			<span id='span_tiene_todos' name='span_tiene_todos' style='color:green;font-size:small;'></span>
		</div>
	</div>
	<br>
	<br>
    <div class="form-group">
		<div class="col-sm-12">
			<form id="frm_generaDeudasLotefrm" name="frm_generaDeudasLotefrm" method="post" action="" enctype="multipart/form-data">
				{deudas_checklist}
			</form>
		</div>
    </div>
    <div class="form-group">
		<div class="col-sm-12">
			<button id="btn_genera_deuda" type="button" class="btn btn-success" onclick="js_aniosPeriodo_generarDeudaLote('frm_generaDeudasLotefrm','{ruta_html_finan}/aniosPeriodo/controller.php')">
					<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Generar deudas</button>
		</div>
    </div>
    <div class="form-group">
		<div class="col-sm-12">
			<div class="progress">
				<div id="prog_bar_deudas" class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width:2em; width:0%;">
					0%
				</div>
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-sm-12">
			<div id="div_deudas_resultado">
			</div>
		</div>
    </div>
</div>