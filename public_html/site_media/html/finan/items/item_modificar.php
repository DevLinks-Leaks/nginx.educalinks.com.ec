<div id="frm_modificacionItem" class="form-medium" >
    <div class="form-group">
        <!--<label for="codigo">Codigo</label>-->
        <input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{item_codigo}" required="required">
    </div>
    <div class="form-group">
        <label for="codigoCategoria_mod">Categoria</label>
        {combo_categoria}
    </div>    
    <div class="form-group"> 
        <label for="nombre_mod">Nombre</label>
        <input type="text" class="form-control" name="nombre_mod" id="nombre_mod" value="{item_nombre}" placeholder="Nombre del producto" required="required">
    </div>
    <div class="form-group">
        <label for="descripcion_mod">Descripci&oacute;n</label>
        <textarea class="form-control" rows="3" name="descripcion_mod" id="descripcion_mod" value="" placeholder="Breve descripcion" required="required">{item_descripcion}</textarea>
    </div>
    <div class="form-group"> 
        <label for="cuentaContable_mod">Cuenta contable</label>
        <input type="text" class="form-control" name="cuentaContable_mod" id="cuentaContable_mod" value="{item_cuentaContable}" placeholder="Codigo de la cuenta contable" required="required">
    </div>
  <div class="form-group"> 
        <label for="descuento_mod" class="checkbox-inline">
            <input type="checkbox" id="descuento_mod" name="descuento_mod" {item_descuento} />  
            Descuento 
        </label>
    </div>
    <div class="form-group"> 
        <label for="aplicaIVA_mod" class="checkbox-inline">
            <input type="checkbox" id="aplicaIVA_mod" name="aplicaIVA_mod" {item_aplicaIVA} />  
            IVA 
        </label>
    </div>
    <div class="form-group"> 
        <label for="aplicaICE_mod" class="checkbox-inline">
            <input type="checkbox" id="aplicaICE_mod" name="aplicaICE_mod" {item_aplicaICE} />   
            ICE
        </label>
    </div>

    <div class="form-group"> 
        <label for="precioGeneral_mod" class="checkbox-inline">
            <input type="checkbox" id="precioGeneral_mod" name="precioGeneral_mod" {item_precioGeneral} />   
            Precio General
        </label>
    </div>
     <div class="form-group"> 
        <label for="liquidez_mod" class="checkbox-inline">
            <input type="checkbox" id="liquidez_mod" name="liquidez_mod" {item_liquidez}/>   
            Reporte Liquidez
        </label>
    </div>
      <div class="form-group"> 
        <label for="prontopago_mod" class="checkbox-inline">
            <input type="checkbox" id="prontopago_mod" name="prontopago_mod" {item_prontopago}/>   
            Aplica Prontopago
        </label>
    </div>
</div>