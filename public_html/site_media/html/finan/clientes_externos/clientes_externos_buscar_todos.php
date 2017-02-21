<!-- Modal Visor Estado de cuenta-->
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#f4f4f4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" >Estado de cuenta</h4>
			</div>
			<div class="modal-body" id="modal_showDebtState_body" style="background-color:#f4f4f4;">
			...
			</div>
			<div class="modal-footer" style="background-color:#f4f4f4;">
				<button type="button" class="btn btn-primary" data-dismiss="modal" 
						onclick="print_pdf('{ruta_html_finan}/clientes_externos/controller.php')"><span class='glyphicon glyphicon-print'></span>&nbsp;Imprimir</button>
				<!--<a href="/reporte/estadoCuenta/{codigoAlumno}/{periodo}/{fechaInicio}/{fechaFin}" class="btn btn-primary" role="button" >Imprimir</a>-->
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="modal_asign_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar-->
<!-- Modal Asignar Grupo Economico-->
<div class="modal fade" id="modal_showSetGrupoEconomico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="modal_showSetGrupoEconomico_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar Grupo Economico-->
<!-- Modal Asignar representante-->
<div class="modal fade" id="modal_asign_repr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Asignar representante</h4>
			</div>
			<div class="modal-body" id='div_asign_repr' name='div_asign_repr'>
			...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar representante-->
<form id="file_form" action="{ruta_html_finan}/clientes_externos/controller.php" enctype="multipart/form-data" method="post" target="_blank">
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
							onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes_externos/controller.php')"></button>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Cod. cliente:</label>
					<div class="col-md-3 col-sm-8"
							data-placement="bottom"
							title='C&oacute;digo del representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_cod_cliente" id="txt_cod_cliente" >
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nombre cliente:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nombre del cliente representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_nom_cliente" id="txt_nom_cliente" >
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
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_cliente'>Id. Cliente:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_id_cliente" id="txt_id_cliente" >
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1" style='display:none;'>
						<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
							 title='valor total neto, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha_nac' name='chk_fecha_nac' onclick='js_clientes_check_fecha_nac();'>
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
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-header with-border">
	    <h3 class="box-title">
			<span id='span_button_return' name='span_button_return'>Clientes externos</span>
			<span id='span_button_save_person' name='span_button_save_person'></span></h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>