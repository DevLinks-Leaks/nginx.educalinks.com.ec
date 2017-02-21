<div id="frm_pagoDeposito" class="form-medium" >
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigoFP" id="codigoFP" value="{codigoFormaPago}" required="required" />
        <input type="hidden" class="form-control" name="nombreFP" id="nombreFP" value="{nombreFormaPago}" required="required" />
        <input type="hidden" class="form-control" name="pago" id="pago" value="{idPago}" required="required" />
    </div>
    <div class="form-group">
        <label for="banco"><strong>Banco Origen</strong></label>
        {comboBanco}
    </div>
    <!-- <div class="form-group">
        <label for="numeroCuentaOrigen">Cuenta de origen</label>
        <input type="text" class="form-control" name="numeroCuentaOrigen" id="numeroCuentaOrigen" onkeypress="return permite(event, 'num')" maxlength="20" value="{depo_numeroCuentaOrigen}" placeholder="000000000000" required="required" />
    </div>-->
    <div class="form-group">
        <label for="numeroCuentaDestino" class='control-label'><strong>Cuenta de destino</strong></label>
        {comboCuentasDestino}
    </div>
    <div class="form-group">
        <label for="referencia" class='control-label'><strong>Referencia</strong></label>
        <input type="text" class="form-control" name="referencia" id="referencia"
				data-placement="top"
				title='N&uacute;mero de referencia del dep&oacute;sito'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				onkeypress="return permite(event, 'num_car')" maxlength="20" value="{depo_referencia}" placeholder="Número de la transacción" required="required" />
    </div>
    <div class="form-group">
        <label for="fechaTransaccion" class='control-label'><strong>Fecha transacción</strong></label>
        <div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</div>
			<input type="text" class="form-control" name="fechaTransaccion" id="fechaTransaccion"
				data-placement="top"
				title='Fecha de la transacci&oacute;n del dep&oacute;sito'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				data-inputmask="'alias': 'dd/mm/yyyy'" data-mask 
				value="{depo_fechaTransaccion}"
				required="required" />
		</div>
    </div>
	<div class="form-group">
        <label for="monto" class='control-label'><strong>Monto</strong></label>
        <div class="input-group"
				data-placement="top"
				title='Monto total a pagar con la tarjeta de cr&eacute;dito.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'>
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" name="monto" id="monto" value="{depo_monto}"
				onkeypress="return spacebar_retorna_cero(event,this);"  maxlength="15" 
				placeholder="00.00" required="required"
				 pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01">
        </div>
		<span class="help-block with-errors"></span>
    </div>
    <div class="form-group">
        <label for="observacion" class='control-label'><strong>Observaci&oacute;n</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" onkeypress="return permite(event, 'num_car')" maxlength="50" value="{depo_observacion}" placeholder="Dato adicional" />
    </div>
</div>