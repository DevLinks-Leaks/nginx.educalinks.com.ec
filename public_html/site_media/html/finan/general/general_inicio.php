<!-- Modal Reporte-->
<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Educalinks</h4>
			</div>
			<div class="modal-body" id='modal_msg_body'>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Reporte-->
<div class="form-horizontal">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
				<h3>Pagos</h3>

				<p>Listado de pagos recibidos</p>
				</div>
				<div class="icon">
					<i class="fa fa-list"></i>
				</div>
				<a href="../pagos/" class="small-box-footer">Ir a pagos <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-purple">
				<div class="inner">
				<h3>Reporte</h3>

				<p>De Cierre de Cuentas por Cobrar</p>
				</div>
				<div class="icon">
					<i class="fa fa-bookmark"></i>
				</div>
				<a href="../rep_ctasporcobrar/" class="small-box-footer">Ir a reportes <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
				<h3>CRM</h3>

				<p>Cobranza</p>
				</div>
				<div class="icon">
					<i class="fa fa-phone"></i>
				</div>
				<a href="../cobranza/" class="small-box-footer">Ir a CRM Cobranza <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
				<h3>Clientes</h3>

				<p>Listado de estudiantes</p>
				</div>
				<div class="icon">
					<i class="fa fa-user"></i>
				</div>
				<a href="../clientes/" class="small-box-footer">Ir a Clientes <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<a href="../pagos/" class="small-box-footer"><span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span></a>
				
				<div class="info-box-content">
					<span class="info-box-text">Pagos recibidos hoy</span>
					<span class="info-box-number">{numPagos}</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-purple"><i class="fa fa-usd"></i></span>
				
				<div class="info-box-content">
					<span class="info-box-text">Total recuadado hoy</span>
					<span class="info-box-number"><small>$</small>{totalPagos}</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
				<a href="../VerDocumentosAutorizados/" class="small-box-footer"><span class="info-box-icon bg-red"><i class="icon icon-sri"></i></span></a>

				<div class="info-box-content">
				    <span class="info-box-text">Facturas autorizadas hoy</span>
				    <span class="info-box-number">{numFacturas}</span>
				</div>
            </div>
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
				
				<a href="../cierre_caja/" class="small-box-footer"><span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span></a>
				<div class="info-box-content">
				    <span class="info-box-text">Cajas abiertas</span>
				    <span class="info-box-number">{numCajas}</span>
				</div>
			</div>
        </div>
	</div>
</div>

