<div id="frm_modificacionCategoria" class="form-medium" >
    <div class="form-group">
		<!--<label for="codigo">Codigo</label>-->
		<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{cate_codigo}" required="required">
	</div>
    <div class="form-group">
		<label for="categoriaPadre_mod">Categoria Padre</label>
		{combo_categoriaPadre}
	</div>
    <div class="form-group"> 
		<label for="nombre_mod">Nombre</label>
		<input type="text" class="form-control" name="nombre_mod" id="nombre_mod" value="{cate_nombre}" placeholder="Nombre de la categoria" required="required">
	</div>
    <div class="form-group">
		<label for="descripcion_mod">Descripci&oacute;n</label>
		<textarea class="form-control" rows="3" name="descripcion_mod" id="descripcion_mod" value="" placeholder="Breve descripcion" required="required">{cate_descripcion}</textarea>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ckb_tipoMatricula_mod" id="ckb_tipoMatricula_mod" {ckb_tipoMatricula_mod_checked}>
				Los productos sobre esta categor&iacute;a tendr&aacute;n deudas generadas autom&aacute;ticamente al momento de matricular un estudiante.
				<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
					<a href='#' onmouseover='$(this).tooltip("show")' 
						title="Al momento de 'matricular' a un estudiante, si tiene la opci&oacute;n de 'Generar deuda de matr&iacute;cula' activa, de todos los items que est&eacute;n sobre esta categor&iacute;a, se generará deuda." 
						data-placement='top'><i class='fa fa-info-circle'></i></a>
				</div>
			</label>
		</div>
    </div>
</div>