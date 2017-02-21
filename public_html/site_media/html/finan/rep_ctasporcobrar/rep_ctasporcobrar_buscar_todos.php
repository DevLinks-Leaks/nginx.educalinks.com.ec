<!-- Modal Msg-->
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
<!-- Modal Msg-->
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reporte de cierre de cuentas por cobrar</h4>
      </div>
      <div class="modal-body" id="modal_edit_body" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
       
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<form id="file_form" action="{ruta_html_finan}/rep_ctasporcobrar/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<div class="panel-group">  
		<div class="panel panel-info">
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












					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;'>F. corte de pagos:</label>
					<div id="div_comboCajeros" class="col-md-4 col-sm-5">
						<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
								   value="{txt_fecha_fin}" placeholder="dd/mm/yyyy" required="required">
					</div>
					<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='rep_ctasporcobrar_check_fecha();' checked>
				</div>
				<!--<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;'>Cajero:</label>
					<div id="div_comboCajeros" class="col-md-4 col-sm-5">
						{combo_cajas}
					</div>
				</div>-->
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
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="cursos" style='text-align: right;'>Producto:</label>
					<div class="col-md-4 col-sm-5">
						{cmb_producto}
					</div>
				</div>
				<!--<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="cursos" style='text-align: right;'>Deudas:</label>
					<div class="col-md-4 col-sm-5">
						<div id="resultadoCursos" class='checkbox'>							
							<input type="radio" id="rdb_quienes" name="rdb_quienes" value="PC"> Por cobrar/Abonadas
							<input type="radio" id="rdb_quienes" name="rdb_quienes" value="P" > Pagadas
							<input type="radio" id="rdb_quienes" name="rdb_quienes" value="T" checked> Todas
						</div>
					</div>
				</div>-->
			</div>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-body">
			<div class="grid">
				<div class="row">
					<div class="col-sm-12">
						<div class="grid" style= "display: inline-block; overflow: hidden; vertical-align: middle; width: 100%;">
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
														onclick=" js_rep_ctasporcobrar_carga_rpte('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_resumen')"></button>
												</td>
												<td align='center'>
													<button 
														type="button"
														class="btn bg-olive fa fa-file-excel-o"
														onclick=" js_rep_ctasporcobrar_carga_rpte_xls('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_resumen')"></button>
												</td>
											</tr>
											<tr><td>
													<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - mensual</label>
												</td>
												<td align='center'><button 
														type="button"
														class="btn btn-danger fa fa-file-pdf-o"
														onclick=" js_rep_ctasporcobrar_carga_rpte('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_mensual')"></button>
												</td>
												<td align='center'>
													<button 
														type="button"
														class="btn bg-maroon fa fa-file-excel-o"
														onclick=" js_rep_ctasporcobrar_carga_rpte_xls('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_mensual')"></button>
												</td>
											</tr>
											<tr><td>
													<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - curso</label>
												</td>
												<td align='center'><button 
														type="button"
														class="btn btn-primary fa fa-file-pdf-o"
														onclick=" js_rep_ctasporcobrar_carga_rpte('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_curso')"></button>
												</td>
												<td align='center'>
													<button 
														type="button"
														class="btn btn-info fa fa-file-excel-o"
														onclick=" js_rep_ctasporcobrar_carga_rpte_xls('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_curso')"></button>
												</td>
											</tr>
											<tr><td>
													<label class="codigoNivel_busq" for="comboUsuarios">Reporte de deudores - curso (detallado)</label>
												</td>
												<td align='center'>
													<button type="button" class='btn bg-navy' id='btn_selectRept_excel' name='btn_selectRept_excel' 
															onclick="js_rep_ctasporcobrar_carga_rpte('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_curso_detalle')">
															<span class='fa fa-file-pdf-o'></span>
													</button>
												</td>
												<td align='center'>
													<button type="button" class='btn bg-purple' id='btn_selectRept_excel' name='btn_selectRept_excel' 
															onclick="js_rep_ctasporcobrar_carga_rpte_xls('modal_edit_body','{ruta_html_finan}/rep_ctasporcobrar/controller.php','print_deudores_curso_detalle')">
															<span class='fa fa-file-excel-o'></span>
													</button>
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
	</div>
</form>