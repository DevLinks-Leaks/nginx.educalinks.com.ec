<!-- Modal Reenviar factura al SRI-->
<div class="modal fade" id="modal_resend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Respuesta de la Autorización (Reenvío)</h4>
            </div>
            <div class="modal-body" id="modal_resend_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reenviar factura al SRI-->
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
<!--Modal editar datos factura-->
<!-- Modal Enviar factura al SRI -->
<div class="modal fade" id="modal_send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Respuesta de la Autorización (Envío)</h4>
            </div>
            <div class="modal-body" id="modal_send_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reenviar factura al SRI-->
<form id="file_form" action="{ruta_html_finan}/gestionNotascredito/controller.php" enctype="multipart/form-data" method="post" target="_blank">
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
								onclick="carga_busquedaFacturas('resultadoProceso','{ruta_html_finan}/gestionNotascredito/controller.php')"></button>
						<div class="btn-group">
							<button type="button" 
									title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
									class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" onclick="js_gestionNotascredito_to_excel_busquedaFacturas('print_excel_all_data','mini');">Reporte reducido</a></li>
								<li><a href="#" onclick="js_gestionNotascredito_to_excel_busquedaFacturas('print_excel_all_data','completo');">Reporte completo</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de emisión, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. emisi&oacute;n</span>
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
					<div class="checkbox checkbox-info col-sm-2">
						<label for='ckb_gestionFactura_opc_adv'>
							<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='check_opc_avanzadas();'>
								<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
						</label>
					</div>
				</div>
				<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
					<div class='form-group'>
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
									<input type="checkbox" id='chk_tneto' name='chk_tneto' onclick='check_tneto();'>
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
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Estado de la factura'
								onmouseover='$(this).tooltip("show")'>
							<select class='form-control' id='cmb_estado' name='cmb_estado'>
								<option value=''>Seleccione...</option>
								<option value='A' selected='selected'>Activo</option>
								<option value='I'>Inactivo</option>
							</select>
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estadoElectronico'>Estado electr&oacute;nico:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Estado electr&oacute;nico de la factura'
								onmouseover='$(this).tooltip("show")'>
							<select class='form-control input-sm' id='cmb_estadoElectronico' name='cmb_estadoElectronico'>
								<option value='' selected='selected'>En gestión</option>
								<option value='AUTORIZADO'>Autorizado</option>
								<option value='NO AUTORIZADO'>No Autorizado</option>
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
		<h3 class="box-title">
			<button class="btn btn-default glyphicon glyphicon-refresh" type="button" 
					data-placement="right"
					title='Recargar consulta'
					onmouseover='$(this).tooltip("show")'
					onclick="carga_facturasPendientes('resultadoProceso','{ruta_html_finan}/gestionNotascredito/controller.php')"></button>
		</h3>
	</div>
	<div class="box-body">
		<div id="resultadoProceso">
			{tabla}
		</div>
	</div>
</div>