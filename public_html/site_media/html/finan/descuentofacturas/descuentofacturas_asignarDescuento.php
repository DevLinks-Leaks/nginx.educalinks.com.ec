<!-- Modal guardar cambios-->
<div class="modal fade" id="modal_save_changes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-save"></i>&nbsp;Guardar cambios</h4>
            </div>
            <div class="modal-body" id="modal_save_changes_body">
            </div>
        </div>
    </div>
</div>
<!-- Modal guardar cambios-->
<!-- Modal Información-->
<div class="modal fade" id="modal_infoNumFact" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-question-circle'></span>&nbsp;Acerca de Información general de registro de deuda</h4>
			</div>
			<div class="modal-body" id="modal_infoNumFact_body" style='height:400px;overflow-y:scroll;' >
				<p>*Sólo se pueden realizar cambios a deudas sin abonos.</p>
				<table class='table table-striped table-bordered'>
					<tr style='vertical-align:top;'><td width='15%'><b>Fecha inicio cobro:</b> </td><td>Fecha de inicio de cobro de la deuda.</td></tr>
					<tr style='vertical-align:top;'><td><b>Fecha vencimiento:</b> </td><td>Fecha límite en la que la deuda no es considerada como vencida.</td></tr>
					<tr style='vertical-align:top;'><td><b>Días prontopago:</b> </td><td>Número de días en los que es el descuento del pronto pago es vigente sobre la deuda. Empieza a contar desde la fecha inicio de cobro. El porcentaje de prontopago es una configuración global y se puede cambiar entrando a la Configuración de colecturía.</td></tr>
					<tr style='vertical-align:top;'><td><b>No. Factura:</b> </td><td>Números de facturas que se le puede asignar a una deuda. Tiene que tener visto en <b>Generar factura</b>. Los números de facturas enlistados son los números de facturas reciclados en los reversos de pagos y el número de factura siguiente del punto de venta seleccionado.</td></tr>
					<tr style='vertical-align:top;'><td><b>Generar factura:</b> </td><td>Marcar si la deuda va a generar factura cuando se realice el pago. Si no lo tiene marcado, irá directamente a la bandeja de Documentos autorizados. Ahí, filtrar el Estado electrónico como 'Deudas sin facturas' para poderlas visualizar.</td></tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Información-->
<div class="modal fade" id="modal_select_sucursal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-institution"></i>&nbsp;Sucursal</h4>
            </div>
            <div class="modal-body" id="modal_select_sucursal_body">
				<div class='form-horizontal'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='input-group input-group-sm'>
								{combo_sucursal}
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" onclick="js_descuentofactura_select_sucursal_followed();">Seleccionar</button>
								</span>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal guardar cambios-->
<!-- Modal guardar cambios-->
<div class="modal fade" id="modal_select_ptoVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-tent"></i>&nbsp;Punto de venta</h4>
            </div>
            <div class="modal-body" id="modal_select_ptoVenta_body">
				<div class='form-horizontal'>
					<div class='row'>
						<div class='col-sm-12'>
							<div id='div_cmb_ptoVenta' class='input-group input-group-sm'>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal guardar cambios-->
<!-- Modal guardar cambios-->
<div class="modal fade" id="modal_select_numeroFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="icon icon-sri"></i>&nbsp;Numero Factura</h4>
            </div>
            <div class="modal-body" id="modal_select_numeroFactura_body">
				<div class='form-horizontal'>
					<div class='row'>
						<div class='col-sm-12'>
							<div id='div_cmb_numeroFactura' class='input-group input-group-sm'>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal guardar cambios-->
<!-- Modal Asignar descuento-->
<div class="modal fade bs-example-modal-md" id="modal_addDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#f4f4f4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-percent'></i>&nbsp;Asignar Descuento</h4>
			</div>
			<div class="modal-body" id="modal_addDiscount_body" style="background-color:#f4f4f4;">
				<div class="form-horizontal">
					<div class="form-group">
						<div class="col-md-4">
							Tipo de descuento
						</div>
						<div class="col-md-8">
							{combo_descto}
						</div>
					</div>
					<div id='div_descuentoInfo'>
						<div class="form-group">
							<div class="col-md-4">
								Porcentaje dscto.
							</div>
							<div class="col-md-4">
								 <div class="input-group">
									<div id="div_porcentaje_descto"><input type="text" class="form-control input-sm" name="porcentaje_descto" id="porcentaje_descto" 
										placeholder="0.00" required="required"></div>
										<span class="input-group-addon" id="basic-addon">%</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4"> 
								<label for="diasvalidez" class="control-label"><b>Días de validez</b></label>
								<div id="EducaLinksHelperCliente" style="display:inline;font-size:small;text-align:left;vertical-align:middle;">
									<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>Es el tiempo en el que el descuento es válido, a partir del día de inicio de cobro de una deuda.</div>" data-placement="top"><span class="fa fa-info-circle"></span></a>
								</div>
								<div id="EducaLinksHelperCliente" style="display:inline;font-size:small;text-align:left;vertical-align:middle;">
									<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>Deje el número de días en '0' para que el sistema reconozca que el descuento no tiene límite en el número de días de validez.</div>" data-placement="bottom"><span class="fa fa-info-circle"></span></a>
								</div>
							</div>
						<div class="col-md-4"> 
							<input type="text" class="form-control input-sm" id="diasvalidez" name="diasvalidez" value="0">
						</div>
						</div>
						<div class="form-group">
							<div class="col-md-12"> 
								<label for="aplicaprontopago_add" class="checkbox-inline">
									<input type="checkbox" id="ckb_prontopago" name="ckb_prontopago" />
									Aplica Prontopago
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color:#f4f4f4;">
				<button type="button" class="btn btn-default" data-dismiss='modal'>Cerrar</button>
				<button type="button" class="btn btn-default"
					onclick="js_descuentofacturas_agregar_descuento()"><i class='fa fa-plus'></i>&nbsp;Agregar</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Asignar descuento-->
