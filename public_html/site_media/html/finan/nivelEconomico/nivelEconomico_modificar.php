<div id="frm_ingresoCategoria" class="form-medium" >
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{codigo}" required="required">
        <label for="nombre_mod">Nombre</label>
        <input type="text" class="form-control" name="nombre_mod" id="nombre_mod" placeholder="Nombre de la cuenta" required="required" value="{nombre}">
    </div>
    <div class="form-group">
        <label for="descripcion_mod">Descripci&oacute;n</label>
        <textarea class="form-control" rows="3" name="descripcion_mod" id="descripcion_mod" placeholder="Breve descripcion" required="required">{descripcion}</textarea>
    </div>
    <div class="form-group">
    	<label for="codigoGrupoEconomico_mod">Grupo Económico Defecto</label>
    	{combo_grupoeco}
    </div>
</div>