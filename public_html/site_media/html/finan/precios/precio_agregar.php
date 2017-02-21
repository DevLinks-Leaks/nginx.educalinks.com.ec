<div id="frm_ingresoPrecio" class="form-medium" >
    <input type="hidden" class="form-control" name="codigoProducto_add" id="codigoProducto_add" value="{prec_productoCodigo}" required="required">
    <div class="form-group"> 
        <label for="nombre_add" class="control-label"><strong>Producto</strong></label>
        <input type="text" readonly class="form-control" name="nombreProducto_add" id="nombreProducto_add" value="{prec_productoNombre}" placeholder="Nombre del producto" required="required">
		<input type="hidden" name="hd_precio_general" id="hd_precio_general" value="{precio_general}">
    </div>
    <div class="form-group">
    	<label for="grupoEconomico_add" class="control-label"><strong>Grupo Economico</strong></label>
    	{combo_grupoEconomico}
    </div>
    <div class="form-group">
        <label for="nivel_economico_add" class="control-label"><strong>Nivel económico</strong></label>
        {combo_nivel_economico}
    </div>
	<div class="form-group">
		<label for="precio_add" class="control-label"><strong>Precio</strong></label>
		<div class="input-group"
					data-placement="right"
					title='Nuevo valor del producto.'
					onfocus='$(this).tooltip("show")'
					onmouseover='$(this).tooltip("show")'>
			<span class="input-group-addon">$</span>
			<input type="text" class="form-control" name="precio_add" id="precio_add"
					onkeypress="return spacebar_retorna_cero(event,this);" 
					pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01"
					maxlength="15" placeholder="00.00" required='required'>
		</div>
		<span class="help-block with-errors"></span>
	</div>
    <div class="form-group" style='display:none;'> 
    	<label for="precio_add" class="control-label"><strong>Cuenta Contable</strong></label>
    	<input type="text" class="form-control" name="cuentacontable_add" id="cuentacontable_add" placeholder="Cuenta Contable">
    </div>
</div>