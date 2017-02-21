<div id="jsondeudas" style="display: none;"  >{deudas} </div>
<input type="hidden" id="cantidad" name="cantidad" value="{cantidaddeudas}"/>
<div id="resultadofinal">
	<div class="modal-body" id="modal_deudas_body">
		<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Atencion:</span>
		¿Est&aacute; seguro que desea migrar las {cantidaddeudas} deudas?
		</div>
	</div>
	<div class="modal-footer" id="footerdeudas">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button type="button" class="btn btn-sucess" onclick="js_aniosPeriodo_migrarfacturascontificos('{ruta_html_finan}/aniosPeriodo/controller.php','resultadomigracion_deudas',0,0,0,0)">
			<span class="glyphicon glyphicon glyphicon-send"></span>&nbsp;Migrar</button>
	</div>
</div>

 