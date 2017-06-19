<div class="form-group">
	<div class="col-md-1" id="div_number" name="div_number">
		1
	</div>
	<div class="col-md-4">
		{combo_descto}
	</div>
	<div class="col-md-2">
		 <div class="input-group">
			<div id="div_porcentaje_descto"><input type="text" class="form-control input-sm" name="porcentaje_descto" id="porcentaje_descto" 
				placeholder="0.00" required="required"></div>
				<span class="input-group-addon" id="basic-addon">%</span>
		</div>
	</div>
	<div class="col-md-2"> 
		<input type="text" id="txt_dia_validez" name="txt_dia_validez">Días validez
	</div>
	<div class="col-md-2"> 
		<input type="checkbox" id="ckb_prontopago" name="ckb_prontopago">Prontopago
	</div>
	<div class="col-md-2"> 
		<button type="button" id="btn_delete" name="btn_delete" onclick="btn_descuentoFactura_delete(1)"><i class="fa fa-times-circle-o"></i></button>
		<button type="button" id="btn_reverse" name="btn_reverse" onclick="btn_descuentoFactura_reverse(1)"><i class="fa fa-arrow-circle-o-left"></i></button>
	</div>
</div>
