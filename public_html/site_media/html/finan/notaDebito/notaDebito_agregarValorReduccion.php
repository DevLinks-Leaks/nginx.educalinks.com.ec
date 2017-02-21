<div id="frm_addValorNC" class="form-normal">
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtSecuenciaDetalleFactura" id="txtSecuenciaDetalleFactura" value="{secuenciaDetalleFactura}" placeholder="000000" required="required" />        
    </div>
    <div class="form-group">
        <label for="txtCodigoProducto"><b>Código producto</b></label>
        <input type="text" disabled="true" class="form-control" name="txtCodigoProducto" id="txtCodigoProducto" value="{codigoProducto}" placeholder="000000" required="required" />        
    </div>
    <div class="form-group">
        <label for="txtNombreProducto"><b>Producto</b></label>
        <input type="text" disabled="true" class="form-control" name="txtNombreProducto" id="txtNombreProducto" value="{nombreProducto}" placeholder="Nombre del producto" required="required" />
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtIVA" id="txtIVA" value="{iva}" placeholder="00.00" required="required" />        
    </div>
    <div class="form-group">
        <label for="txtIVADeducido"><b>IVA deducido</b></label>
        <input type="text" disabled="true" class="form-control" name="txtIVADeducido" id="txtIVADeducido" value="" maxlength="20" placeholder="00.00" required="required" />
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtDescuento" id="txtDescuento" value="{descuento}" placeholder="00.00" required="required" />        
    </div>
    <div class="form-group">
        <label for="txtDescuentoDeducido"><b>Descuento deducido</b></label>
        <input type="text" disabled="true" class="form-control" name="txtDescuentoDeducido" id="txtDescuentoDeducido" value="" maxlength="30" placeholder="00.00" required="required" />
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtValorBruto" id="txtValorBruto" value="{valorBruto}" placeholder="00.00" required="required" />        
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtValorNeto" id="txtValorNeto" value="{valorNeto}" placeholder="00.00" required="required" />        
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="txtValorNC" id="txtValorNC" value="{valorNC}" placeholder="00.00" required="required" />        
    </div>
    <div class="form-group">
        <label for="txtValorBrutoDeducido"><b>Valor bruto deducido</b></label>
        <input type="text" disabled="true" class="form-control" name="txtValorBrutoDeducido" id="txtValorBrutoDeducido" value="" maxlength="30" placeholder="00.00" required="required" />
    </div>
    <div class="form-group">
        <label for="txtDescripcion"><b>Descripción</b></label>
        <input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Descripción" maxlength="50" required="required" />
    </div>
    <div class="form-group">
        <label for="txtValorNeto"><b>Monto a reducir</b></label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" name="txtValorNetoAReducir" id="txtValorNetoAReducir" onkeypress="return validaDesbordamientoNC(event, this);" onkeyup="deducirValores(this);" maxlength="15" placeholder="00.00" required="required" />
        </div>
    </div>
</div>