<div class="form-horizontal">
	<div class="row">
		<div class="col-lg-9 col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Reporte de deudores</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
					</div>
				<!-- /.box-header -->
				<div class="box-body">
									  
					<form id="file_form" action="{ruta_html_finan}/general/controller.php" enctype="multipart/form-data" method="post" target="_blank">
						<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
						<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
						<div class="panel-group">  
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'>
											<div width='100%'>
												<span class="fa fa-search"></span>&nbsp;B&uacute;squeda
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
													class="btn btn-primary fa fa-search btn-sm"
													onclick="js_general_cargaDeudores('deudas_tablas','{ruta_html_finan}/general/controller.php')"></button>
												<!--<button 
													type="button"
													class="btn btn-default"
													onclick="js_general_to_excel_carga_reports_deudores('print_excel_all_data','completo')">
														<span style="color:green;" class="fa fa-file-excel-o"></span></button>
												<div id='busqueda_result_label' style='display:inline;color:darkred;font-size:large;'></div>-->
												<button 
													type="button"
													class="btn btn-default"
													onclick="carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores')">
														<span style="color:red;" class="fa fa-file-pdf-o"></span></button>
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
										<div class="form-group" style='display:none;' id='div_cmb_producto' name='div_cmb_producto'>
											<label class="col-md-2 col-sm-3 control-label" for="cmb_producto" style='text-align: right;'>Producto:</label>
											<div class="col-md-4 col-sm-5">
													{combo_producto}
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 col-sm-3 control-label" for="rdb_quienes" style='text-align: right;'>Deudas:</label>
											<div class="col-md-4 col-sm-5">
												<div id="resultadoCursos" class='checkbox'>							
													<input type="radio" id="rdb_quienes" name="rdb_quienes" value="PC"> Por cobrar/Abonadas
													<input type="radio" id="rdb_quienes" name="rdb_quienes" value="P" > Pagadas
													<input type="radio" id="rdb_quienes" name="rdb_quienes" value="A" > Anuladas
													<input type="radio" id="rdb_quienes" name="rdb_quienes" value="T" checked> Todas
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
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
							<div id='tabs_deudas_home' name='tabs_deudas_home' class="form-inline">
							<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#deudas_reportes" aria-controls="Reportes" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Reportes</a></li>
									<li role="presentation"><a href="#deudas_tablas" aria-controls="Tablas" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-th"></span> Tablas</a></li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane"  id="deudas_tablas">
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
									<div role="tabpanel" class="tab-pane active" id="deudas_reportes">
										<div class="grid" 
											style= "display: inline-block; overflow: hidden; vertical-align: middle; width: 100%;">
											<br />
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-bordered table-hover dataTable" id='tbl_reportes_generales'>
														<thead>
															<th>Reporte</th>
															<th>PDF</th>
															<th>HOJA DE CÁLCULO</th>
														</thead>
														<tbody>
															<tr><td>
																	<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - resumen</label>
																</td>
																<td align='center'><button 
																		type="button"
																		class="btn btn-success fa fa-file-pdf-o"
																		onclick=" carga_reports_deudores_rept('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_resumen')"></button>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn bg-olive fa fa-file-excel-o"
																		onclick=" carga_reports_deudores_rept_xls('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_resumen')"></button>
																</td>
															</tr>
															<tr><td>
																	<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - mensual</label>
																</td>
																<td align='center'><button 
																		type="button"
																		class="btn btn-danger fa fa-file-pdf-o"
																		onclick=" carga_reports_deudores_rept('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_mensual')"></button>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn bg-maroon fa fa-file-excel-o"
																		onclick=" carga_reports_deudores_rept_xls('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_mensual')"></button>
																</td>
															</tr>
															<tr><td>
																	<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - mensual (detallado)</label>
																</td>
																<td align='center'><button 
																		type="button"
																		class="btn btn-warning fa fa-file-pdf-o"
																		onclick=" carga_reports_deudores_rept('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_mensual_detalle')"></button>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn bg-orange fa fa-file-excel-o"
																		onclick=" carga_reports_deudores_rept_xls('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_mensual_detalle')"></button>
																</td>
															</tr>
															<tr><td>
																	<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - curso</label>
																</td>
																<td align='center'><button 
																		type="button"
																		class="btn btn-primary fa fa-file-pdf-o"
																		onclick=" carga_reports_deudores_rept('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_curso')"></button>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn btn-info fa fa-file-excel-o"
																		onclick=" carga_reports_deudores_rept_xls('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_curso')"></button>
																</td>
															</tr>
															<tr><td>
																	<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - curso (detallado)</label>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn bg-navy fa fa-file-pdf-o"
																		onclick=" carga_reports_deudores_rept('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_curso_detalle')"></button>
																</td>
																<td align='center'>
																	<button 
																		type="button"
																		class="btn bg-purple fa fa-file-excel-o"
																		onclick=" carga_reports_deudores_rept_xls('modal-deudoresbody','{ruta_html_finan}/general/controller.php','print_deudores_curso_detalle')"></button>
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
						</div>
						<!--<div class="box-footer">
							
						</div>-->
					</div>
				</div>
				<!-- <div class="box-footer text-center">
					
				</div> -->
			</div>
		</div>
		<div class="col-lg-3 col-sm-6">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_deudas_data" data-toggle="tab" aria-expanded="true">Pensiones pendientes</a></li>
					<li class=""><a href="#tab_deudas_valores" data-toggle="tab" aria-expanded="false">Ver todas</a></li>
					<!--<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					  Dropdown <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
					  <li role="presentation" class="divider"></li>
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
					</ul>
					</li>
					<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>-->
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_deudas_data">
						{deudaMiniTabla}
					</div>
					<div class="tab-pane" id="tab_deudas_valores">
						{deudaMiniTabla2}
					</div>
					<div style='text-align:center;'>
						<b>{totalPagadas}</b> Deudas pagadas<br>
						<b>{totalDeudas}</b> Deudas generadas</div>
				</div>
            </div>
			<!-- <div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Deudas generadas</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
				
				</div>
			</div> -->
		</div>
	</div>
</div>