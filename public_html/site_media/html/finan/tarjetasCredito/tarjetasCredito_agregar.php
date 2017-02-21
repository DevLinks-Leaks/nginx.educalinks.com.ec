<div id="alta_tarjetaCredito" class="form-medium" >
    <div class="form-group">
		<label for="tarjetaCredito_add">Nombre de la tarjeta</label>
		<input type="text" class="form-control" name="tarjetaCredito_add" id="tarjetaCredito_add" placeholder="Ingrese el nombre de la tarjeta de crédito" required="required"></div>
    <div class="form-group"> 
		<label for="bancos_add">Banco</label>
		<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
			<a tabindex="0" data-toggle="popover" title="<a href='../bancos/' target='_blank'>Bancos</a>" data-content="<div style='font-size:x-small'>Si este campo sale en blanco, es probable que haga falta ingresar registros de Bancos en el sistema. Por favor, ir a la página de <a href='../bancos/' target='_blank'>bancos</a>.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
		</div>
		{combo_bancos}
	</div>
	<div class="form-group"> 
		<label for="bancos_add">Tipo</label>
		<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
			<a tabindex="0" data-toggle="popover" data-content="<div style='font-size:x-small'>Esta información es utilizada al momento de seleccionar 'Tarjetas' como forma de pago en <a href='../cobros/' target='_blank'>Caja</a>. El SRI (función envío de comprobantes electrónicos online), requiere determinar si la tarjeta de crédito es nacional o internacional.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
		</div>
		<select id='cmb_esInternacional_add' name='cmb_esInternacional_add' class='form-control'>
			<option selected='selected' value='0'>Nacional</option>
			<option value='1'>Internacional</option>
		</select>
	</div>   
</div>