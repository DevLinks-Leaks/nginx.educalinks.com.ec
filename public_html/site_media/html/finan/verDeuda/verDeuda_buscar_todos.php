<!-- Modal Revertir deuda y borrar pago-->
<div class="modal fade" id="modal_revert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Revertir deuda y borrar pago</h4>
            </div>
            <div class="modal-body" id="modal_revert_body">
            </div>
        </div>
    </div>
</div>
<!-- Modal Revertir deuda y borrar pago-->
<form id="file_form" action="{ruta_html_finan}/verDeuda/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<div class='panel panel-info'>
		<div class="panel-heading">
			<h3 class="panel-title">Búsqueda</h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-4 col-sm-12'> 
						<button type="button" class='btn btn-primary glyphicon glyphicon-search' id='btn_selectTipoDocAut' name='btn_selectTipoDocAut' 
								onclick="return js_Pago_carga_PagosRealizados('resultadoProcesoPagos', '{ruta_html_finan}/pagos/controller.php');">
						</button>
					</div>
					<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de emisión, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. emisi&oacute;n</span>
							</span>				
							<span class="input-group-addon">
								<small>Inicio</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
										value="{txt_fecha_ini}" placeholder="dd/mm/yyyy" required="required">
						
							<span class="input-group-addon">
								<small>Fin</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
										value="{txt_fecha_fin}" placeholder="dd/mm/yyyy" required="required">
						</div>
					</div>
					<div class="checkbox checkbox-info col-sm-2">
						<label for='ckb_opc_adv'>
							<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='js_Pago_check_opc_avanzadas();'>
								<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
						</label>
					</div>
				</div>
				<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Ref. Pago:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='C&oacute;digo del representado'
								onmouseover='$(this).tooltip("show")'>
							<input type="text" class="form-control" name="txt_codigo_pago" id="txt_codigo_pago" >
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Forma de pago:</label>
						<div class="col-md-4 col-sm-8">
							{cmb_forma_pago}
						</div>
					</div>
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Ref. FAC.:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='99999999999999' min='1' class="form-control" name="txt_num_factura" id="txt_num_factura">
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
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Sucursal:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='9999' min='1' class="form-control" name="txt_sucursal" id="txt_sucursal">
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Pto. Venta:</label>
						<div class="col-md-4 col-sm-8">
							<input type="number" max='9999' min='1' class="form-control" name="txt_ptoVenta" id="txt_ptoVenta" >
						</div>
					</div>
					<div class='form-group'>
						<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1">
							<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
								 title='valor total neto, desde, hasta.'
								 onmouseover='$(this).tooltip("show")'>
								<span class="input-group-addon">
									<input type="checkbox" id='chk_tneto' name='chk_tneto' onclick='js_Pago_check_tneto();'>
								</span>
								<span class="input-group-addon">
									<span style="text-align:right;font-size:small;font-weight:bold;">T. Neto</span>
								</span>				
								<span class="input-group-addon" style="text-align:right;font-size:small;font-weight:bold;">de $</span>
								<input type="text" class="form-control" name="txt_tneto_ini" id="txt_tneto_ini" placeholder='0.00' disabled='disabled'>
								<span class="input-group-addon" style="text-align:right;font-size:small;font-weight:bold;">a $</span>
								<input type="text" class="form-control" name="txt_tneto_fin" id="txt_tneto_fin"  placeholder='0.00' disabled='disabled'>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
								onmouseover='$(this).tooltip("show")'>
							<input type="text" class="form-control" name="txt_id_titular" id="txt_id_titular" >
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre titular:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Nombre del titular del documento autorizado'
								onmouseover='$(this).tooltip("show")'>
							<input type="text" class="form-control" name="txt_nom_titular" id="txt_nom_titular" >
						</div>
					</div>
					<div class='form-group'>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Cod. estudiante:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='C&oacute;digo del representado'
								onmouseover='$(this).tooltip("show")'>
							<input type="text" class="form-control" name="txt_cod_cliente" id="txt_cod_cliente" >
						</div>
						<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre estudiante:</label>
						<div class="col-md-4 col-sm-8"
								data-placement="bottom"
								title='Nombre del cliente representado'
								onmouseover='$(this).tooltip("show")'>
							<input type="text" class="form-control" name="txt_nom_cliente" id="txt_nom_cliente" >
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-body">
		<div id="resultadoProcesoDeudas">
			<div style='text-align:center'>- Consultar primero -</div>
			{tabla_deudas}
		</div>
	</div>
</div>