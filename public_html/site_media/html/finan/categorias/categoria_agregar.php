<div id="frm_ingresoCategoria" class="form-medium" >
    <div class="form-group">
		<label for="categoriaPadre_add">Categoria Padre</label>
		{combo_categoriaPadre}
	</div>
    <div class="form-group"> 
		<label for="nombre_add">Nombre</label>
		<input type="text" class="form-control" name="nombre_add" id="nombre_add" placeholder="Nombre de la categoria" required="required">
	</div>
    <div class="form-group">
		<label for="descripcion_add">Descripci&oacute;n</label>
		<textarea class="form-control" rows="3" name="descripcion_add" id="descripcion_add" placeholder="Breve descripcion" required="required"></textarea>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ckb_tipoMatricula_add" id="ckb_tipoMatricula_add" >
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