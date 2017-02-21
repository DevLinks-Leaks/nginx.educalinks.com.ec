<div id="frm_modificacionItem" class="form-medium" >
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigoPeriodo_mod" id="codigoPeriodo_mod" value="{aperiodo_codigoPeriodo}" required="required">
        <input type="hidden" class="form-control" name="codigoProducto_mod" id="codigoProducto_mod" value="{aperiodo_codigoProducto}" required="required">
    </div>
    <div class="form-group"> 
        <label for="nombreProducto_mod">Producto</label>
        <input type="text" readonly class="form-control" name="nombreProducto_mod" id="nombreProducto_mod" value="{aperiodo_nombreProducto}" placeholder="Nombre Producto" required="required">
    </div>
    <div class="form-group"> 
        <label for="fechaInicio_mod">Fecha inicio cobro</label>
        <input type="text" class="form-control" name="fechaInicio_mod" id="fechaInicio_mod" value="{aperiodo_fechaInicio}" placeholder="dd/mm/aaaa" required="required">
        <label for="fechaInicio_add">Días de Pronto pago</label>
        <input type="number" class="form-control" name="diasProntopago_add" id="diasProntopago_mod" min="0" max="30" step="1" value="{aperiodo_diasProntoPago}" placeholder="Días de pronto-pago" required="required">
    </div>
    <div class="form-group">
        <label for="fechaFin_mod">Fecha fin cobro</label>
        <input type="text" class="form-control" name="fechaFin_mod" id="fechaFin_mod" value="{aperiodo_fechaFin}" placeholder="dd/mm/aaaa" required="required">
    </div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ckb_deudasPendientes" id="ckb_deudasPendientes" >
				¿Actualizar fecha de inicio de cobro y de vencimiento de las deudas que ya han sido generadas y que est&aacute;n pendientes de cobro?
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;font-style: italic;text-align:left;vertical-align:middle;'>
					<a href='#' onmouseover='$(this).tooltip("show")' 
						title="Deje esta opci&oacute;n en blanco en caso que desee que los cambios a realizar sean v&aacute;lidos s&oacute;lo para las deudas que se generen a partir de ahora." data-placement='bottom'>(?)</a>
				</div>
			</label>
		</div>
    </div>
</div>