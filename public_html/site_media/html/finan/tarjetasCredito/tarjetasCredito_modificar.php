<div id="alta_tarjetaCredito" class="form-medium" >
    <div class="form-group">
		<input type="hidden" id="tarjeta_codigo" name="tarjeta_codigo" value="{tarjCred_codigo}" />
		<label for="tarjeta_nombre">Nombre de la tarjeta</label>
		<input type="text" class="form-control" name="tarjeta_nombre" id="tarjeta_nombre" placeholder="Ingrese el nombre de la Tarjeta de Crédito" required="required" value="{tarjCred_nombre}">
	</div>
    <div class="form-group">
		<label for="combo_bancos">Bancos</label>
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
		<select id='cmb_esInternacional' name='cmb_esInternacional' class='form-control'>
			<option {nacional} value='0'>Nacional</option>
			<option {internacional} value='1'>Internacional</option>
		</select>
	</div> 
</div>