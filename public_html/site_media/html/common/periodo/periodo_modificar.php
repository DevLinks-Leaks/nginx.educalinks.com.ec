<div id="frm_modificacionPeriodo" class="form-medium" >
    <div class="form-group">
    <input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{periodo_codigo}" required="required"></div>
    <div class="form-group"> 
	    <label for="descripcion_mod">Descripción</label>
	    <input type="text" class="form-control" name="descripcion_mod" id="descripcion_mod" value="{periodo_descripcion}" placeholder="Descripción del periodo" required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Año principalmente asociado</label>
	    <input type="text" class="form-control" name="txt_periodo_anio_mod" id="txt_periodo_anio_mod"  value="{periodo_anio}" placeholder="Ej: 2015" value='2016'
			required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Nota máxima</label>
	    <input type="text" class="form-control" name="txt_nota_maxima_mod" id="txt_nota_maxima_mod"  value="{periodo_nota_max}" placeholder="10" value='10'
			required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_add">Tipo</label>
	    <select type="text" class="form-control" name="cmb_periodo_tipo_mod" id="cmb_periodo_tipo_mod" required="required">
			<option value='R' {peri_tipo_r}>Período regular</option>
			<option value='V' {peri_tipo_v}>Período vacacional</option>
			<option value='A' {peri_tipo_a}>Período de admisiones</option>
		</select>
	</div>
	<div class="form-group"> 
	    <label for="fechainicio_mod">Fecha de inicio</label>
	    <input type="text" class="form-control" name="fechainicio_mod" id="fechainicio_mod" value="{periodo_fechainicio}" placeholder="Fecha de inicio del periodo" 
			 data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
	</div>
	<div class="form-group"> 
	    <label for="fechafin_mod">Fecha de fin</label>
	    <input type="text" class="form-control" name="fechafin_mod" id="fechafin_mod" value="{periodo_fechafin}" placeholder="Fecha de fin del periodo" 
			 data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
	</div>
</div>