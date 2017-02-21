<div id="frm_actualizacionFormaPagoEfectivo" class="form-medium">
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigoFP" id="codigoFP" value="{codigoFormaPago}" placeholder="Dato adicional">
        <input type="hidden" class="form-control" name="nombreFP" id="nombreFP" value="{nombreFormaPago}" required="required" />
        <input type="hidden" class="form-control" name="pago" id="pago" value="{idPago}" required="required" />
    </div>
	<div class="form-group">
			<label for="monto" class="control-label"><strong>Monto</strong></label>
			<div class="input-group"
					data-placement="right"
					title='Monto total a pagar en efectivo.'
					onfocus='$(this).tooltip("show")'
					onmouseover='$(this).tooltip("show")'>
				<span class="input-group-addon">$</span>
				<input type="text" class="form-control" name="monto" id="monto" value="{efec_monto}"
					onkeypress="return spacebar_retorna_cero(event,this);" 
					onkeyup="return enterpress_addpay(event);" pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01"
					maxlength="15" placeholder="00.00" required='required'>
			</div>
			<span class="help-block with-errors"></span>
		</div>
    <div class="form-group">
        <label for="observacion"><strong>Observacion</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" onkeypress="return permite(event, 'num_car')" maxlength="50" value="{efec_observacion}" placeholder="Dato adicional">
    </div>
</div>