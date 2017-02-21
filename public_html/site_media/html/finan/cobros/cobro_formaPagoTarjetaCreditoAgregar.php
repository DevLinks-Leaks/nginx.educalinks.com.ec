<div id="frm_formaPagoTarjetaCredito" class="form-medium">
    <div class="form-group">
        <label for="tarjetaCredito" class='control-label'><strong>Tarjeta Crédito</strong></label>
        {comboTarjetaCredito}
    </div>
    <div class="form-group">
        <label for="numero" class='control-label'><strong>Titular</strong></label>
        <input class="form-control" name="titular" id="titular"
				data-placement="right"
				title='Nombre del titular del a tarjeta'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				onkeypress="return permite(event, 'car')"
				type="text"  maxlength="45"
				placeholder="Dueño de la tarjeta" required="required">
    </div>
    <div class="form-group">
        <label for="numero" class='control-label'><strong>Número</strong></label>
        <input class="form-control" name="numero" id="numero"
				data-placement="right"
				title='N&uacute;mero de la tarjeta de cr&eacute;dito'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				onkeypress="return permite(event, 'num')"
				type="number" min="0" step="1" max="99999999999999999999"
				placeholder="000000000000" required="required">
    </div>
    <div class="form-group">
        <label for="lote" class='control-label'><strong>Lote</strong></label>
        <input class="form-control" name="lote" id="lote"
				data-placement="right"
				title='Lote'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				onkeypress="return permite(event, 'num_car')"
				type="number" min="0" step="1" max="99999999999999999999" 
				placeholder="Número del lote" required="required">
    </div>
    <div class="form-group">
        <label for="referencia" class='control-label'><strong>Referencia</strong></label>
        <input class="form-control" name="referencia" id="referencia"
				data-placement="right"
				title='N&uacute;mero de referencia del voucher'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				onkeypress="return permite(event, 'num_car')" 
				type="number" min="0" step="1" max="99999999999999999999"
				placeholder="Número de la transacción" required="required">
    </div>
	<!--<div class="form-group">
        <label for="fechaTransaccion" class='control-label'><strong>Fecha de caducidad</strong></label>
        <input type="date" class="form-control" name="fechaCaducidad" id="fechaCaducidad"
				data-placement="right"
				title='Fecha de vencimiento de la tarjeta a partir de la cual la tarjeta ya no ser&aacute; v&aacute;lida.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")' 
				maxlength="10" placeholder="dd/mm/aaaa" required="required" />
		<div class="help-block with-errors"></div>
    </div>-->
    <div class="form-group">
        <label for="monto" class='control-label'><strong>Monto</strong></label>
        <div class="input-group"
				data-placement="right"
				title='Monto total a pagar con la tarjeta de cr&eacute;dito.'
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
        <label for="monto" class='control-label'><strong>Red de pago</strong></label>
		<select class="form-control" name="red_de_pago" id="red_de_pago" required="required" >
			<option value="D">Datafast</option>
			<option value="M">Medianet</option>
		</select>
		<span class="help-block with-errors"></span>
    </div>
    <div class="form-group">
        <label for="observacion" class='control-label'><strong>Observacion</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" onkeypress="return permite(event, 'num_car')" maxlength="50" placeholder="Dato adicional">
    </div>
</div>