<div id="frm_ingresoItem" class="form-medium" >
    <div class="form-group">
    	<label for="codigoCategoria_add">Categoria</label>
    	{combo_categoria}
    </div>    
    <div class="form-group"> 
    	<label for="nombre_add">Nombre</label>
    	<input type="text" class="form-control" name="nombre_add" id="nombre_add" placeholder="Nombre del producto" required="required">
    </div>
    <div class="form-group">
    	<label for="descripcion_add">Descripci&oacute;n</label>
    	<textarea class="form-control" rows="3" name="descripcion_add" id="descripcion_add" placeholder="Breve descripcion" required="required"></textarea>
    </div>
    <div class="form-group"> 
    	<label for="cuentaContable_add">Cuenta contable</label>
    	<input type="text" class="form-control" name="cuentaContable_add" id="cuentaContable_add" placeholder="Codigo de la cuenta contable" required="required">
    </div>
    
	 <div class="form-group"> 
        <label for="descuento_add" class="checkbox-inline">
            <input type="checkbox" id="descuento_add" name="descuento_add" {item_descuento} />  
            Descuento 
        </label>
    </div>
    
    <div class="form-group"> 
    	<label for="aplicaIVA_add" class="checkbox-inline">
    		<input type="checkbox" id="aplicaIVA_add" name="aplicaIVA_add" />	
            IVA
    	</label>
    </div>
    <div class="form-group"> 
    	<label for="aplicaICE_add" class="checkbox-inline">
    		<input type="checkbox" id="aplicaICE_add" name="aplicaICE_add" />	
            ICE
    	</label>
	</div>


    <div class="form-group"> 
        <label for="precioGeneral_add" class="checkbox-inline">
            <input type="checkbox" id="precioGeneral_add" name="precioGeneral_add" />   
            Precio General
        </label>
    </div>
    
     <div class="form-group"> 
        <label for="liquidez_add" class="checkbox-inline">
            <input type="checkbox" id="liquidez_add" name="liquidez_add" />   
            Reporte Liquidez
        </label>
    </div>
      <div class="form-group"> 
        <label for="prontopago_add" class="checkbox-inline">
            <input type="checkbox" id="prontopago_add" name="prontopago_add" />   
            Aplica Prontopago
        </label>
    </div>


</div>