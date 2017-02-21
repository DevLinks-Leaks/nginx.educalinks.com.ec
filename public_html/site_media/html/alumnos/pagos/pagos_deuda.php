<div class="form-horizontal">
	<div class="form-group">
		<div class="col-sm-8" id="div_datos">
			{datos_deuda}
		</div>
		<div class="col-sm-4" id="div_total">
		<div class="form-group">
			<div class="col-sm-12">
				<div class="panel panel-warning">
					<div class="panel-heading"></div>
					<div class="panel-body" style='text-align:center;background-color:#f4f4f4;'>
						<span style='font-size:16px;'><b>Total ({cantidad_total}): <span style='color:#b12704'>{valor_total}</b></span></span>
						<br>
						<br>
						{frm_pago_sbmt}
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">Listado de deudas a cancelar</div>
					<div class="panel-body" style='text-align:left;background-color:#f4f4f4;'>
						{frm_pago_details}
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>