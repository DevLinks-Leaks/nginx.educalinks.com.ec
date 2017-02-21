<div id="frm_busquedaProducto" class="form-medium" >
    <div style='background-color:white;'>
		<div class="col-sm-12">
			<div class="form-group">
				<label for="codigoCategoria_busq">Categoria</label>
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
					<a tabindex="0" data-toggle="popover" title="<a href='../categorias/' target='_blank'>Categorías</a>" data-content="<div style='font-size:x-small'>Para agregar un ítem a una deuda para su cobro, debe primero seleccionar una categoría y luego un ítem. Los ítems están separados por categoria.<br><br> Si este combo (listado) está vacío, es probable que no haya creado categorías todavía en su entorno. Por favor, ir a la página de <a href='../categorias/' target='_blank'>Categorías</a> para empezar a alimentar este listado.</div>" data-placement='right'><span class='fa fa-info-circle'></span></a>
				</div>
				{combo_categoria}
			</div>
			<div class="form-group">
				<label for="codigoProducto_busq">Ítem (Producto/servicio)</label>
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
					<a tabindex="0" data-toggle="popover" title="<a href='../items/' target='_blank'>Ítems</a>" data-content="<div style='font-size:x-small'>Para agregar un ítem a una deuda para su cobro, debe primero seleccionar una categoría y luego un ítem. Los ítems están separados por categoria.<br><br> Si este combo (listado) está vacío, es probable que ya haya creado categorías en su entorno pero no haya creado ítems todavía. Por favor, ir a la página de <a href='../items/' target='_blank'>Ítems</a> para empezar a alimentar este listado.</div>" data-placement='right'><span class='fa fa-info-circle'></span></a>
				</div>
				<div id="resultadoProducto">
					{combo_producto}
				</div>
			</div>
			<div class="form-group">
				<label for="precio_busq">Precio</label>
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
					<a tabindex="0" data-toggle="popover" title="<a href='../precios/' target='_blank'>Precios</a>" data-content="<div style='font-size:x-small'>Si este campo sale en blanco, es probable que haga falta asignarle precio(s) al ítem. Por favor, ir a la página de <a href='../precios/' target='_blank'>Precios</a> para agregarle el precio a este ítem.</div>" data-placement='right'><span class='fa fa-info-circle'></span></a>
				</div>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" readonly class="form-control" name="precio_busq" id="precio_busq" placeholder="00.00" required="required">
					<input type="hidden" readonly class="form-control" name="porcentajeIva_busq" id="porcentajeIva_busq" />
				</div>
			</div>
			<div class="form-group">
				<label for="cantidad_busq">Cantidad</label>
				<div class="input-group">
					<span class="input-group-addon">Und.</span>
					<input type="text" onkeypress="return validaNumeros(event, this);" onkeyup="calculaTotalesAsignacion();"  
						maxlength="10" class="form-control" name="cantidad_busq" id="cantidad_busq" placeholder="00" value='1' required="required">
				</div>
			</div>
			<div id='div_descuento_mucho_busq' name='div_descuento_mucho_busq' style='display:none;' class='grid'>
			</div>
			<div id='div_descuento_poco_busq' name='div_descuento_poco_busq' style='display:inline;'>
				<div class="form-group">
					<label for="descuentoAsignado_busq">Descuento Asignado</label>		
						<div class="input-group">
							<span class="input-group-addon">%</span>
							<input type="text" readonly class="form-control" name="descuentoAsignado_busq" id="descuentoAsignado_busq" placeholder="00.00" value='0.00' required="required">
						</div>
					</div>
				<div class="form-group">
					<label for="descuento_busq">Total Descuento</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" readonly class="form-control" name="descuento_busq" id="descuento_busq" placeholder="00.00" value='0.00' required="required">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="iva_busq">IVA</label>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" readonly class="form-control" name="iva_busq" id="iva_busq" placeholder="00.00" value='0.00' required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="total_busq">Total</label>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" readonly class="form-control" name="total_busq" id="total_busq" placeholder="00.00" value='0.00' required="required">
				</div>
			</div>
		</div>
	</div>
</div>