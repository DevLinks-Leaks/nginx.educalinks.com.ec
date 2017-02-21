<!-- Modal CRM-->
<div class="modal fade" id="modal_crm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="modal_crm_body">
				...
			</div>
		</div>
	</div>
</div>
<!-- Modal CRM-->
<form id="file_form" action="{ruta_html_finan}/cobranza/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
	<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
		<div class="panel-heading">
			<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
				<a href="#/" class="pull-right" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>
			</h3>
		</div>
		<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-1 col-sm-12'>
					<button class="btn btn-primary fa fa-search" type="button" 
							data-placement="bottom"
							title='Buscar facturas'
							onmouseover='$(this).tooltip("show")'
							onclick="js_cobranza_buscar('resultado','{ruta_html_finan}/cobranza/controller.php')"></button>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Cod. estudiante:</label>
					<div class="col-md-3 col-sm-8"
							data-placement="bottom"
							title='C&oacute;digo del representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_cod_cliente" id="txt_cod_cliente" >
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nombre estudiante:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nombre del cliente representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_nom_cliente" id="txt_nom_cliente" >
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1">
						<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
							 title='valor total neto, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha_nac' name='chk_fecha_nac' onclick='js_cobranza_check_fecha_nac();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. nacimiento</span>
							</span>				
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">de</span>
							<input type="text" class="form-control input-sm" name="txt_fecha_nac_ini" id="txt_fecha_nac_ini" placeholder='dd/mm/yyyy' disabled='disabled'>
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">a</span>
							<input type="text" class="form-control input-sm" name="txt_fecha_nac_fin" id="txt_fecha_nac_fin" placeholder='dd/mm/yyyy' disabled='disabled'>
						</div>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_estudiante'>Id. estudiante:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_id_estudiante" id="txt_id_estudiante" >
					</div>
				</div>
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_id_titular" id="txt_id_titular" >
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_titular'>Nombre titular:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nombre del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_nom_titular" id="txt_nom_titular" >
					</div>
				</div>
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Período:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Período en el que se generó la deuda'
							onmouseover='$(this).tooltip("show")'>
						{cmb_periodo}
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Grupo Económico:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='grupo Económico'
							onmouseover='$(this).tooltip("show")'>
						{cmb_grupoEconomico}
					</div>
				</div>
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Nivel Económico:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nivel económico'
							onmouseover='$(this).tooltip("show")'>
						<div id='resultadoNivelEcon' name='resultadoNivelEcon'>{cmb_nivelEconomico}</div>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Curso Paralelo:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Curso del alumno'
							onmouseover='$(this).tooltip("show")'>
						<div id='resultadoCursos' name='resultadoCursos'>{cmb_curso}</div>
					</div>
				</div>
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Estado de la factura'
							onmouseover='$(this).tooltip("show")'>
						<select class='form-control input-sm' id='cmb_estado' name='cmb_estado'>
							<option value='A' selected='selected'>Activo</option>
							<option value='I'>Inactivo</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-header with-border">
	    <h3 class="box-title">Cobranza</h3>
		<div class="pull-right">
			<a class="btn btn-default" href='../../finan/rep_mediacion/'>
				<span style='color:red;' class="fa fa-bookmark-o"></span>&nbsp;Reporte de mediación</a>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>