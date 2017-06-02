<!--Modal editar datos factura-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
			<div id="modal_edit_body">
                ...
            </div>
        </div>
    </div>
</div>
<!--Modal /. editar datos factura-->
<!-- Modal envío y reenvío individual factura al SRI -->
<div class="modal fade" id="modal_send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Respuesta de Envío individual</h4>
            </div>
            <div class="modal-body" id="modal_send_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal envío y reenvío individual factura al SRI-->
<!-- Modal Envio y Reenvío por lote al SRI -->
<div class="modal fade" id="modal_lote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Resultado de Envio en lote</h4>
            </div>
            <div class="modal-body">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#modal_lote_body" aria-controls="modal_lote_body" role="tab" data-toggle="tab">Proceso</a></li>
					<li role="presentation"><a href="#lote_detail_body" aria-controls="lote_detail_body" role="tab" data-toggle="tab">Detalle</a></li>
				</ul>
				<div class="tab-content">
					<div id="modal_lote_body" role="tabpanel" class="tab-pane active" >
					</div>
					<div id="lote_detail_body" role="tabpanel" class="tab-pane">
						<div style='height:245px;overflow-y:scroll;'>
							<div class="box-body">
								<div class="box-group" id="accordion">
								<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
									<div class="panel box box-success">
										<div class="box-header with-border">
											<h4 class="box-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
													PAGADOS <span id="span_log_lote_autorizadas"></span>
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
											<div id="div_log_lote_autorizadas" class="box-body">
											</div>
										</div>
									</div>
									<div class="panel box box-danger">
										<div class="box-header with-border">
											<h4 class="box-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="collapsed" aria-expanded="false">
													CON ERRORES <span id="span_log_lote_errores"></span>
												</a>
											</h4>
										</div>
										<div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
											<div id="div_log_lote_errores" class="box-body">
											</div>
										</div>
									</div>
							    </div>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Envio por lote al SRI. Data string para envio al SRI, chartgrama y codigos-->
