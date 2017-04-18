<div class="form-horizontal" role="form">
	<div class="form-group" >
		<div class="col-md-12"> 
			<label for="nombre_add">Nombre</label>
		</div>
		<div class="col-md-12">
			<input type="text" class="form-control" name="nombre_add" id="nombre_add" placeholder="Nombre del grupo" required="required">
		</div>
		<div class="col-md-12">
			<br>
		</div>
		<div class="col-md-12"> 
			<label for="descripcion_add">Descripci&oacute;n</label>
		</div>
		<div class="col-md-12">
			<textarea class="form-control" rows="3" name="descripcion_add" id="descripcion_add" placeholder="Breve descripcion" required="required"></textarea>
		</div>
		<div class="col-md-12">
			<br>
		</div>
		<div {usa_rango_ingreso_mensual}>
			<div class="col-md-12">
				<hr>
			</div>
			<div class="col-md-12">
				<span class="">
					<span style="text-align:left;font-weight:bold;">Aplicar este grupo económico a estudiantes con ingreso familiar:</span>
				</span>
			</div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="col-md-12"> 
						<label for="nombre_mod">De </label>
					</div>
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">$</span>
							<input type="text" class="form-control input-sm" name="txt_rango_ini_add" id="txt_rango_ini_add" placeholder='0.00' value='0.00'>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12"> 
						<label for="nombre_mod">Hasta </label>
					</div>
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">$</span>
							<input type="text" class="form-control input-sm" name="txt_rango_fin_add" id="txt_rango_fin_add" placeholder='0.00' value='0.00'>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>