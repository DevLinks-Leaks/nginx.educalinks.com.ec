<div id="frm_ingresoGrupoEconomico" class="form-medium" >    
    <div class="form-group"> 
        <label for="anio">Periodo Activo</label>
        <input type="text" readonly class="form-control" name="anio" id="anio" placeholder="Año" value="{aperiodo_anio}" required="required" />
        <input type="hidden" name="periodo_add" id="periodo_add" value="{aperiodo_codigo}" required="required" />
    </div>
    <div class="form-group"> 
        <label for="codigoCategoria_add">Categoria</label>
        {combo_categoria}
    </div>
    <div class="form-group"> 
    	<label for="codigoProducto_add">Producto</label>
        <div id="resultadoProducto">
            {combo_producto}    
        </div>
    </div>
    <div class="form-group"> 
    	<label for="fechaInicio_add">Fecha inicio cobro</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</div>
			<input type="text" name="fechaInicio_add" id="fechaInicio_add"
				class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
		</div>
	</div>
	<div class="form-group"> 
        <label for="fechaInicio_add">Días de Pronto pago</label>
        <input type="text" class="form-control" name="diasProntopago_add" id="diasProntopago_add" value='0'
			placeholder="0" required="required">
    </div>
    <div class="form-group">
    	<label for="fechaFin_add">Fecha fin cobro</label>
    	<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</div>
			<input type="text" name="fechaFin_add" id="fechaFin_add"
				class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
		</div>
    </div>
</div>