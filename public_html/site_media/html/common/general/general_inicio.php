<!-- Modal Reporte-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog-900">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Visor de Reporte de Deudores</h4>
			</div>
			<div class="modal-body" >
				<div>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#modal-deudoresbody" aria-controls="Reporte Deudores" role="tab" data-toggle="tab">Reporte de Deudores</a></li>
						<li role="presentation"><a href="#modal_deudores_resumen" aria-controls="Reporte Deudores - Resumen" role="tab" data-toggle="tab">Reporte de Deudores - Resumen</a></li>
						<li role="presentation"><a href="#modal_deudores_mensual" aria-controls="Reporte Deudores - Mensual" role="tab" data-toggle="tab">Reporte de Deudores - Mensual</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="modal-deudoresbody">...</div>
						<div role="tabpanel" class="tab-pane" id="modal_deudores_resumen">...</div>
						<div role="tabpanel" class="tab-pane" id="modal_deudores_mensual">...</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Reporte-->
<div class="panel-group">  
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'>
					<div width='100%'>
						<span class="glyphicon glyphicon-option-vertical"></span>  B&uacute;squeda
					</div>
				</a>
			</h3>
		</div>
		<div class="panel-body"  id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-4 col-sm-12">
						<button 
							type="button"
							class="btn btn-primary glyphicon glyphicon-search btn-sm"
							onclick="js_general_cargaDeudores('deudas_tablas','{ruta_html}/general/controller.php')"></button>
						<div id='busqueda_result_label' style='display:inline;color:darkred;font-size:large;'></div>
					</div>
					<div class="col-md-6 col-sm-10">
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de vencimiento, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. vencimiento</span>
							</span>				
							<span class="input-group-addon">
								<small>Inicio</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
										value="" placeholder="dd/mm/yyyy" disabled='disabled'>
						
							<span class="input-group-addon">
								<small>Fin</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
										value="" placeholder="dd/mm/yyyy" disabled='disabled'>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;'>Per&iacute;odo:</label>
					<div class="col-md-4 col-sm-5">
						{combo_periodo}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="nivelEconomico" style='text-align: right;'>Nivel econ.:</label>
					<div class="col-md-4 col-sm-5">
						<div id="resultadoNivelEcon">
							{combo_nivel}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="cursos" style='text-align: right;'>Curso:</label>
					<div class="col-md-4 col-sm-5">
						<div id="resultadoCursos">
							{combo_cursos}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
<div class="box box-default">
	<div class="box-header with-border">
	</div>
	<div class="box-body">
		<div class="grid" 
			style= "display: inline-block; overflow: hidden; vertical-align: middle; width: 100%;">
			<div class="row">
				<div class="col-sm-12">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
				</div>
			</div>
		</div>
		<div class="form-inline">
		<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#deudas_tablas" aria-controls="Tablas" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-th"></span> Tablas</a></li>
				<li role="presentation"><a href="#deudas_reportes" aria-controls="Reportes" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Reportes</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active"  id="deudas_tablas">
					<br>
					<div class="grid" 
						style= "display: inline-block; overflow: hidden; vertical-align: middle; width: 100%;">
						<div class="row">
							<div class="col-sm-12">
								{tabla}
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="deudas_reportes">
					<div class="grid" 
						style= "display: inline-block; overflow: hidden; vertical-align: middle; width: 100%;">
						<br />
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-hover dataTable" id='tbl_reportes_generales'>
									<thead>
										<th>Reporte</th>
										<th>PDF</th>
									</thead>
									<tbody>
										<tr><td>
												<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores</label>
											</td>
											<td align='center'><button 
													type="button"
													class="btn btn-danger glyphicon glyphicon-print"
													onclick=" carga_reports_deudores('modal-deudoresbody','{ruta_html}/general/controller.php','print_deudores')"></button>
											</td>
										</tr>
										<tr><td>
												<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - resumen</label>
											</td>
											<td align='center'><button 
													type="button"
													class="btn btn-warning glyphicon glyphicon-print"
													onclick=" carga_reports_deudores_resumen('modal-deudoresbody','{ruta_html}/general/controller.php','print_deudores_resumen')"></button>
											</td>
										</tr>
										<tr><td>
												<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - mensual</label>
											</td>
											<td align='center'><button 
													type="button"
													class="btn btn-primary glyphicon glyphicon-print"
													onclick=" carga_reports_deudores_mensual('modal-deudoresbody','{ruta_html}/general/controller.php','print_deudores_mensual')"></button>
											</td>
										</tr>
										<tr><td>
												<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - curso</label>
											</td>
											<td align='center'><button 
													type="button"
													class="btn btn-success glyphicon glyphicon-print"
													onclick=" carga_reports_deudores_mensual('modal-deudoresbody','{ruta_html}/general/controller.php','print_deudores_curso')"></button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		Deudores.
	</div>
</div>