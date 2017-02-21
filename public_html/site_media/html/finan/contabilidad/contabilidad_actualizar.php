		<div id="jsondeudas" style="display: none;"  >{deudas} </div>
		<div id="jsondeudasid" style="display: none;"  >{idpago} </div>
		<div id="jsondeudasidpago" style="display: none;"  >{idpagocodigo} </div>
		<input type="hidden" id="cantidad" name="cantidad" value="{cantidaddeudas}" />
		
		<div id="resultadofinalact">
			<div class="modal-body" id="modal_actualizar_body">		
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Atencion:</span>
					¿Desea actualizar los {cantidaddeudas} documentos no autorizados y convertirlos en Factura en Contífico?
				</div>
			</div>
			<!--<div class="modal-footer" id="footerdeudas">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ahora no, por favor</button>
				<button type="button" class="btn btn-primary" onclick="js_contabilidad_actualizarcontifico('{ruta_html_finan}/contabilidad/controller.php','migrarfacturasresult',0,0,0,0)">Actualizar</button>
			</div>-->
		</div>