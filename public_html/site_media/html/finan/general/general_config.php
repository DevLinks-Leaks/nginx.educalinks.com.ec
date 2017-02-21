<div id="alta_usuario" class="form-medium" >
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#valores_general" aria-controls="Reporte Deudores" role="tab" data-toggle="tab">General</a></li>
		<li {cliente_contifico} role="presentation"><a href="#interaccion_contifico" aria-controls="interaccion_contifico" role="tab" data-toggle="tab">Contífico</a></li>
		<li role="presentation"><a href="#interaccion_sistema" aria-controls="interaccion_sistema" role="tab" data-toggle="tab">Interacción entre módulos del sistema</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="valores_general">
			<div class="form-group">
				<br>
			</div>
			<div style='font-size:small'>Los valores configurados en esta pestaña afectan todo el sistema. </div>
			<br>
			<div class="form-group">
				<input type="hidden" class="form-control" name="usua_codigo" id="usua_codigo" value='{usua_codigo}'>
				<label for="desc_pronto">Usar prontopago y días de validez en descuento</label>
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_usa_pp_dv" name="check_usa_pp_dv" onclick='js_general_check_usa_pp_dv();' {usa_pp_dv}> Permitir el uso de prontopago y días de validez en el sistema.
					</label>
				</div>
			</div>
			<br>
			<div class="form-group">
				<input type="hidden" class="form-control" name="usua_codigo" id="usua_codigo" value='{usua_codigo}'>
				<label for="desc_pronto">Porcentaje de descuento en deudas que apliquen al prontopago</label>
				<div class="input-group">
					<input type="text" class="form-control" name="desc_pronto" id="desc_pronto" placeholder="Ingrese el porcentaje de descuento"  value='{prontopago}' required="required" {usa_pp_dv_disable_txtpp}><span class="input-group-addon">%</span>
				</div>
			</div>
			<div class="form-group">   
				<label for="desc_pronto">Porcentaje del I.V.A.</label>
				<div class="input-group">
					<input type="text" class="form-control" name="desc_prepago" id="desc_prepago" placeholder="Ingrese el porcentaje de descuento"  value='{prepago}' required="required"><span class="input-group-addon" >%</span>
				</div>
			</div>
			<div class="form-group">
				<label for="desc_pronto">Envío de facturas al SRI</label>
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_enviar_fac_sri_en_cobro" name="check_enviar_fac_sri_en_cobro" {enviar_fac_sri_en_cobro}> Intentar enviar factura(s) al SRI al cobrar una o más deudas en la ventana de "Cobrar deuda".
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="desc_pronto">Envío de cheques a bandeja de validación</label>
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_enviar_cheque_a_bandeja" name="check_enviar_cheque_a_bandeja" {enviar_cheque_a_bandeja}> Mandar los cheques a la bandeja de validar cheques para esperar a su aprobación.
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="desc_pronto">Método de aplicación de descuentos por cliente/alumno a las deudas.</label>
				<div class="checkbox">
					<label>
						<input type="radio" id="rdb_metodo_descuento" name="rdb_metodo_descuento" value="desc_sobre" {desc_sobre}> Aplicar descuento sobre descuento<br>
						<input type="radio" id="rdb_metodo_descuento" name="rdb_metodo_descuento" value="desc_sumado" {desc_sumado}> Sumar todos los descuento asignados
					</label>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="interaccion_contifico">
			<div class="form-group">
				<br>
			</div>
			<label>Interacción con Contífico</label>
			<br>
			<div style='font-size:small'>Las <b>API KEY</b> y <b>API KEY TOKEN</b> son claves entregadas por Contífico para poder enviar las deudas a sus sistema contable, siempre que haya activado una cuenta con ellos.</div>
			<br>
			<div class="form-group">   
				<label>APY KEY</label>
				<div class="input-group">
					<input type="text" class="form-control" name="txt_config_apikey" id="txt_config_apikey" placeholder="API KEY"  value='{apikey}' required="required"><span class="input-group-addon" ><i class='fa fa-key'></i></span>
				</div>
			</div>
			<div class="form-group">   
				<label for="desc_pronto">APY KEY TOKEN</label>
				<div class="input-group">
					<input type="text" class="form-control" name="txt_config_apikey_token" id="txt_config_apikey_token" placeholder="API KEY TOKEN"  value='{apikeytoken}' required="required"><span class="input-group-addon" ><i class='fa fa-key'></i></span>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="interaccion_sistema">
			<div class="form-group">
				<br>
			</div>
			<div class="form-group">
				<label>
					Interacción entre el módulo académico - financiero
				</label>
			</div>
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_bloqueo" name="check_bloqueo" {bloqueo}> Bloqueo al acceso de libretas a los deudores.
					</label>
				</div>
			</div>
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_genera_deuda_matr" name="check_genera_deuda_matr" {genera_deuda_matr}> Generar deuda de ítems 'matrícula' al matricular a un estudiante.
					</label>
				</div>
			</div>
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_bloqueo_matr_por_deuda" name="check_bloqueo_matr_por_deuda" {bloqueo_matr_por_deuda}> Bloquear matriculación si el estudiante tiene deudas pendientes.
					</label>
				</div>
			</div>
			<!--<div class="form-group">
				<label>Botón de pagos (módulo representantes)</label>
			</div>
			<div class="form-group" style='text-align:left;'>
				<button onclick='js_general_config_bdp();' type='button' class='btn btn-app'><i class='fa fa-edit'></i>&nbsp;Configurar</button>
			</div>-->
			<div style="display:none;">
				<div class="form-group">
					<hr>
				</div>
				<div class="form-group">
					<label>
						Interacción entre el módulo biblioteca - financiero
					</label>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input type="checkbox" id="check_biblio_genera_multa_por_mora" name="check_biblio_genera_multa_por_mora" {biblio_genera_multa_por_mora}> Generar deuda de multa por atraso de entrega de libros.
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input type="checkbox" id="check_biblio_bloquea_prestamo_por_deuda" name="check_biblio_bloquea_prestamo_por_deuda" {biblio_bloquea_prestamo_por_deuda}> Bloquear préstamo de libro si el estudiante tiene deudas pendientes.
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>