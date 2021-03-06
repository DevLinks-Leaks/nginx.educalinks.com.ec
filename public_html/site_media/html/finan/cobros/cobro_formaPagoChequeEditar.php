<div id="frm_actualizacionFormaPagoCheque" class="form-medium">
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigoFP" id="codigoFP" value="{codigoFormaPago}" required="required" />
        <input type="hidden" class="form-control" name="nombreFP" id="nombreFP" value="{nombreFormaPago}" required="required" />
        <input type="hidden" class="form-control" name="pago" id="pago" value="{idPago}" required="required" />
    </div>
    <div class="form-group">
        <label for="banco" class='control-label'><strong>Banco</strong></label>
        {comboBanco}
    </div>
    <div class="form-group">
        <label for="numeroCheque" class='control-label'><strong>Número cheque</strong></label>
        <input type="text" class="form-control" name="numeroCheque" id="numeroCheque"
				data-placement="top"
				title='N&uacute;mero del cheque'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				 value="{cheq_numeroCheque}" onkeypress="return permite(event, 'num')" maxlength="20" placeholder="000000000000" required="required" />
    </div>
    <div class="form-group">
        <label for="numeroCuenta" class='control-label'><strong>Número cuenta</strong></label>
        <input type="text" class="form-control" name="numeroCuenta" id="numeroCuenta"
				data-placement="top"
				title='N&uacute;mero de cuenta'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				 value="{cheq_numeroCuenta}" onkeypress="return permite(event, 'num')" maxlength="20" placeholder="000000000000" required="required" />
    </div>
    <div class="form-group">
        <label for="nombreTitular" class='control-label'><strong>Titular</strong></label>
        <input type="text" class="form-control" name="nombreTitular" id="nombreTitular"
				data-placement="top"
				title='Nombre del titular del cheque'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				 value="{cheq_nombreTitular}" onkeypress="return permite(event, 'car')" maxlength="30" placeholder="Nombre del beneficiario" required="required" />
    </div>
    <div class="form-group">
        <label for="nombreGirador" class='control-label'><strong>Girador</strong></label>
        <input type="text" class="form-control" name="nombreGirador" id="nombreGirador"
				data-placement="top"
				title='Nombre del girador del cheque'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				  value="{cheq_nombreGirador}" onkeypress="return permite(event, 'car')" maxlength="30" placeholder="Nombre del girador" required="required" />
    </div>
    <div class="form-group">
        <label for="fechaDeposito" class='control-label'><strong>Fecha depósito</strong></label>
        <input type="text" class="form-control" name="fechaDeposito" id="fechaDeposito"
				data-placement="top"
				title='Fecha de dep&oacute;sito'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'
				data-inputmask="'alias': 'dd/mm/yyyy'" data-mask 
				 value="{cheq_fechaDeposito}" required="required" />
    </div>
	<div class="form-group">
        <label for="monto" class='control-label'><strong>Monto</strong></label>
        <div class="input-group" 
				data-placement="top"
				title='Monto total a pagar con el cheque.'
				onfocus='$(this).tooltip("show")'
				onmouseover='$(this).tooltip("show")'>
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" name="monto" id="monto" value="{cheq_monto}"
				onkeypress="return spacebar_retorna_cero(event,this);"  maxlength="15" 
				placeholder="00.00" required="required"
				 pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01">
        </div>
		<span class="help-block with-errors"></span>
    </div>
    <div class="form-group">
        <label for="observacion" class='control-label'><strong>Observacion</strong></label>
        <input type="text" class="form-control" name="observacion" id="observacion" value="{cheq_observacion}" maxlength="50" placeholder="Dato adicional" />
    </div>
</div>