<div id="asignaResidencia_cliente" class="form-horizontal" role="form">
    <input type="hidden" class="form-control" name="codigo" id="codigo" placeholder="codigo" value="{clie_codigo}" required="required">
    <div class="form-group"> 
        <div class="col-sm-1">
			<label for="nombres">Código deuda</label>
		</div>
		<div class="col-sm-6">
			<input type="text" readonly class="form-control input-sm" name="txt_desc_deuda" id="txt_desc_deuda" placeholder="Descripción de deuda" value="" required="required">
		</div>
		<div class="col-sm-2">
			<label for="nombres">Método de descuento</label>
		</div>
		<div class="col-sm-3">
			<select class="form-control input-sm" name="cmb_tipo_descuento" id="cmb_tipo_descuento" placeholder=""  onfocus='js_descuentofactura_check_pvfalse();'>
				<option value="desc_sobre" {desc_sobre}>- Descuento sobre descuento -</option>
				<option value="desc_sumado" {desc_sumado}>- Descuento sumado -</option>
			</select>
		</div>
    </div>
	<div class="form-group"> 
        <div class="col-sm-1">
			<label for="nombres">Cliente</label>
		</div>
		<div class="col-sm-6">
			<input type="text" readonly class="form-control input-sm" name="nombres" id="nombres" placeholder="Ingrese los nombres" value="{clie_nombres} {clie_apellidos}" required="required">
		</div>
    </div>
    <div class="form-group"> 
        <div class="col-md-12"> 
			<hr>
			<h4>Información general de registro de deuda
			<div class="pull-right">
				<button type="button" class="btn btn-default"
					aria-hidden='true' data-toggle='modal' data-target='#modal_infoNumFact'
					title='Acerca de "Información general de registro de deuda"' onmouseover='$(this).tooltip("show");' data-placement='left'>
					&nbsp;<span style='color:#3c8dbc;' class='fa fa-info-circle'></span>&nbsp;</button>
			</div>
			</h4>
		</div>
    </div>
	<div class="form-group"> 
		<div class="col-sm-4">
			<div class="input-group">
				<div class="input-group-addon input-sm">
					Fecha inicio cobro
				</div>
				<div class="input-group-addon input-sm">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" name="fechaInicio_add" id="fechaInicio_add" value='{txt_fecha_ini}' onfocus='js_descuentofactura_check_pvfalse();'
					class="form-control input-sm" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="input-group">
				<div class="input-group-addon input-sm">
					Fecha vencimiento
				</div>
				<div class="input-group-addon input-sm">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" name="fechaFin_add" id="fechaFin_add" value='{txt_fecha_fin}' onfocus='js_descuentofactura_check_pvfalse();'
					class="form-control input-sm" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
			</div>
		</div>
		<div class="col-sm-4" style='display:none'>
			Convenio de pago: <b>{ckb_convenioPago}</b>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<div class="input-group">
				<div class="input-group-addon  input-sm">
					Días prontopago
				</div>
				<input type="text" class="form-control input-sm" name="dias_prontopago" id="dias_prontopago" value='{dias_prontopago}'  onfocus='js_descuentofactura_check_pvfalse();'>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="input-group">
				<div class="input-group-addon input-sm" title='Ej.: 001-001-000027104' onmouseover='$(this).tooltip("show");'  data-placement='left'>
					No. Factura
				</div>
				<input type="text" class="form-control input-sm" name="txt_num_sucursal" readonly="readonly" id="txt_num_sucursal" value='{txt_num_sucursal}' 
					placeholder='xxx'
					onclick='js_descuentofactura_select_sucursal();'
					style='width:30%;background-color:white;cursor:pointer;text-align:center;'
					title='Asignar sucursal'
					data-sucu_codigo='{sucursal_codigo}'
					onmouseover='$(this).tooltip("show");' data-placement='bottom'
					{disabled_txt_num_factura}> 
				<input type="text" class="form-control input-sm" readonly="readonly" name="txt_num_ptoVenta" id="txt_num_ptoVenta" value='{txt_num_ptoVenta}' 
					placeholder='xxx'
					onclick='js_descuentofactura_select_ptoVenta();'
					style='width:30%;background-color:white;cursor:pointer;text-align:center;'
					title='Asignar punto de venta'
					data-puntvent_codigo='{puntVent_codigo}'
					onmouseover='$(this).tooltip("show");' data-placement='bottom'
					{disabled_txt_num_factura}> 
				<input type="text" class="form-control input-sm" name="txt_num_factura" readonly="readonly" id="txt_num_factura" value='{txt_num_factura}'
					placeholder='xxxxxxxxx'
					onclick='js_descuentofactura_select_numeroFactura();' 
					style='width:40%;background-color:white;cursor:pointer;text-align:center;'
					title='Asignar número de factura'
					onmouseover='$(this).tooltip("show");' data-placement='bottom'
					{disabled_txt_num_factura}> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="check_generar_FAC" name="check_generar_FAC"  onfocus='js_descuentofactura_check_pvfalse();' {ckb_genera_factura}
						onclick='js_facturas_check_generar_FAC();' > Generar factura
				</label>
			</div>
		</div>
	</div>
    <div class="form-group"> 
        <div class="col-md-12"> 
			<hr>
			<h4>Detalle de factura</h4>
		</div>
    </div>
	<div class="form-group">
		<div class="col-md-12"> 
			<input type='hidden' id='hd_total_numero_detalle' name='hd_total_numero_detalle' value='{hd_t_num_detalle}' />
			{tabla_detalleFactura}
		</div>
	</div>
	<div class="form-group"> 
		<div class="col-md-12"> 
			<hr>
			<table width='100%'>
				<tr><td align='left' width='50%'><h4>Descuentos asignados a la factura</h4></td>
					<td align='right'></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<input type='hidden' id='hd_total_inicial_descuentos' name='hd_total_inicial_descuentos' value='{hd_t_ini_dsctos}' />
			{tabla_descuentos}
			<table width='100%'>
				<tr><td align='left' width='50%'></td>
					<td align='right'>
						<button class='btn btn-default' type='button' id='btn_add_dscto' name='btn_add_dscto'
							aria-hidden='true' data-toggle='modal' data-target='#modal_addDiscount'><i class='fa fa-plus'></i>&nbsp;Agregar descuento</button></td></tr>
			</table>
		</div>
	</div>
	<div class="form-group"> 
		<div class="col-md-12"> 
			<hr>
			<table width='100%'>
				<tr>
					<td align='left' width='50%'><h4><label class="control-label"><b>Previsualización</b></label>
							<div id="EducaLinksHelperCliente" style="display:inline;font-size:small;text-align:left;vertical-align:middle;">
								<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>La previsualización me muestra cómo el cajero verá los valores al momento de cobrarlos, según el día seleccionado.
								<br>
								<br>
								<b>¿Por qué el día importa?</b>
								<br>
								<br>
								Es importante seleccionar el día de cobro, porque los descuentos y los prontopagos pueden variar, dependiendo de los días de validez que tenga un descuento, o los días de prontopago que tenga una pensión.
								</div>" data-placement="top"><span class="fa fa-info-circle"></span></a>
							</div>
						</h4>
					</td>
					<td align='right'>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="txt_como_si_fuera" class="control-label col-md-2 col-sm-4 col-xs-4">Previsualizar como si fuera</label>
							<div class="col-xs-5 col-sm-5 col-md-3">
								<div class='input-group'>
									<div class='input-group-addon input-sm'>
										<i class='fa fa-calendar'></i>
									</div>
									<input type="text" id="txt_como_si_fuera" name="txt_como_si_fuera" placeholder="dd/mm/yyyy"
										class="form-control input-sm" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required"/>
									<span class="input-group-btn">
										<button class='btn btn-default btn-flat btn-sm' type='button' id='btn_previsualizar' name='btn_previsualizar' title='Previsualizar' 
											onmouseover="$(this).tooltip('show');"
											onclick="js_descuentofacturas_previsualizar();"><i class='fa fa-eye'></i>&nbsp;</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div id='div_previsualizacion' name='div_previsualizacion'>
						{tabla_previsualizacion}
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12" id='div_previsualizacion_controles' name='div_previsualizacion_controles' style='text-align:right;'>
				<button class="btn btn-success" type="button" onclick="js_descuentofactura_save( );"><li class="fa fa-save"></li>&nbsp;Guardar Cambios</button>
		</div>
	</div>
</div>