<form id="file_form" action="{ruta_html_finan}/convenio_pago2/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
	<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
		<div class="panel-heading">
			<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
			<a href="#/" class="pull-right" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a></h3>
		</div>
		<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-4 col-sm-12'>
						<button class="btn btn-primary fa fa-search" type="button" 
								data-placement="bottom"
								title='Buscar facturas'
								onmouseover='$(this).tooltip("show")'
								onclick="js_convenio_pago_carga_busquedaFacturas('resultadoProceso','{ruta_html_finan}/convenio_pago2/controller.php')"></button>
						<!--<div class="btn-group">
							<button type="button" 
									title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
									class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" onclick="js_gestionFactura_to_excel_busquedaFacturas('print_excel_all_data','mini');">Reporte reducido</a></li>
								<li><a href="#" onclick="js_gestionFactura_to_excel_busquedaFacturas('print_excel_all_data','completo');">Reporte completo</a></li>
							</ul>
						</div>-->
					</div>
					<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de inicio de cobro, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. inicio cobro</span>
							</span>				
							<span class="input-group-addon">
								<small>Inicio</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
										value="" placeholder="dd/mm/yyyy" >
						
							<span class="input-group-addon">
								<small>Fin</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
										value="{txt_fecha_fin}" placeholder="dd/mm/yyyy" >
						</div>
					</div>
					<div class="checkbox checkbox-info col-sm-2">
						<label for='ckb_gestionFactura_opc_adv'>
							<input type="checkbox" id='ckb_gestionFactura_opc_adv' name='ckb_gestionFactura_opc_adv' onclick='js_gestionFactura_check_opc_avanzadas();'>
								<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
						</label>
					</div>
				</div>
				<div id='div_gestionFactura_opc_adv' name='div_gestionFactura_opc_adv' class='collapse'>
					<div class='form-group' style="display:none;">
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_sucursal'>Sucursal:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='9999' min='1' class="form-control input-sm" name="txt_sucursal" id="txt_sucursal">
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ptoVenta'>Pto. Venta:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='9999' min='1' class="form-control input-sm" name="txt_ptoVenta" id="txt_ptoVenta" >
						</div>
					</div>
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Ref. Doc.:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='99999999999999' min='1' class="form-control input-sm" name="txt_ref_factura" id="txt_ref_factura">
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Producto:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Producto facturado'
								onmouseover='$(this).tooltip("show")'>
							{cmb_producto}
						</div>
					</div>
					
					<div class='form-group'>
						<!-- <div class="col-md-6 col-sm-10 col-md-offset-4 col-sm-offset-1"> -->
						<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1">
							<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
								 title='valor total neto, desde, hasta.'
								 onmouseover='$(this).tooltip("show")'>
								<span class="input-group-addon">
									<input type="checkbox" id='chk_tneto' name='chk_tneto' onclick='js_gestionFactura_check_tneto();'>
								</span>
								<span class="input-group-addon">
									<span style="text-align:left;font-size:small;font-weight:bold;">T. Neto</span>
								</span>				
								<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">de $</span>
								<input type="text" class="form-control input-sm" name="txt_tneto_ini" id="txt_tneto_ini" placeholder='0.00' disabled='disabled'>
								<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">a $</span>
								<input type="text" class="form-control input-sm" name="txt_tneto_fin" id="txt_tneto_fin"  placeholder='0.00' disabled='disabled'>
							</div>
						</div>
						<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1" id="div_fini" name="div_fini" >
							<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
								 title='Fecha de creación de deuda, desde, hasta.'
								 onmouseover='$(this).tooltip("show")'>
								<span class="input-group-addon">
									<input type="checkbox" id='chk_fecha_deuda' name='chk_fecha_deuda' onclick='js_gestionFactura_check_fechadeuda();'>
								</span>
								<span class="input-group-addon">
									<span style="text-align:left;font-size:small;font-weight:bold;">F. creaci&oacute;n deuda</span>
								</span>				
								<span class="input-group-addon">
									<small>Inicio</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_deuda_ini" id="txt_fecha_deuda_ini" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled'>
							
								<span class="input-group-addon">
									<small>Fin</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_deuda_fin" id="txt_fecha_deuda_fin" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled'>
							</div>
						</div>
					</div>
					<div class='form-group'  style="display:none;">
						<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1">
						</div>
						<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1" id="div_fini" name="div_fini" >
							<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
								 title='Fecha de autorización, desde, hasta.'
								 onmouseover='$(this).tooltip("show")'>
								<span class="input-group-addon">
									<input type="checkbox" id='chk_fecha_aut' name='chk_fecha_aut' onclick='js_gestionFactura_check_fechaAut();'>
								</span>
								<span class="input-group-addon">
									<span style="text-align:left;font-size:small;font-weight:bold;">F. autorizaci&oacute;n</span>
								</span>				
								<span class="input-group-addon">
									<small>Inicio</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_aut_ini" id="txt_fecha_aut_ini" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled'>
							
								<span class="input-group-addon">
									<small>Fin</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_aut_fin" id="txt_fecha_aut_fin" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled'>
							</div>
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
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Cod. estudiante:</label>
						<div class="col-md-4 col-sm-8"
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
					<div class='form-group'  style="display:none;">
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Estado de la factura'
								onmouseover='$(this).tooltip("show")'>
							<select class='form-control input-sm' id='cmb_estado' name='cmb_estado'>
								<option value=''>Seleccione...</option>
								<option value='P' selected='selected'>Pagado</option>
								<option value='PC'>Por cobrar</option>
								<option value='PV'>Por validar</option>
								<option value='A'>Anulado</option>
							</select>
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estadoElectronico'>Estado electr&oacute;nico:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Estado electr&oacute;nico de la factura'
								onmouseover='$(this).tooltip("show")'>
							<select class='form-control input-sm' id='cmb_estadoElectronico' name='cmb_estadoElectronico'>
								<option value='' selected='selected'>Todos en gestión (DNA's)</option>
								<option value='AUTORIZADO'>Autorizado</option>
								<option value='NO AUTORIZADO'>No Autorizado</option>
								<option value='NO ENVIADO'>No Enviado</option>
								<option value='PROCESANDOSE'>Procesándose</option>
								<option value='ERROR'>Error</option>
								<option value='DEVUELTA'>Devuelta</option>
								<option value='CONTINGENTE'>Contingente</option>
								<option value='MFANF'>MFANF</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-header with-border">
		<div class='col-sm-12'>
			<button class="btn btn-default" type='button' id='ckb_codigoDocumento_head2' name='ckb_codigoDocumento_head2'
				onClick='js_convenio_pago_select_all2( )'>
				<span id='span_codigoDocumento_head1' class="fa fa-square-o"></span>&nbsp;
				<span id='span_codigoDocumento_head2'>Marcar todos</span></button>
			<button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_lote' 
				id='btn_convenio_pago_pay' name='btn_convenio_pago_pay' disabled='disabled'
				onclick="js_convenio_pago_pagar_PorLote('modal_lote_body','{ruta_html_finan}/convenio_pago2/controller.php')" {disabled_enviar_lote}>
				<span class="fa fa-handshake-o"></span>&nbsp;Pagar deudas seleccionadas</button>
		</div>
	</div>
	<div class="box-body">
		<div id="resultadoProceso">
			{tabla}
		</div>
	</div>
</div>