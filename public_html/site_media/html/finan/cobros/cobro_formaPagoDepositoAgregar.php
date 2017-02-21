<div id="frm_pagoDeposito" class="form-medium" >
    <div class="form-group">
        <label for="banco" class="control-label"><strong>Banco Origen</strong></label>
        {comboBanco}
    </div>
    <!-- <div class="form-group">
        <label for="numeroCuentaOrigen">Cuenta de origen</label>
        <input type="text" class="form-control" name="numeroCuentaOrigen" id="numeroCuentaOrigen" onkeypress="return permite(event, 'num')" maxlength="20" placeholder="000000000000" required="required">
    </div>--> 
	<div class="form-group">
        <label for="numeroCuentaDestino" class="control-label"><strong>Cuenta de destino</strong></label>
        {comboCuentasDestino}
		<div class="help-block with-errors"></div>
	</div>
    <div class="form-group">
        <label for="referencia" class="control-label"><strong>Referencia</strong></label>
        <input class="form-control" name="referencia" id="referencia"
				data-placement="top"
				title='N&uacute;mero de referencia del dep&oacute;sito'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				onkeypress="return permite(event, 'num_car')" 
				type="number" min="0" step="1" max="99999999999999999999"
				placeholder="Número de la transacción" required="required">
		<div class="help-block with-errors"></div>
	</div>
    <div class="form-group">
        <label for="fechaTransaccion" class="control-label"><strong>Fecha transacción</strong></label>
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
				required="required">
		</div>
		<div class="help-block with-errors"></div>
	</div>
   <div class="form-group">
        <label for="monto" class='control-label'><strong>Monto</strong></label>
        <div class="input-group"
				data-placement="top"
				title='Monto total a pagar con el dep&oacute;sito.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'>
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" name="monto" id="monto" 
				onkeypress="return spacebar_retorna_cero(event,this);"  maxlength="15" 
				placeholder="00.00" required="required"
				pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01">
        </div>
		<span class="help-block with-errors"></span>
    </div>
    <div class="form-group">
        <label for="observacion" class="control-label"><strong>Observaci&oacute;n</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" onkeypress="return permite(event, 'num_car')" maxlength="50" placeholder="Dato adicional">
    </div>
</div>