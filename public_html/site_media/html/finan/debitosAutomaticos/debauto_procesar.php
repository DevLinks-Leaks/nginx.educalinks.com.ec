<div id="procesar" class="form-small">
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-4'>
				<div class="alert alert-success" role="alert">
					<p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						Educalinks Informa
						<hr style="padding:3px;margin:0px;">
						El archivo fue cargado con &eacute;xito y est&aacute; listo para procesarse.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<input type="hidden" name="event" id="evento" value="subir_archivo" />
				<label for="textook" class='control-label'>Fecha del débito</label>
			</div>
			<div class='col-sm-3'>
				<input type="text" class="form-control" name="fecha_debito" id="fecha_debito" value="{txt_fecha_debito}" readonly='readonly' />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="textook" class='control-label'>Campo C&oacute;digo Deuda</label>
			</div>
			<div class='col-sm-3'>
				{combo_codigodeuda}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="textook" class='control-label'>Campo Valor</label>
			</div>
			<div class='col-sm-3'>
				{combo_valor}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="textook" class='control-label'>Campo de Texto Confirmaci&oacute;n</label>
			</div>
			<div class='col-sm-3'>
				{combo_estado}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<input type="hidden" name="event" id="evento" value="subir_archivo" />
				<label for="textook" class='control-label'>Texto Confirmaci&oacute;n</label>
			</div>
			<div class='col-sm-3'>
				<input type="text" class="form-control" name="textook" id="textook" placeholder="Texto de confirmación" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="textook" class='control-label'>Forma de pago</label>
			</div>
			<div class='col-sm-3'>
				<select class='form-control' id='cmb_formaPago' name='cmb_formaPago'>
					<option value="8" selected='selected'>- Débito bancario -</option>
					<option value="10">- Convenio de pago -</option>
					<option value="11">- Pago por ventanilla del banco -</option>
					<option value="12">- Pagado todo el año -</option>
					<option value="13">- Debito rol de pago -</option>
					<option value="1">- Efectivo -</option>
					<option value="6">- Documento interno -</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<br>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-2'>
				<button class="form-control btn btn-primary" type="button"
					id='btn_procesar_carga_xls' name='btn_procesar_carga_xls'
					onclick="procesar_Archivo('procesar','{ruta_html_finan}/debitosAutomaticos/controller.php');">Procesar</button>
			</div>
		</div>
	</div>
</div>
