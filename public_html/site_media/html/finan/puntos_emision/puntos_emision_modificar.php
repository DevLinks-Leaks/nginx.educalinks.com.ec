<div id="alta_pto_emision" class="form-medium" >
    <div class="form-group">
		<input type="hidden" id="pto_codigo" name="pto_codigo" value="{puntVent_codigo}" />
		<label for="pto_prefijo" class='control-label'>Prefijo
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
				<a href='#' onmouseover='$(this).tooltip("show")' 
				title="Prefijo del punto de venta. En los documentos (ej. facturas, notas de cr&eacute;dito), son el segundo conjunto de tres numeros. Por ejemplo: xxx-001-xxx." data-placement='right'>
					<span class='glyphicon glyphicon-question-sign'></span></a>
			</div>
		</label>
		<input type="number" class="form-control" name="pto_prefijo" id="pto_prefijo" 
				placeholder="Ingrese el prefijo para la factura" required="required" value="{puntVent_prefijo}" 
				min='1'>
	</div>
    <div class="form-group">
		<label for="pto_sucursal" class='control-label'>Sucursal</label>
		{combo_sucursal}
	</div>
    <div class="form-group"> 
		<label for="pto_secuencia" class='control-label'>Secuencia de Facturas</label>
		<input type="number" class="form-control" name="pto_secuencia" id="pto_secuencia" 
				placeholder="Ingrese la secuencia para la factura" required="required" value="{puntVent_secuencia}"
				min='1'>
	</div>
    <div class="form-group"> 
		<label for="pto_secuencia" class='control-label'>Secuencia de Notas de Crédito</label>
		<input type="number" class="form-control" name="pto_secuencia_nc" id="pto_secuencia_nc" 
				placeholder="Ingrese la secuencia para la factura" required="required" value="{puntVent_secuencianc}"
				min='1'>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ckb_deudasPendientes" id="ckb_docPendientes" >
					¿Actualizar prefijo de punto de venta a los documentos legales sin estado <i>'autorizado'?</i>
					<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
						<a href='#' onmouseover='$(this).tooltip("show")' 
						title="Deje esta opci&oacute;n en blanco en caso que desee que los cambios a realizar sean v&aacute;lidos s&oacute;lo para los documentos (ej: facturas, notas de cr&eacute;dito) que se generen a partir de ahora." data-placement='bottom'>
							<span class='glyphicon glyphicon-question-sign'></span></a>
					</div>
			</label>
		</div>
    </div>
</div>