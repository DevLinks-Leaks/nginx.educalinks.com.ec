<div id="alta_usuario" class="form-medium" >
	<div class="form-group">
		<label for="desc_pronto">El servicio de Botón de Pago permite que el representante pueda realizar el pago de pensiones en línea,
		desde el módulo de representantes.</label>
		<div class="checkbox">
			<label>
				<input type="radio" id="rdb_bdp_activo_act" name="rdb_bdp_activo" value="enbld" onclick='js_general_rdb_bdp_active();' {enbld}> Activar (abrir caja)<br>
				<input type="radio" id="rdb_bdp_activo_ina" name="rdb_bdp_activo" value="dsbld" onclick='js_general_rdb_bdp_active();' {dsbld}> Desactivar (cerrar caja)
			</label>
		</div>
		<span style='font-size:small;'>Los reportes se pueden visualizar desde el menú a Caja/Historial Cajas.</span><br>
		<span style='font-size:small;'>Al desactivar y activar, no se abre otra caja si es que ya hay una abierto.</span>
	</div>
	<div class="form-group">
		<hr/>
	</div>
	<div class="form-group">   
		<label for="desc_pronto">Cajero</label>
		<div class="input-group">
			<input type="text" class="form-control" name="cajero" id="cajero" value='CAJEROWEB' required="required" disabled='disabled'>
		</div>
	</div>
	
	<div class="form-group">
		<label for="pto_prefijo_web" class='control-label'>Prefijo (número de caja)
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
				<a href='#' onmouseover='$(this).tooltip("show")' 
				title="Prefijo del punto de venta. En los documentos (ej. facturas, notas de cr&eacute;dito), son el segundo conjunto de tres numeros. Por ejemplo: xxx-001-xxx." data-placement='right'>
					<span class='glyphicon glyphicon-question-sign'></span></a>
			</div>
		<input type="text" class="form-control" name="pto_prefijo_web" id="pto_prefijo_web"  value='{pto_prefijo_web_value}'
			   placeholder="001" required="required" {pto_prefijo_web_dsbld}>
	</div>
    <div class="form-group"> 
		<label for="pto_sucursal_web" class='control-label'>Sucursal</label>
		<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
			<a tabindex="0" data-toggle="popover" title="<a href='../sucursales/' target='_blank'>Sucursales</a>" data-content="<div style='font-size:x-small'>Si este campo sale en blanco, es probable que haga falta registrar sucursales en el sistema. Por favor, ir a la página de <a href='../sucursales/' target='_blank'>sucursales</a>.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
		</div>
		{combo_sucursal}
	</div>
    <div class="form-group">
		<label for="pto_secuencia_web" class='control-label'>Secuencia de Facturas </label>
		<input type="text" class="form-control" name="pto_secuencia_web" id="pto_secuencia_web" value='{pto_secuencia_web_value}'
			   placeholder="1" required="required" {pto_secuencia_web_dsbld}>
	</div>
    <!--<div class="form-group">
		<label for="pto_secuencia_web" class='control-label'>Secuencia de Nota de Crédito</label>
		<input type="number" class="form-control" name="pto_secuencianc_web" id="pto_secuencianc_web" 
			   placeholder="Secuencia para nota de crédito" required="required">
	</div>-->
</div>