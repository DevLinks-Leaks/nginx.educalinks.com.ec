<div id="alta_pto_emision" class="form-medium" >
    <div class="form-group">
		<label for="pto_prefijo_add" class='control-label'>Prefijo
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
				<a href='#' onmouseover='$(this).tooltip("show")' 
				title="Prefijo del punto de venta. En los documentos (ej. facturas, notas de cr&eacute;dito), son el segundo conjunto de tres numeros. Por ejemplo: xxx-001-xxx." data-placement='right'>
					<span class='glyphicon glyphicon-question-sign'></span></a>
			</div>
		<input type="number" class="form-control" name="pto_prefijo_add" id="pto_prefijo_add" 
			   placeholder="Prefijo para factura" required="required">
	</div>
    <div class="form-group"> 
		<label for="pto_sucursal_add" class='control-label'>Sucursal</label>
		{combo_sucursal}
	</div>
    <div class="form-group">
		<label for="pto_secuencia_add" class='control-label'>Secuencia de Facturas </label>
		<input type="number" class="form-control" name="pto_secuencia_add" id="pto_secuencia_add" 
			   placeholder="Secuencia para factura" required="required">
	</div>
    <div class="form-group">
		<label for="pto_secuencia_add" class='control-label'>Secuencia de Nota de Crédito</label>
		<input type="number" class="form-control" name="pto_secuencianc_add" id="pto_secuencianc_add" 
			   placeholder="Secuencia para nota de crédito" required="required">
	</div>
</div>
