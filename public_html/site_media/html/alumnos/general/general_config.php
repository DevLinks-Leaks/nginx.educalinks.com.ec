<div id="alta_usuario" class="form-medium" >
    <div class="form-group">
		<input type="hidden" class="form-control" name="usua_codigo" id="usua_codigo" value='{usua_codigo}'>
		<label for="desc_pronto">Descuento de Prontopago</label>
		<div class="input-group">
			<input type="text" class="form-control" name="desc_pronto" id="desc_pronto" placeholder="Ingrese el porcentaje de descuento"  value='{prontopago}' required="required" onfocus="activa_mascara('desc_pronto')"><span class="input-group-addon" >%</span>
		</div>
	</div>
    <div class="form-group">   
		<label for="desc_pronto">Descuento de Prepago</label>
		<div class="input-group">
			<input type="text" class="form-control" name="desc_prepago" id="desc_prepago" placeholder="Ingrese el porcentaje de descuento"  value='{prepago}' required="required" onfocus="activa_mascara('desc_prepago')"><span class="input-group-addon" >%</span>
		</div>
	</div>
   	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" id="check_bloqueo" name="check_bloqueo" {bloqueo}> Bloqueo a deudores
			</label>
		</div>
	</div>
    <!--<div class="form-group">
		<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="js_general_settings_change(document.getElementById('desc_pronto').value,document.getElementById('desc_prepago').value,document.getElementById('check_bloqueo').checked,'{ruta_html}/general/controller.php')">Guardar</button>
    </div>-->
</div>