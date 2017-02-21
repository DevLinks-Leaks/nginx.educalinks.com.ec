<div id="alta_usuario" class="form-medium" >
    <div class="form-group">
		<input type="hidden" id="sucu_codigo" name="sucu_codigo" value="{sucu_codigo}" />
		<label for="sucu_descripcion" class='control-label'><b>Descripción</b></label>
		<input type="text" class="form-control" name="sucu_descripcion" id="sucu_descripcion" placeholder="Ingrese la descripción de la sucursal" required="required" value="{sucu_descripcion}"></div>
    <div class="form-group">
		<label for="sucu_direccion" class='control-label'><b>Dirección</b></label>
		<input type="text" class="form-control" name="sucu_direccion" id="sucu_direccion" placeholder="Ingrese la dirección de la sucursal" required="required" value="{sucu_direccion}"></div>
    <div class="form-group"> 
		<label for="sucu_prefijo" class='control-label'><b>Prefijo</b>
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
				<a href='#' onmouseover='$(this).tooltip("show")' 
				title="Prefijo de sucursal. En los documentos (ej. facturas, notas de cr&eacute;dito), son el primer conjunto de tres numeros. Por ejemplo: 001-xxx-xxx." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
			</div>
		</label>
		<input type="text" class="form-control" name="sucu_prefijo" id="sucu_prefijo" placeholder="Ingrese el prefijo para la factura" required="required" value="{sucu_prefijo}">
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ckb_docPendientes" id="ckb_docPendientes" >
				¿Actualizar prefijo de sucursal a los documentos legales sin estado <i>'autorizado'?</i>
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
					<a href='#' onmouseover='$(this).tooltip("show")' 
						title="Deje esta opci&oacute;n en blanco en caso que desee que los cambios a realizar sean v&aacute;lidos s&oacute;lo para los documentos (ej: facturas, notas de cr&eacute;dito) que se generen a partir de ahora." data-placement='top'><span class='glyphicon glyphicon-question-sign'></span></a>
				</div>
			</label>
		</div>
    </div>
</div>