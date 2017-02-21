<div id="frm_pagoTransferencia" class="form-medium" >
    <div class="form-group">
        <label for="banco" class='control-label'><strong>Banco Origen</strong></label>
        {comboBanco}
    </div>
    <div class="form-group">
        <label for="numeroCuentaOrigen" class='control-label'><strong>Cuenta de origen</strong></label>
        <input class="form-control" name="numeroCuentaOrigen" id="numeroCuentaOrigen"
				data-placement="right"
				title='N&uacute;mero de cuenta a la que se le ser&aacute; debitada el monto a pagar.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				onkeypress="return permite(event, 'num')" 
				type="number" min="0" step="1" max="99999999999999999999"
				placeholder="000000000000" required="required">
    </div>
    <div class="form-group">
        <label for="numeroCuentaDestino" class='control-label'><strong>Cuenta de destino</strong></label>
        {comboCuentasDestino}
    </div>
    <div class="form-group">
        <label for="referencia" class='control-label'><strong>Referencia</strong></label>
        <input class="form-control" name="referencia" id="referencia" 
				data-placement="right"
				title='N&uacute;mero de referencia de la transferencia'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				onkeypress="return permite(event, 'num_car')"
				type="number" min="0" step="1"  max="99999999999999999999"
				placeholder="Número de la transacción" required="required">
    </div>
    <div class="form-group">
        <label for="fechaTransaccion" class='control-label'><strong>Fecha transacci&oacute;n</strong></label>
        <input type="text" class="form-control" name="fechaTransaccion" id="fechaTransaccion"
				data-placement="right"
				title='Fecha de la transacci&oacute;n de la transferencia'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				maxlength="10" placeholder="dd/mm/aaaa" required="required">
		<div class="help-block with-errors"></div>
	</div>
    <div class="form-group">
        <label for="monto" class='control-label'><strong>Monto</strong></label>
        <div class="input-group"
				data-placement="right"
				title='Monto total a pagar con la transferencia.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'>
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" name="monto" id="monto" 
				onkeypress="return spacebar_retorna_cero(event,this);" maxlength="15" 
				placeholder="00.00" required="required"
				pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01">
        </div>
		<span class="help-block with-errors"></span>
    </div>
    <div class="form-group">
        <label for="observacion" class='control-label'><strong>Observaci&oacute;n</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" onkeypress="return permite(event, 'num_car')" maxlength="50" placeholder="Dato adicional">
    </div>
</div>