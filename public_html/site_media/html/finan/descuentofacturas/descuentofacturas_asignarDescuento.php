<div id="asignaResidencia_cliente" class="form col-md-8 "style="margin-bottom:30px;" >
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigo" id="codigo" placeholder"codigo" value="{clie_codigo}" required="required">
    </div>
    <div class="form-group"> 
        <label for="nombres">Cliente</label>
        <input type="text" readonly class="form-control" name="nombres" id="nombres" placeholder"Ingrese los nombres" value="{clie_nombres} {clie_apellidos}" required="required">
    </div>
    <div class="form-group"> 
        <label for="nombres" id="checkid" name="checkid">Valor de Descuento</label>
		<div class="col-md-8"> 
			<input type="text"  class="form-control" readonly name="descuento" id="descuento" placeholder"Ingrese El valor Descuento"  required="required">
		</div>
		<div class="col-md-4"> 
			<input type="checkbox" id="checkvalor" name="checkvalor" onclick="js_descuentofactura_habilitar()"> Habilitar  
		</div>
    </div>
    <div class="form-group" style="margin-top:50px;">
        <label for="porcentaje_descto">Porcentaje Sugerido</label>
        <div class="col-md-8">
            <div class="input-group ">
				<div id="resultadoPorcentaje"><input type="text" readonly class="form-control" name="porcentaje_descto" id="porcentaje_descto" 
					placeholder="0.00" required="required"></div>
					<span class="input-group-addon" id="basic-addon">%</span>
            </div>
		</div>
   		<div class="col-md-4">
			<input type="checkbox" id="checkporcentaje" name="checkporcentaje" onclick="js_descuentofactura_habilitar()"> Habilitar
        </div>
	</div>
</div>
{tabla_descuentos}