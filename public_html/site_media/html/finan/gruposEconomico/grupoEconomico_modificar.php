<div class="form-horizontal" role="form">
	<div class="form-group" > 
		<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{geconomico_codigo}" required="required">
		<div class="col-md-12"> 
			<label for="nombre_mod">Nombre</label>
		</div>
		<div class="col-md-12">
			<input type="text" class="form-control" name="nombre_mod" id="nombre_mod" value="{geconomico_nombre}" placeholder="Nombre del grupo" required="required">
		</div>
		<div class="col-md-12">
			<br>
		</div>
		<div class="col-md-12">
			<label for="descripcion_mod">Descripci&oacute;n</label>
		</div>
		<div class="col-md-12">
			<textarea class="form-control" rows="3" name="descripcion_mod" id="descripcion_mod" value="" placeholder="Breve descripcion" required="required">{geconomico_descripcion}</textarea>
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
							<input type="text" class="form-control input-sm" name="txt_rango_ini_mod" id="txt_rango_ini_mod" value="{geconomico_desde}" placeholder='0.00'>
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
							<input type="text" class="form-control input-sm" name="txt_rango_fin_mod" id="txt_rango_fin_mod" value="{geconomico_hasta}" placeholder='0.00'>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>