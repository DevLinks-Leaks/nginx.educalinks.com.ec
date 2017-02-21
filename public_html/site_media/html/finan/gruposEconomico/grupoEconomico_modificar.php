<div id="frm_modificacionGrupoEconomico" class="form-medium" >
    <div class="form-group">
        <input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{geconomico_codigo}" required="required">
    </div>
    <div class="form-group"> 
        <label for="nombre_mod">Nombre</label>
        <input type="text" class="form-control" name="nombre_mod" id="nombre_mod" value="{geconomico_nombre}" placeholder="Nombre del grupo" required="required">
    </div>
    <div class="form-group">
        <label for="descripcion_mod">Descripci&oacute;n</label>
        <textarea class="form-control" rows="3" name="descripcion_mod" id="descripcion_mod" value="" placeholder="Breve descripcion" required="required">{geconomico_descripcion}</textarea>
    </div>
</div>