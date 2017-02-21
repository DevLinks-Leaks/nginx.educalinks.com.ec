<div class="modal-body" id="modal_deudas_body">
	<div class="alert alert-success" role="alert">
		Ha finalizado el proceso! 
		<br>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Atencion:</span>
		Se han migrado {correctos} correctamente.
		<br>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Atencion:</span>
		Han ocurrido errores en el envio en {errores} deudas.
		<br>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Atencion:</span>
		Hay {errfactura} deudas con problemas en su estructura.
	</div>
</div>
<div class="modal-footer" id="footerdeudas">
	<button type="button" class="btn btn-default" data-dismiss="modal" 
	onclick="js_aniosPeriodo_buscadeudas('resultadomigracion_deudas','{ruta_html_finan}/aniosPeriodo/controller.php');">Aceptar</button>
</div>

