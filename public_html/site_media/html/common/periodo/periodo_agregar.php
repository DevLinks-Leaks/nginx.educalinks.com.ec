<div id="frm_ingresoPeriodo" class="form-medium" >
    <div class="form-group"> 
	    <label for="descripcion_add">Descripción</label>
	    <input type="text" class="form-control" name="descripcion_add" id="descripcion_add" placeholder="Ej: Período lectivo 2016-2017" 
			value='Período lectivo 2016-2017' required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Año principalmente asociado</label>
	    <input type="text" class="form-control" name="txt_periodo_anio_add" id="txt_periodo_anio_add" placeholder="Ej: 2015" value='2016'
			required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Nota máxima</label>
	    <input type="text" class="form-control" name="txt_nota_maxima_add" id="txt_nota_maxima_add" placeholder="10" value='10'
			required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Tipo</label>
	    <select type="text" class="form-control" name="cmb_periodo_tipo_add" id="cmb_periodo_tipo_add" required="required">
			<option value='R' selected='selected'>Período regular</option>
			<option value='V'>Período vacacional</option>
			<option value='A'>Período de admisiones</option>
		</select>
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Fecha de inicio</label>
	    <input type="text" class="form-control" name="fechainicio_add" id="fechainicio_add" placeholder="Fecha de inicio del periodo" 
			 data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechafin_add">Fecha de fin</label>
	    <input type="text" class="form-control" name="fechafin_add" id="fechafin_add" placeholder="Fecha de fin del periodo" 
			 data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
	</div>
</div>