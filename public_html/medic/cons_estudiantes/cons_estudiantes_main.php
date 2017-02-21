<div class="panel panel-info">
	<div class="panel-heading">
		<table style='width:100%'>
			<tr>
				<td style='text-align:left;'>
					Alumno
				</td>
				<td style='text-align:right;'>
					<button class="btn btn-info btn-md" data-toggle="modal" data-target="#modal_busqueda">
						<span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>
				</td>
			</tr>
		</table>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_codi" name="alum_codi" placeholder="Código alumno" aria-describedby="alum_codi_addon" readonly>
			</div>
			<div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_nombre" name="alum_nombre" placeholder="Nombres" aria-describedby="alum_nombre_addon" readonly>
			</div>
			<div class="col-md-4 col-md-offset-0 col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-6 bottom_10">
				<input type="text" class="form-control" id="alum_curso" name="alum_curso" placeholder="Curso" aria-describedby="alum_curso_addon" readonly>
				<input type="hidden" class="form-control" id="curs_para_codi" name="curs_para_codi">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_telf" name="alum_telf" placeholder="Teléfono" aria-describedby="alum_telf_addon" readonly>
			</div>
			<div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
				<input placeholder="Dirección" id="alum_domi" name="alum_domi" class="form-control" aria-describedby="alum_domi_addon" readonly>
			</div>
			<?php /*$dev_visible = ""; if ($_SESSION['usua_codi'] != 'ADMIN' ){ $dev_visible = "style='display:none;'"; } */ ?>
			<div class="col-md-4 col-md-offset-0 col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-6 bottom_10" style='text-align:right;margin-top:2px;'>
				<div style='vertical-align:middle;' id='client_options' <?php echo $dev_visible; ?>></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bottom_10">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bottom_10">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-bell"></span> Alergias o Restricciones</h3>
					</div>
					<div class="panel-body" id="alum_alergias_div">
						No contiene restricciones de medicamentos o alergias.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Datos de Horario</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<div class="input-group" id="div_select_materias">
					<span class="input-group-addon" id="mate_alum_curso_addon">Materia:</span>
					<select class="form-control" id="mate_alum_curso" name="mate_alum_curso">
						<option value="" data_prof_codi="0">Seleccione...</option>
					</select>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
				<div class="input-group">
					<span class="input-group-addon" id="prof_nomb_addon">Profesor:</span>
					<input type="text" class="form-control" id="prof_nomb" name="prof_nomb" placeholder="Profesor" aria-describedby="prof_nomb_addon" readonly>
				</div>
				<input type="hidden" class="form-control" id="prof_codi" name="prof_codi">
			</div>
			<div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
				<div class="input-group">
					<span class="input-group-addon" id="reloj_addon">Hora:</span>
					<input type="text" class="form-control" id="reloj" name="reloj" aria-describedby="reloj_addon" readonly>                 
				</div>                
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Datos del Tratamiento</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<div class="input-group" id="div_select_medicamentos">
					<?php
					include("../clases/medicamentos.php");
					$medicamentos = new Medicamentos();
					$medicamentos->get_all_medicamentos();
					?>
					<span class="input-group-addon" id="medicamentos_addon">Medicamento:</span>
					<select class="form-control" id="medicamentos" name="medicamentos" onchange="carga_stock('stock_div','../ajax_script/medicamentos.php',this.value);">
						<option value="">Seleccione...</option>
						<?php
						foreach($medicamentos->rows as $medicamento){
						?>
						<option value="<?=$medicamento['med_codigo'];?>"><?=$medicamento['med_descripcion'];?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<div class="input-group">
					<span class="input-group-addon" id="cant_med_addon">Cantidad:</span>
					<input type="text" class="form-control" id="cant_med" name="cant_med" placeholder="Cantidad" aria-describedby="cant_med_addon">
				</div>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10" id="stock_div">
				<div class='input-group'>
					<span class='input-group-addon' id='stock_med_addon'>Stock:</span>
					<input type='text' class='form-control' id='stock_med' name='stock_med' placeholder='Stock' aria-describedby='stock_med_addon' value='0' readonly>
				</div>
			</div>
			<div class="col-md-1 col-xs-12 col-sm-6 bottom_10">
				<div class='input-group'>
					<button class="btn btn-success" id="btn_agregar" data-loading-text='Agregando...' ><span class="glyphicon glyphicon-plus"></span> Agregar</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bottom_10">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bottom_10">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-bell"></span> Medicinas Entregadas</h3>
					</div>
					<div class="panel-body" id="tratamientos_div">
						<table class="table table-stripped table-hover table-responsive" id="table_tratamientos" data-page-length='5'>
							<thead>
								<tr>
									<th>#</th>
									<th>Medicina</th>
									<th>Cantidad</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-12 bottom_10">
				<div class="input-group">
					<span class="input-group-addon" id="motivos_addon">Motivo:</span>
					<input type="text" class="form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="..." id="motivo" name="motivo" aria-describedby="motivos_addon" />
				</div>
				<input type="hidden" class="form-control" autocomplete="off" spellcheck="false" placeholder="Motivo" id="motivo_id" name="motivo_id" aria-describedby="motivos_addon" />
			</div>
			<div class="col-md-4 col-xs-12 col-sm-12 bottom_10">
				<div class="input-group">
					<span class="input-group-addon" id="observaciones_addon">Observaciones:</span>
					<textarea rows="3" class="form-control" maxlength="250" id="observaciones" name="observaciones" placeholder="(250 caracteres max.)"></textarea>
				</div>
			</div>
			<div class="col-md-2 col-xs-12 col-sm-12 bottom_10">
				<div class="row">
					<div class="col-md-12 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<label>
								<input type="checkbox" id="compr_tipo" name="compr_tipo" /> Compr. Salida
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<button class="btn btn-primary" id="btn_guardar" data-fail-text='<span class="glyphicon glyphicon-floppy-disk"></span> Guardar' data-loading-text='Guardando...' data-complete-text='<span class="glyphicon glyphicon-floppy-disk"></span> Guardado'><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Atenciones de Hoy</h3>
	</div>
	<div class="panel-body" id="atenciones_div">
		<?php include("../tabla_atenciones_hoy.php");?>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_busqueda" tabindex="-1" role="dialog" aria-labelledby="modal_busquedaLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_busquedaLabel">Buscar Alumno</h4>
			</div>
			<div class="modal-body" id="modal_busquedabody">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_ficha_medica" tabindex="-1" role="dialog" aria-labelledby="modal_busquedaLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_busquedaLabel"><i class="fa fa-clipboard"></i>&nbsp;Listado de fichas médicas del paciente</h4>
			</div>
			<div class="modal-body" id="modal_ficha_medica_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>