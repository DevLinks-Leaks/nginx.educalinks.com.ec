<div id="frm_modificaDetalle" class="form-medium" >
    <div class="form-group">
        <input type="hidden" readonly class="form-control" name="idDetalle" id="idDetalle" value="{detalle_mod}" placeholder="00.00" required="required">
    </div>
    <div class="form-group">
        <label for="categoriaDetalle">Categoria</label>
        <input type="text" readonly class="form-control" name="categoriaDetalle" id="categoriaDetalle" value="{nombreCategoria_mod}" data-codigo="{codigoCategoria_mod}" placeholder="Nombre de la categoria" required="required">
    </div>
    <div class="form-group">
        <label for="productoDetalle">Producto</label>
            <input type="text" readonly class="form-control" name="productoDetalle" id="productoDetalle" value="{nombreProducto_mod}" data-codigo="{codigoProducto_mod}" placeholder="Nombre del producto" required="required">
    </div>
    <div class="form-group">
        <label for="precioDetalle">Precio</label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" readonly class="form-control" name="precioDetalle" id="precioDetalle" value="{precio_mod}" placeholder="00.00" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="cantidadDetalle">Cantidad</label>
        <div class="input-group">
            <span class="input-group-addon">Und.</span>
            <input type="text" onkeypress="return validaNumeros(event, this);" onkeyup="calculaTotalesModificacion();"  maxlength="10" class="form-control" name="cantidadDetalle" id="cantidadDetalle" value="{cantidad_mod}" placeholder="00" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="descuentoDetalle">Descuento</label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" readonly class="form-control" name="descuentoDetalle" id="descuentoDetalle" value="{descuento_mod}" placeholder="00.00" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="ivaDetalle">IVA</label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" readonly class="form-control" name="ivaDetalle" id="ivaDetalle" value="{iva_mod}" data-iva="{aplicaIVA_mod}" placeholder="00.00" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="totalDetalle">Total</label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" readonly class="form-control" name="totalDetalle" id="totalDetalle" value="{subtotal_mod}" placeholder="00.00" required="required">
        </div>
    </div>
</div>